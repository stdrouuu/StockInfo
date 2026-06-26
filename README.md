<h1 align="left">
  stockInfo — Buildings Material Store & Warehouse Inventory Management System
</h1>

<p align="left">
  A full-featured web-based inventory management system for building materials stores and warehouses, built with Laravel 13 and Tailwind CSS v4, equipped with Role-Based Access Control (RBAC), multi-format reporting exports, stock opname management, and an interactive analytics dashboard.
</p>

 ![loginTB.png](https://github.com/user-attachments/assets/f2c06071-9b09-4787-ae74-35feb4909c17)

<p align="left">
  <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/TailwindCSS-v4-38BDF8?style=for-the-badge&logo=tailwindcss&logoColor=white" />
  <img src="https://img.shields.io/badge/Vite-8.x-646CFF?style=for-the-badge&logo=vite&logoColor=white" />
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" />
</p>

---

## Table of Contents

- [About the Project](#about-the-project)
- [Development Team](#development-team)
- [Core Features](#core-features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Database Schema](#database-schema)
- [User Roles & RBAC](#user-roles--rbac)
- [Installation & Setup](#installation--setup)
- [Configuration](#configuration)
- [Default Credentials](#default-credentials)
- [Available Scripts](#available-scripts)

---

## About the Project

**stockInfo** is a web-based inventory management system built with Laravel 13, designed specifically for building materials stores and warehouses. It covers the full inventory workflow — stock transactions (in & out), product and category management, supplier records, stock opname (physical count), and multi-format business report exports.

This system was developed as a real client project for a building materials warehouse looking to digitalize their manual inventory process. It implements Role-Based Access Control (RBAC) to separate management (Admin) and operational (Staff) access, ensuring data integrity while keeping daily operations smooth.

---

## Development Team

| Name | Role | Responsibilities |
|---|---|---|
| **Brandon Jeremiah Sutedja** | Project Manager | End-to-end team lead, project planning, defining system scope and features, repository setup and collaboration workflow, tech stack selection, Blade templating, Tailwind styling |
| **Cristian Dion** | Backend Developer | Laravel MVC architecture, business logic, Eloquent ORM, API routes, authentication system, session management |
| **Gaddiel Abiyr Nesher Sitorus** | Export Feature & QC/QA | Excel & PDF export implementation (`maatwebsite/excel`, `barryvdh/laravel-dompdf`), quality control, functional testing, bug reporting |
| **Owen Antony** | RBAC Implementation | Role-Based Access Control middleware (`CheckRole`), route protection, role-specific view logic, permission enforcement |

---

## Core Features

### Authentication & Security
- Username/password login with session-based authentication
- No email required — uses username as the unique identifier
- Automatic redirect to login for unauthenticated users
- RBAC middleware (`CheckRole`) that returns HTTP 403 for unauthorized access attempts
- Users can update their own password at any time

### Interactive Dashboard
- Real-time KPI cards: Total Stock Units, Total SKUs, Low Stock Alerts, Stock In/Out quantities, and Inventory Asset Value
- Inventory asset value (financial data) is **hidden from Staff** and only visible to Admin
- Dynamic bar chart (Inbound vs. Outbound) filterable by **Daily**, **Weekly**, and **Monthly** views
- Low stock alert panel showing the 5 most critical products

### Product & Category Management
- Full CRUD for products with SKU, name, category, price, stock, minimum stock threshold, and product image
- Full CRUD for product categories
- Low stock indicator based on the configurable minimum stock threshold
- **Admin Only**: Create, edit, delete products and categories

### Stock Transactions (In & Out)
- Record stock inbound (`masuk`) and outbound (`keluar`) transactions
- Multi-item transactions with per-item quantity, unit price, and subtotal calculation
- Transaction status: `diproses` (processing), `selesai` (completed), `dibatalkan` (cancelled)
- Print delivery note (Surat Jalan) as a formatted document
- **Admin Only**: Delete transactions

### Internal Process Tracking
- Log internal processes linked to transactions (e.g., returns, damaged goods)
- Process status tracking: `pending`, `on-going`, `completed`
- **Admin Only**: Edit and delete process records

### Supplier Management
- Store complete supplier profiles: name, contact person, phone, email, and address
- Suppliers are referenced in inbound transactions
- **Admin Only**: Create, edit, delete suppliers

### Stock Opname (Physical Count)
- Create stock opname **periods** with start/end dates
- Staff inputs physical count per product item during active periods
- System auto-calculates **discrepancy** (selisih) between system stock and physical count
- Period statuses: `aktif` / `tidak_aktif` (operational), and `belum_lengkap` / `lengkap` / `selesai` (reporting)
- **Admin Only**: Create/edit/delete periods and **approve stock adjustment** (adjust stock to match physical count)

### Reports & Exports *(Admin Only)*
- **Product Report** — Export to Excel (`.xlsx`)
- **Transaction Report** — Export to PDF or Excel with filters for transaction type and date range
- **Stock Opname Report** — Export to PDF or Excel per selected period
- All exports are timestamped in their filename

### User Management *(Admin Only)*
- Create, edit, and delete system users
- Assign roles (`admin` or `staff`) to users
- All users can update their own passwords

---

## Tech Stack

### Backend
| Technology | Version | Purpose |
|---|---|---|
| **PHP** | ^8.3 | Server-side language |
| **Laravel** | ^13.0 | MVC web framework |
| **Laravel Tinker** | ^3.0 | REPL for debugging |
| **maatwebsite/excel** | ^3.1 | Excel export (`.xlsx`) via PhpSpreadsheet |
| **barryvdh/laravel-dompdf** | ^3.1 | PDF generation |
| **arielmejiadev/larapex-charts** | ^10.0 | Server-side chart data builder (ApexCharts) |

### Frontend
| Technology | Version | Purpose |
|---|---|---|
| **Blade** | Laravel built-in | Server-side templating engine |
| **Tailwind CSS** | ^4.0 | Utility-first CSS framework |
| **Vite** | ^8.0 | Frontend asset bundler & dev server |
| **Axios** | ^1.11.0 | HTTP client for AJAX requests |
| **ApexCharts** | CDN | Interactive JavaScript charts |

### Development Tools
| Tool | Version | Purpose |
|---|---|---|
| **Laravel Pail** | ^1.2.5 | Real-time log tailing |
| **Laravel Pint** | ^1.27 | PHP code style fixer |
| **PHPUnit** | ^12.5 | Unit & feature testing |
| **Faker** | ^1.23 | Test data generation |
| **Concurrently** | ^9.0.1 | Run multiple dev processes in parallel |

### Database
- **SQLite** (default for development) — zero-config setup
- Switchable to **MySQL/MariaDB** via `.env` configuration

---

## Project Structure

```
stockInfo/
├── app/
│   ├── Exports/                    # Excel export classes (Maatwebsite)
│   │   ├── ProdukExport.php        # Product list export
│   │   ├── TransaksiExport.php     # Transaction report export
│   │   └── StokOpnameExport.php    # Stock opname report export
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── LoginController.php
│   │   │   ├── DashboardController.php     # KPIs, charts, low stock alerts
│   │   │   ├── KategoriController.php      # Category CRUD
│   │   │   ├── LaporanController.php       # Report & export hub
│   │   │   ├── PengaturanController.php    # App settings
│   │   │   ├── ProdukController.php        # Product CRUD + image upload
│   │   │   ├── ProsesController.php        # Internal process tracking
│   │   │   ├── StokOpnameController.php    # Full stock opname workflow
│   │   │   ├── SupplierController.php      # Supplier CRUD
│   │   │   ├── TransaksiController.php     # Stock in/out transactions
│   │   │   └── UserController.php          # User & profile management
│   │   └── Middleware/
│   │       └── CheckRole.php               # RBAC middleware
│   ├── Models/
│   │   ├── User.php
│   │   ├── Produk.php
│   │   ├── Kategori.php
│   │   ├── Supplier.php
│   │   ├── Transaksi.php
│   │   ├── TransaksiItem.php
│   │   ├── Proses.php
│   │   ├── StokOpnamePeriode.php
│   │   └── StokOpnameItem.php
│   └── Providers/
├── database/
│   ├── migrations/                 # All table schema definitions
│   └── seeders/                    # Default data seeders
│       ├── UserSeeder.php          # Seeds default admin & staff accounts
│       ├── KategoriSeeder.php
│       ├── ProdukSeeder.php
│       ├── SupplierSeeder.php
│       ├── TransaksiSeeder.php
│       ├── StokOpnameSeeder.php
│       └── ProsesSeeder.php
├── resources/
│   └── views/
│       ├── auth/                   # Login page
│       ├── dashboard/              # Main dashboard view
│       ├── produk/                 # Product & category views
│       ├── transaksi/              # Transaction views + surat jalan
│       ├── supplier/               # Supplier views
│       ├── proses/                 # Internal process views
│       ├── stok/                   # Stock opname views (opname1/2/3)
│       ├── laporan/                # Report views + PDF templates
│       ├── user/                   # User management views
│       ├── layouts/                # Base layout templates
│       └── partials/               # Reusable partial components
├── routes/
│   └── web.php                     # All application routes with RBAC annotations
├── public/
├── .env.example                    # Environment variable template
├── composer.json                   # PHP dependencies
├── package.json                    # Node.js dependencies
└── vite.config.js                  # Vite build configuration
```

---

## Database Schema

The system uses **11 database tables**:

```
users
├── id              (PK)
├── name            string
├── username        string (unique)
├── password        string (hashed)
├── role            enum: admin | staff
├── remember_token
└── timestamps

kategoris
├── id              (PK)
├── nama            string(100) (unique)
└── timestamps

produks
├── id              (PK)
├── sku             string(50) (unique)
├── nama            string(255)
├── kategori_id     (FK → kategoris)
├── stok            integer (default: 0)
├── harga           decimal(15,2) (default: 0)
├── stok_minimum    integer (default: 0)
├── gambar          string (nullable)
└── timestamps

suppliers
├── id              (PK)
├── nama            string(255)
├── kontak_person   string(100)
├── telepon         string(20)
├── email           string(255) (nullable)
├── alamat          text
└── timestamps

transaksis
├── id              (PK)
├── kode            string(50) (unique)
├── tipe            enum: masuk | keluar
├── supplier_id     (FK → suppliers, nullable)
├── tujuan          string(255) (nullable)
├── alamat          text (nullable)
├── tanggal         date
├── keterangan      text (nullable)
├── status          enum: diproses | selesai | dibatalkan
├── total_nilai     decimal(15,2)
├── user_id         (FK → users)
└── timestamps

transaksi_items
├── id              (PK)
├── transaksi_id    (FK → transaksis)
├── produk_id       (FK → produks)
├── qty             integer
├── harga_satuan    decimal(15,2)
├── subtotal        decimal(15,2)
└── timestamps

proses
├── id              (PK)
├── transaksi_id    (FK → transaksis, nullable)
├── produk_id       (FK → produks)
├── no_surat_jalan  string(50)
├── status          enum: on-going | pending | completed
├── kategori_proses string(100)
├── keterangan      text (nullable)
└── timestamps

stok_opname_periodes
├── id                  (PK)
├── tanggal_mulai       date
├── tanggal_selesai     date
├── keterangan          text (nullable)
├── status_kerja        enum: aktif | tidak_aktif
├── status_pelaporan    enum: belum_lengkap | lengkap | selesai
├── is_adjusted         boolean (default: false)
├── user_id             (FK → users)
└── timestamps

stok_opname_items
├── id              (PK)
├── periode_id      (FK → stok_opname_periodes)
├── produk_id       (FK → produks)
├── stok_sistem     integer (default: 0)
├── stok_fisik      integer (default: 0)
├── selisih         integer (default: 0)
├── catatan         text (nullable)
└── timestamps

sessions                (Laravel built-in session table)
password_reset_tokens   (Laravel built-in)
```

### Entity Relationship Overview

```
users ──< transaksis >──< transaksi_items >── produks ──> kategoris
users ──< stok_opname_periodes >──< stok_opname_items >── produks
transaksis ──< proses >── produks
transaksis ──> suppliers
```

---

## User Roles & RBAC

The system implements two user roles enforced by the `CheckRole` middleware and route-level protection.

### Role Comparison Matrix

| Feature / Action | Admin | Staff |
|---|:---:|:---:|
| **Dashboard** | Yes - Full (incl. asset value) | Yes - Limited (asset value hidden) |
| **Products** — View | Yes | Yes |
| **Products** — Create / Edit / Delete | Yes | No |
| **Categories** — View | Yes | Yes |
| **Categories** — Create / Edit / Delete | Yes | No |
| **Transactions** — View / Create | Yes | Yes |
| **Transactions** — Print Delivery Note | Yes | Yes |
| **Transactions** — Delete | Yes | No |
| **Suppliers** — View | Yes | Yes |
| **Suppliers** — Create / Edit / Delete | Yes | No |
| **Internal Processes** — View / Create | Yes | Yes |
| **Internal Processes** — Edit / Delete | Yes | No |
| **Stock Opname** — View Periods & Input | Yes | Yes |
| **Stock Opname** — Create / Edit / Delete Period | Yes | No |
| **Stock Opname** — Approve Stock Adjustment | Yes | No |
| **Reports & Exports** (PDF/Excel) | Yes | No |
| **App Settings** | Yes | No |
| **User Management** | Yes | No |
| **Update Own Password** | Yes | Yes |

### How RBAC Works

The `CheckRole` middleware (`app/Http/Middleware/CheckRole.php`) acts as a request gatekeeper:

```php
// Example route protection
Route::middleware(['role:admin'])->group(function () {
    Route::delete('/{produk}', [ProdukController::class, 'destroy']);
    // ...other admin-only routes
});
```

If a Staff user attempts to access an Admin-only route, the middleware immediately aborts with **HTTP 403 Forbidden**.

---

## Installation & Setup

### Prerequisites

Ensure the following are installed on your machine:

| Requirement | Minimum Version |
|---|---|
| PHP | 8.3+ |
| Composer | 2.x |
| Node.js | 18+ |
| npm | 9+ |
| SQLite extension | (for default setup) |

> **Using Laragon?** Laragon bundles PHP, MySQL, and SQLite out of the box — no additional setup required.

---

### Quick Setup (Recommended)

A `setup` Composer script is provided that automates all installation steps in one command:

```bash
composer run setup
```

This single command will:
1. Install all PHP dependencies (`composer install`)
2. Copy `.env.example` to `.env` (if not already present)
3. Generate the application encryption key (`php artisan key:generate`)
4. Run all database migrations (`php artisan migrate --force`)
5. Install Node.js dependencies (`npm install`)
6. Build frontend assets (`npm run build`)

---

### Manual Step-by-Step Setup

If you prefer to run each step manually:

**1. Clone the repository**
```bash
git clone <repository-url> stockInfo
cd stockInfo
```

**2. Install PHP dependencies**
```bash
composer install
```

**3. Create environment file**
```bash
cp .env.example .env
```

**4. Generate application key**
```bash
php artisan key:generate
```

**5. Configure your database** *(see [Configuration](#configuration))*

**6. Run database migrations**
```bash
php artisan migrate
```

**7. Seed default data** *(optional but recommended)*
```bash
php artisan db:seed
```

**8. Install Node.js dependencies**
```bash
npm install
```

**9. Build frontend assets**
```bash
npm run build
```

**10. Start the development server**
```bash
php artisan serve
```

Visit: **http://localhost:8000**

---

## Configuration

All configuration is managed through the `.env` file. Copy `.env.example` and adjust as needed.

### Application Settings

```env
APP_NAME=stockInfo
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
```

### Database Configuration

**Option A — SQLite (Default, zero-config)**
```env
DB_CONNECTION=sqlite
# The SQLite file will be auto-created at database/database.sqlite
```

**Option B — MySQL / MariaDB**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stockinfo
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Session Configuration

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

---

## Default Credentials

After running `php artisan db:seed`, the following accounts are available:

| Role | Username | Password |
|---|---|---|
| **Admin** | `admin_utama` | `admin123` |
| **Staff** | `staff_toko` | `staff123` |

> **Security Warning:** Change these credentials immediately in any production environment.

---

## Available Scripts

### Composer Scripts

| Command | Description |
|---|---|
| `composer run setup` | Full one-command project setup |
| `composer run dev` | Start all dev services concurrently (Laravel server, queue, log tailing, Vite) |
| `composer run test` | Clear config cache and run PHPUnit test suite |

### NPM Scripts

| Command | Description |
|---|---|
| `npm run dev` | Start Vite dev server with HMR |
| `npm run build` | Build optimized production assets |

### Artisan Commands

| Command | Description |
|---|---|
| `php artisan migrate` | Run pending migrations |
| `php artisan migrate:fresh --seed` | Drop all tables, re-run migrations, and seed data |
| `php artisan db:seed` | Run all database seeders |
| `php artisan serve` | Start the built-in PHP development server |
| `php artisan tinker` | Open the interactive REPL for debugging |

---

## Running Tests

```bash
composer run test
# or
php artisan test
```

---

## License

This project is licensed under the **MIT License**.

---

<p align="center">Built by the stockInfo Team</p>
<p align="center">Brandon Jeremiah Sutedja &bull; Cristian Dion &bull; Gaddiel &bull; Owen</p>
