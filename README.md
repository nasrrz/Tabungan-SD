# 💰 Tabungan-SD (Sistem Informasi Tabungan Siswa Sekolah Dasar)

[![Laravel Version](https://img.shields.io/badge/Laravel-v11.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-v8.3-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Debian/Ubuntu](https://img.shields.io/badge/OS-Debian%2FUbuntu-A80030?logo=debian&logoColor=white)](https://www.debian.org)

Aplikasi manajemen dan rekapitulasi tabungan siswa Sekolah Dasar berbasis web. Proyek ini dibangun untuk mendigitalisasi pencatatan transaksi tabungan secara aman, transparan, dan dapat dimonitor langsung oleh pihak sekolah maupun orang tua siswa.

> 🎯 **Target Deployment**: Server Debian/Ubuntu (VPS, Dedicated, atau Local Server)  
> 🌐 **Akses Publik**: Via domain/IP server langsung (tanpa tunneling)  
> 📦 **Repository**: [GitHub - Tabungan-SD](https://github.com/username-kamu/Tabungan-SD)

---

## 🚀 Fitur Utama

* **Autentikasi Multi-User:** Pemisahan hak akses login untuk Administrator, Guru (Wali Kelas), dan Orang Tua Siswa.
* **Manajemen Data Induk:** Pengelolaan data siswa, kelas (relasional ke wali kelas), dan data pengguna sistem.
* **Pencatatan Transaksi Real-time:** Proses setor dan tarik tunai tabungan dengan kalkulasi saldo otomatis.
* **Laporan Eksport:** Cetak riwayat transaksi dan rekapitulasi tabungan ke format Excel menggunakan `maatwebsite/excel`.
* **Responsive Design:** Tampilan optimal untuk desktop, tablet, dan mobile.
* **Audit Log:** Pencatatan aktivitas pengguna untuk keamanan dan transparansi.

---

## 🛠️ Stack Teknologi & Spesifikasi Infrastruktur

### 💻 Backend & Core Framework
| Komponen | Versi | Keterangan |
|----------|-------|------------|
| **Framework** | Laravel 11.x | PHP Framework modern dengan fitur lengkap |
| **Bahasa** | PHP 8.3 (LTS) | Performa optimal dengan JIT compiler |
| **Package Manager** | Composer 2.x | Dependency management untuk PHP |
| **Ekstensi PHP** | `gd`, `mysqli`, `mbstring`, `xml`, `curl`, `zip` | Diperlukan untuk fitur grafis, database, dan export |

### 🌐 Web Server (Pilih Salah Satu)
| Web Server | Versi | Port Default | Kelebihan |
|------------|-------|--------------|-----------|
| **Nginx** | ≥ 1.22 | 80/443 | Performa tinggi, resource efisien, reverse proxy native |
| **Apache2** | ≥ 2.4 | 80/443 | Konfigurasi fleksibel, `.htaccess` support, modul lengkap |

### 🗄️ Database & Tools Pendukung
| Komponen | Versi | Keterangan |
|----------|-------|------------|
| **Database** | MariaDB 10.11+ / MySQL 8.0+ | Relational database dengan performa tinggi |
| **PHP-FPM** | 8.3 | FastCGI Process Manager untuk handling request PHP |
| **Cache** | Redis (opsional) / File | Session & cache optimization |
| **Queue** | Database/Redis (opsional) | Background job processing |

### 🔧 Environment & Deployment
* **OS**: Debian 12 (Bookworm) / Ubuntu 22.04 LTS / 24.04 LTS
* **Git**: Untuk version control dan deployment dari GitHub
* **SSL**: Let's Encrypt (Certbot) untuk HTTPS gratis
* **Firewall**: UFW (Uncomplicated Firewall) untuk keamanan jaringan

---

## 📂 Struktur Database (Skema Utama)

Berikut adalah gambaran salah satu skema migrasi tabel relasional pada sistem:

<?php
Schema::create('kelas', function (Blueprint $table) {
    $table->id();
    $table->string('nama_kelas');
    
    // Relasi Data: Menghubungkan kelas ke tabel Users (Guru)
    // integrity constraint: Set Null jika akun user/guru dihapus
    $table->foreignId('guru_id')->nullable()->constrained('users')->nullOnDelete();
    
    $table->timestamps();
});
?>
