<!-- Modal -->
<div class="modal fade" id="modalTambahSatuan" tabindex="-1" aria-labelledby="judulModalSatuan" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModalSatuan">Tambah Satuan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('satuan/tambah', ['class' => 'formSatuan']); ?>
            <div class="modal-body">
                <div class="alert alert-secondary text-sm" role="alert">
                    <p><i class="fa-solid fa-lightbulb me-1"></i>
                        Mohon pastikan tidak menambah nama satuan yang sama dengan yang sudah ada di tabel!</p>
                </div>
                <?= csrf_field(); ?>
                <div class="form-group mb-3">
                    <label for="nama" class="form-label">Nama Satuan</label>
                    <input type="text" class="form-control" name="nama" id="nama">
                    <div class="invalid-feedback errorNama"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btnSimpan">Tambah Data</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
    // Konfigurasi Modal Tambah Satuan di modaltambah.php
    $(document).ready(function () {
        $('#modalTambahSatuan').on('shown.bs.modal', function () {
            $('#nama').focus();
        })
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
                    $('.btnSimpan').html('Tambah Data')
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
                        $('#modalTambahSatuan').modal('hide');
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