<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> Tambah GOR
    </h4>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Tambah GOR</h5>
            <small class="text-muted float-end">Input data GOR baru</small>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/gors/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="gors_name" class="form-label">Nama GOR</label>
                    <input type="text" name="gors_name" id="gors_name"
                        class="form-control <?= (session('validation') && session('validation')->hasError('gors_name')) ? 'is-invalid' : '' ?>"
                        placeholder="Masukan nama GOR" value="<?= old('gors_name') ?>" />
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('gors_name') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea name="address" id="address" rows="3"
                        class="form-control <?= (session('validation') && session('validation')->hasError('address')) ? 'is-invalid' : '' ?>"
                        placeholder="Masukkan alamat lengkap GOR"><?= old('address') ?></textarea>
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('address') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="contact" class="form-label">Kontak (Telp/HP)</label>
                    <input type="text" name="contact" id="contact"
                        class="form-control <?= (session('validation') && session('validation')->hasError('contact')) ? 'is-invalid' : '' ?>"
                        placeholder="Masukkan nomor kontak" value="<?= old('contact') ?>" />
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('contact') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="form-control <?= (session('validation') && session('validation')->hasError('description')) ? 'is-invalid' : '' ?>"
                        placeholder="Contoh: GOR menggunakan fasilitas AC"><?= old('description') ?></textarea>
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('description') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Harga Sewa (Per Jam)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="price" id="price"
                            class="form-control <?= (session('validation') && session('validation')->hasError('price')) ? 'is-invalid' : '' ?>"
                            placeholder="Contoh: 50000" value="<?= old('price') ?>" min="0" />
                        <span class="input-group-text">.00</span>
                        <div class="invalid-feedback">
                            <?= session('validation') ? session('validation')->getError('price') : '' ?>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Foto Fasilitas</label>
                    <input class="form-control <?= (session('validation') && session('validation')->hasError('photo')) ? 'is-invalid' : '' ?>"
                        type="file" id="photo" name="photo" accept="image/*" onchange="previewPhoto(event)" />
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('photo') : '' ?>
                    </div>
                </div>

                <div class="mb-3 text-center">
                    <img id="photoPreview" src="#" alt="Preview Foto Fasilitas"
                        style="max-width: 200px; display: none; border-radius: 10px; border: 1px solid #ccc; padding: 5px;">
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bx bx-save"></i> Simpan
                    </button>
                    <a href="<?= site_url('admin/gors') ?>" class="btn btn-outline-secondary">
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