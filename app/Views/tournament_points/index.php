<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-2 mb-3">
            <span class="text-muted fw-light">Master /</span> Poin Pertandingan
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

        <a href="<?= site_url('admin/tournament-points/a_points') ?>" class="btn btn-primary mb-3">
            <i class="bx bx-plus me-1"></i> Tambah Poin Pertandingan
        </a>

        <div class="card">
            <h5 class="card-header">Daftar Poin Pertandingan</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>LEVEL PERTANDINGAN</th>
                            <th>CHAMPION</th>
                            <th>RUNNER UP</th>
                            <th>SF (Semi-Final)</th>
                            <th>QF (Quarter-Final)</th>
                            <th>R2 (Round 2)</th>
                            <th>R1 (Round 1)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php if (empty($points)): ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted">Tidak ada data poin pertandingan.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($points as $point): ?>
                                <tr>
                                    <td><strong><?= esc($point['id']) ?></strong></td>
                                    <td><?= esc($point['series_level']) ?></td>
                                    <td><?= esc($point['points_champion']) ?></td>
                                    <td><?= esc($point['points_runnerup']) ?></td>
                                    <td><?= esc($point['points_sf']) ?></td>
                                    <td><?= esc($point['points_qf']) ?></td>
                                    <td><?= esc($point['points_r2']) ?></td>
                                    <td><?= esc($point['points_r1']) ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?= site_url('admin/tournament-points/e_points/' . $point['id']) ?>">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <a class="dropdown-item text-danger"
                                                    href="<?= site_url('admin/tournament-points/d_points/' . $point['id']) ?>"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data poin level <?= esc($point['series_level']) ?> ini?');">
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
</div>