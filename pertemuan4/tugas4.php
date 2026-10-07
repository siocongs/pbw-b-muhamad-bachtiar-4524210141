<?php


// KONFIGURASI KONEKSI


$host = "127.0.0.1";
$user = "root";
$password = "";
$database = "akademik";

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

echo "Koneksi ke server MySQL berhasil.<br><br>";



// 1. INSERT
// Menambahkan data mahasiswa

$sqlInsert = "
    INSERT IGNORE INTO mahasiswa
    (nim, nama, email, prodi, angkatan, ipk)
    VALUES
    ('2026001', 'Andi Pratama', 'andi@kampus.ac.id', 'Teknik Informatika', 2026, 3.75),
    ('2026002', 'Siti Rahma', 'siti@kampus.ac.id', 'Sistem Informasi', 2026, 3.82),
    ('2025003', 'Budi Santoso', 'budi@kampus.ac.id', 'Teknik Informatika', 2025, 3.20)
";

echo "<h2>1. INSERT - Menambahkan Data</h2>";

if (mysqli_query($koneksi, $sqlInsert)) {
    echo "<p>Data mahasiswa berhasil dimasukkan ke database.</p>";
} else {
    echo "<p>Gagal memasukkan data: " . mysqli_error($koneksi) . "</p>";
}


// 2. SELECT & WHERE
// Membaca data mahasiswa

echo "<h2>2. SELECT & WHERE - Membaca Data</h2>";

// MODIFIKASI 1:
// Filter minimum IPK dan program studi
$minIpk = isset($_GET['min_ipk']) ? (float) $_GET['min_ipk'] : 3.50;
$prodi = isset($_GET['prodi']) ? trim($_GET['prodi']) : "";

$sqlSelect = "
    SELECT nim, nama, prodi, ipk
    FROM mahasiswa
    WHERE ipk >= ?
";

$params = [$minIpk];
$types = "d";

if ($prodi !== "") {
    $sqlSelect .= " AND prodi = ?";
    $params[] = $prodi;
    $types .= "s";
}

$sqlSelect .= " ORDER BY ipk DESC, nama ASC LIMIT 10";

$stmt = mysqli_prepare($koneksi, $sqlSelect);

if ($stmt) {

    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {

        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr>";
        echo "<th>NIM</th>";
        echo "<th>Nama</th>";
        echo "<th>Program Studi</th>";
        echo "<th>IPK</th>";
        echo "<th>Predikat</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_assoc($result)) {

            // MODIFIKASI 2:
            // Menentukan predikat berdasarkan IPK
            if ($row['ipk'] >= 3.50) {
                $predikat = "Sangat Memuaskan";
            } elseif ($row['ipk'] >= 3.00) {
                $predikat = "Memuaskan";
            } else {
                $predikat = "Perlu Peningkatan";
            }

            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['nim']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
            echo "<td>" . htmlspecialchars($row['prodi']) . "</td>";
            echo "<td>" . htmlspecialchars($row['ipk']) . "</td>";
            echo "<td>" . $predikat . "</td>";
            echo "</tr>";
        }

        echo "</table>";

    } else {
        echo "<p>Tidak ada data mahasiswa yang memenuhi kriteria.</p>";
    }

    mysqli_stmt_close($stmt);

} else {
    echo "<p>Query SELECT gagal: " . mysqli_error($koneksi) . "</p>";
}



// FORM FILTER


echo "<h3>Filter Data Mahasiswa</h3>";

echo "
<form method='get'>

    <label>Minimum IPK:</label>
    <input
        type='number'
        name='min_ipk'
        step='0.01'
        min='0'
        max='4'
        value='" . htmlspecialchars($minIpk) . "'
    >

    <label>Program Studi:</label>
    <select name='prodi'>

        <option value=''>Semua Prodi</option>

        <option value='Teknik Informatika'
            " . ($prodi === 'Teknik Informatika' ? 'selected' : '') . ">
            Teknik Informatika
        </option>

        <option value='Sistem Informasi'
            " . ($prodi === 'Sistem Informasi' ? 'selected' : '') . ">
            Sistem Informasi
        </option>

    </select>

    <button type='submit'>Filter</button>

</form>
";



// 3. UPDATE
// Mengubah IPK mahasiswa

