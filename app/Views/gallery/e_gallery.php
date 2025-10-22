<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Master /</span> Edit Event Galeri
    </h4>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Edit Event Galeri</h5>
            <small class="text-muted float-end">Ubah data event galeri</small>
        </div>

        <div class="card-body">
            <form action="<?= site_url('admin/gallery/update/' . $item['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="mb-3">
                    <label for="title" class="form-label">Judul Event</label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control <?= (session('validation') && session('validation')->hasError('title')) ? 'is-invalid' : '' ?>"
                        placeholder="Masukkan judul event"
                        value="<?= old('title', $item['title']) ?>" />
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
                        value="<?= old('event_date', $item['event_date']) ?>" />
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('event_date') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="form-control <?= (session('validation') && session('validation')->hasError('description')) ? 'is-invalid' : '' ?>"
                        placeholder="Masukkan deskripsi singkat event"><?= old('description', $item['description']) ?></textarea>
                    <div class="invalid-feedback">
                        <?= session('validation') ? session('validation')->getError('description') : '' ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Foto Event</label>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="position-relative">
                            <?php
                            $photo_url = !empty($item['photo'])
                                ? base_url('assets/img/gallery/' . $item['photo'])
                                : base_url('assets/img/no-image.png');
                            ?>
                            <img
                                id="photoPreview"
                                src="<?= $photo_url ?>"
                                alt="Foto Event"
                                class="img-thumbnail"
                                width="150" height="150"
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
                            <small class="text-muted d-block mt-1">Kosongkan jika tidak ingin mengubah foto.</small>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bx bx-save"></i> Update
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
        }
    }
</script>