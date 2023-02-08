<!-- Modal -->
<div class="modal fade" id="modalAddOther" tabindex="-1" aria-labelledby="judulModalAddOther" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModalAddOther">Tambah Transaksi Lainnya</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('jurnal/addOther', ['class' => 'formAddOther']); ?>
            <div class="modal-body">
                <?= csrf_field(); ?>
                <div class="form-group mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" id="tanggal">
                    <div class="invalid-feedback errorTanggal"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="mutasi" class="form-label">Jenis Transaksi</label>
                    <div class="form-row justify-content-between text-center">
                        <div class="col">
                            <input class="form-check-input" type="radio" name="mutasi" id="debit" value="D"
                                data-mut="Pemasukan">
                            <label class="form-check-label" for="debit">
                                Pemasukan</label>
                        </div>
                        <div class="col">
                            <input class="form-check-input" type="radio" name="mutasi" id="kredit" value="K"
                                data-mut="Pengeluaran">
                            <label class="form-check-label" for="kredit">
                                Pengeluaran</label>
                        </div>
                    </div>
                    <div class="text-danger errorMutasi" style="font-size: 83%;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control" name="harga" id="harga">
                        <span class="input-group-text">,00</span>
                        <div class="invalid-feedback errorHarga"></div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" name="keterangan" id="keterangan">
                    <div class="invalid-feedback errorKeterangan"></div>
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
    // Konfigurasi Modal Tambah Transaksi Lainnya di modaladdother.php
    $(document).ready(function () {
        // $('#modalAddOther').on('shown.bs.modal', function () {
        //     $('#nama').focus();
        // })
        $('.formAddOther').submit(function (e) {
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

                        if (response.error.tanggal) {
                            $('#tanggal').addClass('is-invalid');
                            $('.errorTanggal').html(response.error.tanggal);
                        } else {
                            $('#tanggal').removeClass('is-invalid');
                            $('#tanggal').addClass('is-valid');
                            $('.errorTanggal').html('');
                        }
                        if (response.error.keterangan) {
                            $('#keterangan').addClass('is-invalid');
                            $('.errorKeterangan').html(response.error.keterangan);
                        } else {
                            $('#keterangan').removeClass('is-invalid');
                            $('#keterangan').addClass('is-valid');
                            $('.errorKeterangan').html('');
                        }
                        if (response.error.mutasi) {
                            $('.errorMutasi').html(response.error.mutasi);
                        } else {
                            $('.errorMutasi').html('');
                        }
                        if (response.error.harga) {
                            $('#harga').addClass('is-invalid');
                            $('.errorHarga').html(response.error.harga);
                        } else {
                            $('#harga').removeClass('is-invalid');
                            $('#harga').addClass('is-valid');
                            $('.errorHarga').html('');
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
                        $('#modalAddOther').modal('hide');
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