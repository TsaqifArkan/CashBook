<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<?php //echo dd($data); ?>

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
            <div class="card my-2 shadow">
                <div class="card-header py-2">
                    <h6 class="m-1 fw-bold text-uppercase">Daftar Transaksi</h6>
                    <?php // echo esc($data[0])['tanggal']; ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable-EditTrans">
                            <thead class="ave-bg-th">
                                <tr>
                                    <th class="text-uppercase fw-bold head-no">No</th>
                                    <th class="text-uppercase fw-bold">Tanggal</th>
                                    <th class="text-uppercase fw-bold">Keterangan</th>
                                    <th class="text-uppercase fw-bold">Nama Barang</th>
                                    <th class="text-uppercase fw-bold">Jumlah</th>
                                    <th class="text-uppercase fw-bold">Satuan</th>
                                    <th class="text-uppercase fw-bold">Jenis Transaksi</th>
                                    <th class="text-uppercase fw-bold">Harga</th>
                                    <th class="text-uppercase fw-bold head-aksi-klas">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="listtransaksi" name="listtrans">
                                <?php foreach ($data as $i => $d): ?>
                                    <tr>
                                        <td><?= $i + 1; ?></td>
                                        <td><?= esc($d['tanggal']); ?></td>
                                        <td><?= esc($d['keterangan']); ?></td>
                                        <td><?= esc($d['namaBar']); ?></td>
                                        <td><?= esc($d['jumlah']); ?></td>
                                        <td><?= esc($d['namaSat']); ?></td>
                                        <td><?=(esc($d['dk']) == 'D' ? 'Pemasukan' : 'Pengeluaran'); ?></td>
                                        <td><?= esc($d['harga']); ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="Edit"
                                                onclick="ubah('<?= esc($d['idjurnal']); ?>')"><i
                                                    class="fa-solid fa-pen-to-square"></i></button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="Hapus"
                                                onclick="hapus('<?= esc($d['idjurnal']); ?>')"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="viewModalEditTrans" style="display: none;"></div>
<script>
    $(document).ready(function () {
        $('#dataTable-EditTrans').DataTable({
            "pageLength": 25,
            "columnDefs": [
                {
                    targets: "_all",
                    className: 'dt-head-center'
                },
                {
                    // targets: [0, 2],
                    targets: "_all",
                    className: 'dt-body-center'
                }
            ]
        });
    });

    // Konfigurasi Tombol Edit
    function ubah(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('jurnal/formedit'); ?>",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function (response) {
                if (response.data) {
                    $('.viewModalEditTrans').html(response.data).show();
                    $('#modalEditTransaksi').modal('show');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                var tab = window.open('about:blank', '_blank');
                tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                tab.document.close(); // to finish loading the page
            }
        });
    }

    // Konfigurasi Tombol Hapus
    function hapus(id) {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Data yang sudah dihapus tidak bisa dikembalikan lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('jurnal/delete'); ?>",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.flashData) {
                            Swal.fire({
                                icon: 'success',
                                title: 'SUCCESS !',
                                text: response.flashData
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                            // tableBarang();
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        var tab = window.open('about:blank', '_blank');
                        tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                        tab.document.close(); // to finish loading the page
                    }
                });
            }
        })
    }
</script>
<?= $this->endSection(); ?>