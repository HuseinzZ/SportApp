<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold d-flex align-items-center py-2 mb-2">
            Histori Pertandingan <span class="text-primary ms-2"><?= esc($player['player_name']) ?></span>
        </h4>

        <a href="<?= site_url('admin/ranking') ?>" class="btn btn-primary mb-4 d-inline-flex align-items-center">
            <i class="bx bx-arrow-back me-1"></i> Kembali ke Peringkat
        </a>

        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Riwayat 10 Pertandingan Terakhir (Ganda)</h5>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="table-light">
                            <th class="text-uppercase">WAKTU</th>
                            <th class="text-uppercase">LOKASI</th>
                            <th class="text-uppercase">REKAN</th>
                            <th class="text-uppercase">LAWAN</th>
                            <th class="text-uppercase text-center">SKOR GAMES</th>
                            <th class="text-uppercase text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php if (empty($history)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bx bx-info-circle me-1"></i> Belum ada data pertandingan untuk pemain ini.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($history as $match): ?>
                                <?php
                                $isWinner = $match['p1_team'] === $match['winner_team'];
                                $resultText = $isWinner ? 'MENANG' : 'KALAH';
                                $resultIcon = $isWinner ? '✅' : '❌';
                                $resultClass = $isWinner ? 'success' : 'danger';
                                $p1Score = $match['p1_team'] === 'A' ? $match['team_a_score'] : $match['team_b_score'];
                                $oppScore = $match['p1_team'] === 'A' ? $match['team_b_score'] : $match['team_a_score'];

                                // Menyorot baris pemenang (opsional)
                                $rowClass = $isWinner ? 'table-secondary' : '';
                                ?>
                                <tr class="<?= $rowClass ?>">
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold"><?= esc(date('d M Y', strtotime($match['match_date']))) ?></span>
                                            <small class="text-muted"><?= esc(date('H:i', strtotime($match['match_date']))) ?> WIB</small>
                                        </div>
                                    </td>
                                    <td><i class="bx bx-map me-1 text-info"></i> <?= esc($match['gors_name']) ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-user me-1"></i>
                                            <?= esc($match['teammate_name'] ?: '<span class="text-info">(Tunggal)</span>') ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-group me-1"></i>
                                            <?= esc($match['opponent_names']) ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-<?= $isWinner ? 'primary' : 'secondary' ?> fs-6">
                                            <?= esc($p1Score) ?> - <?= esc($oppScore) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-label-<?= $resultClass ?> fw-semibold">
                                            <?= $resultIcon ?> <?= $resultText ?>
                                        </span>
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