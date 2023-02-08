<div class="table-responsive">
    <table class="table table-bordered table-hover" id="dataTable-Satuan">
        <thead class="ave-bg-th">
            <tr>
                <th class="text-uppercase fw-bold head-no">No</th>
                <th class="text-uppercase fw-bold">Nama Satuan</th>
                <th class="text-uppercase fw-bold head-aksi-klas">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datas as $i => $data): ?>
                <tr>
                    <td><?= $i + 1; ?></td>
                    <td><?= esc($data['nama']); ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="Edit" onclick="ubah('<?= esc($data['idsatuan']); ?>')"><i
                                class="fa-solid fa-pen-to-square"></i></button>
                        <?php if (isset($usedSat[$data['idsatuan']])): ?>
                            <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                title="Satuan masih dipakai">
                                <button class="btn btn-danger btn-sm" disabled><i class="fa-solid fa-trash"></i></button>
                            <?php else: ?>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Hapus" onclick="hapus('<?= esc($data['idsatuan']); ?>')"><i
                                        class="fa-solid fa-trash"></i></button>
                            <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function () {
        $('#dataTable-Satuan').DataTable({
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
            url: "<?= base_url('satuan/formedit'); ?>",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function (response) {
                if (response.data) {
                    $('.viewModalSatuan').html(response.data).show();
                    $('#modalEditSatuan').modal('show');
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
                    url: "<?= base_url('satuan/delete'); ?>",
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
                            })
                            tableSatuan();
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