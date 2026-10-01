# InternX

**Catat. Hadir. Berkembang.**

InternX adalah sistem monitoring kegiatan magang mahasiswa: logbook harian, absensi masuk/pulang, pengumpulan laporan akhir, serta review oleh mentor — dibangun dengan Laravel 13, Blade, dan Tailwind CSS v4.

---

## 1. Requirement

Pastikan sudah terpasang di komputer Anda (Windows/macOS/Linux):

| Tools      | Versi minimum |
|------------|---------------|
| PHP        | 8.3+          |
| Composer   | 2.x           |
| MySQL      | 8.0+ (atau MariaDB 10.6+) |
| Node.js    | 18+           |
| npm        | 9+            |

Ekstensi PHP yang wajib aktif: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`.

---

## 2. Instalasi

### 2.1 Clone / salin project

```powershell
cd D:\Project
# jika dari git
git clone <repo-url> internex
cd internex
```

Jika Anda menerima project ini dalam bentuk ZIP, cukup ekstrak `internex-laravel.zip` lalu masuk ke foldernya.

### 2.2 Install dependency PHP & JS

```powershell
composer install
npm install
```

### 2.3 Copy file environment

**PowerShell:**
```powershell
copy .env.example .env
```

**CMD:**
```cmd
copy .env.example .env
```

### 2.4 Generate APP_KEY

```powershell
php artisan key:generate
```

### 2.5 Buat database MySQL

Buka MySQL client (mysql, phpMyAdmin, HeidiSQL, TablePlus, dsb) lalu jalankan:

```sql
CREATE DATABASE magangtrack CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau lewat command line:

```powershell
mysql -u root -e "CREATE DATABASE magangtrack CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 2.6 Konfigurasi `.env`

File `.env` sudah otomatis berisi konfigurasi MySQL berikut (sesuaikan `DB_PASSWORD` jika root MySQL Anda memakai password):

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=magangtrack
DB_USERNAME=root
DB_PASSWORD=
```

### 2.7 Migration & Seeder

```powershell
php artisan migrate --seed
```

### 2.8 Buat symbolic link storage (untuk lampiran logbook & file laporan)

```powershell
php artisan storage:link
```

> Jika di Windows muncul error izin/symlink, jalankan PowerShell/CMD sebagai **Administrator**.

### 2.9 Jalankan aplikasi

Buka dua terminal terpisah:

**Terminal 1 — build asset (Tailwind + Vite):**
```powershell
npm run dev
```

**Terminal 2 — jalankan server Laravel:**
```powershell
php artisan serve
```

Buka browser ke **http://127.0.0.1:8000**

### 2.10 (Opsional) Aktifkan foto brand aplikasi

InternX menyertakan sistem visual foto (`PhotoHero`, `PhotoBanner`, `PhotoCard`, `PhotoCarousel`) yang otomatis aktif begitu file foto tersedia — tidak perlu ubah kode apa pun.

1. Siapkan foto Anda: `foto1.png` s.d. `foto8.png` (format PNG/JPG, disarankan landscape, resolusi minimal 1200px pada sisi terpanjang).
2. Salin seluruh file tersebut ke folder `public/foto/` pada project ini.
3. Refresh halaman — carousel login, hero dashboard, banner Aktivitas Harian/Peserta Magang/Periode, dsb akan otomatis menampilkan foto yang sesuai.

Pemetaan context → nama file ada di `app/Support/Photos.php`, silakan sesuaikan jika Anda ingin foto tertentu tampil di halaman tertentu. Jika sebuah file belum tersedia, halaman terkait akan menampilkan fallback gradient + icon (bukan gambar rusak), jadi aplikasi tetap terlihat rapi walau foto belum lengkap.



> Password di bawah ini **hanya untuk development/testing**, bukan untuk production.

| Role      | Email                  | Password   |
|-----------|-------------------------|------------|
| Mentor    | mentor@internex.test    | password   |
| Mahasiswa | mahasiswa@internex.test | password   |

Seeder juga membuat 1 mentor tambahan dan 4 mahasiswa tambahan dengan data acak (email dapat dilihat melalui tabel `users` setelah seeding) untuk keperluan uji coba fitur monitoring mentor terhadap banyak mahasiswa binaan.

---

## 4. Struktur Fitur

### Mahasiswa
- **Dashboard** — progress magang, statistik logbook/kehadiran, laporan akhir, aksi cepat
- **Aktivitas Harian** — CRUD aktivitas magang (create/edit dibatasi selama belum *approved*), upload lampiran, filter status/tanggal
- **Absensi** — absen masuk & pulang (mencegah double check-in/out), status hadir/terlambat otomatis, riwayat & rekap
- **Laporan Akhir** — draft → submit → reviewed/revision/approved, upload file, lihat feedback mentor

### Mentor
- **Dashboard** — ringkasan mahasiswa binaan, logbook & laporan menunggu review
- **Peserta Magang** — daftar & detail progress setiap mahasiswa
- **Review Logbook** — approve/reject dengan feedback wajib saat reject
- **Monitoring Absensi** — rekap kehadiran seluruh mahasiswa binaan
- **Periode Magang** — CRUD periode (active/completed)
- **Review Laporan Akhir** — review, approve, atau minta revisi dengan feedback

### Keamanan & Otorisasi
- Autentikasi native Laravel (session, `Auth` facade, tanpa Breeze/Jetstream/Fortify)
- Middleware `role` membatasi area mahasiswa/mentor
- **Laravel Policy** untuk setiap resource (Internship, Logbook, Attendance, FinalReport, InternshipPeriod) — mentor hanya bisa mereview mahasiswa binaannya, mahasiswa hanya bisa mengelola datanya sendiri
- File attachment disimpan lewat Laravel Storage (disk `public`), bukan disimpan manual

