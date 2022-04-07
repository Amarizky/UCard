<input type="hidden" value="<?= $this->uri->segment(3) ?>" id="id">
<link rel="stylesheet" href="<?= base_url('assets/admin/vendor/select2/dist/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/admin/vendor/quill/dist/quill.core.css') ?>">

<style>
    .wrapper {
        display: inline-flex;
        height: 100px;
        width: 100%;
        align-items: center;
        justify-content: space-evenly;
        border-radius: 5px;
        padding: 20px 0px;
    }

    .grid-container {
        display: inline-grid;
        grid-template-columns: auto auto;
        background-color: #FFFFFF;
        width: 100%;
    }

    .grid-item {
        width: 100%;
        background-color: #FFFFFF;
        border: 0px solid rgba(202, 0, 0, 0.8);
        padding: 20px;
        font-size: 15px;
    }

    .item1 {
        width: 100%;
        grid-column: 2;
    }

    .lcfont {
        font-family: "Lucida Console";
    }

    .wrapper .option {
        background: #fff;
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        margin: 0 10px;
        border-radius: 5px;
        cursor: pointer;
        padding: 0 10px;
        border: 2px solid lightgrey;
        transition: all 0.3s ease;
    }

    .wrapper .option .dot {
        height: 20px;
        width: 20px;
        background: #d9d9d9;
        border-radius: 50%;
        position: relative;
    }

    .wrapper .option .dot::before {
        position: absolute;
        content: "";
        top: 4px;
        left: 4px;
        width: 12px;
        height: 12px;
        background: #0069d9;
        border-radius: 50%;
        opacity: 0;
        transform: scale(1.5);
        transition: all 0.3s ease;
    }

    .page[size="A6"] {
        background: white;
        font: "Lucida Console";
        width: 10.5cm;
        height: 14.8cm;
        display: block;
        margin: 0 auto;
        box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    @media screen {
        #printSection {
            display: none;
        }
    }

    @media print {
        body * {
            visibility: hidden;
        }

        #printSection,
        #printSection * {
            visibility: visible;
        }

        #printSection {
            position: absolute;
            left: 0;
            top: 0;
        }
    }

    .p {
        display: none;
    }

    #option-1:checked:checked~.option-1,
    #option-2:checked:checked~.option-2 {
        border-color: #0069d9;
        background: #0069d9;
    }

    #option-1:checked:checked~.option-1 .dot,
    #option-2:checked:checked~.option-2 .dot {
        background: #fff;
    }

    #option-1:checked:checked~.option-1 .dot::before,
    #option-2:checked:checked~.option-2 .dot::before {
        opacity: 1;
        transform: scale(1);
    }

    .wrapper .option span {
        font-size: 20px;
        color: #808080;
    }

    #option-1:checked:checked~.option-1 span,
    #option-2:checked:checked~.option-2 span {
        color: #fff;
    }
</style>
<!-- Header -->

