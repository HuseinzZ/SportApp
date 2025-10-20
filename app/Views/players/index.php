<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-2 mb-3">
            <span class="text-muted fw-light">Master /</span> Pemain
        </h4>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <a href="<?= site_url('admin/players/a_players') ?>" class="btn btn-primary mb-3">
            <i class="bx bx-plus me-1"></i> Tambah Pemain
        </a>

        <div class="card">
            <h5 class="card-header">Daftar Pemain</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Pemain</th>
                            <th>Jenis Kelamin</th>
                            <th>Status</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php if (empty($players)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada data pemain.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($players as $player): ?>
                                <tr>
                                    <td><strong><?= esc($player['id']) ?></strong></td>
                                    <td><?= esc($player['player_name']) ?></td>
                                    <td><?= $player['gender'] === 'M' ? 'Pria' : 'Wanita' ?></td>
                                    <td>
                                        <span class="badge bg-label-<?= $player['is_active'] ? 'success' : 'danger' ?> me-1">
                                            <?= $player['is_active'] ? 'Aktif' : 'Tidak Aktif' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if (!empty($player['photo'])): ?>
                                            <img src="<?= base_url('assets/img/players/' . $player['photo']) ?>"
                                                alt="Foto <?= esc($player['player_name']) ?>"
                                                class="rounded-circle"
                                                width="40" height="40">
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?= site_url('admin/players/e_players/' . $player['id']) ?>">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <a class="dropdown-item text-danger"
                                                    href="<?= site_url('admin/players/d_players/' . $player['id']) ?>"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    <i class="bx bx-trash me-1"></i> Hapus
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>