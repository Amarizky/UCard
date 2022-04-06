<?php
class M_category extends CI_Model
{
	function get_category($where_in = '')
	{
		if (empty($where_in))
			return $this->db
				->get('tbl_product_category')
				->result_array();
		else
			return $this->db
				->where_in('category_kode', $where_in)
				->get('tbl_product_category')
				->result_array();
	}
	function kode_to_text($kode_array = '', $separator = null)
	{
		if (empty($kode_array) || is_null($kode_array)) return '';
		if (!is_array($kode_array)) $kode_array = explode(',', $kode_array);
		$getCategory = $this->M_category->get_category($kode_array);

		$category = "";
		foreach ($getCategory as $key => $value) {
			$category .= (!empty($category) ? ($separator ?? ', ') : '') . $value['category_nama'];
		}
		return $category;
	}
	function text_to_kode($text_array = '', $separator = null)
	{
		if (empty($text_array) || is_null($text_array)) return '';
		if (!is_array($text_array)) $text_array = explode($separator ?? ',', $text_array);
		$getText = $this->db
			->where_in('category_nama', $text_array)
			->get('tbl_product_category')
			->result_array();

		$category = "";
		foreach ($getText as $key => $value) {
			$category .= (!empty($category) ? ',' : '') . $value['category_kode'];
		}
		return $category;
	}
	function tambah_category($kode, $nama)
	{
		$h = $this->db->query("INSERT INTO tbl_product_category VALUES (NULL,'$kode','$nama') ");
		return $h;
	}
}
