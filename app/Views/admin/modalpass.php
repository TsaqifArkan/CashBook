<!-- Modal -->
<div class="modal fade" id="modalUbahPass" tabindex="-1" aria-labelledby="judulModalPass" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModalPass">Ubah Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('admin/pass', ['class' => 'formPass']); ?>
            <div class="modal-body">
                <?= csrf_field(); ?>
                <div class="form-group mb-3">
                    <label for="oldPass" class="form-label">Password Lama</label>
                    <input type="password" class="form-control" name="oldPass" id="oldPass">
                    <div class="invalid-feedback errorOldPass"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="newPass" class="form-label">Password Baru (min. 3 karakter)</label>
                    <input type="password" class="form-control" name="newPass" id="newPass">
                    <div class="invalid-feedback errorNewPass"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="konfPass" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" name="konfPass" id="konfPass">
                    <div class="invalid-feedback errorKonfPass"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btnSimpan">Ubah</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
    // Konfigurasi Modal Ubah Password di modalpass.php
    $(document).ready(function () {
        $('.formPass').submit(function (e) {
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
                    $('.btnSimpan').html('Ubah')
                },
                success: function (response) {
                    if (response.error) {

                        if (response.error.oldPass) {
                            $('#oldPass').addClass('is-invalid');
                            $('.errorOldPass').html(response.error.oldPass);
                        } else {
                            $('#oldPass').removeClass('is-invalid');
                            $('#oldPass').addClass('is-valid');
                            $('.errorOldPass').html('');

                            if (response.error.newPass) {
                                $('#newPass').addClass('is-invalid');
                                $('.errorNewPass').html(response.error.newPass);
                            } else {
                                $('#newPass').removeClass('is-invalid');
                                $('#newPass').addClass('is-valid');
                                $('.errorNewPass').html('');
                            }

                            if (response.error.konfPass) {
                                $('#konfPass').addClass('is-invalid');
                                $('.errorKonfPass').html(response.error.konfPass);
                            } else {
                                $('#konfPass').removeClass('is-invalid');
                                $('#konfPass').addClass('is-valid');
                                $('.errorKonfPass').html('');
                            }
                        }

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
                        $('#modalUbahPass').modal('hide');
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