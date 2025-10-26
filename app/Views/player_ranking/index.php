<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header Judul Halaman -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">Laporan /</span> Daftar Peringkat
            </h4>
            <div class="d-flex align-items-center gap-2">
                <!-- Dropdown Ekspor -->
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" type="button" id="exportDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-download me-1"></i> Ekspor
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="exportDropdown">
                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="<?= site_url('admin/ranking/export/excel') ?>">
                                <i class="bx bx-spreadsheet text-success me-2 fs-5"></i> Ekspor ke Excel (.xls)
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="<?= site_url('admin/ranking/export/csv') ?>">
                                <i class="bx bx-file text-primary me-2 fs-5"></i> Ekspor ke CSV (.csv)
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Tombol Print -->
                <a href="<?= site_url('admin/ranking/print') ?>" class="btn btn-primary">
                    <i class="bx bx-printer me-1"></i> Cetak
                </a>
            </div>
        </div>

        <!-- Info Box -->
        <div class="alert alert-info d-flex align-items-center" role="alert">
            <i class="bx bx-info-circle me-2 fs-4"></i>
            <div>
                Poin dihitung berdasarkan akumulasi total poin yang diperoleh dari setiap jadwal pertandingan (Level Seri).
            </div>
        </div>

        <!-- Card Tabel -->
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
                            <th>PEMAIN</th>
                            <th width="10%">LEVEL</th>
                            <th width="15%">TOTAL POIN</th>
                            <th width="15%">AKSI</th>
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
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge bg-label-<?= $rank <= 3 ? 'warning' : 'secondary' ?> fs-6">
                                            <?= $rank++ ?>
                                        </span>
                                    </td>
                                    <td><strong><?= esc($playerRank['player_name']) ?></strong></td>
                                    <td class="text-center"><?= esc($detail['level'] ?? '-') ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-primary fs-6 px-3 py-2">
                                            <?= number_format(esc($playerRank['total_points']), 0, ',', '.') ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= site_url('admin/players/history/' . $playerRank['player_id']) ?>"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bx bx-history me-1"></i> Histori
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