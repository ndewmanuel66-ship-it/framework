<?php
helper('form');
$errors = session()->getFlashdata('errors') ?? [];
$editErrors = session()->getFlashdata('editErrors') ?? [];
$editId = session()->getFlashdata('editId') ?? 0;
$saveError = session()->getFlashdata('saveError');
$editError = session()->getFlashdata('editError');
$deleteError = session()->getFlashdata('deleteError');
$nis = old('nis');
$nama = old('nama');
$kelas = old('kelas');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa XI RPL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --indigo: #4f46e5;
            --indigo-dark: #4338ca;
            --slate-bg: #f8fafc;
            --slate-text: #334155;
            --slate-muted: #64748b;
            --slate-border: #e2e8f0;
        }

        body {
            min-height: 100vh;
            color: var(--slate-text);
            background: var(--slate-bg);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--slate-border);
        }

        .navbar-brand,
        .text-indigo {
            color: var(--indigo) !important;
        }

        .navbar .nav-link {
            color: var(--slate-muted);
            font-weight: 500;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            color: var(--indigo);
        }

        .btn-indigo {
            color: #fff;
            background-color: var(--indigo);
            border-color: var(--indigo);
        }

        .btn-indigo:hover,
        .btn-indigo:focus {
            color: #fff;
            background-color: var(--indigo-dark);
            border-color: var(--indigo-dark);
        }

        .student-card {
            overflow: hidden;
            border: 1px solid var(--slate-border);
            border-radius: 1rem;
        }

        .student-card .card-header {
            border-bottom: 1px solid var(--slate-border);
        }

        .student-table thead th {
            padding-top: 0.9rem;
            padding-bottom: 0.9rem;
            color: #475569;
            background: #f1f5f9;
            border-bottom: 1px solid var(--slate-border);
            white-space: nowrap;
        }

        .student-table tbody td {
            padding-top: 0.85rem;
            padding-bottom: 0.85rem;
        }

        .class-badge {
            color: var(--indigo);
            background: #eef2ff;
            border: 1px solid #c7d2fe;
        }

        .pager-area nav {
            margin-top: 1.25rem;
        }

        .pager-area ul.pagination {
            display: flex;
            justify-content: center;
            gap: 0.35rem;
            padding-left: 0;
            margin-bottom: 0;
        }

        .pager-area ul.pagination li {
            list-style: none;
        }

        .pager-area ul.pagination li a,
        .pager-area ul.pagination li span {
            display: block;
            padding: 0.4rem 0.75rem;
            color: var(--indigo);
            text-decoration: none;
            background: #fff;
            border: 1px solid var(--slate-border);
            border-radius: 0.5rem;
        }

        .pager-area ul.pagination li.active a,
        .pager-area ul.pagination li.active span {
            color: #fff;
            background: var(--indigo);
            border-color: var(--indigo);
        }

        .pager-area ul.pagination li a:hover {
            background: #eef2ff;
        }

        @media (max-width: 575.98px) {
            .pager-area ul.pagination {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= site_url('/'); ?>">Data Siswa XI RPL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Buka navigasi">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="<?= site_url('/'); ?>">Home</a>
                    <a class="nav-link active" aria-current="page" href="<?= site_url('/'); ?>">Data Siswa</a>
                    <a class="nav-link" href="#about">About</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        <div class="card student-card shadow-sm">
            <div class="card-header bg-white py-3">
                <h1 class="h5 card-title fw-bold m-0 text-indigo">Data Siswa</h1>
            </div>
            <div class="card-body">
                <?php if ($saveError): ?>
                    <div class="alert alert-danger" role="alert"><?= esc($saveError); ?></div>
                <?php endif; ?>

                <?php if ($editError): ?>
                    <div class="alert alert-danger" role="alert"><?= esc($editError); ?></div>
                <?php endif; ?>

                <?php if ($deleteError): ?>
                    <div class="alert alert-danger" role="alert"><?= esc($deleteError); ?></div>
                <?php endif; ?>

                <button type="button" class="btn btn-indigo mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    + Tambah Data Siswa
                </button>

                <div class="table-responsive">
                    <table class="table table-hover align-middle student-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">NIS</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Kelas</th>
                                <th scope="col" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (! empty($siswa)): ?>
                                <?php foreach ($siswa as $index => $row): ?>
                                    <tr>
                                        <td><?= (($pager->getCurrentPage('siswa') - 1) * 10) + $index + 1; ?></td>
                                        <td><?= esc($row['nis']); ?></td>
                                        <td><?= esc($row['nama']); ?></td>
                                        <td><span class="badge rounded-pill class-badge"><?= esc($row['kelas']); ?></span></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= esc($row['id']); ?>">
                                                    Edit
                                                </button>
                                                <form action="<?= site_url('siswa/hapus/' . $row['id']); ?>" method="post" onsubmit="return confirm('Apakah kamu yakin ingin menghapus data ini?');">
                                                    <?= csrf_field(); ?>
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data siswa.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (! empty($siswa)): ?>
                    <div class="pager-area">
                        <?= $pager->links('siswa', 'default_full'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (! empty($siswa)): ?>
            <?php foreach ($siswa as $row): ?>
                <?php
                $rowId = (int) $row['id'];
                $isEditingRow = (int) $editId === $rowId;
                $rowEditErrors = $isEditingRow ? $editErrors : [];
                $editNis = $isEditingRow ? old('nis', $row['nis']) : $row['nis'];
                $editNama = $isEditingRow ? old('nama', $row['nama']) : $row['nama'];
                $editKelas = $isEditingRow ? old('kelas', $row['kelas']) : $row['kelas'];
                ?>
                <div class="modal fade" id="modalEdit<?= esc($rowId); ?>" tabindex="-1" aria-labelledby="modalEditLabel<?= esc($rowId); ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-warning">
                                <h2 class="modal-title fs-5" id="modalEditLabel<?= esc($rowId); ?>">Edit Data Siswa</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <form action="<?= site_url('siswa/edit/' . $rowId); ?>" method="post">
                                <?= csrf_field(); ?>
                                <div class="modal-body">
                                    <?php if ($rowEditErrors !== []): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <ul class="mb-0">
                                                <?php foreach ($rowEditErrors as $error): ?>
                                                    <li><?= esc($error); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>

                                    <div class="mb-3">
                                        <label for="nisEdit<?= esc($rowId); ?>" class="form-label">NIS</label>
                                        <input type="text" name="nis" id="nisEdit<?= esc($rowId); ?>" class="form-control" value="<?= esc($editNis); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="namaEdit<?= esc($rowId); ?>" class="form-label">Nama Lengkap</label>
                                        <input type="text" name="nama" id="namaEdit<?= esc($rowId); ?>" class="form-control" value="<?= esc($editNama); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kelasEdit<?= esc($rowId); ?>" class="form-label">Kelas</label>
                                        <input type="text" name="kelas" id="kelasEdit<?= esc($rowId); ?>" class="form-control" value="<?= esc($editKelas); ?>" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>

    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white" style="background-color: #4f46e5;">
                    <h2 class="modal-title fs-5" id="modalTambahLabel">Tambah Data Siswa</h2>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form action="<?= site_url('siswa/tambah'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <?php if ($errors !== []): ?>
                            <div class="alert alert-danger" role="alert">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= esc($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="nis" class="form-label">NIS</label>
                            <input type="text" name="nis" id="nis" class="form-control" value="<?= esc($nis ?? ''); ?>" placeholder="Masukkan NIS" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="<?= esc($nama ?? ''); ?>" placeholder="Masukkan Nama Lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input type="text" name="kelas" id="kelas" class="form-control" value="<?= esc($kelas ?? ''); ?>" placeholder="Contoh: XI RPL 1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-indigo">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer id="about" class="container pb-4 text-center small text-secondary">
        Halaman pengelolaan data siswa XI RPL.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($errors !== [] || $saveError): ?>
        <script>
            new bootstrap.Modal(document.getElementById('modalTambah')).show();
        </script>
    <?php endif; ?>
    <?php if ($editErrors !== [] || $editError): ?>
        <script>
            const modalEdit = document.getElementById('modalEdit<?= esc((string) $editId, 'js'); ?>');
            if (modalEdit) {
                new bootstrap.Modal(modalEdit).show();
            }
        </script>
    <?php endif; ?>
</body>
</html>
