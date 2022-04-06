<?php

class Laporan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!isset($this->session->admin_nama)) {
            redirect('Admin');
        }
        if (!$this->M_admin->check_permission('laporan')) redirect('Dashboard');
    }
    function index()
    {
        redirect('Laporan/penjualan');
    }
    function pelanggan()
    {
        if (!$this->M_admin->check_permission('laporanpelanggan')) redirect('Dashboard');
        $data['data'] = $this->db
            ->select('pelanggan_nama, pelanggan_email, pelanggan_nohp, pelanggan_lahir, pelanggan_alamat, pelanggan_kecamatan, pelanggan_kabupaten, pelanggan_kodepost, pelanggan_telephone')
            ->order_by('pelanggan_nama')
            ->get('tbl_pelanggan')
            ->result_array();
        $this->load->view('admin/template/V_header', ['title' => 'Laporan Pelanggan']);
        $this->load->view('admin/V_laporan_pelanggan', $data);
        $this->load->view('admin/template/V_footer');
    }
    function produk()
    {
        if (!$this->M_admin->check_permission('laporanproduk')) redirect('Dashboard');
        $x['data30'] = $this->db
            ->select('p.product_nama, p.product_harga, p.product_kode, SUM(t.transaksi_jumlah) terjual, SUM(t.transaksi_harga) total')
            ->from('tbl_transaksi t')
            ->join('tbl_product p', 't.transaksi_product_id = p.product_id')
            ->where('t.transaksi_tanggal >= NOW() - INTERVAL 30 DAY')
            ->group_by('t.transaksi_product_id')
            ->get()
            ->result_array();
        $x['dataSemua'] = $this->db
            ->select('p.product_nama, p.product_harga, p.product_kode, SUM(t.transaksi_jumlah) terjual, SUM(t.transaksi_harga) total')
            ->from('tbl_transaksi t')
            ->join('tbl_product p', 't.transaksi_product_id = p.product_id')
            ->group_by('t.transaksi_product_id')
            ->get()
            ->result_array();
        $this->load->view('admin/template/V_header', ['title' => 'Laporan Produk']);
        $this->load->view('admin/V_laporan_produk', $x);
        $this->load->view('admin/template/V_footer');
    }
    function penjualan()
    {
        if (!$this->M_admin->check_permission('laporanpenjualan')) redirect('Dashboard');
        $data['data'] = $this->db
            ->select('pe.pelanggan_nama, pr.product_nama, tr.transaksi_atas_nama, tr.transaksi_tanggal, tr.transaksi_jumlah, tr.transaksi_harga')
            ->from('tbl_transaksi tr')
            ->join('tbl_pelanggan pe', 'tr.transaksi_nohp = pe.pelanggan_nohp')
            ->join('tbl_product pr', 'tr.transaksi_product_id = pr.product_id')
            ->get()
            ->result_array();
        $this->load->view('admin/template/V_header', ['title' => 'Laporan Penjualan']);
        $this->load->view('admin/V_laporan_penjualan', $data);
        $this->load->view('admin/template/V_footer');
    }
}
