<?php
function url($needle)
{
    return (substr(uri_string(), 0, strlen($needle)) === $needle ? 'active' : '');
}
?>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active bg-sidebar-ave">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="icon">
                    <i class="fa-solid fa-money-bill-1-wave app-logo"></i>
                </div>
                <div class="logo">
                    <a href="<?= base_url('/'); ?>" class="nameapp-ave">CashBook</a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block">
                        <!-- <i class="bi bi-x bi-middle"></i></a> -->
                        <i class="fa-solid fa-fw fa-xmark"></i>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li
                    class="sidebar-item <?=(substr(uri_string(), 0, strlen('admin')) === 'admin' || uri_string() === '/' ? 'active' : '') ?>">
                    <a href="<?= base_url('admin'); ?>" class='sidebar-link'>
                        <i class="fa-solid fa-fw fa-user"></i>
                        <span>Profil Admin</span>
                    </a>
                </li>

                <li class="sidebar-item <?= url('jurnal'); ?>">
                    <a href="<?= base_url('jurnal'); ?>" class='sidebar-link'>
                        <i class="fa-solid fa-fw fa-scale-balanced"></i>
                        <span>Jurnal</span>
                    </a>
                </li>

                <!-- <li class="sidebar-item <?php // echo url('akun'); ?>">
                    <a href="<?php // echo base_url('akun'); ?>" class='sidebar-link'>
                        <i class="fa-solid fa-fw fa-file-invoice"></i>
                        <span>Akun</span>
                    </a>
                </li> -->

                <li class="sidebar-item <?= url('bukukas'); ?>">
                    <a href="<?= base_url('bukukas'); ?>" class='sidebar-link'>
                        <i class="fa-brands fa-fw fa-sellcast"></i>
                        <span>Buku Kas</span>
                    </a>
                </li>

                <li class="sidebar-item <?= url('barang'); ?>">
                    <a href="<?= base_url('barang'); ?>" class='sidebar-link'>
                        <i class="fa-solid fa-fw fa-weight-hanging"></i>
                        <span>Barang</span>
                    </a>
                </li>

                <li class="sidebar-item <?= url('satuan'); ?>">
                    <a href="<?= base_url('satuan'); ?>" class='sidebar-link'>
                        <i class="fa-solid fa-fw fa-coins"></i>
                        <span>Satuan</span>
                    </a>
                </li>
                <hr>
                <li class="sidebar-item">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" class='sidebar-link'>
                        <i class="fa-solid fa-fw fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>