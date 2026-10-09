<?php
require_once 'koneksi.php';

// Modifikasi: fitur pencarian berdasarkan NIM, nama, atau program studi.
$cari = trim($_GET['cari'] ?? '');
if ($cari !== '') {
    $kata = '%' . $cari . '%';
    $stmt = mysqli_prepare($koneksi, 'SELECT nim, nama, email, prodi, angkatan, ipk FROM mahasiswa WHERE nim LIKE ? OR nama LIKE ? OR prodi LIKE ? ORDER BY nama ASC');
    mysqli_stmt_bind_param($stmt, 'sss', $kata, $kata, $kata);
} else {
    $stmt = mysqli_prepare($koneksi, 'SELECT nim, nama, email, prodi, angkatan, ipk FROM mahasiswa ORDER BY nama ASC');
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
function e($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function predikat($ipk) {
    if ($ipk >= 3.50) return 'Sangat Baik';
    if ($ipk >= 3.00) return 'Baik';
    if ($ipk >= 2.00) return 'Cukup';
    return 'Perlu Evaluasi';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<title>Data Mahasiswa | CRUD</title>
</head>
<body class="bg-slate-100 min-h-screen p-4 md:p-8 text-slate-800">
<main class="max-w-6xl mx-auto bg-white rounded-xl shadow-sm p-5 md:p-8">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div><p class="text-sm font-semibold text-blue-600">PRAKTIKUM PBW • PERTEMUAN 6</p><h1 class="text-3xl font-bold mt-1">Data Mahasiswa</h1><p class="text-slate-500 mt-1">Kelola data akademik dengan fitur CRUD.</p></div>
    <a href="create.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg font-semibold text-center">+ Tambah Mahasiswa</a>
  </div>
  <?php $status = $_GET['status'] ?? ''; $notifikasi = ['tambah'=>'Data mahasiswa berhasil ditambahkan.', 'ubah'=>'Data mahasiswa berhasil diperbarui.', 'hapus'=>'Data mahasiswa berhasil dihapus.', 'gagal_hapus'=>'Data tidak ditemukan atau gagal dihapus.']; if (isset($notifikasi[$status])): ?><div class="mb-4 rounded-lg bg-blue-50 text-blue-700 p-3"><?= e($notifikasi[$status]) ?></div><?php endif; ?>
  <form method="GET" class="flex flex-col sm:flex-row gap-2 mb-5">
    <input type="search" name="cari" value="<?= e($cari) ?>" placeholder="Cari NIM, nama, atau prodi..." class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
    <button class="bg-slate-800 hover:bg-slate-700 text-white rounded-lg px-5 py-2">Cari</button>
    <?php if ($cari !== ''): ?><a href="index.php" class="border border-slate-300 rounded-lg px-4 py-2 text-center">Reset</a><?php endif; ?>
  </form>
  <div class="overflow-x-auto">
  <table class="w-full text-sm border-collapse">
    <thead class="bg-slate-100 text-left"><tr>
      <th class="p-3 border border-slate-200">NIM</th><th class="p-3 border border-slate-200">Nama</th><th class="p-3 border border-slate-200">Email</th><th class="p-3 border border-slate-200">Program Studi</th><th class="p-3 border border-slate-200">Angkatan</th><th class="p-3 border border-slate-200">IPK</th><th class="p-3 border border-slate-200">Predikat</th><th class="p-3 border border-slate-200">Aksi</th>
    </tr></thead><tbody>
    <?php if (mysqli_num_rows($result) === 0): ?>
      <tr><td colspan="8" class="p-6 text-center text-slate-500 border border-slate-200">Data mahasiswa tidak ditemukan.</td></tr>
    <?php else: while ($data = mysqli_fetch_assoc($result)): ?>
      <tr class="hover:bg-blue-50">
        <td class="p-3 border border-slate-200 whitespace-nowrap"><?= e($data['nim']) ?></td><td class="p-3 border border-slate-200"><?= e($data['nama']) ?></td><td class="p-3 border border-slate-200"><?= e($data['email']) ?></td><td class="p-3 border border-slate-200"><?= e($data['prodi']) ?></td><td class="p-3 border border-slate-200"><?= e($data['angkatan']) ?></td><td class="p-3 border border-slate-200"><?= number_format((float)$data['ipk'], 2, ',', '.') ?></td><td class="p-3 border border-slate-200"><?= e(predikat((float)$data['ipk'])) ?></td>
        <td class="p-3 border border-slate-200 whitespace-nowrap"><a class="text-blue-600 font-semibold hover:underline" href="edit.php?nim=<?= urlencode($data['nim']) ?>">Edit</a><span class="text-slate-300 mx-1">|</span><form class="inline" action="delete.php" method="POST" onsubmit="return confirm('Yakin ingin menghapus data <?= e($data['nama']) ?>?')"><input type="hidden" name="nim" value="<?= e($data['nim']) ?>"><button class="text-red-600 font-semibold hover:underline">Hapus</button></form></td>
      </tr>
    <?php endwhile; endif; ?>
    </tbody>
  </table></div>
  <p class="text-xs text-slate-500 mt-4">Jumlah data ditampilkan: <?= mysqli_num_rows($result) ?>. Predikat IPK dihitung otomatis oleh program.</p>
</main></body></html>
