<?php
// app/Views/partials/navbar_bootstrap.php

// Dapatkan URL saat ini untuk menentukan tautan aktif
$currentUrl = current_url();

// Definisi Tautan Utama
$mainLinks = [
    ['path' => base_url('/'), 'label' => 'Leaderboard', 'icon' => 'trophy-fill'],
    ['path' => base_url('schedule'), 'label' => 'Schedule', 'icon' => 'calendar-date'],
    ['path' => base_url('gallery'), 'label' => 'Gallery', 'icon' => 'image'],
    ['path' => base_url('about'), 'label' => 'About', 'icon' => 'info-circle'],
];

// Definisi Tautan Admin
$adminLink = ['path' => base_url('admin/login'), 'label' => 'Admin Login', 'icon' => 'lock-fill'];
?>

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
    <div class="container-fluid container-lg">

        <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">
            <div class="logo-icon me-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-trophy-fill text-white fs-5"></i>
            </div>
            <span class="fs-4 fw-bold text-dark">PB Prabu</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation" data-testid="mobile-menu-button">
            <i class="bi bi-list text-secondary fs-4"></i>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <div class="navbar-nav me-2">
                <?php foreach ($mainLinks as $link):
                    $isActive = ($currentUrl === $link['path']);
                    $activeClass = $isActive ? 'active' : '';
                ?>
                    <a
                        class="nav-link px-3 py-2 fw-medium transition-all <?= $activeClass ?> text-secondary"
                        href="<?= $link['path'] ?>"
                        data-testid="nav-<?= strtolower($link['label']) ?>">
                        <i class="bi bi-<?= $link['icon'] ?> me-2"></i>
                        <?= $link['label'] ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <a href="<?= $adminLink['path'] ?>">
                <button
                    class="btn btn-outline-info btn-sm fw-medium border-2"
                    data-testid="admin-login-nav-button">
                    <i class="bi bi-lock-fill me-2"></i>
                    Admin
                </button>
            </a>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
            <div class="d-flex align-items-center">
                <div class="logo-icon me-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-trophy-fill text-white fs-6"></i>
                </div>
                <span class="fs-5 fw-bold text-dark">PB Prabu</span>
            </div>
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="d-flex flex-column">
            <?php foreach ($mainLinks as $link):
                $isActive = ($currentUrl === $link['path']);
                $activeClass = $isActive ? 'active' : '';
            ?>
                <a
                    href="<?= $link['path'] ?>"
                    data-testid="mobile-nav-<?= strtolower($link['label']) ?>"
                    class="mobile-link text-decoration-none p-3 rounded-3 fw-medium mb-1 transition-all <?= $activeClass ?> text-dark"
                    data-bs-dismiss="offcanvas">
                    <i class="bi bi-<?= $link['icon'] ?> me-3 fs-5"></i>
                    <?= $link['label'] ?>
                </a>
            <?php endforeach; ?>

            <hr class="my-2">

            <a
                href="<?= $adminLink['path'] ?>"
                data-testid="mobile-admin-login-button"
                class="mobile-link text-decoration-none p-3 rounded-3 fw-medium text-info hover:bg-light"
                data-bs-dismiss="offcanvas">
                <i class="bi bi-lock-fill me-3 fs-5"></i>
                <?= $adminLink['label'] ?>
            </a>
        </div>
    </div>
</div>