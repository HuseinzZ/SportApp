<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> Tambah Poin Pertandingan
    </h4>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Tambah Poin Pertandingan</h5>
            <small class="text-muted float-end">Input data poin pertandingan baru</small>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/tournament-points/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="series_level" class="form-label">Level Seri</label>
                    <input type="text"
                        name="series_level"
                        id="series_level"
                        class="form-control <?= (session('validation') && session('validation')->hasError('series_level')) ? 'is-invalid' : '' ?>"
                        placeholder="Contoh: SUPER 1000"
                        value="<?= old('series_level') ?>" />
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('series_level') : '' ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="points_champion" class="form-label">Poin Champion</label>
                        <input type="number" name="points_champion" id="points_champion"
                            class="form-control <?= (session('validation') && session('validation')->hasError('points_champion')) ? 'is-invalid' : '' ?>"
                            value="<?= old('points_champion') ?>" />
                        <div class="invalid-feedback">
                            <?= session('validation') ? session('validation')->getError('points_champion') : '' ?>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="points_runnerup" class="form-label">Poin Runner Up</label>
                        <input type="number" name="points_runnerup" id="points_runnerup"
                            class="form-control <?= (session('validation') && session('validation')->hasError('points_runnerup')) ? 'is-invalid' : '' ?>"
                            value="<?= old('points_runnerup') ?>" />
                        <div class="invalid-feedback">
                            <?= session('validation') ? session('validation')->getError('points_runnerup') : '' ?>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="points_sf" class="form-label">Poin Semi-Final (SF)</label>
                        <input type="number" name="points_sf" id="points_sf"
                            class="form-control <?= (session('validation') && session('validation')->hasError('points_sf')) ? 'is-invalid' : '' ?>"
                            value="<?= old('points_sf') ?>" />
                        <div class="invalid-feedback">
                            <?= session('validation') ? session('validation')->getError('points_sf') : '' ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="points_qf" class="form-label">Poin Quarter-Final (QF)</label>
                        <input type="number" name="points_qf" id="points_qf"
                            class="form-control <?= (session('validation') && session('validation')->hasError('points_qf')) ? 'is-invalid' : '' ?>"
                            value="<?= old('points_qf') ?>" />
                        <div class="invalid-feedback">
                            <?= session('validation') ? session('validation')->getError('points_qf') : '' ?>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="points_r2" class="form-label">Poin Babak Kedua (R2)</label>
                        <input type="number" name="points_r2" id="points_r2"
                            class="form-control <?= (session('validation') && session('validation')->hasError('points_r2')) ? 'is-invalid' : '' ?>"
                            value="<?= old('points_r2') ?>" />
                        <div class="invalid-feedback">
                            <?= session('validation') ? session('validation')->getError('points_r2') : '' ?>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="points_r1" class="form-label">Poin Babak Pertama (R1)</label>
                        <input type="number" name="points_r1" id="points_r1"
                            class="form-control <?= (session('validation') && session('validation')->hasError('points_r1')) ? 'is-invalid' : '' ?>"
                            value="<?= old('points_r1') ?>" />
                        <div class="invalid-feedback">
                            <?= session('validation') ? session('validation')->getError('points_r1') : '' ?>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bx bx-save"></i> Simpan
                    </button>
                    <a href="<?= site_url('admin/tournament-points') ?>" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>