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
		$id_product = $this->input->post('id_product');
		$nohp = $this->input->post('nohp');
		$harga = $this->input->post('harga');
		$tot_h = $harga * $jumlah;
		$tanggal = date('Y-m-d');
		$personalisasi = $this->input->post('personalisasi');
		$coating = $this->input->post('coating');
		$finishing = $this->input->post('finishing');
		$function = $this->input->post('function');
		$packaging = $this->input->post('packaging');
		$status = $this->input->post('status');

		// $this->db->query(
		// 	"INSERT INTO tbl_transaksi VALUES (NULL,'$nohp','$id_product','$tanggal',
		// 	'$jumlah','$keterangan','$personalisasi','$coating','$finishing','$function','$packaging','$tot_h',NULL,NULL,NULL,NULL,NULL,1) "
		// );

		$data = array(
			'transaksi_id' 					=> null,
			'transaksi_nohp' 				=> $nohp,
			'transaksi_product_id' 			=> $id_product,
			'transaksi_tanggal' 			=> $tanggal,
			'transaksi_jumlah' 				=> $jumlah,
			'transaksi_keterangan' 			=> $keterangan,
			'transaksi_harga' 				=> $tot_h,
			'transaksi_personalisasi' 		=> $personalisasi,
			'transaksi_coating' 			=> $coating,
			'transaksi_finishing' 			=> $finishing,
			'transaksi_function' 			=> $function,
			'transaksi_packaging' 			=> $packaging,
			'transaksi_bank' 				=> null,
			'transaksi_atas_nama' 			=> null,
			'transaksi_bukti' 				=> null,
			'transaksi_paket' 				=> $status,
			'transaksi_terima' 				=> null,
			'transaksi_new' 				=> 1,
			'transaksi_resi' 				=> null,
			'transaksi_ongkir'				=> 0
		);

		$this->db->insert('tbl_transaksi', $data);

		$id_transaksi = $this->db->insert_id();

		$tanggal_ini = time();
		$s = $this->db->query("SELECT * FROM tbl_status WHERE status_id = '1' ")->row_array();
		$tanggal_hangus = $tanggal_ini + (86400 * $s['status_jangka_waktu']);

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

	function correction()
	{
		$harga = $this->db->query("SELECT * FROM tbl_product WHERE product_id=" . $this->input->post('product_id'))->row_array()['product_harga'];
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

		$this->db->where('transaksi_id', $this->input->post('transaksi_id'));
		$this->db->update('tbl_transaksi', $data);
		redirect(base_url('Order_pelanggan/detail/' . $this->input->post('transaksi_id')));
	}
}
