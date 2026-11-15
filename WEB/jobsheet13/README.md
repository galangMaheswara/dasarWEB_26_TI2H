# SIMPUS-Mini — Jobsheet 13 (Deployment & Dokumentasi)

**Sub-CPMK:** Mendeploy dan mendokumentasikan aplikasi.

Snapshot akhir proyek SIMPUS-Mini setelah Jobsheet 1-12, siap didemokan pada UAS.

## Deskripsi Aplikasi
SIMPUS-Mini adalah aplikasi web sederhana untuk mengelola perpustakaan: data buku, anggota, serta
transaksi peminjaman/pengembalian, dengan autentikasi petugas.

**Stack:** HTML5, CSS3 (Bootstrap 5), JavaScript, PHP native, PostgreSQL (PDO_PGSQL).

## ERD Final
```text
buku            anggota           users              peminjaman
------          --------          ------             -----------
id (PK)         id (PK)           id (PK)            id (PK)
judul           nama              nama               buku_id (FK -> buku.id)
pengarang       no_anggota (UQ)   username (UQ)      anggota_id (FK -> anggota.id)
tahun           alamat            password (hash)    tanggal_pinjam
isbn            no_hp             role               tanggal_kembali
stok                                                 status
kategori
```
Relasi: satu buku bisa dipinjam banyak kali dan satu anggota bisa meminjam banyak buku. Tabel
`peminjaman` menjadi penghubung keduanya (many-to-many).

## Fitur per Role
| Fitur | Tamu (tanpa login) | Petugas (login) |
|---|---|---|
| Lihat Beranda & statistik | Ya | Ya |
| Lihat Daftar Buku | Ya | Ya |
| Tambah/Edit/Hapus Buku | Tidak | Ya |
| Kelola Anggota (CRUD) | Tidak | Ya |
| Peminjaman Baru | Tidak | Ya |
| Pengembalian | Tidak | Ya |
| Riwayat Peminjaman | Tidak | Ya |

## Instalasi & Menjalankan
1. Clone/salin folder ini ke server (lokal atau hosting yang mendukung PHP + PostgreSQL).
2. Buat database dan impor skema. Urutannya penting karena `peminjaman` mereferensikan
   `buku`/`anggota`:
   ```bash
   createdb simpus_mini
   psql -d simpus_mini -f sql/01_buku_anggota.sql
   psql -d simpus_mini -f sql/02_users.sql
   psql -d simpus_mini -f sql/03_peminjaman.sql
   ```
3. Konfigurasi koneksi. Kredensial database dibaca oleh `includes/config.php` dari environment
   variable (`DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`) dengan nilai cadangan untuk
   pengembangan lokal. Ada dua cara mengisinya:
   - Langsung saat menjalankan server:
     ```bash
     DB_HOST=127.0.0.1 DB_NAME=simpus_mini DB_USER=produser DB_PASS=rahasia php -S localhost:8000
     ```
     Di Windows PowerShell: `$env:DB_PASS="rahasia"; php -S localhost:8000`
   - Atau salin `.env.example` menjadi `.env` lalu isi nilainya. File `.env` sudah masuk
     `.gitignore`, jadi tidak ikut di-commit.

   **Jangan** mengganti nilai cadangan di `includes/config.php` dengan kredensial asli lalu
    meng-commit-nya ke repository publik.
4. Jalankan. Path CSS/JS/link/redirect dihitung relatif otomatis di `includes/header.php` &
   `includes/auth.php`, jadi tidak harus dari root server.
   - Opsi 1 — PHP built-in server: `php -S localhost:8000`
   - Opsi 2 — Laragon (Apache): virtual host langsung ke folder `Jobsheet-13/` (mis.
     `http://jobsheet13.test/`) atau bersarang di bawah domain proyek.
5. Buka `http://localhost:8000/index.php`, lalu registrasi akun petugas pertama lewat
   `auth/register.php`.

## Struktur Folder
```text
Jobsheet-13/
├── index.php            Beranda (statistik real-time dari DB, transaksi terbaru)
├── includes/            config.php, koneksi.php, header.php, footer.php, auth.php, csrf.php, helpers.php
├── assets/css, assets/js
├── buku/                CRUD Buku
├── anggota/             CRUD Anggota
├── auth/                Register, Login, Logout
├── peminjaman/          Peminjaman, Pengembalian, Riwayat
├── sql/                 skema database (01-03, jalankan berurutan)
├── tests/               uji_keamanan.php (Jobsheet 11), uji_peminjaman.php (Jobsheet 12)
├── docs/                wireframe.md, security-checklist.md, manual-pengguna.md (+ img/)
├── .env.example         daftar environment variable yang dibutuhkan
└── .gitignore           mengecualikan .env
```

## Perubahan dari Jobsheet 12
- `includes/config.php` (baru) — mengembalikan array konfigurasi dari `getenv()` dengan operator
  `?:` sebagai cadangan, dan memuat file `.env` kalau ada.
- `includes/koneksi.php` — membaca `$config = require __DIR__ . '/config.php';`, tidak ada lagi
  kredensial yang ditulis langsung.
- `includes/footer.php`, `includes/header.php` — label Jobsheet 13.
- `docs/manual-pengguna.md` (baru) — panduan untuk petugas, lengkap dengan screenshot asli di
  `docs/img/`.
- `.env.example`, `.gitignore` (latihan 4.5 no. 1).
- `buku/edit.php` — kategori yang diisi bebas di form Tambah tidak lagi berubah saat buku diedit.

## Dokumen Pendukung
- `docs/wireframe.md` — rancangan UX (Jobsheet 4)
- `docs/security-checklist.md` — audit keamanan (Jobsheet 11)
- `docs/manual-pengguna.md` — panduan penggunaan aplikasi

## Catatan
- Seluruh berkas PHP lolos `php -l` (tanpa error sintaks).
- Sudah diuji end-to-end dengan PHP 8.3 + PostgreSQL 16 (PHP built-in server), termasuk instalasi
  dari database kosong dan menjalankan aplikasi dengan `DB_NAME` lain tanpa mengubah kode.
- Detail alur transaksi stok (transaction, `SELECT ... FOR UPDATE`) ada di README Jobsheet 12.