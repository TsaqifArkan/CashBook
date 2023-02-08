<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<?php //dd(is_null($data), isset($data), empty($data)); ?>

<!-- <div class="alert alert-breadcrumb-ave" role="alert">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 fs-6">
            <li class="breadcrumb-item active" aria-current="page">Jurnal</li>
        </ol>
    </nav>
</div> -->

<div class="container-fluid ">

    <!-- FLASH DATA -->
    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('msg'); ?>"></div>

    <!-- Page Heading -->
    <div class="row my-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Jurnal</h1>
        </div>
    </div>

    <div class="alert bgmainalert" role="alert">
        <p class="mb-1"><i class="fa-solid fa-lightbulb me-1"></i>
        Tombol <b>Jual/Beli Barang</b> digunakan untuk menambah transaksi pemasukan dan pengeluaran barang. Tombol <b>Transaksi Lainnya</b> digunakan untuk menambah transaksi diluar jual beli barang.</p>
        <p class=""><i class="fa-solid fa-lightbulb me-1"></i>
        <strong>Perhatian!</strong> Data yang ditampilkan di <b>Jurnal</b> adalah data harian.</p>
    </div>

    <div class="row mb-3">
        <div class="col">
            <a href="<?= base_url('jurnal/jualbeli'); ?>" class="btn btn-success">
                <span class="me-1"><i class="fa-solid fa-fw fa-circle-plus"></i></span>
                <span>Jual/Beli Barang</span>
            </a>
            <!-- Button trigger modal -->
            <button type="button"
                class="btn btn-success addOtherTrans justify-content-between align-items-center"
                data-bs-target="#modalTambahOther">
                <span class="me-1"><i class="fa-solid fa-fw fa-circle-plus"></i></span>
                <span>Transaksi Lainnya</span>
            </button>
        </div>
        <div class="col">
            
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-2">
                    <div class="row">
                        <div class="col">
                            <h6 class="m-1 fw-bold text-uppercase">Tabel Jurnal</h6>
                        </div>
                    </div>
                    <div class="row justify-content-around">
                        <div class="col-3">
                            <label for="awal">Tanggal Awal</label>
                            <input type="date" class="form-control mb-3 tanggal" id="awal" value="<?= $now; ?>">
                        </div>
                        <div class="col-3">
                            <label for="akhir">Tanggal Akhir</label>
                            <input type="date" class="form-control mb-3 tanggal" id="akhir" value="<?= $now; ?>">
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable-Jurnal">
                            <thead class="ave-bg-th" id="tableJurnal">
                                <tr class="text-center">
                                    <th class="text-uppercase fw-bold head-no">No</th>
                                    <th class="text-uppercase fw-bold">Tanggal</th>
                                    <th class="text-uppercase fw-bold">Keterangan</th>
                                    <th class="text-uppercase fw-bold">Nama Barang</th>
                                    <th class="text-uppercase fw-bold">Jumlah</th>
                                    <th class="text-uppercase fw-bold">Satuan</th>
                                    <th class="text-uppercase fw-bold">Jenis Transaksi</th>
                                    <th class="text-uppercase fw-bold">Harga</th>
                                    <th class="text-uppercase fw-bold">Total</th>
                                    <th class="text-uppercase fw-bold head-aksi-klas">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="sectiondatajurnal">
                                <?= view('jurnal/tablejurnal', $data); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="viewModalEditTrans" style="display: none;"></div>
<div class="viewModalAddOther" style="display: none;"></div>
<script>
    $('.tanggal').change(function () {
        $('.sectiondatajurnal').html('');
        $.ajax({
            method: "POST",
            url: "<?= base_url('jurnal/getData'); ?>",
            data: {
                awal: $('#awal').val(),
                akhir: $('#akhir').val()
            },
            dataType: "JSON",
            success: function (response) {
                $('.sectiondatajurnal').html(response.data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                var tab = window.open('about:blank', '_blank');
                tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                tab.document.close(); // to finish loading the page
            }
        });
    });

    $(document).ready(function () {
        $('.addOtherTrans').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('jurnal/formaddother'); ?>",
                dataType: "JSON",
                success: function (response) {
                    $('.viewModalAddOther').html(response.data).show();
                    $('#modalAddOther').modal('show');
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