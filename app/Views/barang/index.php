<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<?php //echo dd($datas); ?>

<!-- <div class="alert alert-breadcrumb-ave" role="alert">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 fs-6">
            <li class="breadcrumb-item active" aria-current="page">Barang</li>
        </ol>
    </nav>
</div> -->

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <!-- Page Heading -->
            <div class="row my-2">
                <div class="col">
                    <h1 class="h3 text-gray-800">Daftar Data Barang</h1>
                </div>
            </div>

            <div class="alert bgmainalert" role="alert">
                <p class="mb-1"><i class="fa-solid fa-lightbulb me-1"></i>
                <strong>Perhatian!</strong> Penghapusan data suatu barang akan menghapus seluruh informasi terkait barang tersebut!
                Riwayat transaksi barang yang telah tersimpan di <b>Jurnal</b> maupun <b>Bukukas</b> tidak akan terhapus.</p>
                <p><i class="fa-solid fa-lightbulb me-1"></i>
                <strong>Perhatian!</strong> Seluruh transaksi yang menggunakan nama barang termasuk ke dalam jenis <b>Transaksi Jual/Beli</b>.
                Penghapusan data suatu barang akan mengubah jenis transaksinya menjadi <b>Transaksi Lainnya</b> secara otomatis.</p>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <!-- Button trigger modal -->
                    <button type="button"
                        class="btn btn-success tombolTambahBarang justify-content-between align-items-center"
                        data-bs-target="#modalTambahBarang">
                        <span class="me-1"><i class="fa-solid fa-fw fa-circle-plus"></i></span>
                        <span>Tambah Data Barang</span>
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-2">
                            <h6 class="m-1 fw-bold text-uppercase">Tabel Barang</h6>
                        </div>
                        <div class="card-body">
                            <div class="sectiondatabarang">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="viewModalBarang" style="display: none;"></div>

<script>
    function tableBarang() {
        $.ajax({
            url: "<?= base_url('barang/getData'); ?>",
            dataType: "JSON",
            success: function (response) {
                $('.sectiondatabarang').html(response.data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                var tab = window.open('about:blank', '_blank');
                tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                tab.document.close(); // to finish loading the page
            }
        });
    }

    // Konfigurasi Modal Tambah Barang di index.php (barang)
    $(document).ready(function () {
        tableBarang();
        $('.tombolTambahBarang').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('barang/formtambah'); ?>",
                dataType: "JSON",
                success: function (response) {
                    $('.viewModalBarang').html(response.data).show();
                    $('#modalTambahBarang').modal('show');
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