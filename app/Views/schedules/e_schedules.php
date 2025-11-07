<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> Edit Jadwal Pertandingan
    </h4>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Edit Jadwal Pertandingan</h5>
            <small class="text-muted float-end">Ubah data jadwal pertandingan</small>
        </div>

        <div class="card-body">
            <form action="<?= site_url('admin/schedules/update/' . $schedule['id']) ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="mb-3">
                    <label for="gors_id" class="form-label">GOR</label>
                    <select name="gors_id" id="gors_id"
                        class="form-select <?= (session('validation') && session('validation')->hasError('gors_id')) ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih GOR --</option>
                        <?php foreach ($gors as $gor): ?>
                            <?php $selected = old('gors_id', $schedule['gors_id']) == $gor['id'] ? 'selected' : '' ?>
                            <option value="<?= esc($gor['id']) ?>" <?= $selected ?>>
                                <?= esc($gor['gors_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('gors_id') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="tournament_points_id" class="form-label">Level Pertandingan</label>
                    <select name="tournament_points_id" id="tournament_points_id"
                        class="form-select <?= (session('validation') && session('validation')->hasError('tournament_points_id')) ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Pertandingan --</option>
                        <?php foreach ($tournament_points as $point): ?>
                            <?php $selected = old('tournament_points_id', $schedule['tournament_points_id']) == $point['id'] ? 'selected' : '' ?>
                            <option value="<?= esc($point['id']) ?>" <?= $selected ?>>
                                <?= esc($point['series_level']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('tournament_points_id') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="match_date" class="form-label">Tanggal & Waktu Pertandingan</label>
                    <?php
                    // Ensure the datetime-local format is 'YYYY-MM-DDThh:mm'
                    $current_date = $schedule['match_date'] ? date('Y-m-d\TH:i', strtotime($schedule['match_date'])) : '';
                    $old_date = old('match_date') ?: $current_date; // Use old() directly, it should handle the format if validation fails
                    ?>
                    <input type="datetime-local"
                        name="match_date"
                        id="match_date"
                        class="form-control <?= (session('validation') && session('validation')->hasError('match_date')) ? 'is-invalid' : '' ?>"
                        value="<?= esc($old_date) ?>" />
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('match_date') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="match_type" class="form-label">Jenis Pertandingan</label>
                    <select name="match_type" id="match_type"
                        class="form-select <?= (session('validation') && session('validation')->hasError('match_type')) ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Jenis Pertandingan --</option>
                        <option value="Campuran" <?= old('match_type', $schedule['match_type'] ?? '') === 'Campuran' ? 'selected' : '' ?>>Campuran</option>
                        <option value="Pratama" <?= old('match_type', $schedule['match_type'] ?? '') === 'Pratama' ? 'selected' : '' ?>>Pratama</option>
                        <option value="Utama" <?= old('match_type', $schedule['match_type'] ?? '') === 'Utama' ? 'selected' : '' ?>>Utama</option>
                        <option value="Grup" <?= old('match_type', $schedule['match_type'] ?? '') === 'Grup' ? 'selected' : '' ?>>Grup</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('match_type') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status"
                        class="form-select <?= (session('validation') && session('validation')->hasError('status')) ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Status --</option>
                        <?php $statuses = ['Scheduled', 'In-Progress', 'Completed', 'Cancelled']; ?>
                        <?php foreach ($statuses as $s): ?>
                            <?php $selected = old('status', $schedule['status']) === $s ? 'selected' : '' ?>
                            <option value="<?= $s ?>" <?= $selected ?>><?= $s ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('status') : '' ?>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bx bx-save"></i> Update
                    </button>
                    <a href="<?= site_url('admin/schedules') ?>" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>