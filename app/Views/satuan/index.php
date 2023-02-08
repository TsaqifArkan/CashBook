<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<?php //echo dd($datas); ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-6">

            <!-- Page Heading -->
            <div class="row my-2">
                <div class="col">
                    <h1 class="h3 text-gray-800">Daftar Satuan Barang</h1>
                </div>
            </div>

            <div class="alert bgmainalert" role="alert">
                <p class="mb-1"><i class="fa-solid fa-lightbulb me-1"></i>
                <strong>Perhatian!</strong> Data suatu <b>Satuan</b> hanya bisa dihapus apabila tidak ada <b>Barang</b> yang menggunakan <b>Satuan</b> tersebut!</p>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <!-- Button trigger modal -->
                    <button type="button"
                        class="btn btn-success tombolTambahSatuan justify-content-between align-items-center"
                        data-bs-target="#modalTambahSatuan">
                        <span class="me-1"><i class="fa-solid fa-fw fa-circle-plus"></i></span>
                        <span>Tambah Satuan</span>
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-2">
                            <h6 class="m-1 fw-bold text-uppercase">Tabel Satuan</h6>
                        </div>
                        <div class="card-body">
                            <div class="sectiondatasatuan">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="viewModalSatuan" style="display: none;"></div>

<script>
    function tableSatuan() {
        $.ajax({
            url: "<?= base_url('satuan/getData'); ?>",
            dataType: "JSON",
            success: function (response) {
                $('.sectiondatasatuan').html(response.data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                var tab = window.open('about:blank', '_blank');
                tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                tab.document.close(); // to finish loading the page
            }
        });
    }

    // Konfigurasi Modal Tambah Satuan di index.php (satuan)
    $(document).ready(function () {
        tableSatuan();
        $('.tombolTambahSatuan').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('satuan/formtambah'); ?>",
                dataType: "JSON",
                success: function (response) {
                    $('.viewModalSatuan').html(response.data).show();
                    $('#modalTambahSatuan').modal('show');
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