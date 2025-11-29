#  P5X Store - Phantom Thieves Market

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

**P5X Store** adalah aplikasi E-Commerce berbasis Laravel yang dirancang dengan sistem Multi-Role (Admin, Seller, Buyer) yang aman dan terstruktur. Mengusung tema visual yang terinspirasi dari *Persona 5*, aplikasi ini menyediakan pengalaman belanja yang unik mulai dari katalog produk hingga manajemen toko.

---

##  Fitur Utama

###  Public & Buyer (Pembeli)
* **Katalog Produk:** Pencarian real-time dan filter berdasarkan harga/terbaru.
* **Keranjang Belanja:** Menambah, mengupdate, dan menghapus item.
* **Checkout System:** Memproses keranjang menjadi pesanan dengan validasi stok.
* **Riwayat Pesanan:** Melacak status pesanan (Pending, Processed, Shipped, Completed).
* **Ulasan Produk:** Memberikan rating bintang dan komentar setelah pesanan selesai.
* **Profil Pengguna:** Edit profil dan ganti password.

###  Seller (Penjual)
* **Registrasi & Verifikasi:** Sistem pendaftaran dengan status "Pending" hingga disetujui Admin.
* **Manajemen Toko:** Mengatur nama, deskripsi, dan banner toko.
* **Manajemen Produk:** CRUD Produk lengkap dengan upload gambar.
* **Manajemen Pesanan:** Melihat pesanan masuk dan update status pesanan.
* **Dashboard Statistik:** Ringkasan total produk dan pesanan.

###  Admin (Administrator)
* **Manajemen User:** Melihat, mengedit, dan menghapus pengguna.
* **Verifikasi Seller:** Menyetujui (Approve) atau Menolak (Reject) pendaftaran Seller baru.
* **Manajemen Kategori:** Membuat dan mengatur kategori produk global.
* **Moderasi Produk:** Menghapus produk yang melanggar ketentuan (Take Down).

---

##  Teknologi yang Digunakan

* **Framework:** Laravel 11
* **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
* **Database:** MySQL
* **Authentication:** Laravel Breeze (Customized for Multi-Role)
* **File Storage:** Local Storage Link

---

##  Cara Instalasi (Localhost)

Ikuti langkah-langkah ini untuk menjalankan proyek di komputer Anda:

### 1. Clone Repository
```bash
git clone [https://github.com/username-anda/final_lab.git](https://github.com/username-anda/final_lab.git)
cd final_lab
```

==Install Dependensi==
```bash
composer install
npm install
npm run build
```

==Konfigurasi Environment==
```
php artisan key:generate
php artisan storage:link
```

Duplikat file .env.example menjadi .env:
```
php artisan migrate:fresh --seed
```

Buka file .env dan atur konfigurasi database serta filesystem:
```
DB_DATABASE=final
DB_USERNAME=root
DB_PASSWORD=
```

# PENTING AGAR GAMBAR MUNCUL
```
FILESYSTEM_DISK=public
```

==Migrasi & Seeding Database==
```
php artisan migrate:fresh --seed
```

===Jalankan Server==
```
php artisan serve
```
==Akun Demo (Seeder)==

<img width="580" height="170" alt="image" src="https://github.com/user-attachments/assets/dd50c07b-cda2-4f14-827d-1482ad10b57d" />

## Tampilan
Tampilan Awal
<img width="1919" height="926" alt="image" src="https://github.com/user-attachments/assets/365cf9a6-cd2a-4ccb-8f2d-27fdc9905fbb" />

Register

<img width="662" height="865" alt="image" src="https://github.com/user-attachments/assets/12839b89-de78-45db-b700-9cccc9035e2a" />

Login

<img width="505" height="624" alt="image" src="https://github.com/user-attachments/assets/d0d2501c-5140-4316-994e-fe3311cc453a" />

Tampilan Admin
<img width="1919" height="814" alt="image" src="https://github.com/user-attachments/assets/b536130e-7160-4b6c-85d2-b7756bd4ca99" />

Tampilan Seller
<img width="1919" height="925" alt="image" src="https://github.com/user-attachments/assets/65bb28a9-80a9-4e1d-8669-5c91b035eee0" />


Catatan Penting
---
```
Jika gambar tidak muncul, pastikan Anda sudah menjalankan 
php artisan storage:link dan mengubah 
FILESYSTEM_DISK=public di .env.
```

Jika terjadi error "Route not found" atau "Class not found", jalankan:
```
composer dump-autoload
php artisan optimize:clear
```

AND THE LAST 

TAKE YOUR TIME
<img width="1200" height="1200" alt="image" src="https://github.com/user-attachments/assets/a614247a-1f3e-4674-a093-b406da67bf39" />



