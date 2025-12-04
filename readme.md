# 📸 JogjaLensa - Marketplace Fotografi Yogyakarta

![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

> **Project Pemrograman Web (Semester 3)** > Platform marketplace yang menghubungkan fotografer profesional (Vendor) dengan klien di wilayah Yogyakarta untuk keperluan Wisuda, Wedding, Event, dan lainnya.

---

## 📖 Deskripsi Project

**JogjaLensa** hadir untuk memecahkan masalah sulitnya mencari fotografer yang transparan harga dan kualitasnya di Yogyakarta. Aplikasi ini menyediakan ekosistem lengkap mulai dari pencarian vendor, pemesanan (booking), pembayaran, hingga ulasan (review).

Dibangun menggunakan **PHP Native (Procedural)** yang ringan dan **Bootstrap 5** untuk antarmuka yang modern, responsif, dan *cinematic*.

## ✨ Fitur Unggulan

### 1. 🌏 Fitur Umum (Landing Page)
* **Cinematic Hero:** Tampilan awal dengan background video pariwisata Jogja dan audio yang memberikan *immersive experience*.
* **Advanced Search:** Pencarian vendor berdasarkan Nama, Kategori (Wisuda, Wedding, dll), dan Lokasi (Sleman, Bantul, dll).
* **Sorting & Filter:** Urutkan hasil pencarian berdasarkan Harga Termurah, Termahal, atau Nama (A-Z).
* **Statistik Real-time:** Menampilkan jumlah vendor aktif dan transaksi sukses langsung dari database.

### 2. 👤 Fitur Client (User)
* **Booking System:** Memesan jasa foto dengan memilih paket, tanggal, dan jam secara spesifik.
* **Dashboard Client:** Memantau status pesanan (Menunggu Konfirmasi, Diproses, Selesai).
* **Payment Upload:** Mengunggah bukti transfer pembayaran.
* **Review & Rating:** Memberikan ulasan bintang 1-5 setelah pesanan selesai.
* **Invoice Digital:** Cetak detail pesanan/invoice secara otomatis.

### 3. 📷 Fitur Vendor (Fotografer)
* **Mitra Dashboard:** Statistik pendapatan total, jumlah proyek, dan rating rata-rata.
* **Manajemen Paket:** CRUD (Create, Read, Update, Delete) paket harga layanan.
* **Portofolio Gallery:** Upload foto hasil karya untuk menarik klien.
* **Order Management:** Menerima (Accept), Menolak (Reject), atau Menyelesaikan (Complete) pesanan masuk.
* **Profile Studio:** Pengaturan profil bisnis, alat (gear), keahlian, dan media sosial.

---

## 🛠️ Teknologi yang Digunakan

| Komponen | Teknologi | Keterangan |
| :--- | :--- | :--- |
| **Backend** | PHP 8 (Native) | Menggunakan koneksi `mysqli` prosedural. |
| **Frontend** | Bootstrap v5.3 | Framework CSS responsive + Icons. |
| **Database** | MySQL / MariaDB | Relasional database dengan Foreign Keys. |
| **Media** | HTML5 Video & Audio | Background video loop & fitur musik latar pintar. |
| **Server** | Apache | Dijalankan via XAMPP / Laragon. |

---

## 📂 Struktur Folder Project

```text
/JogjaLensa
│
├── /assets                 # File statis (CSS, Gambar, Audio, Video)
│   ├── /audio              # Musik latar
│   ├── /image              # Gambar kategori & placeholder
│   └── /video              # Video background landing page
│
├── /components             # Potongan layout (Header, Navbar, Footer)
├── /includes               # Konfigurasi Database (koneksi.php)
├── /logic                  # Logika Pemrosesan Backend
│   ├── /auth               # Login, Register, Logout
│   ├── /logicuser          # Booking, Bayar, Review, Profile
│   └── /logicvendor        # Paket, Portofolio, Status Order
│
├── /sql                    # File backup database (.sql)
├── /uploads                # Folder penyimpanan file user
│   ├── /portofolio         # Foto portofolio vendor
│   └── /bukti_transfer     # Bukti pembayaran user
│
├── index.php               # Landing Page Utama
├── dashboard_user.php      # Halaman User
├── dashboard_vendor.php    # Halaman Vendor
├── pencarian.php           # Halaman Search Result
├── profile.php             # Halaman Detail Vendor
└── ... (file lainnya)
