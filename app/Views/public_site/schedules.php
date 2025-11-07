<style>
    /* CSS KUSTOM UNTUK ANIMASI HOVER PADA KARTU */
    .transition-3d-hover {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .transition-3d-hover:hover {
        /* Menggeser kartu sedikit ke atas dan menambahkan bayangan 3D */
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }

    /* Animasi untuk status "In-Progress" */
    @keyframes pulse-warning {
        0% {
            background-color: rgba(255, 193, 7, 0.5);
        }

        50% {
            background-color: rgba(255, 193, 7, 1);
        }

        100% {
            background-color: rgba(255, 193, 7, 0.5);
        }
    }

    .pulsing-badge.bg-label-warning {
        animation: pulse-warning 1.5s infinite;
    }

    /* Animasi Tombol saat status completed */
    .btn-primary:hover {
        transform: translateY(-2px);
        transition: transform 0.2s ease-out;
    }
</style>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-4 justify-content-center">
            <?php if (empty($schedules)): ?>
                <div class="col-12">
                    <div class="card p-5 text-center shadow-sm">
                        <h5 class="text-muted mb-0">
                            Belum ada jadwal pertandingan yang tersedia saat ini.
                        </h5>
                        <p class="text-muted mt-2">Nantikan pembaruan selanjutnya!</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($schedules as $schedule):
                    // Menentukan kelas badge status
                    $statusClass = [
                        'Scheduled'   => 'info',
                        'In-Progress' => 'warning',
                        'Completed'   => 'success',
                        'Cancelled'   => 'danger',
                    ][$schedule['status']] ?? 'secondary';
                ?>
                    <div class="col-lg-4 col-md-6 col-sm-12" data-aos="fade-up" data-aos-duration="1000">
                        <div class="card h-100 shadow-sm border-0 transition-3d-hover">
                            <div class="position-relative">
                                <img class="card-img-top rounded-top"
                                    src="<?= base_url('assets/img/gors/' . esc($schedule['photo'])) ?>"
                                    alt="Foto GOR <?= esc($schedule['gors_name']) ?>"
                                    style="height: 200px; object-fit: cover;">

                                <span class="badge bg-label-<?= $statusClass ?> position-absolute top-0 end-0 m-2 fw-bold text-uppercase 
                                    <?= ($schedule['status'] === 'In-Progress') ? 'pulsing-badge' : '' ?>">
                                    <?= esc($schedule['status']) ?>
                                </span>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-dark mb-3">
                                    <?= esc($schedule['series_level']) ?>
                                </h5>

                                <ul class="list-unstyled mb-4">
                                    <li class="mb-2 d-flex align-items-center">
                                        <i class="bx bx-calendar fs-5 text-primary me-2"></i>
                                        <div class="small text-dark">
                                            Tanggal & Waktu: <span class="fw-medium"><?= esc(date('d M Y, H:i', strtotime($schedule['match_date']))) ?></span>
                                        </div>
                                    </li>
                                    <li class="mb-2 d-flex align-items-center">
                                        <i class="bx bx-map-pin fs-5 text-primary me-2"></i>
                                        <div class="small text-dark">
                                            Lokasi: <span class="fw-medium"><?= esc($schedule['gors_name']) ?></span>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="bx bx-tag-alt fs-5 text-primary me-2"></i>
                                        <div class="small text-dark">
                                            Kategori: <span class="fw-medium"><?= esc($schedule['match_type']) ?></span>
                                        </div>
                                    </li>
                                </ul>

                                <div class="mt-auto pt-3 border-top text-center">
                                    <?php if ($schedule['status'] === 'Completed'): ?>
                                        <a href="<?= site_url('schedule/' . $schedule['id']) ?>" class="btn btn-primary w-100">
                                            <i class="bx bx-trophy me-1"></i> Lihat Hasil Pertandingan
                                        </a>
                                    <?php elseif ($schedule['status'] === 'In-Progress'): ?>
                                        <span class="text-warning fw-medium">
                                            <i class="bx bx-loader-alt bx-spin me-1"></i> Pertandingan Sedang Berlangsung...
                                        </span>
                                    <?php elseif ($schedule['status'] === 'Cancelled'): ?>
                                        <span class="text-danger fw-medium">
                                            <i class="bx bx-x-circle me-1"></i> Pertandingan Dibatalkan
                                        </span>
                                    <?php else: // Scheduled 
                                    ?>
                                        <span class="text-info fw-medium">
                                            <i class="bx bx-info-circle me-1"></i> Menunggu Jadwal Dimulai
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>