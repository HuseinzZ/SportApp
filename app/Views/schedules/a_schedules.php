<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> Tambah Jadwal Pertandingan
    </h4>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Tambah Jadwal Pertandingan</h5>
            <small class="text-muted float-end">Input jadwal pertandingan baru</small>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/schedules/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="gors_id" class="form-label">GOR</label>
                    <select name="gors_id" id="gors_id"
                        class="form-select <?= (session('validation') && session('validation')->hasError('gors_id')) ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih GOR --</option>
                        <?php foreach ($gors as $gor): ?>
                            <option value="<?= esc($gor['id']) ?>" <?= old('gors_id') == $gor['id'] ? 'selected' : '' ?>>
                                <?= esc($gor['gors_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('gors_id') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="tournament_points_id" class="form-label">Jenis Pertandingan</label>
                    <select name="tournament_points_id" id="tournament_points_id"
                        class="form-select <?= (session('validation') && session('validation')->hasError('tournament_points_id')) ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Pertandingan --</option>
                        <?php foreach ($tournament_points as $point): ?>
                            <option value="<?= esc($point['id']) ?>" <?= old('tournament_points_id') == $point['id'] ? 'selected' : '' ?>>
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
                    <input type="datetime-local"
                        name="match_date"
                        id="match_date"
                        class="form-control <?= (session('validation') && session('validation')->hasError('match_date')) ? 'is-invalid' : '' ?>"
                        value="<?= old('match_date') ? date('Y-m-d\TH:i', strtotime(old('match_date'))) : '' ?>" />
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('match_date') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="match_type" class="form-label">Jenis Pertandingan (Format)</label>
                    <select name="match_type" id="match_type"
                        class="form-select <?= (session('validation') && session('validation')->hasError('match_type')) ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Jenis Pertandingan --</option>
                        <option value="Campuran" <?= old('match_type') === 'Campuran' ? 'selected' : '' ?>>Campuran</option>
                        <option value="Pratama" <?= old('match_type') === 'Pratama' ? 'selected' : '' ?>>Pratama</option>
                        <option value="Utama" <?= old('match_type') === 'Utama' ? 'selected' : '' ?>>Utama</option>
                        <option value="Pratama" <?= old('match_type') === 'Grup' ? 'selected' : '' ?>>Grup</option>
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
                        <option value="Scheduled" <?= old('status') === 'Scheduled' ? 'selected' : '' ?>>Scheduled</option>
                        <option value="In-Progress" <?= old('status') === 'In-Progress' ? 'selected' : '' ?>>In-Progress</option>
                        <option value="Completed" <?= old('status') === 'Completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="Cancelled" <?= old('status') === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('status') : '' ?>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bx bx-save"></i> Simpan
                    </button>
                    <a href="<?= site_url('admin/schedules') ?>" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>