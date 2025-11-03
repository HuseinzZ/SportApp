<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card p-4 shadow-lg">

            <div class="row">

                <div class="col-md-4 pe-md-4 mb-4 mb-md-0 pb-4 pb-md-0 border-bottom border-md-end">

                    <div class="text-center mb-4">
                        <?php
                        $photoUrl = base_url('assets/img/players/' . esc($player['photo'] ?? ''));
                        $isPhotoAvailable = !empty($player['photo']);
                        ?>
                        <?php if ($isPhotoAvailable): ?>
                            <img src="<?= $photoUrl ?>"
                                alt="<?= esc($player['player_name']) ?>"
                                class="rounded-circle shadow-sm mb-3"
                                style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #f8f9fa;">
                        <?php else: ?>
                            <div class="d-inline-block rounded-circle bg-label-secondary text-secondary p-3 mb-3"
                                style="width: 80px; height: 80px; font-size: 2rem; line-height: 2;">
                                <i class='bx bx-user'></i>
                            </div>
                        <?php endif; ?>

                        <h4 class="fw-bold mb-1"><?= esc($player['player_name'] ?? 'N/A') ?></h4>
                        <span class="badge bg-label-secondary"><?= esc($player['level'] ?? '-') ?></span>
                    </div>
                    <h5 class="fw-bold mb-3 text-dark"><i class="bx bx-tachometer me-2"></i> Kinerja Dasar</h5>

                    <div class="d-flex justify-content-between align-items-end mb-4 pb-2 border-bottom">
                        <div>
                            <span class="text-muted d-block small mb-1">Total Poin:</span>
                            <strong class="text-primary h2 fw-bolder"><?= number_format($playerStats['poin'] ?? 0, 0, ',', '.') ?></strong>
                        </div>
                        <div class="text-end">
                            <span class="text-muted d-block small mb-1">Ranking:</span>
                            <?php if (($playerStats['ranking'] ?? 0) == 1): ?>
                                <span class="badge bg-warning h4 px-3 py-2 text-uppercase">
                                    <i class="bx bxs-crown me-1"></i> TOP 1
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary h4 px-3 py-2">#<?= $playerStats['ranking'] ?? '-' ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold">Win Rate:</span>
                            <span class="h5 text-dark">
                                <strong><?= $playerStats['win_rate'] ?? 0 ?>%</strong>
                            </span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: <?= $playerStats['win_rate'] ?? 0 ?>%;"
                                aria-valuenow="<?= $playerStats['win_rate'] ?? 0 ?>" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-4">
                            <div class="card bg-light p-2 text-center">
                                <span class="text-muted small d-block">Total</span>
                                <h5 class="fw-bold mb-0"><?= $playerStats['total_match'] ?? 0 ?></h5>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card p-2 bg-success text-white text-center">
                                <span class="small d-block text-white">Menang</span>
                                <h5 class="fw-bold mb-0"><?= $playerStats['menang'] ?? 0 ?></h5>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="card p-2 bg-danger text-white text-center">
                                <span class="small d-block text-white">Kalah</span>
                                <h5 class="fw-bold mb-0"><?= $playerStats['kalah'] ?? 0 ?></h5>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-8 ps-md-4">
                    <h5 class="fw-bold mb-3 mt-4 mt-md-0 text-dark"><i class="bx bx-data me-2"></i> 10 Pertandingan Terakhir</h5>

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <?php if (empty($history)): ?>
                            <p class="text-muted text-center w-100 mt-4">Belum ada data pertandingan yang telah diselesaikan untuk pemain ini.</p>
                        <?php else: ?>
                            <?php foreach ($history as $match):
                                $isWinner = $match['p1_team'] === $match['winner_team'];
                                $mainScore = ($match['p1_team'] == 'A') ? $match['team_a_score'] : $match['team_b_score'];
                                $opponentScore = ($match['p1_team'] == 'A') ? $match['team_b_score'] : $match['team_a_score'];
                                $opponentTeam = str_replace(',', ' & ', $match['opponent_names']);
                                // Ubah warna: hijau jika menang, merah jika kalah
                                $bgColor = $isWinner ? '#28a745' : '#dc3545';
                                $badgeText = $isWinner ? 'Menang' : 'Kalah';
                            ?>
                                <div class="card p-2 text-white shadow-sm transition-300"
                                    style="width: 100px; background-color: <?= $bgColor ?>; border-radius: 6px;">
                                    <small class="text-truncate mb-1 opacity-75 small" title="<?= esc($opponentTeam) ?>">
                                        <?= esc($opponentTeam) ?>
                                    </small>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 fw-bolder"><?= esc($opponentScore) ?></span>
                                        <span class="text-light mx-1 opacity-50 small">/</span>
                                        <span class="h5 fw-bolder"><?= esc($mainScore) ?></span>
                                    </div>
                                    <span class="badge text-white mt-1 p-0 small"
                                        style="background-color: rgba(0,0,0,0.2);"><?= $badgeText ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="d-flex align-items-center small">
                            <span class="bg-success rounded-circle me-1 d-inline-block" style="width: 8px; height: 8px;"></span>
                            Menang
                        </div>
                        <div class="d-flex align-items-center small">
                            <span class="bg-danger rounded-circle me-1 d-inline-block" style="width: 8px; height: 8px;"></span>
                            Kalah
                        </div>
                    </div>

                    <div class="mt-2 pt-3 border-top text-end">
                        <a href="<?= site_url('leaderboard') ?>" class="btn btn-secondary me-2">Kembali</a>
                        <button type="button" class="btn btn-primary">
                            <i class="bx bx-share me-1"></i> Bagikan
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS Tambahan untuk efek hover pada kotak pertandingan */
    .transition-300 {
        transition: transform 0.3s ease-in-out;
    }

    .transition-300:hover {
        transform: scale(1.05);
    }

    /* Menghilangkan border-end di mobile */
    @media (max-width: 767.98px) {
        .border-md-end {
            border-right: none !important;
        }
    }
</style>