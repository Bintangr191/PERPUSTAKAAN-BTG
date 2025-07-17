# Sistem Informasi Perpustakaan BTG

Aplikasi ini merupakan sistem informasi perpustakaan berbasis Laravel. Pastikan Anda telah menginstal PHP minimal versi 8.1, Composer, dan server lokal seperti XAMPP atau Laragon.

1. Clone repositori dengan perintah:  git clone https://github.com/Bintangr191/PERPUSTAKAAN-BTG.git
2. Masuk ke direktori proyek:  cd PERPUSTAKAAN-BTG
3. Jalankan Composer untuk mengunduh dependensi:  composer install
4. Salin file konfigurasi:  cp .env.example .env
5. di terminal atur: php artisan key:generate
6. Buat database baru di MySQL, misalnya dengan nama perpusbtg.
7. Edit file .env dan sesuaikan bagian DB_DATABASE, DB_USERNAME, dan DB_PASSWORD.
8. Setelah itu, jalankan migrasi dan seeder dengan perintah:  php artisan migrate --seed
9. install dan build frontend: npm install -> npm run dev
10. Untuk menjalankan aplikasi, gunakan perintah:  php artisan serve
11. Buka browser dan akses:  http://localhost:8000

Aplikasi siap digunakan.

Akun default hasil seeder:  
- Email: adminperpus123@gmail.com  
- Password: password123
