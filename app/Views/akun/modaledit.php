<!-- Modal -->
<div class="modal fade" id="modalEditAkun" tabindex="-1" aria-labelledby="judulModalAkun" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModalAkun">Edit Akun</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('akun/edit', ['class' => 'formAkun']); ?>
            <div class="modal-body">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" id="id" value="<?= esc($akun['idakun']); ?>">
                <div class="form-group mb-3">
                    <label for="nama" class="form-label">Nama Akun</label>
                    <input type="text" class="form-control" name="nama" id="nama" value="<?= esc($akun['nama']); ?>">
                    <div class="invalid-feedback errorNama"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="kode" class="form-label">Kode Akun</label>
                    <input type="text" class="form-control" name="kode" id="kode" value="<?= esc($akun['kode']); ?>">
                    <div class="invalid-feedback errorKode"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="posisi" class="form-label">Posisi</label>
                    <div class="form-row justify-content-around text-center">
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="posisi" id="neraca" value="Neraca"
                                    <?= esc($akun['posisi'] == 'Neraca' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="neraca">
                                    Neraca
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="posisi" id="labarugi"
                                    value="Laba Rugi" <?= esc($akun['posisi'] == 'Laba Rugi' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="labarugi">
                                    Laba Rugi
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="text-danger errorPosisi" style="font-size: 83%;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="saldoNormal" class="form-label">Saldo Normal</label>
                    <div class="form-row justify-content-around text-center">
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="saldoNormal" id="debit" value="Debit"
                                    <?= esc($akun['saldonormal'] == 'Debit' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="debit">
                                    Debit
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="saldoNormal" id="kredit"
                                    value="Kredit" <?= esc($akun['saldonormal'] == 'Kredit' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="kredit">
                                    Kredit
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="text-danger errorSaldoNormal" style="font-size: 83%;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="saldoAwal" class="form-label">Saldo Awal</label>
                    <input type="text" class="form-control" name="saldoAwal" id="saldoAwal"
                        value="<?= esc($akun['saldoawal']); ?>">
                    <div class="invalid-feedback errorSaldoAwal"></div>
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
    // Konfigurasi Modal Edit Akun di modaledit.php
    $(document).ready(function () {
        $('.formAkun').submit(function (e) {
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
                        if (response.error.kode) {
                            $('#kode').addClass('is-invalid');
                            $('.errorKode').html(response.error.kode);
                        } else {
                            $('#kode').removeClass('is-invalid');
                            $('#kode').addClass('is-valid');
                            $('.errorKode').html('');
                        }
                        if (response.error.posisi) {
                            $('.errorPosisi').html(response.error.posisi);
                        } else {
                            $('.errorPosisi').html('');
                        }
                        if (response.error.saldoNormal) {
                            $('.errorSaldoNormal').html(response.error.saldoNormal);
                        } else {
                            $('.errorSaldoNormal').html('');
                        }

                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'SUCCESS !',
                            text: response.flashData
                        });
                        $('#modalEditAkun').modal('hide');
                        tableAkun();
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