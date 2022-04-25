<?php
$jml_daftar = count(($this->db->query("SELECT t.transaksi_id FROM tbl_transaksi AS t JOIN tbl_status_transaksi AS s ON t.transaksi_id = s.transaksi_order_id WHERE (s.transaksi_status IS NULL OR s.transaksi_status = '0' OR s.transaksi_status = '2')  AND t.transaksi_terima IS NULL AND t.transaksi_deleted = '0' AND s.transaksi_deleted = '0' AND " . $this->M_admin->tambahanQueryOrderYangFungsinyaBuatCekPermission() . ' GROUP BY t.transaksi_id')->result_array()));
$jml_verif = $this->db->query("SELECT count(t.transaksi_id) AS jml_verif FROM tbl_transaksi AS t JOIN tbl_status_transaksi AS s ON t.transaksi_id = s.transaksi_order_id WHERE t.transaksi_terima IS NULL AND s.transaksi_status_id = '1' AND (s.transaksi_status = '2' OR s.transaksi_status = '0' OR s.transaksi_status IS NULL) AND t.transaksi_deleted = '0' AND s.transaksi_deleted = '0'")->row_array()['jml_verif'];
$jml_design = $this->db->query("SELECT count(t.transaksi_id) AS jml_design FROM tbl_transaksi AS t JOIN tbl_status_transaksi AS s ON t.transaksi_id = s.transaksi_order_id WHERE s.transaksi_status_id = '2' AND (s.transaksi_status = '2' OR s.transaksi_status IS NULL OR s.transaksi_status = '0')  AND t.transaksi_terima IS NULL AND t.transaksi_deleted = '0' AND s.transaksi_deleted = '0'")->row_array()['jml_design'];
$jml_pemb = $this->db->query("SELECT count(t.transaksi_id) AS jml_pemb FROM tbl_transaksi AS t JOIN tbl_status_transaksi AS s ON t.transaksi_id = s.transaksi_order_id WHERE s.transaksi_status_id = '3' AND (s.transaksi_status = '2' OR s.transaksi_status IS NULL OR s.transaksi_status = '0')  AND t.transaksi_terima IS NULL AND t.transaksi_deleted = '0' AND s.transaksi_deleted = '0'")->row_array()['jml_pemb'];
$jml_approv = $this->db->query("SELECT count(t.transaksi_id) AS jml_approv FROM tbl_transaksi AS t JOIN tbl_status_transaksi AS s ON t.transaksi_id = s.transaksi_order_id WHERE s.transaksi_status_id = '4' AND (s.transaksi_status = '2' OR s.transaksi_status IS NULL OR s.transaksi_status = '0')  AND t.transaksi_terima IS NULL AND t.transaksi_deleted = '0' AND s.transaksi_deleted = '0'")->row_array()['jml_approv'];
$jml_cetak = count($this->db->query("SELECT t.transaksi_id FROM tbl_transaksi AS t JOIN tbl_status_transaksi AS s ON t.transaksi_id = s.transaksi_order_id WHERE s.transaksi_status_id = '5' AND (s.transaksi_status = '2' OR s.transaksi_status IS NULL OR s.transaksi_status = '0')  AND t.transaksi_terima IS NULL AND t.transaksi_deleted = '0' AND s.transaksi_deleted = '0' GROUP BY t.transaksi_id")->result_array());
$jml_kirim = $this->db->query("SELECT count(t.transaksi_id) AS jml_kirim FROM tbl_transaksi AS t JOIN tbl_status_transaksi AS s ON t.transaksi_id = s.transaksi_order_id WHERE s.transaksi_status_id = '6' AND (s.transaksi_status = '2' OR s.transaksi_status IS NULL OR s.transaksi_status = '0')  AND t.transaksi_terima IS NULL AND t.transaksi_deleted = '0' AND s.transaksi_deleted = '0'")->row_array()['jml_kirim'];
?>

<!DOCTYPE html>
<html>
<!-- buat push doang -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?></title>
    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/img/icon.png') ?>" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/vendor/nucleo/css/nucleo.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('assets/admin/vendor/@fortawesome/fontawesome-free/css/all.min.css') ?>" type="text/css">
    <!-- Page plugins -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') ?>">

    <!-- Argon CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/argon.css?v=1.1.0') ?>" type="text/css">
    <style>
        .required:after {
            color: red;
            content: '*';
        }
    </style>
    <script src="<?= base_url('assets/admin/vendor/jquery/dist/jquery.min.js') ?>"></script>
