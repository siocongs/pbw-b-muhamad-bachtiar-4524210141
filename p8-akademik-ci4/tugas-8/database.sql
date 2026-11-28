-- Database akademik mengikuti konfigurasi praktikum pada materi Pertemuan 8.
-- Pastikan database akademik sudah dibuat, lalu jalankan file SQL ini di phpMyAdmin.

USE akademik;

CREATE TABLE IF NOT EXISTS mahasiswa_tugas8 (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    prodi VARCHAR(100) NOT NULL,
    ipk DECIMAL(3,2) NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    CONSTRAINT chk_mahasiswa_tugas8_ipk CHECK (ipk >= 0 AND ipk <= 4)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO mahasiswa_tugas8 (nim, nama, prodi, ipk) VALUES
('2026001', 'Andi', 'Teknik Informatika', 3.75),
('4523210083', 'Naufal Maulana Saputra', 'Teknik Informatika', 3.50),
('4523210081', 'Zaidan Abhab', 'Teknik Informatika', 3.55);
