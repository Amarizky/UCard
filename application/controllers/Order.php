<?php

class Order extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!isset($this->session->admin_nama)) {
            redirect('Admin');
        }
        if (!$this->M_admin->check_permission('order')) redirect('Dashboard');
    }

    function index()
    {
        $x['title'] = "Daftar Order";
        $x['order'] = $this->db->query("SELECT t.*,p.pelanggan_nama, s.transaksi_status_id, s.transaksi_order_id, s.transaksi_status, s.transaksi_keterangan FROM tbl_transaksi AS t JOIN tbl_status_transaksi AS s ON t.transaksi_id = s.transaksi_order_id JOIN tbl_pelanggan AS p ON t.transaksi_nohp = p.pelanggan_nohp WHERE t.transaksi_terima IS NULL AND ( s.transaksi_status IS NULL OR s.transaksi_status = '0' OR s.transaksi_status = '2') AND t.transaksi_deleted = '0' AND s.transaksi_deleted = '0' " . $this->M_admin->tambahanQueryOrderYangFungsinyaBuatCekPermission() . ' GROUP BY t.transaksi_id')->result_array();
        $this->load->view('admin/template/V_header', $x);
        $this->load->view('admin/V_order', $x);
        $this->load->view('admin/template/V_footer');
    }
    function verifikasi()
    {
        if (!$this->M_admin->check_permission('orderverifikasi')) redirect('Dashboard');
        $x['title'] = "Verifikasi";
        $x['order'] = $this->db->query("SELECT t.*,p.pelanggan_nama, s.transaksi_status_id, s.transaksi_order_id, s.transaksi_status, s.transaksi_keterangan FROM tbl_transaksi AS t JOIN tbl_status_transaksi AS s ON t.transaksi_id = s.transaksi_order_id JOIN tbl_pelanggan AS p ON t.transaksi_nohp = p.pelanggan_nohp WHERE t.transaksi_terima IS NULL AND s.transaksi_status_id = '1' AND (s.transaksi_status = '2' OR s.transaksi_status = '0' OR s.transaksi_status IS NULL) AND t.transaksi_deleted = '0' AND s.transaksi_deleted = '0' GROUP BY t.transaksi_id ")->result_array();
        $this->load->view('admin/template/V_header', $x);
        $this->load->view('admin/V_order', $x);
        $this->load->view('admin/template/V_footer');
    }
    function kirim_design()
    {
        if (!$this->M_admin->check_permission('orderkirimdesign')) redirect('Dashboard');
        $x['title'] = "Kirim Design";
        $x['order'] = $this->db->query("SELECT t.*,p.pelanggan_nama, s.transaksi_status_id, s.transaksi_order_id, s.transaksi_status, s.transaksi_keterangan FROM tbl_transaksi AS t JOIN tbl_status_transaksi AS s ON t.transaksi_id = s.transaksi_order_id JOIN tbl_pelanggan AS p ON t.transaksi_nohp = p.pelanggan_nohp WHERE t.transaksi_terima IS NULL AND s.transaksi_status_id = '2' AND (s.transaksi_status = '2' OR s.transaksi_status = '0' OR s.transaksi_status IS NULL) AND t.transaksi_deleted = '0' AND s.transaksi_deleted = '0' GROUP BY t.transaksi_id ")->result_array();
        $this->load->view('admin/template/V_header', $x);
        $this->load->view('admin/V_order', $x);
        $this->load->view('admin/template/V_footer');
    }
    function pembayaran()
    {
        if (!$this->M_admin->check_permission('orderpembayaran')) redirect('Dashboard');
        $x['title'] = "Pembayaran";
        $x['order'] = $this->db->query("SELECT t.*,p.pelanggan_nama, s.transaksi_status_id, s.transaksi_order_id, s.transaksi_status, s.transaksi_keterangan FROM tbl_transaksi AS t JOIN tbl_status_transaksi AS s ON t.transaksi_id = s.transaksi_order_id JOIN tbl_pelanggan AS p ON t.transaksi_nohp = p.pelanggan_nohp WHERE t.transaksi_terima IS NULL AND s.transaksi_status_id = '3' AND (s.transaksi_status = '2' OR s.transaksi_status = '0' OR s.transaksi_status IS NULL) AND t.transaksi_deleted = '0' AND s.transaksi_deleted = '0' GROUP BY t.transaksi_id ")->result_array();
        $this->load->view('admin/template/V_header', $x);
        $this->load->view('admin/V_order', $x);
        $this->load->view('admin/template/V_footer');
    }
    function approval()
    {
        if (!$this->M_admin->check_permission('orderapproval')) redirect('Dashboard');
        $x['title'] = "Approval";
        $x['order'] = $this->db->query("SELECT t.*,p.pelanggan_nama, s.transaksi_status_id, s.transaksi_order_id, s.transaksi_status, s.transaksi_keterangan FROM tbl_transaksi AS t JOIN tbl_status_transaksi AS s ON t.transaksi_id = s.transaksi_order_id JOIN tbl_pelanggan AS p ON t.transaksi_nohp = p.pelanggan_nohp WHERE t.transaksi_terima IS NULL AND s.transaksi_status_id = '4' AND (s.transaksi_status = '2' OR s.transaksi_status = '0' OR s.transaksi_status IS NULL) AND t.transaksi_deleted = '0' AND s.transaksi_deleted = '0' GROUP BY t.transaksi_id ")->result_array();
        $this->load->view('admin/template/V_header', $x);
        $this->load->view('admin/V_order', $x);
        $this->load->view('admin/template/V_footer');
    }
    function cetak_produk()
    {
        if (!$this->M_admin->check_permission('ordercetakproduk')) redirect('Dashboard');
        $x['title'] = "Cetak Produk";
        $x['order'] = $this->db->query("SELECT t.*,p.pelanggan_nama, s.transaksi_status_id, s.transaksi_order_id, s.transaksi_status, s.transaksi_keterangan FROM tbl_transaksi AS t JOIN tbl_status_transaksi AS s ON t.transaksi_id = s.transaksi_order_id JOIN tbl_pelanggan AS p ON t.transaksi_nohp = p.pelanggan_nohp WHERE t.transaksi_terima IS NULL AND s.transaksi_status_id = '5' AND (s.transaksi_status = '2' OR s.transaksi_status = '0' OR s.transaksi_status IS NULL) AND t.transaksi_deleted = '0' AND s.transaksi_deleted = '0' GROUP BY t.transaksi_id ")->result_array();
        $this->load->view('admin/template/V_header', $x);
        $this->load->view('admin/V_order', $x);
        $this->load->view('admin/template/V_footer');
    }
    function kirim_ambil()
    {
        if (!$this->M_admin->check_permission('orderkirimambil')) redirect('Dashboard');
        $x['title'] = "Ambil / Kirim";
        $x['order'] = $this->db->query("SELECT t.*,p.pelanggan_nama, s.transaksi_status_id, s.transaksi_order_id, s.transaksi_status, s.transaksi_keterangan FROM tbl_transaksi AS t JOIN tbl_status_transaksi AS s ON t.transaksi_id = s.transaksi_order_id JOIN tbl_pelanggan AS p ON t.transaksi_nohp = p.pelanggan_nohp WHERE t.transaksi_terima IS NULL AND s.transaksi_status_id = '6' AND (s.transaksi_status = '2' OR s.transaksi_status = '0' OR s.transaksi_status IS NULL) AND t.transaksi_deleted = '0' AND s.transaksi_deleted = '0' GROUP BY t.transaksi_id ")->result_array();
        $this->load->view('admin/template/V_header', $x);
        $this->load->view('admin/V_order', $x);
        $this->load->view('admin/template/V_footer');
    }
    function history()
    {
        if (!$this->M_admin->check_permission('orderhistory')) redirect('Dashboard');
        $x['title'] = "Order History";
        $x['order'] = $this->db->query("SELECT t.*,p.pelanggan_nama FROM tbl_transaksi AS t JOIN tbl_pelanggan AS p ON t.transaksi_nohp = p.pelanggan_nohp ")->result_array();
        $this->load->view('admin/template/V_header', $x);
        $this->load->view('admin/V_order_history', $x);
        $this->load->view('admin/template/V_footer');
    }
    function check_status()
    {
        echo $this->db->query("SELECT transaksi_status FROM tbl_status_transaksi WHERE transaksi_status = '2' ")->num_rows();
    }
    function new_status()
    {
        $status = $this->db->query("SELECT * FROM tbl_status_transaksi AS st JOIN tbl_status AS s ON st.transaksi_status_id = s.status_id JOIN tbl_transaksi AS t ON t.transaksi_id = st.transaksi_order_id JOIN tbl_pelanggan AS p ON t.transaksi_nohp = p.pelanggan_nohp WHERE transaksi_status = '2' ")->result_array();
        foreach ($status as $s) {
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
        <?php
        }
    }
    function get_data()
    {
        $id = $this->input->post('id');
        $status = $this->db->query("SELECT * FROM tbl_status WHERE status_id LIKE '_'")->result_array();
        $e = $this->db->query("SELECT * FROM tbl_transaksi JOIN tbl_pelanggan ON tbl_transaksi.transaksi_nohp = tbl_pelanggan.pelanggan_nohp JOIN tbl_product ON tbl_transaksi.transaksi_product_id = tbl_product.product_id WHERE transaksi_id = '$id' ")->row_array();
        ?>
        <div class="modal-body">
            <div id="alert_update"></div>
            <div class="tab">
                <button class="tablinks" onclick="openTabs(event, 'Detail')">Detail</button>
                <button class="tablinks" onclick="openTabs(event, 'bukti')">Bukti Transaksi</button>
            </div>
            <div id="Detail" class="tabcontent">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="text-center">Pelanggan</h2>
                        <hr class="m-2">
                        <b>Nama</b>
                        <p><?= $e['pelanggan_nama']; ?></p>
                        <b>Email</b>
                        <p><?= $e['pelanggan_email']; ?></p>
                        <b>Tgl Lahir</b>
                        <p><?= $e['pelanggan_lahir']; ?></p>
                        <b>Alamat</b>
                        <p><?= $e['pelanggan_alamat']; ?></p>
                        <b>Whatsapp</b>
                        <p><?= $e['pelanggan_nohp']; ?></p>
                        <b>Kecamatan</b>
                        <p><?= $e['pelanggan_kecamatan']; ?></p>
                        <b>Kabupaten</b>
                        <p><?= $e['pelanggan_kabupaten']; ?></p>
                        <b>Kodepost</b>
                        <p><?= $e['pelanggan_kodepost']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <h2 class="text-center">Produk</h2>
                        <hr class="m-2">
                        <b>Produk</b>
                        <p><?= $e['product_nama']; ?></p>
                        <b>Jumlah</b>
                        <p><?= $e['transaksi_jumlah']; ?></p>
                        <b>Harga</b>
                        <?php if (empty($e['transaksi_harga'])) : ?>
                            <p>Harga belum ditentukan</p>
                        <?php else : ?>
                            <p><?= 'Rp' . number_format($e['transaksi_harga'], 2, ',', '.'); ?></p>
                        <?php endif; ?>
                        <br>
                        <b>Keterangan</b>
                        <p><?= $e['transaksi_keterangan']; ?></p>
                    </div>
                </div>
            </div>
            <div id="bukti" class="tabcontent">
                <?php if ($e['transaksi_bukti'] == NULL) : ?>
                    Belum ada bukti transaksi
                <?php else : ?>
                    <img style="width:300px;" src="<?= base_url('bukti_transaksi/' . $e['transaksi_bukti']); ?>">
                <?php endif; ?>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
        </div>
    <?php
    }
    function get_data_design()
    {
        $id = $this->input->post('id');
        $id_transaksi = $this->input->post('id_transaksi');
        $g = $this->db->query("SELECT * FROM tbl_user_design WHERE design_id = '$id' ")->row_array();
    ?>
        <div id="alert"></div>
        <div class="row">
            <div class="col-md-12">
                <center>
                    <img style="width: 200px;border-radius:5px;" src="<?= base_url('design_user/') . $g['design_image']; ?>" alt="">
                </center>
                <br>
                <p><?= $g['design_width'] ?> X <?= $g['design_height'] ?></p>
                <br>
                <div>
                    <table style="width:100%;">
                        <tr>
                            <td>
                                <a style="width: 100%;" href="<?= base_url('Editor?design=') . $g['design_id'] . '&level=2&id=' . $id_transaksi; ?>" class="btn btn-primary">Edit Design</a>
                            </td>
                            </td>
                            <td>
                                <button style="width: 100%;" id="hapus_design" class="btn btn-danger">Hapus Design</button></center>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    <?php
    }
    function hapus_design()
    {
        $id = $this->input->post('id');
        $this->db->query("DELETE FROM tbl_user_design WHERE design_id = '$id' ");
    }
    function update_order()
    {
        $id = $this->input->post('id');
        $harga = $this->input->post('harga');
        if (empty($harga)) {
            $h = NULL;
        } else {
            $h = $harga;
        }
        $this->db->query("UPDATE tbl_transaksi SET transaksi_harga = '$h' WHERE transaksi_id = '$id' ");
    }
    function hapus_order()
    {
        $id = $this->input->post('id');
        $this->db->query("UPDATE tbl_transaksi SET transaksi_deleted = '1' WHERE transaksi_id = '$id' ");
        $this->db->query("UPDATE tbl_status_transaksi SET transaksi_deleted = '1' WHERE transaksi_order_id = '$id' ");
    }
    function batal_trans()
    {
        $id = $this->input->post('id');
        $this->db->query("UPDATE tbl_transaksi SET transaksi_status = 'DIBATALKAN' WHERE transaksi_id = '$id' ");
    }
    function detail()
    {
        $x['title'] = "Detail";
        $id = $this->uri->segment(3);
        $o = $this->db->query("SELECT * FROM tbl_transaksi AS t JOIN tbl_pelanggan AS p ON t.transaksi_nohp = p.pelanggan_nohp JOIN tbl_status_transaksi AS s ON t.transaksi_id = s.transaksi_order_id WHERE t.transaksi_id = '$id' " . $this->M_admin->tambahanQueryOrderYangFungsinyaBuatCekPermission())->row_array();
        if (!$o) {
            redirect('Order');
        } else {
            $x['o'] = $o;
            $id_product = $o['transaksi_product_id'];
            $x['p'] = $this->db->query("SELECT * FROM tbl_product WHERE product_id = '$id_product' ")->row_array();
            $x['bank'] = $this->db->query("SELECT * FROM tbl_bank")->result_array();
            $x['status'] = $this->db->query("SELECT * FROM tbl_status WHERE status_id LIKE '_'")->result_array();
            $this->load->view('admin/template/V_header', $x);
            $this->load->view('admin/V_detail', $x);
            $this->load->view('admin/template/V_footer');
        }
    }
    function upload_approval1()
    {
        $id = $this->input->post('id');
        $transaksi_id = $this->input->post('transaksi_id');
        $apv1 = $_FILES['approval1']['name'];
        $config['upload_path']          = './design_approval/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['max_size']             = 0;
        $config['remove_spaces']        = FALSE;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('approval1')) {
            $this->upload->data();
        }

        $a = $this->upload->data('file_name');

        $data = [
            'transaksi_approval_1' => $a
        ];

        $this->db->where('transaksi_id', $transaksi_id);
        $this->db->update('tbl_transaksi', $data);
        redirect('Order/detail/' . $transaksi_id);
    }
    function upload_approval2()
    {
        $id = $this->input->post('id');
        $transaksi_id = $this->input->post('transaksi_id');
        $apv1 = $_FILES['approval2']['name'];
        $config['upload_path']          = './design_approval/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['max_size']             = 0;
        $config['remove_spaces']        = FALSE;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('approval2')) {
            $this->upload->data();
        }

        $a = $this->upload->data('file_name');

        $data = [
            'transaksi_approval_2' => $a
        ];

        $this->db->where('transaksi_id', $transaksi_id);
        $this->db->update('tbl_transaksi', $data);
        redirect('Order/detail/' . $transaksi_id);
    }
    function upload_approval3()
    {
        $id = $this->input->post('id');
        $transaksi_id = $this->input->post('transaksi_id');
        $apv1 = $_FILES['approval3']['name'];
        $config['upload_path']          = './design_approval/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['max_size']             = 0;
        $config['remove_spaces']        = FALSE;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('approval3')) {
            $this->upload->data();
        }

        $a = $this->upload->data('file_name');

        $data = [
            'transaksi_approval_3' => $a
        ];

        $this->db->where('transaksi_id', $transaksi_id);
        $this->db->update('tbl_transaksi', $data);
        redirect('Order/detail/' . $transaksi_id);
    }
    function info_design()
    {
        $d = $this->input->post('d');
        $data = getimagesize($d);
        $width = $data[0];
        $height = $data[1];

        echo $height . ' X ' . $width;
    }
    function hapus_design_upload()
    {
        $id = $this->input->post('id');
        $this->db->query("DELETE FROM tbl_design_kirim WHERE design_id = '$id' ");
    }
    function status()
    {
        $id_status = $this->input->post('id_status');
        $status_urut = (50 < $id_status && $id_status <= 55 ? '5' : $this->input->post('id_status') + 1);
        $id = $this->input->post('id');
        $keputusan = $this->input->post('keputusan');
        $keterangan = $this->input->post('keterangan');
        $personalisasi = $this->input->post('personalisasi');
        $coating = $this->input->post('coating');
        $finishing = $this->input->post('finishing');
        $function = $this->input->post('function');
        $packaging = $this->input->post('packaging');
        $status = $this->input->post('status');
        $user = $this->input->post('user');
        $tanggal_ini = time();

        $pelanggan = $this->db->query("SELECT p.* FROM tbl_transaksi AS t JOIN tbl_pelanggan AS p ON t.transaksi_nohp = p.pelanggan_nohp WHERE transaksi_id = '$id' ")->row_array();
        $transaksi_produksi_status_id = $this->db->query("SELECT max(transaksi_produksi_status_id) as tpsi FROM tbl_status_transaksi WHERE transaksi_order_id = '$id' ")->row_array()['tpsi'];
        $s = $this->db->query("SELECT * FROM tbl_status WHERE status_id = '$status_urut' ")->row_array();

        if ($keputusan == '1') {
            $k = 'DITERIMA';
            $tanggal_hangus = $tanggal_ini + (86400 * $s['status_jangka_waktu']);
            $this->db->query("UPDATE tbl_status_transaksi SET transaksi_status = '$keputusan', transaksi_keterangan = '$keterangan' WHERE transaksi_status_id = '$id_status' AND transaksi_order_id = '$id' ");

            switch ($id_status) {
                case "1":
                    $dataVerif = array(
                        'transaksi_id'  => $id,
                        'verif_pesanan' => $user
                    );
                    $this->db->insert('tbl_verifikasi', $dataVerif);

                    //kirim email telah terverifikasi
                    $this->load->library('email');

                    $this->email->clear();
                    $this->email->to($pelanggan['pelanggan_email']);
                    $this->email->from('amarizky02@gmail.com');
                    $this->email->subject('UCard Surabaya - Pesananmu sudah diverifikasi!');
                    $this->email->set_mailtype('html');
                    $this->email->message('
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCARD - Pesananmu sudah diverifikasi</title>
    <style>
    body{background-color:#f5f5f5;text-align:center}.btn{color:#fff;background-color:#4caf50;font-size:16px;border-radius:8px;border:0;width:180px;height:40px;cursor:pointer}.container{background-image:linear-gradient(87deg,#5e72e4 0,#825ee4 100%);min-width:480px;max-width:700px;border-radius:8px;height:auto;padding-bottom:10px}.body{padding:20px;background-color:#fff;text-align:start;border-radius:8px}.code{text-align:center;color:#000;font-size:18px}.m-auto{margin:auto}.m-10{margin:10px}.p-10{padding:10px}.text-center{text-align:center}.w-100{width:100%}
    </style>
</head>

<body>

    <div class="text-center">
        <div class="container">
            <div class="m-auto p-10 text-center">
                <img src="' . base_url('assets/img/logo-kartuidcard-white.png') . '" alt="">
            </div>
            <div class="m-10 body">
                <h2 class="text-center">Halo, ' . $pelanggan["pelanggan_nama"] . '!</h2>
                <br>
                <p>Pesananmu pada tanggal ' . $pelanggan["transaksi_tanggal"] . ' sudah diverifikasi oleh ' . $user . ' nih! Ayo cek sekarang juga untuk melanjutkan ke tahap berikutnya!</p>
                <p>Tekan tombol di bawah untuk membuka halaman detail produk.</p>
                <div class="text-center">
                    <a href="' . base_url('Order_pelanggan/detail/' . $id) . '">
                        <button class="btn">Detail Produk</button>
                    </a>
                </div>
            </div>
            <p style="color: white;">UCard Surabaya<br>Jl. Rungkut Harapan Blk. F No.008, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
        </div>
    </div>
</body>

</html>
            ');
                    $this->email->send();
                    break;
                case "2":
                    $this->db->set('verif_desain', $user)->where('transaksi_id', $id)->update('tbl_verifikasi');
                    //kirim email desain diterima
                    $this->load->library('email');

                    $this->email->clear();
                    $this->email->to($pelanggan['pelanggan_email']);
                    $this->email->from('amarizky02@gmail.com');
                    $this->email->subject('UCard Surabaya - Desainmu sudah diverifikasi!');
                    $this->email->set_mailtype('html');
                    $this->email->message('
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCARD - Desainmu sudah diverifikasi</title>
    <style>
    body{background-color:#f5f5f5;text-align:center}.btn{color:#fff;background-color:#4caf50;font-size:16px;border-radius:8px;border:0;width:180px;height:40px;cursor:pointer}.container{background-image:linear-gradient(87deg,#5e72e4 0,#825ee4 100%);min-width:480px;max-width:700px;border-radius:8px;height:auto;padding-bottom:10px}.body{padding:20px;background-color:#fff;text-align:start;border-radius:8px}.code{text-align:center;color:#000;font-size:18px}.m-auto{margin:auto}.m-10{margin:10px}.p-10{padding:10px}.text-center{text-align:center}.w-100{width:100%}
    </style>
</head>

<body>

    <div class="text-center">
        <div class="container">
            <div class="m-auto p-10 text-center">
                <img src="' . base_url('assets/img/logo-kartuidcard-white.png') . '" alt="">
            </div>
            <div class="m-10 body">
                <h2 class="text-center">Halo, ' . $pelanggan["pelanggan_nama"] . '!</h2>
                <br>
                <p>Desainmu ' . $pelanggan["transaksi_tanggal"] . ' sudah diverifikasi oleh ' . $user . ' nih! Ayo cek sekarang juga untuk melanjutkan ke tahap berikutnya!</p>
                <p>Tekan tombol di bawah untuk membuka halaman detail produk.</p>
                <div class="text-center">
                    <a href="' . base_url('Order_pelanggan/detail/' . $id) . '">
                        <button class="btn">Detail Produk</button>
                    </a>
                </div>
            </div>
            <p style="color: white;">UCard Surabaya<br>Jl. Rungkut Harapan Blk. F No.008, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
        </div>
    </div>
</body>

</html>
            ');
                    $this->email->send();
                    break;
                case "3":
                    $this->db->set('verif_pembayaran', $user)->where('transaksi_id', $id)->update('tbl_verifikasi');
                    //kirim email pembayaran diterima
                    $this->load->library('email');

                    $this->email->clear();
                    $this->email->to($pelanggan['pelanggan_email']);
                    $this->email->from('amarizky02@gmail.com');
                    $this->email->subject('UCard Surabaya - Pembayaranmu sudah diverifikasi!');
                    $this->email->set_mailtype('html');
                    $this->email->message('
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCARD - Pembayaranmu sudah diverifikasi</title>
    <style>
    body{background-color:#f5f5f5;text-align:center}.btn{color:#fff;background-color:#4caf50;font-size:16px;border-radius:8px;border:0;width:180px;height:40px;cursor:pointer}.container{background-image:linear-gradient(87deg,#5e72e4 0,#825ee4 100%);min-width:480px;max-width:700px;border-radius:8px;height:auto;padding-bottom:10px}.body{padding:20px;background-color:#fff;text-align:start;border-radius:8px}.code{text-align:center;color:#000;font-size:18px}.m-auto{margin:auto}.m-10{margin:10px}.p-10{padding:10px}.text-center{text-align:center}.w-100{width:100%}
    </style>
</head>

<body>

    <div class="text-center">
        <div class="container">
            <div class="m-auto p-10 text-center">
                <img src="' . base_url('assets/img/logo-kartuidcard-white.png') . '" alt="">
            </div>
            <div class="m-10 body">
                <h2 class="text-center">Halo, ' . $pelanggan["pelanggan_nama"] . '!</h2>
                <br>
                <p>Pembayaranmu ' . $pelanggan["transaksi_tanggal"] . ' sudah diverifikasi oleh ' . $user . ' nih! Ayo cek sekarang juga untuk melanjutkan ke tahap berikutnya!</p>
                <p>Tekan tombol di bawah untuk membuka halaman detail produk.</p>
                <div class="text-center">
                    <a href="' . base_url('Order_pelanggan/detail/' . $id) . '">
                        <button class="btn">Detail Produk</button>
                    </a>
                </div>
            </div>
            <p style="color: white;">UCard Surabaya<br>Jl. Rungkut Harapan Blk. F No.008, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
        </div>
    </div>
</body>

</html>
            ');
                    $this->email->send();
                    break;
                case "4":
                    $this->db->set('verif_approval', $user)->where('transaksi_id', $id)->update('tbl_verifikasi');
                    $transaksi_produksi_status_id = '51';

                    //kirim email pembayaran diterima
                    $this->load->library('email');

                    $this->email->clear();
                    $this->email->to($pelanggan['pelanggan_email']);
                    $this->email->from('amarizky02@gmail.com');
                    $this->email->subject('UCard Surabaya - Approval : Pilih Desain Cetakanmu');
                    $this->email->set_mailtype('html');
                    $this->email->message('
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCARD - Selesaikan Proses Approval</title>
    <style>
    body{background-color:#f5f5f5;text-align:center}.btn{color:#fff;background-color:#4caf50;font-size:16px;border-radius:8px;border:0;width:180px;height:40px;cursor:pointer}.container{background-image:linear-gradient(87deg,#5e72e4 0,#825ee4 100%);min-width:480px;max-width:700px;border-radius:8px;height:auto;padding-bottom:10px}.body{padding:20px;background-color:#fff;text-align:start;border-radius:8px}.code{text-align:center;color:#000;font-size:18px}.m-auto{margin:auto}.m-10{margin:10px}.p-10{padding:10px}.text-center{text-align:center}.w-100{width:100%}
    </style>
</head>

<body>

    <div class="text-center">
        <div class="container">
            <div class="m-auto p-10 text-center">
                <img src="' . base_url('assets/img/logo-kartuidcard-white.png') . '" alt="">
            </div>
            <div class="m-10 body">
                <h2 class="text-center">Halo, ' . $pelanggan["pelanggan_nama"] . '!</h2>
                <br>
                <p>Proses pemilihan desaimu ' . $pelanggan["transaksi_tanggal"] . ' sudah diverifikasi oleh ' . $user . ' nih! Ayo cek sekarang juga untuk melanjutkan ke tahap berikutnya!</p>
                <p>Tekan tombol di bawah untuk membuka halaman detail produk.</p>
                <div class="text-center">
                    <a href="' . base_url('Order_pelanggan/detail/' . $id) . '">
                        <button class="btn">Detail Produk</button>
                    </a>
                </div>
            </div>
            <p style="color: white;">UCard Surabaya<br>Jl. Rungkut Harapan Blk. F No.008, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
        </div>
    </div>
</body>

</html>
                ');
                    $this->email->send();
                    break;
                case '51':
                    // $this->db->set('verif_cetak', $user)->where('transaksi_id', $id)->update('tbl_verifikasi');
                    $transaksi_produksi_status_id = '52';
                    break;
                case '52':
                    $transaksi_produksi_status_id = '53';
                    break;
                case '53':
                    $transaksi_produksi_status_id = '54';
                    break;
                case '54':
                    $transaksi_produksi_status_id = '55';
                    break;
                case '55':
                    $this->db->set('verif_cetak', $user)->where('transaksi_id', $id)->update('tbl_verifikasi');
                    $this->db->set('transaksi_status', '1')->where(['transaksi_status_id' => '5', 'transaksi_order_id' => $id])->update('tbl_status_transaksi');
                    $status_urut = '6';

                    //produk selesai dicetak
                    $this->load->library('email');

                    $this->email->clear();
                    $this->email->to($pelanggan['pelanggan_email']);
                    $this->email->from('amarizky02@gmail.com');
                    $this->email->subject('UCard Surabaya - Pesananmu sudah selesai dicetak!');
                    $this->email->set_mailtype('html');
                    $this->email->message('
<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UCARD - Pesananmu sudah selesai dicetak</title>
<style>
body{background-color:#f5f5f5;text-align:center}.btn{color:#fff;background-color:#4caf50;font-size:16px;border-radius:8px;border:0;width:180px;height:40px;cursor:pointer}.container{background-image:linear-gradient(87deg,#5e72e4 0,#825ee4 100%);min-width:480px;max-width:700px;border-radius:8px;height:auto;padding-bottom:10px}.body{padding:20px;background-color:#fff;text-align:start;border-radius:8px}.code{text-align:center;color:#000;font-size:18px}.m-auto{margin:auto}.m-10{margin:10px}.p-10{padding:10px}.text-center{text-align:center}.w-100{width:100%}
</style>
</head>

<body>

<div class="text-center">
<div class="container">
    <div class="m-auto p-10 text-center">
        <img src="' . base_url('assets/img/logo-kartuidcard-white.png') . '" alt="">
    </div>
    <div class="m-10 body">
        <h2 class="text-center">Halo, ' . $pelanggan["pelanggan_nama"] . '!</h2>
        <br>
        <p>Pesananmu ' . $pelanggan["transaksi_tanggal"] . ' sudah selesai dicetak nih! Ayo cek sekarang juga untuk melanjutkan ke tahap berikutnya!</p>
        <p>Tekan tombol di bawah untuk membuka halaman detail produk.</p>
        <div class="text-center">
            <a href="' . base_url('Order_pelanggan/detail/' . $id) . '">
                <button class="btn">Detail Produk</button>
            </a>
        </div>
    </div>
    <p style="color: white;">UCard Surabaya<br>Jl. Rungkut Harapan Blk. F No.008, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
</div>
</div>
</body>

</html>
            ');
                    $this->email->send();
                    break;

                default:
                    break;
            }

            $data = array(
                'transaksi_status_id'           => $status_urut,
                'transaksi_produksi_status_id'  => $transaksi_produksi_status_id,
                'transaksi_order_id'            => $id,
                'transaksi_tanggal'             => $tanggal_ini,
                'transaksi_tanggal_hangus'      => $tanggal_hangus
            );

            $this->db->insert('tbl_status_transaksi', $data);
        } else {
            $k = 'DITOLAK';
            $tanggal_hangus = $tanggal_ini + (86400 * $s['status_jangka_waktu']);
            $this->db->query("UPDATE tbl_status_transaksi SET transaksi_status = '$keputusan', transaksi_keterangan = '$keterangan', transaksi_tanggal = '$tanggal_ini', transaksi_tanggal_hangus = '$tanggal_hangus' WHERE transaksi_status_id = '$id_status' AND transaksi_order_id = '$id' ");
        }
    }
    function paket()
    {
        $id = $this->input->post('id');
        $val = $this->input->post('val');
        $this->db->query("UPDATE tbl_transaksi SET transaksi_paket = '$val' WHERE transaksi_id = '$id' ");
    }
    function terima()
    {
        $id = $this->input->post('id');
        $val = $this->input->post('val');
        $user = $this->input->post('user');
        $this->db->query("UPDATE tbl_transaksi SET transaksi_terima = '$val' WHERE transaksi_id = '$id' ");
        $this->db->query("UPDATE tbl_status_transaksi SET transaksi_status = '$val', transaksi_keterangan = 'Sudah Diterima' WHERE transaksi_status_id = '6' AND transaksi_order_id = '$id' ");
        $o = $this->db->query("SELECT * FROM tbl_transaksi WHERE transaksi_id = '$id' ")->row_array();
    ?>
        <div class="wrapper">
            <h2><?= $o['transaksi_paket'] == '1' ? 'Kirim Paket' : 'Ambil Sendiri'; ?></h2>
            <h2>Paket sudah diterima</h2>
        </div>
        <?php

        $this->db->set('verif_kirimambil', $user)->where('transaksi_id', $id)->update('tbl_verifikasi');
    }
    function check()
    {
        $check = $this->db->query("SELECT transaksi_id FROM tbl_transaksi WHERE transaksi_new = '1' ORDER BY transaksi_id DESC")->row_array();
        $id = $check['transaksi_id'];
        if ($check) {
            echo 'baru';
            $this->db->query("UPDATE tbl_transaksi SET transaksi_new = '0' WHERE transaksi_id = '$id' ");
        }
    }
    function check_tot()
    {
        echo $this->db->query("SELECT transaksi_id FROM tbl_transaksi WHERE transaksi_terima IS NULL ")->num_rows();
    }
    function check_v()
    {
        echo $this->db->query("SELECT t.transaksi_id AS kd FROM tbl_transaksi AS t JOIN tbl_status_transaksi AS s ON t.transaksi_id = s.transaksi_order_id WHERE t.transaksi_terima IS NULL AND s.transaksi_status_id = '1' AND (s.transaksi_status = '2' OR s.transaksi_status = '0' OR s.transaksi_status IS NULL) ")->num_rows();
    }
    function get_status()
    {
        $id = $this->input->post('id');
        $id_status = $this->input->post('id_status');

        if ($id_status > 50) {
            $s = $this->db->query("SELECT * FROM tbl_status_transaksi WHERE transaksi_produksi_status_id = '$id_status' AND transaksi_order_id = '$id' ")->row_array();
            $status = $this->db->query("SELECT * FROM tbl_status WHERE status_id LIKE '5_' OR status_id = '6';")->result_array();
            $curr = $status[array_search($id_status, array_column($status, 'status_id'))];
            $next = $status[array_search(($id_status != '55' ? $id_status + 1 : '6'), array_column($status, 'status_id'))];
        ?>
            <div class="modal-body pt-0">
                <input type="hidden" value="<?= $id_status; ?>" id="id_status">
                <div class="form-group">
                    <input id="keputusan" type="hidden" value="1">
                    <p>Status saat ini: <b><?= $curr['status_status']; ?></b><br>Status selanjutnya: <b><?= $next['status_status']; ?></b><br><br>
                    <p class="mb-0">Apakah Anda yakin ingin melanjutkan proses produksi ke tahap selanjutnya?</p>
                </div>
                <div class="modal-footer p-1 pt-0">
                    <button style="width:100%;" id="update-status" class="btn btn-primary">Ya</button>
                </div>
            <?php
        } else {
            $s = $this->db->query("SELECT * FROM tbl_status_transaksi WHERE transaksi_status_id = '$id_status' AND transaksi_order_id = '$id' ")->row_array();
            $o = $this->db->query("SELECT * FROM tbl_transaksi WHERE transaksi_id = '$id' ")->row_array();

            ?>
                <div class="modal-body">
                    <input type="hidden" value="<?= $id_status; ?>" id="id_status">
                    <div class="form-group">
                        <label>Keputusan *</label><br>
                        <select id="keputusan" name="keputusan" class="form-control" required="">
                            <option value="">--Pilih--</option>
                            <?php if ($id_status != '5') : ?>
                                <?php if ($s['transaksi_status'] == '1') : ?>
                                    <option selected value="1">Diterima</option>
                                <?php else : ?>
                                    <option value="1">Diterima</option>
                                <?php endif; ?>
                                <?php if ($s['transaksi_status'] == '0') : ?>
                                    <option selected value="0">Ditolak</option>
                                <?php else : ?>
                                    <option value="0">Ditolak</option>
                                <?php endif; ?>
                            <?php else : ?>
                                <option value="1">Sudah Jadi</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="grid-container">
                        <div class="grid-item">
                            <b>Personalisasi</b>
                            <br><br>
                            <div class="form-group">
                                <input type="checkbox" id="persona1" placeholder="personalisasi" name="personalisasi" value="1" <?= $o['transaksi_personalisasi'] == '1' ? 'checked' : ''; ?>>
                                <label for="persona1">Blanko</label><br>
                                <input type="checkbox" id="persona2" placeholder="personalisasi" name="personalisasi" value="2" <?= $o['transaksi_personalisasi'] == '2' ? 'checked' : ''; ?>>
                                <label for="persona2">Nomerator</label><br>
                                <input type="checkbox" id="persona3" placeholder="personalisasi" name="personalisasi" value="3" <?= $o['transaksi_personalisasi'] == '3' ? 'checked' : ''; ?>>
                                <label for="persona3">Barcode</label><br>
                                <input type="checkbox" id="persona4" placeholder="personalisasi" name="personalisasi" value="4" <?= $o['transaksi_personalisasi'] == '4' ? 'checked' : ''; ?>>
                                <label for="persona4">Data</label><br>
                                <input type="checkbox" id="persona5" placeholder="personalisasi" name="personalisasi" value="5" <?= $o['transaksi_personalisasi'] == '5' ? 'checked' : ''; ?>>
                                <label for="persona5">Data + Foto</label>
                            </div>
                        </div>
                        <div class="grid-item">
                            <b>Coating</b>
                            <br><br>
                            <input type="radio" id="coating1" placeholder="coating" name="coating" value="1" <?= $o['transaksi_coating'] == '1' ? 'checked' : ''; ?>>
                            <label for="coating1">Glossy</label><br>
                            <input type="radio" id="coating2" placeholder="coating" name="coating" value="2" <?= $o['transaksi_coating'] == '2' ? 'checked' : ''; ?>>
                            <label for="coating2">Doff</label><br>
                            <input type="radio" id="coating3" placeholder="coating" name="coating" value="3" <?= $o['transaksi_coating'] == '3' ? 'checked' : ''; ?>>
                            <label for="coating3">Glossy + Doff</label><br>
                            <input type="radio" id="coating4" placeholder="coating" name="coating" value="4" <?= $o['transaksi_coating'] == '4' ? 'checked' : ''; ?>>
                            <label for="coating3">UV</label>
                        </div>
                        <div class="grid-item">
                            <b>Finishing</b>
                            <br><br>
                            <input type="checkbox" id="finish1" placeholder="finishing" name="finishing" value="1" <?= $o['transaksi_finishing'] == '1' ? 'checked' : ''; ?>>
                            <label for="finish1">Tidak ada</label><br>
                            <input type="checkbox" id="finish2" placeholder="finishing" name="finishing" value="2" <?= $o['transaksi_finishing'] == '2' ? 'checked' : ''; ?>>
                            <label for="finish2">Urutkan</label><br>
                            <input type="checkbox" id="finish3" placeholder="finishing" name="finishing" value="3" <?= $o['transaksi_finishing'] == '3' ? 'checked' : ''; ?>>
                            <label for="finish3">Label Gosok</label><br>
                            <input type="checkbox" id="finish4" placeholder="finishing" name="finishing" value="4" <?= $o['transaksi_finishing'] == '4' ? 'checked' : ''; ?>>
                            <label for="finish4">Plong Oval</label><br>
                            <input type="checkbox" id="finish5" placeholder="finishing" name="finishing" value="5" <?= $o['transaksi_finishing'] == '5' ? 'checked' : ''; ?>>
                            <label for="finish5">Plong Bulat</label><br>
                            <input type="checkbox" id="finish6" placeholder="finishing" name="finishing" value="6" <?= $o['transaksi_finishing'] == '6' ? 'checked' : ''; ?>>
                            <label for="finish6">Copy Data RFID</label><br>
                            <input type="checkbox" id="finish7" placeholder="finishing" name="finishing" value="7" <?= $o['transaksi_finishing'] == '7' ? 'checked' : ''; ?>>
                            <label for="finish7">Emboss Silver</label><br>
                            <input type="checkbox" id="finish8" placeholder="finishing" name="finishing" value="8" <?= $o['transaksi_finishing'] == '8' ? 'checked' : ''; ?>>
                            <label for="finish8">Emboss Gold</label><br>
                            <input type="checkbox" id="finish9" placeholder="finishing" name="finishing" value="9" <?= $o['transaksi_finishing'] == '9' ? 'checked' : ''; ?>>
                            <label for="finish9">Panel</label><br>
                            <input type="checkbox" id="finish10" placeholder="finishing" name="finishing" value="10" <?= $o['transaksi_finishing'] == '10' ? 'checked' : ''; ?>>
                            <label for="finish10">Hot Print</label><br>
                            <input type="checkbox" id="finish11" placeholder="finishing" name="finishing" value="11" <?= $o['transaksi_finishing'] == '11' ? 'checked' : ''; ?>>
                            <label for="finish11">Swipe</label><br>
                        </div>
                        <div class="grid-item">
                            <b>Function</b>
                            <br><br>
                            <input type="radio" id="function1" placeholder="function" name="functionn" value="1" <?= $o['transaksi_function'] == '1' ? 'checked' : ''; ?>>
                            <label for="function1">Print Thermal</label><br>
                            <input type="radio" id="function2" placeholder="function" name="functionn" value="2" <?= $o['transaksi_function'] == '2' ? 'checked' : ''; ?>>
                            <label for="function2">Scan Barcode</label><br>
                            <input type="radio" id="function3" placeholder="function" name="functionn" value="3" <?= $o['transaksi_function'] == '3' ? 'checked' : ''; ?>>
                            <label for="function3">Swipe Magnetic</label><br>
                            <input type="radio" id="function4" placeholder="function" name="functionn" value="4" <?= $o['transaksi_function'] == '4' ? 'checked' : ''; ?>>
                            <label for="function4">Tap RFID</label>
                        </div>
                        <div class="grid-item">
                            <b>Packaging</b>
                            <br><br>
                            <input type="checkbox" id="packaging1" placeholder="packaging" name="packaging" value="1" <?= $o['transaksi_packaging'] == '1' ? 'checked' : ''; ?>>
                            <label for="packaging1">Plastik 1 on 1</label><br>
                            <input type="checkbox" id="packaging2" placeholder="packaging" name="packaging" value="2" <?= $o['transaksi_packaging'] == '2' ? 'checked' : ''; ?>>
                            <label for="packaging2">Plastik Terpisah</label><br>
                            <input type="checkbox" id="packaging3" placeholder="packaging" name="packaging" value="3" <?= $o['transaksi_packaging'] == '3' ? 'checked' : ''; ?>>
                            <label for="packaging3">Box Kartu Nama</label><br>
                            <input type="checkbox" id="packaging4" placeholder="packaging" name="packaging" value="4" <?= $o['transaksi_packaging'] == '4' ? 'checked' : ''; ?>>
                            <label for="packaging4">Box Putih</label><br>
                            <input type="checkbox" id="packaging5" placeholder="packaging" name="packaging" value="5" <?= $o['transaksi_packaging'] == '5' ? 'checked' : ''; ?>>
                            <label for="packaging5">Small UCARD</label><br>
                            <input type="checkbox" id="packaging6" placeholder="packaging" name="packaging" value="6" <?= $o['transaksi_packaging'] == '6' ? 'checked' : ''; ?>>
                            <label for="packaging6">Small Maxi UCARD</label><br>
                            <input type="checkbox" id="packaging7" placeholder="packaging" name="packaging" value="7" <?= $o['transaksi_packaging'] == '7' ? 'checked' : ''; ?>>
                            <label for="packaging7">Large UCARD</label><br>
                            <input type="checkbox" id="packaging8" placeholder="packaging" name="packaging" value="8" <?= $o['transaksi_packaging'] == '8' ? 'checked' : ''; ?>>
                            <label for="packaging8">Large Maxi UCARD</label>
                        </div>
                        <div class="grid-item">
                            <b>Ambil/Kirim</b>
                            <br><br>
                            <input type="radio" id="kirim" placeholder="status" name="status" value="1" <?= $o['transaksi_paket'] == '1' ? 'checked' : ''; ?>>
                            <label for="kirim">Kirim Produk</label><br>
                            <input type="radio" id="ambil" placeholder="status" name="status" value="2" <?= $o['transaksi_paket'] == '2' ? 'checked' : ''; ?>>
                            <label for="ambil">Ambil Sendiri</label>
                        </div>
                    </div>
                    <label>Keterangan</label>
                    <textarea id="keterangan" class="form-control" cols="30" rows="5"><?= $s['transaksi_keterangan']; ?></textarea>

                </div>
                <div class="modal-footer">
                    <button style="width:100%;" id="update-status" class="btn btn-primary">Save</button>
                </div>
    <?php
        }
    }
    function hangus()
    {
        $hangus = $this->db->query("SELECT * FROM tbl_status_transaksi AS st JOIN tbl_status AS s ON st.transaksi_status_id = s.status_id WHERE transaksi_status IS NULL OR transaksi_status = '0' ")->result_array();
        foreach ($hangus as $h) {
            if ((time() > $h['transaksi_tanggal_hangus']) && $h['status_jangka_waktu'] !== NULL) {
                $id_s = $h['transaksi_id'];
                $id = $h['transaksi_order_id'];
                $this->db->query("UPDATE tbl_transaksi SET transaksi_terima = 0 WHERE transaksi_id = '$id' ");
                $this->db->query("UPDATE tbl_status_transaksi SET transaksi_status = 4 WHERE transaksi_id = '$id_s' ");
                // $e = $this->db->query("SELECT * FROM tbl_transaksi JOIN tbl_pelanggan ON tbl_transaksi.transaksi_nohp = tbl_pelanggan.pelanggan_nohp WHERE transaksi_id = '$id' ")->row_array();
                //     $mail = '<html lang="en">
                // <head>
                // </head>
                // <body>
                //     <center>
                //     <img src="https://amarizky.com/assets/img/logo-kartuidcard-blue.png" alt="">
                //     <hr>
                //     <br>

                //     <h1 style="font-weight:bold;">BEMBELIAN GAGAL</h1>
                //     <br>
                //     <table>
                //     <tr>
                //     <td>Product<td>
                //     <td> : <td>
                //     <td>'.$e['product_nama'].'<td>
                //     </tr>
                //     <tr>
                //     <td>Jumlah<td>
                //     <td> : <td>
                //     <td>'.$e['transaksi_jumlah'].'<td>
                //     </tr>
                //     <tr>
                //     <td>Harga<td>
                //     <td> : <td>
                //     <td>Rp. '.number_format($e['transaksi_harga']).'<td>
                //     </tr>
                //     </table
                //     <br>
                //     <a href="'.base_url('Order_pelanggan/detail/'.$id.'/'.$e['pelanggan_password']).'" style="background-color: blue;
                //     border: none;
                //     color: white;
                //     border-radius:10px;
                //     padding: 15px 32px;
                //     text-align: center;
                //     text-decoration: none;
                //     display: inline-block;
                //     font-size: 16px;
                //     margin: 4px 2px;
                //     cursor: pointer;">Lihat Detail</a>
                //     </center>
                // </body>
                // </html>';

                // $config = [
                //     'protocol' => 'smtp',
                //     'smtp_host' => 'ssl://mail.appgarden.xyz',
                //     'smtp_user' => 'hello@appgarden.xyz',
                //     'smtp_pass' => 'Sari1920',
                //     'smtp_port' => 465,
                //     'mailtype' => 'html',
                //     'charset' => 'utf-8',
                //     'crlf' => "\r\n",
                //     'newline' => "\r\n",
                //     'wordwrap' => TRUE
                // ];

                // $this->load->library('email', $config);

                // $this->email->from('hello@appgarden.xyz', 'UCARD INDONESIA');
                // $this->email->to('mhsanugrah@gmail.com');
                // $this->email->subject('Transaksi|Ucard');
                // $this->email->message('halo');

                // $this->email->send();
                echo 'h';
            }
        }
    }

    function update_resi()
    {
        $id = $this->input->post('transaksi_id');
        $resi = $this->input->post('resi');
        $this->db->query("UPDATE tbl_transaksi SET transaksi_resi = '$resi' WHERE transaksi_id = '$id';");
        redirect('Order/detail/' . $id);
    }
    function update_ongkir()
    {
        $id = $this->input->post('transaksi_id');
        $ongkir = $this->input->post('ongkir');
        $this->db->query("UPDATE tbl_transaksi SET transaksi_ongkir = '$ongkir' WHERE transaksi_id = '$id';");
        redirect('Order/detail/' . $id);
    }
}