</head>

<body>
    <!-- Sidenav -->
    <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="sidenav-header d-flex align-items-center">
                <a class="navbar-brand" href="<?= base_url('Dashboard') ?>">
                    <img src="<?= base_url('assets/img/logo-kartuidcard-blue.png') ?>" class="navbar-brand-img" alt="...">
                </a>
                <div class="ml-auto">
                    <!-- Sidenav toggler -->
                    <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <?php $seg1 = $this->uri->segment(1); ?>
                    <?php $seg2 = $this->uri->segment(2); ?>
                    <?php $perms = $this->db->where('admin_id', $_SESSION['admin_id'])->get('tbl_admin')->result_array()[0]; ?>
                    <ul class="navbar-nav">
                        <?php if ($perms['admin_perm_dashboard']) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $seg1 == 'Dashboard' ? 'active' : ''; ?>" href="<?= base_url('Dashboard') ?>">
                                    <i class="ni ni-shop text-primary"></i>
                                    <span class="nav-link-text">Dashboard</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($perms['admin_perm_order']) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $seg1 == 'Order' && $seg2 != 'history' ? 'active' : ''; ?>" href="#navbar-order" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-order">
                                    <i class="ni ni-cart text-green"></i>
                                    <span class="nav-link-text">Order <span class="badge badge-pill badge-danger"><?= $jml_daftar; ?></span></span>
                                </a>
                                <div class="collapse <?= $seg1 == 'Order' && $seg2 != 'history' ? 'show' : ''; ?>" id="navbar-order">
                                    <ul class="nav nav-sm flex-column">
                                        <?php if ($perms['admin_perm_order']) : ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Order') ?>" class="nav-link <?= $seg1 == 'Order' && $seg2 == '' ? 'active' : ''; ?>"><i class="fa fa-book"></i>
                                                    <table class="w-100">
                                                        <tr>
                                                            <td>DAFTAR ORDER</td>
                                                            <td class="text-right"><span id="pill-o" class="badge badge-pill badge-danger"><?= $jml_daftar; ?></span></td>
                                                        </tr>
                                                    </table>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($perms['admin_perm_orderverifikasi']) : ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Order/verifikasi') ?>" class="nav-link <?= $seg2 == 'verifikasi' ? 'active' : ''; ?>"><i class="fa fa-check"></i>
                                                    <table class="w-100">
                                                        <tr>
                                                            <td>VERIFIKASI</td>
                                                            <td class="text-right"><span id="pill-v" class="badge badge-pill badge-danger"><?= $jml_verif; ?></span></td>
                                                        </tr>
                                                    </table>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($perms['admin_perm_orderkirimdesign']) : ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Order/kirim_design') ?>" class="nav-link <?= $seg2 == 'kirim_design' ? 'active' : ''; ?>"><i class="fa fa-image"></i>
                                                    <table class="w-100">
                                                        <tr>
                                                            <td>KIRIM DESIGN</td>
                                                            <td class="text-right"><span id="pill-d" class="badge badge-pill badge-danger"><?= $jml_design ?></span></td>
                                                        </tr>
                                                    </table>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($perms['admin_perm_orderpembayaran']) : ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Order/pembayaran') ?>" class="nav-link <?= $seg2 == 'pembayaran' ? 'active' : ''; ?>"><i class="fa fa-credit-card"></i>
                                                    <table class="w-100">
                                                        <tr>
                                                            <td>PEMBAYARAN</td>
                                                            <td class="text-right"><span id="pill-p" class="badge badge-pill badge-danger"><?= $jml_pemb ?></span></td>
                                                        </tr>
                                                    </table>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($perms['admin_perm_orderapproval']) : ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Order/approval') ?>" class="nav-link <?= $seg2 == 'approval' ? 'active' : ''; ?>"><i class="fa fa-check"></i>
                                                    <table class="w-100">
                                                        <tr>
                                                            <td>APPROVAL</td>
                                                            <td class="text-right"><span id="pill-a" class="badge badge-pill badge-danger"><?= $jml_approv ?></span></td>
                                                        </tr>
                                                    </table>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($perms['admin_perm_orderproduksi']) : ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Order/proses_produksi') ?>" class="nav-link <?= $seg2 == 'proses_produksi' ? 'active' : ''; ?>"><i class="fa fa-print"></i>
                                                    <table class="w-100">
                                                        <tr>
                                                            <td>PRODUKSI</td>
                                                            <td class="text-right"><span id="pill-c" class="badge badge-pill badge-danger"><?= $jml_cetak ?></span></td>
                                                        </tr>
                                                    </table>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($perms['admin_perm_orderkirimambil']) : ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Order/kirim_ambil') ?>" class="nav-link <?= $seg2 == 'kirim_ambil' ? 'active' : ''; ?>">
                                                    <i class="fa fa-truck"></i>
                                                    <table class="w-100">
                                                        <tr>
                                                            <td>KIRIM / AMBIL</td>
                                                            <td class="text-right"><span id="pill-k" class="badge badge-pill badge-danger"><?= $jml_kirim ?></span></td>
                                                        </tr>
                                                    </table>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>
                        <?php if ($perms['admin_perm_orderhistory']) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $seg1 . '/' . $seg2 == 'Order/history' ? 'active' : ''; ?>" href="<?= base_url('Order/history') ?>">
                                    <i class="fa fa-history text-green"></i>
                                    <span class="nav-link-text">Order History</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($perms['admin_perm_laporan']) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $seg1 == 'Laporan' ? 'active' : ''; ?>" href="#navbar-laporan" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-data">
                                    <i class="ni ni-single-copy-04 text-info"></i>
                                    <span class="nav-link-text">Laporan</span>
                                </a>
                                <div class="collapse <?= $seg1 == 'Laporan' ? 'show' : ''; ?>" id="navbar-laporan">
                                    <ul class="nav nav-sm flex-column">
                                        <?php if ($perms['admin_perm_laporanpelanggan']) : ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Laporan/pelanggan') ?>" class="nav-link <?= $seg2 == 'pelanggan' ? 'active' : ''; ?>">
                                                    <i class="ni ni-single-copy-04 text-info"></i>Pelanggan
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($perms['admin_perm_laporanproduk']) : ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Laporan/produk') ?>" class="nav-link <?= $seg2 == 'produk' ? 'active' : ''; ?>">
                                                    <i class="ni ni-single-copy-04 text-info"></i>Produk
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($perms['admin_perm_laporanpenjualan']) : ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Laporan/penjualan') ?>" class="nav-link <?= $seg2 == 'penjualan' ? 'active' : ''; ?>">
                                                    <i class="ni ni-single-copy-04 text-info"></i>Penjualan
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>
                        <?php if ($perms['admin_perm_kupon']) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $seg1 == 'kupon' ? 'active' : ''; ?>" href="<?= base_url('kupon') ?>">
                                    <i class="fa fa-gift text-green"></i>
                                    <span class="nav-link-text">Kupon</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($perms['admin_perm_category']) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $seg1 == 'Kategori' ? 'active' : ''; ?>" href="<?= base_url('Category') ?>">
                                    <i class="ni ni-bullet-list-67 text-primary"></i>
                                    <span class="nav-link-text">Kategori</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($perms['admin_perm_produk']) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $seg1 == 'Produk' ? 'active' : ''; ?>" href="<?= base_url('Product') ?>">
                                    <i class="ni ni-box-2 text-danger"></i>
                                    <span class="nav-link-text">Produk</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($perms['admin_perm_template']) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $seg1 == 'Template' ? 'active' : ''; ?>" href="#navbar-template" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-template">
                                    <i class="ni ni-image text-green"></i>
                                    <span class="nav-link-text">Template</span>
                                </a>
                                <div class="collapse <?= $seg1 == 'Template' ? 'show' : ''; ?>" id="navbar-template">
                                    <ul class="nav nav-sm flex-column">
                                        <?php if ($perms['admin_perm_templateassets']) : ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Template/design_assets') ?>" class="nav-link <?= $seg2 == 'design_assets' ? 'active' : ''; ?>">
                                                    <i class="ni ni-image text-green"></i>Template Assets
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($perms['admin_perm_templatepelanggan']) : ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Template/design_user') ?>" class="nav-link <?= $seg2 == 'design_user' ? 'active' : ''; ?>"><i class="ni ni-image text-green"></i>
                                                    Template Pelanggan
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>
                        <?php if ($perms['admin_perm_image']) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $seg1 == 'Image' ? 'active' : ''; ?>" href="#navbar-image" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-image">
                                    <i class="ni ni-image text-info"></i>
                                    <span class="nav-link-text">Image</span>
                                </a>
                                <div class="collapse <?= $seg1 == 'Image' ? 'show' : ''; ?>" id="navbar-image">
                                    <ul class="nav nav-sm flex-column">
                                        <?php if ($perms['admin_perm_imageassets']) : ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Image/image_assets') ?>" class="nav-link <?= $seg2 == 'image_assets' ? 'active' : ''; ?>">
                                                    <i class="ni ni-image text-info"></i>Image Assets
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($perms['admin_perm_imagepelanggan']) : ?>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Image/image_user') ?>" class="nav-link <?= $seg2 == 'image_user' ? 'active' : ''; ?>">
                                                    <i class="ni ni-image text-info"></i>Image Pelanggan
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>
                        <?php if ($perms['admin_perm_pelanggan']) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $seg1 == 'Pelanggan' ? 'active' : ''; ?>" href="<?= base_url('Pelanggan') ?>">
                                    <i class="ni ni-single-02 text-info"></i>
                                    <span class="nav-link-text">Pelanggan</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($perms['admin_perm_customerservices']) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $seg1 == 'Customer_services' ? 'active' : ''; ?>" href="<?= base_url('Customer_services') ?>">
                                    <i class="ni ni-circle-08 text-orange"></i>
                                    <span class="nav-link-text">Customer Services</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($perms['admin_perm_status']) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $seg1 == 'Status' ? 'active' : ''; ?>" href="<?= base_url('Status') ?>">
                                    <i class="ni ni-tag text-info"></i>
                                    <span class="nav-link-text">Status</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($perms['admin_perm_bank']) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $seg1 == 'Bank' ? 'active' : ''; ?>" href="<?= base_url('Bank') ?>">
                                    <i class="ni ni-credit-card text-success"></i>
                                    <span class="nav-link-text">Bank</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($perms['admin_perm_admin']) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $seg1 == 'Administrator' ? 'active' : ''; ?>" href="<?= base_url('Administrator') ?>">
                                    <i class="ni ni-single-02 text-warning"></i>
                                    <span class="nav-link-text">Admin</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Navbar links -->
                    <ul class="navbar-nav align-items-center ml-md-auto">
                        <li class="nav-item d-xl-none">
                            <!-- Sidenav toggler -->
                            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <?php $notifCount = $this->db->query("SELECT transaksi_status FROM tbl_status_transaksi WHERE transaksi_status = '2' ")->num_rows(); ?>
                    <ul class="navbar-nav align-items-center ml-auto ml-md-0">
                        <li class="nav-item dropdown">
                            <a id="s-n" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ni ni-bell-55"></i>
                                <b><?= $notifCount; ?></b>
                            </a>
                            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right py-0 overflow-hidden">
                                <!-- Dropdown header -->
                                <div class="px-3 py-3">
                                    <h6 class="text-sm text-muted m-0">Ada <b class="text-primary"><?= $notifCount; ?></b> notifikasi</h6>
                                </div>
                                <!-- List group -->
                                <div style="max-height:500px;overflow-y:auto;" class="list-group list-group-flush">
                                    <?php
                                    $status = $this->db->query("SELECT * FROM tbl_status_transaksi AS st JOIN tbl_status AS s ON st.transaksi_status_id = s.status_id JOIN tbl_transaksi AS t ON t.transaksi_id = st.transaksi_order_id JOIN tbl_pelanggan AS p ON t.transaksi_nohp = p.pelanggan_nohp WHERE transaksi_status = '2' ")->result_array();
                                    foreach ($status as $s) :
                                    ?>
                                        <a href="<?= base_url('Order/detail/' . $s['transaksi_id']); ?>" class="list-group-item list-group-item-action">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <!-- Avatar -->
                                                    <i class="<?= $s['status_icon']; ?>"></i>
                                                </div>
                                                <div class="col ml--2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h4 class="mb-0 text-sm"><?= $s['pelanggan_nama']; ?></h4>
                                                        </div>
                                                        <div class="text-right text-muted">
                                                            <small><?= $s['status_status']; ?></small>
                                                        </div>
                                                    </div>
                                                    <p class="text-sm mb-0">Menunggu Konfirmasi</p>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                    <div class="media-body ml-2">
                                        <span class="mb-0 text-sm  font-weight-bold"><?= $_SESSION['admin_nama'] ?></span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0"><?= $_SESSION['admin_nama'] ?></h6>
                                </div>
                                <a href="<?= base_url('Admin/logout_admin') ?>" class="dropdown-item">
                                    <i class="ni ni-user-run"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header -->