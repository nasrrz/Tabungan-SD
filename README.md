# 💰 Tabungan-SD (Sistem Informasi Tabungan Siswa Sekolah Dasar)

[![Laravel Version](https://img.shields.io/badge/Laravel-v11.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-v8.3-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![Nginx](https://img.shields.io/badge/Nginx-v1.24-009639?logo=nginx&logoColor=white)](https://nginx.org)
[![Apache](https://img.shields.io/badge/Apache-v2.4-D11141?logo=apache&logoColor=white)](https://httpd.apache.org/)
[![Database](https://img.shields.io/badge/MariaDB-v10.11-003545?logo=mariadb&logoColor=white)](https://mariadb.org)

Sistem Informasi Tabungan Siswa Sekolah Dasar (Tabungan-SD) adalah aplikasi manajemen dan rekapitulasi transaksi tabungan berbasis web. Proyek ini dirancang untuk mendigitalisasi pencatatan keuangan sekolah secara aman, transparan, dan akurat yang dapat diakses oleh pihak sekolah maupun dimonitor oleh orang tua murid.

---

## 🚀 Fitur Utama

* **Autentikasi Multi-User:** Hak akses terpisah untuk Administrator, Guru (Wali Kelas), dan Orang Tua Siswa.
* **Manajemen Data Induk:** Pengelolaan data siswa, kelas relasional, serta manajemen akun pengguna.
* **Pencatatan Transaksi Real-time:** Fitur setor dan tarik tunai tabungan dengan kalkulasi saldo otomatis yang presisi.
* **Ekspor Laporan:** Cetak riwayat transaksi dan rekapitulasi tabungan ke format Excel menggunakan library `status/maatwebsite`.
* **Keamanan Data:** Validasi mutasi yang ketat untuk menghindari manipulasi saldo sepihak.

---

## 🛠️ Stack Teknologi & Spesifikasi Server

### Backend & Framework
* **Framework:** Laravel 11.x
* **Bahasa Pemrograman:** PHP 8.3
* **Ekstensi PHP Wajib:** `openssl`, `pdo_mysql`, `mbstring`, `xml`, `curl`, `ctype`, `json`, `gd` (untuk kebutuhan ekspor Excel).

### Web Server & Database
* **Web Server:** Nginx atau Apache2 (Konfigurasi Produksi Port `80`/`443`)
* **Database Engine:** MariaDB v10.11+ / MySQL v8.0+

---

## 📂 Struktur Database (Skema Utama)

Aplikasi ini menggunakan relasi database yang ketat guna menjaga integritas data keuangan. Berikut adalah contoh blueprint migrasi pada tabel kelas:

```php
Schema::create('kelas', function (Blueprint $table) {
    $table->id();
    $table->string('nama_kelas');
    
    // Integrity constraint: Set Null jika akun user/guru dihapus
    $table->foreignId('guru_id')->nullable()->constrained('users')->nullOnDelete();
    
    $table->timestamps();
});
```

---

🏁 Panduan Instalasi Deployment (Ubuntu / Debian)
Ikuti langkah-langkah berikut untuk melakukan deployment repositori ini ke server produksi berbasis Debian/Ubuntu Linux.

1. Persiapan Environment Server
Pastikan sistem Anda sudah memperbarui repositori dan memasang dependensi dasar:

```Bash
sudo apt update && sudo apt upgrade -y
sudo apt install git curl unzip -y
```

---

2. Clone Repositori
Clone proyek ini ke direktori web server (standar: /var/www/):

```Bash
cd /var/www
sudo git clone [https://github.com/username-kamu/Tabungan-SD.git](https://github.com/username-kamu/Tabungan-SD.git)
cd Tabungan-SD
```

---

3. Install Dependensi Composer
Pastikan Composer sudah terinstall global pada server Anda, kemudian jalankan:

```Bash
composer install --no-dev --optimize-autoloader
```
4. Konfigurasi Environment File
Salin file .env.example menjadi .env lalu sesuaikan konfigurasi database Anda:

```Bash
cp .env.example .env
php artisan key:generate --force
```
Buka file .env mengunakan teks editor (nano .env) dan sesuaikan baris berikut:

```Code snippet
APP_ENV=production
APP_DEBUG=false
APP_URL=http://domain_atau_ip_server_anda

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tabungan_sd
DB_USERNAME=user_database_anda
DB_PASSWORD=password_database_anda
```
5. Eksekusi Migrasi & Seeder Database
Buat database kosong bernama tabungan_sd di MySQL/MariaDB server Anda, lalu jalankan perintah:

```Bash
php artisan migrate --force
php artisan db:seed --force
```
6. Atur Hak Akses Folder (Permission)
Berikan hak akses kepemilikan direktori kepada pengguna web server (www-data):

```Bash
sudo chown -R www-data:www-data /var/www/Tabungan-SD
sudo find /var/www/Tabungan-SD -type f -exec chmod 644 {} \;
sudo find /var/www/Tabungan-SD -type d -exec chmod 755 {} \;
```
# Berikan izin tulis khusus untuk folder penyimpanan Laravel
```sudo chmod -R 775 storage bootstrap/cache```
🌐 Referensi Konfigurasi Web Server
Pilih salah satu dari konfigurasi web server di bawah ini sesuai dengan engine yang aktif di server Debian/Ubuntu Anda.

Opsi A: Menggunakan Nginx (Direkomendasikan)
Buat file konfigurasi baru di /etc/nginx/sites-available/tabungan-sd:

```Nginx
server {
    listen 80;
    server_name domain_atau_ip_server_anda;
    root /var/www/Tabungan-SD/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```
Aktifkan konfigurasi dan muat ulang Nginx:

```Bash
sudo ln -s /etc/nginx/sites-available/tabungan-sd /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

Opsi B: Menggunakan Apache2
Pastikan modul mod_rewrite telah aktif pada Apache:

```Bash
sudo a2enmod rewrite
Buat file konfigurasi VirtualHost baru di /etc/apache2/sites-available/tabungan-sd.conf:
```

```Apache
<VirtualHost *:80>
    ServerName domain_atau_ip_server_anda
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/Tabungan-SD/public

    <Directory /var/www/Tabungan-SD/public>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/tabungan_sd_error.log
    CustomLog ${APACHE_LOG_DIR}/tabungan_sd_access.log combined
</VirtualHost>
```
Aktifkan VirtualHost dan muat ulang Apache2:

```Bash
sudo a2ensite tabungan-sd.conf
sudo a2dissite 000-default.conf
sudo systemctl restart apache2
```

---

🛠️ Optimasi Produksi (Production Cache)
Setelah aplikasi berhasil terpasang dan berjalan lancar, jalankan serangkaian perintah ini di direktori root aplikasi untuk mempercepat performa Laravel:

```Bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
👷 Dikembangkan oleh: Nasir Fadhlurrohman.
