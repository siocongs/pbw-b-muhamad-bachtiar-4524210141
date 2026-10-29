<?php function e($v): string
{
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
$modeEdit = is_array($produkEdit); ?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ProdukKu | Penjualan MVC</title>
    <style>
        :root {
            --ink: #172033;
            --muted: #65718a;
            --line: #e3e8f1;
            --blue: #3157d5;
            --bg: #f5f7fb
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--ink);
            font: 15px/1.5 -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif
        }

        header {
            background: #111a2e;
            color: #fff;
            padding: 22px max(22px, calc((100% - 1100px)/2));
            display: flex;
            justify-content: space-between;
            gap: 18px
        }

        .brand {
            font-size: 21px;
            font-weight: 800
        }

        .brand span {
            color: #91a8ff
        }

        .tag {
            color: #c4cde0;
            font-size: 13px
        }

        main {
            max-width: 1100px;
            margin: 32px auto;
            padding: 0 22px
        }

        .intro {
            display: flex;
            justify-content: space-between;
            align-items: end;
            margin-bottom: 22px;
            gap: 14px
        }

        h1 {
            margin: 0 0 5px;
            font-size: 28px
        }

        .sub {
            margin: 0;
            color: var(--muted)
        }

        .pill {
            background: #e8edff;
            color: #2949bd;
            padding: 7px 12px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 700
        }

        .layout {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 22px
        }

        .card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 7px 22px #18284b08
        }

        h2 {
            font-size: 18px;
            margin: 0 0 18px
        }

        .field {
            margin-bottom: 15px
        }

        label {
            display: block;
            font-weight: 650;
            font-size: 13px;
            margin-bottom: 6px
        }

        input {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #d5dbea;
            border-radius: 9px;
            font: inherit
        }

        .hint {
            font-size: 12px;
            color: var(--muted);
            margin-top: 5px
        }

        .btn {
            border: 0;
            border-radius: 9px;
            padding: 10px 13px;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-block
        }

        .primary {
            background: var(--blue);
            color: white
        }

        .secondary {
            background: #edf1f8;
            color: #35415b
        }

        .full {
            width: 100%;
            text-align: center
        }

        .notice {
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 18px
        }

        .success {
            background: #e8f7ef;
            color: #126b49
        }

        .error {
            background: #fff0ee;
            color: #b42318
        }

        .table-wrap {
            overflow-x: auto
        }

        table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap
        }

        th,
        td {
            text-align: left;
            padding: 13px 12px;
            border-bottom: 1px solid var(--line)
        }

        th {
            font-size: 12px;
            color: var(--muted);
            background: #fafbfe;
            text-transform: uppercase
        }

        td.num {
            text-align: right;
            font-variant-numeric: tabular-nums
        }

        .product-name {
            font-weight: 700
        }

        .id {
            color: var(--muted);
            font-size: 12px
        }

        .actions {
            display: flex;
            gap: 8px
        }

        .empty {
            text-align: center;
            color: var(--muted);
            padding: 28px
        }

        @media(max-width:780px) {
            .layout {
                grid-template-columns: 1fr
            }

            .intro {
                align-items: start;
                flex-direction: column
            }

            header {
                padding: 20px 22px
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="brand">GA<span>GA.</span></div>
        <div class="tag">“Attitude in a Cup" · PHP MVC</div>
    </header>
    <main>
        <div class="intro">
            <div>
                <h1>Dashboard Product</h1>
                <p class="sub">Manage product stock using php MVC.</p>
            </div>
            <div class="pill"><?= count($daftarProduk) ?> PRODUK TERSIMPAN</div>
        </div>
        <?php if ($pesan !== ''): ?><div class="notice <?= e($jenisPesan) ?>"><?= e($pesan) ?></div><?php endif; ?>
        <div class="layout">
            <section class="card">
                <h2><?= $modeEdit ? 'Edit Produk' : 'Tambah Produk' ?></h2>
                <form method="post" action="index.php"><input type="hidden" name="aksi" value="<?= $modeEdit ? 'ubah' : 'tambah' ?>"><?php if ($modeEdit): ?><input type="hidden" name="id" value="<?= e($produkEdit['id']) ?>"><?php endif; ?>
                    <div class="field"><label for="nama_produk">Nama produk</label><input id="nama_produk" name="nama_produk" maxlength="100" required placeholder="Contoh: Kopi Arabika" value="<?= e($produkEdit['nama_produk'] ?? '') ?>"></div>
                    <div class="field"><label for="harga">Harga (Rp)</label><input id="harga" name="harga" type="number" min="0" step="0.01" required placeholder="25000" value="<?= e($produkEdit['harga'] ?? '') ?>"></div>
                    <div class="field"><label for="stok">Stok</label><input id="stok" name="stok" type="number" min="0" step="1" required placeholder="10" value="<?= e($produkEdit['stok'] ?? '') ?>">
                        <div class="hint">Stok berupa bilangan bulat dan tidak boleh negatif.</div>
                    </div>
                    <button class="btn primary full" type="submit"><?= $modeEdit ? 'Simpan Perubahan' : 'Tambah Produk' ?></button><?php if ($modeEdit): ?><p><a class="btn secondary full" href="index.php">Batal mengedit</a></p><?php endif; ?>
                </form>
            </section>
            <section class="card">
                <h2>Daftar Produk</h2>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$daftarProduk): ?><tr>
                                    <td colspan="4" class="empty">Belum ada produk. Tambahkan melalui formulir.</td>
                                </tr><?php else: foreach ($daftarProduk as $produk): ?><tr>
                                        <td>
                                            <div class="product-name"><?= e($produk['nama_produk']) ?></div>
                                            <div class="id">ID #<?= e($produk['id']) ?></div>
                                        </td>
                                        <td class="num">Rp <?= number_format((float)$produk['harga'], 0, ',', '.') ?></td>
                                        <td class="num"><?= number_format((int)$produk['stok'], 0, ',', '.') ?></td>
                                        <td>
                                            <div class="actions"><a class="btn secondary" href="index.php?aksi=edit&amp;id=<?= e($produk['id']) ?>">Edit</a></div>
                                        </td>
                                    </tr><?php endforeach;
                                    endif; ?></tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>

</html>