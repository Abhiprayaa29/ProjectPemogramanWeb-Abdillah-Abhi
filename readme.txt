# 📸 JogjaLensa

![PHP Version](https://img.shields.io/badge/php-8.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Database](https://img.shields.io/badge/database-mysql-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Framework](https://img.shields.io/badge/frontend-bootstrap%205-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)

> **Platform Marketplace Fotografi #1 di Yogyakarta.**
> *Temukan, Booking, dan Abadikan Momen Terbaikmu.*

---

## 📑 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Fitur Unggulan](#-fitur-unggulan)
- [Teknologi](#-teknologi)
- [Struktur Database](#-struktur-database)
- [Instalasi & Penggunaan](#-instalasi--penggunaan)
- [Tangkapan Layar](#-tangkapan-layar)
- [Kontributor](#-kontributor)

---

## 📖 Tentang Proyek

**JogjaLensa** adalah aplikasi berbasis web yang menjembatani kebutuhan antara klien (wisudawan, pasangan pengantin, turis) dengan fotografer profesional di Yogyakarta.

Diciptakan untuk memecahkan masalah transparansi harga dan kesulitan mencari vendor fotografi yang terpercaya. Aplikasi ini menawarkan pengalaman pengguna yang sinematik dengan fitur pencarian canggih dan manajemen booking yang terintegrasi.

---

## ✨ Fitur Unggulan

### 🌍 Umum (Public)
- **Cinematic Landing Page:** Visualisasi video latar belakang & pemutar musik yang imersif.
- **Smart Search & Filter:** Cari vendor berdasarkan Lokasi, Kategori (Wisuda, Wedding, dll), Harga, dan Nama.
- **Vendor Discovery:** Rekomendasi vendor termurah dan terpopuler secara real-time.

### 👤 Klien (User)
- **Booking System:** Pemesanan jadwal foto yang mudah dengan status pelacakan (Pending -> Confirmed -> Completed).
- **Payment Gateway (Simulasi):** Unggah bukti transfer untuk konfirmasi pembayaran.
- **Rating & Review:** Berikan ulasan bintang 1-5 untuk vendor setelah proyek selesai.
- **User Dashboard:** Kelola profil, ganti password, dan lihat riwayat transaksi.

### 📷 Vendor (Fotografer)
- **Dedicated Dashboard:** Pantau pendapatan, statistik pesanan, dan performa rating.
- **Package Management:** CRUD (Create, Read, Update, Delete) paket layanan harga.
- **Portfolio Gallery:** Unggah hasil karya terbaik untuk menarik klien.
- **Order Management:** Terima/Tolak pesanan masuk dan update status pengerjaan.

---

## 💻 Teknologi

Proyek ini dibangun dengan pendekatan *Native* untuk performa maksimal dan kemudahan pemahaman struktur dasar web.

| Kategori | Teknologi | Deskripsi |
| :--- | :--- | :--- |
| **Backend** | PHP 8 | Native Procedural Style |
| **Database** | MySQL / MariaDB | Relational Database Management |
| **Frontend** | Bootstrap 5.3 | Responsive UI Framework |
| **Icons** | Bootstrap Icons | Ikon Vektor Ringan |
| **Scripting** | JavaScript (Vanilla) | Logika Modal & Audio Player |

---

## 🗄️ Struktur Database

Relasi tabel utama dalam `db_jogjalensa`:

* `users`: Menyimpan data autentikasi (Login).
* `vendors`: Profil detail fotografer (berelasi dengan `users`).
* `packages`: Layanan harga yang ditawarkan vendor.
* `bookings`: Transaksi inti antara user dan vendor.
* `reviews`: Ulasan kepuasan pelanggan.
* `portofolio`: Galeri foto vendor.

> *Skema lengkap tersedia di folder `sql/`.*

---

## 🚀 Instalasi & Penggunaan

Ikuti langkah-langkah berikut untuk menjalankan proyek di **Localhost** (XAMPP/Laragon):

### 1. Clone atau Download
Simpan folder proyek di dalam direktori server lokal Anda (misal: `C:\xampp\htdocs\jogjalensa`).

### 2. Konfigurasi Database
1. Buka **phpMyAdmin**.
2. Buat database baru: `db_jogjalensa`.
3. Import file SQL terbaru dari folder `sql/` (Rekomendasi: `db_jogjalensa (2).sql`).

### 3. Koneksi
Pastikan file `includes/koneksi.php` sesuai dengan kredensial database Anda:
```php
$host = "localhost";
$user = "root";
$pass = ""; // Sesuaikan password database Anda
$name = "db_jogjalensa";
