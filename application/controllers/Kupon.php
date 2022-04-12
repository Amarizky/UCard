<?php

class kupon extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_kupon');
    }

    function index()
    {
        if (!isset($this->session->admin_nama)) {
            redirect('Admin');
        }
        if (!$this->M_admin->check_permission('kupon')) redirect('Dashboard');

        $x['title'] = "Kupon";
        $x['kupon'] = $this->db->get('tbl_kupon')->result_array();
        $this->load->view('admin/template/V_header', $x);
        $this->load->view('admin/V_kupon', $x);
        $this->load->view('admin/template/V_footer');
    }

    function tambah_kupon()
    {
        if (!isset($this->session->admin_nama)) {
            redirect('Admin');
        }
        if (!$this->M_admin->check_permission('kupon')) redirect('Dashboard');

        $data = [
            'kupon_nama' => $this->input->post('nama'),
            'kupon_deskripsi' => $this->input->post('deskripsi'),
            'kupon_kode' => $this->input->post('kode'),
            'kupon_min' => $this->input->post('min'),
            'kupon_fixed' => $this->input->post('fixed'),
            'kupon_persentase' => $this->input->post('persentase'),
        ];

        $this->db->insert('tbl_kupon', $data);
        redirect(base_url('Kupon'));
    }

    function edit_kupon()
    {
        if (!isset($this->session->admin_nama)) {
            redirect('Admin');
        }
        if (!$this->M_admin->check_permission('kupon')) redirect('Dashboard');

        $data = [
            'kupon_nama' => $this->input->post('nama'),
            'kupon_deskripsi' => $this->input->post('deskripsi'),
            'kupon_kode' => $this->input->post('kode'),
            'kupon_min' => $this->input->post('min'),
            'kupon_fixed' => $this->input->post('fixed'),
            'kupon_persentase' => $this->input->post('persentase'),
        ];

        $this->db->set($data)->where('kupon_id', $this->input->post('kupon_id'))->update('tbl_kupon');
        redirect(base_url('Kupon'));
    }

    function get_edit()
    {
        if (!isset($this->session->admin_nama)) {
            redirect('Admin');
        }
        if (!$this->M_admin->check_permission('kupon')) redirect('Dashboard');

        $kupon_id = $this->input->post('kupon_id');
        $k = $this->M_kupon->get_kupon($kupon_id);
?>
        <form method="post" action="<?= base_url('Kupon/edit_kupon') ?>">
            <div class="modal-body">
                <input type="hidden" name="kupon_id" value="<?= $kupon_id; ?>">
                <div class="form-group">
                    <label for="nama" class="required">Nama</label>
                    <input class="form-control" type="text" placeholder="Masukkan nama" id="nama" name="nama" value="<?= $k['kupon_nama']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <input class="form-control" type="text" placeholder="Masukkan deskripsi" id="deskripsi" name="deskripsi" value="<?= $k['kupon_deskripsi']; ?>">
                </div>
                <div class="form-group">
                    <label for="kode" class="required">Kode</label>
                    <input class="form-control" type="text" placeholder="Masukkan kode kupon" id="kode" name="kode" value="<?= $k['kupon_kode']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="min" class="required">Minimal Pembelian</label>
                    <input class="form-control" type="number" placeholder="Masukkan minimal pembelian" id="min" name="min" value="<?= $k['kupon_min']; ?>" required>
                </div>
                <hr>
                <b>Isi salah satu</b>
                <div class="form-group">
                    <label for="fixed" class="required">Diskon Rp</label>
                    <input class="form-control" type="number" placeholder="Masukkan diskon (Rupiah)" id="fixed" name="fixed" value="<?= $k['kupon_fixed']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="persentase" class="required">Diskon %</label>
                    <input class="form-control" type="number" placeholder="Masukkan diskon (persentase)" id="persentase" name="persentase" value="<?= $k['kupon_persentase']; ?>" required>
                </div>
                <div id="alert"></div>
            </div>
            <div class="modal-footer">
                <button id="<?= $k['kupon_id']; ?>" type="submit" class="btn btn-primary update">Save</button>
                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
            </div>
        </form>
<?php
    }

    function cek_kupon()
    {
        $transaksi_id = $this->input->post('transaksi_id');
        $kode = strtoupper($this->input->post('kupon'));

        $kupon = $this->M_kupon->get_kupon($kode);
        $t = $this->db->where('transaksi_id', $transaksi_id)->get('tbl_transaksi')->row_array();
        $subtotal = $t['transaksi_harga'];

        if (!$kode || !count($kupon ?? [])) return print_r(json_encode(['alert' => false, 'cont' => false]));
        if ($t['transaksi_harga'] < $kupon['kupon_min']) return print_r(json_encode(['alert' => true, 'cont' => false, 'msg' => 'Subtotal tidak memenuhi syarat minimal']));

        $diskon = $kupon['kupon_fixed'] ? $kupon['kupon_fixed'] : $kupon['kupon_persentase'] / 100 * $subtotal;

        $data = [
            'alert'     => false,
            'cont'      => true,
            'diskon'    => 'Rp' . number_format($diskon ?? 0, 2, ',', '.'),
            'subtotal'  => 'Rp' . number_format($subtotal ?? 0, 2, ',', '.'),
            'total'     => 'Rp' . number_format($subtotal - $diskon + $t['transaksi_ongkir'] ?? 0, 2, ',', '.'),
        ];

        $this->db
            ->set('transaksi_kupon_id', $kupon['kupon_id'])
            ->where('transaksi_id', $transaksi_id)
            ->update('tbl_transaksi');

        print_r(json_encode($data));
    }
}
