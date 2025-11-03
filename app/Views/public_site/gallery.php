<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <?php
        if (!empty($gallery)):
            foreach ($gallery as $item):
                $photoUrl = base_url('assets/img/gallery/' . esc($item['photo']));
        ?>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2-4 mb-4">

                    <div class="card shadow-sm border-0 gallery-card position-relative overflow-hidden">
                        <div class="ratio ratio-1x1">

                            <a
                                href="<?= $photoUrl ?>"
                                data-lightbox="gallery-set"
                                data-title="<?= esc($item['title']) ?>"
                                class="stretched-link gallery-lightbox-link"
                                title="Lihat foto: <?= esc($item['title']) ?>">
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
            <?php
            endforeach;
        else:
            ?>
            <div class="col-12">
                <div class="alert alert-info text-center shadow" role="alert">
                    <i class="bx bx-images me-2"></i> Belum ada foto di galeri saat ini.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Membuat gambar tetap tajam dan proporsional */
    .gallery-img {
        object-fit: cover;
        width: 100%;
        height: 100%;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
        transform: translateZ(0);
        backface-visibility: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Efek hover lembut agar foto terlihat hidup */
    .gallery-card:hover .gallery-img {
        transform: scale(1.05);
    }

    /* Membulatkan sudut dan tambahkan bayangan lembut */
    .gallery-card {
        border-radius: 10px;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }

    .gallery-card:hover {
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    }

    /* Rasio lebih tinggi — ubah dari 4/3 jadi 3/4 */
    .ratio.ratio-1x1 {
        aspect-ratio: 3 / 4;
    }

    /* Pastikan gambar tidak terdistorsi di berbagai layar */
    @media (min-width: 992px) {
        .ratio.ratio-1x1 {
            aspect-ratio: 2.8 / 4;
        }
    }

    /* Tambahan agar tampilan tetap rapi di layar kecil */
    @media (max-width: 576px) {
        .ratio.ratio-1x1 {
            aspect-ratio: 1 / 1;
        }
    }
</style>