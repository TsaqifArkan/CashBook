<!-- Modal -->
<div class="modal fade" id="modalTambahAkun" tabindex="-1" aria-labelledby="judulModalAkun" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModalAkun">Tambah Akun</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('akun/tambah', ['class' => 'formAkun']); ?>
            <div class="modal-body">
                <?= csrf_field(); ?>
                <div class="form-group mb-3">
                    <label for="nama" class="form-label">Nama Akun</label>
                    <input type="text" class="form-control" name="nama" id="nama">
                    <div class="invalid-feedback errorNama"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="kode" class="form-label">Kode Akun</label>
                    <input type="text" class="form-control" name="kode" id="kode">
                    <div class="invalid-feedback errorKode"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="posisi" class="form-label">Posisi</label>
                    <div class="form-row justify-content-around text-center">
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="posisi" id="neraca" value="Neraca">
                                <label class="form-check-label" for="neraca">
                                    Neraca
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="posisi" id="labarugi"
                                    value="Laba Rugi">
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
                                <input class="form-check-input" type="radio" name="saldoNormal" id="debit"
                                    value="Debit">
                                <label class="form-check-label" for="debit">
                                    Debit
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="saldoNormal" id="kredit"
                                    value="Kredit">
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
                    <input type="text" class="form-control" name="saldoAwal" id="saldoAwal">
                    <div class="invalid-feedback errorSaldoAwal"></div>
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
    // Konfigurasi Modal Tambah Akun di modaltambah.php
    $(document).ready(function () {
        $('#modalTambahAkun').on('shown.bs.modal', function () {
            $('#nama').focus();
        })
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
                        // if (response.error.saldoAwal) {
                        //     $('#saldoAwal').addClass('is-invalid');
                        //     $('.errorSaldoAwal').html(response.error.saldoAwal);
                        // } else {
                        //     $('#saldoAwal').removeClass('is-invalid');
                        //     $('#saldoAwal').addClass('is-valid');
                        //     $('.errorSaldoAwal').html('');
                        // }

                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'SUCCESS !',
                            text: response.flashData
                        });
                        $('#modalTambahAkun').modal('hide');
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