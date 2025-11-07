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
$isScheduleActive = ($segment1 === 'schedule');
$isMemberActive = ($segment1 === 'member');
?>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="d-none d-xl-block">
        <div style="padding: 0.5rem 0; text-align: center; position: relative;">
            <a href="<?= base_url() ?>"
                style="display: flex; flex-direction: column; align-items: center; text-decoration: none; color: inherit">

                <span style="display: block; margin-bottom: 5px;">
                    <img src="<?= base_url('assets/img/1.png') ?>" alt="Logo PB PRABU"
                        class="d-none d-xl-block" style="height: 120px; width: auto; display: block;" />
                    <img src="<?= base_url('assets/img/1.png') ?>" alt="Logo PB PRABU"
                        class="d-block d-xl-none" style="height: 60px; width: auto; display: block;" />
                </span>

                <span style="font-weight: bold; font-size: 1.2rem; text-transform: uppercase">
                    PB PRABU BANDUNG
                </span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none" style="position: absolute; right: 15px; top: 10px;">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
        </div>
    </div>

    <div class="d-block d-xl-none">
        <div class="app-brand demo mb-3" style="padding: 4rem;">
            <a href="<?= base_url() ?>" class="app-brand-link">
                <span class="app-brand-logo demo ms-4">
                    <img src="<?= base_url('assets/img/1.png') ?>" alt="Logo PB PRABU" style="height: 95px; width: auto" />
                </span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
        </div>
    </div>


    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1 mt-0 mt-xl-4">
        <li class="menu-item <?= $isHome ? 'active' : '' ?>">
            <a href="<?= base_url() ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home"></i>
                <div>Beranda</div>
            </a>
        </li>

        <li class="menu-item <?= $isRankingActive ? 'active' : '' ?> mt-2">
            <a href="<?= base_url('leaderboard') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bar-chart"></i>
                <div>Daftar Peringkat</div>
            </a>
        </li>

        <li class="menu-item <?= $isGalleryActive ? 'active' : '' ?> mt-2">
            <a href="<?= base_url('gallery') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-images"></i>
                <div>Galeri</div>
            </a>
        </li>

        <li class="menu-item <?= $isScheduleActive ? 'active' : '' ?> mt-2">
            <a href="<?= base_url('schedule') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-trophy"></i>
                <div>Pertandingan</div>
            </a>
        </li>

        <li class="menu-item <?= $isMemberActive ? 'active' : '' ?> mt-2">
            <a href="<?= base_url('member') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-pin"></i>
                <div>Anggota</div>
            </a>
        </li>

        <li class="menu-item <?= $isAboutActive ? 'active' : '' ?> mt-2">
            <a href="<?= base_url('about') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-info-circle"></i>
                <div>Tentang Kami</div>
            </a>
        </li>
    </ul>
</aside>