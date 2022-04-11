<?php

class M_kupon extends CI_Model
{
    function get_kupon($idcode)
    {
        return @$this->db
            ->where('kupon_id', $idcode)
            ->or_where('kupon_kode', $idcode)
            ->get('tbl_kupon')
            ->row_array();
    }
}
