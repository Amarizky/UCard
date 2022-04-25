<!-- Header -->

<!-- Page content -->
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <table style="width: 100%;">
                        <tr>
                            <td style="text-align: left;">
                                <h3 class="mb-0" id="judul">Admin</h3>
                            </td>
                            <td style="text-align: right;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i></button></td>
                        </tr>
                    </table>
                </div>

                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table table-flush" id="datatable-basic">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No HP</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $n = 1;
                            foreach ($admin as $a) : ?>
                                <tr>
                                    <td><?= $n++ ?></td>
                                    <td><?= $a['admin_nohp'] ?></td>
                                    <td><?= $a['admin_nama'] ?></td>
                                    <td><?= $a['admin_email'] ?></td>
                                    <td>
                                        <button id="<?= $a['admin_id'] ?>" type="button" class="btn btn-info btn-sm edit" data-toggle="modal" data-target="#edit"><i class="fa fa-pen"></i></button>
                                        <button id="<?= $a['admin_id'] ?>" type="button" class="btn btn-danger btn-sm hapus" data-toggle="modal" data-target="#hapus"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <!-- Card footer -->
                <div class="card-footer py-4">
                    <nav aria-label="...">
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered" role="document">
        <form method="post" action="<?= base_url('Administrator/tambah_admin') ?>" style="width: 600px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Tambah Admin</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body pb-0">
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="number" name="add_nohp" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="add_nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="add_email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kata sandi</label>
                        <input type="password" autocomplete="off" name="add_password" class="form-control" required>
                    </div>
                    <div class="form-group m-0">
                        <label>Perizinan</label>
                        <table id="tblAddAdminPerm" class="table m-0" style="cursor: default;">
                            <tbody>
                                <tr>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-shop text-primary"></i>
                                    </td>
                                    <td colspan="3">Dashboard</td>
                                    <td class="add_perm_check">
                                        <input type="checkbox" value="1" name="add_perm_dashboard" id="add_perm_dashboard" checked disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-cart text-green"></i>
                                    </td>
                                    <td colspan="3">Order</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_order" type="checkbox" value="1" name="add_perm_order" id="add_perm_order">
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="fa fa-book"></i>
                                    </td>
                                    <td colspan="2">DAFTAR ORDER</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_orderdaftarorder" type="checkbox" value="1" name="add_perm_orderdaftarorder" id="add_perm_orderdaftarorder" disabled>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="fa fa-check"></i>
                                    </td>
                                    <td colspan="2">VERIFIKASI</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_orders" type="checkbox" value="1" name="add_perm_orderverifikasi" id="add_perm_orderverifikasi">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="fa fa-image"></i>
                                    </td>
                                    <td colspan="2">KIRIM DESIGN</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_orders" type="checkbox" value="1" name="add_perm_orderkirimdesign" id="add_perm_orderkirimdesign">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="fa fa-credit-card"></i>
                                    </td>
                                    <td colspan="2">PEMBAYARAN</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_orders" type="checkbox" value="1" name="add_perm_orderpembayaran" id="add_perm_orderpembayaran">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="fa fa-check"></i>
                                    </td>
                                    <td colspan="2">APPROVAL</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_orders" type="checkbox" value="1" name="add_perm_orderapproval" id="add_perm_orderapproval">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="fa fa-print"></i>
                                    </td>
                                    <td colspan="2">PROSES PRODUKSI</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_orders add_perm_produksi" type="checkbox" value="1" name="add_perm_orderproduksi" id="add_perm_orderproduksi">
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="fa fa-warehouse"></i>
                                    </td>
                                    <td>GUDANG</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_orders add_perm_produksis" type="checkbox" value="1" name="add_perm_orderproduksi_gudang" id="add_perm_orderproduksi_gudang">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="fas fa-fingerprint"></i>
                                    </td>
                                    <td>INPUT IDENTIFIKASI</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_orders add_perm_produksis" type="checkbox" value="1" name="add_perm_orderproduksi_identifikasi" id="add_perm_orderproduksi_identifikasi">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="fas fa-print"></i>
                                    </td>
                                    <td>CETAK</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_orders add_perm_produksis" type="checkbox" value="1" name="add_perm_orderproduksi_cetak" id="add_perm_orderproduksi_cetak">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="fas fa-compress-arrows-alt"></i>
                                    </td>
                                    <td>PRESS</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_orders add_perm_produksis" type="checkbox" value="1" name="add_perm_orderproduksi_press" id="add_perm_orderproduksi_press">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="fas fa-cut"></i>
                                    </td>
                                    <td>PLONG</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_orders add_perm_produksis" type="checkbox" value="1" name="add_perm_orderproduksi_plong" id="add_perm_orderproduksi_plong">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="fas fa-spray-can"></i>
                                    </td>
                                    <td>FINISHING</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_orders add_perm_produksis" type="checkbox" value="1" name="add_perm_orderproduksi_finishing" id="add_perm_orderproduksi_finishing">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="far fa-check-circle"></i>
                                    </td>
                                    <td>QUALITY CONTROL</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_orders add_perm_produksis" type="checkbox" value="1" name="add_perm_orderproduksi_qualitycontrol" id="add_perm_orderproduksi_qualitycontrol">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="fas fa-box"></i>
                                    </td>
                                    <td>SIAP KIRIM</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_orders add_perm_produksis" type="checkbox" value="1" name="add_perm_orderproduksi_siapkirim" id="add_perm_orderproduksi_siapkirim">
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="fa fa-truck"></i>
                                    </td>
                                    <td colspan="2">KIRIM / AMBIL</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_orders" type="checkbox" value="1" name="add_perm_orderkirimambil" id="add_perm_orderkirimambil">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="add_perm_icon">
                                        <i class="fa fa-history text-green"></i>
                                    </td>
                                    <td colspan="3">Order History</td>
                                    <td class="add_perm_check">
                                        <input type="checkbox" value="1" name="add_perm_orderhistory" id="add_perm_orderhistory">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-single-copy-04 text-info"></i>
                                    </td>
                                    <td colspan="3">Laporan</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_laporan" type="checkbox" value="1" name="add_perm_laporan" id="add_perm_laporan">
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-single-copy-04 text-info"></i>
                                    </td>
                                    <td colspan="2">Pelanggan</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_laporans" type="checkbox" value="1" name="add_perm_laporanpelanggan" id="add_perm_laporanpelanggan">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-single-copy-04 text-info"></i>
                                    </td>
                                    <td colspan="2">Produk</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_laporans" type="checkbox" value="1" name="add_perm_laporanproduk" id="add_perm_laporanproduk">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-single-copy-04 text-info"></i>
                                    </td>
                                    <td colspan="2">Penjualan</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_laporans" type="checkbox" value="1" name="add_perm_laporanpenjualan" id="add_perm_laporanpenjualan">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-bullet-list-67 text-primary"></i>
                                    </td>
                                    <td colspan="3">Category</td>
                                    <td class="add_perm_check">
                                        <input type="checkbox" value="1" name="add_perm_category" id="add_perm_category">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-box-2 text-danger"></i>
                                    </td>
                                    <td colspan="3">Product</td>
                                    <td class="add_perm_check">
                                        <input type="checkbox" value="1" name="add_perm_produk" id="add_perm_produk">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-image text-green"></i>
                                    </td>
                                    <td colspan="3">Template</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_template" type="checkbox" value="1" name="add_perm_template" id="add_perm_template">
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-image text-green"></i>
                                    </td>
                                    <td colspan="2">Template Assets</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_templates" type="checkbox" value="1" name="add_perm_templateassets" id="add_perm_templateassets">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-image text-green"></i>
                                    </td>
                                    <td colspan="2">Template Pelanggan</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_templates" type="checkbox" value="1" name="add_perm_templatepelanggan" id="add_perm_templatepelanggan">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-image text-info"></i>
                                    </td>
                                    <td colspan="3">Image</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_image" type="checkbox" value="1" name="add_perm_image" id="add_perm_image">
                                    </td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-image text-info"></i>
                                    </td>
                                    <td colspan="2">Image Assets</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_images" type="checkbox" value="1" name="add_perm_imageassets" id="add_perm_imageassets">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-image text-info"></i>
                                    </td>
                                    <td colspan="2">Image Pelanggan</td>
                                    <td class="add_perm_check">
                                        <input class="add_perm_images" type="checkbox" value="1" name="add_perm_imagepelanggan" id="add_perm_imagepelanggan">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-single-02 text-info"></i>
                                    </td>
                                    <td colspan="3">Pelanggan</td>
                                    <td class="add_perm_check">
                                        <input type="checkbox" value="1" name="add_perm_pelanggan" id="add_perm_pelanggan">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-circle-08 text-orange"></i>
                                    </td>
                                    <td colspan="3">Customer Services</td>
                                    <td class="add_perm_check">
                                        <input type="checkbox" value="1" name="add_perm_customerservices" id="add_perm_customerservices">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-tag text-info"></i>
                                    </td>
                                    <td colspan="3">Status</td>
                                    <td class="add_perm_check">
                                        <input type="checkbox" value="1" name="add_perm_status" id="add_perm_status">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-credit-card text-success"></i>
                                    </td>
                                    <td colspan="3">Bank</td>
                                    <td class="add_perm_check">
                                        <input type="checkbox" value="1" name="add_perm_bank" id="add_perm_bank">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="add_perm_icon">
                                        <i class="ni ni-single-02 text-warning"></i>
                                    </td>
                                    <td colspan="3">Admin</td>
                                    <td class="add_perm_check">
                                        <input type="checkbox" value="1" name="add_perm_admin" id="add_perm_admin">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-link ml-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    .add_perm_icon {
        width: 1%;
    }

    .add_perm_check {
        width: 20px;
    }
