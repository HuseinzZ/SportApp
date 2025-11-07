<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="alert alert-info d-flex align-items-center" role="alert">
            <i class="bx bx-info-circle me-2 fs-4"></i>
            <div>
                Poin dihitung berdasarkan akumulasi total poin yang diperoleh dari setiap jadwal pertandingan (Level Seri).
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bx bx-bar-chart me-2"></i> Daftar Peringkat
                </h5>

                <form id="filterRankingForm" action="<?= site_url('leaderboard') ?>" method="get"
                    class="d-flex flex-wrap align-items-center gap-2">

                    <div class="input-group input-group-sm" style="width: 180px;">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bx bx-filter-alt"></i>
                        </span>
                        <select name="level" id="levelFilter" class="form-select border-start-0"
                            onchange="document.getElementById('filterRankingForm').submit()">
                            <option value="">Semua Level</option>
                            <option value="Utama" <?= (isset($selectedLevel) && $selectedLevel === 'Utama') ? 'selected' : '' ?>>Utama</option>
                            <option value="Pratama" <?= (isset($selectedLevel) && $selectedLevel === 'Pratama') ? 'selected' : '' ?>>Pratama</option>
                        </select>
                    </div>

                    <div class="input-group input-group-sm" style="width: 220px;">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bx bx-search"></i>
                        </span>
                        <input type="text" name="search" id="searchRankingInput"
                            class="form-control border-start-0"
                            placeholder="Cari Nama Pemain..."
                            value="<?= esc($search ?? '') ?>"
                            onkeyup="autoSubmitRanking(event)">
                    </div>

                    <?php if (!empty($selectedLevel) || !empty($search)): ?>
                        <a href="<?= site_url('leaderboard') ?>" class="btn btn-sm btn-outline-danger">
                            <i class="bx bx-x me-1"></i> Reset Filter
                        </a>
                    <?php endif; ?>

                </form>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th width="5%">RANK</th>
                            <th width="5%">FOTO</th>
                            <th width="15%">PEMAIN</th>
                            <th width="10%">LEVEL</th>
                            <th width="15%">TOTAL POIN</th>
                            <th width="10%">WR</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($ranking)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4"> <i class="bx bx-info-circle fs-4 d-block mb-2"></i>
                                    Belum ada data poin ranking yang dihitung.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $rank = 1; ?>
                            <?php foreach ($ranking as $playerRank):
                                $detail = $playerDetails[$playerRank['player_id']] ?? null;
                                $history_url = site_url('leaderboard/' . $playerRank['player_id']);
                                $winRate = $playerRank['win_rate'] ?? 0;

                                // LOGIKA FOTO
                                $photoFileName = $detail['photo'] ?? null; // Asumsi 'photo' adalah nama file foto
                                $defaultAvatar = base_url('assets/img/avatars/default.png');

                                // Sesuaikan path ini dengan struktur folder Anda jika berbeda
                                $photoUrl = $photoFileName ? base_url('assets/img/players/' . $photoFileName) : $defaultAvatar;
                                $playerId = esc($playerRank['player_id'] ?? uniqid());
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge bg-label-<?= $rank <= 3 ? 'warning' : 'secondary' ?> fs-6">
                                            <?= $rank++ ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?php if ($photoFileName): ?>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#zoomModal<?= $playerId ?>">
                                                <img src="<?= $photoUrl ?>"
                                                    alt="Foto <?= esc($playerRank['player_name']) ?>"
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

                                    <td>
                                        <a href="<?= $history_url ?>"
                                            class="text-secondary fw-bold text-decoration-none d-flex align-items-center">
                                            <span><?= esc($playerRank['player_name']) ?></span>
                                        </a>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-label-<?= ($detail['level'] ?? '') === 'Utama' ? 'info' : 'secondary' ?> me-1">
                                            <?= esc($detail['level'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary fs-6 px-3 py-2">
                                            <?= esc($playerRank['total_points']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <strong><?= $winRate ?>%</strong>
                                    </td>
                                </tr>

                                <?php if ($photoFileName): ?>
                                    <div class="modal fade" id="zoomModal<?= $playerId ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable custom-modal-no-content">
                                            <img src="<?= $photoUrl ?>"
                                                class="img-fluid rounded shadow-lg"
                                                style="max-width: 85vw; max-height: 85vh; object-fit: contain; cursor: zoom-out;"
                                                alt="Foto <?= esc($playerRank['player_name']) ?>"
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
    let searchTimeout;

    function autoSubmitRanking(event) {
        if (event.keyCode === 13) { // Enter key
            clearTimeout(searchTimeout);
            document.getElementById('filterRankingForm').submit();
            return;
        }

        // Tunda submit saat user mengetik
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('filterRankingForm').submit();
        }, 800);
    }
</script>
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

        /* BARIS INI DIHAPUS/DIKOMENTARI:
        pointer-events: none; 
        */
    }

    /* 2. Sesuaikan ukuran batas gambar */
    .custom-modal-no-content img {
        max-width: 85vw !important;
        max-height: 85vh !important;
        pointer-events: auto;
        /* Penting: agar gambar bisa diklik/dismiss */
    }

    /* 3. Opasitas Backdrop (agar tidak terlalu hitam) */
    .modal-backdrop.show {
        opacity: 0.6;
        background-color: #000;
    }

    /* --- Styling Thumbnail (Player Photo) --- */
    .rounded-circle {
        transition: transform 0.2s;
    }

    .rounded-circle:hover {
        transform: scale(1.1);
    }

    @media (max-width: 767px) {

        /* Menyesuaikan card-header: Judul di atas, Filter di bawah */
        .card-header {
            /* Bootstrap d-flex justify-content-between diubah */
            flex-direction: column;
            align-items: flex-start !important;
            /* Rata kiri */
        }

        /* Menambahkan jarak setelah judul di mobile */
        .card-header h5.mb-0 {
            margin-bottom: 1rem !important;
        }

        /* Menargetkan wrapper filter (form) */
        .card-header>form#filterRankingForm {
            width: 100%;
            /* Ambil lebar penuh */
            /* Jarak vertikal antar item filter */
            gap: 10px 0;
        }

        /* Menargetkan input-group (Select Level dan Search) */
        .card-header>form#filterRankingForm>.input-group {
            /* Paksa input-group untuk mengambil lebar penuh */
            width: 100% !important;
        }

        /* Membuat tombol Reset Filter mengambil lebar penuh */
        .card-header>form#filterRankingForm>a.btn {
            width: 100%;
        }
    }
</style>