<div class="container-fluid bg-white py-4 border-top border-bottom border-light">
    <div class="container-xxl">
        <h6 class="text-center text-muted mb-4 fw-semibold">Dipercaya oleh Partner Kami</h6>
        <div class="row justify-content-center align-items-center g-4">

            <div class="col-auto">
                <img src="<?= base_url('assets/img/icons/brands/asana.png') ?>" alt="Logo Asana" style="max-height: 40px; opacity: 0.7;">
            </div>

            <div class="col-auto">
                <img src="<?= base_url('assets/img/icons/brands/google.png') ?>" alt="Logo Google" style="max-height: 40px; opacity: 0.7;">
            </div>

            <div class="col-auto">
                <img src="<?= base_url('assets/img/icons/brands/slack.png') ?>" alt="Logo Slack" style="max-height: 40px; opacity: 0.7;">
            </div>

        </div>
    </div>
</div>

<footer class="container-fluid bg-light text-dark pt-5">
    <div class="container-xxl py-5">

        <div class="row g-5">

            <div class="col-md-6 col-lg-4">
                <a href="<?= base_url() ?>" class="d-inline-block mb-3 text-decoration-none">
                    <h4 class="text-dark fw-bolder">PB PRABU</h4>
                </a>
                <p class="mb-0 small text-muted">
                    Pusat pelatihan dan komunitas bulutangkis terdepan untuk meraih prestasi.
                </p>
            </div>

            <div class="col-md-6 col-lg-4">
                <h5 class="text-dark mb-4">Hubungi Kami</h5>
                <p class="text-muted"><i class='bx bxl-whatsapp me-3' style="font-size: 1.5rem; color: #25D366 !important;"></i><a href="tel:+6281802434889" class="text-dark text-decoration-none">+62 818-0243-4889</a></p>
                <p class="text-muted"><i class='bx bxl-instagram me-3' style="font-size: 1.5rem; 
              display: inline-block; 
              background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%); 
              background-clip: text; 
              -webkit-text-fill-color: transparent;"></i><a href="mailto:support@prabu.com" class="text-dark text-decoration-none">support@prabu.com</a></p>
            </div>

            <div class="col-md-6 col-lg-4">
                <h5 class="text-dark mb-4">Tautan Cepat</h5>
                <a class="btn btn-link text-muted p-0 text-start d-block mb-2" href="<?= base_url() ?>">Beranda</a>
                <a class="btn btn-link text-muted p-0 text-start d-block mb-2" href="<?= site_url('leaderboard') ?>">Daftar Peringkat</a>
                <a class="btn btn-link text-muted p-0 text-start d-block mb-2" href="<?= site_url('gallery') ?>">Galeri</a>
                <a class="btn btn-link text-muted p-0 text-start d-block mb-2" href="<?= site_url('about') ?>">Tentang Kami</a>
                <a class="btn btn-link text-muted p-0 text-start d-block mb-2" href="<?= site_url('contact') ?>">Kontak</a>
                <a class="btn btn-link text-muted p-0 text-start d-block mb-2" href="<?= site_url('admin') ?>">Area Admin</a>
            </div>

        </div>
    </div>

    <div class="container-xxl">
        <div class="copyright">
            <div class="row border-top border-light pt-3 pb-4">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0 small text-muted">
                    &copy; <span id="currentYear"></span> <a class="text-primary border-bottom text-decoration-none" href="<?= base_url() ?>">PB PRABU</a>, All rights reserved.
                </div>
                <div class="col-md-6 text-center text-md-end small text-muted">
                    <div class="footer-menu d-flex justify-content-center justify-content-md-end gap-3">
                        <a href="<?= base_url() ?>" class="text-muted text-decoration-none">Beranda</a>
                        <a href="#!" class="text-muted text-decoration-none">FAQ</a>
                        <a href="#!" class="text-muted text-decoration-none">Syarat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    document.getElementById('currentYear').textContent = new Date().getFullYear();
</script>