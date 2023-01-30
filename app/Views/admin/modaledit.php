<!-- Modal -->
<div class="modal fade" id="modalEditProfil" tabindex="-1" aria-labelledby="judulModalAdmin" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModalAdmin">Edit Profil Admin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('admin/edit', ['class' => 'formAdmin']); ?>
            <div class="modal-body">
                <?= csrf_field(); ?>
                <div class="form-group mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username"
                        value="<?= esc($admin['username']); ?>">
                    <div class="invalid-feedback errorUsername"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="namaLengkap" id="namaLengkap"
                        value="<?= esc($admin['namalengkap']); ?>" placeholder="(opsional)">
                    <div class="invalid-feedback errorNamaLengkap"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email"
                        value="<?= esc($admin['email']); ?>" placeholder="(opsional)">
                    <div class="invalid-feedback errorEmail"></div>
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
    // Konfigurasi Modal Edit Profil di modaledit.php
    $(document).ready(function () {
        $('.formAdmin').submit(function (e) {
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
                    if (response.errorUsername) {
                        $('#username').addClass('is-invalid');
                        $('.errorUsername').html(response.errorUsername);
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'SUCCESS !',
                            text: response.flashData
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                        $('#modalEditProfil').modal('hide');
                        // location.reload();
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