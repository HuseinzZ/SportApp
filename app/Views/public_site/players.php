<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card shadow-lg">

            <div class="card-header d-flex flex-wrap justify-content-between align-items-center py-3">

                <h5 class="mb-0">
                    Daftar Anggota
                </h5>

                <form id="filterPlayersForm" action="<?= site_url('member') ?>" method="get"
                    class="d-flex flex-wrap align-items-center gap-2">

                    <div class="input-group input-group-sm" style="width: 180px;">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bx bx-filter-alt"></i>
                        </span>
                        <select name="level" id="levelFilter" class="form-select border-start-0"
                            onchange="document.getElementById('filterPlayersForm').submit()">
                            <option value="">Semua Level</option>
                            <option value="Utama" <?= (isset($selectedLevel) && $selectedLevel === 'Utama') ? 'selected' : '' ?>>Utama</option>
                            <option value="Pratama" <?= (isset($selectedLevel) && $selectedLevel === 'Pratama') ? 'selected' : '' ?>>Pratama</option>
                        </select>
                    </div>

                    <div class="input-group input-group-sm" style="width: 220px;">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bx bx-search"></i>
                        </span>
                        <input type="text" name="search" id="searchPlayerInput" class="form-control border-start-0" placeholder="Cari Nama Pemain..."
                            value="<?= esc($search ?? '') ?>" onkeyup="autoSubmitPlayers(event)">
                    </div>

                    <?php if (!empty($selectedLevel) || !empty($search)): ?>
                        <a href="<?= site_url('member') ?>" class="btn btn-sm btn-outline-danger">
                            <i class="bx bx-x me-1"></i> Reset Filter
                        </a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Foto</th>
                            <th>Nama Pemain</th>
                            <th>Level</th>
                            <th>Jenis Kelamin</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php if (empty($players)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Tidak ada data pemain yang terdaftar saat ini.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($players as $player):
                                $photoUrl = base_url('assets/img/players/' . $player['photo']);
                                $defaultAvatar = base_url('assets/img/avatars/default.png');
                                $displayPhoto = !empty($player['photo']) ? $photoUrl : $defaultAvatar;
                                $levelClass = $player['level'] === 'Utama' ? 'info' : 'secondary';
                                $playerId = esc($player['id'] ?? uniqid());
                            ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($player['photo'])): ?>
                                            <a href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#zoomModal<?= $playerId ?>">
                                                <img src="<?= $displayPhoto ?>"
                                                    alt="Foto <?= esc($player['player_name']) ?>"
                                                    class="rounded-circle shadow-sm"
                                                    width="45" height="45" style="object-fit: cover; cursor: pointer;">
                                            </a>
                                        <?php else: ?>
                                            <img src="<?= $defaultAvatar ?>"
                                                alt="Avatar Default"
                                                class="rounded-circle"
                                                width="45" height="45" style="object-fit: cover;">
                                        <?php endif; ?>
                                    </td>
                                    <td><span class="fw-medium"><?= esc($player['player_name']) ?></span></td>
                                    <td>
                                        <span class="badge bg-label-<?= $levelClass ?> me-1">
                                            <?= esc($player['level']) ?>
                                        </span>
                                    </td>
                                    <td><?= $player['gender'] === 'M' ? 'Pria' : 'Wanita' ?></td>
                                    <td>
                                        <span class="badge bg-label-<?= $player['is_active'] ? 'success' : 'danger' ?> me-1">
                                            <?= $player['is_active'] ? 'Aktif' : 'Tidak Aktif' ?>
                                        </span>
                                    </td>
                                </tr>

                                <?php if (!empty($player['photo'])): ?>
                                    <div class="modal fade" id="zoomModal<?= $playerId ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable custom-modal-no-content">
                                            <img src="<?= $photoUrl ?>"
                                                class="img-fluid rounded shadow-lg"
                                                style="max-width: 85vw; max-height: 85vh; object-fit: contain; cursor: zoom-out;"
                                                alt="Foto <?= esc($player['player_name']) ?>"
                                                data-bs-dismiss="modal">
                                        </div>
                                    </div>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Pastikan skrip ini hanya ada sekali di footer Anda atau di halaman ini
    let searchTimeout;

    function autoSubmitPlayers(event) {
        // Cek jika tombol yang ditekan adalah Enter (keyCode 13)
        if (event.keyCode === 13) {
            clearTimeout(searchTimeout);
            document.getElementById('filterPlayersForm').submit();
            return;
        }

        // Untuk menunda submit saat user masih mengetik
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('filterPlayersForm').submit();
        }, 800); // Tunda 800ms (0.8 detik) sebelum submit
    }
