<?php
require_once 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}
$nim = trim($_POST['nim'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$prodi = trim($_POST['prodi'] ?? '');
$angkatan = (int)($_POST['angkatan'] ?? 0);
$ipk = filter_var($_POST['ipk'] ?? null, FILTER_VALIDATE_FLOAT);

// Validasi server-side tetap dilakukan meskipun form memakai atribut HTML.
if ($nim === '' || $nama === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $prodi === '' || $angkatan < 2000 || $angkatan > 2099 || $ipk === false || $ipk < 0 || $ipk > 4) {
    http_response_code(422);
    exit('Data tidak valid. IPK harus berada pada rentang 0 sampai 4. <a href="index.php">Kembali</a>');
}
// Pastikan email tidak digunakan oleh mahasiswa lain.
$cek = mysqli_prepare($koneksi, 'SELECT nim FROM mahasiswa WHERE email = ? AND nim <> ? LIMIT 1');
mysqli_stmt_bind_param($cek, 'ss', $email, $nim);
mysqli_stmt_execute($cek);
if (mysqli_num_rows(mysqli_stmt_get_result($cek)) > 0) {
    exit('Email sudah digunakan mahasiswa lain. <a href="edit.php?nim=' . urlencode($nim) . '">Kembali</a>');
}
$stmt = mysqli_prepare($koneksi, 'UPDATE mahasiswa SET nama = ?, email = ?, prodi = ?, angkatan = ?, ipk = ? WHERE nim = ?');
mysqli_stmt_bind_param($stmt, 'sssids', $nama, $email, $prodi, $angkatan, $ipk, $nim);
// Tipe parameter mysqli harus berjumlah sama dengan parameter query.
if (mysqli_stmt_execute($stmt)) {
    header('Location: index.php?status=ubah');
    exit;
}
http_response_code(500);
echo 'Data gagal diubah. Periksa kembali data yang dimasukkan.';