</style>
<script>
    $('#tblAddAdminPerm tr').click(function() {
        var inp = $(this).find("input")[0];
        if (!$(inp).is('#add_perm_dashboard') && !$(inp).is('#add_perm_orderdaftarorder')) {
            inp.checked = !inp.checked;
            if ($(inp).hasClass("add_perm_order")) {
                $(".add_perm_orders").prop("checked", $(".add_perm_order").prop("checked"));
                $(".add_perm_produksis").prop("checked", $(".add_perm_order").prop("checked"));
                $(".add_perm_orderdaftarorder").prop("checked", $(".add_perm_order").prop("checked"));
            }
            if ($(inp).hasClass("add_perm_orders")) {
                if ($(inp).hasClass("add_perm_produksi")) $(".add_perm_produksis").prop("checked", $(".add_perm_produksi").prop("checked"));
                if ($(".add_perm_orders:checked").length) {
                    $(".add_perm_order").prop("checked", true);
                    $(".add_perm_orderdaftarorder").prop("checked", true);
                } else {
                    $(".add_perm_order").prop("checked", false);
                    $(".add_perm_orderdaftarorder").prop("checked", false);
                }
            }
            if ($(inp).hasClass("add_perm_produksis")) {
                if ($(".add_perm_produksis:checked").length) {
                    $(".add_perm_produksi").prop("checked", true);
                } else {
                    $(".add_perm_produksi").prop("checked", false);
                }
                if ($(".add_perm_orders:checked").length) {
                    $(".add_perm_order").prop("checked", true);
                    $(".add_perm_orderdaftarorder").prop("checked", true);
                } else {
                    $(".add_perm_order").prop("checked", false);
                    $(".add_perm_orderdaftarorder").prop("checked", false);
                }
            }
            if ($(inp).hasClass("add_perm_laporan")) $(".add_perm_laporans").prop("checked", $(".add_perm_laporan").prop("checked"));
            if ($(inp).hasClass("add_perm_laporans"))
                if ($(".add_perm_laporans:checked").length) $(".add_perm_laporan").prop("checked", true);
                else $(".add_perm_laporan").prop("checked", false);
            if ($(inp).hasClass("add_perm_template")) $(".add_perm_templates").prop("checked", $(".add_perm_template").prop("checked"));
            if ($(inp).hasClass("add_perm_templates"))
                if ($(".add_perm_templates:checked").length) $(".add_perm_template").prop("checked", true);
                else $(".add_perm_template").prop("checked", false);
            if ($(inp).hasClass("add_perm_image")) $(".add_perm_images").prop("checked", $(".add_perm_image").prop("checked"));
            if ($(inp).hasClass("add_perm_images"))
                if ($(".add_perm_images:checked").length) $(".add_perm_image").prop("checked", true);
                else $(".add_perm_image").prop("checked", false);
        }
    });
    $('#tblAddAdminPerm input').click(function() {
        this.checked = true;
    })
