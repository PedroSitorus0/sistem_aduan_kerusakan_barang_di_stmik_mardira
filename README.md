# Sistem Manajemen Pengaduan Fasilitas Kampus
### STMIK Mardira Indonesia

---

## Tujuan Inti Aplikasi
Menyediakan platform terpusat bagi mahasiswa, dosen, dan pegawai untuk melaporkan kerusakan fasilitas kampus. Laporan akan dikelola oleh administrator, ditugaskan kepada teknisi, dan dipantau penyelesaiannya secara transparan. Developer berperan sebagai pengawas sistem tanpa intervensi operasional.

---

## Pembagian Peran (Role)

| Role        | Tanggung Jawab Utama                                                                 |
|-------------|--------------------------------------------------------------------------------------|
| **User**    | Melaporkan kerusakan, melihat status pengaduan sendiri                              |
| **Admin**   | Mengelola semua pengaduan, menugaskan teknisi, mengelola data master (lokasi, kategori, pengguna) |
| **Teknisi** | Menerima tugas, memperbarui progres perbaikan, menyelesaikan pengaduan              |
| **Dev**     | Mengawasi sistem melalui `system_logs`, mengelola data master, **tidak bisa mengakses/mengelola teknisi** |

---

## Alur Kerja Utama

1. **Pelapor (User)** mengajukan pengaduan via form → status `menunggu`.
2. **Admin** meninjau laporan:
   - Jika valid → ubah status ke `diproses` + tentukan teknisi (`assigned_to`).
   - Jika tidak valid → ubah status ke `ditolak` + alasan di log.
3. **Teknisi** melihat pengaduan yang ditugaskan, memberi catatan progres, dan menyelesaikan → status `selesai` + `resolved_at` tercatat.
4. **Setiap perubahan status** dicatat di tabel `complaint_logs` (actor, status lama, status baru, pesan).
5. **Dev** dapat melihat semua pengaduan & `system_logs`, tetapi tidak bisa melihat data teknisi atau menugaskan.

---

## Fitur Utama

### Semua Role
- [x] Login/Register (multi-role)
- [x] Notifikasi perubahan status

### User (Pelapor)
- [x] Membuat pengaduan (judul, deskripsi, kategori, lokasi, foto)
- [x] Riwayat pengaduan pribadi
- [x] Melihat log penanganan

### Admin
- [x] Dashboard semua pengaduan (filter status)
- [x] Ubah status & tugaskan teknisi
- [x] CRUD data master (lokasi, kategori, user)
- [x] Akses `complaint_logs`

### Teknisi
- [x] Dashboard pengaduan khusus miliknya
- [x] Kirim catatan progres (log_message)
- [x] Menyelesaikan pengaduan

### Dev
- [x] Melihat semua pengaduan (tanpa akses assign teknisi)
- [x] Mengelola data master (kecuali data teknisi)
- [x] Akses penuh `system_logs`

---

## Ringkasan Struktur Database

| Tabel              | Fungsi |
|--------------------|--------|
| `users`            | Autentikasi & identitas (role: user, admin, dev, teknisi) |
| `locations`        | Data ruangan (kode unik: `R213`, `G07` → gedung diekstrak otomatis) |
| `categories`       | Jenis kerusakan (listrik, AC, proyektor, dll) |
| `complaints`       | Data utama pengaduan (relasi ke pelapor, lokasi, kategori, teknisi) |
| `complaint_photos` | Multi-foto pengaduan |
| `complaint_logs`   | Riwayat perubahan status (actor, old_status, new_status, pesan) |
| `system_logs`      | Log error/warning/info untuk debugging dev |

---

## Teknologi

- **Backend:** Laravel 12 + MySQL
- **Frontend:** Blade + Tailwind CSS + Alpine.js
- **Autentikasi:** Laravel Breeze
- **Testing:** PHPUnit

---

## Milestone Pengerjaan

| Tahap | Deskripsi | Status |
|-------|-----------|--------|
| **1. Setup** | Instalasi Laravel, Breeze, konfigurasi database | ✅ Selesai |
| **2. Migrations** | Membuat 7 tabel sesuai skema | ✅ Selesai |
| **3. Models** | Model + relasi Eloquent | ✅ Selesai |
| **4. Controllers** | Controller per modul (User, Complaint, Admin, Teknisi, Dev) | 🔄 Saat Ini |
| **5. Views** | Blade template (dashboard, form, notifikasi) | ⏳ Mendatang |
| **6. Testing** | Unit & integration test | ⏳ Mendatang |
| **7. Deployment** | Hosting + production setup | ⏳ Mendatang |

---

## Struktur Direktori Penting
app/
├── Models/
│ ├── User.php
│ ├── Location.php
│ ├── Category.php
│ ├── Complaint.php
│ ├── ComplaintPhoto.php
│ ├── ComplaintLog.php
│ └── SystemLog.php
├── Http/Controllers/
│ ├── Auth/
│ │ └── RegisteredUserController.php
│ ├── DashboardController.php
│ ├── ComplaintController.php
│ ├── CategoryController.php
│ ├── LocationController.php
│ ├── UserManagementController.php
│ └── SystemLogController.php

---

## Kontributor
