<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Modul Mahasiswa') ?> | Tugas 8 CI4</title>
    <style>
        :root {
            --bg: #f4f6fb; --surface: #fff; --ink: #172033; --muted: #68738a;
            --line: #e5e9f2; --primary: #3858d6; --primary-dark: #2945b7;
            --success-bg: #e9f8ef; --success: #176b42;
            --danger-bg: #fff0ee; --danger: #b42318;
        }
        * { box-sizing: border-box; }
        body { margin: 0; color: var(--ink); background: var(--bg);
               font: 15px/1.55 -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        header { background: #121b31; color: #fff; }
        .nav { max-width: 1120px; margin: auto; padding: 19px 24px;
               display: flex; justify-content: space-between; align-items: center; gap: 16px; }
        .brand { font-size: 19px; font-weight: 800; letter-spacing: .2px; }
        .brand span { color: #9fb2ff; }
        .nav small { color: #c5cde0; }
        main { max-width: 1120px; margin: 34px auto; padding: 0 24px 48px; }
        .page-heading { display: flex; justify-content: space-between; align-items: end;
                        gap: 16px; margin-bottom: 22px; }
        h1 { margin: 0 0 5px; font-size: 29px; letter-spacing: -.5px; }
        h2 { margin: 0 0 18px; font-size: 18px; }
        p { margin-top: 0; }
        .muted { color: var(--muted); margin: 0; }
        .card { background: var(--surface); border: 1px solid var(--line); border-radius: 16px;
                padding: 22px; box-shadow: 0 8px 24px rgba(21, 34, 66, .045); }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 7px;
               border: 0; border-radius: 9px; padding: 10px 14px; text-decoration: none;
               font: inherit; font-weight: 700; cursor: pointer; }
        .btn-primary { color: #fff; background: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-light { color: #34415e; background: #edf1f8; }
        .btn-danger { color: #a52620; background: #fff0ee; }
        .btn-small { padding: 7px 10px; font-size: 13px; }
        .alert { border-radius: 10px; padding: 12px 15px; margin-bottom: 17px; }
        .alert-success { color: var(--success); background: var(--success-bg); }
        .alert-error { color: var(--danger); background: var(--danger-bg); }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; white-space: nowrap; }
        th, td { padding: 13px 12px; text-align: left; border-bottom: 1px solid var(--line); }
        th { color: var(--muted); background: #fafbfe; font-size: 12px; letter-spacing: .05em;
             text-transform: uppercase; }
        td.actions { display: flex; align-items: center; gap: 7px; }
        .empty { text-align: center; color: var(--muted); padding: 28px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .field { margin-bottom: 16px; }
        label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: 700; }
        input { width: 100%; padding: 11px 12px; border: 1px solid #d6ddeb; border-radius: 9px;
                font: inherit; color: var(--ink); background: #fff; }
        input:focus { outline: 0; border-color: var(--primary);
                      box-shadow: 0 0 0 3px rgba(56, 88, 214, .12); }
        .field-error { color: var(--danger); margin-top: 5px; font-size: 12px; }
        .form-note { color: var(--muted); font-size: 12px; margin-top: 5px; }
        .form-actions { display: flex; gap: 9px; margin-top: 5px; }
        .error-list { margin: 6px 0 0; padding-left: 20px; }
        footer { max-width: 1120px; margin: 0 auto; padding: 0 24px 26px;
                 color: var(--muted); font-size: 12px; }
        @media (max-width: 700px) {
            .nav { padding: 16px 18px; } .nav small { display: none; }
            main { margin-top: 24px; padding: 0 16px 36px; }
            .page-heading { align-items: flex-start; flex-direction: column; }
            .form-grid { grid-template-columns: 1fr; gap: 0; }
            .card { padding: 17px; } h1 { font-size: 25px; }
            footer { padding: 0 16px 22px; }
        }
    </style>
</head>
<body>
<header>
    <div class="nav">
        <div class="brand"><span>B</span>Akademik</div>
        <small>Modul Data Mahasiswa · Tugas 8 CodeIgniter 4</small>
    </div>
</header>
