<?php
class Detail_product_pelanggan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!isset($this->session->pelanggan_nama)) {
			redirect('Admin');
		}
	}

	function index()
	{
		$x['title'] = "Detail Produk";
		$id = $this->input->get('id');
		$nohp = $_SESSION['pelanggan_nohp'];
		$x['pel'] = $this->db->query("SELECT * FROM tbl_pelanggan WHERE pelanggan_nohp = '$nohp' ")->row_array();
		$x['p'] = $this->db->query("SELECT * FROM tbl_product WHERE product_id = '$id' ")->row_array();
		$this->load->view('pelanggan/template/V_header', $x);
		$this->load->view('pelanggan/V_detail_product_pelanggan', $x);
		$this->load->view('pelanggan/template/V_footer');
	}
	function order()
	{
		$jumlah = $this->input->post('jumlah');
		$keterangan = $this->input->post('keterangan');
		$product_id = $this->input->post('product_id');
		$nohp = $this->input->post('nohp');
		$harga = $this->db->select('product_harga')->where('product_id', $product_id)->get('tbl_product')->row_array()['product_harga'];
		$total_harga = $harga * $jumlah;
		$tanggal = time();
		$personalisasi = $this->input->post('personalisasi') ? implode(',', $this->input->post('personalisasi')) : null;
		$finishing = $this->input->post('finishing') ? implode(',', $this->input->post('finishing')) : null;
		$packaging = $this->input->post('packaging') ? implode(',', $this->input->post('packaging')) : null;
		$coating = $this->input->post('coating') ?? null;
		$function = $this->input->post('function') ?? null;
		$status = $this->input->post('status') ?? null;
		$material = $this->input->post('material') ?? null;
		$finish = $this->input->post('finish') ?? null;
		$jp = $this->input->post('jp') ?? null;
		$yoyo = $this->input->post('yoyo') ?? null;
		$warna = $this->input->post('warna') ?? null;
		$casing = $this->input->post('casing') ?? null;
		$ck = $this->input->post('ck') ?? null;
		$lr = $this->input->post('lr') ?? null;
		$pb = $this->input->post('pb') ?? null;

		$data = [
			'transaksi_nohp' 				=> $nohp,
			'transaksi_product_id' 			=> $product_id,
			'transaksi_tanggal' 			=> $tanggal,
			'transaksi_jumlah' 				=> $jumlah,
			'transaksi_keterangan' 			=> $keterangan,
			'transaksi_harga' 				=> $total_harga,
			'transaksi_personalisasi' 		=> $personalisasi,
			'transaksi_coating' 			=> $coating,
			'transaksi_finishing' 			=> $finishing,
			'transaksi_function' 			=> $function,
			'transaksi_packaging' 			=> $packaging,
			'transaksi_material' 			=> $material,
			'transaksi_finish' 				=> $finish,
			'transaksi_jp' 					=> $jp,
			'transaksi_yoyo' 				=> $yoyo,
			'transaksi_warna' 				=> $warna,
			'transaksi_casing' 				=> $casing,
			'transaksi_ck' 					=> $ck,
			'transaksi_logo' 				=> $lr,
			'transaksi_pb' 					=> $pb,
			'transaksi_paket' 				=> $status,
			'transaksi_new' 				=> 1
		];

		$this->db->insert('tbl_transaksi', $data);
		$id_transaksi = $this->db->insert_id();

		$tanggal_ini = time();
		$status_jangka_waktu = $this->db
			->where('status_id', '1')
			->get('tbl_status')
			->row_array()['status_jangka_waktu'];
		$tanggal_hangus = $tanggal_ini + (86400 * $status_jangka_waktu);

		$data = array(
			'transaksi_status_id'			=> 1,
			'transaksi_order_id'			=> $id_transaksi,
			'transaksi_status'				=> 2,
			'transaksi_keterangan'			=> null,
			'transaksi_tanggal'				=> $tanggal_ini,
			'transaksi_tanggal_hangus'		=> $tanggal_hangus
		);

		$this->db->insert('tbl_status_transaksi', $data);

		// $this->db->query("INSERT INTO tbl_status_transaksi VALUES (NULL,1,'$id_transaksi',2,NULL,$tanggal_ini,$tanggal_hangus) ");
		redirect('Order_pelanggan/detail/' . $id_transaksi);
	}
	function checkStatus()
	{
		$id = $_POST['id'];
		$status = $_POST['status'];
		$produksi = $_POST['produksi'];
		$statusRefresh = $this->db->query("SELECT max(transaksi_status_id) st, max(transaksi_produksi_status_id) pd FROM tbl_status_transaksi WHERE transaksi_order_id=" . $id)->row_array();

		if ($statusRefresh['st'] !== $status || $statusRefresh['pd'] !== $produksi) {
			echo 'refresh';
		}
	}

	function perbaikan()
	{
		$product_id = $this->input->post('product_id');
		$transaksi_id = $this->input->post('transaksi_id');

		$harga = $this->db
			->where('product_id', $product_id)
			->get('tbl_product')
			->row_array()['product_harga'];

		$data = array(
			'transaksi_jumlah' 				=> $this->input->post('jumlah'),
			'transaksi_keterangan' 			=> $this->input->post('keterangan'),
			'transaksi_harga' 				=> $this->input->post('jumlah') * $harga,
			'transaksi_personalisasi' 		=> $this->input->post('personalisasi'),
			'transaksi_coating' 			=> $this->input->post('coating'),
			'transaksi_finishing' 			=> $this->input->post('finishing'),
			'transaksi_function' 			=> $this->input->post('function'),
			'transaksi_packaging' 			=> $this->input->post('packaging'),
			'transaksi_paket' 				=> $this->input->post('status')
		);

		$this->db->where('transaksi_id', $transaksi_id);
		$this->db->update('tbl_transaksi', $data);
		redirect(base_url('Order_pelanggan/detail/' . $transaksi_id));
	}
}
