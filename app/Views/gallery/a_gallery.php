<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> Tambah Galeri
    </h4>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Tambah Galeri</h5>
            <small class="text-muted float-end">Input data galeri baru</small>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/gallery/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="title" class="form-label">Judul Event</label>
                    <input type="text"
                        name="title"
                        id="title"
                        class="form-control <?= (session('validation') && session('validation')->hasError('title')) ? 'is-invalid' : '' ?>"
                        placeholder="Masukkan judul event"
                        value="<?= old('title') ?>" />
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('title') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="event_date" class="form-label">Tanggal Event</label>
                    <input type="date"
                        name="event_date"
                        id="event_date"
                        class="form-control <?= (session('validation') && session('validation')->hasError('event_date')) ? 'is-invalid' : '' ?>"
                        value="<?= old('event_date') ?>" />
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('event_date') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="form-control <?= (session('validation') && session('validation')->hasError('description')) ? 'is-invalid' : '' ?>"
                        placeholder="Masukkan deskripsi singkat event"><?= old('description') ?></textarea>
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('description') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Foto Event</label>
                    <input class="form-control <?= (session('validation') && session('validation')->hasError('photo')) ? 'is-invalid' : '' ?>"
                        type="file" id="photo" name="photo" accept="image/*" onchange="previewPhoto(event)" />
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('photo') : '' ?>
                    </div>
                </div>

                <div class="mb-3 text-center">
                    <img id="photoPreview" src="#" alt="Preview Foto Event"
                        style="max-width: 250px; display: none; border-radius: 8px; border: 1px solid #ccc; padding: 5px;">
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bx bx-save"></i> Simpan
                    </button>
                    <a href="<?= site_url('admin/gallery') ?>" class="btn btn-outline-secondary">
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