<div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
        <?php $session = service('session'); ?>
        <?php if ($session->getFlashdata('error')): ?>
            <div class="alert alert-danger text-center mb-3" role="alert">
                <?= $session->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if ($session->getFlashdata('success')): ?>
            <div class="alert alert-success text-center mb-3" role="alert">
                <?= $session->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <div class="app-brand justify-content-center">
                    <a href="<?= site_url('admin/dashboard') ?>" class="app-brand-link gap-2">
                        <span class="app-brand-text demo text-body fw-bolder">Admin Panel</span>
                    </a>
                </div>
                <h4 class="mb-2">Selamat datang kembali! 👋</h4>
                <p class="mb-4">Harap, masuk menggunakan akun anda dan mulai menjelajah</p>

                <form id="formAuthentication" class="mb-3" action="<?= site_url('admin') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input
                            type="text"
                            class="form-control <?= $validation->hasError('username') ? 'is-invalid' : '' ?>"
                            id="username"
                            name="username"
                            placeholder="Enter your username"
                            value="<?= old('username') ?>"
                            autofocus />
                        <div class="invalid-feedback">
                            <?= $validation->getError('username') ?>
                        </div>
                    </div>

                    <div class="mb-3 form-password-toggle">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password">Password</label>
                        </div>
                        <div class="input-group input-group-merge">
                            <input
                                type="password"
                                class="form-control <?= $validation->hasError('password') ? 'is-invalid' : '' ?>"
                                id="password"
                                name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            <div class="invalid-feedback">
                                <?= $validation->getError('password') ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary d-grid w-100" type="submit">Log in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>