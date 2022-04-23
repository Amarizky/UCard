<?php
class M_admin extends CI_Model
{

    function get_admin()
    {
        $h = $this->db->query("SELECT * FROM tbl_admin");
        return $h->result_array();
    }
    function hapus_admin($id)
    {
        $h = $this->db->query("DELETE FROM tbl_admin WHERE admin_id = '$id' ");
        return $h;
    }
    function check_permission($perm)
    {
        return
            @$this
                ->db
                ->select('admin_perm_' . $perm)
                ->where('admin_id', $_SESSION['admin_id'])
                ->get('tbl_admin')
                ->row_array()['admin_perm_' . $perm] == "1" ? true : false;
    }
    function tambahanQueryOrderYangFungsinyaBuatCekPermission()
    {
        $adm = $this->db->select([
            'admin_perm_orderverifikasi verifikasi',
            'admin_perm_orderkirimdesign kirimdesign',
            'admin_perm_orderpembayaran pembayaran',
            'admin_perm_orderapproval approval',
            'admin_perm_orderproduksi cetakproduk',
            'admin_perm_orderkirimambil kirimambil'
        ])
            ->where('admin_id', $this->session->admin_id)
            ->get('tbl_admin')
            ->row_array();

        $allowed = [];
        if ($adm['verifikasi']) $allowed[] = '1';
        if ($adm['kirimdesign']) $allowed[] = '2';
        if ($adm['pembayaran']) $allowed[] = '3';
        if ($adm['approval']) $allowed[] = '4';
        if ($adm['cetakproduk']) $allowed[] = '5';
        if ($adm['kirimambil']) $allowed[] = '6';

        return '(s.transaksi_status_id=' . implode(' OR s.transaksi_status_id=', $allowed) . ")";
    }
}
