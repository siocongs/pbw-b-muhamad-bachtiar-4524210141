<?php

// TUGAS 1 PRAKTIKUM PEMROGRAMAN BERBASIS WEB
// Pertemuan 1


// CONTOH 1 - KALKULATOR SEDERHANA

$hasil = null;
$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $a = (float) ($_POST['a'] ?? 0);
    $b = (float) ($_POST['b'] ?? 0);
    $operator = $_POST['operator'] ?? '+';

    switch ($operator) {

        case '+':
            $hasil = $a + $b;
            break;

        case '-':
            $hasil = $a - $b;
            break;

        case '*':
            $hasil = $a * $b;
            break;

        case '/':
            if ($b == 0) {
                $pesan = 'Pembagian dengan nol tidak diperbolehkan.';
            } else {
                $hasil = $a / $b;
            }
            break;

        default:
            $pesan = 'Operator tidak valid.';
    }
}

// CONTOH 2 - BIODATA MAHASISWA

function statusKelulusan(float $ipk): string
{
    if ($ipk >= 3.50) {
        return 'Sangat Memuaskan';
    }

    if ($ipk >= 3.00) {
        return 'Memuaskan';
    }

    return 'Perlu Peningkatan';
}


// MODIFIKASI 1
// Menambahkan validasi nilai IPK

$pesanIpk = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ipk'])) {

    $ipkInput = (float) $_POST['ipk'];

    if ($ipkInput < 0 || $ipkInput > 4) {
        $pesanIpk = 'IPK harus berada di antara 0.00 sampai 4.00.';
    }
}


// DATA BIODATA

$mahasiswa = [
    'nim' => '4524210141',
    'nama' => 'Muhamad Bachtiar',
    'prodi' => 'Teknik Informatika',
    'semester' => 5,    
    'ipk' => 3.89,
    'email' => 'muhamad.bachtiar@example.com'
];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tugas 1 Praktikum PBW</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .card {
            background-color: white;
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            text-align: center;
        }

        h2 {
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        input,
        select,
        button {
            padding: 10px;
            font-size: 15px;
        }

        button {
            cursor: pointer;
        }

        .hasil {
            margin-top: 15px;
            padding: 12px;
            background-color: #e8f5e9;
            border-radius: 8px;
        }

        .error {
            margin-top: 15px;
            padding: 12px;
            background-color: #ffebee;
            color: #c62828;
            border-radius: 8px;
        }

        ul {
            line-height: 1.8;
        }
    </style>

</head>

<body>

    <div class="container">

        <h1>Tugas 1 Praktikum PBW</h1>

        <!-- KALKULATOR -->

        <div class="card">

            <h2>Kalkulator Sederhana</h2>

            <form method="post">

                <input
                    type="number"
                    step="any"
                    name="a"
                    placeholder="Angka pertama"
                    required>

                <select name="operator">

                    <option value="+">+</option>
                    <option value="-">-</option>
                    <option value="*">*</option>
                    <option value="/">/</option>

                </select>

                <input
                    type="number"
                    step="any"
                    name="b"
                    placeholder="Angka kedua"
                    required>

                <button type="submit">
                    Hitung
                </button>

            </form>


            <?php if ($pesan): ?>

                <div class="error">

                    <?= htmlspecialchars($pesan) ?>

                </div>

            <?php elseif ($hasil !== null): ?>

                <div class="hasil">

                    Hasil:
                    <strong>
                        <?= htmlspecialchars((string) $hasil) ?>
                    </strong>

                </div>

            <?php endif; ?>

        </div>


        <!-- BIODATA -->

        <div class="card">

            <h2>Biodata Mahasiswa</h2>

            <ul>

                <?php foreach ($mahasiswa as $kunci => $nilai): ?>

                    <li>

                        <?= htmlspecialchars(ucfirst($kunci)) ?> :
                        <?= htmlspecialchars((string) $nilai) ?>

                    </li>

                <?php endforeach; ?>

            </ul>

            <p>

                <strong>Predikat:</strong>

                <?= htmlspecialchars(
                    statusKelulusan($mahasiswa['ipk'])
                ) ?>

            </p>

        </div>


        <!-- MODIFIKASI IPK -->

        <div class="card">

            <h2>Validasi IPK</h2>

            <form method="post">

                <input
                    type="number"
                    name="ipk"
                    min="0"
                    max="4"
                    step="0.01"
                    placeholder="Masukkan IPK"
                    required>

                <button type="submit">
                    Validasi IPK
                </button>

            </form>


            <?php if ($pesanIpk): ?>

                <div class="error">

                    <?= htmlspecialchars($pesanIpk) ?>

                </div>

            <?php endif; ?>

        </div>

    </div>

</body>

</html>