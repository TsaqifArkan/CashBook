<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="alert alert-breadcrumb-ave" role="alert">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 fs-6">
            <li class="breadcrumb-item active" aria-current="page">Buku Kas</li>
        </ol>
    </nav>
</div>

<div class="container-fluid">

    <!-- FLASH DATA -->
    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('msg'); ?>"></div>

    <!-- Page Heading -->
    <div class="row my-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Buku Kas</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-2">
                    <div class="row">
                        <div class="col">
                            <h6 class="m-1 fw-bold text-uppercase">Tabel Buku Kas</h6>
                        </div>
                    </div>
                    
                </div>
                <div class="card-body">
                    <div class="sectiondatabukukas">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="viewModalSaldo" style="display: none;"></div> -->
<script>
   function tableBukuKas() {
        $.ajax({
            url: "<?= base_url('bukukas/getData'); ?>",
            dataType: "JSON",
            success: function (response) {
                $('.sectiondatabukukas').html(response.data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                var tab = window.open('about:blank', '_blank');
                tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                tab.document.close(); // to finish loading the page
            }
        });
    }

    $(document).ready(function () {
        tableBukuKas();
    });
</script>
<?= $this->endSection(); ?>