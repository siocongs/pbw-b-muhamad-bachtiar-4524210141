<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data Mahasiswa</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f6fb; margin: 0; padding: 32px; color: #1f2937; }
        .container { max-width: 560px; margin: auto; background: #fff; padding: 28px; border-radius: 12px; box-shadow: 0 5px 18px #00000012; }
        h1 { margin-top: 0; color: #174ea6; }
        label { display: block; margin: 14px 0 6px; font-weight: 600; }
        input { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; }
        button { margin-top: 20px; padding: 11px 18px; border: 0; border-radius: 6px; background: #1769e0; color: white; cursor: pointer; }
        button:hover { background: #1254b8; }
        .note { color: #64748b; font-size: 13px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Form Data Mahasiswa</h1>
    <p class="note">Isi data mahasiswa dengan benar sebelum menyimpan.</p>
    <form action="simpan.php" method="post">
        <label for="nim">NIM</label>
        <input id="nim" type="text" name="nim" required minlength="5" maxlength="15" pattern="[0-9]+" title="NIM harus berupa angka, minimal 5 digit dan maksimal 15 digit">

        <label for="nama">Nama</label>
        <input id="nama" type="text" name="nama" required maxlength="100">

        <label for="email">Email</label>
        <input id="email" type="email" name="email" required maxlength="120">

        <label for="prodi">Program Studi</label>
        <input id="prodi" type="text" name="prodi" required maxlength="80">

        <label for="angkatan">Angkatan</label>
        <input id="angkatan" type="number" name="angkatan" required min="2000" max="2100">

        <label for="ipk">IPK</label>
        <input id="ipk" type="number" name="ipk" required min="0" max="4" step="0.01">

        <button type="submit">Simpan Data</button>
    </form>
</div>
</body>
</html>
