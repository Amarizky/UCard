<?php
class Administrator extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!isset($this->session->admin_nama)) {
            redirect('Admin');
        }
        if (!$this->M_admin->check_permission('admin')) redirect('Dashboard');
    }

    function index()
    {
        $x['title'] = "Admin";
        $x['admin'] = $this->M_admin->get_admin();
        $this->load->view('admin/template/V_header', $x);
        $this->load->view('admin/V_admin', $x);
        $this->load->view('admin/template/V_footer');
    }
    function get_data()
    {
        $id = $this->input->post('id');
        $a = $this->db->query("SELECT * FROM tbl_admin WHERE admin_id = '$id' ")->row_array();
?>
        <div class="modal-body pb-0">
            <div class="form-group">
                <label>No HP</label>
                <input type="number" name="nohp" class="form-control" value="<?= $a['admin_nohp']; ?>">
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="<?= $a['admin_nama']; ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?= $a['admin_email']; ?>">
            </div>
            <div class="form-group">
                <label>Kata sandi</label>
                <input type="password" autocomplete="off" name="password" class="form-control" placeholder="Tulis di sini untuk mengganti">
                <input type="hidden" name="password_default" value="<?= $a['admin_password']; ?>" class="form-control">
            </div>
            <div class="form-group m-0">
                <label>Perizinan</label>
                <style>
                    .perm_icon {
                        width: 1%;
                    }

                    .perm_check {
                        width: 20px;
                    }
                </style>
                <script>
                    $('#tblPerm tr').click(function() {
                        var inp = $(this).find("input")[0];
                        if (!$(inp).is('#perm_dashboard') && !$(inp).is('#perm_orderdaftarorder')) {
                            inp.checked = !inp.checked;
                            if ($(inp).hasClass("perm_order")) {
                                $(".perm_orders").prop("checked", $(".perm_order").prop("checked"));
                                $(".perm_produksis").prop("checked", $(".perm_order").prop("checked"));
                                $(".perm_orderdaftarorder").prop("checked", $(".perm_order").prop("checked"));
                            }
                            if ($(inp).hasClass("perm_orders")) {
                                if ($(inp).hasClass("perm_produksi")) $(".perm_produksis").prop("checked", $(".perm_produksi").prop("checked"));
                                if ($(".perm_orders:checked").length) {
                                    $(".perm_order").prop("checked", true);
                                    $(".perm_orderdaftarorder").prop("checked", true);
                                } else {
                                    $(".perm_order").prop("checked", false);
                                    $(".perm_orderdaftarorder").prop("checked", false);
                                }
                            }
                            if ($(inp).hasClass("perm_produksis")) {
                                if ($(".perm_produksis:checked").length) {
                                    $(".perm_produksi").prop("checked", true);
                                } else {
                                    $(".perm_produksi").prop("checked", false);
                                }
                                if ($(".perm_orders:checked").length) {
                                    $(".perm_order").prop("checked", true);
                                    $(".perm_orderdaftarorder").prop("checked", true);
                                } else {
                                    $(".perm_order").prop("checked", false);
                                    $(".perm_orderdaftarorder").prop("checked", false);
                                }
                            }
                            if ($(inp).hasClass("perm_laporan")) $(".perm_laporans").prop("checked", $(".perm_laporan").prop("checked"));
                            if ($(inp).hasClass("perm_laporans"))
                                if ($(".perm_laporans:checked").length) $(".perm_laporan").prop("checked", true);
                                else $(".perm_laporan").prop("checked", false);
                            if ($(inp).hasClass("perm_template")) $(".perm_templates").prop("checked", $(".perm_template").prop("checked"));
                            if ($(inp).hasClass("perm_templates"))
                                if ($(".perm_templates:checked").length) $(".perm_template").prop("checked", true);
                                else $(".perm_template").prop("checked", false);
                            if ($(inp).hasClass("perm_image")) $(".perm_images").prop("checked", $(".perm_image").prop("checked"));
                            if ($(inp).hasClass("perm_images"))
                                if ($(".perm_images:checked").length) $(".perm_image").prop("checked", true);
                                else $(".perm_image").prop("checked", false);
                        }
                    });
                    $('#tblPerm input').click(function() {
                        this.checked = !this.checked;
                    })
                </script>
                <table id="tblPerm" class="table m-0" style="cursor: default;">
                    <tbody>
                        <tr>
                            <td class="perm_icon">
                                <i class="ni ni-shop text-primary"></i>
                            </td>
                            <td colspan="3">Dashboard</td>
                            <td class="perm_check">
                                <input type="checkbox" value="1" name="perm_dashboard" id="perm_dashboard" checked disabled>
                            </td>
                        </tr>
                        <tr>
                            <td class="perm_icon">
                                <i class="ni ni-cart text-green"></i>
                            </td>
                            <td colspan="3">Order</td>
                            <td class="perm_check">
                                <input class="perm_order" type="checkbox" value="1" name="perm_order" id="perm_order" <?= $a['admin_perm_order'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td class="perm_icon">
                                <i class="fa fa-book"></i>
                            </td>
                            <td colspan="2">DAFTAR ORDER</td>
                            <td class="perm_check">
                                <input class="perm_orderdaftarorder" type="checkbox" value="1" name="perm_orderdaftarorder" id="perm_orderdaftarorder" <?= $a["admin_perm_orderverifikasi"] || $a["admin_perm_orderkirimdesign"] || $a["admin_perm_orderpembayaran"] || $a["admin_perm_orderapproval"] || $a["admin_perm_orderproduksi"] || $a["admin_perm_orderkirimambil"] ? 'checked' : ''; ?> disabled>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="perm_icon">
                                <i class="fa fa-check"></i>
                            </td>
                            <td colspan="2">VERIFIKASI</td>
                            <td class="perm_check">
                                <input class="perm_orders" type="checkbox" value="1" name="perm_orderverifikasi" id="perm_orderverifikasi" <?= $a['admin_perm_orderverifikasi'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="perm_icon">
                                <i class="fa fa-image"></i>
                            </td>
                            <td colspan="2">KIRIM DESIGN</td>
                            <td class="perm_check">
                                <input class="perm_orders" type="checkbox" value="1" name="perm_orderkirimdesign" id="perm_orderkirimdesign" <?= $a['admin_perm_orderkirimdesign'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="perm_icon">
                                <i class="fa fa-credit-card"></i>
                            </td>
                            <td colspan="2">PEMBAYARAN</td>
                            <td class="perm_check">
                                <input class="perm_orders" type="checkbox" value="1" name="perm_orderpembayaran" id="perm_orderpembayaran" <?= $a['admin_perm_orderpembayaran'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="perm_icon">
                                <i class="fa fa-check"></i>
                            </td>
                            <td colspan="2">APPROVAL</td>
                            <td class="perm_check">
                                <input class="perm_orders" type="checkbox" value="1" name="perm_orderapproval" id="perm_orderapproval" <?= $a['admin_perm_orderapproval'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="perm_icon">
                                <i class="fa fa-print"></i>
                            </td>
                            <td colspan="2">PROSES PRODUKSI</td>
                            <td class="perm_check">
                                <input class="perm_orders perm_produksi" type="checkbox" value="1" name="perm_orderproduksi" id="perm_orderproduksi" <?= $a['admin_perm_orderproduksi'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td class="perm_icon">
                                <i class="fa fa-warehouse"></i>
                            </td>
                            <td>GUDANG</td>
                            <td class="perm_check">
                                <input class="perm_orders perm_produksis" type="checkbox" value="1" name="perm_orderproduksi_gudang" id="perm_orderproduksi_gudang" <?= $a['admin_perm_orderproduksi_gudang'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="perm_icon">
                                <i class="fas fa-fingerprint"></i>
                            </td>
                            <td>INPUT IDENTIFIKASI</td>
                            <td class="perm_check">
                                <input class="perm_orders perm_produksis" type="checkbox" value="1" name="perm_orderproduksi_identifikasi" id="perm_orderproduksi_identifikasi" <?= $a['admin_perm_orderproduksi_identifikasi'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="perm_icon">
                                <i class="fas fa-print"></i>
                            </td>
                            <td>CETAK</td>
                            <td class="perm_check">
                                <input class="perm_orders perm_produksis" type="checkbox" value="1" name="perm_orderproduksi_cetak" id="perm_orderproduksi_cetak" <?= $a['admin_perm_orderproduksi_cetak'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="perm_icon">
                                <i class="fas fa-compress-arrows-alt"></i>
                            </td>
                            <td>PRESS</td>
                            <td class="perm_check">
                                <input class="perm_orders perm_produksis" type="checkbox" value="1" name="perm_orderproduksi_press" id="perm_orderproduksi_press" <?= $a['admin_perm_orderproduksi_press'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="perm_icon">
                                <i class="fas fa-cut"></i>
                            </td>
                            <td>PLONG</td>
                            <td class="perm_check">
                                <input class="perm_orders perm_produksis" type="checkbox" value="1" name="perm_orderproduksi_plong" id="perm_orderproduksi_plong" <?= $a['admin_perm_orderproduksi_plong'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="perm_icon">
                                <i class="fas fa-spray-can"></i>
                            </td>
                            <td>FINISHING</td>
                            <td class="perm_check">
                                <input class="perm_orders perm_produksis" type="checkbox" value="1" name="perm_orderproduksi_finishing" id="perm_orderproduksi_finishing" <?= $a['admin_perm_orderproduksi_finishing'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="perm_icon">
                                <i class="far fa-check-circle"></i>
                            </td>
                            <td>QUALITY CONTROL</td>
                            <td class="perm_check">
                                <input class="perm_orders perm_produksis" type="checkbox" value="1" name="perm_orderproduksi_qualitycontrol" id="perm_orderproduksi_qualitycontrol" <?= $a['admin_perm_orderproduksi_qualitycontrol'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="perm_icon">
                                <i class="fa fa-print"></i>
                            </td>
                            <td>SIAP KIRIM</td>
                            <td class="perm_check">
                                <input class="perm_orders perm_produksis" type="checkbox" value="1" name="perm_orderproduksi_siapkirim" id="perm_orderproduksi_siapkirim" <?= $a['admin_perm_orderproduksi_siapkirim'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td class="perm_icon">
                                <i class="fa fa-truck"></i>
                            </td>
                            <td colspan="2">KIRIM / AMBIL</td>
                            <td class="perm_check">
                                <input class="perm_orders" type="checkbox" value="1" name="perm_orderkirimambil" id="perm_orderkirimambil" <?= $a['admin_perm_orderkirimambil'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>

                        <tr>
                            <td class="perm_icon">
                                <i class="fa fa-history text-green"></i>
                            </td>
                            <td colspan="3">Order History</td>
                            <td class="perm_check">
                                <input type="checkbox" value="1" name="perm_orderhistory" id="perm_orderhistory" <?= $a['admin_perm_orderhistory'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td class="perm_icon">
                                <i class="ni ni-single-copy-04 text-info"></i>
                            </td>
                            <td colspan="3">Laporan</td>
                            <td class="perm_check">
                                <input class="perm_laporan" type="checkbox" value="1" name="perm_laporan" id="perm_laporan" <?= $a['admin_perm_laporan'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td class="perm_icon">
                                <i class="ni ni-single-copy-04 text-info"></i>
                            </td>
                            <td colspan="2">Pelanggan</td>
                            <td class="perm_check">
                                <input class="perm_laporans" type="checkbox" value="1" name="perm_laporanpelanggan" id="perm_laporanpelanggan" <?= $a['admin_perm_laporanpelanggan'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="perm_icon">
                                <i class="ni ni-single-copy-04 text-info"></i>
                            </td>
                            <td colspan="2">Produk</td>
                            <td class="perm_check">
                                <input class="perm_laporans" type="checkbox" value="1" name="perm_laporanproduk" id="perm_laporanproduk" <?= $a['admin_perm_laporanproduk'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="perm_icon">
                                <i class="ni ni-single-copy-04 text-info"></i>
                            </td>
                            <td colspan="2">Penjualan</td>
                            <td class="perm_check">
                                <input class="perm_laporans" type="checkbox" value="1" name="perm_laporanpenjualan" id="perm_laporanpenjualan" <?= $a['admin_perm_laporanpenjualan'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>

                        <tr>
                            <td class="perm_icon">
                                <i class="ni ni-bullet-list-67 text-primary"></i>
                            </td>
                            <td colspan="3">Kategori</td>
                            <td class="perm_check">
                                <input type="checkbox" value="1" name="perm_category" id="perm_category" <?= $a['admin_perm_category'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td class="perm_icon">
                                <i class="ni ni-box-2 text-danger"></i>
                            </td>
                            <td colspan="3">Produk</td>
                            <td class="perm_check">
                                <input type="checkbox" value="1" name="perm_produk" id="perm_produk" <?= $a['admin_perm_produk'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td class="perm_icon">
                                <i class="ni ni-image text-green"></i>
                            </td>
                            <td colspan="3">Template</td>
                            <td class="perm_check">
                                <input class="perm_template" type="checkbox" value="1" name="perm_template" id="perm_template" <?= $a['admin_perm_template'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td class="perm_icon">
                                <i class="ni ni-image text-green"></i>
                            </td>
                            <td colspan="2">Template Assets</td>
                            <td class="perm_check">
                                <input class="perm_templates" type="checkbox" value="1" name="perm_templateassets" id="perm_templateassets" <?= $a['admin_perm_templateassets'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="perm_icon">
                                <i class="ni ni-image text-green"></i>
                            </td>
                            <td colspan="2">Template Pelanggan</td>
                            <td class="perm_check">
                                <input class="perm_templates" type="checkbox" value="1" name="perm_templatepelanggan" id="perm_templatepelanggan" <?= $a['admin_perm_templatepelanggan'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>

                        <tr>
                            <td class="perm_icon">
                                <i class="ni ni-image text-info"></i>
                            </td>
                            <td colspan="3">Image</td>
                            <td class="perm_check">
                                <input class="perm_image" type="checkbox" value="1" name="perm_image" id="perm_image" <?= $a['admin_perm_image'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td class="perm_icon">
                                <i class="ni ni-image text-info"></i>
                            </td>
                            <td colspan="2">Image Assets</td>
                            <td class="perm_check">
                                <input class="perm_images" type="checkbox" value="1" name="perm_imageassets" id="perm_imageassets" <?= $a['admin_perm_imageassets'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="perm_icon">
                                <i class="ni ni-image text-info"></i>
                            </td>
                            <td colspan="2">Image Pelanggan</td>
                            <td class="perm_check">
                                <input class="perm_images" type="checkbox" value="1" name="perm_imagepelanggan" id="perm_imagepelanggan" <?= $a['admin_perm_imagepelanggan'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>

                        <tr>
                            <td class="perm_icon">
                                <i class="ni ni-single-02 text-info"></i>
                            </td>
                            <td colspan="3">Pelanggan</td>
                            <td class="perm_check">
                                <input type="checkbox" value="1" name="perm_pelanggan" id="perm_pelanggan" <?= $a['admin_perm_pelanggan'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td class="perm_icon">
                                <i class="ni ni-circle-08 text-orange"></i>
                            </td>
                            <td colspan="3">Customer Services</td>
                            <td class="perm_check">
                                <input type="checkbox" value="1" name="perm_customerservices" id="perm_customerservices" <?= $a['admin_perm_customerservices'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td class="perm_icon">
                                <i class="ni ni-tag text-info"></i>
                            </td>
                            <td colspan="3">Status</td>
                            <td class="perm_check">
                                <input type="checkbox" value="1" name="perm_status" id="perm_status" <?= $a['admin_perm_status'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td class="perm_icon">
                                <i class="ni ni-credit-card text-success"></i>
                            </td>
                            <td colspan="3">Bank</td>
                            <td class="perm_check">
                                <input type="checkbox" value="1" name="perm_bank" id="perm_bank" <?= $a['admin_perm_bank'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                        <tr>
                            <td class="perm_icon">
                                <i class="ni ni-single-02 text-warning"></i>
                            </td>
                            <td colspan="3">Admin</td>
                            <td class="perm_check">
                                <input type="checkbox" value="1" name="perm_admin" id="perm_admin" <?= $a['admin_perm_admin'] == 1 ? 'checked' : ''; ?>>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="alert_edit"></div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="admin_id" value="<?= $a['admin_id']; ?>">
            <button type="submit" class="btn btn-primary update">Save</button>
            <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
        </div>
<?php

    }
    function tambah_admin()
    {
        $nohp = $this->input->post('add_nohp');

        $data = [
            'admin_id'                                => 'A-' . time(),
            'admin_nama'                              => $this->input->post('add_nama'),
            'admin_email'                             => $this->input->post('add_email'),
            'admin_nohp'                              => (substr(trim($nohp), 0, 1) == '0' ? '62' . substr(trim($nohp), 1) : $nohp),
            'admin_password'                          => md5($this->input->post('add_password')),
            'admin_perm_dashboard'                    => "1",
            'admin_perm_order'                        => $this->input->post('add_perm_order')                        ?? "0",
            'admin_perm_orderverifikasi'              => $this->input->post('add_perm_orderverifikasi')              ?? "0",
            'admin_perm_orderkirimdesign'             => $this->input->post('add_perm_orderkirimdesign')             ?? "0",
            'admin_perm_orderpembayaran'              => $this->input->post('add_perm_orderpembayaran')              ?? "0",
            'admin_perm_orderapproval'                => $this->input->post('add_perm_orderapproval')                ?? "0",
            'admin_perm_orderproduksi'                => $this->input->post('add_perm_orderproduksi')                ?? "0",
            'admin_perm_orderproduksi_gudang'         => $this->input->post('add_perm_orderproduksi_gudang')         ?? "0",
            'admin_perm_orderproduksi_identifikasi'   => $this->input->post('add_perm_orderproduksi_identifikasi')   ?? "0",
            'admin_perm_orderproduksi_cetak'          => $this->input->post('add_perm_orderproduksi_cetak')          ?? "0",
            'admin_perm_orderproduksi_press'          => $this->input->post('add_perm_orderproduksi_press')          ?? "0",
            'admin_perm_orderproduksi_plong'          => $this->input->post('add_perm_orderproduksi_plong')          ?? "0",
            'admin_perm_orderproduksi_finishing'      => $this->input->post('add_perm_orderproduksi_finishing')      ?? "0",
            'admin_perm_orderproduksi_qualitycontrol' => $this->input->post('add_perm_orderproduksi_qualitycontrol') ?? "0",
            'admin_perm_orderproduksi_siapkirim'      => $this->input->post('add_perm_orderproduksi_siapkirim')      ?? "0",
            'admin_perm_orderkirimambil'              => $this->input->post('add_perm_orderkirimambil')              ?? "0",
            'admin_perm_orderhistory'                 => $this->input->post('add_perm_orderhistory')                 ?? "0",
            'admin_perm_laporan'                      => $this->input->post('add_perm_laporan')                      ?? "0",
            'admin_perm_laporanpelanggan'             => $this->input->post('add_perm_laporanpelanggan')             ?? "0",
            'admin_perm_laporanproduk'                => $this->input->post('add_perm_laporanproduk')                ?? "0",
            'admin_perm_laporanpenjualan'             => $this->input->post('add_perm_laporanpenjualan')             ?? "0",
            'admin_perm_category'                     => $this->input->post('add_perm_category')                     ?? "0",
            'admin_perm_produk'                       => $this->input->post('add_perm_produk')                       ?? "0",
            'admin_perm_template'                     => $this->input->post('add_perm_template')                     ?? "0",
            'admin_perm_templateassets'               => $this->input->post('add_perm_templateassets')               ?? "0",
            'admin_perm_templatepelanggan'            => $this->input->post('add_perm_templatepelanggan')            ?? "0",
            'admin_perm_image'                        => $this->input->post('add_perm_image')                        ?? "0",
            'admin_perm_imageassets'                  => $this->input->post('add_perm_imageassets')                  ?? "0",
            'admin_perm_imagepelanggan'               => $this->input->post('add_perm_imagepelanggan')               ?? "0",
            'admin_perm_pelanggan'                    => $this->input->post('add_perm_pelanggan')                    ?? "0",
            'admin_perm_customerservices'             => $this->input->post('add_perm_customerservices')             ?? "0",
            'admin_perm_status'                       => $this->input->post('add_perm_status')                       ?? "0",
            'admin_perm_bank'                         => $this->input->post('add_perm_bank')                         ?? "0",
            'admin_perm_admin'                        => $this->input->post('add_perm_admin')                        ?? "0",
        ];

        $this->db->insert('tbl_admin', $data);
        // $this->M_admin->tambah_admin($id, $hp, $nama, $email, $password);
        redirect('Administrator');
    }
    function update_admin()
    {
        $admin_id = $this->input->post('admin_id');
        $nohp     = $this->input->post('nohp');
        $pw       = md5($this->input->post('password'));
        $pwDef    = $this->input->post('password_default');

        $data = [
            'admin_nama'                              => $this->input->post('nama'),
            'admin_email'                             => $this->input->post('email'),
            'admin_nohp'                              => (substr(trim($nohp), 0, 1) == '0' ? '62' . substr(trim($nohp), 1) : $nohp),
            'admin_password'                          => (empty($password) ? $pw : $pwDef),
            'admin_perm_dashboard'                    => "1",
            'admin_perm_order'                        => $this->input->post('perm_order')                        ?? "0",
            'admin_perm_orderverifikasi'              => $this->input->post('perm_orderverifikasi')              ?? "0",
            'admin_perm_orderkirimdesign'             => $this->input->post('perm_orderkirimdesign')             ?? "0",
            'admin_perm_orderpembayaran'              => $this->input->post('perm_orderpembayaran')              ?? "0",
            'admin_perm_orderapproval'                => $this->input->post('perm_orderapproval')                ?? "0",
            'admin_perm_orderproduksi'                => $this->input->post('perm_orderproduksi')                ?? "0",
            'admin_perm_orderproduksi_gudang'         => $this->input->post('perm_orderproduksi_gudang')         ?? "0",
            'admin_perm_orderproduksi_identifikasi'   => $this->input->post('perm_orderproduksi_identifikasi')   ?? "0",
            'admin_perm_orderproduksi_cetak'          => $this->input->post('perm_orderproduksi_cetak')          ?? "0",
            'admin_perm_orderproduksi_press'          => $this->input->post('perm_orderproduksi_press')          ?? "0",
            'admin_perm_orderproduksi_plong'          => $this->input->post('perm_orderproduksi_plong')          ?? "0",
            'admin_perm_orderproduksi_finishing'      => $this->input->post('perm_orderproduksi_finishing')      ?? "0",
            'admin_perm_orderproduksi_qualitycontrol' => $this->input->post('perm_orderproduksi_qualitycontrol') ?? "0",
            'admin_perm_orderproduksi_siapkirim'      => $this->input->post('perm_orderproduksi_siapkirim')      ?? "0",
            'admin_perm_orderkirimambil'              => $this->input->post('perm_orderkirimambil')              ?? "0",
            'admin_perm_orderhistory'                 => $this->input->post('perm_orderhistory')                 ?? "0",
            'admin_perm_laporan'                      => $this->input->post('perm_laporan')                      ?? "0",
            'admin_perm_laporanpelanggan'             => $this->input->post('perm_laporanpelanggan')             ?? "0",
            'admin_perm_laporanproduk'                => $this->input->post('perm_laporanproduk')                ?? "0",
            'admin_perm_laporanpenjualan'             => $this->input->post('perm_laporanpenjualan')             ?? "0",
            'admin_perm_category'                     => $this->input->post('perm_category')                     ?? "0",
            'admin_perm_produk'                       => $this->input->post('perm_produk')                       ?? "0",
            'admin_perm_template'                     => $this->input->post('perm_template')                     ?? "0",
            'admin_perm_templateassets'               => $this->input->post('perm_templateassets')               ?? "0",
            'admin_perm_templatepelanggan'            => $this->input->post('perm_templatepelanggan')            ?? "0",
            'admin_perm_image'                        => $this->input->post('perm_image')                        ?? "0",
            'admin_perm_imageassets'                  => $this->input->post('perm_imageassets')                  ?? "0",
            'admin_perm_imagepelanggan'               => $this->input->post('perm_imagepelanggan')               ?? "0",
            'admin_perm_pelanggan'                    => $this->input->post('perm_pelanggan')                    ?? "0",
            'admin_perm_customerservices'             => $this->input->post('perm_customerservices')             ?? "0",
            'admin_perm_status'                       => $this->input->post('perm_status')                       ?? "0",
            'admin_perm_bank'                         => $this->input->post('perm_bank')                         ?? "0",
            'admin_perm_admin'                        => $this->input->post('perm_admin')                        ?? "0",
        ];

        $this->db->where('admin_id', $admin_id)->update('tbl_admin', $data);
    }
    function hapus_admin()
    {
        $id = $this->input->post('id');
        $this->M_admin->hapus_admin($id);
    }
}