echo "<h2>3. UPDATE - Mengubah Data</h2>";

$sqlUpdate = "
    UPDATE mahasiswa
    SET ipk = 3.40
    WHERE nim = '2025003'
";

if (mysqli_query($koneksi, $sqlUpdate)) {

    echo "
        <p>
            Data mahasiswa dengan NIM 2025003
            berhasil diubah menjadi IPK 3.40.
        </p>
    ";

} else {

    echo "
        <p>
            Gagal melakukan UPDATE:
            " . mysqli_error($koneksi) . "
        </p>
    ";
}



// 4. GROUP BY
// Rekap jumlah mahasiswa per prodi

echo "<h2>4. GROUP BY - Rekap Mahasiswa per Prodi</h2>";

$sqlRekap = "
    SELECT
        prodi,
        COUNT(*) AS jumlah,
        ROUND(AVG(ipk), 2) AS rata_ipk
    FROM mahasiswa
    GROUP BY prodi
    ORDER BY jumlah DESC
";

$resultRekap = mysqli_query($koneksi, $sqlRekap);

if ($resultRekap && mysqli_num_rows($resultRekap) > 0) {

    echo "<table border='1' cellpadding='8' cellspacing='0'>";

    echo "<tr>";
    echo "<th>Program Studi</th>";
    echo "<th>Jumlah Mahasiswa</th>";
    echo "<th>Rata-rata IPK</th>";
    echo "</tr>";

    while ($row = mysqli_fetch_assoc($resultRekap)) {

        echo "<tr>";

        echo "<td>"
            . htmlspecialchars($row['prodi'])
            . "</td>";

        echo "<td>"
            . htmlspecialchars($row['jumlah'])
            . "</td>";

        echo "<td>"
            . htmlspecialchars($row['rata_ipk'])
            . "</td>";

        echo "</tr>";
    }

    echo "</table>";

} else {

    echo "<p>Belum ada data rekap mahasiswa.</p>";

}



// 5. SELECT
// Verifikasi data sebelum dihapus

echo "<h2>5. SELECT - Verifikasi Data</h2>";

$nimTarget = "2025003";

$sqlVerifikasi = "
    SELECT nim, nama, prodi, ipk
    FROM mahasiswa
    WHERE nim = ?
";

$stmtVerifikasi = mysqli_prepare($koneksi, $sqlVerifikasi);

mysqli_stmt_bind_param(
    $stmtVerifikasi,
    "s",
    $nimTarget
);

mysqli_stmt_execute($stmtVerifikasi);

$resultVerifikasi = mysqli_stmt_get_result($stmtVerifikasi);

if (mysqli_num_rows($resultVerifikasi) > 0) {

    $row = mysqli_fetch_assoc($resultVerifikasi);

    echo "<p>Data ditemukan:</p>";

    echo "<ul>";

    echo "<li>NIM: "
        . htmlspecialchars($row['nim'])
        . "</li>";

    echo "<li>Nama: "
        . htmlspecialchars($row['nama'])
        . "</li>";

    echo "<li>Program Studi: "
        . htmlspecialchars($row['prodi'])
        . "</li>";

    echo "<li>IPK: "
        . htmlspecialchars($row['ipk'])
        . "</li>";

    echo "</ul>";

} else {

    echo "<p>Data dengan NIM $nimTarget tidak ditemukan.</p>";
}

mysqli_stmt_close($stmtVerifikasi);



// 6. DELETE
// Menghapus data mahasiswa

echo "<h2>6. DELETE - Menghapus Data</h2>";

$sqlDelete = "
    DELETE FROM mahasiswa
    WHERE nim = '2025003'
";

if (mysqli_query($koneksi, $sqlDelete)) {

    if (mysqli_affected_rows($koneksi) > 0) {

        echo "
            <p>
                Data mahasiswa dengan NIM 2025003
                berhasil dihapus dari database.
            </p>
        ";

    } else {

        echo "
            <p>
                Data dengan NIM 2025003
                tidak ditemukan atau sudah dihapus.
            </p>
        ";
    }

} else {

    echo "
        <p>
            Gagal menghapus data:
            " . mysqli_error($koneksi) . "
        </p>
    ";
}

mysqli_close($koneksi);

?>