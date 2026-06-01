# antrian-q (AntrianQ)

[![Laravel Framework](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Server-Sent Events](https://img.shields.io/badge/SSE-Realtime-blue?style=for-the-badge)](https://developer.mozilla.org/en-US/docs/Web/API/Server-sent_events)

**AntrianQ** (`antrian-q`) adalah sistem manajemen antrian digital real-time berbasis web yang dibangun menggunakan **Laravel** dan teknologi **Server-Sent Events (SSE)**. Aplikasi ini dirancang untuk memfasilitasi antrian loket secara instan dan sinkron antara halaman pengambilan tiket pengunjung, dashboard petugas, dan layar monitor ruang tunggu tanpa membebani server dengan *polling* HTTP berulang.

---

## 🛠️ Tech Stack & Library

* **Back-end Framework:** Laravel (PHP)
* **Real-time Engine:** Native Server-Sent Events (SSE) stream via `EventSource` API
* **Database:** MySQL / MariaDB (bisa juga menggunakan SQLite)
* **Front-end Styling:** Vanilla CSS (Desain kustom premium dengan skema warna HSL modern, efek glassmorphism, visual responsif, dan layout bersih)
* **Icons:** Boxicons CSS library (`bx` icons)
* **Notifikasi Suara:** Web Speech API (`window.speechSynthesis`) untuk panggilan suara otomatis dalam Bahasa Indonesia

---

## 🚀 Fitur Utama & Modul

Aplikasi ini terdiri dari tiga modul utama yang bekerja secara real-time:

### 1. 👥 Modul Pengantre (Guest/Pengunjung)
* **Pengambilan Tiket Instan:** Pengunjung cukup memasukkan nama untuk mendapatkan nomor antrian secara otomatis.
* **Halaman Tiket Dinamis:** Menampilkan status antrian saat ini (Menunggu, Sedang Dipanggil, Selesai, atau Terlewat) secara real-time tanpa perlu me-refresh halaman.

### 2. 🛡️ Dasbor & Manajemen Petugas (Admin/Loket)
* **Panel Kontrol Panggilan:** Dashboard untuk memantau antrian yang sedang menunggu dan memprosesnya.
* **Aksi Petugas:**
  * **Panggil Berikutnya (Call Next):** Memanggil nomor antrian selanjutnya dari antrian terlama.
  * **Panggil Ulang (Recall):** Mengirimkan ulang sinyal panggilan suara ke layar utama ruang tunggu.
  * **Selesai (Complete):** Mengubah status layanan menjadi selesai dan menutup antrian tersebut.
  * **Terlewat (Late):** Menandai antrian sebagai terlewat jika pengunjung tidak hadir di loket.

### 3. 🖥️ Layar Monitor Utama (Board)
* **Display Ruang Tunggu:** Tampilan monitor penuh yang atraktif untuk menunjukkan nomor antrian yang sedang dipanggil saat ini beserta nomor meja layanan/loket.
* **Riwayat Panggilan (History):** Menampilkan daftar 3 nomor antrian terakhir yang dipanggil sebelumnya.
* **Panggilan Suara Otomatis (Text-to-Speech):** Membunyikan suara panggilan saat admin menekan tombol "Call" atau "Recall" (contoh: *"Nomor antrian 5, harap menuju ke meja layanan"*).
* **Indikator Koneksi SSE:** Badge status koneksi real-time (`Connected`, `Connecting`, atau `Disconnected`) di bagian atas layar untuk memantau konektivitas jaringan SSE.

---

## 📂 Dokumentasi Rute (Routes)

* **Beranda (Home):** `/` (pilihan akses cepat ke semua halaman)
* **Pengunjung (Guest):**
  * `/guest` - Form pengambilan tiket antrian
  * `/guest/tiket/{id}` - Halaman detail status tiket real-time
* **Petugas (Admin):**
  * `/admin` atau `/admin/dashboard` - Panel kendali utama petugas
  * `/admin/manajemen` - Manajemen data antrian
* **Layar Display (Board):**
  * `/board` - Monitor display utama ruang tunggu
* **Event Stream:**
  * `/sse/antrian` - Endpoint SSE stream yang memancarkan data antrian secara real-time ke semua klien

---

## ⚙️ Cara Instalasi & Penggunaan

1. **Clone Repository:**
   ```bash
   git clone https://github.com/username_anda/antrian-q.git
   cd antrian-q
   ```

2. **Instal Dependensi Composer & NPM:**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment:**
   Salin file `.env.example` menjadi `.env`:
   ```bash
   copy .env.example .env
   ```
   *Buka file `.env` dan konfigurasikan koneksi database MySQL Anda:*
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=antrian_q
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Buat Database:**
   Buat database baru bernama `antrian_q` (atau sesuai konfigurasi `.env` Anda) melalui phpMyAdmin, MySQL CLI, atau DBMS pilihan Anda.

5. **Generate App Key & Jalankan Migrasi:**
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

6. **Jalankan Aplikasi:**
   ```bash
   php artisan serve
   ```
   Akses aplikasi melalui browser pada alamat [http://localhost:8000](http://localhost:8000).

---

## 💡 Catatan Tambahan
* **Izin Suara Browser (Autoplay):** Layar display utama (`/board`) membutuhkan izin suara pada browser Anda agar Text-to-Speech panggilan antrian dapat berbunyi otomatis tanpa terblokir sistem keamanan browser.
