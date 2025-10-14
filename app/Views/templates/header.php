<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title; ?></title>

    <link href="<?= base_url('assets/'); ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?= base_url('assets/'); ?>vendor/icons/font/bootstrap-icons.min.css" rel="stylesheet">

    <link href="<?= base_url('assets/'); ?>css/navbar.css" rel="stylesheet">

</head>

<body class="bg-light">

    <?= $this->include('templates/navbar') ?>

    <div class="container mt-4">
        <?= $this->renderSection('content') ?>
    </div>

    <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>