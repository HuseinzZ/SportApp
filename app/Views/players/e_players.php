<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> Edit Pemain
    </h4>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Edit Pemain</h5>
            <small class="text-muted float-end">Ubah data pemain</small>
        </div>

        <div class="card-body">
            <form action="<?= site_url('admin/players/update/' . $player['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="mb-3">
                    <label for="player_name" class="form-label">Nama Pemain</label>
                    <input
                        type="text"
                        name="player_name"
                        id="player_name"
                        class="form-control <?= (session('validation') && session('validation')->hasError('player_name')) ? 'is-invalid' : '' ?>"
                        placeholder="Masukkan nama pemain"
                        value="<?= old('player_name', $player['player_name']) ?>" />
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('player_name') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="level" class="form-label">Level Pemain</label>
                    <select name="level" id="level"
                        class="form-select <?= (session('validation') && session('validation')->hasError('level')) ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Level --</option>
                        <option value="Pratama" <?= old('level', $player['level']) === 'Pratama' ? 'selected' : '' ?>>Pratama</option>
                        <option value="Utama" <?= old('level', $player['level']) === 'Utama' ? 'selected' : '' ?>>Utama</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('level') : '' ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <select
                        name="gender"
                        id="gender"
                        class="form-select <?= (session('validation') && session('validation')->hasError('gender')) ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="M" <?= old('gender', $player['gender']) === 'M' ? 'selected' : '' ?>>Pria</option>
                        <option value="F" <?= old('gender', $player['gender']) === 'F' ? 'selected' : '' ?>>Wanita</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('gender') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="is_active" class="form-label">Status Pemain</label>
                    <select name="is_active" id="is_active"
                        class="form-select <?= (session('validation') && session('validation')->hasError('is_active')) ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Status --</option>
                        <option value="1" <?= old('is_active', $player['is_active']) == 1 ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= old('is_active', $player['is_active']) == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('is_active') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Foto Pemain</label>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="position-relative">
                            <img
                                id="photoPreview"
                                src="<?= !empty($player['photo']) ? base_url('assets/img/players/' . $player['photo']) : base_url('assets/img/no-image.png') ?>"
                                alt="Foto <?= esc($player['player_name']) ?>"
                                class="rounded-circle border"
                                width="100" height="100"
                                style="object-fit: cover;">
                            <span class="d-block text-center small text-muted mt-1">Foto Saat Ini</span>
                        </div>

                        <div class="flex-grow-1">
                            <input
                                class="form-control <?= (session('validation') && session('validation')->hasError('photo')) ? 'is-invalid' : '' ?>"
                                type="file" id="photo_input" name="photo" accept="image/*"
                                onchange="previewPhoto(event)" />
                            <div class="invalid-feedback d-block">
                                <?= session('validation') ? session('validation')->getError('photo') : '' ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bx bx-save"></i> Update
                    </button>
                    <a href="<?= site_url('admin/players') ?>" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewPhoto(event) {
        const preview = document.getElementById('photoPreview');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
        }
    }
</script>