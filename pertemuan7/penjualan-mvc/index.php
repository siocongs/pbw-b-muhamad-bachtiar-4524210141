<?php
require_once __DIR__ . '/koneksi.php';
require_once __DIR__ . '/models/ProdukModel.php';
require_once __DIR__ . '/controllers/ProdukController.php';
$model = new ProdukModel($koneksi);
$controller = new ProdukController($model);
$controller->handleRequest();
