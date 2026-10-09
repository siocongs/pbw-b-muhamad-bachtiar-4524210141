<?php
require_once 'koneksi.php';
// Modifikasi: hanya menerima permintaan penghapusan melalui POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}
$nim = trim($_POST['nim'] ?? '');
if ($nim === '') {
    header('Location: index.php');
    exit;
}
$stmt = mysqli_prepare($koneksi, 'DELETE FROM mahasiswa WHERE nim = ?');
mysqli_stmt_bind_param($stmt, 's', $nim);
if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0) {
    header('Location: index.php?status=hapus');
    exit;
}
header('Location: index.php?status=gagal_hapus');
exit;
