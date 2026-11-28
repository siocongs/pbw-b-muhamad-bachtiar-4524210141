<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('tugas8/mahasiswa', 'Tugas8MahasiswaController::index');
$routes->get('tugas8/mahasiswa/tambah', 'Tugas8MahasiswaController::create');
$routes->post('tugas8/mahasiswa/simpan', 'Tugas8MahasiswaController::store');
$routes->get('tugas8/mahasiswa/ubah/(:num)', 'Tugas8MahasiswaController::edit/$1');
$routes->post('tugas8/mahasiswa/perbarui/(:num)', 'Tugas8MahasiswaController::update/$1');
$routes->post('tugas8/mahasiswa/hapus/(:num)', 'Tugas8MahasiswaController::delete/$1');