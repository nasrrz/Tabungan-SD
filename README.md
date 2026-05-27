# 💰 Tabungan-SD (Sistem Informasi Tabungan Siswa Sekolah Dasar)

[![Laravel Version](https://img.shields.io/badge/Laravel-v11.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-v8.3-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![Nginx](https://img.shields.io/badge/Nginx-v1.22-009639?logo=nginx&logoColor=white)](https://nginx.org)
[![Database](https://img.shields.io/badge/MariaDB-v10.11-003545?logo=mariadb&logoColor=white)](https://mariadb.org)

Aplikasi manajemen dan rekapitulasi tabungan siswa Sekolah Dasar berbasis web. Proyek ini dibangun untuk mendigitalisasi pencatatan transaksi tabungan secara aman, transparan, dan dapat dimonitor langsung oleh pihak sekolah maupun orang tua siswa.

---

## 🚀 Fitur Utama
* **Autentikasi Multi-User:** Pemisahan hak akses login untuk Administrator, Guru (Wali Kelas), dan Orang Tua Siswa.
* **Manajemen Data Induk:** Pengelolaan data siswa, kelas (relasional ke wali kelas), dan data pengguna sistem.
* **Pencatatan Transaksi Real-time:** Proses setor dan tarik tunai tabungan dengan kalkulasi saldo otomatis.
* **Laporan Eksport:** Cetak riwayat transaksi dan rekapitulasi tabungan ke format Excel menggunakan `maatwebsite/excel`.
* **Arsitektur Mobile Hosting:** Server dioptimalkan untuk dapat berjalan secara *portable* di lingkungan Android via UserLAnd.

---

## 🛠️ Stack Teknologi & Spesifikasi Infrastruktur

### 💻 Backend & Core Framework
* **Framework:** Laravel 11.x
* **Bahasa Pemrograman:** PHP 8.3 (LTS Modern Deployment)
* **Ekstensi PHP Aktif:** `ext-gd` (Grafik/Spreadsheet), `mysqli`, `mbstring`, `xml`

### 🌐 Web Server & Database
* **Web Server:** Nginx (Port: `8080` Reverse Proxy Integration)
* **Database Management:** MariaDB / MySQL Server
* **Database Administrator:** phpMyAdmin v5.2.1 (Manual Standalone Deployment)

### ⛓️ Tunneling & Networking Gateway
* **Edge Network:** Cloudflare Tunnel (`cloudflared`) via Quick Tunnel & Custom Domain Routing.

---

## 📂 Struktur Database (Skema Utama)

Berikut adalah gambaran salah satu skema migrasi tabel relasional pada sistem:

```php
Schema::create('kelas', function (Blueprint $table) {
    $table->id();
    $table->string('nama_kelas');
    
    // Relasi Data: Menghubungkan kelas ke tabel Users (Guru)
    // integrity constraint: Set Null jika akun user/guru dihapus
    $table->foreignId('guru_id')->nullable()->constrained('users')->nullOnDelete();
    
    $table->timestamps();
});
🏁 Panduan Instalasi Lokal (Ubuntu/Debian/UserLAnd Android)
1. Clone Repositori
Bash
git clone [https://github.com/username-kamu/Tabungan-SD.git](https://github.com/username-kamu/Tabungan-SD.git)
cd Tabungan-SD
2. Install Dependensi Composer
Bash
composer install
3. Konfigurasi Environment File
Salin file .env.example menjadi .env, lalu sesuaikan kredensial database Anda:

Bash
cp .env.example .env
php artisan key:generate
Isi konfigurasi database pada file .env:

Code snippet
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tabungan_sd
DB_USERNAME=root
DB_PASSWORD=password_mariadb_anda
4. Eksekusi Migrasi & Seeder Database
Bash
php artisan migrate
php artisan db:seed
5. Atur Hak Akses Folder (Linux Environment)
Bash
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
6. Konfigurasi Server Blok Nginx (/etc/nginx/sites-available/default)
Nginx
server {
        listen 8080 default_server;
        root /var/www/Tabungan-SD/public;
        index index.php index.html;

        location / {
                try_files $uri $uri/ /index.php?$query_string;
        }

        location ~ \.php$ {
                include snippets/fastcgi-php.conf;
                fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        }
}
Jalankan ulang layanan web server:

Bash
sudo service nginx restart
sudo service php8.3-fpm restart
🌐 Publikasi Jaringan via Cloudflare Tunnel
Untuk membuka akses lokal agar dapat diakses secara publik melalui internet, jalankan perintah berikut:

Bash
cloudflared tunnel --url [http://127.0.0.1:8080](http://127.0.0.1:8080)
Gunakan link berakhiran .trycloudflare.com yang dihasilkan untuk mengakses aplikasi dari luar jaringan.

👷 Dikembangkan oleh: Nasir Fadhlurrohman.
