<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="alert alert-breadcrumb-ave" role="alert">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 fs-6">
            <li class="breadcrumb-item"><a class="a-bread-ave" href="<?= base_url('barang'); ?>">Barang</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </nav>
</div>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row my-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Detail Barang</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-2">
                    <h6 class="m-1 fw-bold text-uppercase">Buku Besar Barang</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="row mb-2 mx-0">
                            <div class="col mx-0">
                                <h4 class="text-dark"><strong><?= $data[0]['namaBrg']; ?></strong></h4>
                            </div>
                        </div>
                        <table class="table table-bordered table-hover" id="dataTable-Detail">
                            <thead class="ave-bg-th">
                                <tr>
                                    <th class="text-uppercase fw-bold head-no">No</th>
                                    <th class="text-uppercase fw-bold">Tanggal</th>
                                    <th class="text-uppercase fw-bold">Keterangan</th>
                                    <th class="text-uppercase fw-bold">Nama Barang</th>
                                    <th class="text-uppercase fw-bold">Jumlah</th>
                                    <th class="text-uppercase fw-bold">Satuan</th>
                                    <th class="text-uppercase fw-bold">Pemasukan</th>
                                    <th class="text-uppercase fw-bold">Pengeluaran</th>
                                    <th class="text-uppercase fw-bold">Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $i => $d): ?>
                                    <tr>
                                        <td><?= $i + 1; ?></td>
                                        <td><?= esc($d['tanggal']); ?></td>
                                        <td><?= esc($d['keterangan']); ?></td>
                                        <td><?= esc($d['namaBrg']); ?></td>
                                        <td><?= esc($d['jumlah']); ?></td>
                                        <td><?= esc($d['satBrg']); ?></td>
                                        <td><?= esc($d['pemasukan']); ?></td>
                                        <td><?= esc($d['pengeluaran']); ?></td>
                                        <td><?= esc($d['saldo']); ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>