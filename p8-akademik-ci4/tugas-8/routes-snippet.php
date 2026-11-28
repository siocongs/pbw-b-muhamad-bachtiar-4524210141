// Tambahkan baris berikut ke app/Config/Routes.php di proyek utama.
// Jangan mengganti seluruh isi Routes.php yang sudah ada.

$routes->get('tugas8/mahasiswa', 'Tugas8MahasiswaController::index');
$routes->get('tugas8/mahasiswa/tambah', 'Tugas8MahasiswaController::create');
$routes->post('tugas8/mahasiswa/simpan', 'Tugas8MahasiswaController::store');
$routes->get('tugas8/mahasiswa/ubah/(:num)', 'Tugas8MahasiswaController::edit/$1');
$routes->post('tugas8/mahasiswa/perbarui/(:num)', 'Tugas8MahasiswaController::update/$1');
$routes->post('tugas8/mahasiswa/hapus/(:num)', 'Tugas8MahasiswaController::delete/$1');
