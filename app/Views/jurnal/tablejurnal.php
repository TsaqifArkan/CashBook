<?php // echo dd($data, $nRow); ?>

<!-- Konfigurasi input search -->
<!-- <div class="container">
    <div class="input-group my-3">
        <span class="input-group-text">
            Search
        </span>
        <input type="text" class="form-control" name="searchtext" id="searchtext" placeholder="Input keyword here.."
            aria-label="keyword">
        <span class="input-group-text">
            <i class="fa-solid fa-fw fa-magnifying-glass"></i>
        </span>
    </div>
</div> -->

<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="ave-bg-th" id="tahleJurnal">
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
        <tbody class="srch">
            <?php
            // $dateprev = $data[0]['created_at'];
            $dateprev = "";
            $notraprev = 0;
            $i = 0;
            $c = "";
            $row = ""; ?>
            <?php foreach ($data as $d): ?>
                <?php // $datenow = $d['created_at']; ?>
                <?php $notranow = $d['notrans']; ?>
                <?php // if ($dateprev != $datenow): ?>
                <?php if ($notraprev != $notranow): ?>
                    <?php $i++; ?>
                    <?php $c = $i; ?>
                    <?php // $dateprev = $datenow; ?>
                    <?php $notraprev = $notranow; ?>
                    <?php $row = $nRow[$c - 1]['noRow']; ?>
                    <?php $firstRC = "<td rowspan='$row'>$c</td>"; ?>
                    <?php $lastRC = "<td rowspan=" . $row . ">
                    <a href=" . base_url('jurnal/edit') . '/' . esc($notranow) . " class='btn btn-warning btn-sm' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Edit'><i
                        class='fa-solid fa-pen-to-square'></i></a>
                        <button class='btn btn-danger btn-sm' data-bs-toggle='tooltip' data-bs-placement='bottom'
                        title='Hapus' onclick='hapus(" . esc($notranow) . ")'><i
                            class='fa-solid fa-trash'></i></button>
                    </td>"; ?>
                <?php else: ?>
                    <?php $c = ""; ?>
                    <?php $row = ""; ?>
                    <?php $firstRC = ""; ?>
                    <?php $lastRC = ""; ?>
                <?php endif; ?>
                <tr>
                    <?= $firstRC; ?>
                    <td><?= esc($d['tanggal']); ?></td>
                    <td><?= esc($d['keterangan']); ?></td>
                    <td><?= esc($d['namabarang']); ?></td>
                    <td><?= esc($d['jumlah']); ?></td>
                    <td><?= esc($d['namasatuan']); ?></td>
                    <td><?=(esc($d['dk']) == 'D' ? 'Pemasukan' : 'Pengeluaran'); ?></td>
                    <td><?= esc($d['harga']); ?></td>
                    <?= $lastRC; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function () {
        $('#tableJurnal').click(false);
        $('#tableJurnal').click(function () { return false; });
        // $('#dataTable-Jurnal').DataTable({
        //     "pageLength": 25,
        //     "columnDefs": [
        //         {
        //             targets: "_all",
        //             className: 'dt-head-center'
        //         },
        //         {
        //             // targets: [0, 2],
        //             targets: "_all",
        //             className: 'dt-body-center'
        //         }
        //     ]
        // });

        // function searchData(query) {
        //     $.ajax({
        //         type: "POST",
        //         url: "<?php // echo base_url(); ?>/jurnal/search",
        //         data: {
        //             query: query
        //         },
        //         // dataType: "dataType",
        //         success: function (response) {
        //             $('.srch').html(response);
        //         }
        //     });
        // }

        // $('#searchtext').keyup(function () {
        //     let search = $(this).val();
        //     if (search != '') {
        //         searchData(search);
        //     }
        //     else {
        //         searchData();
        //     }
        // });

    });

    // Konfigurasi Tombol Hapus
    function hapus(notra) {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Data transaksi yang sudah dihapus tidak bisa dikembalikan lagi!",
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
                        notra: notra
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
                            // tableSatuan();
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