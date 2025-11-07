<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="mb-4">Daftar Album Kegiatan</h4>
    <div class="row">
        <?php
        if (!empty($grouped_gallery)):
            foreach ($grouped_gallery as $group):
                // URL yang akan memicu filter di Controller
                $albumUrl = site_url('gallery?title=' . urlencode($group['title']));
                $coverUrl = base_url('assets/img/gallery/' . esc($group['cover_photo']));
        ?>
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <a href="<?= $albumUrl ?>" class="card shadow-sm border-0 gallery-folder-link text-decoration-none">
                        <div class="ratio ratio-4x3"> <img src="<?= $coverUrl ?>"
                                alt="Cover Album <?= esc($group['title']) ?>"
                                class="card-img-top object-fit-cover w-100 h-100 gallery-img"
                                onerror="this.onerror=null;this.src='https://via.placeholder.com/600x450?text=Album+Cover';" />
                        </div>
                        <div class="card-body p-3">
                            <h6 class="card-title fw-bold text-dark mb-1">
                                <?= esc($group['title']) ?>
                            </h6>
                            <p class="card-text text-muted small mb-0">
                                <i class="bx bx-calendar me-1"></i> <?= date('d M Y', strtotime($group['event_date'])) ?>
                            </p>
                            <p class="card-text text-primary fw-medium small mb-0">
                                <?= esc($group['photos_count']) ?> Foto
                            </p>
                        </div>
                    </a>
                </div>
            <?php
            endforeach;
        else:
            ?>
            <div class="col-12">
                <div class="alert alert-info text-center shadow" role="alert">
                    <i class="bx bx-images me-2"></i> Belum ada album yang dibuat saat ini.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>