---

## 5. Menjalankan Test

```powershell
php artisan test
```

atau langsung dengan Pest:

```powershell
./vendor/bin/pest
```

> **Catatan:** test menggunakan koneksi database yang sama dengan `.env` (`RefreshDatabase`). Disarankan membuat database terpisah `magangtrack_testing` agar data development tidak ikut ter-reset, lalu sesuaikan `DB_DATABASE` di `phpunit.xml` atau `.env.testing`.

```sql
CREATE DATABASE magangtrack_testing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

## 6. Code Style

Project ini menggunakan **Laravel Pint**:

```powershell
./vendor/bin/pint
```

---

## 7. Troubleshooting Umum

| Masalah | Solusi |
|---|---|
| `SQLSTATE[HY000] [1049] Unknown database 'magangtrack'` | Pastikan sudah menjalankan `CREATE DATABASE magangtrack;` di MySQL |
| Halaman blank / error 500 tanpa detail | Set `APP_DEBUG=true` di `.env`, cek `storage/logs/laravel.log` |
| CSS/JS tidak muncul (tampilan polos) | Jalankan `npm run dev` (development) atau `npm run build` (production), pastikan `npm install` sudah dijalankan |
| `Class "PDO" not found` / `could not find driver` | Aktifkan ekstensi `pdo_mysql` di `php.ini`, lalu restart terminal/server |
| `storage:link` gagal di Windows | Jalankan terminal sebagai Administrator, atau salin manual isi `storage/app/public` ke `public/storage` |
| Error `419 Page Expired` saat submit form | Sesi/cookie kadaluarsa — refresh halaman dan login ulang; pastikan `SESSION_DRIVER=database` dan tabel `sessions` sudah termigrasi |
| Upload file gagal (ukuran) | Sesuaikan `upload_max_filesize` dan `post_max_size` di `php.ini` (minimal 10M) |
| Ingin reset seluruh data | `php artisan migrate:fresh --seed` |

---

## 8. Struktur Folder Utama

```
app/
  Http/
    Controllers/        Controller mahasiswa & mentor (namespace Mentor\)
    Requests/            Form Request validasi
    Middleware/          EnsureUserHasRole
  Models/                User, Internship, InternshipPeriod, Logbook,
                         LogbookFeedback, Attendance, FinalReport,
                         FinalReportFeedback
  Policies/              Otorisasi per resource
database/
  migrations/            Skema tabel (users, internships, logbooks, dst)
  factories/             Factory untuk data uji/seeder
  seeders/               DatabaseSeeder (data demo)
resources/
  views/
    layouts/             Layout utama (sidebar + mobile drawer)
    components/          Blade components (button, input, badge, modal, dst)
    auth/                Halaman login
    dashboard/            Dashboard mahasiswa & mentor
    logbooks/             CRUD logbook
    attendances/          Absensi
    final-report/         Laporan akhir mahasiswa
    mentor/                Semua halaman mentor
  css/app.css             Tailwind v4 + design tokens InternX
  js/app.js               Interaksi UI (sidebar, modal, flash message, dst)
routes/web.php            Seluruh named route
tests/Feature/            Pest test (auth, dashboard, logbook, attendance, laporan)
```

---

## 9. Status Implementasi

Seluruh source code (migration, model, controller, request, policy, route, Blade view, factory, seeder, test) sudah dibuat lengkap dan siap dijalankan sesuai langkah instalasi di atas.

Lingkungan pembuatan project ini **tidak menyediakan PHP, Composer, maupun MySQL** (hanya Node.js), sehingga `composer install`, `php artisan migrate`, dan `php artisan test` **belum dapat dijalankan/diverifikasi secara otomatis** di lingkungan tersebut. Semua file ditulis mengikuti konvensi Laravel 13 standar secara manual dan konsisten (namespace, nama route, relasi Eloquent, dsb). Sangat disarankan menjalankan `composer install && php artisan test` di komputer Anda sendiri sesaat setelah instalasi untuk memverifikasi semuanya berjalan mulus — jika ditemukan error kecil (mis. versi paket), silakan sesuaikan `composer.json` dengan versi Laravel 13 terbaru yang tersedia di Packagist saat Anda menginstal.

Frontend telah disempurnakan menjadi tampilan SaaS/corporate: sistem foto brand (`PhotoHero`/`PhotoBanner`/`PhotoCard`/`PhotoCarousel`), dan seluruh emoji telah dihapus lalu digantikan icon Lucide secara konsisten di seluruh halaman.

---

## 10. Design System & Icon

- Warna: background `#F8FAFC`, dark navy `#0F172A`, primary indigo `#4F46E5`, emerald `#10B981`, border `#E2E8F0`.
- Seluruh icon menggunakan **Lucide** (satu library saja, tanpa emoji/Unicode/Font Awesome campuran), dimuat via CDN dan di-render dengan `data-lucide="..."` + `lucide.createIcons()`.
- Standar ukuran icon: `w-4 h-4` tombol, `w-5 h-5` navigasi, `w-6 h-6` statistic card, `w-8 h-8` empty state/hero.
- Foto brand (lihat bagian 2.10) dipetakan lewat `App\Support\Photos` dan dirender lewat komponen `PhotoHero`, `PhotoBanner`, `PhotoCard`, `PhotoCarousel` — satu visual kuat per section utama, bukan galeri foto. Avatar profil mahasiswa/mentor memakai inisial nama (`avatar-initials`), bukan foto dari `public/foto/`.
