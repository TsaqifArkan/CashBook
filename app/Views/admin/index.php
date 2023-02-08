<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<!-- FLASH DATA -->
<!-- <div class="flash-data" data-flashdata="<?php // echo session()->getFlashdata('pesan'); ?>"></div> -->

<div class="container-fluid">

    <div class="row my-2">
        <div class="col">
            <div class="p-5 mb-4 rounded-3 bg-jumbotron-ave">
                <div class="container-fluid py-5">
                    <h1 class="display-5 text-center">Selamat <?= $greet; ?>, <?= esc($admindata['username']); ?> !</h1>
                    <hr class="my-4">
                    <div class="row justify-content-center">
                        <div class="card mb-3 shadow" style="width: 50%;">
                            <div class="row no-gutters">
                                <div class="col p-0">
                                    <div class="usr-card">
                                        <!-- <div class="usr-display-picture">
                                        <img src="" alt="" class="img-thumbnail">
                                    </div> -->
                                        <div class="usr-banner"><img src="<?= base_url('img/curved4.jpg'); ?>" alt="">
                                        </div>
                                        <div class="usr-content">
                                            <div class="row" style="font-size: large;">
                                                <div class="col-5 text-center">
                                                    Username
                                                </div>
                                                <div class="col-7 fw-bold text-center">
                                                    <?= esc($admindata['username']); ?>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row" style="font-size: large;">
                                                <div class="col-5 text-center">
                                                    Fullname
                                                </div>
                                                <div class="col-7 fw-bold text-center">
                                                    <?= esc($admindata['namalengkap']) ? esc($admindata['namalengkap']) : '-'; ?>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row" style="font-size: large;">
                                                <div class="col-5 text-center">
                                                    Email Address
                                                </div>
                                                <div class="col-7 fw-bold text-center">
                                                    <?= esc($admindata['email']) ? esc($admindata['email']) : '-'; ?>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col text-center">
                                                    <button type="button" class="btn btn-warning" onclick="ubah()">Edit Profil</button>
                                                    <button type="button" class="btn btn-danger" onclick="password()">Ubah Password</button>
                                                    <button type="button" class="btn btn-dark" onclick="ubahSaldoAwal()">Ubah Saldo Awal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="viewModalAdmin" style="display: none;"></div>
<script>
    // Konfigurasi Tombol Edit Profil
    function ubah() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/formedit'); ?>",
            dataType: "JSON",
            success: function (response) {
                if (response.data) {
                    $('.viewModalAdmin').html(response.data).show();
                    $('#modalEditProfil').modal('show');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                var tab = window.open('about:blank', '_blank');
                tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                tab.document.close(); // to finish loading the page
            }
        });
    }

    // Konfigurasi Tombol Ubah Password
    function password() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/formpass'); ?>",
            dataType: "JSON",
            success: function (response) {
                if (response.data) {
                    $('.viewModalAdmin').html(response.data).show();
                    $('#modalUbahPass').modal('show');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                var tab = window.open('about:blank', '_blank');
                tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                tab.document.close(); // to finish loading the page
            }
        });
    }

    // Konfigurasi Ubah Saldo Awal
    function ubahSaldoAwal(){
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/formsalaw'); ?>",
            dataType: "JSON",
            success: function (response) {
                if (response.data) {
                    $('.viewModalAdmin').html(response.data).show();
                    $('#modalSaldo').modal('show');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                var tab = window.open('about:blank', '_blank');
                tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                tab.document.close(); // to finish loading the page
            }
        });
    }
</script>

<?= $this->endSection(); ?>