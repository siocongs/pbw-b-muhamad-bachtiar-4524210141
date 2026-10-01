<?php
    $host = 'localhost';
    $user = 'root';
    $password = '';
    // $db;
    
    $koneksi = mysqli_connect($host, $user, $password);

    if (!$koneksi) {
        die("Koneksi gagal" . mysqli_connect_error());
    }
    echo "koneksi ke server MySQL berhasil";

?>