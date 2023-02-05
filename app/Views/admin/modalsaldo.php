<!-- Modal -->
<div class="modal fade" id="modalSaldo" tabindex="-1" aria-labelledby="modalSaldoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="modalSaldoLabel">Ubah Saldo Awal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('admin/ubahsaldo', ['class' => 'formUbahSaldo']); ?>
            <div class="modal-body">
                <div class="alert alert-secondary text-sm" role="alert">
                    Secara default, saldo awal adalah Rp 0.00,-. Silahkan ubah saldo awal kas desa melalui form input
                    ini!
                </div>
                <?= csrf_field(); ?>
                <div class="form-group mb-3">
                    <label for="initSaldo" class="form-label">Saldo Awal</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control" name="initSaldo" id="initSaldo" placeholder="min. 0"
                            value="<?= esc($saldo); ?>">
                        <span class="input-group-text">,00</span>
                        <div class="invalid-feedback errorInitSaldo"></div>
                    </div>
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
    // Konfigurasi Modal Ubah Saldo Awal di modalsaldo.php
    $(document).ready(function () {
        $('.formUbahSaldo').submit(function (e) {
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

                        if (response.error.initSaldo) {
                            $('#initSaldo').addClass('is-invalid');
                            $('.errorInitSaldo').html(response.error.initSaldo);
                        } else {
                            $('#initSaldo').removeClass('is-invalid');
                            $('#initSaldo').addClass('is-valid');
                            $('.errorInitSaldo').html('');
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
                        $('#modalSaldo').modal('hide');
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
            return false;
        });
    });
</script>