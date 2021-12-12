<?php
class Laporan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!isset($this->session->admin_nama)) {
            redirect('Admin');
        }
    }

    function index()
    {
    }

    function pelanggan()
    {
        $data['data'] = $this->db
            ->get('tbl_pelanggan')
            ->result_array();
        $this->load->view('admin/laporan/V_pelanggan', $data);
    }
}
