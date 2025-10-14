<div
    class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xxl-3">
                <div class="card mb-0">
                    <div class="card-body">

                        <?php $session = service('session'); ?>
                        <?php if ($session->getFlashdata('error')): ?>
                            <div class="alert alert-danger text-center" role="alert">
                                <?= $session->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <a href="<?= site_url() ?>" class="text-nowrap logo-img text-center d-block py-3 w-100">
                            <img src="<?= base_url('assets/img/logo.svg') ?>" alt="Logo">
                        </a>

                        <p class="text-center">Your Social Campaigns</p>

                        <form action="<?= site_url('admin') ?>" method="POST">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input
                                    type="text"
                                    class="form-control <?= $validation->hasError('username') ? 'is-invalid' : '' ?>"
                                    id="username"
                                    name="username"
                                    value="<?= old('username') ?>"
                                    autofocus>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('username') ?>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input
                                    type="password"
                                    class="form-control <?= $validation->hasError('password') ? 'is-invalid' : '' ?>"
                                    id="password"
                                    name="password">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('password') ?>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 mt-2 rounded-2">Log In</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>