<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> Tambah Pemain
    </h4>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Tambah Pemain</h5>
            <small class="text-muted float-end">Input data pemain baru</small>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/players/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="player_name" class="form-label">Nama Pemain</label>
                    <input type="text"
                        name="player_name"
                        id="player_name"
                        class="form-control <?= (session('validation') && session('validation')->hasError('player_name')) ? 'is-invalid' : '' ?>"
                        placeholder="Masukkan nama pemain"
                        value="<?= old('player_name') ?>" />
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('player_name') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="level" class="form-label">Level Pemain</label>
                    <select name="level" id="level"
                        class="form-select <?= (session('validation') && session('validation')->hasError('level')) ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Level --</option>
                        <option value="Pratama" <?= old('level') === 'Pratama' ? 'selected' : '' ?>>Pratama</option>
                        <option value="Utama" <?= old('level') === 'Utama' ? 'selected' : '' ?>>Utama</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('level') : '' ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <select name="gender" id="gender"
                        class="form-select <?= (session('validation') && session('validation')->hasError('gender')) ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="M" <?= old('gender') === 'M' ? 'selected' : '' ?>>Pria</option>
                        <option value="F" <?= old('gender') === 'F' ? 'selected' : '' ?>>Wanita</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('gender') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Foto Pemain</label>
                    <input class="form-control <?= (session('validation') && session('validation')->hasError('photo')) ? 'is-invalid' : '' ?>"
                        type="file" id="photo" name="photo" accept="image/*" onchange="previewPhoto(event)" />
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('photo') : '' ?>
                    </div>
                </div>

                <div class="mb-3 text-center">
                    <img id="photoPreview" src="#" alt="Preview Foto Pemain"
                        style="max-width: 200px; display: none; border-radius: 10px; border: 1px solid #ccc; padding: 5px;">
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bx bx-save"></i> Simpan
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
            preview.style.display = 'block';
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }
</script>