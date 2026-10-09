# Tugas Pertemuan 6 — CRUD PHP

## Identitas
- **Nama:** Muhamad Bachtiar
- **NIM:** 4524210141
- **Program Studi:** Teknik Informatika
- **Mata Kuliah:** Pemrograman Berbasis Web
- **Pertemuan:** 6
- **Materi:** CRUD PHP dan MySQL

## Deskripsi
Program ini mengelola data mahasiswa menggunakan PHP dan MySQL. Fitur yang tersedia adalah menampilkan, menambahkan, mengubah, mencari, dan menghapus data mahasiswa.

## Struktur Folder
```text
tugas pertemuan 6/
├── index.php
├── create.php
├── store.php
├── edit.php
├── update.php
├── delete.php
├── koneksi.php
└── README.md
```

## Modifikasi Bermakna
1. **Pencarian data mahasiswa** — `index.php` menyediakan pencarian berdasarkan NIM, nama, atau program studi. Query memakai prepared statement.
2. **Validasi dan keamanan input** — `store.php` dan `update.php` memvalidasi email, tahun angkatan, serta IPK 0–4 di sisi server; query tambah/ubah/hapus memakai prepared statement.
3. **Predikat IPK otomatis** — `index.php` menampilkan predikat berdasarkan IPK: Sangat Baik (≥3,50), Baik (≥3,00), Cukup (≥2,00), atau Perlu Evaluasi.
4. **Konfirmasi dan metode penghapusan lebih aman** — `index.php` meminta konfirmasi dan mengirim permintaan hapus melalui POST ke `delete.php`, bukan tautan GET.
5. **Pengecekan data ganda** — `store.php` menolak NIM atau email yang telah digunakan; `update.php` mencegah email dipakai oleh mahasiswa lain.

## Lima Bagian Kode Penting
1. **`koneksi.php` — koneksi database:** `mysqli_connect()` menghubungkan aplikasi dengan database `akademik`, lalu `mysqli_set_charset()` menetapkan UTF-8.
2. **`index.php` — membaca dan menampilkan data:** query SELECT mengambil data mahasiswa. `while` membaca setiap baris, sedangkan `htmlspecialchars()` membantu mencegah HTML dari data tersimpan dieksekusi saat ditampilkan.
3. **`create.php` — form input:** form mengirim data menggunakan metode POST ke `store.php`; atribut `required`, `type="email"`, `min`, dan `max` membantu validasi awal di browser.
4. **`store.php` — menambah data:** validasi dilakukan sebelum query INSERT. Prepared statement memisahkan perintah SQL dari nilai input pengguna.
5. **`edit.php`, `update.php`, dan `delete.php` — ubah/hapus:** `edit.php` mengambil data sesuai NIM, `update.php` menjalankan UPDATE, dan `delete.php` menjalankan DELETE setelah menerima POST.

## Screenshot Sebelum dan Sesudah
Simpan screenshot hasil uji ke folder `screenshots/` dengan nama berikut:
- `screenshots/sebelum.png` — tampilan program asli sebelum modifikasi.
- `screenshots/sesudah.png` — tampilan program setelah modifikasi, sebaiknya memperlihatkan pencarian dan kolom predikat IPK.
- `screenshots/tambah-data.png` — opsional, bukti form tambah data.
- `screenshots/validasi-ipk.png` — opsional, bukti penolakan IPK di luar rentang 0–4.

> Screenshot harus diambil dari aplikasi yang benar-benar dijalankan. Placeholder screenshot tidak disertakan karena perlu diambil dari lingkungan XAMPP milik sendiri.

## Error, Penyebab, dan Perbaikan
**Error:** `Duplicate entry ... for key 'nim'` atau `Duplicate entry ... for key 'email'`.

**Penyebab:** NIM atau email yang dimasukkan sudah ada di tabel `mahasiswa`, sedangkan kolom tersebut memiliki aturan UNIQUE.

**Perbaikan:** Gunakan NIM dan email yang belum terdaftar. Pada versi modifikasi, `store.php` memeriksa NIM/email sebelum INSERT dan menampilkan pesan duplikasi melalui halaman form. Batasan UNIQUE di database tetap dipertahankan agar data ganda tidak tersimpan.

## Catatan
Program mengasumsikan tabel `mahasiswa` pada database `akademik` memiliki kolom `nim`, `nama`, `email`, `prodi`, `angkatan`, dan `ipk` seperti pada file SQL praktikum. Tailwind CSS dimuat melalui CDN sehingga membutuhkan koneksi internet saat membuka halaman.
