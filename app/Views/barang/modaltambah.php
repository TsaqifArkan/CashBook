<!-- Modal -->
<div class="modal fade" id="modalTambahBarang" tabindex="-1" aria-labelledby="judulModalBarang" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModalBarang">Tambah Data Barang</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('barang/tambah', ['class' => 'formBarang']); ?>
            <div class="modal-body">
                <?= csrf_field(); ?>
                <div class="form-group mb-3">
                    <label for="nama" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" name="nama" id="nama">
                    <div class="invalid-feedback errorNama"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="stokAwal" class="form-label">Stok Awal</label>
                    <input type="text" class="form-control" name="stokAwal" id="stokAwal"
                        placeholder="ex: 0 / 1.5 / 10 ...">
                    <div class="invalid-feedback errorStokAwal"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="satuan" class="form-label">Satuan</label>
                    <select class="form-select" id="satuan" name="satuan">
                        <option value="" disabled selected>--Pilih Satuan--</option>
                        <?php foreach ($satuan as $s): ?>
                            <option value="<?= esc($s['idsatuan']); ?>"><?= esc($s['nama']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback errorSatuan"></div>
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
    // Konfigurasi Modal Tambah Barang di modaltambah.php
    $(document).ready(function () {
        $('#modalTambahBarang').on('shown.bs.modal', function () {
            $('#nama').focus();
        })
        $('.formBarang').submit(function (e) {
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
                        if (response.error.stokAwal) {
                            $('#stokAwal').addClass('is-invalid');
                            $('.errorStokAwal').html(response.error.stokAwal);
                        } else {
                            $('#stokAwal').removeClass('is-invalid');
                            $('#stokAwal').addClass('is-valid');
                            $('.errorStokAwal').html('');
                        }
                        if (response.error.satuan) {
                            $('#satuan').addClass('is-invalid');
                            $('.errorSatuan').html(response.error.satuan);
                        } else {
                            $('#satuan').removeClass('is-invalid');
                            $('#satuan').addClass('is-valid');
                            $('.errorSatuan').html('');
                        }

                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'SUCCESS !',
                            text: response.flashData
                        });
                        $('#modalTambahBarang').modal('hide');
                        tableBarang();
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