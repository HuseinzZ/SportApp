<style>
    /* 🎨 CSS Kustom untuk Responsivitas Ketinggian Carousel */

    /* Class untuk mengontrol ketinggian gambar carousel */
    .carousel-img-responsive {
        /* object-fit: cover; sudah ada di inline style, tetapi pastikan di sini juga */
        width: 100%;
        /* Ketinggian default untuk layar yang lebih besar (desktop: >= 992px) */
        height: 500px;
    }

    /* Media Query untuk layar ukuran sedang (tablet: <= 991.98px) */
    @media (max-width: 991.98px) {
        .carousel-img-responsive {
            height: 350px;
            /* Ketinggian disesuaikan untuk tablet */
        }
    }

    /* Media Query untuk layar ukuran kecil (ponsel: <= 575.98px) */
    @media (max-width: 575.98px) {
        .carousel-img-responsive {
            height: 220px;
            /* Ketinggian disesuaikan untuk ponsel */
        }
    }
</style>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card bg-dark text-white p-0 overflow-hidden">
                    <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" style="cursor: pointer;">
                        <div class="carousel-inner" onclick="nextSlide()">
                            <div class="carousel-item active">
                                <img src="<?= base_url('assets/img/home/1.jpg') ?>" class="d-block w-100 carousel-img-responsive" alt="Latihan Bulutangkis" style="object-fit: cover;">
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url('assets/img/home/2.jpeg') ?>" class="d-block w-100 carousel-img-responsive" alt="Pertandingan Bulutangkis" style="object-fit: cover;">
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url('assets/img/home/3.jpg') ?>" class="d-block w-100 carousel-img-responsive" alt="Grup Atlet PB PRABU" style="object-fit: cover;">
                            </div>
                        </div>

                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#imageCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#imageCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#imageCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card p-4 mb-4">
                    <div class="card-body">
                        <h2 class="card-title text-primary mb-3">Selamat Datang di PB PRABU! 🏸</h2>
                        <p class="card-text lead">
                            Kami adalah pusat pelatihan bulutangkis terdepan, berkomitmen untuk membina bakat, meningkatkan keterampilan, dan mencetak atlet berprestasi.
                        </p>
                        <p class="card-text text-muted">
                            Bergabunglah dengan komunitas kami dan mulailah perjalanan Anda menuju puncak prestasi di dunia bulutangkis. Dari latihan dasar hingga strategi pertandingan tingkat lanjut, kami menyediakan program terbaik untuk semua level.
                        </p>
                        <a href="<?= base_url('about') ?>" class="btn btn-outline-primary mt-3">Pelajari Lebih Lanjut</a>
                        <a href="<?= base_url('leaderboard') ?>" class="btn btn-primary mt-2 mt-sm-3 ms-sm-2">Lihat Peringkat Atlet</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-run text-primary" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Atlet Aktif</span>
                        <h3 class="card-title mb-2">100+</h3>
                        <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> Tumbuh 12% tahun ini</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-trophy text-warning" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Gelar Juara</span>
                        <h3 class="card-title mb-2">45+</h3>
                        <small class="text-muted">Di berbagai turnamen lokal & regional</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <i class="bx bx-shield-quarter text-info" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Pelatih Berlisensi</span>
                        <h3 class="card-title mb-2">5</h3>
                        <small class="text-muted">Siap membimbing Anda</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-backdrop fade"></div>
</div>