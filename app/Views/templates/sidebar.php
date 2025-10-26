<?php
$uri = service('uri');
$segment2 = $uri->getSegment(2);

$tournament_segments = ['schedules', 'tournament-points', 'matches'];
$isTournamentActive = in_array($segment2, $tournament_segments);
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
        <li class="menu-item <?= $segment2 === 'dashboard' ? 'active' : '' ?>">
            <a href="<?= base_url('admin/dashboard') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Halaman Utama</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Master Data</span>
        </li>

        <li class="menu-item <?= $segment2 === 'players' ? 'active' : '' ?>">
            <a href="<?= base_url('admin/players') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-pin"></i>
                <div>Pemain</div>
            </a>
        </li>

        <li class="menu-item <?= $segment2 === 'gors' ? 'active' : '' ?>">
            <a href="<?= base_url('admin/gors') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-area"></i>
                <div>Gor</div>
            </a>
        </li>

        <li class="menu-item <?= $segment2 === 'gallery' ? 'active' : '' ?>">
            <a href="<?= base_url('admin/gallery') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-images"></i>
                <div>Galeri</div>
            </a>
        </li>

        <li class="menu-item <?= $isTournamentActive ? 'open active' : '' ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-trophy"></i>
                <div>Manajemen Pertandingan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= $segment2 === 'schedules' || $segment2 === 'matches' ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/schedules') ?>" class="menu-link">
                        <div>Jadwal Pertandingan</div>
                    </a>
                </li>
                <li class="menu-item <?= $segment2 === 'tournament-points' ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/tournament-points') ?>" class="menu-link">
                        <div>Poin Turnamen</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Laporan</span>
        </li>
        <li class="menu-item <?= $segment2 === 'ranking' ? 'active' : '' ?>">
            <a href="<?= base_url('admin/ranking') ?>" class="menu-link">
                <div>Ranking Poin Global</div>
            </a>
        </li>

    </ul>
</aside>