</script>
<style>
    /* ... (CSS styling for zoom modal remains the same) ... */
</style>
<style>
    /* 1. Paksa Dialog Modal untuk mengisi seluruh ruang viewport */
    .modal-dialog.custom-modal-no-content {
        max-width: 100vw;
        width: 100vw;
        height: 100vh;
        margin: 0;
        padding: 0;

        /* Pengaturan Flexbox untuk Pemusatan */
        display: flex;
        align-items: center;
        /* Pusatkan Vertikal */
        justify-content: center;
        /* Pusatkan Horizontal */

        pointer-events: none;
        /* Memungkinkan klik melalui dialog ke backdrop */
    }

    /* 2. Sesuaikan ukuran batas gambar (misalnya 85% dari viewport) */
    .custom-modal-no-content img {
        max-width: 85vw !important;
        /* Batas ruang 7.5% di kiri dan 7.5% di kanan */
        max-height: 85vh !important;
        /* Batas ruang 7.5% di atas dan 7.5% di bawah */
        pointer-events: auto;
    }

    /* 3. Opasitas Backdrop (agar tidak terlalu hitam) */
    .modal-backdrop.show {
        opacity: 0.6;
        /* Nilai opasitas yang lebih rendah (misalnya 0.6) */
        background-color: #000;
    }

    /* --- Styling Thumbnail (Player Photo) --- */
    /* Opsional: Tambahkan sedikit efek untuk foto di tabel agar lebih interaktif */
    .rounded-circle {
        transition: transform 0.2s;
    }

    .rounded-circle:hover {
        transform: scale(1.1);
    }

    @media (max-width: 767px) {

        /* Menargetkan wrapper filter */
        .card-header>form#filterPlayersForm {
            /* Izinkan flex-wrap untuk mengatur item dalam beberapa baris jika ruangnya tidak cukup */
            /* Ini sudah diatur di HTML dengan class 'd-flex flex-wrap' (Bootstrap) */

            /* Untuk memastikan form filter menggunakan lebar penuh container pada mobile */
            width: 100%;
            /* Atur jarak antar baris item jika terbungkus */
            gap: 10px 0;
        }

        /* Menargetkan input-group (Filter Level dan Search) */
        .card-header>form#filterPlayersForm>.input-group {
            /* Paksa input-group untuk mengambil lebar penuh */
            width: 100% !important;
        }

        /* Opsi: JIKA Anda ingin Reset Button di bawah semua filter */
        /* Anda bisa menambahkan class khusus ke tombol reset jika ingin memisahkannya */
        /* Contoh di bawah hanya memastikan jarak yang konsisten */

        /* Jarak untuk tombol reset (Jika ada) */
        .card-header>form#filterPlayersForm>a.btn {
            width: 100%;
            /* Atau biarkan sesuai kontennya */
            margin-top: 5px;
            /* Tambahkan sedikit jarak di atas */
        }

        /* Pastikan elemen di card-header (judul dan form) mendapat jarak yang cukup */
        .card-header {
            /* Mengatur form dan judul agar berbaris vertikal di mobile jika perlu */
            flex-direction: column;
            align-items: flex-start !important;
            /* Agar konten rata kiri */
        }

        /* Tambahkan jarak antara judul dan form di mobile */
        .card-header h5.mb-0 {
            margin-bottom: 1rem !important;
            /* Jarak yang lebih besar setelah judul */
        }
    }
</style>