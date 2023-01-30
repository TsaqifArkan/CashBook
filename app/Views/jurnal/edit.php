<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<?= dd($data); ?>

<div class="alert alert-breadcrumb-ave" role="alert">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 fs-6">
            <li class="breadcrumb-item"><a class="a-bread-ave" href="<?= base_url('jurnal'); ?>">Jurnal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
</div>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row my-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Form Edit Transaksi</h1>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <form action="<?= base_url(); ?>/jurnal/validatef1" method="post" class="f1">
                <div class="card mb-3 shadow">
                    <div class="card-header">
                        <h6 class="m-1">Table Input Transaksi Barang Sementara
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-secondary text-sm" role="alert">
                            Anda dapat memasukkan lebih dari 1 data pada 1 transaksi
                        </div>
                        <input type="hidden" name="tempdata" id="tdat">
                        <div class="row mt-3 justify-content-center">
                            <div class="col-2">
                                <div class="form-group mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" id="tanggal">
                                    <div class="invalid-feedback errorTanggal"></div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group mb-3">
                                    <label for="barang" class="form-label">Pilih Barang</label>
                                    <select class="form-select" id="barang" name="barang">
                                    <!-- onchange="setSatStok()" -->
                                        <option value="" disabled selected>-- Pilih barang --</option>
                                        <?php foreach ($barang as $i => $b): ?>
                                            <option id="brg<?= esc($i++); ?>" value="<?= esc($b['idbrg']); ?>"
                                                data-satuan="<?= esc($b['namaSat']); ?>"
                                                data-stok="<?= esc($b['stok']); ?>" onchange="$('#stok')[0].value = this.dataset['stok']"><?=
                                                      esc($b['nama']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback errorBarang"></div>
                                </div>
                                <!-- <input type="hidden" name="barang[stok]" id="newStok" value="$('#barang')"> -->
                            </div>
                            <div class="col-1">
                                <div class="form-group mb-3">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" class="form-control" name="stok" id="stok" disabled>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group mb-3">
                                    <label for="mutasi" class="form-label">Jenis Transaksi</label>
                                    <div class="form-row justify-content-between text-center mt-1">
                                        <div class="col">
                                            <input class="form-check-input" type="radio" name="mutasi" id="debit"
                                                value="D" onchange="toggleJml();" data-mut="Pemasukan">
                                            <label class="form-check-label" for="debit">
                                                Pemasukan</label>
                                            <div class="text-secondary text-sm">(penjualan barang / transaksi lainnya)</div>
                                        </div>
                                        <div class="col">
                                            <input class="form-check-input" type="radio" name="mutasi" id="kredit"
                                                value="K" onchange="toggleJml();" data-mut="Pengeluaran">
                                            <label class="form-check-label" for="kredit">
                                                Pengeluaran</label>
                                            <div class="text-secondary text-sm">(pembelian barang / transaksi lainnya)</div>
                                        </div>
                                    </div>
                                    <div class="text-danger errorMutasi" style="font-size: 83%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-1">
                                <div class="form-group mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" name="jumlah" id="jumlah" disabled>
                                    <div class="invalid-feedback errorJumlah"></div>
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="form-group mb-3">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <input type="text" class="form-control" name="satuan" id="satuan" disabled>
                                    <!-- <div class="invalid-feedback errorSatuan"></div> -->
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" name="harga" id="harga">
                                        <span class="input-group-text">,00</span>
                                        <div class="invalid-feedback errorHarga"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <input type="text" class="form-control" name="keterangan" id="keterangan">
                                    <div class="invalid-feedback errorKeterangan"></div>
                                </div>
                            </div>
                            <!-- <div class="col-4">
                                <div class="form-group mb-3">
                                    <label for="kredit2" class="form-label">Pengeluaran</label>
                                    <input type="number" class="form-control" name="kredit2" id="kredit2" disabled>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <!-- id="tambah" sudah tidak digunakan lagi -->
                        <button class="btn btn-primary" id="tambah" type="submit">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card my-2 shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="ave-bg-th">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Harga</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            <tbody id="listtransaksi" name="listtrans">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <form method="POST" action="<?= base_url() ?>/jurnal/save" id="f2">
                        <input type="hidden" name="successdata" id="sdat">
                        <button class="btn btn-primary" id="jurnal_simpan">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection(); ?>