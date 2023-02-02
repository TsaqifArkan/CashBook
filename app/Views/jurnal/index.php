<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="alert alert-breadcrumb-ave" role="alert">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 fs-6">
            <li class="breadcrumb-item active" aria-current="page">Jurnal</li>
        </ol>
    </nav>
</div>

<div class="container-fluid ">

    <!-- FLASH DATA -->
    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('msg'); ?>"></div>

    <!-- Page Heading -->
    <div class="row my-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Jurnal</h1>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-6 text-center">
            <a href="<?= base_url('jurnal/transaksi'); ?>" class="btn btn-success">
                <span class="me-1"><i class="fa-solid fa-fw fa-circle-plus"></i></span>
                <span>Jual/Beli Barang</span>
            </a>
        </div>
        <div class="col-6 text-center">
            <a href="<?= base_url('jurnal/other'); ?>" class="btn btn-success">
                <span class="me-1"><i class="fa-solid fa-fw fa-circle-plus"></i></span>
                <span>Transaksi Lainnya</span>
            </a>
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
                    <div class="row justify-content-center">
                        <div class="col-4">
                            <label for="bulan">Periode Bulan</label>
                            <input type="month" class="form-control mb-3 tanggal" id="bulan" value="<?= $now ?>"
                                onchange="bulan(event);">
                        </div>
                        <!-- <div class="col">
                            <label for="awal">Tanggal Akhir</label>
                            <input type="date" class="form-control mb-3 tanggal" id="akhir" min='<?php // echo $datemin ?>'
                                max='<?php // echo $datemax ?>' value="<?php // echo $now ?>" onchange="akhirOnChange(event);">
                        </div> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="sectiondatajurnal">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function tableJurnal(bulan) {
        $.ajax({
            url: "<?= base_url('jurnal/getData'); ?>",
            data: {
                bulan: bulan
            },
            method: "POST",
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
    }

    function bulan(e) {
        // let awal = e.target.value;
        // console.log(awal);
        var bulan = e.target.value;
        // var tglakhir = $('#akhir').val();
        tableJurnal(bulan);
    }

    $(document).ready(function () {
        // Get data from Bulan
        var bulan = $('#bulan').val();
        // var tglakhir = $('#akhir').val();
        // console.log(tglawal, tglakhir);
        tableJurnal(bulan);

        // >> Konfigurasi flash data
        const flashData = $('.flash-data').data('flashdata');
        // console.log(flashData);
        if (flashData) {
            Swal.fire({
                title: 'SUCCESS !',
                text: flashData,
                icon: 'success'
            });
        }

    });

    // function akhirOnChange(e) {
    //     var tglawal = $('#awal').val();
    //     var tglakhir = e.target.value;
    //     tableJurnal(tglawal, tglakhir);
    // }
</script>

<?= $this->endSection(); ?>