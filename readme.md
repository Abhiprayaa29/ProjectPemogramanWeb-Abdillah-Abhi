# JogjaLensa 📸

**JogjaLensa** adalah sebuah platform marketplace fotografi berbasis web yang menghubungkan klien (wisudawan, pasangan pengantin, turis) dengan fotografer profesional (vendor) di wilayah Yogyakarta.

Web ini bertujuan untuk memudahkan pengguna mencari jasa fotografi yang transparan, aman, dan berkualitas, sekaligus membantu fotografer lokal memasarkan jasa mereka dan mengelola pesanan secara profesional.

---

## 🌟 Fitur Utama

Web ini membagi hak akses menjadi dua peran utama: **Client (Pengguna)** dan **Vendor (Fotografer)**.

### 1. Fitur Umum (Landing Page)
* **Cinematic Experience:** Tampilan beranda dengan latar belakang video dan musik latar (background audio) khas Yogyakarta.
* **Pencarian Canggih:** Mencari fotografer berdasarkan nama, kategori (Wisuda, Wedding, Event, Produk), atau lokasi (Sleman, Bantul, dll).
* **Filter & Sorting:** Menyaring hasil pencarian dan mengurutkan berdasarkan harga termurah/termahal atau nama (A-Z).
* **Top Vendor:** Menampilkan rekomendasi vendor termurah dan statistik real-time aplikasi.

### 2. Fitur Client (User)
* **Registrasi & Login:** Pendaftaran akun pengguna.
* **Booking System:** Memesan jasa foto dengan memilih paket, tanggal, dan waktu sesi.
* **Manajemen Pesanan:** Melihat riwayat pesanan dan status (Menunggu Konfirmasi, Diproses, Selesai).
* **Pembayaran:** Mengunggah bukti transfer pembayaran.
* **Review & Rating:** Memberikan ulasan bintang dan komentar setelah sesi foto selesai.
* **Pengaturan Profil:** Mengubah foto profil, nama, email, dan kata sandi.

### 3. Fitur Vendor (Fotografer)
* **Pendaftaran Mitra:** Formulir khusus untuk mendaftar sebagai vendor.
* **Vendor Dashboard:** Statistik pendapatan, jumlah proyek selesai, dan rating rata-rata.
* **Manajemen Paket (CRUD):** Membuat, mengedit, dan menghapus paket harga layanan.
* **Manajemen Portofolio:** Mengunggah dan menghapus foto hasil karya ke dalam galeri profil.
* **Manajemen Pesanan:** Menerima atau menolak pesanan masuk, serta menandai pesanan selesai.
* **Pengaturan Studio:** Mengedit profil bisnis, deskripsi, alat (gear), keahlian (skills), dan akun sosial media.

---

## 🛠️ Teknologi yang Digunakan

Proyek ini dibangun menggunakan teknologi web standar (Native) tanpa framework backend yang berat, sehingga ringan dan mudah dipelajari.

### Backend
* **Bahasa:** PHP 8.x (Native / Procedural style).
* **Database:** MySQL / MariaDB.
* **Keamanan:**
    * Password Hashing (`password_hash` & `password_verify`).
    * SQL Injection Protection (menggunakan `mysqli_real_escape_string`).
    * Session Management.

### Frontend
* **HTML5 & CSS3.**
* **Framework CSS:** Bootstrap 5.3 (Responsif untuk Mobile & Desktop).
* **Icons:** Bootstrap Icons (`bi-`).
* **JavaScript:** Vanilla JS & Bootstrap Bundle (untuk Modal, Dropdown, dan logika Audio Player).

### Media
* **Video Background:** Video MP4 untuk visualisasi hero section.
* **Audio Player:** Fitur musik latar dengan persistensi status (menyimpan posisi lagu saat pindah halaman).

---

## 📂 Struktur Database

Database `db_jogjalensa` terdiri dari tabel-tabel berikut:

1.  **`users`**: Menyimpan data login (email, password, role).
2.  **`vendors`**: Menyimpan detail profil fotografer (brand name, lokasi, deskripsi, dll) yang berelasi dengan tabel users.
3.  **`packages`**: Daftar paket harga yang ditawarkan vendor.
4.  **`bookings`**: Transaksi pemesanan (tanggal, status, total harga).
5.  **`portofolio`**: Galeri foto yang diunggah vendor.
6.  **`reviews`**: Ulasan dan rating dari user untuk booking yang selesai.
7.  **`packages_history`**: Riwayat perubahan paket (log).

---

## 🚀 Panduan Instalasi (Localhost)

Ikuti langkah ini untuk menjalankan proyek di komputer Anda menggunakan XAMPP atau Laragon:

1.  **Persiapan Lingkungan:**
    * Pastikan **XAMPP** atau server lokal sejenis sudah terinstall (Apache & MySQL).
    * Simpan folder project ini di dalam direktori `htdocs` (misal: `C:\xampp\htdocs\jogjalensa`).

2.  **Setup Database:**
    * Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
    * Buat database baru dengan nama `db_jogjalensa`.
    * Import file SQL yang ada di folder `sql/` (Gunakan file terbaru: `db_jogjalensa (2).sql`).

3.  **Konfigurasi Koneksi:**
    * Buka file `includes/koneksi.php`.
    * Pastikan konfigurasi sesuai dengan server lokal Anda:
        ```php
        $host = "localhost";
        $user = "root";
        $pass = ""; // Kosongkan jika default XAMPP
        $name = "db_jogjalensa";
        ```

4.  **Menjalankan Project:**
    * Buka browser dan akses: `http://localhost/jogjalensa/`

---

## 📝 Alur Booking (How it Works)

1.  **Cari:** User mencari fotografer dan melihat portofolio/paket.
2.  **Booking:** User memilih paket dan mengisi tanggal/jam (Status awal: `pending`).
3.  **Konfirmasi:** Vendor menerima pesanan melalui dashboard (Status berubah: `confirmed`).
4.  **Bayar:** User mengunggah bukti pembayaran.
5.  **Pelaksanaan:** Sesi foto berlangsung sesuai jadwal.
6.  **Selesai:** Vendor menandai pesanan selesai (Status akhir: `completed`).
7.  **Review:** User memberikan rating bintang 1-5.

---

## 👤 Author

**Project Pemrograman Web**
* **Abdillah Abhi dan Gian Abi Firdaus**
* Dikembangkan untuk memenuhi tugas pemrograman web dan studi kasus e-commerce jasa.

---

*Catatan: Pastikan folder `uploads/portofolio/` dan `assets/bukti_transfer/` memiliki izin tulis (write permission) agar fitur upload gambar berfungsi dengan baik.*
