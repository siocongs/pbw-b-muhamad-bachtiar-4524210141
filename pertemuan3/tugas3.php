<?php

// KONEKSI KE MYSQL

$host = '127.0.0.1';
$user = 'root';
$password = '';

$koneksi = mysqli_connect($host, $user, $password);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
echo "<h2>Koneksi ke server MySQL berhasil.</h2>";


// MEMBUAT DATABASE

$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS akademik";

if (mysqli_query($koneksi, $sqlCreateDB)) {
    echo "<p>Database akademik berhasil dibuat atau sudah tersedia.</p>";
} else {
    die("Gagal membuat database: " . mysqli_error($koneksi));
}


// MEMILIH DATABASE

mysqli_set_charset($koneksi, "utf8mb4");

if (!mysqli_select_db($koneksi, "akademik")) {
    die("Gagal memilih database akademik: " . mysqli_error($koneksi));
}


// MEMBUAT TABEL

$sqlCreateTables = [

    // Tabel mahasiswa
    "CREATE TABLE IF NOT EXISTS mahasiswa (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nim VARCHAR(15) NOT NULL UNIQUE,
        nama VARCHAR(100) NOT NULL,
        email VARCHAR(120) NOT NULL UNIQUE,
        prodi VARCHAR(80) NOT NULL,
        angkatan YEAR NOT NULL,
        ipk DECIMAL(3,2) DEFAULT 0.00,

        -- MODIFIKASI 1
        status VARCHAR(20) NOT NULL DEFAULT 'Aktif'
    ) ENGINE=InnoDB",

    // Tabel dosen
    "CREATE TABLE IF NOT EXISTS dosen (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nidn VARCHAR(20) NOT NULL UNIQUE,
        nama VARCHAR(100) NOT NULL,
        email VARCHAR(120) NOT NULL UNIQUE
    ) ENGINE=InnoDB",

    // Tabel mata kuliah
    "CREATE TABLE IF NOT EXISTS mata_kuliah (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        kode_mk VARCHAR(12) NOT NULL UNIQUE,
        nama_mk VARCHAR(100) NOT NULL,
        sks TINYINT UNSIGNED NOT NULL,
        dosen_id BIGINT UNSIGNED,

        -- MODIFIKASI 2
        semester TINYINT UNSIGNED NOT NULL DEFAULT 1,

        CONSTRAINT fk_mk_dosen
        FOREIGN KEY (dosen_id)
        REFERENCES dosen(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
    ) ENGINE=InnoDB",

    // Tabel KRS
    "CREATE TABLE IF NOT EXISTS krs (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        mahasiswa_id BIGINT UNSIGNED NOT NULL,
        semester TINYINT UNSIGNED NOT NULL,
        tahun_ajaran VARCHAR(9) NOT NULL,

        CONSTRAINT uq_krs
        UNIQUE (mahasiswa_id, semester, tahun_ajaran),

        CONSTRAINT fk_krs_mahasiswa
        FOREIGN KEY (mahasiswa_id)
        REFERENCES mahasiswa(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
    ) ENGINE=InnoDB",

    // Tabel penghubung KRS dan mata kuliah
    "CREATE TABLE IF NOT EXISTS mk_krs (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        krs_id BIGINT UNSIGNED NOT NULL,
        mata_kuliah_id BIGINT UNSIGNED NOT NULL,

        CONSTRAINT fk_mkkrs_krs
        FOREIGN KEY (krs_id)
        REFERENCES krs(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

        CONSTRAINT fk_mkkrs_mk
        FOREIGN KEY (mata_kuliah_id)
        REFERENCES mata_kuliah(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
    ) ENGINE=InnoDB"
];


// MENJALANKAN QUERY PEMBUATAN TABEL

foreach ($sqlCreateTables as $namaTabel => $query) {

    if (mysqli_query($koneksi, $query)) {
        echo "<p>✓ Tabel berhasil dibuat atau sudah tersedia.</p>";
    } else {
        echo "<p>✗ Gagal membuat tabel: "
            . htmlspecialchars(mysqli_error($koneksi))
            . "</p>";
    }
}


// INFORMASI DATABASE

echo "<hr>";
echo "<h3>Database Akademik Berhasil Disiapkan</h3>";

echo "<p>Database: <strong>akademik</strong></p>";

echo "<p>Tabel yang digunakan:</p>";

echo "<ul>
        <li>mahasiswa</li>
        <li>dosen</li>
        <li>mata_kuliah</li>
        <li>krs</li>
        <li>mk_krs</li>
      </ul>";

echo "<p>
    Modifikasi:
    <br>1. Menambahkan field status pada tabel mahasiswa.
    <br>2. Menambahkan field semester pada tabel mata_kuliah.
</p>";


// MENUTUP KONEKSI

mysqli_close($koneksi);

?>