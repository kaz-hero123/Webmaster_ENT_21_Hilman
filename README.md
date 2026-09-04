# Portal Berita (CRUD Sederhana)

Website Portal Berita sederhana ini dibangun menggunakan framework **Laravel**. Sistem ini memiliki fitur CRUD (Create, Read, Update, Delete) untuk mengelola berita, lengkap dengan fitur relasi **Kategori**.

## 🚀 Fitur Utama
1. **Manajemen Berita (CRUD)**: Menambah, melihat, mengedit, dan menghapus berita.
2. **Kategori Berita**: Setiap berita dapat dikaitkan dengan sebuah kategori (Relasi 1-to-Many).
3. **Upload Gambar**: Fitur opsional untuk mengunggah gambar sampul berita.

## 🛠️ Persyaratan Sistem
- PHP >= 8.2
- Composer
- Database MySQL atau SQLite (Secara default Laravel 11+ menggunakan SQLite jika MySQL tidak dikonfigurasi)
- Node.js & NPM (Opsional untuk asset)

---

## 📝 Tahapan Instalasi

Ikuti langkah-langkah berikut untuk menginstal dan menjalankan proyek di komputermu:

1. **Clone Repository**
   Buka terminal dan jalankan perintah berikut:
   ```bash
   git clone <LINK_REPOSITORY_KAMU>
   cd <NAMA_FOLDER_REPOSITORY>
   ```

2. **Install Dependensi PHP (Composer)**
   ```bash
   composer install
   ```

3. **Salin File Environment**
   Buat file `.env` dari salinan `.env.example`:
   ```bash
   cp .env.example .env
   ```
   *(Jika menggunakan Windows Command Prompt, gunakan `copy .env.example .env`)*

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Konfigurasi Database**
   Buka file `.env`, lalu atur bagian database sesuai dengan sistem komputermu. Jika kamu menggunakan MySQL (XAMPP/Laragon):
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=portalberita
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *Pastikan kamu sudah membuat database kosong bernama `portalberita` di phpMyAdmin/MySQL sebelum lanjut.*

6. **Jalankan Migrasi & Seeder Database**
   Perintah ini akan membuat tabel di database dan mengisi Kategori bawaan:
   ```bash
   php artisan migrate:fresh --seed
   ```

---

## ▶️ Tahapan Menjalankan Aplikasi

Setelah semua instalasi selesai, kamu bisa menyalakan server lokal Laravel:

1. Buka terminal di dalam folder proyek.
2. Jalankan perintah server:
   ```bash
   php artisan serve
   ```
3. Buka browser dan akses alamat berikut:
   **[http://localhost:8000/posts](http://localhost:8000/posts)**

Sekarang aplikasi Portal Berita sudah siap digunakan! Kamu bisa mulai menambahkan berita baru dan memilih kategori yang sudah disediakan (Politik, Teknologi, Olahraga).
