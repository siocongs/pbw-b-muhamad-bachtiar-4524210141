<?php
class ProdukModel {
    private mysqli $db;
    public function __construct(mysqli $koneksi) { $this->db = $koneksi; }
    public function semua(): array {
        $hasil = $this->db->query('SELECT id, nama_produk, harga, stok FROM produk ORDER BY id DESC');
        return $hasil ? $hasil->fetch_all(MYSQLI_ASSOC) : [];
    }
    public function cari(int $id): ?array {
        $stmt = $this->db->prepare('SELECT id, nama_produk, harga, stok FROM produk WHERE id = ?');
        $stmt->bind_param('i', $id); $stmt->execute(); $data = $stmt->get_result()->fetch_assoc(); $stmt->close();
        return $data ?: null;
    }
    public function tambah(string $nama, float $harga, int $stok): bool {
        $stmt = $this->db->prepare('INSERT INTO produk (nama_produk, harga, stok) VALUES (?, ?, ?)');
        $stmt->bind_param('sdi', $nama, $harga, $stok); $ok = $stmt->execute(); $stmt->close(); return $ok;
    }
    public function ubah(int $id, string $nama, float $harga, int $stok): bool {
        $stmt = $this->db->prepare('UPDATE produk SET nama_produk=?, harga=?, stok=? WHERE id=?');
        $stmt->bind_param('sdii', $nama, $harga, $stok, $id); $ok = $stmt->execute(); $stmt->close(); return $ok;
    }
}
