<?php
$uri = service('uri');
$segmentCount = $uri->getTotalSegments();
$segment1 = $segmentCount >= 1 ? $uri->getSegment(1) : '';
$segment2 = $segmentCount >= 2 ? $uri->getSegment(2) : '';

// =========================
// 🔹 MENU PUBLIC
// =========================
$isHome = ($segment1 === '' && $segment2 === '');
$isRankingActive = ($segment1 === 'leaderboard' || $segment1 === 'history');
$isGalleryActive = ($segment1 === 'gallery');
$isAboutActive = ($segment1 === 'about');
$isContactActive = ($segment1 === 'contact');
?>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="<?= base_url() ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="<?= base_url('assets/img/1.png') ?>" alt="Logo PB PRABU" style="height: 50px; width: auto;" />
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2 fs-3 text-uppercase">PB PRABU</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1 mt-4">
        <!-- 🔹 Menu Beranda -->
        <li class="menu-item <?= $isHome ? 'active' : '' ?> mt-2">
            <a href="<?= base_url() ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home"></i>
                <div>Beranda</div>
            </a>
        </li>

        <!-- 🔹 Menu Daftar Peringkat -->
        <li class="menu-item <?= $isRankingActive ? 'active' : '' ?> mt-2">
            <a href="<?= base_url('leaderboard') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bar-chart"></i>
                <div>Daftar Peringkat</div>
            </a>
        </li>

        <!-- 🔹 Menu Galeri -->
        <li class="menu-item <?= $isGalleryActive ? 'active' : '' ?> mt-2">
            <a href="<?= base_url('gallery') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-images"></i>
                <div>Galeri</div>
            </a>
        </li>

        <!-- 🔹 Menu pertandingan -->
        <li class="menu-item <?= $isContactActive ? 'active' : '' ?> mt-2">
            <a href="<?= base_url('match') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-trophy"></i>
                <div>Pertandingan</div>
            </a>
        </li>

        <!-- 🔹 Menu Tentang Kami -->
        <li class="menu-item <?= $isAboutActive ? 'active' : '' ?> mt-2">
            <a href="<?= base_url('about') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-info-circle"></i>
                <div>Tentang Kami</div>
            </a>
        </li>
    </ul>
</aside>