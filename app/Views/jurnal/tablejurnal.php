<?php //echo dd($data); ?>

<?php if (empty($data)): ?>
    <tr>
        <td colspan='10' class='text-center'>
            Tidak ada data yang tersedia pada tabel ini
        </td>
    </tr>
<?php else: ?>
    <?php foreach ($data as $i => $d): ?>
        <tr>
            <td class="text-center"><?= $i + 1; ?></td>
            <td class="text-center"><?= esc($d['tanggal']); ?></td>
            <td><?= esc($d['keterangan']); ?></td>
            <td><?= esc($d['namabarang']); ?></td>
            <td class="text-center"><?= esc($d['jumlah']); ?></td>
            <td class="text-center"><?= esc($d['namasatuan']); ?></td>
            <td class="text-center"><?= esc($d['dk']) == 'D' ? 'Pemasukan' : 'Pengeluaran'; ?></td>
            <td class="text-end"><?= esc($d['harga']); ?></td>
            <td class="text-end"><?= esc($d['total']); ?></td>
            <td class="text-center">
                <button class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"
                    onclick="ubah('<?= esc($d['idjurnal']); ?>')"><i class="fa-solid fa-pen-to-square"></i></button>
                <button class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus"
                    onclick="hapus('<?= esc($d['idjurnal']); ?>')"><i class='fa-solid fa-trash'></i></button>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
<script>
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