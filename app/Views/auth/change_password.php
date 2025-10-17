<?php
$alert_message = $alert_message ?? 'Masukkan sandi lama dan sandi baru Anda.';
$validation = $validation ?? service('validation');
$session = service('session');
?>
<!DOCTYPE html>
<html
    lang="en"
    class="light-style customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="<?= base_url('assets/') ?>"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= esc($title) ?></title>

    <meta name="description" content="" />

    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon/favicon.ico') ?>" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/boxicons.css') ?>" />

    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css') ?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />

    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />

    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/page-auth.css') ?>" />

    <script src="<?= base_url('assets/vendor/js/helpers.js') ?>"></script>
    <script src="<?= base_url('assets/js/config.js') ?>"></script>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">

                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center">
                            <a href="<?= site_url('admin/dashboard') ?>" class="app-brand-link gap-2">
                                <span class="app-brand-text demo text-body fw-bolder">Admin Panel</span>
                            </a>
                        </div>
                        <h4 class="mb-2">Ganti Sandi Akun 🔒</h4>
                        <p class="mb-4"><?= esc($alert_message) ?></p>

                        <?php if ($session->getFlashdata('error')): ?>
                            <div class="alert alert-danger" role="alert"><?= $session->getFlashdata('error') ?></div>
                        <?php endif; ?>
                        <?php if ($session->getFlashdata('success')): ?>
                            <div class="alert alert-success" role="alert"><?= $session->getFlashdata('success') ?></div>
                        <?php endif; ?>

                        <form id="formAuthentication" class="mb-3" action="<?= site_url('admin/change-password') ?>" method="POST">
                            <?= csrf_field() ?>

                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="current_password">Sandi Lama</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="current_password"
                                        name="current_password"
                                        class="form-control <?= $validation->hasError('current_password') ? 'is-invalid' : '' ?>"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        autofocus />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    <div class="invalid-feedback"><?= $validation->getError('current_password') ?></div>
                                </div>
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="new_password">Sandi Baru</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="new_password"
                                        name="new_password"
                                        class="form-control <?= $validation->hasError('new_password') ? 'is-invalid' : '' ?>"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    <div class="invalid-feedback"><?= $validation->getError('new_password') ?></div>
                                </div>
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="confirm_password">Konfirmasi Sandi Baru</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="confirm_password"
                                        name="confirm_password"
                                        class="form-control <?= $validation->hasError('confirm_password') ? 'is-invalid' : '' ?>"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    <div class="invalid-feedback"><?= $validation->getError('confirm_password') ?></div>
                                </div>
                            </div>

                            <button class="btn btn-primary d-grid w-100" type="submit">Ganti Sandi</button>
                        </form>

                        <div class="text-center">
                            <a href="<?= site_url('admin/dashboard') ?>" class="d-flex align-items-center justify-content-center">
                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/popper/popper.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/js/bootstrap.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/js/menu.js') ?>"></script>

    <script src="<?= base_url('assets/js/main.js') ?>"></script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>