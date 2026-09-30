<?php

// TUGAS 2 PRAKTIKUM PEMROGRAMAN BERBASIS WEB
// Pertemuan 2 - OOP PHP


// CONTOH 1 - IDENTITAS MAHASISWA
interface Identitas
{
    public function ringkasan(): string;
}


class Mahasiswa implements Identitas
{
    private string $nim;
    private string $nama;
    protected float $ipk;

    public function __construct(
        string $nim,
        string $nama,
        float $ipk
    ) {
        $this->nim = $nim;
        $this->nama = $nama;
        $this->setIpk($ipk);
    }

    public function setIpk(float $ipk): void
    {
        if ($ipk < 0 || $ipk > 4) {
            throw new InvalidArgumentException(
                'IPK harus berada di antara 0 sampai 4.'
            );
        }

        $this->ipk = $ipk;
    }

    public function getIpk(): float
    {
        return $this->ipk;
    }

    public function ringkasan(): string
    {
        return $this->nim
            . ' - '
            . $this->nama
            . ' - IPK: '
            . $this->ipk;
    }


    // MODIFIKASI 1
    // Menambahkan predikat berdasarkan IPK
    public function predikat(): string
    {
        if ($this->ipk >= 3.50) {
            return 'Sangat Memuaskan';
        }

        if ($this->ipk >= 3.00) {
            return 'Memuaskan';
        }

        return 'Perlu Peningkatan';
    }
}


$mhs = new Mahasiswa(
    '4524210141',
    'Muhamad Bachtiar',
    3.75
);


// CONTOH 2 - PRODUK
interface BisaDihitung
{
    public function hargaAkhir(): float;
}


class Produk implements BisaDihitung
{
    public function __construct(
        protected string $nama,
        protected float $harga,
        protected string $kategori
    ) {
    }

    public function hargaAkhir(): float
    {
        return $this->harga;
    }

    public function getNama(): string
    {
        return $this->nama;
    }

    public function getKategori(): string
    {
        return $this->kategori;
    }
}


class ProdukDiskon extends Produk
{
    public function __construct(
        string $nama,
        float $harga,
        string $kategori,
        private float $diskon
    ) {
        parent::__construct($nama, $harga, $kategori);

        // MODIFIKASI 2
        // Validasi diskon
        if ($diskon < 0 || $diskon > 100) {
            throw new InvalidArgumentException(
                'Diskon harus berada di antara 0 sampai 100 persen.'
            );
        }
    }

    public function hargaAkhir(): float
    {
        return $this->harga * (1 - $this->diskon / 100);
    }

    public function getDiskon(): float
    {
        return $this->diskon;
    }
}



// DATA PRODUK
$daftar = [
    new Produk(
        'Keyboard',
        250000,
        'Aksesoris'
    ),

    new ProdukDiskon(
        'Mouse',
        150000,
        'Aksesoris',
        10
    ),

    new ProdukDiskon(
        'Headset',
        300000,
        'Audio',
        15
    )
];


// OUTPUT
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tugas 2 Praktikum PBW</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 30px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
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

        .item {
            padding: 12px;
            margin-bottom: 10px;
            background: #f8f9fa;
            border-radius: 8px;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>Tugas 2 Praktikum PBW</h1>

    <div class="card">

        <h2>Identitas Mahasiswa</h2>

        <p>
            <?= htmlspecialchars($mhs->ringkasan()) ?>
        </p>

        <p>
            <strong>Predikat:</strong>
            <?= htmlspecialchars($mhs->predikat()) ?>
        </p>

    </div>


    <div class="card">

        <h2>Daftar Produk</h2>

        <?php foreach ($daftar as $produk): ?>

            <div class="item">

                <strong>
                    <?= htmlspecialchars($produk->getNama()) ?>
                </strong>

                <br>

                Kategori:
                <?= htmlspecialchars($produk->getKategori()) ?>

                <br>

                Harga:
                Rp
                <?= number_format(
                    $produk->hargaAkhir(),
                    0,
                    ',',
                    '.'
                ) ?>

                <?php if ($produk instanceof ProdukDiskon): ?>

                    <br>

                    Diskon:
                    <?= $produk->getDiskon() ?>%

                <?php endif; ?>

            </div>

        <?php endforeach; ?>

    </div>

</div>

</body>

</html>