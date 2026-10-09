<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Metode permintaan tidak diizinkan.");
}

// Ambil dan rapikan input dari form.
$nim = trim($_POST['nim'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$prodi = trim($_POST['prodi'] ?? '');
$angkatan = filter_var($_POST['angkatan'] ?? null, FILTER_VALIDATE_INT);
$ipk = filter_var($_POST['ipk'] ?? null, FILTER_VALIDATE_FLOAT);

// Validasi server-side agar data tetap diperiksa meskipun validasi browser dilewati.
if (!preg_match('/^[0-9]{5,15}$/', $nim)) {
    exit("NIM harus berupa angka dengan panjang 5 sampai 15 digit.");
}
if ($nama === '' || strlen($nama) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Nama atau format email tidak valid.");
}
if ($prodi === '' || strlen($prodi) > 80) {
    exit("Program studi wajib diisi dan maksimal 80 karakter.");
}
if ($angkatan === false || $angkatan < 2000 || $angkatan > 2100) {
    exit("Angkatan harus berada pada rentang 2000 sampai 2100.");
}
if ($ipk === false || $ipk < 0 || $ipk > 4) {
    exit("IPK harus berada pada rentang 0.00 sampai 4.00.");
}

// Prepared statement mencegah input pengguna langsung digabung ke query SQL.
$stmt = mysqli_prepare(
    $koneksi,
    "INSERT INTO mahasiswa (nim, nama, email, prodi, angkatan, ipk) VALUES (?, ?, ?, ?, ?, ?)"
);
mysqli_stmt_bind_param($stmt, "ssssid", $nim, $nama, $email, $prodi, $angkatan, $ipk);


try {
    if (mysqli_stmt_execute($stmt)) {
        $namaAman = htmlspecialchars($nama, ENT_QUOTES, 'UTF-8');
        $nimAman = htmlspecialchars($nim, ENT_QUOTES, 'UTF-8');
        echo "<!DOCTYPE html><html lang='id'><meta charset='UTF-8'><title>Status Simpan</title>";
        echo "<body style='font-family:Arial,sans-serif;max-width:650px;margin:50px auto;padding:24px;background:#f3f6fb'>";
        echo "<h2 style='color:#16794b'>Data mahasiswa berhasil disimpan.</h2>";
        echo "<p>NIM: <strong>{$nimAman}</strong></p><p>Nama: <strong>{$namaAman}</strong></p>";
        echo "<p><a href='form.php'>Kembali ke form</a> | <a href='data.php'>Lihat data mahasiswa</a></p></body></html>";
    }
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) {
        echo "<h3 style='color:red'>NIM sudah terdaftar. Gunakan NIM yang berbeda.</h3>";
    } else {
        echo "Terjadi kesalahan saat menyimpan data.";
    }
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);
