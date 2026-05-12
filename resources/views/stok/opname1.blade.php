@extends('layouts.app')

@section('title', 'StockInfo - Stok Opname')

@section('content')
<div class="space-y-8">
    <div class="bg-[#d35400] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-orange-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-archive text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Stok Opname</h2>
                <div class="flex items-center gap-2 text-orange-100 text-[10px] mt-1 font-bold">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase">STOK OPNAME</span>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="text-white uppercase font-black tracking-widest">DATA</span>
                </div>
            </div>
        </div>
        <i class="fas fa-box absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6">
        <div class="mb-6">
            <button @click="showModal = true; modalType = 'add-period'" class="bg-[#2d46b9] hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 shadow-lg shadow-blue-200 transition-all">
                <i class="fas fa-plus text-xs"></i>
                Buat Periode
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-[#2d46b9] text-white text-[10px] font-black uppercase tracking-widest">
                        <th class="px-6 py-4 rounded-tl-xl">No</th>
                        <th class="px-6 py-4">Periode</th>
                        <th class="px-6 py-4 text-center">Jumlah Barang</th>
                        <th class="px-6 py-4 text-center">Jumlah Sesuai Barang</th>
                        <th class="px-6 py-4 text-center">Jumlah Selisih Barang</th>
                        <th class="px-6 py-4 text-center">Status Kerja</th>
                        <th class="px-6 py-4 text-center">Status Pelaporan</th>
                        <th class="px-6 py-4 rounded-tr-xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @php
                        $data = [
                            ['no' => 1, 'period' => "1 Okt 2025 s/d 30 Okt 2025", 'qty' => 150, 'match' => 150, 'diff' => 0, 'work' => "Tidak Aktif", 'status' => "LENGKAP", 'class' => "bg-emerald-50 text-emerald-600"],
                            ['no' => 2, 'period' => "01 Sep 2025 s/d 29 Sep 2025", 'qty' => 85, 'match' => 87, 'diff' => 2, 'work' => "Tidak Aktif", 'status' => "LENGKAP", 'class' => "bg-emerald-50 text-emerald-600"],
                            ['no' => 3, 'period' => "01 Sep 2025 s/d 29 Sep 2025", 'qty' => 20, 'match' => 20, 'diff' => 0, 'work' => "Aktif", 'status' => "BELUM LENGKAP", 'class' => "bg-rose-50 text-rose-600"],
                            ['no' => 4, 'period' => "01 Sep 2025 s/d 29 Sep 2025", 'qty' => 300, 'match' => 300, 'diff' => 0, 'work' => "Tidak Aktif", 'status' => "SELESAI", 'class' => "bg-slate-50 text-slate-400"]
                        ];
                    @endphp
                    @foreach($data as $row)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 text-sm text-slate-400 font-medium">{{ $row['no'] }}</td>
                        <td class="px-6 py-5 text-sm font-extrabold text-[#2d46b9] leading-relaxed">{{ $row['period'] }}</td>
                        <td class="px-6 py-5 text-sm font-medium text-slate-500 text-center">{{ $row['qty'] }}</td>
                        <td class="px-6 py-5 text-sm font-black text-slate-800 text-center">{{ $row['match'] }}</td>
                        <td class="px-6 py-5 text-sm font-medium text-slate-500 text-center">{{ $row['diff'] }}</td>
                        <td class="px-6 py-5 text-sm font-medium text-slate-400 text-center">{{ $row['work'] }}</td>
                        <td class="px-6 py-5 text-center">
                            <span class="px-3 py-1 {{ $row['class'] }} text-[10px] font-black uppercase rounded-full">{{ $row['status'] }}</span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <button class="text-slate-300 hover:text-slate-600"><i class="fas fa-ellipsis-v"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex items-center justify-between">
            <p class="text-xs text-slate-400 font-medium tracking-tight">Menampilkan 1-4 dari 1,290 transaksi</p>
            <div class="flex items-center gap-2">
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#2d46b9] text-white text-xs font-bold shadow-md">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-500 text-xs font-bold transition-all">2</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal-content')
<div x-show="modalType === 'add-period'">
    <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Buat Periode Opname</h2>
    <form class="space-y-5">
        <div class="grid grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Tanggal Mulai</label>
                <input type="date" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Tanggal Selesai</label>
                <input type="date" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
        </div>
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Keterangan Periode</label>
            <textarea placeholder="Contoh: Stok Opname Gudang A - Akhir Tahun" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all resize-none" rows="2"></textarea>
        </div>
        <div class="flex justify-end gap-3 pt-4">
            <button type="button" @click="showModal = false" class="px-8 py-2.5 bg-slate-100 text-slate-800 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">Batal</button>
            <button type="submit" class="px-8 py-2.5 bg-[#2d46b9] text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-200 hover:bg-blue-800 transition-all">Buat</button>
        </div>
    </form>
</div>
@endsection
