<?php
$errors = session()->getFlashdata('errors') ?? [];
$mahasiswa = $mahasiswa ?? [];
?>
<?php if (! empty($errors)): ?>
    <div class="alert alert-error">
        <strong>Periksa kembali input berikut:</strong>
        <ul class="error-list">
            <?php foreach ($errors as $message): ?>
                <li><?= esc($message) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<section class="card">
    <form method="post" action="<?= esc($formAction) ?>">
        <?= csrf_field() ?>
        <div class="form-grid">
            <div class="field">
                <label for="nim">NIM</label>
                <input id="nim" name="nim" type="text" maxlength="20" required
                       value="<?= esc(old('nim', $mahasiswa['nim'] ?? '')) ?>"
                       placeholder="Contoh: 4524210141">
                <?php if (isset($errors['nim'])): ?><div class="field-error"><?= esc($errors['nim']) ?></div><?php endif; ?>
            </div>
            <div class="field">
                <label for="nama">Nama lengkap</label>
                <input id="nama" name="nama" type="text" maxlength="100" required
                       value="<?= esc(old('nama', $mahasiswa['nama'] ?? '')) ?>"
                       placeholder="Masukkan nama mahasiswa">
                <?php if (isset($errors['nama'])): ?><div class="field-error"><?= esc($errors['nama']) ?></div><?php endif; ?>
            </div>
            <div class="field">
                <label for="prodi">Program studi</label>
                <input id="prodi" name="prodi" type="text" maxlength="100" required
                       value="<?= esc(old('prodi', $mahasiswa['prodi'] ?? '')) ?>"
                       placeholder="Contoh: Teknik Informatika">
                <?php if (isset($errors['prodi'])): ?><div class="field-error"><?= esc($errors['prodi']) ?></div><?php endif; ?>
            </div>
            <div class="field">
                <label for="ipk">IPK</label>
                <input id="ipk" name="ipk" type="number" min="0" max="4" step="0.01" required
                       value="<?= esc(old('ipk', $mahasiswa['ipk'] ?? '')) ?>"
                       placeholder="Contoh: 3.75">
                <div class="form-note">IPK harus berupa angka dengan rentang 0,00 sampai 4,00.</div>
                <?php if (isset($errors['ipk'])): ?><div class="field-error"><?= esc($errors['ipk']) ?></div><?php endif; ?>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= esc($submitLabel) ?></button>
            <a href="<?= site_url('tugas8/mahasiswa') ?>" class="btn btn-light">Kembali</a>
        </div>
    </form>
</section>
