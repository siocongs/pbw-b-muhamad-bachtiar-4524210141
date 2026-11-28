<?= $this->include('tugas8/mahasiswa/_header') ?>

<main>
    <div class="page-heading">
        <div>
            <h1>Data Mahasiswa</h1>
            <p class="muted">Kelola data NIM, nama, program studi, dan IPK.</p>
        </div>
        <a class="btn btn-primary" href="<?= site_url('tugas8/mahasiswa/tambah') ?>">+ Tambah Mahasiswa</a>
    </div>

    <?php if ($success = session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc($success) ?></div>
    <?php endif; ?>
    <?php if ($error = session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><?= esc($error) ?></div>
    <?php endif; ?>

    <section class="card">
        <h2>Daftar Mahasiswa</h2>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Program Studi</th>
                        <th>IPK</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($mahasiswa)): ?>
                    <tr><td colspan="6" class="empty">Belum ada data mahasiswa. Silakan tambahkan data.</td></tr>
                <?php else: ?>
                    <?php foreach ($mahasiswa as $no => $row): ?>
                        <tr>
                            <td><?= $no + 1 ?></td>
                            <td><strong><?= esc($row['nim']) ?></strong></td>
                            <td><?= esc($row['nama']) ?></td>
                            <td><?= esc($row['prodi']) ?></td>
                            <td><?= number_format((float) $row['ipk'], 2) ?></td>
                            <td class="actions">
                                <a class="btn btn-light btn-small"
                                   href="<?= site_url('tugas8/mahasiswa/ubah/' . $row['id']) ?>">Ubah</a>
                                <form method="post"
                                      action="<?= site_url('tugas8/mahasiswa/hapus/' . $row['id']) ?>"
                                      onsubmit="return confirm('Hapus data mahasiswa ini?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger btn-small">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?= $this->include('tugas8/mahasiswa/_footer') ?>
