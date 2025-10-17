<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="<?= base_url('dashboard') ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img
                    src="<?= base_url('assets/img/1.png') ?>"
                    alt="Logo PB PRABU"
                    style="height: 60px; width: auto;" />
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2 fs-3 text-uppercase">PB PRABU</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1 mt-4">
        <li class="menu-item active">
            <a href="<?= base_url('dashboard') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Master</span>
        </li>
        <li class="menu-item">
            <a href="cards-basic.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-football"></i>
                <div data-i18n="Basic">Fields</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="cards-basic.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-images"></i>
                <div data-i18n="Basic">Galery</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="cards-basic.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-pin"></i>
                <div data-i18n="Basic">Players</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="cards-basic.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-ol"></i>
                <div data-i18n="Basic">Points</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="cards-basic.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-trophy"></i>
                <div data-i18n="Basic">Records Match</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="cards-basic.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                <div data-i18n="Basic">Schedules</div>
            </a>
        </li>
    </ul>
</aside>