<?php

namespace Tests\Feature;

use App\Models\StokOpnamePeriode;
use App\Models\StokOpnameItem;
use App\Models\User;
use App\Models\Produk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StokOpnameStatusTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    private function createProduk($attributes = [])
    {
        $kategori = \App\Models\Kategori::firstOrCreate(['nama' => 'Bahan Bangunan']);
        return Produk::create(array_merge([
            'sku' => 'PROD-' . uniqid(),
            'nama' => 'Produk Test',
            'kategori_id' => $kategori->id,
            'stok' => 10,
            'harga' => 1000,
            'stok_minimum' => 5,
        ], $attributes));
    }

    /** @test */
    public function test_it_returns_zero_for_total_sesuai_and_total_selisih_when_unreported()
    {
        $periode = StokOpnamePeriode::create([
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(30),
            'keterangan' => 'Periode 1',
            'status_kerja' => 'aktif',
            'status_pelaporan' => 'belum_lengkap',
            'user_id' => $this->user->id,
        ]);

        $produk = $this->createProduk(['stok' => 10]);

        StokOpnameItem::create([
            'periode_id' => $periode->id,
            'produk_id' => $produk->id,
            'stok_sistem' => 10,
            'stok_fisik' => 10,
            'selisih' => 0,
            'catatan' => 'belum dilaporkan',
        ]);

        $this->assertEquals(0, $periode->fresh()->total_sesuai);
        $this->assertEquals(0, $periode->fresh()->total_selisih);
    }

    /** @test */
    public function test_it_cannot_adjust_stock_if_reporting_is_incomplete()
    {
        $periode = StokOpnamePeriode::create([
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(30),
            'keterangan' => 'Periode 1',
            'status_kerja' => 'aktif',
            'status_pelaporan' => 'belum_lengkap',
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('stok.adjustStock', $periode->id));

        $response->assertSessionHas('error', 'Stok tidak dapat disinkronkan karena pelaporan belum lengkap.');
        $this->assertFalse($periode->fresh()->is_adjusted);
    }

    /** @test */
    public function test_it_can_adjust_stock_even_if_status_kerja_is_tidak_aktif()
    {
        $periode = StokOpnamePeriode::create([
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(30),
            'keterangan' => 'Periode 1',
            'status_kerja' => 'tidak_aktif',
            'status_pelaporan' => 'selesai',
            'user_id' => $this->user->id,
        ]);

        $produk = $this->createProduk(['stok' => 10, 'harga' => 5000]);

        $item = StokOpnameItem::create([
            'periode_id' => $periode->id,
            'produk_id' => $produk->id,
            'stok_sistem' => 10,
            'stok_fisik' => 8,
            'selisih' => -2,
            'catatan' => 'selisih',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('stok.adjustStock', $periode->id));

        $response->assertRedirect(route('stok.opname1'));
        $response->assertSessionHas('success');
        $this->assertTrue($periode->fresh()->is_adjusted);
        $this->assertEquals(8, $produk->fresh()->stok);
    }

    /** @test */
    public function test_editing_report_moves_active_status_to_that_period()
    {
        $periodeActive = StokOpnamePeriode::create([
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(30),
            'keterangan' => 'Periode Aktif',
            'status_kerja' => 'aktif',
            'status_pelaporan' => 'belum_lengkap',
            'user_id' => $this->user->id,
        ]);

        $periodeInactive = StokOpnamePeriode::create([
            'tanggal_mulai' => now()->subDays(40),
            'tanggal_selesai' => now()->subDays(10),
            'keterangan' => 'Periode Tidak Aktif',
            'status_kerja' => 'tidak_aktif',
            'status_pelaporan' => 'belum_lengkap',
            'user_id' => $this->user->id,
        ]);

        $produk = $this->createProduk(['stok' => 10]);

        $item = StokOpnameItem::create([
            'periode_id' => $periodeInactive->id,
            'produk_id' => $produk->id,
            'stok_sistem' => 10,
            'stok_fisik' => 10,
            'selisih' => 0,
            'catatan' => 'belum dilaporkan',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('stok.reportItem', $item->id), [
                'stok_fisik' => 9,
                'catatan' => 'selisih dikit',
            ]);

        $response->assertRedirect();

        // Assert that the previously inactive period is now active
        $this->assertEquals('aktif', $periodeInactive->fresh()->status_kerja);

        // Assert that the previously active period is now inactive
        $this->assertEquals('tidak_aktif', $periodeActive->fresh()->status_kerja);
    }
}
