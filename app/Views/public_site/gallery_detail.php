<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <a href="<?= site_url('gallery') ?>" class="text-secondary"><i class="bx bx-arrow-back me-2"></i></a>
            <?= esc($title) ?>
        </h4>
        <span class="badge bg-primary fs-6"><?= count($photos) ?> Foto</span>
    </div>

    <div class="row">
        <?php
        if (!empty($photos)):
            foreach ($photos as $item):
                $itemId = esc($item['id'] ?? uniqid());
                $photoUrl = base_url('assets/img/gallery/' . esc($item['photo']));
        ?>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2-4 mb-4">
                    <div class="card shadow-sm border-0 gallery-card position-relative overflow-hidden">
                        <div class="ratio ratio-1x1">
                            <a
                                href="#"
                                data-bs-toggle="modal"
                                data-bs-target="#zoomModal<?= $itemId ?>"
                                class="stretched-link gallery-lightbox-link"
                                title="<?= esc($item['description'] ?? $item['title']) ?>">
                                <img
                                    src="<?= $photoUrl ?>"
                                    alt="<?= esc($item['title']) ?>"
                                    class="card-img-top object-fit-cover w-100 h-100 gallery-img"
                                    loading="lazy"
                                    onerror="this.onerror=null;this.src='https://via.placeholder.com/400x400?text=Gambar+Tidak+Tersedia';" />
                            </a>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="zoomModal<?= $itemId ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable custom-modal-no-content">
                        <img src="<?= $photoUrl ?>"
                            class="img-fluid rounded shadow-lg"
                            style="max-width: 85vw; max-height: 85vh; object-fit: contain; cursor: zoom-out;"
                            alt="Foto <?= esc($item['title']) ?>"
                            data-bs-dismiss="modal">
                    </div>
                </div>

        <?php endforeach;
        endif; ?>
    </div>
</div>
<style>
    /* 1. Paksa Dialog Modal untuk mengisi seluruh ruang viewport dan menggunakan Flexbox */
    .modal-dialog.custom-modal-no-content {
        max-width: 100vw;
        width: 100vw;
        height: 100vh;
        margin: 0;
        padding: 0;

        /* Pengaturan Flexbox untuk Pemusatan */
        display: flex;
        align-items: center;
        /* Pusatkan Vertikal */
        justify-content: center;
        /* Pusatkan Horizontal */

        /* Hapus pointer-events: none; di sini agar Flexbox bekerja dengan baik */
    }

    /* 2. Sesuaikan ukuran batas gambar */
    .custom-modal-no-content img {
        max-width: 85vw !important;
        /* Batas 85% dari viewport width */
        max-height: 85vh !important;
        /* Batas 85% dari viewport height */

        pointer-events: auto;
        /* Memastikan gambar bisa diklik untuk menutup */

        /* Opsi tambahan untuk memastikan gambar yang sangat kecil tetap terlihat: */
        min-width: 50px;
        min-height: 50px;
    }

    /* 3. Opasitas Backdrop (agar tidak terlalu hitam, opsional) */
    .modal-backdrop.show {
        opacity: 0.6;
        background-color: #000;
    }

    /* Tambahan styling untuk thumbnail (jika diperlukan) */
    .ratio.ratio-1x1 {
        aspect-ratio: 1 / 1;
    }

    .gallery-img {
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .gallery-card:hover .gallery-img {
        transform: scale(1.05);
    }
</style>