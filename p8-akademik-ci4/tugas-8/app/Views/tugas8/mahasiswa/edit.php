<?= $this->include('tugas8/mahasiswa/_header') ?>

<main>
    <div class="page-heading">
        <div>
            <h1>Ubah Data Mahasiswa</h1>
            <p class="muted">Perbarui informasi mahasiswa, lalu simpan perubahan.</p>
        </div>
    </div>

    <?= view('tugas8/mahasiswa/_form', [
        'formAction' => site_url('tugas8/mahasiswa/perbarui/' . $mahasiswa['id']),
        'submitLabel' => 'Simpan Perubahan',
        'mahasiswa' => $mahasiswa,
    ]) ?>
</main>

<?= $this->include('tugas8/mahasiswa/_footer') ?>
