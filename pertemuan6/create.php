<?php
require_once 'koneksi.php';
function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
$pesan = $_GET['pesan'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Tambah Mahasiswa</title>
</head>

<body class="bg-slate-100 min-h-screen p-5 text-slate-800">
    <main class="max-w-xl mx-auto bg-white p-6 md:p-8 rounded-xl shadow-sm">
        <a href="index.php" class="text-blue-600 hover:underline text-sm">← Kembali ke daftar</a>
        <h1 class="text-2xl font-bold mt-3 mb-1">Tambah Mahasiswa</h1>
        <p class="text-slate-500 mb-6">Isi data mahasiswa dengan benar.</p>
        <?php if ($pesan === 'duplikat'): ?><div class="bg-red-50 text-red-700 p-3 rounded-lg mb-4">NIM atau email sudah terdaftar. Gunakan data yang berbeda.</div><?php endif; ?>
        <form action="store.php" method="POST" class="space-y-4">
            <div><label for="nim" class="block text-sm font-semibold mb-1">NIM</label><input id="nim" name="nim" required maxlength="15" class="w-full border border-slate-300 rounded-lg p-2.5" placeholder="Contoh: 4524210141"></div>
            <div><label for="nama" class="block text-sm font-semibold mb-1">Nama Lengkap</label><input id="nama" name="nama" required maxlength="100" class="w-full border border-slate-300 rounded-lg p-2.5"></div>
            <div><label for="email" class="block text-sm font-semibold mb-1">Email</label><input id="email" name="email" type="email" required maxlength="120" class="w-full border border-slate-300 rounded-lg p-2.5"></div>
            <div><label for="prodi" class="block text-sm font-semibold mb-1">Program Studi</label><input id="prodi" name="prodi" required maxlength="80" class="w-full border border-slate-300 rounded-lg p-2.5" value="Teknik Informatika"></div>
            <div><label for="angkatan" class="block text-sm font-semibold mb-1">Angkatan</label><input id="angkatan" name="angkatan" type="number" min="2000" max="2099" required class="w-full border border-slate-300 rounded-lg p-2.5" value="2026"></div>
            <div><label for="ipk" class="block text-sm font-semibold mb-1">IPK (0,00–4,00)</label><input id="ipk" name="ipk" type="number" min="0" max="4" step="0.01" required class="w-full border border-slate-300 rounded-lg p-2.5" value="0.00"></div>
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg">Simpan Data</button>
        </form>
    </main>
</body>

</html>