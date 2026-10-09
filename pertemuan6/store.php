<?php
require_once 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create.php');
    exit;
}
$nim = trim($_POST['nim'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$prodi = trim($_POST['prodi'] ?? '');
$angkatan = (int)($_POST['angkatan'] ?? 0);
$ipk = filter_var($_POST['ipk'] ?? null, FILTER_VALIDATE_FLOAT);

// Modifikasi: validasi server-side untuk mencegah data tidak valid.
if ($nim === '' || $nama === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $prodi === '' || $angkatan < 2000 || $angkatan > 2099 || $ipk === false || $ipk < 0 || $ipk > 4) {
    http_response_code(422);
    exit('Data tidak valid. Periksa email, angkatan, dan IPK (0 sampai 4). <a href="create.php">Kembali</a>');
}
// Modifikasi: prepared statement dan pengecekan duplikasi NIM/email.
$cek = mysqli_prepare($koneksi, 'SELECT nim FROM mahasiswa WHERE nim = ? OR email = ? LIMIT 1');
mysqli_stmt_bind_param($cek, 'ss', $nim, $email);
mysqli_stmt_execute($cek);
$hasilCek = mysqli_stmt_get_result($cek);
if (mysqli_num_rows($hasilCek) > 0) {
    header('Location: create.php?pesan=duplikat');
    exit;
}
$stmt = mysqli_prepare($koneksi, 'INSERT INTO mahasiswa (nim, nama, email, prodi, angkatan, ipk) VALUES (?, ?, ?, ?, ?, ?)');
mysqli_stmt_bind_param($stmt, 'ssssid', $nim, $nama, $email, $prodi, $angkatan, $ipk);
if (mysqli_stmt_execute($stmt)) {
    header('Location: index.php?status=tambah');
    exit;
}
http_response_code(500);
echo 'Data gagal disimpan. Silakan periksa kembali data dan database.';
