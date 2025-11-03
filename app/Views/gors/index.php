<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-2 mb-3">
            <span class="text-muted fw-light">Master /</span> GOR
        </h4>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <a href="<?= site_url('admin/gors/a_gors') ?>" class="btn btn-primary mb-3">
            <i class="bx bx-plus me-1"></i> Tambah GOR
        </a>

        <div class="card">
            <h5 class="card-header">Daftar GOR</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Nama GOR</th>
                            <th>Alamat</th>
                            <th>Kontak</th>
                            <th>Harga Sewa</th>
                            <th>Deskripsi</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php if (empty($gor_list)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada data GOR.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($gor_list as $gor): ?>
                                <tr>
                                    <td><?= esc($gor['gors_name']) ?></td>
                                    <td><?= esc(substr($gor['address'], 0, 30)) . (strlen($gor['address']) > 30 ? '...' : '') ?></td>

                                    <td><?= esc($gor['contact']) ?></td>
                                    <td><?= 'Rp ' . number_format($gor['price'], 0, ',', '.') ?></td>

                                    <td><?= esc(substr($gor['description'], 0, 30)) . (strlen($gor['description']) > 30 ? '...' : '') ?></td>
                                    <td>
                                        <?php if (!empty($gor['photo'])): ?>
                                            <img src="<?= base_url('assets/img/gors/' . $gor['photo']) ?>"
                                                alt="Foto GOR"
                                                class="rounded-circle"
                                                width="40" height="40" style="object-fit: cover;">
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?= site_url('admin/gors/e_gors/' . $gor['id']) ?>">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <a class="dropdown-item text-danger"
                                                    href="<?= site_url('admin/gors/d_gors/' . $gor['id']) ?>"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini? Semua foto terkait akan terhapus.');">
                                                    <i class="bx bx-trash me-1"></i> Hapus
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>