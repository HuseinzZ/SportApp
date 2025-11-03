<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-2 mb-3">
            <span class="text-muted fw-light">Master/ Jadwal Pertandingan /</span> ID <?= esc($schedule_id) ?>
        </h4>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert"><?= session()->getFlashdata('success') ?><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert"><?= session()->getFlashdata('error') ?><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
        <?php endif; ?>

        <a href="<?= site_url('admin/matches/a_match/' . $schedule_id) ?>" class="btn btn-primary mb-3">
            <i class="bx bx-plus me-1"></i> Tambah Pertandingan Baru
        </a>

        <div class="card">
            <h5 class="card-header">Daftar Pertandingan untuk Sesi <?= esc(date('d M Y', strtotime($schedule['match_date']))) ?></h5>
            <div class="table-responsive text-nowrap">
                <?php if ($is_empty): ?>
                    <div class="p-4 text-center text-muted">Belum ada pertandingan yang dicatat untuk jadwal ini.</div>
                <?php else: ?>
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>BABAK</th>
                                <th>TIM A (PASANGAN)</th>
                                <th>TIM B (PASANGAN)</th>
                                <th>SKOR</th>
                                <th>PEMENANG</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php foreach ($all_matches as $data):
                                $match = $data['match'];
                                $players = $data['match_players'];
                                $scores = $data['match_scores'];

                                // Hitung Total Skor
                                $totalScoreA = array_sum(array_column($scores, 'team_a_score'));
                                $totalScoreB = array_sum(array_column($scores, 'team_b_score'));
                            ?>
                                <tr>
                                    <td><?= esc($match['round']) ?></td>
                                    <td><?= implode(' & ', $players['A']) ?></td>
                                    <td><?= implode(' & ', $players['B']) ?></td>
                                    <td><?= esc($totalScoreA) ?> - <?= esc($totalScoreB) ?></td>
                                    <td><span class="badge bg-<?= $match['winner_team'] == 'A' ? 'primary' : 'info' ?>"><?= esc($match['winner_team']) ?></span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?= site_url('admin/matches/e_match/' . $match['id']) ?>">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit Hasil
                                                </a>
                                                <a class="dropdown-item text-danger" href="<?= site_url('admin/matches/d_match/' . $match['id']) ?>"
                                                    onclick="return confirm('Hapus Pertandingan #<?= esc($match['id']) ?> beserta semua data pemain dan skor?');">
                                                    <i class="bx bx-trash me-1"></i> Hapus
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>