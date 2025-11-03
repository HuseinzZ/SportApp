<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header">Daftar Jadwal Pertandingan</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Tanggal & Waktu</th>
                            <th>GOR</th>
                            <th>Pertandingan</th>
                            <th>Jenis Pertandingan</th>
                            <th>Status</th>
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
                                    <td><?= esc(date('d M Y, H:i', strtotime($schedule['match_date']))) ?></td>
                                    <td><?= esc($schedule['gors_name']) ?></td>
                                    <td><?= esc($schedule['series_level']) ?></td>
                                    <td><?= esc($schedule['match_type']) ?></td>
                                    <td>
                                        <span class="badge bg-label-<?= $statusClass ?> me-1">
                                            <?= esc($schedule['status']) ?>
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