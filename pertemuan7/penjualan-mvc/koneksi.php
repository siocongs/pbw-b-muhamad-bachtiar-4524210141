<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'penjualan_mvc';
$koneksi = new mysqli($host, $user, $password, $database);
if ($koneksi->connect_error) 
    die('Koneksi database gagal: ' . htmlspecialchars($koneksi->connect_error));
$koneksi->set_charset('utf8mb4');
