<!-- Modal -->
<div class="modal fade" id="modalEditSatuan" tabindex="-1" aria-labelledby="judulModalSatuan" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModalSatuan">Edit Satuan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('satuan/edit', ['class' => 'formSatuan']); ?>
            <div class="modal-body">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" id="id" value="<?= esc($satuan['idsatuan']); ?>">
                <div class="form-group mb-3">
                    <label for="nama" class="form-label">Nama Satuan</label>
                    <input type="text" class="form-control" name="nama" id="nama" value="<?= esc($satuan['nama']); ?>">
                    <div class="invalid-feedback errorNama"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btnSimpan">Update Data</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
    // Konfigurasi Modal Edit Satuan di modaledit.php
    $(document).ready(function () {
        $('.formSatuan').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function () {
                    $('.btnSimpan').attr('disable', 'disabled');
                    $('.btnSimpan').html('<i class="fa-solid fa-spin fa-fw fa-spinner"></i>')
                },
                complete: function () {
                    $('.btnSimpan').removeAttr('disable');
                    $('.btnSimpan').html('Update Data')
                },
                success: function (response) {
                    if (response.error) {

                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errorNama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('#nama').addClass('is-valid');
                            $('.errorNama').html('');
                        }

                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'SUCCESS !',
                            text: response.flashData
                        });
                        $('#modalEditSatuan').modal('hide');
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
            return false;
        });
    });
</script>