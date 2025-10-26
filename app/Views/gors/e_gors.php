<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> Edit GOR
    </h4>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Edit GOR</h5>
            <small class="text-muted float-end">Ubah data GOR</small>
        </div>

        <div class="card-body">
            <form action="<?= site_url('admin/gors/update/' . $gor['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-3">
                    <label for="gors_name" class="form-label">Nama GOR</label>
                    <input type="text" name="gors_name" id="gors_name"
                        class="form-control <?= (session('validation') && session('validation')->hasError('gors_name')) ? 'is-invalid' : '' ?>"
                        placeholder="Masukan nama GOR" value="<?= old('gors_name', $gor['gors_name']) ?>" readonly />
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('gors_name') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea name="address" id="address" rows="3"
                        class="form-control <?= (session('validation') && session('validation')->hasError('address')) ? 'is-invalid' : '' ?>"
                        placeholder="Masukkan alamat lengkap GOR"><?= old('address', $gor['address']) ?></textarea>
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('address') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="contact" class="form-label">Kontak (Telp/HP)</label>
                    <input type="text" name="contact" id="contact"
                        class="form-control <?= (session('validation') && session('validation')->hasError('contact')) ? 'is-invalid' : '' ?>"
                        placeholder="Contoh: +62-123-4567-8910" value="<?= old('contact', $gor['contact']) ?>" />
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('contact') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="form-control <?= (session('validation') && session('validation')->hasError('description')) ? 'is-invalid' : '' ?>"
                        placeholder="Masukan deskripsi GOR"><?= old('description', $gor['description']) ?></textarea>
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
                            placeholder="Contoh: 50000" value="<?= old('price', $gor['price']) ?>" min="0" />
                        <div class="invalid-feedback">
                            <?= session('validation') ? session('validation')->getError('price') : '' ?>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Foto GOR</label>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="position-relative">
                            <img id="photoPreview"
                                src="<?= !empty($gor['photo']) ? base_url('assets/img/gors/' . $gor['photo']) : base_url('assets/img/no-image.png') ?>"
                                alt="Foto <?= esc($gor['gors_name']) ?>"
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
        }
    }
</script>