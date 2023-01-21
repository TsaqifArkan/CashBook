<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<?php //echo dd($datas); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row my-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Daftar Akun</h1>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <!-- Button trigger modal -->
            <button type="button"
                class="btn btn-success tombolTambahAkun d-flex justify-content-between align-items-center"
                data-bs-target="#modalTambahAkun">
                <span class="me-1"><i class="fa-solid fa-fw fa-circle-plus"></i></span>
                <span>Tambah Akun</span>
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-2">
                    <h6 class="m-1 fw-bold text-uppercase">Tabel Daftar Akun</h6>
                </div>
                <div class="card-body">
                    <div class="sectiondataakun">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="viewModalAkun" style="display: none;"></div>

<script>
    function tableAkun() {
        $.ajax({
            url: "<?= base_url('akun/getData'); ?>",
            dataType: "JSON",
            success: function (response) {
                $('.sectiondataakun').html(response.data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                var tab = window.open('about:blank', '_blank');
                tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                tab.document.close(); // to finish loading the page
            }
        });
    }

    // Konfigurasi Modal Tambah Akun di index.php (akun)
    $(document).ready(function () {
        tableAkun();
        $('.tombolTambahAkun').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('akun/formtambah'); ?>",
                dataType: "JSON",
                success: function (response) {
                    $('.viewModalAkun').html(response.data).show();
                    $('#modalTambahAkun').modal('show');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    var tab = window.open('about:blank', '_blank');
                    tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                    tab.document.close(); // to finish loading the page
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>