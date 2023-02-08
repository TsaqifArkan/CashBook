<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row my-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Detail Akun</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-2">
                    <h6 class="m-1 fw-bold text-uppercase">Buku Besar Akun</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable-Jurnal">
                            <thead class="ave-bg-th">
                                <tr>
                                    <th class="text-uppercase fw-bold head-no">No</th>
                                    <th class="text-uppercase fw-bold">Tanggal</th>
                                    <th class="text-uppercase fw-bold">Keterangan</th>
                                    <th class="text-uppercase fw-bold">Debit</th>
                                    <th class="text-uppercase fw-bold">Kredit</th>
                                    <th class="text-uppercase fw-bold">Saldo</th>
                                    <th class="text-uppercase fw-bold head-aksi-klas">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>0</td>
                                    <td></td>
                                    <td>Saldo Awal</td>
                                    <td></td>
                                    <td></td>
                                    <td><?= esc($init['saldoawal']); ?></td>
                                    <td></td>
                                </tr>
                                <?php foreach ($data as $i => $d): ?>
                                    <tr>
                                        <td><?= $i + 1; ?></td>
                                        <td><?= esc($d['tanggal']); ?></td>
                                        <td><?= esc($d['keterangan']); ?></td>
                                        <td><?= esc($d['debit']); ?></td>
                                        <td><?= esc($d['kredit']); ?></td>
                                        <td><?= esc($d['saldo']); ?></td>
                                        <td></td>
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