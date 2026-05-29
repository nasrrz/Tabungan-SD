💰 Tabungan-SD (Sistem Informasi Tabungan Siswa Sekolah Dasar)
[![Laravel Version](https://img.shields.io/badge/Laravel-v11.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-v8.3-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![Database](https://img.shields.io/badge/MariaDB-v10.11-003545?logo=mariadb&logoColor=white)](https://mariadb.org)

Aplikasi manajemen dan rekapitulasi tabungan siswa Sekolah Dasar berbasis web. Proyek ini dibangun untuk mendigitalisasi pencatatan transaksi tabungan secara aman, transparan, dan dapat dimonitor langsung oleh pihak sekolah maupun orang tua siswa.
🎯 Target Deployment: Server Debian/Ubuntu (VPS, Dedicated, atau Local Server)
🌐 Akses Publik: Via domain/IP server langsung (tanpa tunneling)
📦 Repository: GitHub - Tabungan-SD
🚀 Fitur Utama
Autentikasi Multi-User: Pemisahan hak akses login untuk Administrator, Guru (Wali Kelas), dan Orang Tua Siswa.
Manajemen Data Induk: Pengelolaan data siswa, kelas (relasional ke wali kelas), dan data pengguna sistem.
Pencatatan Transaksi Real-time: Proses setor dan tarik tunai tabungan dengan kalkulasi saldo otomatis.
Laporan Eksport: Cetak riwayat transaksi dan rekapitulasi tabungan ke format Excel menggunakan maatwebsite/excel.
Responsive Design: Tampilan optimal untuk desktop, tablet, dan mobile.
Audit Log: Pencatatan aktivitas pengguna untuk keamanan dan transparansi.
🛠️ Stack Teknologi & Spesifikasi Infrastruktur
💻 Backend & Core Framework
Komponen
Versi
Keterangan
Framework
Laravel 11.x
PHP Framework modern dengan fitur lengkap
Bahasa
PHP 8.3 (LTS)
Performa optimal dengan JIT compiler
Package Manager
Composer 2.x
Dependency management untuk PHP
Ekstensi PHP
gd, mysqli, mbstring, xml, curl, zip
Diperlukan untuk fitur grafis, database, dan export
🌐 Web Server (Pilih Salah Satu)
Web Server
Versi
Port Default
Kelebihan
Nginx
≥ 1.22
80/443
Performa tinggi, resource efisien, reverse proxy native
Apache2
≥ 2.4
80/443
Konfigurasi fleksibel, .htaccess support, modul lengkap
🗄️ Database & Tools Pendukung
Komponen
Versi
Keterangan
Database
MariaDB 10.11+ / MySQL 8.0+
Relational database dengan performa tinggi
PHP-FPM
8.3
FastCGI Process Manager untuk handling request PHP
Cache
Redis (opsional) / File
Session & cache optimization
Queue
Database/Redis (opsional)
Background job processing
🔧 Environment & Deployment
OS: Debian 12 (Bookworm) / Ubuntu 22.04 LTS / 24.04 LTS
Git: Untuk version control dan deployment dari GitHub
SSL: Let's Encrypt (Certbot) untuk HTTPS gratis
Firewall: UFW (Uncomplicated Firewall) untuk keamanan jaringan
📂 Struktur Database (Skema Utama)
Berikut adalah gambaran salah satu skema migrasi tabel relasional pada sistem:
php
12345678910
🔗 Diagram Relasi Utama
1234
🏁 Panduan Instalasi Server (Debian/Ubuntu)
📋 Prasyarat Sistem
Server dengan minimal 2GB RAM, 2 vCPU, dan 20GB SSD
Akses root/sudo ke server
Domain atau IP publik yang dapat diakses (opsional untuk produksi)
Port 80 (HTTP) dan 443 (HTTPS) terbuka di firewall
🔧 Langkah 1: Update Sistem & Install Dependensi Dasar
bash
12345
🐘 Langkah 2: Install PHP 8.3 & Ekstensi Required
bash
123456789101112
🗄️ Langkah 3: Install & Konfigurasi Database (MariaDB)
bash
12345678
sql
123456
🌐 Langkah 4: Pilih & Konfigurasi Web Server
⚠️ Pilih salah satu: Nginx ATAU Apache2. Jangan jalankan keduanya di port yang sama.
🔹 Opsi A: Konfigurasi Nginx (Direkomendasikan)
bash
12345
nginx
123456789101112131415161718192021222324252627282930313233343536373839404142
bash
1234567
🔹 Opsi B: Konfigurasi Apache2
bash
123456
apache
123456789101112131415161718192021222324252627282930313233343536
bash
12345678
📦 Langkah 5: Deploy Aplikasi dari GitHub
bash
123456789101112131415161718
Edit file .env sesuai konfigurasi server:
env
1234567891011121314151617
🗃️ Langkah 6: Migrasi Database & Seeder
bash
123456789
🔐 Langkah 7: Atur Permission & Ownership
bash
12345678
🔒 Langkah 8: Konfigurasi SSL (HTTPS) - Opsional tapi Direkomendasikan
bash
12345678910111213
🔄 Setelah instalasi SSL, update APP_URL di .env menjadi https:// dan jalankan:
bash
1
🧪 Langkah 9: Verifikasi & Testing
bash
1234567891011
Akses aplikasi melalui browser: https://your-domain.com
🔄 Deployment Otomatis dari GitHub (Opsional)
Menggunakan GitHub Actions (CI/CD Sederhana)
Buat file .github/workflows/deploy.yml:
yaml
12345678910111213141516171819202122232425262728
⚠️ Simpan variabel berikut di GitHub Repository Secrets:
SERVER_HOST: IP atau domain server
SERVER_USER: username SSH (misal: deploy)
SSH_PRIVATE_KEY: Private key SSH untuk akses server
🛡️ Keamanan & Best Practices
🔐 Hardening Server
bash
12345678910111213
🔒 Hardening Aplikasi Laravel
Pastikan APP_DEBUG=false di produksi
Gunakan APP_ENV=production
Batasi akses ke /phpmyadmin (jika diinstall) dengan IP whitelist
Gunakan password kuat untuk database dan user aplikasi
Backup database secara berkala:
bash
12
📊 Monitoring (Opsional)
Install laravel-telescope untuk debugging lokal
Gunakan laravel-log-viewer untuk monitoring log
Setup monitoring server dengan netdata atau prometheus+grafana
🐛 Troubleshooting Umum
Masalah
Solusi
500 Internal Server Error
Cek log: tail -f /var/log/nginx/tabungan-sd-error.log atau storage/logs/laravel.log
Permission denied
Pastikan ownership www-data dan permission 775 untuk storage/ dan bootstrap/cache/
Database connection failed
Verifikasi kredensial di .env, pastikan user DB memiliki hak akses, dan firewall mengizinkan port 3306 (localhost only)
PHP extensions missing
Jalankan php -m dan install ekstensi yang kurang via apt install php8.3-xxx
Laravel routing not working
Pastikan mod_rewrite aktif (Apache) atau konfigurasi try_files benar (Nginx)
SSL certificate error
Jalankan sudo certbot renew --force-renewal dan restart web server
📦 Backup & Restore
Backup Database
bash
12345
Restore Database
bash
12345
Backup File Aplikasi
bash
123456
🤝 Kontribusi
Fork repository ini
Buat branch fitur baru (git checkout -b fitur/baru)
Commit perubahan (git commit -am 'Tambah fitur X')
Push ke branch (git push origin fitur/baru)
Buat Pull Request
📝 Pastikan kode mengikuti standar PSR-12 dan telah di-test sebelum submit PR.
📄 Lisensi
Proyek ini dilisensikan di bawah Lisensi MIT.
👷 Dikembangkan oleh
Nasir Fadhlurrohman
📧 Email | 💼 LinkedIn | 🐙 GitHub
