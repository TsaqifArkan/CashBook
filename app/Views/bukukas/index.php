<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<!-- <div class="alert alert-breadcrumb-ave" role="alert">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 fs-6">
            <li class="breadcrumb-item active" aria-current="page">Buku Kas</li>
        </ol>
    </nav>
</div> -->

<div class="container-fluid">

    <!-- FLASH DATA -->
    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('msg'); ?>"></div>

    <!-- Page Heading -->
    <div class="row my-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Buku Kas</h1>
        </div>
    </div>

    <div class="alert bgmainalert" role="alert">
        <p class="mb-1"><i class="fa-solid fa-lightbulb me-1"></i>
        <strong>Perhatian!</strong> Data yang ada di <b>Buku Kas</b> berasal dari transaksi-transaksi yang ditambahkan melalui menu <b>Jurnal</b>. Anda dapat melakukan pengubahan maupun penghapusan terkait datanya melalui menu <b>Jurnal</b>.</p>
        <p><i class="fa-solid fa-lightbulb me-1"></i>
        <strong>Perhatian!</strong> Pastikan memilih rentang tanggal terlebih dahulu sebelum mencetak data <b>Buku Kas</b> ke bentuk Excel (.xlsx)!</p>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-2">
                    <div class="row">
                        <div class="col">
                            <h6 class="m-1 fw-bold text-uppercase">Tabel Buku Kas</h6>
                        </div>
                    </div>
                    <div class="row justify-content-around">
                        <div class="col-3">
                            <label class="mb-1" for="awal">Tanggal Awal</label>
                            <input type="date" class="form-control mb-3 tanggal" id="awal" value="<?= $now; ?>">
                        </div>
                        <div class="col-3">
                            <label class="mb-1" for="akhir">Tanggal Akhir</label>
                            <input type="date" class="form-control mb-3 tanggal" id="akhir" value="<?= $now; ?>">
                        </div>
                        <div class="col-3 justify-content-center text-center">
                            <label class="d-block mb-1" for="cetak">Cetak Buku Kas</label>
                            <a href="<?= base_url('bukukas/print') . '/' . $now . '/' . $now; ?>" type="button" class="btn btn-dark printBukuKas" target="_blank">
                                <i class="fa-solid fa-fw fa-print me-3"></i>Print</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover sectiondatabukukas" id="dataTable-Bukukas">
                            <?= view('bukukas/tablebukukas', $data); ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.tanggal').change(function () {
        const loc = '<?= base_url('bukukas/print') . '/'; ?>';
        let awal = $('#awal').val();
        let akhir = $('#akhir').val();
        $('.printBukuKas')[0].href = loc+awal+'/'+akhir;
        $('.sectiondatabukukas').html('');
        $.ajax({
            method: "POST",
            url: "<?= base_url('bukukas/getData'); ?>",
            data: {
                awal: awal,
                akhir: akhir
            },
            dataType: "JSON",
            success: function (response) {
                $('.sectiondatabukukas').html(response.data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                var tab = window.open('about:blank', '_blank');
                tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                tab.document.close(); // to finish loading the page
            }
        });
    });

    // $(document).ready(function () {
    //     $('.printBukuKas').click(function(e){
    //         e.preventDefault();
    //         $.ajax({
    //             method: "POST",
    //             url: "<?php // echo base_url('bukukas/print'); ?>",
    //             data: {
    //                 awal: $('#awal').val(),
    //                 akhir: $('#akhir').val()
    //             },
    //             dataType: "JSON",
    //             success: function (response) {
                    
    //             },
    //             error: function (xhr, ajaxOptions, thrownError) {
    //                 // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
    //                 var tab = window.open('about:blank', '_blank');
    //                 tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
    //                 tab.document.close(); // to finish loading the page
    //             }
    //         });
    //     });
    // });
</script>
<?= $this->endSection(); ?>