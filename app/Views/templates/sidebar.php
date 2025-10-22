<?php
$uri = service('uri');
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="<?= base_url('admin/dashboard') ?>" class="app-brand-link">
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
        <li class="menu-item <?= $uri->getSegment(2) === 'dashboard' ? 'active' : '' ?>">
            <a href="<?= base_url('admin/dashboard') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Halaman Utama</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Master</span>
        </li>

        <li class="menu-item <?= $uri->getSegment(2) === 'gallery' ? 'active' : '' ?>">
            <a href="<?= base_url('admin/gallery') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-images"></i>
                <div>Galeri</div>
            </a>
        </li>

        <li class="menu-item <?= $uri->getSegment(2) === 'gors' ? 'active' : '' ?>">
            <a href="<?= base_url('admin/gors') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-area"></i>
                <div>Gor</div>
            </a>
        </li>

        <li class="menu-item <?= $uri->getSegment(2) === 'schedules' ? 'active' : '' ?>">
            <a href="<?= base_url('admin/schedules') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                <div>Jadwal</div>
            </a>
        </li>

        <li class="menu-item <?= $uri->getSegment(2) === 'players' ? 'active' : '' ?>">
            <a href="<?= base_url('admin/players') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-pin"></i>
                <div>Pemain</div>
            </a>
        </li>

        <li class="menu-item <?= $uri->getSegment(2) === 'points' ? 'active' : '' ?>">
            <a href="<?= base_url('admin/points') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-ol"></i>
                <div>Point</div>
            </a>
        </li>

        <li class="menu-item <?= $uri->getSegment(2) === 'record-match' ? 'active' : '' ?>">
            <a href="<?= base_url('admin/record-match') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-trophy"></i>
                <div>Skor Pertandingan</div>
            </a>
        </li>
    </ul>
</aside>