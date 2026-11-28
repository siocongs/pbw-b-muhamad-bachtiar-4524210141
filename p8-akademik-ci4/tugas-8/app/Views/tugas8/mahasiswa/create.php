<?= $this->include('tugas8/mahasiswa/_header') ?>

<main>
    <div class="page-heading">
        <div>
            <h1>Tambah Mahasiswa</h1>
            <p class="muted">Isi semua kolom untuk menyimpan data mahasiswa baru.</p>
        </div>
    </div>

    <?= view('tugas8/mahasiswa/_form', [
        'formAction' => site_url('tugas8/mahasiswa/simpan'),
        'submitLabel' => 'Simpan Data',
        'mahasiswa' => $mahasiswa ?? [],
    ]) ?>
</main>

<?= $this->include('tugas8/mahasiswa/_footer') ?>
