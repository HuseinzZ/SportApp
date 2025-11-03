<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="alert alert-info d-flex align-items-center" role="alert">
            <i class="bx bx-info-circle me-2 fs-4"></i>
            <div>
                Poin dihitung berdasarkan akumulasi total poin yang diperoleh dari setiap jadwal pertandingan (Level Seri).
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white"><i class="bx bx-bar-chart me-2"></i> Daftar Peringkat</h5>
                <span class="badge bg-light text-primary">Total: <?= count($ranking) ?> Pemain</span>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th width="5%">RANK</th>
                            <th width="15%">PEMAIN</th>
                            <th width="10%">LEVEL</th>
                            <th width="15%">TOTAL POIN</th>
                            <th width="10%">WR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($ranking)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bx bx-info-circle fs-4 d-block mb-2"></i>
                                    Belum ada data poin ranking yang dihitung.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $rank = 1; ?>
                            <?php foreach ($ranking as $playerRank):
                                $detail = $playerDetails[$playerRank['player_id']] ?? null;
                                $history_url = site_url('leaderboard/' . $playerRank['player_id']);
                                $winRate = $playerRank['win_rate'] ?? 0;
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge bg-label-<?= $rank <= 3 ? 'warning' : 'secondary' ?> fs-6">
                                            <?= $rank++ ?>
                                        </span>
                                    </td>

                                    <td>
                                        <a href="<?= $history_url ?>" class="text-secondary fw-bold text-decoration-none d-block">
                                            <?= esc($playerRank['player_name']) ?>
                                        </a>
                                    </td>
                                    <td class="text-center"><?= esc($detail['level'] ?? '-') ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-primary fs-6 px-3 py-2">
                                            <?= esc($playerRank['total_points']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center"><strong><?= $winRate ?>%</strong>
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