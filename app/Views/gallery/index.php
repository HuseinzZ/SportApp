<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-2 mb-3">
            <span class="text-muted fw-light">Master /</span> Galeri
        </h4>

        <?= session()->getFlashdata('success') ? '<div class="alert alert-success alert-dismissible" role="alert">' . session()->getFlashdata('success') . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>' : '' ?>
        <?= session()->getFlashdata('error') ? '<div class="alert alert-danger alert-dismissible" role="alert">' . session()->getFlashdata('error') . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>' : '' ?>

        <a href="<?= site_url('admin/gallery/a_gallery') ?>" class="btn btn-primary mb-3">
            <i class="bx bx-plus me-1"></i> Tambah Galeri
        </a>

        <div class="card">
            <h5 class="card-header">Daftar Galeri</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Judul Event</th>
                            <th>Deskripsi</th>
                            <th>Tanggal Event</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php if (empty($gallery_list)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada data Galeri.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($gallery_list as $item): ?>
                                <tr>
                                    <td><?= esc($item['id']) ?></td>
                                    <td>
                                        <?php if (!empty($item['photo'])): ?>
                                            <img src="<?= base_url('assets/img/gallery/' . $item['photo']) ?>"
                                                alt="Foto Event"
                                                class="img-thumbnail"
                                                width="60" height="60" style="object-fit: cover;">
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['title']) ?></td>
                                    <td><?= esc(substr($item['description'], 0, 50)) . (strlen($item['description']) > 50 ? '...' : '') ?></td>
                                    <td><?= date('d M Y', strtotime($item['event_date'])) ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="<?= site_url('admin/gallery/e_gallery/' . $item['id']) ?>">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <form action="<?= site_url('admin/gallery/d_gallery/' . $item['id']) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini? Semua foto terkait akan terhapus.');">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bx bx-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
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