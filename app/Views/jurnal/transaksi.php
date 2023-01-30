<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="alert alert-breadcrumb-ave" role="alert">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 fs-6">
            <li class="breadcrumb-item"><a class="a-bread-ave" href="<?= base_url('jurnal'); ?>">Jurnal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
        </ol>
    </nav>
</div>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row my-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Form Tambah Transaksi</h1>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <form action="<?= base_url(); ?>/jurnal/validatef1" method="post" class="f1">
                <div class="card mb-3 shadow">
                    <div class="card-header">
                        <h6 class="m-1">Table Input Transaksi Barang Sementara
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-secondary text-sm" role="alert">
                            Anda dapat memasukkan lebih dari 1 data pada 1 transaksi
                        </div>
                        <input type="hidden" name="tempdata" id="tdat">
                        <div class="row mt-3 justify-content-center">
                            <div class="col-2">
                                <div class="form-group mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" id="tanggal">
                                    <div class="invalid-feedback errorTanggal"></div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group mb-3">
                                    <label for="barang" class="form-label">Pilih Barang</label>
                                    <select class="form-select" id="barang" name="barang">
                                    <!-- onchange="setSatStok()" -->
                                        <option value="" disabled selected>-- Pilih barang --</option>
                                        <?php foreach ($barang as $i => $b): ?>
                                            <option id="brg<?= esc($i++); ?>" value="<?= esc($b['idbrg']); ?>"
                                                data-satuan="<?= esc($b['namaSat']); ?>"
                                                data-stok="<?= esc($b['stok']); ?>" onchange="$('#stok')[0].value = this.dataset['stok']"><?=
                                                      esc($b['nama']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback errorBarang"></div>
                                </div>
                                <!-- <input type="hidden" name="barang[stok]" id="newStok" value="$('#barang')"> -->
                            </div>
                            <div class="col-1">
                                <div class="form-group mb-3">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" class="form-control" name="stok" id="stok" disabled>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group mb-3">
                                    <label for="mutasi" class="form-label">Jenis Transaksi</label>
                                    <div class="form-row justify-content-between text-center mt-1">
                                        <div class="col">
                                            <input class="form-check-input" type="radio" name="mutasi" id="debit"
                                                value="D" onchange="toggleJml();" data-mut="Pemasukan">
                                            <label class="form-check-label" for="debit">
                                                Pemasukan</label>
                                            <div class="text-secondary text-sm">(penjualan barang / transaksi lainnya)</div>
                                        </div>
                                        <div class="col">
                                            <input class="form-check-input" type="radio" name="mutasi" id="kredit"
                                                value="K" onchange="toggleJml();" data-mut="Pengeluaran">
                                            <label class="form-check-label" for="kredit">
                                                Pengeluaran</label>
                                            <div class="text-secondary text-sm">(pembelian barang / transaksi lainnya)</div>
                                        </div>
                                    </div>
                                    <div class="text-danger errorMutasi" style="font-size: 83%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-1">
                                <div class="form-group mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" name="jumlah" id="jumlah" disabled>
                                    <div class="invalid-feedback errorJumlah"></div>
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="form-group mb-3">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <input type="text" class="form-control" name="satuan" id="satuan" disabled>
                                    <!-- <div class="invalid-feedback errorSatuan"></div> -->
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" name="harga" id="harga">
                                        <span class="input-group-text">,00</span>
                                        <div class="invalid-feedback errorHarga"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <input type="text" class="form-control" name="keterangan" id="keterangan">
                                    <div class="invalid-feedback errorKeterangan"></div>
                                </div>
                            </div>
                            <!-- <div class="col-4">
                                <div class="form-group mb-3">
                                    <label for="kredit2" class="form-label">Pengeluaran</label>
                                    <input type="number" class="form-control" name="kredit2" id="kredit2" disabled>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <!-- id="tambah" sudah tidak digunakan lagi -->
                        <button class="btn btn-primary" id="tambah" type="submit">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card my-2 shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="ave-bg-th">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Harga</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            <tbody id="listtransaksi" name="listtrans">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <form method="POST" action="<?= base_url() ?>/jurnal/save" id="f2">
                        <input type="hidden" name="successdata" id="sdat">
                        <button class="btn btn-primary" id="jurnal_simpan">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    // DSelect (searchable dropdown) feature
    const config = {
        search: true, // Toggle search feature. Default: false
        // creatable: false, // Creatable selection. Default: false
        // clearable: false, // Clearable selection. Default: false
        // maxHeight: '360px', // Max height for showing scrollbar. Default: 360px
        // size: '', // Can be "sm" or "lg". Default ''
    }
    dselect(document.querySelector('#barang'), config);

    // Creating JS Dictionary
    // NB. I use var so that it can be accessed globally
    var list_transaksi = {};
    // Counter
    var c = 0;


    // Try something new
    // $('#tambah').click(function(e){
    //     e.preventDefault();
        
    // });


    $('.f1').submit(function (e) {
    // $('#tambah').click(function (e) {
        e.preventDefault();

        // let mutasi = $('input[name="mutasi"]:checked').val();
        let stokBrg = +$('#barang')[0].selectedOptions[0].dataset['stok'];
        // let jumlah = +$('#jumlah').val();
        // if (mutasi == 'D') {
        //     stokBrg -= jumlah;
        //     // $('#barang').find(":selected")[0].dataset.stok = stokBrg;
        // } else {
        //     stokBrg += jumlah;
        // }
        // $('#barang').find(":selected")[0].dataset.stok = stokBrg;

        let tmpdata = {stok : stokBrg};
        $('#tdat')[0].value = JSON.stringify(tmpdata);

        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "JSON",
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
                    // console.log('gawrrr');
                    $('#jumlah')[0].setCustomValidity('');
                    f = $('form')[0];
                    // 3 line below specified the input ID -> tanggal
                    // console.log(f['tanggal'].value);
                    // console.log(f['akun'].selectedOptions[0].innerHTML);
                    // console.log(f['kode'].value);
                    // console.log(f);
                    // console.log(f['barang'].selectedOptions[0]);
                    // console.log($('input[name="mutasi"]:checked').data('mut'));
                    // console.log(f['mutasi']);
                    // console.log(f['mutasi'] checked);

                    // if(f.checkValidity()){
                        // if((+$('#barang')[0].selectedOptions[0].dataset['stok']) >= (+$('#jumlah')[0].value)){
                            t = $('#listtransaksi')[0];
                            ftext = `<tr id="list${c}" data-jumlah="${f['jumlah'].value}" data-mutasi="${$('input[name="mutasi"]:checked').val()}" data-idbrg="${f['barang'].selectedOptions[0].value}">
                            <td>${f['tanggal'].value}</td>
                            <td>${f['keterangan'].value}</td>
                            <td>${f['barang'].selectedOptions[0].innerHTML}</td>
                            <td>${f['jumlah'].value}</td>
                            <td>${f['satuan'].value}</td>
                            <td>${$('input[name="mutasi"]:checked').data('mut')}</td>
                            <td>${f['harga'].value}</td>
                            <td><button class="btn btn-danger hapus" onclick="hapus(${c})"><i class="fa-solid fa-fw fa-trash"></i></i></button></td></tr>`;
                            t.innerHTML += ftext;

                            // Preparing data to be sent
                            data = {
                                tanggal: f['tanggal'].value,
                                keterangan: f['keterangan'].value,
                                barang: f['barang'].selectedOptions[0].value,
                                jumlah: f['jumlah'].value,
                                satuan: f['satuan'].value,
                                mutasi: $('input[name="mutasi"]:checked').val(),
                                harga: f['harga'].value,
                                // stok: stokBrg
                            };
                            list_transaksi[c++] = data;

                            // Count Stok Saat ini
                            let mutasi = $('input[name="mutasi"]:checked').val();
                            // let stokBrg = +$('#barang')[0].selectedOptions[0].dataset['stok'];
                            // let jumlah = +$('#jumlah').val();
                            if (mutasi == 'D') {
                                // stokBrg -= jumlah;
                                // $('#barang').find(":selected")[0].dataset.stok = stokBrg;
                                $('#barang')[0].selectedOptions[0].dataset['stok'] = parseInt($('#barang')[0].selectedOptions[0].dataset['stok']) - parseInt($('#jumlah').val());
                                // console.log('debit');
                                // console.log(typeof($('#barang')[0].selectedOptions[0].dataset['stok']));
                            } else {
                                // stokBrg += jumlah;
                                ($('#barang')[0].selectedOptions[0].dataset['stok']) = parseInt($('#barang')[0].selectedOptions[0].dataset['stok']) + parseInt($('#jumlah').val());
                                // console.log('kredit');
                                // console.log(typeof($('#barang')[0].selectedOptions[0].dataset['stok']));
                            }

                            // $('#barang')[0].selectedOptions[0].dataset['stok'] -= $('#jumlah').val();
                            // $('#stok')[0].value = $('#barang')[0].selectedOptions[0].dataset['stok'];
                            $('#stok')[0].value = $('#barang')[0].selectedOptions[0].dataset['stok'];

                            // Clearing inputted data
                            $('#keterangan')[0].value = '';
                            // $('#barang')[0].value = '';
                            // $('#stok')[0].value = '';
                            $('#harga')[0].value = '';
                            // $('#satuan')[0].value = '';
                            $('#jumlah')[0].value = '';

                            Swal.fire({
                                icon: 'success',
                                title: response.flashData,
                                toast: true,
                                position: 'bottom-end',
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        // } else {
                        //     $('#jumlah')[0].setCustomValidity('Jumlah melebihi stok!');
                        //     f.reportValidity();
                        //     console.log('lebih');
                        // }
                    // } else {
                    //     f.reportValidity();
                    // }
                    
                    

                    // // Perhitungan stok sementara agar tidak salah input jumlah untuk data selanjutnya
                    // let mutasi = $('input[name="mutasi"]:checked').val();
                    // let stokBrg = +$('#barang')[0].selectedOptions[0].dataset['stok'];
                    // let jumlah = +$('#jumlah').val();
                    // let stok = $('#stok').val();
                    // // console.log(stokBrg);
                    // // $('#stok').attr('data-abc', 123);
                    // // console.log($('#stok').attr('data-abc', 123));
                    // // console.log(jumlah, stok);
                    // // console.log("AAAAAAAAAAA");
                    // // console.log($('#barang').find(":selected")[0].dataset.stok);
                    // if (mutasi == 'D') {
                    //     stokBrg -= jumlah;
                    //     $('#barang').find(":selected")[0].dataset.stok = stokBrg;
                    //     // $('#stok').value = stokBrg;
                    //     // $('#barang')[0].selectedOptions[0].attr('data-brr', stokBrg);
                    //     // console.log($('#barang')[0].selectedOptions[0].attr('data-brr', stokBrg));
                    //     // $('#barang')[0].selectedOptions[0].data('stok', stokBrg);
                    //     // console.log($('#barang')[0].selectedOptions[0].data('stok', stokBrg));
                    //     // stok = stokBrg;
                    //     // console.log(stokBrg, stok);
                    // } else {
                    //     stokBrg += jumlah;
                    //     $('#barang').find(":selected")[0].dataset.stok = stokBrg;
                    //     // stok = stokBrg;
                    // }

                    // $('#persekot')[0].selectedOptions[0].dataset['sisa'] -= f['jumlah'].value;
                    // $('#sisa')[0].value = rupiah($('#persekot')[0].selectedOptions[0].dataset['sisa']);

                    
                    // console.log(Object.keys(list_transaksi).length);

                    

                    
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                var tab = window.open('about:blank', '_blank');
                tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                tab.document.close(); // to finish loading the page
            }
        });
    });

    // Function to Toggle disabled property on Debit/Kredit Input
    function toggleDeb() {
        $('#debit2').val('');
        $('#kredit2').val('');
        if ($("input[type='radio']:checked").val() == 'Debit') {
            $('#kredit2').prop('disabled', true);
            $('#debit2').prop('disabled', false);
            $('#debit2').prop('required', true);
            $('#debit2').attr('min', 0);
        } else {
            $('#debit2').prop('disabled', true);
            $('#kredit2').prop('disabled', false);
            $('#kredit2').prop('required', true);
            $('#kredit2').attr('min', 0);
        }
    }

    // Function to automatically set satuan and stok barang
    function setSatStok() {
        let brg = $('#barang')[0].selectedOptions[0];
        $('#satuan')[0].value = brg.dataset['satuan'];
        $('#stok')[0].value = brg.dataset['stok'];
    }

    $('#barang').change(function(){
        $('#satuan')[0].value = this.selectedOptions[0].dataset['satuan'];
        $('#stok')[0].value = this.selectedOptions[0].dataset['stok'];
    });

    // Function to Toggle disabled property on Jumlah Input
    function toggleJml() {
        let radButton = $("input[type='radio']:checked").val();
        if (radButton != '') {
            $('#jumlah').prop('disabled', false);
        }
    }

    function hapus(id) {
        a = document.getElementById('list' + id);
        // console.log(a);
        let mutasi = a.dataset['mutasi'];
        let idbrg = a.dataset['idbrg'];
        let jumlah = a.dataset['jumlah'];
        // console.log(idbrg, mutasi);
        let c = 0;
        while ($("#barang option#brg"+c)[0].value != idbrg){
            c++;
        }
        if (mutasi == 'D'){
            $("#barang option#brg"+c)[0].dataset['stok'] = parseInt($("#barang option#brg"+c)[0].dataset['stok']) + parseInt(jumlah);
        } else {
            $("#barang option#brg"+c)[0].dataset['stok'] = parseInt($("#barang option#brg"+c)[0].dataset['stok']) - parseInt(jumlah);
        }
        if ($('#barang')[0].selectedOptions[0].value == $("#barang option#brg"+c)[0].value){
            $('#stok')[0].value = $("#barang option#brg"+c)[0].dataset['stok'];
        }
        // console.log($('#barang')[0].selectedOptions[0]);
        // console.log($('#barang')[0]);
        // console.log($("#barang option#brg"+c)[0].dataset['stok']);

        // s = $('#barang')[0].selectedOptions[0].dataset['stok'];
        

        // $('#barang')[0].selectedOptions[0].dataset['stok'] = +a.dataset['jumlah'] + s;
        // $('#stok')[0].value = $('#barang')[0].selectedOptions[0].dataset['stok'];

        // let mutasi = $('input[name="mutasi"]:checked').val();
        // // let stokBrg = +$('#barang')[0].selectedOptions[0].dataset['stok'];
        // // let jumlah = +$('#jumlah').val();
        // if (mutasi == 'D') {
        //     // stokBrg -= jumlah;
        //     // $('#barang').find(":selected")[0].dataset.stok = stokBrg;
        //     $('#barang')[0].selectedOptions[0].dataset['stok'] = parseInt($('#barang')[0].selectedOptions[0].dataset['stok']) - parseInt($('#jumlah').val());
        //     // console.log('debit');
        //     // console.log(typeof($('#barang')[0].selectedOptions[0].dataset['stok']));
        // } else {
        //     // stokBrg += jumlah;
        //     ($('#barang')[0].selectedOptions[0].dataset['stok']) = parseInt($('#barang')[0].selectedOptions[0].dataset['stok']) + parseInt($('#jumlah').val());
        //     // console.log('kredit');
        //     // console.log(typeof($('#barang')[0].selectedOptions[0].dataset['stok']));
        // }

        a.remove();
        delete list_transaksi[id];
    }

    $('#jurnal_simpan').click(function (e) {
        e.preventDefault();
        t = $('#listtransaksi')[0];

        if (t.childElementCount) {
            this.setCustomValidity('');
            $('#sdat')[0].value = JSON.stringify(list_transaksi);
            $("#f2")[0].submit();
        } else {
            this.setCustomValidity('Tambahkan data minimal satu!');
            this.reportValidity();
        }
    })


</script>

<?= $this->endSection(); ?>