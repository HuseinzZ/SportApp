<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-2 mb-3">
            Histori Pertandingan:
            <span class="text-primary"><?= esc($player['player_name']) ?></span>
        </h4>

        <a href="<?= site_url('admin/ranking') ?>" class="btn btn-secondary mb-3">
            <i class="bx bx-arrow-back me-1"></i> Kembali ke Ranking Global
        </a>

        <div class="card">
            <h5 class="card-header">10 Pertandingan Terakhir (Ganda)</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>TANGGAL & WAKTU</th>
                            <th>LOKASI (GOR)</th>
                            <th>REKAN SETIM</th>
                            <th>LAWAN</th>
                            <th>HASIL GAMES</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php if (empty($history)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data pertandingan untuk pemain ini.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($history as $match): ?>
                                <?php
                                $isWinner = $match['p1_team'] === $match['winner_team'];
                                $resultText = $isWinner ? '✅ MENANG' : '❌ KALAH';
                                $resultClass = $isWinner ? 'success' : 'danger';

                                // Skor Tim P1 (Pemain utama)
                                $p1Score = $match['p1_team'] === 'A' ? $match['team_a_score'] : $match['team_b_score'];
                                // Skor Tim Lawan
                                $oppScore = $match['p1_team'] === 'A' ? $match['team_b_score'] : $match['team_a_score'];
                                ?>
                                <tr>
                                    <td><?= esc(date('d M Y, H:i', strtotime($match['match_date']))) ?></td>
                                    <td><?= esc($match['gors_name']) ?></td>
                                    <td><?= esc($match['teammate_name'] ?: '(Tunggal)') ?></td>
                                    <td><?= esc($match['opponent_names']) ?></td>
                                    <td>
                                        <strong><?= esc($p1Score) ?> - <?= esc($oppScore) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-<?= $resultClass ?>"><?= $resultText ?></span>
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