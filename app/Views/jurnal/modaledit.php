<!-- Modal -->
<div class="modal fade" id="modalEditTransaksi" tabindex="-1" aria-labelledby="judulModalEditTrans" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModalEditTrans">Edit Transaksi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('jurnal/saveEdit', ['class' => 'formEditTrans']); ?>
            <div class="modal-body">
                <?= csrf_field(); ?>
                <input type="hidden" name="idjurnal" id="idjurnal" value="<?= esc($trans['idjurnal']); ?>">
                <div class="form-group mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" id="tanggal"
                        value="<?= esc($trans['tanggal']); ?>">
                    <div class="invalid-feedback errorTanggal"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="barang" class="form-label">Pilih Barang</label>
                    <select class="form-select" id="barang" name="barang">
                        <!-- onchange="setSatStok()" -->
                        <option value="" disabled <?=!isset($idBar) ? "selected" : ''; ?>>-- Pilih barang --
                        </option>
                        <?php foreach ($barang as $i => $b): ?>
                            <option id="brg<?= esc($i++); ?>" value="<?= esc($b['idbrg']); ?>"
                                data-satuan="<?= esc($b['allNamaSat']); ?>" data-stok="<?= esc($b['stok']); ?>"
                                <?=(esc($b['idbrg']) == $idBar) ? "selected" : ''; ?>><?= esc($b['nama']); ?></option>
                            <!-- onchange="$('#stok')[0].value = this.dataset['stok']" -->
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback errorBarang"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="stok" class="form-label">Stok saat ini</label>
                    <input type="text" class="form-control" name="stok" id="stok" value="<?= esc($stok); ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="mutasi" class="form-label">Jenis Transaksi</label>
                    <div class="form-row justify-content-between text-center mt-1">
                        <div class="col">
                            <input class="form-check-input" type="radio" name="mutasi" id="debit" value="D"
                                onchange="toggleJml();" data-mut="Pemasukan" <?= esc($trans['dk'] == 'D') ? "checked" : ''; ?>>
                            <label class="form-check-label" for="debit">
                                Pemasukan</label>
                            <div class="text-secondary text-sm">(penjualan barang / transaksi lainnya)</div>
                        </div>
                        <div class="col">
                            <input class="form-check-input" type="radio" name="mutasi" id="kredit" value="K"
                                onchange="toggleJml();" data-mut="Pengeluaran" <?= esc($trans['dk'] == 'K') ? "checked" : ''; ?>>
                            <label class="form-check-label" for="kredit">
                                Pengeluaran</label>
                            <div class="text-secondary text-sm">(pembelian barang / transaksi lainnya)</div>
                        </div>
                    </div>
                    <div class="text-danger errorMutasi" style="font-size: 83%;"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="text" class="form-control" name="jumlah" id="jumlah"
                        value="<?= esc($trans['jumlah']); ?>">
                    <div class="invalid-feedback errorJumlah"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="satuan" class="form-label">Satuan</label>
                    <input type="text" class="form-control" name="satuan" id="satuan" value="<?= esc($namaSat); ?>"
                        disabled>
                    <!-- <div class="invalid-feedback errorSatuan"></div> -->
                </div>
                <div class="form-group mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control" name="harga" id="harga"
                            value="<?= esc($trans['harga']); ?>">
                        <span class="input-group-text">,00</span>
                        <div class="invalid-feedback errorHarga"></div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" name="keterangan" id="keterangan"
                        value="<?= esc($trans['keterangan']); ?>">
                    <div class="invalid-feedback errorKeterangan"></div>
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
    // Konfigurasi Modal Edit Transaksi di modaledit.php
    $(document).ready(function () {
        $('.formEditTrans').submit(function (e) {
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

                        if (response.error.tanggal) {
                            $('#tanggal').addClass('is-invalid');
                            $('.errorTanggal').html(response.error.tanggal);
                        } else {
                            $('#tanggal').removeClass('is-invalid');
                            $('#tanggal').addClass('is-valid');
                            $('.errorTanggal').html('');
                        }
                        if (response.error.barang) {
                            $('#barang').addClass('is-invalid');
                            $('.errorBarang').html(response.error.barang);
                        } else {
                            $('#barang').removeClass('is-invalid');
                            $('#barang').addClass('is-valid');
                            $('.errorBarang').html('');
                        }
                        if (response.error.jumlah) {
                            $('#jumlah').addClass('is-invalid');
                            $('.errorJumlah').html(response.error.jumlah);
                        } else {
                            $('#jumlah').removeClass('is-invalid');
                            $('#jumlah').addClass('is-valid');
                            $('.errorJumlah').html('');
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
                        $('#modalEditTransaksi').modal('hide');
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

        // // Function to automatically set satuan and stok barang
        // function setSatStok() {
        //     let brg = $('#barang')[0].selectedOptions[0];
        //     console.log(brg);
        //     $('#satuan')[0].value = brg.dataset['satuan'];
        //     $('#stok')[0].value = brg.dataset['stok'];
        // }
    });

    $('#barang').change(function () {
        $('#satuan')[0].value = this.selectedOptions[0].dataset['satuan'];
        $('#stok')[0].value = this.selectedOptions[0].dataset['stok'];
    });

    // Function to Toggle disabled property on Jumlah Input
    // function toggleJml() {
    //     let radButton = $("input[type='radio']:checked").val();
    //     if (radButton != '') {
    //         $('#jumlah').prop('disabled', false);
    //     }
    // }

    // $("input[type='radio']").attr('checked');
</script>