<!-- Page content -->
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h3 class="mb-0">Timeline</h3>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-one-side" data-timeline-content="axis" data-timeline-axis-style="dashed">
                        <?php
                        $id_transaksi = $this->uri->segment(3);
                        $ctk = $this->db->query("SELECT * FROM tbl_status_transaksi WHERE transaksi_status_id = '5' AND transaksi_order_id = '$id_transaksi' ORDER BY transaksi_id DESC ")->row_array();
                        $statusproduksi = @$ctk['transaksi_produksi_status_id'];

                        foreach ($status as $s) : ?>
                            <?php
                            $id_status = $s['status_urut'];
                            $st = $this->db->query("SELECT * FROM tbl_status_transaksi WHERE transaksi_order_id = '$id_transaksi' AND transaksi_status_id = '$id_status' ORDER BY transaksi_id DESC ")->row_array();
                            $verif = $this->db->query("SELECT * FROM tbl_verifikasi WHERE transaksi_id = '$id_transaksi';")->row_array();
                            ?>
                            <?php if (!empty($st) && ($st['transaksi_status'] == NULL || $st['transaksi_status'] == '2')) : ?>
                                <div class="timeline-block">
                                    <span style="background-color: blue;color: white;" class="timeline-step badge-success">
                                        <i class="<?= $s['status_icon'] ?>"></i>
                                    </span>
                                    <div class="timeline-content">
                                        <a type="button" class="tablinks" onclick="status(event, 'status<?= $s['status_urut'] ?>')" id="defaultOpen"><b class="font-weight-bold"><?= $s['status_status'] ?></b></a>
                                        <?php $max = $this->db->query("SELECT MAX(status_id) AS akhir FROM tbl_status WHERE status_id LIKE '_';")->row_array(); ?>
                                        <?php if ($s['status_urut'] != $max['akhir'] && $st['transaksi_deleted'] == 0 && $st['transaksi_status'] != '4') : ?>
                                            <button id-status="<?= $s['status_urut'] == '5' ? $statusproduksi : $s['status_id'] ?>" class="btn btn-primary btn-sm status" data-toggle="modal" data-target="#status_update"><i class="fa fa-pen"></i></button>
                                        <?php endif; ?>
                                        <p class=" text-sm mt-1 mb-0"><?= $s['status_keterangan'] ?></p>
                                        <?php if ($s['status_jangka_waktu'] != NULL) : ?>
                                            <?php if ($st['transaksi_status'] == '4') : ?>
                                                <b>Sudah lewat tanggal</b>
                                            <?php else : ?>
                                                <strong>Batas kirim: </strong>
                                                <b><?= date('d/m/Y H:m', $st['transaksi_tanggal_hangus']) ?></b>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <div class="mt-3">
                                            <?php if ($st['transaksi_status'] == '2') : ?>
                                                <span class="badge badge-pill badge-info">Menunggu Konfirmasi</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif (!empty($st) && $st['transaksi_status'] == '1') : ?>
                                <div class="timeline-block">
                                    <span style="background-color: green;color: white;" class="timeline-step badge-success">
                                        <i class="<?= $s['status_icon'] ?>"></i>
                                    </span>
                                    <div class="timeline-content">
                                        <?php
                                        $max = $this->db->query("SELECT MAX(status_id) AS akhir FROM tbl_status")->row_array();
                                        if ($s['status_urut'] == $max['akhir']) :
                                        ?>
                                            <a type="button" class="tablinks" onclick="status(event, 'status<?= $s['status_urut'] ?>')" id="defaultOpen"><b class="font-weight-bold"><?= $s['status_status'] . (!empty($verif['verif_kirimambil']) ? " ($verif[verif_kirimambil])" : "") ?> </b></a>
                                        <?php else : ?>
                                            <?php
                                            $verifikator = "";
                                            switch ($s['status_urut']) {
                                                case "1":
                                                    $verifikator = $verif['verif_pesanan'];
                                                    break;
                                                case "2":
                                                    $verifikator = $verif['verif_desain'];
                                                    break;
                                                case "3":
                                                    $verifikator = $verif['verif_pembayaran'];
                                                    break;
                                                case "4":
                                                    $verifikator = $verif['verif_approval'];
                                                    break;
                                                case "5":
                                                    $verifikator = $verif['verif_cetak'];
                                                    break;
                                            }
                                            ?>
                                            <a type="button" class="tablinks" onclick="status(event, 'status<?= $s['status_urut'] ?>')"><b class="font-weight-bold"><?= $s['status_status'] . (!empty($verifikator) ? " ($verifikator)" : "") ?></b></a>
                                        <?php endif; ?>
                                        <p class=" text-sm mt-1 mb-0"><?= $s['status_keterangan'] ?></p>
                                        <div class="mt-3">
                                            <span class="badge badge-pill badge-success">Diterima</span>
                                            <br>
                                            <br>
                                            <?php switch ($s['status_urut']) {
                                                case "1":
                                            ?>
                                                    <button id-status="<?= $s['status_urut'] == '' ? $statusproduksi : $s['status_id'] ?>" class="btn btn-primary btn-sm status" data-toggle="modal" data-target="#status_print1"><i class="fa fa-print"> SPK Sales</i></button>
                                                <?php
                                                    break;
                                                case "4":
                                                ?>
                                                    <button id-status="<?= $s['status_urut'] == '' ? $statusproduksi : $s['status_id'] ?>" class="btn btn-primary btn-sm status" data-toggle="modal" data-target="#status_print4"><i class="fa fa-print"></i> SPK Approval</button>
                                                    <button id-status="<?= $s['status_urut'] == '' ? $statusproduksi : $s['status_id'] ?>" class="btn btn-primary btn-sm status" data-toggle="modal" data-target="#status_print5"><i class="fa fa-print"></i> SPK Produksi</button>
                                            <?php
                                                    break;
                                            }
                                            ?>
                                            <p class="text-sm mt-2">
                                                <?= $st['transaksi_keterangan'] ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif (!empty($st) && ($st['transaksi_status'] == '0' || $st['transaksi_status'] == '4')) : ?>
                                <div class="timeline-block">
                                    <span style="background-color: red;color: white;" class="timeline-step badge-success">
                                        <i class="<?= $s['status_icon'] ?>"></i>
                                    </span>
                                    <div class="timeline-content">
                                        <a type="button" class="tablinks" onclick="status(event, 'status<?= $s['status_urut'] ?>')" id="defaultOpen"><b class="font-weight-bold"><?= $s['status_status'] ?></b></a>
                                        <?php if ($st['transaksi_deleted'] == 0) : ?>
                                            <button id-status="<?= $s['status_id'] ?>" class="btn btn-primary btn-sm status" data-toggle="modal" data-target="#status_update"><i class="fa fa-pen"></i></button>
                                        <?php endif; ?>
                                        <p class=" text-sm mt-1 mb-0"><?= $s['status_keterangan'] ?></p>
                                        <div class="mt-3">
                                            <?php if ($s['status_jangka_waktu'] != NULL) : ?>
                                                <?php if ($st['transaksi_status'] == '4') : ?>
                                                    <b>Sudah lewat tanggal</b>
                                                <?php else : ?>
                                                    <strong>Batas kirim</strong>
                                                    <b><?= date('d/m/Y H:m', $st['transaksi_tanggal_hangus']) ?></b>
                                                <?php endif; ?>
                                            <?php endif; ?><br>
                                            <span class="badge badge-pill badge-danger">Ditolak</span>
                                            <p class="text-sm mt-2">
                                                <?= $st['transaksi_keterangan'] ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="timeline-block">
                                    <span style="background-color: grey;color: white;" class="timeline-step badge-success">
                                        <i class="<?= $s['status_icon'] ?>"></i>
                                    </span>
                                    <div class="timeline-content">
                                        <b class="font-weight-bold"><?= $s['status_status'] ?></b>
                                        <p class=" text-sm mt-1 mb-0"><?= $s['status_keterangan'] ?></p>
                                        <div class="mt-3">
                                            <!-- <span class="badge badge-pill badge-success">Pesanan anda diverifikasi</span> -->
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div id="status1" class="tabcontent">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0">Pembelian</h3>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid" style="padding: 0 !important;">
                            <h1>Produk</h1>
                            <b>Nama Produk</b>
                            <p><?= $p['product_nama'] ?></p>
                            <b>Harga per item</b>
                            <p><?= 'Rp' . number_format($p['product_harga'], 2, ',', '.'); ?></p>
                            <b>Jumlah dipesan</b>
                            <p><?= $o['transaksi_jumlah'] ?></p>
                            <b>Total harga</b>
                            <p><?= 'Rp' . number_format($o['transaksi_harga'], 2, ',', '.'); ?></p>
                            <b>Keterangan</b>
                            <p><?= $o['transaksi_keterangan'] ?></p>
                            <div class="grid-container">
                                <div class="grid-item">
                                    <?php $namaMaterial = ['Tidak diketahui', 'Polyester 1,5CM', 'Polyester 2CM', 'Polyester 2,5CM', 'Tissue 1,5CM', 'Tissue 2CM', 'Tissue 2,5CM']; ?>
                                    <b>Material</b>
                                    <p>&nbsp;<?= $namaMaterial[$o['transaksi_material'] ?? 0]; ?></p>
                                </div>
                                <div class="grid-item">
                                    <?php
                                    $namaFinishing = ['Tidak diketahui', 'Kait Oval', 'Kait HP', 'Kait Standar', 'Tambah Warna Sablon', 'Double Stopper', 'Stopper Tas'];
                                    $finishing = explode(',', $o['transaksi_finish'] ?? 0);
                                    $statusFinishing = "";
                                    foreach ($finishing as $p) {
                                        $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$p];
                                    }
                                    ?>
                                    <b>Finishing</b>
                                    <p>&nbsp;<?= $statusFinishing; ?></p>
                                </div>
                                <div class="grid-item">
                                    <?php $jenisProduksi = ['Tidak diketahui', 'Sablon', 'Printing']; ?>
                                    <b>Jenis Produksi</b>
                                    <p>&nbsp;<?= $jenisProduksi[$o['transaksi_jp'] ?? 0]; ?></p>
                                </div>
                                <div class="grid-item">
                                    <?php $namaPaket = ['Tidak diketahui', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                    <b>Ambil/Kirim</b>
                                    <p><?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></p>
                                </div>
                            </div>
                            <h1>Customer</h1>
                            <b>Nama</b>
                            <p><?= $o['pelanggan_nama'] ?></p>
                            <b>Whatsapp</b>
                            <p><?= $o['pelanggan_nohp'] ?></p>
                            <b>Email</b>
                            <p><?= $o['pelanggan_email'] ?></p>
                            <b>Alamat</b>
                            <p><?= $o['pelanggan_alamat'] ?></p>
                            <b>No Telephone</b>
                            <p><?= $o['pelanggan_telephone'] ?></p>
                            <b>Kecamatan</b>
                            <p><?= $o['pelanggan_kecamatan'] ?></p>
                            <b>Kabupaten</b>
                            <p><?= $o['pelanggan_kabupaten'] ?></p>
                            <b>Kode Pos</b>
                            <p><?= $o['pelanggan_kodepost'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="status2" class="tabcontent">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0">Design</h3>
                    </div>
                    <div class="card-body">
                        <p>File dan/atau URL akan muncul jika pelanggan sudah mengunggahnya</p>
                        <hr>
                        <?php
                        $id = $this->uri->segment(3);
                        $design = $this->db->query("SELECT * FROM tbl_user_design WHERE design_transaksi_id = '$id' ")->result_array();
                        $upload = $this->db->query("SELECT * FROM tbl_design_kirim WHERE design_transaksi_id = '$id' ")->result_array();
                        $link = $this->db->query("SELECT transaksi_link_desain FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                        if (!$design && !$upload && (empty($link['transaksi_link_desain'] || !$link))) {
                            echo '<h3>Pelanggan belum mengirim gambar desain ataupun link</h3>';
                        }
                        if ($design) : ?>
                            <h3>Design Anda</h3>
                            <br>
                            <?php foreach ($design as $d) : ?>
                                <a title="<?= $d['design_id'] ?>" id="modal_lihat" type="button" class="modal_lihat" data-toggle="modal" data-target="#lihat">
                                    <img style="width:100%;" src="<?= base_url('design_user/' . $d['design_image']) ?>" alt="">
                                </a>
                                <hr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if ($upload) : ?>
                            <h3>Uploaded File & Design</h3>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-flush" id="datatable-basic">
                                    <thead>
                                        <tr>
                                            <td colspan="4" class="text-center">Pelanggan belum mengirimkan file desain</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($upload as $u) : ?>
                                            <tr>
                                                <td><?php echo  $u['design_image']; ?></td>
                                                <td><a href="<?= base_url('design_user/' . $u['design_image']) ?>" download>Download</a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                        <hr>
                        <h3>URL File</h3>
                        <div class="col p-0">
                            <?php if (!empty($link['transaksi_link_desain']) && !is_null($link['transaksi_link_desain'])) : ?>
                                <input type="text" class="form-control" name="link" value="<?= $link['transaksi_link_desain']; ?>">
                            <?php else : ?>
                                <input type="text" class="form-control" name="link" value="Pelanggan belum mengirimkan link file" readonly>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="status3" class="tabcontent">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0">Pembayaran</h3>
                    </div>
                    <div class="card-body">
                        <p>Silahkan ubah harga dan/atau ongkir jika diperlukan. Bukti transfer akan muncul setelah pelanggan mengunggah file bukti transfer.</p>
                        <hr>
                        <b>Metode pengiriman yang dipilih pelanggan</b>
                        <p><?= $o['transaksi_paket'] == '1' ? 'Kirim Paket' : 'Ambil Sendiri'; ?></p>
                        <hr>
                        <?php $total = $o['transaksi_paket'] == '1' ? $o['transaksi_harga'] + $o['transaksi_ongkir'] : $o['transaksi_harga']; ?>
                        <b>Harga</b>
                        <p>Rp<?= number_format($o['transaksi_harga'], 2, ',', '.'); ?></p>
                        <?php if ($o['transaksi_paket'] == '1') : ?>
                            <b>Ongkir</b>
                            <p>Rp<?= number_format($o['transaksi_ongkir'], 2, ',', '.') ?></p>
                        <?php endif ?>
                        <b>Total perlu dibayar (Lunas)</b>
                        <p>Rp<?= number_format($total, 2, ',', '.') ?></p>
                        <b>Total perlu dibayar jika DP/uang muka</b>
                        <p>Rp<?= number_format($total * 0.5, 2, ',', '.') ?></p>
                        <hr>
                        <b>Bukti Transfer</b>
                        <?php if (!empty($o['transaksi_bukti'])) : ?>
                            <?php $bank = $this->db->where('bank_id', $o['transaksi_bank'])->get('tbl_bank')->row_array()['bank_nama']; ?>
                            <br>
                            <b>Atas Nama</b>
                            <p><?= $o['transaksi_atas_nama']; ?></p>
                            <b>Bank</b>
                            <p><?= $bank; ?></p>
                            <a type="button" class="modal_lihat w-100" data-toggle="modal" data-target="#bukti">
                                <img style="width: 100%;" src="<?= base_url('bukti_transaksi/' . $o['transaksi_bukti']) ?>">
                            </a>
                        <?php else : ?>
                            <h2>Belum ada bukti transfer</h2>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div id="status4" class="tabcontent">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0">Approval</h3>
                    </div>
                    <div class="card-body">
                        <div>Silahkan unggah ketiga file agar dapat dipilih oleh pelanggan.</div>
                        <br>
                        <div>
                            <b>
                                <?php
                                switch ($o['transaksi_approval_acc']) {
                                    case 1:
                                        echo "Pelanggan memilih Original";
                                        break;
                                    case 2:
                                        echo "Pelanggan memilih Gelap";
                                        break;
                                    case 3:
                                        echo "Pelanggan memilih Terang";
                                        break;
                                    case 4:
                                        echo "Pelanggan Meminta Revisi";
                                        break;
                                    default:
                                        echo "Pelanggan belum menentukan pilihan";
                                        break;
                                }
                                ?>
                            </b>
                        </div>
                        <br>
                        <form method="post" action="<?= base_url('Order/upload_approval1') ?>" enctype="multipart/form-data">
                            <input type="hidden" name="transaksi_id" value="<?= $this->uri->segment(3) ?>">
                            <label for="apv1"><?= $o['transaksi_approval_acc'] == 1 ? "<b>Original (dipilih)</b>" : "Original"; ?></label><br>
                            <?php if ($o['transaksi_approval_1']) : ?>
                                <a type="button" class="modal_lihat" data-toggle="modal" data-target="#approval1">
                                    <img style="width: 100%;" src="<?= base_url('design_approval/' . $o['transaksi_approval_1']) ?>">
                                </a>
                                <br>
                            <?php endif; ?>
                            <input type="file" id="apv1" name="approval1" class="form-control" onchange="this.form.submit()" required><br>
                            <button type="submit" style="width: 100%;" class="btn btn-primary">Tetapkan sebagai varian original</button>
                        </form>
                        <br>
                        <form method="post" action="<?= base_url('Order/upload_approval2') ?>" enctype="multipart/form-data">
                            <input type="hidden" name="transaksi_id" value="<?= $this->uri->segment(3) ?>">
                            <label for="apv2"><?= $o['transaksi_approval_acc'] == 2 ? "<b>Gelap (dipilih)</b>" : "Gelap"; ?></label><br>
                            <?php if ($o['transaksi_approval_2']) : ?>
                                <a type="button" class="modal_lihat" data-toggle="modal" data-target="#approval2">
                                    <img style="width: 100%;" src="<?= base_url('design_approval/' . $o['transaksi_approval_2']) ?>">
                                </a>
                                <br>
                            <?php endif; ?>
                            <input type="file" id="apv2" name="approval2" class="form-control" onchange="this.form.submit()" required><br>
                            <button type="submit" style="width: 100%;" class="btn btn-primary">Tetapkan sebagai varian gelap</button>
                        </form>
                        <br>
                        <form method="post" action="<?= base_url('Order/upload_approval3') ?>" enctype="multipart/form-data">
                            <input type="hidden" name="transaksi_id" value="<?= $this->uri->segment(3) ?>">
                            <label for="apv3"><?= $o['transaksi_approval_acc'] == 3 ? "<b>Terang (dipilih)</b>" : "Terang"; ?></label><br>
                            <?php if ($o['transaksi_approval_3']) : ?>
                                <a type="button" class="modal_lihat" data-toggle="modal" data-target="#approval3">
                                    <img style="width: 100%;" src="<?= base_url('design_approval/' . $o['transaksi_approval_3']) ?>">
                                </a>
                                <br>
                            <?php endif; ?>
                            <input type="file" id="apv3" name="approval3" class="form-control" onchange="this.form.submit()" required><br>
                            <button type="submit" style="width: 100%;" class="btn btn-primary">Tetapkan sebagai varian terang</button>
                        </form>
                    </div>
                </div>
            </div>
            <div id="status5" class="tabcontent">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0">Cetak Produk</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if (@$ctk['transaksi_status'] == '1') :
                        ?>
                            <div style="display: flex;justify-content: center;">
                                <img style="width:50%;margin: auto;" src="<?= base_url('assets/img/gifcheck.gif') ?>" alt="">
                            </div>
                            <br>
                            <br>
                            <h2>Produk sudah selesai dicetak!</h2>
                        <?php else : ?>
                            <img style="width:100%;" src="<?= base_url('assets/img/print.gif') ?>" alt="">
                            <br>
                            <br>
                            <h2>Sedang membuat produk</h2>
                            <br>
                            <div class="timeline timeline-one-side" data-timeline-content="axis" data-timeline-axis-style="dashed">
                                <?php
                                $produksi = $this->db->query("SELECT * FROM tbl_status WHERE status_id LIKE '5_';")->result_array();
                                $produksicount = 51;
                                ?>
                                <?php foreach ($produksi as $p) : ?>
                                    <div class="timeline-block mt-1 mb-0">
                                        <span style="background-color: <?= ($statusproduksi == $produksicount) ? "blue" : ($statusproduksi > $produksicount ? "green" : "grey"); ?>;color: white;" class="timeline-step badge-success">
                                            <i class="fa fa-image"></i>
                                        </span>
                                        <div class="timeline-content">
                                            <p class="my-0"><b class="font-weight-bold"><?= $p['status_status']; ?></b></p>
                                            <p class=" text-sm mt-1 mb-0"><?= $p['status_keterangan']; ?></p>
                                            <!-- <div class="mt-3">
                                                    <span class="badge badge-pill badge-success">Diterima</span>
                                                    <p class="text-sm mt-2">
                                                    </p>
                                                </div> -->
                                        </div>
                                    </div>
                                    <?php $produksicount++ ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div id="status6" class="tabcontent">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0">Konfirmasi Pesanan</h3>
                    </div>
                    <div id="terima_p" class="card-body">
                        <?php if ($o['transaksi_terima'] == NULL) : ?>
                            <div class="wrapper">
                                <input class="p" type="radio" value="1" name="paket" id="option-1" <?= $o['transaksi_paket'] == '1' ? 'checked' : ''; ?>>
                                <input class="p" type="radio" value="2" name="paket" id="option-2" <?= $o['transaksi_paket'] == '2' ? 'checked' : ''; ?>>
                                <label for="option-1" class="option option-1">
                                    <div class="dot"></div>
                                    <span>Kirim Produk</span>
                                </label>
                                <label for="option-2" class="option option-2">
                                    <div class="dot"></div>
                                    <span>Ambil Sendiri</span>
                                </label>
                            </div>
                            <br>
                            <br>
                            <div id="paket_terima">
                                <!-- <button style="width:100%;display:none;" class="btn btn-primary terima">Paket sudah diterima ?</button> -->
                                <?php if ($o['transaksi_paket'] != NULL) : ?>
                                    <table>
                                        <tr>
                                            <td>Alamat</td>
                                            <td> : </td>
                                            <td><?= $o['pelanggan_alamat'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kecamatan</td>
                                            <td> : </td>
                                            <td><?= $o['pelanggan_kecamatan'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kabupaten</td>
                                            <td> : </td>
                                            <td><?= $o['pelanggan_kabupaten'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kode Pos</td>
                                            <td> : </td>
                                            <td><?= $o['pelanggan_kodepost'] ?></td>
                                        </tr>
                                    </table>
                                    <br>
                                    <?php
                                    $resi = $this->db->query("SELECT transaksi_resi FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    ?>
                                    <?php if ($o['transaksi_paket'] == '1') : ?>
                                        <h3>Nomor Resi</h3>
                                        <form action="<?= base_url('Order/update_resi'); ?>" method="post" class="form-group row">
                                            <input type="hidden" name="transaksi_id" value="<?= $id; ?>">
                                            <div class="col-sm-8 pr-1">
                                                <input type="text" class="form-control" name="resi" placeholder="Masukkan nomor resi" value="<?= $resi['transaksi_resi']; ?>">
                                            </div>
                                            <div class="col-sm-4 pl-1">
                                                <button type="submit" class="btn btn-primary mb-2 w-100" id="updateResi">Update</button>
                                            </div>
                                        </form>
                                    <?php endif; ?>
                                    <br>
                                    <button style="width:100%;" class="btn btn-primary terima">Paket sudah diterima ?</button>
                                <?php
                                endif;
                                ?>
                            </div>
                        <?php else : ?>
                            <div class="wrapper">
                                <?php if ($o['transaksi_paket'] == "1") { ?>
                                    <h2>Kirim Paket</h2>
                                <?php } else { ?>
                                    <h2>Ambil Sendiri</h2>
                                <?php } ?>
                                <h2>Paket sudah diterima</h2>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="lihat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail Design</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert_design"></div>
                <div id="data_design"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
$id = $this->uri->segment(3);
$y = $this->db->query("SELECT * FROM tbl_product AS p JOIN tbl_transaksi AS t ON p.product_id = t.transaksi_product_id WHERE transaksi_id = '$id' ")->row_array();
?>

<div class="modal fade" id="status_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Ubah Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="alert_status"></div>
            <div id="data_status"></div>
        </div>
    </div>
</div>
<div>
    <div class="modal fade" id="status_print1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Print SPK Sales</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <page size="A6">
                    <div id="printThis">
                        <div class="modal-body">
                            <div class="lcfont">
                                <button style="float: right;" class="btn btn-primary btn-sm status" data-toggle="modal" data-target="#status_printedit1"><i class="fa fa-edit"></i></button><br>
                                <p style="text-align: left;"><strong> </strong><span style="text-decoration: underline;"><strong>SPK
                                            Sales</strong></span></p>
                                <p style="text-align: left;">Nama&nbsp; &nbsp; : <?= $o['pelanggan_nama'] ?><br />Tanggal :&nbsp;<?= $o['transaksi_tanggal'] ?></p>
                                <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                    <tbody>
                                        <tr style="height: 18px;">
                                            <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Kode Produk</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_product_id'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Jenis Tali</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_nama'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Quantity</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_jumlah'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px; text-align: center;" colspan="2"><strong>Keterangan</strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $namaMaterial = ['Tidak diketahui', 'Polyester 1,5CM', 'Polyester 2CM', 'Polyester 2,5CM', 'Tissue 1,5CM', 'Tissue 2CM', 'Tissue 2,5CM']; ?>
                                            <td style="width: 50%; height: 18px;">Material</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $namaMaterial[$o['transaksi_material'] ?? 0]; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php
                                            $namaFinishing = ['Tidak diketahui', 'Kait Oval', 'Kait HP', 'Kait Standar', 'Tambah Warna Sablon', 'Double Stopper', 'Stopper Tas'];
                                            $finishing = explode(',', $o['transaksi_finish'] ?? 0);
                                            $statusFinishing = "";
                                            foreach ($finishing as $p) {
                                                $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$p];
                                            }
                                            ?>
                                            <td style="width: 50%; height: 18px;">Finishing</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $jenisProduksi = ['Tidak diketahui', 'Sablon', 'Printing']; ?>
                                            <td style="width: 50%; height: 18px;">Jenis Produksi</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $jenisProduksi[$o['transaksi_jp'] ?? 0]; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $namaPaket = ['Tidak diketahui', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                            <td style="width: 50%; height: 18px;">Status</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p style="text-align: left;"><br> Assesoris : <?= $o['transaksi_spkkartu_assesoris'] ?></p>
                                <p style="text-align: left;">&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </page>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="printSpk">Print</button>
                </div>
                <div id="alert_status"></div>
                <div id="data_status"></div>
            </div>
        </div>
    </div>
    <?php $assesoris = $this->db->query("SELECT transaksi_spkkartu_assesoris FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array(); ?>
    <div class="modal fade" id="status_printedit1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit SPK Sales</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <page size="A6">
                    <div id="printThis">
                        <div class="modal-body">
                            <div class="lcfont">
                                <p style="text-align: left;"><strong> </strong><span style="text-decoration: underline;"><strong>SPK
                                            Sales</strong></span></p>
                                <p style="text-align: left;">Nama&nbsp; &nbsp; : <?= $o['pelanggan_nama'] ?><br />Tanggal :&nbsp;<?= $o['transaksi_tanggal'] ?></p>
                                <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                    <tbody>
                                        <tr style="height: 18px;">
                                            <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Kode Produk</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_product_id'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Jenis Tali</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_nama'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Quantity</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_jumlah'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px; text-align: center;" colspan="2"><strong>Keterangan</strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $namaMaterial = ['Tidak diketahui', 'Polyester 1,5CM', 'Polyester 2CM', 'Polyester 2,5CM', 'Tissue 1,5CM', 'Tissue 2CM', 'Tissue 2,5CM']; ?>
                                            <td style="width: 50%; height: 18px;">Material</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $namaMaterial[$o['transaksi_material'] ?? 0]; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php
                                            $namaFinishing = ['Tidak diketahui', 'Kait Oval', 'Kait HP', 'Kait Standar', 'Tambah Warna Sablon', 'Double Stopper', 'Stopper Tas'];
                                            $finishing = explode(',', $o['transaksi_finish'] ?? 0);
                                            $statusFinishing = "";
                                            foreach ($finishing as $p) {
                                                $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$p];
                                            }
                                            ?>
                                            <td style="width: 50%; height: 18px;">Finishing</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $jenisProduksi = ['Tidak diketahui', 'Sablon', 'Printing']; ?>
                                            <td style="width: 50%; height: 18px;">Jenis Produksi</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $jenisProduksi[$o['transaksi_jp'] ?? 0]; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $namaPaket = ['Tidak diketahui', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                            <td style="width: 50%; height: 18px;">Status</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p style="text-align: left;"><br> Assesoris : <input type="text" name="assesoris" id="assesoris" placeholder="Masukkan Keterangan Assesoris" value="<?= $assesoris['transaksi_spkkartu_assesoris']; ?>"></p>
                                <p style="text-align: left;">&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </page>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="savespksales">Save</button>
                </div>
                <div id="alert_status"></div>
                <div id="data_status"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="status_print4" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Print SPK Approval</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <page size="A6">
                    <div id="printThis3">
                        <div class="modal-body">
                            <div class="lcfont">
                                <button style="float: right;" class="btn btn-primary btn-sm status" data-toggle="modal" data-target="#status_printedit2"><i class="fa fa-edit"></i></button><br>
                                <p style="text-align: left;"><strong> </strong><span style="text-decoration: underline;"><strong>SPK Approval</strong></span></p>
                                <p style="text-align: left;">Nama&nbsp; &nbsp; : <?= $o['pelanggan_nama'] ?><br />Quantity: <?= $o['transaksi_jumlah'] ?><br />Tanggal : <?= $o['transaksi_tanggal'] ?>
                                    <br />Jumlah Tali Awal/Akhir &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;: <?= $o['transaksi_spk_jumlahtaliawal'] ?> / <?= $o['transaksi_spk_jumlahtaliakhir'] ?>
                                    <br />Jumlah Tali Stopper Awal/Akhir : <?= $o['transaksi_spk_jumlahtalistopperawal'] ?> / <?= $o['transaksi_spk_jumlahtalistopperakhir'] ?>
                                    <br />Jumlah Klem Awal/Akhir &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_jumlahklemawal'] ?> / <?= $o['transaksi_spk_jumlahklemakhir'] ?>
                                    <br />Jumlah Kait Awal/Akhir &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: <?= $o['transaksi_spk_jumlahkaitawal'] ?> / <?= $o['transaksi_spk_jumlahkaitakhir'] ?>
                                    <br />Jumlah Stopper Awal/Akhir &nbsp; &nbsp;&nbsp; : <?= $o['transaksi_spk_jumlahstopperawal'] ?> / <?= $o['transaksi_spk_jumlahstopperakhir'] ?>
                                    <br />Operator &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_operator'] ?>
                                </p>
                                <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                    <tbody>
                                        <tr style="height: 18px;">
                                            <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Kode Produk</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_product_id'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Jenis Tali</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_nama'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Quantity</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_jumlah'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px; text-align: center;" colspan="2"><strong>Keterangan</strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $namaMaterial = ['Tidak diketahui', 'Polyester 1,5CM', 'Polyester 2CM', 'Polyester 2,5CM', 'Tissue 1,5CM', 'Tissue 2CM', 'Tissue 2,5CM']; ?>
                                            <td style="width: 50%; height: 18px;">Material</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $namaMaterial[$o['transaksi_material'] ?? 0]; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php
                                            $namaFinishing = ['Tidak diketahui', 'Kait Oval', 'Kait HP', 'Kait Standar', 'Tambah Warna Sablon', 'Double Stopper', 'Stopper Tas'];
                                            $finishing = explode(',', $o['transaksi_finish'] ?? 0);
                                            $statusFinishing = "";
                                            foreach ($finishing as $p) {
                                                $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$p];
                                            }
                                            ?>
                                            <td style="width: 50%; height: 18px;">Finishing</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $jenisProduksi = ['Tidak diketahui', 'Sablon', 'Printing']; ?>
                                            <td style="width: 50%; height: 18px;">Jenis Produksi</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $jenisProduksi[$o['transaksi_jp'] ?? 0]; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $namaPaket = ['Tidak diketahui', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                            <td style="width: 50%; height: 18px;">Status</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p style="text-align: left;">
                                    <br />Tanggal/Jam Fix &nbsp; &nbsp; : <?= $o['transaksi_spk_tanggaljamfix'] ?>
                                    <br />Kode Fix&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_kodefix'] ?>
                                    <br />Speeling&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_speeling'] ?>
                                    <br />Deadline&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_deadline'] ?>
                                </p>
                                <p style="text-align: left;">&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </page>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="printSpk1">Print</button>
                </div>
                <div id="alert_status"></div>
                <div id="data_status"></div>
            </div>
        </div>
    </div>
    <?php
    $tanggalJamFix = $this->db->query("SELECT transaksi_spk_tanggaljamfix FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
    $kodeFix = $this->db->query("SELECT transaksi_spk_kodefix FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
    $Speeling = $this->db->query("SELECT transaksi_spk_speeling FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
    $deadline = $this->db->query("SELECT transaksi_spk_deadline FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
    $noPenyelesaian = $this->db->query("SELECT transaksi_no_penyelesaian FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
    $JTaliAwal = $this->db->query("SELECT transaksi_spk_jumlahtaliawal FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
    $JTaliAkhir = $this->db->query("SELECT transaksi_spk_jumlahtaliakhir FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
    $JTaliStopperAwal = $this->db->query("SELECT transaksi_spk_jumlahtalistopperawal FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
    $JTaliStopperAkhir = $this->db->query("SELECT transaksi_spk_jumlahtalistopperakhir FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
    $JKlemAwal = $this->db->query("SELECT transaksi_spk_jumlahklemawal FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
    $JKlemAkhir = $this->db->query("SELECT transaksi_spk_jumlahklemakhir FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
    $JKaitAwal = $this->db->query("SELECT transaksi_spk_jumlahkaitawal FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
    $JKaitAkhir = $this->db->query("SELECT transaksi_spk_jumlahkaitakhir FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
    $JStopperAwal = $this->db->query("SELECT transaksi_spk_jumlahstopperawal FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
    $JStopperAkhir = $this->db->query("SELECT transaksi_spk_jumlahstopperakhir FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
    $spkOperator = $this->db->query("SELECT transaksi_spk_operator FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
    ?>
    <div class="modal fade" id="status_printedit2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit SPK Approval</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <page size="A6">
                    <div id="printThis3">
                        <div class="modal-body">
                            <div class="lcfont">
                                <p style="text-align: left;"><strong> </strong><span style="text-decoration: underline;"><strong>SPK Approval</strong></span></p>
                                <p style="text-align: left;">Nama&nbsp; &nbsp; : <?= $o['pelanggan_nama'] ?><br />Quantity: <?= $o['transaksi_jumlah'] ?><br />Tanggal : <?= $o['transaksi_tanggal'] ?>
                                    <br />Jumlah Tali Awal/Akhir &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;: <input type="number" style="width: 7em" name="JTaliAwal" id="JTaliAwal" placeholder="Awal" value="<?= $JTaliAwal['transaksi_spk_jumlahtaliawal']; ?>"> / <input type="number" style="width: 7em" name="JTaliAkhir" id="JTaliAkhir" placeholder="Akhir" value="<?= $JTaliAkhir['transaksi_spk_jumlahtaliakhir']; ?>">
                                    <br />Jumlah Tali Stopper Awal/Akhir : <input type="number" style="width: 7em" name="JTaliStopperAwal" id="JTaliStopperAwal" placeholder="Awal" value="<?= $JTaliStopperAwal['transaksi_spk_jumlahtalistopperawal']; ?>"> / <input type="number" style="width: 7em" name="JTaliStopperAkhir" id="JTaliStopperAkhir" placeholder="Akhir" value="<?= $JTaliStopperAkhir['transaksi_spk_jumlahtalistopperakhir']; ?>">
                                    <br />Jumlah Klem Awal/Akhir &nbsp; &nbsp; &nbsp; &nbsp; : <input type="number" style="width: 7em" name="JKlemAwal" id="JKlemAwal" placeholder="Awal" value="<?= $JKlemAwal['transaksi_spk_jumlahklemawal']; ?>"> / <input type="number" style="width: 7em" name="JKlemAkhir" id="JKlemAkhir" placeholder="Akhir" value="<?= $JKlemAkhir['transaksi_spk_jumlahklemakhir']; ?>">
                                    <br />Jumlah Kait Awal/Akhir &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: <input type="number" style="width: 7em" name="JKaitAwal" id="JKaitAwal" placeholder="Awal" value="<?= $JKaitAwal['transaksi_spk_jumlahkaitawal']; ?>"> / <input type="number" style="width: 7em" name="JKaitAkhir" id="JKaitAkhir" placeholder="Akhir" value="<?= $JKaitAkhir['transaksi_spk_jumlahkaitakhir']; ?>">
                                    <br />Jumlah Stopper Awal/Akhir &nbsp; &nbsp;&nbsp; : <input type="number" style="width: 7em" name="JStopperAwal" id="JStopperAwal" placeholder="Awal" value="<?= $JStopperAwal['transaksi_spk_jumlahstopperawal']; ?>"> / <input type="number" style="width: 7em" name="JStopperAkhir" id="JStopperAkhir" placeholder="Akhir" value="<?= $JStopperAkhir['transaksi_spk_jumlahstopperakhir']; ?>">
                                    <br />Operator &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <input type="text" style="width: 7em" name="spkoperator" id="spkOperator" placeholder="Masukkan nama operator" value="<?= $spkOperator['transaksi_spk_operator']; ?>">
                                </p>
                                <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                    <tbody>
                                        <tr style="height: 18px;">
                                            <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Kode Produk</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_product_id'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Jenis Tali</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_nama'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Quantity</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_jumlah'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px; text-align: center;" colspan="2"><strong>Keterangan</strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $namaMaterial = ['Tidak diketahui', 'Polyester 1,5CM', 'Polyester 2CM', 'Polyester 2,5CM', 'Tissue 1,5CM', 'Tissue 2CM', 'Tissue 2,5CM']; ?>
                                            <td style="width: 50%; height: 18px;">Material</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $namaMaterial[$o['transaksi_material'] ?? 0]; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php
                                            $namaFinishing = ['Tidak diketahui', 'Kait Oval', 'Kait HP', 'Kait Standar', 'Tambah Warna Sablon', 'Double Stopper', 'Stopper Tas'];
                                            $finishing = explode(',', $o['transaksi_finish'] ?? 0);
                                            $statusFinishing = "";
                                            foreach ($finishing as $p) {
                                                $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$p];
                                            }
                                            ?>
                                            <td style="width: 50%; height: 18px;">Finishing</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $jenisProduksi = ['Tidak diketahui', 'Sablon', 'Printing']; ?>
                                            <td style="width: 50%; height: 18px;">Jenis Produksi</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $jenisProduksi[$o['transaksi_jp'] ?? 0]; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $namaPaket = ['Tidak diketahui', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                            <td style="width: 50%; height: 18px;">Status</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p style="text-align: left;">
                                    <br />Tanggal/Jam Fix &nbsp; &nbsp; : <input type="datetime-local" name="tanggalJamFix" id="tanggalJamFix" value="<?= $tanggalJamFix['transaksi_spk_tanggaljamfix']; ?>">
                                    <br />Kode Fix&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <input type="text" name="kodeFix" id="kodeFix" placeholder="Masukkan Kode Fix" value="<?= $kodeFix['transaksi_spk_kodefix']; ?>">
                                    <br />Speeling&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <input type="text" name="Speeling" id="Speeling" placeholder="Masukkan Speeling" value="<?= $Speeling['transaksi_spk_speeling']; ?>">
                                    <br />Deadline&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <input type="date" name="deadline" id="deadline" value="<?= $deadline['transaksi_spk_deadline']; ?>">
                                </p>
                                <p style="text-align: left;">&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </page>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="savespkapv">Save</button>
                </div>
                <div id="alert_status"></div>
                <div id="data_status"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="status_print5" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Print SPK Produksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <page size="A6">
                    <div id="printThis4">
                        <div class="modal-body">
                            <div class="lcfont">
                                <button style="float: right;" class="btn btn-primary btn-sm status" data-toggle="modal" data-target="#status_printedit3"><i class="fa fa-edit"></i></button><br>
                                <p style="text-align: left;"><strong> </strong><span style="text-decoration: underline;"><strong>SPK Produksi</strong></span></p>
                                <p style="text-align: left;">Nama&nbsp; &nbsp; : <?= $o['pelanggan_nama'] ?><br />Quantity: <?= $o['transaksi_jumlah'] ?><br />Tanggal : <?= $o['transaksi_tanggal'] ?>
                                    <br />Jumlah Tali Awal/Akhir &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;: <?= $o['transaksi_spk_jumlahtaliawal'] ?> / <?= $o['transaksi_spk_jumlahtaliakhir'] ?>
                                    <br />Jumlah Tali Stopper Awal/Akhir : <?= $o['transaksi_spk_jumlahtalistopperawal'] ?> / <?= $o['transaksi_spk_jumlahtalistopperakhir'] ?>
                                    <br />Jumlah Klem Awal/Akhir &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_jumlahklemawal'] ?> / <?= $o['transaksi_spk_jumlahklemakhir'] ?>
                                    <br />Jumlah Kait Awal/Akhir &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: <?= $o['transaksi_spk_jumlahkaitawal'] ?> / <?= $o['transaksi_spk_jumlahkaitakhir'] ?>
                                    <br />Jumlah Stopper Awal/Akhir &nbsp; &nbsp;&nbsp; : <?= $o['transaksi_spk_jumlahstopperawal'] ?> / <?= $o['transaksi_spk_jumlahstopperakhir'] ?>
                                    <br />Operator &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_operator'] ?>
                                </p>
                                <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                    <tbody>
                                        <tr style="height: 18px;">
                                            <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Kode Produk</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_product_id'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Jenis Tali</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_nama'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Quantity</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_jumlah'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px; text-align: center;" colspan="2"><strong>Keterangan</strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $namaMaterial = ['Tidak diketahui', 'Polyester 1,5CM', 'Polyester 2CM', 'Polyester 2,5CM', 'Tissue 1,5CM', 'Tissue 2CM', 'Tissue 2,5CM']; ?>
                                            <td style="width: 50%; height: 18px;">Material</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $namaMaterial[$o['transaksi_material'] ?? 0]; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php
                                            $namaFinishing = ['Tidak diketahui', 'Kait Oval', 'Kait HP', 'Kait Standar', 'Tambah Warna Sablon', 'Double Stopper', 'Stopper Tas'];
                                            $finishing = explode(',', $o['transaksi_finish'] ?? 0);
                                            $statusFinishing = "";
                                            foreach ($finishing as $p) {
                                                $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$p];
                                            }
                                            ?>
                                            <td style="width: 50%; height: 18px;">Finishing</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $jenisProduksi = ['Tidak diketahui', 'Sablon', 'Printing']; ?>
                                            <td style="width: 50%; height: 18px;">Jenis Produksi</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $jenisProduksi[$o['transaksi_jp'] ?? 0]; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $namaPaket = ['Tidak diketahui', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                            <td style="width: 50%; height: 18px;">Status</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p style="text-align: left;">No.Penyelesain &nbsp; &nbsp; &nbsp;: <?= $o['transaksi_no_penyelesaian'] ?>
                                    <br />Deadline&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_deadline'] ?>
                                </p>
                                <p style="text-align: left;">&nbsp;</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="printSpk2">Print</button>
                    </div>
                    <div id="alert_status"></div>
                    <div id="data_status"></div>
                </page>
            </div>
        </div>
    </div>

    <div class="modal fade" id="status_printedit3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit SPK Produksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <page size="A6">
                    <div id="printThis4">
                        <div class="modal-body">
                            <div class="lcfont">
                                <p style="text-align: left;"><strong> </strong><span style="text-decoration: underline;"><strong>SPK Produksi</strong></span></p>
                                <p style="text-align: left;">Nama&nbsp; &nbsp; : <?= $o['pelanggan_nama'] ?><br />Quantity: <?= $o['transaksi_jumlah'] ?><br />Tanggal : <?= $o['transaksi_tanggal'] ?>
                                    <br />Jumlah Tali Awal/Akhir &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;: <input type="number" style="width: 7em" name="JTaliAwalp" id="JTaliAwalp" placeholder="Awal" value="<?= $JTaliAwal['transaksi_spk_jumlahtaliawal']; ?>"> / <input type="number" style="width: 7em" name="JTaliAkhirp" id="JTaliAkhirp" placeholder="Akhir" value="<?= $JTaliAkhir['transaksi_spk_jumlahtaliakhir']; ?>">
                                    <br />Jumlah Tali Stopper Awal/Akhir : <input type="number" style="width: 7em" name="JTaliStopperAwalp" id="JTaliStopperAwalp" placeholder="Awal" value="<?= $JTaliStopperAwal['transaksi_spk_jumlahtalistopperawal']; ?>"> / <input type="number" style="width: 7em" name="JTaliStopperAkhirp" id="JTaliStopperAkhirp" placeholder="Akhir" value="<?= $JTaliStopperAkhir['transaksi_spk_jumlahtalistopperakhir']; ?>">
                                    <br />Jumlah Klem Awal/Akhir &nbsp; &nbsp; &nbsp; &nbsp; : <input type="number" style="width: 7em" name="JKlemAwalp" id="JKlemAwalp" placeholder="Awal" value="<?= $JKlemAwal['transaksi_spk_jumlahklemawal']; ?>"> / <input type="number" style="width: 7em" name="JKlemAkhirp" id="JKlemAkhirp" placeholder="Akhir" value="<?= $JKlemAkhir['transaksi_spk_jumlahklemakhir']; ?>">
                                    <br />Jumlah Kait Awal/Akhir &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: <input type="number" style="width: 7em" name="JKaitAwalp" id="JKaitAwalp" placeholder="Awal" value="<?= $JKaitAwal['transaksi_spk_jumlahkaitawal']; ?>"> / <input type="number" style="width: 7em" name="JKaitAkhirp" id="JKaitAkhirp" placeholder="Akhir" value="<?= $JKaitAkhir['transaksi_spk_jumlahkaitakhir']; ?>">
                                    <br />Jumlah Stopper Awal/Akhir &nbsp; &nbsp;&nbsp; : <input type="number" style="width: 7em" name="JStopperAwalp" id="JStopperAwalp" placeholder="Awal" value="<?= $JStopperAwal['transaksi_spk_jumlahstopperawal']; ?>"> / <input type="number" style="width: 7em" name="JStopperAkhirp" id="JStopperAkhirp" placeholder="Akhir" value="<?= $JStopperAkhir['transaksi_spk_jumlahstopperakhir']; ?>">
                                    <br />Operator &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <input type="text" name="spkoperatorp" id="spkOperatorp" placeholder="Masukkan nama operator" value="<?= $spkOperator['transaksi_spk_operator']; ?>">
                                </p>
                                <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                    <tbody>
                                        <tr style="height: 18px;">
                                            <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Kode Produk</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_product_id'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Jenis Tali</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_nama'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px;">Quantity</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_jumlah'] ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <td style="width: 50%; height: 18px; text-align: center;" colspan="2"><strong>Keterangan</strong></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $namaMaterial = ['Tidak diketahui', 'Polyester 1,5CM', 'Polyester 2CM', 'Polyester 2,5CM', 'Tissue 1,5CM', 'Tissue 2CM', 'Tissue 2,5CM']; ?>
                                            <td style="width: 50%; height: 18px;">Material</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $namaMaterial[$o['transaksi_material'] ?? 0]; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php
                                            $namaFinishing = ['Tidak diketahui', 'Kait Oval', 'Kait HP', 'Kait Standar', 'Tambah Warna Sablon', 'Double Stopper', 'Stopper Tas'];
                                            $finishing = explode(',', $o['transaksi_finish'] ?? 0);
                                            $statusFinishing = "";
                                            foreach ($finishing as $p) {
                                                $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$p];
                                            }
                                            ?>
                                            <td style="width: 50%; height: 18px;">Finishing</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $jenisProduksi = ['Tidak diketahui', 'Sablon', 'Printing']; ?>
                                            <td style="width: 50%; height: 18px;">Jenis Produksi</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $jenisProduksi[$o['transaksi_jp'] ?? 0]; ?></td>
                                        </tr>
                                        <tr style="height: 18px;">
                                            <?php $namaPaket = ['Tidak diketahui', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                            <td style="width: 50%; height: 18px;">Status</td>
                                            <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p style="text-align: left;">No.Penyelesain &nbsp; &nbsp; &nbsp;: <input type="text" name="noPenyelesaian" id="noPenyelesaian" placeholder="Masukkan no penyelesaian" value="<?= $noPenyelesaian['transaksi_no_penyelesaian']; ?>">
                                    <br />Deadline&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_deadline'] ?>
                                </p>
                                <p style="text-align: left;">&nbsp;</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="savespkprdksi">Save</button>
                    </div>
                    <div id="alert_status"></div>
                    <div id="data_status"></div>
                </page>
            </div>
        </div>
    </div>
    <div id="printThis2">
        <?php
        date_default_timezone_set('Asia/Jakarta');
        echo 'Dicetak Pada ' . date('d-m-Y H:i:s');
        ?>
    </div>
</div>
<div class="modal fade" id="bukti" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Bukti Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img style="width: 100%;" src="<?= base_url('bukti_transaksi/' . $o['transaksi_bukti']) ?>">
            </div>
            <div class="modal-footer">
                <a href="<?= base_url('bukti_transaksi/' . $o['transaksi_bukti']) ?>" class="btn btn-primary"><i class="fa fa-download"></i> Download</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="design" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Design</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert_hapus"></div>
                <h3>Ukuran :</h3>
                <h3 id="info_design"></h3>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn_hapus">Hapus</button>
                <a class="btn btn-info btn_download" download><i class="fa fa-download"></i> Download</a>
                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>
<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Hapus</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert_hapus"></div>
                <h3>Apakah anda yakin?</h3>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn_hapus">Hapus</button>
                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/admin/vendor/dropzone/dist/min/dropzone.min.js') ?>"></script>

<script>
    $('#harga').css('display', 'none');
    $('#update_harga').css('display', 'none');
    $('#tombol_update').click(function() {
        $('#harga').css('display', 'block');
        $('#view_harga').css('display', 'none');
        $('#tombol_update').css('display', 'none');
        $('#update_harga').css('display', 'block');
    });
    $('#update_harga').click(function() {
        var id = $('#id').val();
        var harga = $('#harga').val();
        $('#alert').attr('class', '');
        $.ajax({
            url: "<?= base_url('Order/update_order') ?>",
            type: "POST",
            data: {
                id: id,
                harga: harga
            },
            success: function(data) {
                $('#alert').attr('class', 'fa fa-check fa-2x');
            }
        });
    });
    $('.status').click(function() {
        var id = $('#id').val();
        var id_status = $(this).attr('id-status');
        $.ajax({
            type: 'POST',
            url: '<?= base_url('Order/get_status') ?>',
            data: {
                id: id,
                id_status: id_status
            },
            success: function(data) {
                $('#data_status').html(data);
            }
        });
    });
    $(document).on('click', '#update-status', function() {
        var url = document.URL;
        var keputusan = $('#keputusan').val();
        if (keputusan !== '') {
            if (keputusan == '0' && keterangan == '') {
                $('#alert_status').html('<div class="alert alert-danger alert-dismissible fade show" style="border-radius:0px;" role="alert"><span class="alert-icon"><i class="fa fa-times"></i></span><span class="alert-text"><strong>Harus Ada Keterangan</strong></span></div>');
            } else {
                $('#alert_status').html('<div class="alert alert-info alert-dismissible fade show" style="border-radius:0px;" role="alert"><span class="alert-icon"></span><span class="alert-text"><strong>Loading...</strong></span></div>');
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('Order/status') ?>',
                    data: {
                        id: $('#id').val(),
                        id_status: $('#id_status').val(),
                        keputusan: keputusan,
                        personalisasi: $('input[name="personalisasi[]"]:checked').map((i, el) => el.value).get().join(','),
                        coating: $('input[name="coating"]:checked').val(),
                        finishing: $('input[name="finishing[]"]:checked').map((i, el) => el.value).get().join(','),
                        function: $('input[name="function"]:checked').val(),
                        packaging: $('input[name="packaging[]"]:checked').map((i, el) => el.value).get().join(','),
                        status: $('input[name="status"]:checked').val(),
                        keterangan: $('#keterangan').val(),
                        user: $('#loggeduser').val()
                    },
                    success: function(data) {
                        $('#alert_status').html('<div class="alert alert-success alert-dismissible fade show" style="border-radius:0px;" role="alert"><span class="alert-icon"><i class="fa fa-check"></i></span><span class="alert-text"><strong>Berhasil!</strong></span></div>');
                        setTimeout(function() {
                            window.location.href = url;
                        }, 1000);
                    }
                });
            }
        } else {
            $('#alert_status').html('<div class="alert alert-danger alert-dismissible fade show" style="border-radius:0px;" role="alert"><span class="alert-icon"><i class="fa fa-times"></i></span><span class="alert-text"><strong>Keputusan Tidak Boleh Kosong</strong></span></div>');
        }
    });
    $(document).on('click', '.modal_lihat', function() {
        var id = $(this).attr('title');
        $('#data_design').attr('id-design', id);
        $.ajax({
            url: "<?= base_url('Order/get_data_design') ?>",
            type: "POST",
            data: {
                id: id
            },
            success: function(data) {
                $('#data_design').html(data);
            }
        });
    });
    $(document).on('click', '#hapus_design', function() {
        var url = document.URL;
        var id = $('#data_design').attr('id-design');
        $.ajax({
            type: 'POST',
            url: '<?= base_url('Order/hapus_design') ?>',
            data: {
                id: id
            },
            success: function(data) {
                $('#alert_design').html('<div class="alert alert-success alert-dismissible fade show" role="alert"><span class="alert-icon"><i class="fa fa-check"></i></span><span class="alert-text"><strong>Berhasil!</strong> Data dihapus</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                setTimeout(function() {
                    window.location.href = url;
                }, 1000);
            }
        });
    });
    $(document).on('click', '.design', function() {
        var id = $(this).attr('id');
        var d = $(this).attr('design-kirim');
        $.ajax({
            type: 'POST',
            url: '<?= base_url('Order/info_design') ?>',
            data: {
                d: d
            },
            success: function(data) {
                $('#info_design').html(data);
            }
        })
        $('.btn_hapus').attr('id', id);
        $('.btn_download').attr('href', d);
    });
    $(document).on('click', '.btn_hapus', function() {
        var url = document.URL;
        var id = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: "<?= base_url('Order/hapus_design_upload') ?>",
            data: {
                id: id
            },
            success: function(data) {
                $('#alert_hapus').html('<div class="alert alert-success alert-dismissible fade show" role="alert"><span class="alert-icon"><i class="fa fa-check"></i></span><span class="alert-text"><strong>Berhasil!</strong> Data dihapus</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                setTimeout(function() {
                    window.location.href = url;
                }, 1000);
            }
        });
    });
</script>
<script>
    function status(evt, status) {
        var i, tabcontent;
        tabcontent = $(".tabcontent").css('display', 'none');
        tablinks = $(".tablinks");
        $('#' + status).css('display', 'block');
    }

    // Get the element with id="defaultOpen" and click on it
    $("#defaultOpen").click();
</script>
<script>
    $('input[type=radio][name=paket]').on('click', function() {
        return confirm('Apakah anda yakin ingin mengubahnya?');
    });
    $('input[type=radio][name=paket]').change(function() {
        var id = $('#id').val();
        var val = $(this).val();
        $.ajax({
            type: 'POST',
            url: '<?= base_url('Order/paket') ?>',
            data: {
                id: id,
                val: val
            },
            success: function(data) {
                $('.terima').css('display', 'block');
                location.reload();
            }
        })
    });
</script>
<script>
    $('.terima').click(function() {
        if (confirm('Apakah anda yakin paket sudah diterima?')) {
            var val = 1;
            var id = $('#id').val();
            var user = $('#loggeduser').val();
            $.ajax({
                type: 'POST',
                url: "<?= base_url('Order/terima') ?>",
                data: {
                    val: val,
                    id: id,
                    user: user
                },
                success: function(data) {
                    $('#terima_p').html(data);
                    location.reload();
                }
            });
        }
    });
</script>
<script>
    function copy() {
        var copyText = document.getElementById("link");

        copyText.select();
        copyText.setSelectionRange(0, 99999);

        document.execCommand("copy");

        alert("Copied the text: " + copyText.value);
    }
</script>
<script>
    $(document).ready(function() {
        var baseUrl = window.location.href;
        var hash = baseUrl.lastIndexOf('#');
        if (hash != -1) {
            var elId = baseUrl.substring(hash);
            if (elId !== null) $(elId).modal('show');
        }
    })

    $('#savespksales').click(function(e) {
        e.preventDefault();


        var id = $('#id').val();
        var assesoris = $('#assesoris').val();

        $.ajax({
            type: 'POST',
            url: "<?= base_url('Order/savespksales') ?>",
            data: {
                id: id,
                assesoris: assesoris
            },
            success: function(data) {
                window.location = '<?= base_url('Order/detail/' . $this->uri->segment(3) . '#status_print1') ?>';
                location.reload();
            }
        });

    });

    $('#savespkapv').click(function(e) {
        e.preventDefault();
        var id = $('#id').val();
        var spkOperator = $('#spkOperatorp').val();
        var tanggalJamFix = $('#tanggalJamFix').val();
        var kodeFix = $('#kodeFix').val();
        var Speeling = $('#Speeling').val();
        var deadline = $('#deadline').val();
        var noPenyelesaian = $('#noPenyelesaian').val();
        var JTaliAwal = $('#JTaliAwal').val();
        var JTaliAkhir = $('#JTaliAkhir').val();
        var JTaliStopperAwal = $('#JTaliStopperAwal').val();
        var JTaliStopperAkhir = $('#JTaliStopperAkhir').val();
        var JKlemAwal = $('#JKlemAwal').val();
        var JKlemAkhir = $('#JKlemAkhir').val();
        var JKaitAwal = $('#JKaitAwal').val();
        var JKaitAkhir = $('#JKaitAkhir').val();
        var JStopperAwal = $('#JStopperAwal').val();
        var JStopperAkhir = $('#JStopperAkhir').val();

        $.ajax({
            type: 'POST',
            url: "<?= base_url('Order/savespkapv') ?>",
            data: {
                id: id,
                spkOperator: spkOperator,
                tanggalJamFix: tanggalJamFix,
                kodeFix: kodeFix,
                Speeling: Speeling,
                deadline: deadline,
                noPenyelesaian: noPenyelesaian,
                JTaliAwal: JTaliAwal,
                JTaliAkhir: JTaliAkhir,
                JTaliStopperAwal: JTaliStopperAwal,
                JTaliStopperAkhir: JTaliStopperAkhir,
                JKlemAwal: JKlemAwal,
                JKlemAkhir: JKlemAkhir,
                JKaitAwal: JKaitAwal,
                JKaitAkhir: JKaitAkhir,
                JStopperAwal: JStopperAwal,
                JStopperAkhir: JStopperAkhir

            },
            success: function(data) {
                window.location = '<?= base_url('Order/detail/' . $this->uri->segment(3) . '#status_print4') ?>';
                location.reload();
            }
        });
    });

    $('#savespkprdksi').click(function(e) {
        e.preventDefault();
        var id = $('#id').val();
        var spkOperator = $('#spkOperatorp').val();
        var tanggalJamFix = $('#tanggalJamFix').val();
        var kodeFix = $('#kodeFix').val();
        var Speeling = $('#Speeling').val();
        var deadline = $('#deadline').val();
        var noPenyelesaian = $('#noPenyelesaian').val();
        var JTaliAwal = $('#JTaliAwalp').val();
        var JTaliAkhir = $('#JTaliAkhirp').val();
        var JTaliStopperAwal = $('#JTaliStopperAwalp').val();
        var JTaliStopperAkhir = $('#JTaliStopperAkhirp').val();
        var JKlemAwal = $('#JKlemAwalp').val();
        var JKlemAkhir = $('#JKlemAkhirp').val();
        var JKaitAwal = $('#JKaitAwalp').val();
        var JKaitAkhir = $('#JKaitAkhirp').val();
        var JStopperAwal = $('#JStopperAwalp').val();
        var JStopperAkhir = $('#JStopperAkhirp').val();

        $.ajax({
            type: 'POST',
            url: "<?= base_url('Order/savespkprdksi') ?>",
            data: {
                id: id,
                spkOperator: spkOperator,
                tanggalJamFix: tanggalJamFix,
                kodeFix: kodeFix,
                Speeling: Speeling,
                deadline: deadline,
                noPenyelesaian: noPenyelesaian,
                JTaliAwal: JTaliAwal,
                JTaliAkhir: JTaliAkhir,
                JTaliStopperAwal: JTaliStopperAwal,
                JTaliStopperAkhir: JTaliStopperAkhir,
                JKlemAwal: JKlemAwal,
                JKlemAkhir: JKlemAkhir,
                JKaitAwal: JKaitAwal,
                JKaitAkhir: JKaitAkhir,
                JStopperAwal: JStopperAwal,
                JStopperAkhir: JStopperAkhir

            },
            success: function(data) {
                window.location = '<?= base_url('Order/detail/' . $this->uri->segment(3) . '#status_print5') ?>';
                location.reload();
            }
        });
    });
</script>
<script>
    document.getElementById("printSpk").onclick = function() {
        printElement(document.getElementById("printThis"));
        printElement(document.getElementById("printThis2"), true, "<hr />");
        window.print();
    }

    function printElement(elem, append, delimiter) {
        var domClone = elem.cloneNode(true);

        var $printSection = document.getElementById("printSection");

        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }

        if (append !== true) {
            $printSection.innerHTML = "";
        } else if (append === true) {
            if (typeof(delimiter) === "string") {
                $printSection.innerHTML += delimiter;
            } else if (typeof(delimiter) === "object") {
                $printSection.appendChlid(delimiter);
            }
        }

        $printSection.appendChild(domClone);
    }
</script>
<script>
    document.getElementById("printSpk1").onclick = function() {
        printElement(document.getElementById("printThis3"));
        printElement(document.getElementById("printThis2"), true, "<hr />");
        window.print();
    }

    function printElement(elem, append, delimiter) {
        var domClone = elem.cloneNode(true);

        var $printSection = document.getElementById("printSection");

        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }

        if (append !== true) {
            $printSection.innerHTML = "";
        } else if (append === true) {
            if (typeof(delimiter) === "string") {
                $printSection.innerHTML += delimiter;
            } else if (typeof(delimiter) === "object") {
                $printSection.appendChlid(delimiter);
            }
        }

        $printSection.appendChild(domClone);
    }
</script>
<script>
    document.getElementById("printSpk2").onclick = function() {
        printElement(document.getElementById("printThis4"));
        printElement(document.getElementById("printThis2"), true, "<hr />");
        window.print();
    }

    function printElement(elem, append, delimiter) {
        var domClone = elem.cloneNode(true);

        var $printSection = document.getElementById("printSection");

        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }

        if (append !== true) {
            $printSection.innerHTML = "";
        } else if (append === true) {
            if (typeof(delimiter) === "string") {
                $printSection.innerHTML += delimiter;
            } else if (typeof(delimiter) === "object") {
                $printSection.appendChlid(delimiter);
            }
        }

        $printSection.appendChild(domClone);
    }
</script>
<script>
    $('form#ass input').bind("change", function() {
        var val = $(this).val();
        $(this).attr('value', val);
    });
</script>