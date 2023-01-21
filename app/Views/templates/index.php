<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>

    <!-- Nunito Google Fonts -->
    <link rel="stylesheet" href="<?= base_url(); ?>/css/nunitofont.css">
    <!-- Bootstrap v5.1.3 CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>/css/bootstrap.css">
    <!-- idk -->
    <link rel="stylesheet" href="<?= base_url(); ?>/vendor/iconly/bold.css">

    <link rel="stylesheet" href="<?= base_url(); ?>/vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!-- <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="<?= base_url(); ?>/css/app.css">
    <!-- Font Awesome Icons v6.2.1 -->
    <link href="<?= base_url(); ?>/vendor/fontawesome-free-6.2.1-web/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- DataTable Style -->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/vendor/datatables/datatables.min.css">
    <!-- Aveneraa's Style -->
    <link href="<?= base_url(); ?>/css/ave-style.css" rel="stylesheet">
    <!-- Jquery Default File -->
    <script src="<?= base_url(); ?>/vendor/jquery/jquery.min.js"></script>
</head>

<body class="bg-main">
    <div id="app">
        <?= $this->include('templates/sidebar'); ?>
        <div id="main">
            <!-- Main Content -->
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="fa-solid fa-bars"></i>
                    <!-- <i class="bi bi-justify fs-3"></i> -->
                </a>
            </header>
            <?= $this->renderSection('page-content'); ?>
            <!-- Footer -->
            <?= $this->include('templates/footer'); ?>
        </div>
    </div>
    <script src="<?= base_url(); ?>/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url(); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- <script src="assets/vendors/apexcharts/apexcharts.js"></script> -->
    <!-- <script src="<?php // echo base_url(); ?>/js/pages/dashboard.js"></script> -->

    <script src="<?= base_url(); ?>/js/main.js"></script>

    <!-- Sweet Alert Javascript and JQuery (include CSS) -->
    <script src="<?= base_url(); ?>/js/sweetalert2.all.min.js"></script>
    <!-- JQuery Datatable -->
    <script src="<?= base_url(); ?>/vendor/datatables/jquery.dataTables.min.js"></script>
    <!-- JS DataTable -->
    <script src="<?= base_url(); ?>/vendor/datatables/datatables.min.js"></script>
</body>

</html>