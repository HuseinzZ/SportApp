<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-2 mb-3">
            <span class="text-muted fw-light">Master /</span> Jadwal Pertandingan
        </h4>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <a href="<?= site_url('admin/schedules/a_schedules') ?>" class="btn btn-primary mb-3">
            <i class="bx bx-plus me-1"></i> Tambah Jadwal Pertandingan
        </a>

        <div class="card">
            <h5 class="card-header">Daftar Jadwal Pertandingan</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal & Waktu</th>
                            <th>GOR</th>
                            <th>Pertandingan</th>
                            <th>Jenis Pertandingan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php if (empty($schedules)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Tidak ada data jadwal pertandingan.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php
                            if (!isset($matchModel)) {
                                $matchModel = new \App\Models\MatchModel();
                            }
                            ?>
                            <?php foreach ($schedules as $schedule):
                                $statusClass = [
                                    'Scheduled'   => 'info',
                                    'In-Progress' => 'warning',
                                    'Completed'   => 'success',
                                    'Cancelled'   => 'danger',
                                ][$schedule['status']] ?? 'secondary';

                                $matchCount = $matchModel->where('schedule_id', $schedule['id'])->countAllResults();
                                $buttonText = $matchCount > 0 ? "Lihat Hasil ({$matchCount})" : 'Tambah Match';
                                $buttonClass = $matchCount > 0 ? 'text-success' : 'text-primary';
                            ?>
                                <tr>
                                    <td><strong><?= esc($schedule['id']) ?></strong></td>
                                    <td><?= esc(date('d M Y, H:i', strtotime($schedule['match_date']))) ?></td>
                                    <td><?= esc($schedule['gors_name']) ?></td>
                                    <td><?= esc($schedule['series_level']) ?></td>
                                    <td><?= esc($schedule['match_type']) ?></td>
                                    <td>
                                        <span class="badge bg-label-<?= $statusClass ?> me-1">
                                            <?= esc($schedule['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item <?= $buttonClass ?>"
                                                    href="<?= site_url('admin/matches/' . $schedule['id']) ?>">
                                                    <i class="bx bx-list-check me-1"></i> <?= $buttonText ?>
                                                </a>

                                                <div class="dropdown-divider"></div>

                                                <a class="dropdown-item" href="<?= site_url('admin/schedules/e_schedules/' . $schedule['id']) ?>">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit Jadwal
                                                </a>

                                                <a class="dropdown-item text-danger"
                                                    href="<?= site_url('admin/schedules/d_schedules/' . $schedule['id']) ?>"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini? Tindakan ini juga akan menghapus semua data pertandingan (match, players, scores) yang terkait!');">
                                                    <i class="bx bx-trash me-1"></i> Hapus Jadwal
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