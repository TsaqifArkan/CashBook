<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>
        CashBook | Login
    </title>

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons v6.2.1 -->
    <link href="<?= base_url(); ?>/vendor/fontawesome-free-6.2.1-web/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Nunito Google Fonts -->
    <link rel="stylesheet" href="<?= base_url(); ?>/css/nunitofont.css">
    <!-- Bootstrap v5.1.3 CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>/css/bootstrap.css">
    <!-- idk -->
    <link rel="stylesheet" href="<?= base_url(); ?>/vendor/iconly/bold.css">

    <link rel="stylesheet" href="<?= base_url(); ?>/vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!-- <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="<?= base_url(); ?>/css/app.css">
    <!-- Aveneraa's Style -->
    <link href="<?= base_url(); ?>/css/ave-style.css" rel="stylesheet">
    <!-- CSS from Argon-Dashboard -->
    <link id="pagestyle" href="<?= base_url(); ?>/css/argon-dashboard.css" rel="stylesheet" />
</head>

<body class="login-bg-ave">
    <!-- Content -->
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-100">
                <!-- try drop here -->
                <div
                    class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                    <div
                        class="position-relative h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden photo-login-ave">
                        <span class="mask bg-gradient-dark opacity-5"></span>
                    </div>
                </div>
                <!-- end of photos -->
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card">
                                <div class="card-header pb-2 text-center">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <h2 class="">Selamat Datang di CashBook!</h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <h5>Aplikasi Buku Kas BUMDes Tlogosari</h5>
                                        </div>
                                    </div>
                                    <div class="divider">
                                        <div class="divider-text">Login</div>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="col">
                                            <marquee>Silahkan masukkan username dan password Anda</marquee>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if (session('errors.login')): ?>
                                        <div class="alert alert-danger text-white" style="font-size: small;" role="alert">
                                            <?= session('errors.login') ?>
                                        </div>
                                    <?php endif; ?>
                                    <form action="<?= base_url('auth/attemptlogin'); ?>" method="post" class="admin">
                                        <div class="form-floating mb-3">
                                            <input
                                                class="form-control <?php if (session('errors.username')): ?>is-invalid<?php endif; ?>"
                                                id="username" name="username" type="text" placeholder="Username">
                                            <label for="username" class="fw-normal">Username</label>
                                            <div class="invalid-feedback">
                                                <?= session('errors.username'); ?>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input
                                                class="form-control <?php if (session('errors.password')): ?>is-invalid<?php endif; ?>"
                                                id="password" name="password" type="password" placeholder="Password"
                                                autocomplete>
                                            <label for="inputPassword" class="fw-normal">Password</label>
                                            <div class="invalid-feedback">
                                                <?= session('errors.password'); ?>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-lg bg-btn-login-ave w-100 mt-2 mb-2 text-white">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Photos should be here -->
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Core JS Files -->
    <script src="<?= base_url(); ?>/js/core/popper.min.js"></script>
    <script src="<?= base_url(); ?>/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url(); ?>/js/plugins/smooth-scrollbar.min.js"></script>
    <!-- <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script> -->
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?= base_url(); ?>/js/argon-dashboard.js"></script>
</body>

</html>