<?php
require_once 'koneksi.php';
function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
$nim = trim($_GET['nim'] ?? '');
if ($nim === '') {
    header('Location: index.php');
    exit;
}
$stmt = mysqli_prepare($koneksi, 'SELECT nim, nama, email, prodi, angkatan, ipk FROM mahasiswa WHERE nim = ?');
mysqli_stmt_bind_param($stmt, 's', $nim);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$data) {
    http_response_code(404);
    exit('Data mahasiswa tidak ditemukan. <a href="index.php">Kembali</a>');
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Edit Mahasiswa</title>
</head>

<body class="bg-slate-100 min-h-screen p-5 text-slate-800">
    <main class="max-w-xl mx-auto bg-white p-6 md:p-8 rounded-xl shadow-sm"><a href="index.php" class="text-blue-600 hover:underline text-sm">← Kembali ke daftar</a>
        <h1 class="text-2xl font-bold mt-3 mb-6">Edit Data Mahasiswa</h1>
        <form action="update.php" method="POST" class="space-y-4">
            <div><label for="nim" class="block text-sm font-semibold mb-1">NIM (tidak dapat diubah)</label><input id="nim" name="nim" value="<?= e($data['nim']) ?>" readonly class="w-full border border-slate-200 bg-slate-100 rounded-lg p-2.5"></div>
            <div><label for="nama" class="block text-sm font-semibold mb-1">Nama Lengkap</label><input id="nama" name="nama" value="<?= e($data['nama']) ?>" required maxlength="100" class="w-full border border-slate-300 rounded-lg p-2.5"></div>
            <div><label for="email" class="block text-sm font-semibold mb-1">Email</label><input id="email" name="email" type="email" value="<?= e($data['email']) ?>" required maxlength="120" class="w-full border border-slate-300 rounded-lg p-2.5"></div>
            <div><label for="prodi" class="block text-sm font-semibold mb-1">Program Studi</label><input id="prodi" name="prodi" value="<?= e($data['prodi']) ?>" required maxlength="80" class="w-full border border-slate-300 rounded-lg p-2.5"></div>
            <div><label for="angkatan" class="block text-sm font-semibold mb-1">Angkatan</label><input id="angkatan" name="angkatan" type="number" min="2000" max="2099" value="<?= e($data['angkatan']) ?>" required class="w-full border border-slate-300 rounded-lg p-2.5"></div>
            <div><label for="ipk" class="block text-sm font-semibold mb-1">IPK (0,00–4,00)</label><input id="ipk" name="ipk" type="number" min="0" max="4" step="0.01" value="<?= e($data['ipk']) ?>" required class="w-full border border-slate-300 rounded-lg p-2.5"></div>
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg">Simpan Perubahan</button>
        </form>
    </main>
</body>

</html>