</script>

</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Edit Admin</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form_edit"></form>
        </div>
    </div>
</div>

</div>
<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Hapus Admin</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert_hapus"></div>
                <h3>Apakah anda yakin ingin menghapus admin ini?</h3>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn_hapus">Hapus</button>
                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>
<script>
    $(document).ready(function() {
        $('#form_edit').submit(function(e) {
            e.preventDefault()
            var formData = $(this).serialize()

            if (formData['nohp'] !== '' && formData['nama'] !== '' && formData['email'] !== '') {
                $.ajax({
                    type: "post",
                    url: "<?= base_url('Administrator/update_admin'); ?>",
                    data: formData,
                    success: function(data) {
                        $('#alert_edit').html('<div class="alert alert-success alert-dismissible fade show" role="alert"><span class="alert-icon"><i class="fa fa-check"></i></span><span class="alert-text"><strong>Berhasil!</strong> Data berhasil diperbarui</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')
                        setTimeout(function() {
                            location.reload();
                        }, 2000)
                    }
                })
                console.log(formData)
            } else {
                $('#alert_edit').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><span class="alert-icon"><i class="fa fa-times"></i></span><span class="alert-text"><strong>Isi semua data</strong> Jangan biarkan data kosong</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')
            }
        })

        $('.hapus').click(function() {
            var id = $(this).attr('id');
            $('.btn_hapus').attr('id', id);
        });
        $('.btn_hapus').click(function() {
            var url = document.URL.substring(0, document.URL.lastIndexOf('#'));
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                url: "<?= base_url('Administrator/hapus_admin') ?>",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#alert_hapus').html('<div class="alert alert-success alert-dismissible fade show" role="alert"><span class="alert-icon"><i class="fa fa-check"></i></span><span class="alert-text"><strong>Berhasil!</strong> Data dihapus</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    setTimeout(function() {
                        window.location.href = url;
                    }, 1000);
                }
            });
        });
        $('.edit').click(function() {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                url: "<?= base_url('Administrator/get_data') ?>",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#form_edit').html(data);
                }
            });
        });
    })
</script>