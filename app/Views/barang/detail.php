<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<?php // dd($data); ?>
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
                    <h6 class="m-1 fw-bold text-uppercase">Kartu Inventaris Barang</h6>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <div class="row mb-2 mx-0">
                            <div class="col mx-0">
                                <h4 class="text-dark"><strong><?= $namaBarang; ?> (<?= $namaSat; ?>)</strong></h4>
                            </div>
                        </div>
                        <table class="table table-bordered table-hover" id="dataTable-Detail">
                            <thead class="ave-bg-th">
                                <tr class="text-center">
                                    <th class="text-uppercase fw-bold head-no">No</th>
                                    <th class="text-uppercase fw-bold">Tanggal</th>
                                    <th class="text-uppercase fw-bold">Keterangan</th>
                                    <!-- <th class="text-uppercase fw-bold">Nama Barang</th> -->
                                    <th class="text-uppercase fw-bold">Jenis Transaksi</th>
                                    <th class="text-uppercase fw-bold">Jumlah</th>
                                    <th class="text-uppercase fw-bold">Stok</th>
                                    <th class="text-uppercase fw-bold">Harga Satuan</th>
                                    <!-- <th class="text-uppercase fw-bold">Satuan</th> -->
                                    <!-- <th class="text-uppercase fw-bold">Stok</th> -->
                                    <!-- <th class="text-uppercase fw-bold">Pemasukan</th>
                                    <th class="text-uppercase fw-bold">Pengeluaran</th>
                                    <th class="text-uppercase fw-bold">Saldo</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">0</td>
                                    <td class="text-center"></td>
                                    <td>Stok Awal</td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"><?= esc($stokawalBrg); ?></td>
                                    <td class="text-center"><?= esc($hppBrg); ?></td>
                                </tr>
                                <?php foreach ($data as $i => $d): ?>
                                    <tr>
                                        <td class="text-center"><?= $i + 1; ?></td>
                                        <td class="text-center"><?= esc($d['tanggal']); ?></td>
                                        <td><?= esc($d['keterangan']); ?></td>
                                        <!-- <td><?php // echo esc($d['namaBrg']); ?></td> -->
                                        <td class="text-center"><?=(esc($d['dk']) == 'D' ? 'Pemasukan' : 'Pengeluaran'); ?>
                                        </td>
                                        <td class="text-center"><?= esc($d['jumlah']); ?></td>
                                        <td class="text-center"><?= esc($d['stokNow']); ?></td>
                                        <td class="text-center"><?= esc($d['harga']); ?></td>
                                        <!-- <td><?php // echo esc($d['satBrg']); ?></td> -->
                                        <!-- <td><?php // echo esc($d['pemasukan']); ?></td> -->
                                        <!-- <td><?php // echo esc($d['pengeluaran']); ?></td> -->
                                        <!-- <td><?php // echo esc($d['saldo']); ?></td> -->
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