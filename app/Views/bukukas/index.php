<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="alert alert-breadcrumb-ave" role="alert">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 fs-6">
            <li class="breadcrumb-item active" aria-current="page">Buku Kas</li>
        </ol>
    </nav>
</div>

<div class="container-fluid">

    <!-- FLASH DATA -->
    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('msg'); ?>"></div>

    <!-- Page Heading -->
    <div class="row my-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Buku Kas</h1>
        </div>
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
                        <table class="table table-bordered table-hover" id="dataTable-Bukukas">
                            <thead class="ave-bg-th">
                                <tr class="text-center">
                                    <th class="text-uppercase fw-bold head-no">No</th>
                                    <th class="text-uppercase fw-bold">Tanggal</th>
                                    <th class="text-uppercase fw-bold">Keterangan</th>
                                    <th class="text-uppercase fw-bold">Pemasukan</th>
                                    <th class="text-uppercase fw-bold">Pengeluaran</th>
                                    <th class="text-uppercase fw-bold">Saldo</th>
                                </tr>
                            </thead>
                            <tbody class="sectiondatabukukas">
                                <?= view('bukukas/tablebukukas', $data); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.tanggal').change(function () {
        $('.sectiondatabukukas').html('');
        $.ajax({
            method: "POST",
            url: "<?= base_url('bukukas/getData'); ?>",
            data: {
                awal: $('#awal').val(),
                akhir: $('#akhir').val()
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
</script>
<?= $this->endSection(); ?>