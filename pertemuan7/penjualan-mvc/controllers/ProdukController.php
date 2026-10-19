<?php
class ProdukController {
    private ProdukModel $model;
    public function __construct(ProdukModel $model) { $this->model = $model; }
    public function handleRequest(): void {
        $aksi = $_GET['aksi'] ?? 'index'; $pesan = ''; $jenisPesan = 'success'; $produkEdit = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $aksiPost = $_POST['aksi'] ?? ''; $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $nama = trim($_POST['nama_produk'] ?? ''); $harga = $_POST['harga'] ?? ''; $stok = $_POST['stok'] ?? '';
            if ($nama === '' || !is_numeric($harga) || (float)$harga < 0 || filter_var($stok, FILTER_VALIDATE_INT) === false || (int)$stok < 0) {
                $pesan = 'Input tidak valid. Nama wajib diisi, harga tidak boleh negatif, dan stok harus bilangan bulat ≥ 0.'; $jenisPesan = 'error';
                if ($aksiPost === 'ubah' && $id) $produkEdit = ['id'=>$id, 'nama_produk'=>$nama, 'harga'=>$harga, 'stok'=>$stok];
            } else {
                if ($aksiPost === 'tambah') $ok = $this->model->tambah($nama, (float)$harga, (int)$stok);
                elseif ($aksiPost === 'ubah' && $id) $ok = $this->model->ubah($id, $nama, (float)$harga, (int)$stok);
                else $ok = false;
                $pesan = $ok ? ($aksiPost === 'tambah' ? 'Produk berhasil ditambahkan.' : 'Produk berhasil diperbarui.') : 'Operasi gagal. Periksa kembali data dan database.';
                $jenisPesan = $ok ? 'success' : 'error';
            }
        }
        if ($aksi === 'edit' && isset($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($id) $produkEdit = $this->model->cari($id);
            if (!$produkEdit) { $pesan = 'Produk tidak ditemukan.'; $jenisPesan = 'error'; }
        }
        $daftarProduk = $this->model->semua();
        require __DIR__ . '/../views/produk/index.php';
    }
}
