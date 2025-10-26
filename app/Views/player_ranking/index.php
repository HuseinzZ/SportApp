<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-2 mb-3">
            <span class="text-muted fw-light">Laporan /</span> Ranking Poin Global
        </h4>

        <div class="alert alert-info" role="alert">
            Poin dihitung berdasarkan akumulasi total poin yang diperoleh dari setiap jadwal pertandingan (Level Seri).
        </div>

        <div class="card">
            <h5 class="card-header">Daftar Peringkat Pemain</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>RANK</th>
                            <th>PEMAIN</th>
                            <th>LEVEL</th>
                            <th>TOTAL POIN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php if (empty($ranking)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data poin ranking yang dihitung.</td>
                            </tr>
                        <?php else: ?>
                            <?php $rank = 1; ?>
                            <?php foreach ($ranking as $playerRank):
                                $detail = $playerDetails[$playerRank['player_id']] ?? null;
                            ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-label-<?= $rank <= 3 ? 'warning' : 'secondary' ?>"><?= $rank++ ?></span>
                                    </td>
                                    <td><strong><?= esc($playerRank['player_name']) ?></strong></td>
                                    <td><?= esc($detail['level'] ?? '-') ?></td>
                                    <td>
                                        <span class="badge bg-primary fs-6">
                                            <?= number_format(esc($playerRank['total_points']), 0, ',', '.') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('admin/players/history/' . $playerRank['player_id']) ?>" class="btn btn-sm btn-outline-info">
                                            <i class="bx bx-history"></i> Histori
                                        </a>
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