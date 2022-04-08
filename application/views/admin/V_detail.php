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
                                                    <button id-status="<?= $s['status_urut'] == '' ? $statusproduksi : $s['status_id'] ?>" class="btn btn-primary btn-sm status" data-toggle="modal" data-target="#spk_sales"><i class="fa fa-print"> SPK Sales</i></button>
                                                <?php
                                                    break;
                                                case "4":
                                                ?>
                                                    <button id-status="<?= $s['status_urut'] == '' ? $statusproduksi : $s['status_id'] ?>" class="btn btn-primary btn-sm status" data-toggle="modal" data-target="#spk_approval"><i class="fa fa-print"></i> SPK Approval</button>
                                                    <button id-status="<?= $s['status_urut'] == '' ? $statusproduksi : $s['status_id'] ?>" class="btn btn-primary btn-sm status" data-toggle="modal" data-target="#spk_produksi"><i class="fa fa-print"></i> SPK Produksi</button>
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
                            <p><?= $p['product_nama']; ?></p>
                            <b>Harga satuan</b>
                            <p><?= 'Rp' . number_format($p['product_harga'], 2, ',', '.'); ?></p>
                            <b>Jumlah dipesan</b>
                            <p><?= $o['transaksi_jumlah']; ?></p>
                            <b>Total harga</b>
                            <p><?= 'Rp' . number_format($o['transaksi_harga'], 2, ',', '.'); ?></p>
                            <b>Keterangan Pesanan</b>
                            <p><?= $o['transaksi_keterangan'] ?? 'Tidak ada keterangan'; ?></p>
                            <b>Kustomisasi</b>
                            <?php if ($p['product_tipe'] == '0') : ?>
                                <!-- Kartu -->
                                <div class="grid-container">
                                    <div class="grid-item">
                                        <?php
                                        $namaPersonalisasi = ['Tidak dipilih', 'Blanko', 'Nomerator', 'Barcode', 'Data', 'Data + Foto'];
                                        $personalisasi = explode(',', $o['transaksi_personalisasi'] ?? 0);
                                        $statusPersonalisasi = "";
                                        foreach ($personalisasi as $pe) {
                                            $statusPersonalisasi .= (!empty($statusPersonalisasi) ? ', ' : '') . $namaPersonalisasi[$pe];
                                        }
                                        ?>
                                        <b>Personalisasi</b>
                                        <p><?= $statusPersonalisasi; ?></p>
                                    </div>
                                    <div class="grid-item">
                                        <?php $namaCoating = ['Tidak dipilih', 'Glossy', 'Doff', 'Glossy + Doff', 'UV']; ?>
                                        <b>Coating</b>
                                        <p><?= $namaCoating[$o['transaksi_coating'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item">
                                        <?php
                                        $namaFinishing = ['Tidak dipilih', 'Tidak ada', 'Urutkan', 'Label Gosok', 'Plong Oval', 'Plong Bulat', 'Urutkan', 'Emboss Silver', 'Emboss Gold', 'Panel', 'Hot', 'Swipe'];
                                        $finishing = explode(',', $o['transaksi_finishing'] ?? 0);
                                        $statusFinishing = "";
                                        foreach ($finishing as $f) {
                                            $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$f];
                                        }
                                        ?>
                                        <b>Finishing</b>
                                        <p><?= $statusFinishing; ?></p>
                                    </div>
                                    <div class="grid-item">
                                        <?php $namaFunction = ['Tidak dipilih', 'Print Thermal', 'Scan Barcode', 'Swipe Magnetic', 'Tap RFID']; ?>
                                        <b>Function</b>
                                        <p><?= $namaFunction[$o['transaksi_function'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item">
                                        <?php
                                        $namaPackaging = ['Tidak dipilih', 'Plastik 1 on 1', 'Plastik Terpisah', 'Box Kartu Nama', 'Box Putih', 'Small UCARD', 'Small Maxi UCARD', 'Large UCARD', 'Large Maxi UCARD'];
                                        $packaging = explode(',', $o['transaksi_packaging'] ?? 0);
                                        $statusPackaging = "";
                                        foreach ($packaging as $pa) {
                                            $statusPackaging .= (!empty($statusPackaging) ? ', ' : '') . $namaPackaging[$pa];
                                        }
                                        ?>
                                        <b>Packaging</b>
                                        <p><?= $statusPackaging; ?></p>
                                    </div>
                                    <div class="grid-item">
                                        <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                        <b>Ambil/Kirim</b>
                                        <p><?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></p>
                                    </div>
                                </div>
                            <?php elseif ($p['product_tipe'] == '1') : ?>
                                <!-- Aksesoris -->
                                <div class="grid-container">
                                    <div class="grid-item p-0 pb-3">
                                        <?php $yoyo = ['Tidak dipilih', 'Yoyo Putar', 'Yoyo Standar', 'Yoyo Transparan']; ?>
                                        <b>Yoyo</b>
                                        <p>&nbsp;<?= $yoyo[$o['transaksi_yoyo'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $warna = ['Tidak dipilih', 'Hitam', 'Putih', 'Hijau', 'Biru', 'Merah', 'Kuning', 'Orange', 'Silver', 'Coklat', 'Hitam Transparan', 'Putih Transparan', 'Biru Transparan', 'Custom']; ?>
                                        <b>Warna</b>
                                        <p>&nbsp;<?= $warna[$o['transaksi_warna'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $Casing = ['Tidak dipilih', 'Casing ID Card Acrylic', 'Casing ID Card Solid', 'Casing ID Card Karet', 'Casing ID Card Kulit']; ?>
                                        <b>Casing</b>
                                        <p>&nbsp;<?= $Casing[$o['transaksi_casing'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $CasingKaret = ['Tidak dipilih', 'Casing karet 1 sisi', 'Casing karet 2 sisi', 'Casing karet double landscape', 'Casing karet single landscape']; ?>
                                        <b>Casing Karet</b>
                                        <p>&nbsp;<?= $CasingKaret[$o['transaksi_ck'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $LogoResin = ['Tidak memakai logo', 'Logo Resin']; ?>
                                        <b>Logo Resin</b>
                                        <p>&nbsp;<?= $LogoResin[$o['transaksi_logo'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $penjepitBuaya = ['Tidak dipilih', 'Penjepit Buaya Besi', 'Penjepit Buaya Plastik']; ?>
                                        <b>Penjepit Buaya</b>
                                        <p>&nbsp;<?= $penjepitBuaya[$o['transaksi_pb'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0">
                                        <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                        <b>Ambil/Kirim</b>
                                        <p><?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></p>
                                    </div>
                                </div>
                            <?php elseif ($p['product_tipe'] == '2') : ?>
                                <!-- Tali -->
                                <div class="grid-container">
                                    <div class="grid-item">
                                        <?php $namaMaterial = ['Tidak dipilih', 'Polyester 1,5CM', 'Polyester 2CM', 'Polyester 2,5CM', 'Tissue 1,5CM', 'Tissue 2CM', 'Tissue 2,5CM', 'Tali gelang 1,5cm printing', 'Tali gelang 2cm printing']; ?>
                                        <b>Material</b>
                                        <p>&nbsp;<?= $namaMaterial[$o['transaksi_material'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item">
                                        <?php
                                        $namaFinishing = ['Tidak dipilih', 'Kait Oval', 'Kait HP', 'Kait Standar', 'Tambah Warna Sablon', 'Double Stopper', 'Stopper Tas'];
                                        $finishing = explode(',', $o['transaksi_finish'] ?? 0);
                                        $statusFinishing = "";
                                        foreach ($finishing as $f) {
                                            $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$f];
                                        }
                                        ?>
                                        <b>Finishing</b>
                                        <p>&nbsp;<?= $statusFinishing; ?></p>
                                    </div>
                                    <div class="grid-item">
                                        <?php $jenisProduksi = ['Tidak dipilih', 'Sablon', 'Printing']; ?>
                                        <b>Jenis Produksi</b>
                                        <p>&nbsp;<?= $jenisProduksi[$o['transaksi_jp'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item">
                                        <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                        <b>Ambil/Kirim</b>
                                        <p><?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <hr>
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
                        if ($design) : ?>
                            <h3>Gambar Desain</h3>
                            <?php foreach ($design as $d) : ?>
                                <a title="<?= $d['design_id'] ?>" id="modal_lihat" type="button" class="modal_lihat" data-toggle="modal" data-target="#lihat">
                                    <img style="width:100%;" src="<?= base_url('design_user/' . $d['design_image']) ?>" alt="">
                                </a>
                                <hr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <h3>File Desain</h3>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-flush" id="datatable-basic">
                                <thead>
                                    <tr>
                                        <td>Nama File</td>
                                        <td>Unduh</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($upload) : ?>
                                        <?php foreach ($upload as $u) : ?>
                                            <tr>
                                                <td><?php echo $u['design_image']; ?></td>
                                                <td><a href="<?= base_url('design_user/' . $u['design_image']) ?>" download>Unduh</a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="2">Pelanggan belum mengirimkan file desain</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <h3>URL File</h3>
                        <div class="col p-0">
                            <?php if (!empty($link['transaksi_link_desain']) && !is_null($link['transaksi_link_desain'])) : ?>
                                <input type="text" class="form-control" name="link" value="<?= $link['transaksi_link_desain']; ?>">
                            <?php else : ?>
                                <p>Pelanggan belum mengirimkan link file</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="status3" class="tabcontent">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-0">Pembayaran</h3>
                            </div>
                            <div class="col">
                                <?php $st = $this->db->query("SELECT * FROM tbl_status_transaksi WHERE transaksi_order_id = '$id_transaksi' ORDER BY transaksi_id DESC LIMIT 1 ")->row_array(); ?>
                                <?php if ($st['transaksi_status_id'] == '3') : ?>
                                    <div class="col">
                                        <div class="text-right">
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ubah_harga">
                                                Ubah Harga <i class="fa fa-pen"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
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
                        <b>Total perlu dibayar jika lunas</b>
                        <p>Rp<?= number_format($total, 2, ',', '.') ?></p>
                        <?php if ($total >= 1000000) : ?>
                            <b>Total perlu dibayar jika DP/uang muka</b>
                            <p>Rp<?= number_format($total * 0.5, 2, ',', '.') ?></p>
                        <?php endif; ?>
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
                            <p>Pelanggan belum mengunggah bukti transfer</p>
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
                        <hr>
                        <div>
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
                        </div>
                        <hr>
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
                                <?php foreach ($produksi as $pr) : ?>
                                    <div class="timeline-block mt-1 mb-0">
                                        <span style="background-color: <?= ($statusproduksi == $produksicount) ? "blue" : ($statusproduksi > $produksicount ? "green" : "grey"); ?>;color: white;" class="timeline-step badge-success">
                                            <i class="fa fa-image"></i>
                                        </span>
                                        <div class="timeline-content">
                                            <p class="my-0"><b class="font-weight-bold"><?= $pr['status_status']; ?></b></p>
                                            <p class=" text-sm mt-1 mb-0"><?= $pr['status_keterangan']; ?></p>
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

<div class="modal fade" id="ubah_harga" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <form method="post" action="<?= base_url('Order/update_harga'); ?>" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Ubah Harga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="transaksi_id" value="<?= $this->uri->segment(3) ?>">
                <div class="form-group">
                    <label for="harga"><b>Harga</b></label>
                    <input class="form-control" id="harga" type="number" name="harga" value="<?= $o['transaksi_harga']; ?>">
                    <br>
                    <label for="ongkir"><b>Ongkir</b></label>
                    <input class="form-control" id="ongkir" type="number" name="ongkir" value="<?= $o['transaksi_ongkir'] ?? '0'; ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
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
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
<?php
$assesoris = $this->db->query("SELECT transaksi_spkkartu_assesoris FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
$keteranganspk = $this->db->query("SELECT transaksi_keterangan_accesoris FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
$dt = new DateTime("@$o[transaksi_tanggal]");
?>
<div>
    <div class="modal fade" id="spk_sales" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                <p style="text-align: left;"><strong> </strong><span style="text-decoration: underline;"><strong>SPK
                                            Sales</strong></span></p>
                                <p style="text-align: left;">Nama&nbsp; &nbsp; : <?= $o['pelanggan_nama'] ?><br />Tanggal :&nbsp;<?= $dt->format('d-m-Y H:i'); ?></p>
                                <?php if ($p['product_tipe'] == '0') : ?>
                                    <!-- Kartu -->
                                    <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                        <tbody>
                                            <tr style="height: 18px;">
                                                <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Kode Produk</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_kode'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Jenis Kartu</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_nama'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaPersonalisasi = ['Tidak dipilih', 'Blanko', 'Nomerator', 'Barcode', 'Data', 'Data + Foto'];
                                                $personalisasi = explode(',', $o['transaksi_personalisasi'] ?? 0);
                                                $statusPersonalisasi = "";
                                                foreach ($personalisasi as $pe) {
                                                    $statusPersonalisasi .= (!empty($statusPersonalisasi) ? ', ' : '') . $namaPersonalisasi[$pe];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Personalisasi</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusPersonalisasi; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Quantity</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_jumlah'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px; text-align: center;" colspan="2"><strong>Keterangan</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaCoating = ['Tidak dipilih', 'Glossy', 'Doff', 'Glossy + Doff', 'UV']; ?>
                                                <td style="width: 50%; height: 18px;">Coating</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaCoating[$o['transaksi_coating'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaFinishing = ['Tidak dipilih', 'Tidak ada', 'Urutkan', 'Label Gosok', 'Plong Oval', 'Plong Bulat', 'Urutkan', 'Emboss Silver', 'Emboss Gold', 'Panel', 'Hot', 'Swipe'];
                                                $finishing = explode(',', $o['transaksi_finishing'] ?? 0);
                                                $statusFinishing = "";
                                                foreach ($finishing as $f) {
                                                    $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$f];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Finishing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaFunction = ['Tidak dipilih', 'Print Thermal', 'Scan Barcode', 'Swipe Magnetic', 'Tap RFID']; ?>
                                                <td style="width: 50%; height: 18px;">Function</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaFunction[$o['transaksi_function'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaPackaging = ['Tidak dipilih', 'Plastik 1 on 1', 'Plastik Terpisah', 'Box Kartu Nama', 'Box Putih', 'Small UCARD', 'Small Maxi UCARD', 'Large UCARD', 'Large Maxi UCARD'];
                                                $packaging = explode(',', $o['transaksi_packaging'] ?? 0);
                                                $statusPackaging = "";
                                                foreach ($packaging as $pa) {
                                                    $statusPackaging .= (!empty($statusPackaging) ? ', ' : '') . $namaPackaging[$pa];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Packaging</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusPackaging; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p style="text-align: left;"><br> Aksesoris : <?= $o['transaksi_spkkartu_assesoris'] ?></p>
                                    <p style="text-align: left;">&nbsp;</p>
                                <?php elseif ($p['product_tipe'] == '1') : ?>
                                    <!-- Aksesoris -->
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
                                                <td style="width: 50%; height: 18px;">Jenis Produk</td>
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
                                                <?php $yoyo = ['Tidak dipilih', 'Yoyo Putar', 'Yoyo Standar', 'Yoyo Transparan']; ?>
                                                <td style="width: 50%; height: 18px;">Yoyo</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $yoyo[$o['transaksi_yoyo'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $warna = ['Tidak dipilih', 'Hitam', 'Putih', 'Hijau', 'Biru', 'Merah', 'Kuning', 'Orange', 'Silver', 'Coklat', 'Hitam Transparan', 'Putih Transparan', 'Biru Transparan', 'Custom']; ?>
                                                <td style="width: 50%; height: 18px;">Warna</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $warna[$o['transaksi_warna'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $Casing = ['Tidak dipilih', 'Casing ID Card Acrylic', 'Casing ID Card Solid', 'Casing ID Card Karet', 'Casing ID Card Kulit']; ?>
                                                <td style="width: 50%; height: 18px;">Casing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $Casing[$o['transaksi_casing'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $CasingKaret = ['Tidak dipilih', 'Casing karet 1 sisi', 'Casing karet 2 sisi', 'Casing karet double landscape', 'Casing karet single landscape']; ?>
                                                <td style="width: 50%; height: 18px;">CasingKaret</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $CasingKaret[$o['transaksi_ck'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $LogoResin = ['Tidak memakai logo', 'Logo Resin']; ?>
                                                <td style="width: 50%; height: 18px;">Logo Resin</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $LogoResin[$o['transaksi_logo'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $penjepitBuaya = ['Tidak dipilih', 'Penjepit Buaya Besi', 'Penjepit Buaya Plastik']; ?>
                                                <td style="width: 50%; height: 18px;">Penjepit Buaya</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $penjepitBuaya[$o['transaksi_pb'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p style="text-align: left;"><br> Keterangan : <br><?= $keteranganspk['transaksi_keterangan_accesoris'] ?></p>
                                    <p style="text-align: left;">&nbsp;</p>
                                <?php elseif ($p['product_tipe'] == '2') : ?>
                                    <!-- Tali -->
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
                                                <?php $namaMaterial = ['Tidak dipilih', 'Polyester 1,5CM', 'Polyester 2CM', 'Polyester 2,5CM', 'Tissue 1,5CM', 'Tissue 2CM', 'Tissue 2,5CM', 'Tali gelang 1,5cm printing', 'Tali gelang 2cm printing']; ?>
                                                <td style="width: 50%; height: 18px;">Material</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaMaterial[$o['transaksi_material'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaFinishing = ['Tidak dipilih', 'Kait Oval', 'Kait HP', 'Kait Standar', 'Tambah Warna Sablon', 'Double Stopper', 'Stopper Tas'];
                                                $finishing = explode(',', $o['transaksi_finish'] ?? 0);
                                                $statusFinishing = "";
                                                foreach ($finishing as $f) {
                                                    $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$f];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Finishing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $jenisProduksi = ['Tidak dipilih', 'Sablon', 'Printing']; ?>
                                                <td style="width: 50%; height: 18px;">Jenis Produksi</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $jenisProduksi[$o['transaksi_jp'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p style="text-align: left;"><br> Aksesoris : <?= $o['transaksi_spkkartu_assesoris'] ?></p>
                                    <p style="text-align: left;">&nbsp;</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </page>
                <div class="modal-footer">
                    <button class="btn btn-primary status" data-toggle="modal" data-target="#status_printedit1">Edit</button>
                    <button class="btn btn-primary" id="printSpk">Print</button>
                </div>
                <div id="alert_status"></div>
                <div id="data_status"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="status_printedit1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <form class="modal-content" method="post" action="<?= base_url('Order/savespksales') ?>">
                <input type="hidden" name="id" value="<?= $this->uri->segment(3) ?>">
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
                                <p style="text-align: left;">Nama&nbsp; &nbsp; : <?= $o['pelanggan_nama'] ?><br />Tanggal :&nbsp;<?= $dt->format('d-m-Y H:i'); ?></p>
                                <?php if ($p['product_tipe'] == '0') : ?>
                                    <!-- Kartu -->
                                    <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                        <tbody>
                                            <tr style="height: 18px;">
                                                <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Kode Produk</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_kode'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Jenis Kartu</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_nama'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaPersonalisasi = ['Tidak dipilih', 'Blanko', 'Nomerator', 'Barcode', 'Data', 'Data + Foto'];
                                                $personalisasi = explode(',', $o['transaksi_personalisasi'] ?? 0);
                                                $statusPersonalisasi = "";
                                                foreach ($personalisasi as $pe) {
                                                    $statusPersonalisasi .= (!empty($statusPersonalisasi) ? ', ' : '') . $namaPersonalisasi[$pe];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Personalisasi</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusPersonalisasi; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Quantity</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_jumlah'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px; text-align: center;" colspan="2"><strong>Keterangan</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaCoating = ['Tidak dipilih', 'Glossy', 'Doff', 'Glossy + Doff', 'UV']; ?>
                                                <td style="width: 50%; height: 18px;">Coating</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaCoating[$o['transaksi_coating'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaFinishing = ['Tidak dipilih', 'Tidak ada', 'Urutkan', 'Label Gosok', 'Plong Oval', 'Plong Bulat', 'Urutkan', 'Emboss Silver', 'Emboss Gold', 'Panel', 'Hot', 'Swipe'];
                                                $finishing = explode(',', $o['transaksi_finishing'] ?? 0);
                                                $statusFinishing = "";
                                                foreach ($finishing as $f) {
                                                    $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$f];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Finishing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaFunction = ['Tidak dipilih', 'Print Thermal', 'Scan Barcode', 'Swipe Magnetic', 'Tap RFID']; ?>
                                                <td style="width: 50%; height: 18px;">Function</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaFunction[$o['transaksi_function'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaPackaging = ['Tidak dipilih', 'Plastik 1 on 1', 'Plastik Terpisah', 'Box Kartu Nama', 'Box Putih', 'Small UCARD', 'Small Maxi UCARD', 'Large UCARD', 'Large Maxi UCARD'];
                                                $packaging = explode(',', $o['transaksi_packaging'] ?? 0);
                                                $statusPackaging = "";
                                                foreach ($packaging as $pa) {
                                                    $statusPackaging .= (!empty($statusPackaging) ? ', ' : '') . $namaPackaging[$pa];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Packaging</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusPackaging; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p style="text-align: left;"><br> Aksesoris : <input type="text" name="assesoris" id="assesoris" placeholder="Masukkan keterangan" value="<?= $assesoris['transaksi_spkkartu_assesoris']; ?>"></p>
                                    <p style="text-align: left;">&nbsp;</p>
                                <?php elseif ($p['product_tipe'] == '1') : ?>
                                    <!-- Aksesoris -->
                                    <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                        <tbody>
                                            <tr style="height: 18px;">
                                                <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Kode Produk</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_kode'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Jenis Produk</td>
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
                                                <?php $yoyo = ['Tidak dipilih', 'Yoyo Putar', 'Yoyo Standar', 'Yoyo Transparan']; ?>
                                                <td style="width: 50%; height: 18px;">Yoyo</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $yoyo[$o['transaksi_yoyo'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $warna = ['Tidak dipilih', 'Hitam', 'Putih', 'Hijau', 'Biru', 'Merah', 'Kuning', 'Orange', 'Silver', 'Coklat', 'Hitam Transparan', 'Putih Transparan', 'Biru Transparan', 'Custom']; ?>
                                                <td style="width: 50%; height: 18px;">Warna</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $warna[$o['transaksi_warna'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $Casing = ['Tidak dipilih', 'Casing ID Card Acrylic', 'Casing ID Card Solid', 'Casing ID Card Karet', 'Casing ID Card Kulit']; ?>
                                                <td style="width: 50%; height: 18px;">Casing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $Casing[$o['transaksi_casing'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $CasingKaret = ['Tidak dipilih', 'Casing karet 1 sisi', 'Casing karet 2 sisi', 'Casing karet double landscape', 'Casing karet single landscape']; ?>
                                                <td style="width: 50%; height: 18px;">CasingKaret</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $CasingKaret[$o['transaksi_ck'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $LogoResin = ['Tidak memakai logo', 'Logo Resin']; ?>
                                                <td style="width: 50%; height: 18px;">Logo Resin</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $LogoResin[$o['transaksi_logo'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $penjepitBuaya = ['Tidak dipilih', 'Penjepit Buaya Besi', 'Penjepit Buaya Plastik']; ?>
                                                <td style="width: 50%; height: 18px;">Penjepit Buaya</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $penjepitBuaya[$o['transaksi_pb'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p style="text-align: left;"><br> Keterangan : <br><textarea name="keteranganspk" id="keteranganspk" placeholder="Masukan keterangan" rows="7"><?= $keteranganspk['transaksi_keterangan_accesoris'] ?></textarea>
                                    <p style="text-align: left;">&nbsp;</p>
                                <?php elseif ($p['product_tipe'] == '2') : ?>
                                    <!-- Tali -->
                                    <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                        <tbody>
                                            <tr style="height: 18px;">
                                                <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Kode Produk</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_kode'] ?></td>
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
                                                <?php $namaMaterial = ['Tidak dipilih', 'Polyester 1,5CM', 'Polyester 2CM', 'Polyester 2,5CM', 'Tissue 1,5CM', 'Tissue 2CM', 'Tissue 2,5CM', 'Tali gelang 1,5cm printing', 'Tali gelang 2cm printing']; ?>
                                                <td style="width: 50%; height: 18px;">Material</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaMaterial[$o['transaksi_material'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaFinishing = ['Tidak dipilih', 'Kait Oval', 'Kait HP', 'Kait Standar', 'Tambah Warna Sablon', 'Double Stopper', 'Stopper Tas'];
                                                $finishing = explode(',', $o['transaksi_finish'] ?? 0);
                                                $statusFinishing = "";
                                                foreach ($finishing as $f) {
                                                    $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$f];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Finishing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $jenisProduksi = ['Tidak dipilih', 'Sablon', 'Printing']; ?>
                                                <td style="width: 50%; height: 18px;">Jenis Produksi</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $jenisProduksi[$o['transaksi_jp'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p><br> Assesoris : <input type="text" name="assesoris" id="assesoris" placeholder="Masukkan keterangan" value="<?= $assesoris['transaksi_spkkartu_assesoris']; ?>"></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </page>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                <div id="alert_status"></div>
                <div id="data_status"></div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="spk_approval" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                <p style="text-align: left;"><strong> </strong><span style="text-decoration: underline;"><strong>SPK Approval</strong></span></p>
                                <?php if ($p['product_tipe'] == '0') : ?>
                                    <!-- Kartu -->
                                    <p style="text-align: left;">
                                        Nama&nbsp; &nbsp; : <?= $o['pelanggan_nama'] ?>
                                        <br />Quantity: <?= $o['transaksi_jumlah'] ?>
                                        <br />Tanggal : <?= $o['transaksi_tanggal'] ?>
                                        <br />Jumlah Lembar Awal/Akhir &nbsp; &nbsp;: <?= $o['transaksi_spkkartu_jumlahlembarawal'] ?? '0' ?> / <?= $o['transaksi_spkkartu_jumlahlembarakhir'] ?? '0' ?>
                                        <br />Jumlah Overlay Awal/Akhir &nbsp; : <?= $o['transaksi_spkkartu_jumlahoverlayawal'] ?? '0' ?> / <?= $o['transaksi_spkkartu_jumlahoverlayakhir'] ?? '0' ?>
                                        <br />Jumlah Chip Awal/Akhir&nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spkkartu_jumlahchipawal'] ?? '0' ?> / <?= $o['transaksi_spkkartu_jumlahchipakhir'] ?? '0' ?>
                                        <br />Jumlah Magnetic Awal/Akhir &nbsp;: <?= $o['transaksi_spkkartu_jumlahmagneticawal'] ?? '0' ?> / <?= $o['transaksi_spkkartu_jumlahmagneticakhir'] ?? '0' ?>
                                        <br />Jumlah Kartu Rusak &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; : <?= $o['transaksi_spkkartu_jumlahkarturusak'] ?? '0' ?>
                                        <br />Jumlah Lembar Rusak &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spkkartu_jumlahlembarrusak'] ?? '0' ?>
                                        <br />Operator&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_operator'] ?? 'Belum diatur'; ?>
                                    </p>
                                    <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                        <tbody>
                                            <tr style="height: 18px;">
                                                <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Kode Produk</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_kode'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Jenis Kartu</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_nama'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaPersonalisasi = ['Tidak dipilih', 'Blanko', 'Nomerator', 'Barcode', 'Data', 'Data + Foto'];
                                                $personalisasi = explode(',', $o['transaksi_personalisasi'] ?? 0);
                                                $statusPersonalisasi = "";
                                                foreach ($personalisasi as $pe) {
                                                    $statusPersonalisasi .= (!empty($statusPersonalisasi) ? ', ' : '') . $namaPersonalisasi[$pe];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Personalisasi</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusPersonalisasi; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Quantity</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_jumlah'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px; text-align: center;" colspan="2"><strong>Keterangan</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaCoating = ['Tidak dipilih', 'Glossy', 'Doff', 'Glossy + Doff', 'UV']; ?>
                                                <td style="width: 50%; height: 18px;">Coating</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaCoating[$o['transaksi_coating'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaFinishing = ['Tidak dipilih', 'Tidak ada', 'Urutkan', 'Label Gosok', 'Plong Oval', 'Plong Bulat', 'Urutkan', 'Emboss Silver', 'Emboss Gold', 'Panel', 'Hot', 'Swipe'];
                                                $finishing = explode(',', $o['transaksi_finishing'] ?? 0);
                                                $statusFinishing = "";
                                                foreach ($finishing as $f) {
                                                    $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$f];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Finishing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaFunction = ['Tidak dipilih', 'Print Thermal', 'Scan Barcode', 'Swipe Magnetic', 'Tap RFID']; ?>
                                                <td style="width: 50%; height: 18px;">Function</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaFunction[$o['transaksi_function'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaPackaging = ['Tidak dipilih', 'Plastik 1 on 1', 'Plastik Terpisah', 'Box Kartu Nama', 'Box Putih', 'Small UCARD', 'Small Maxi UCARD', 'Large UCARD', 'Large Maxi UCARD'];
                                                $packaging = explode(',', $o['transaksi_packaging'] ?? 0);
                                                $statusPackaging = "";
                                                foreach ($packaging as $pa) {
                                                    $statusPackaging .= (!empty($statusPackaging) ? ', ' : '') . $namaPackaging[$pa];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Packaging</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusPackaging; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />Tanggal/Jam Fix &nbsp; &nbsp; : <?= $o['transaksi_spk_tanggaljamfix'] ?? 'Belum diatur'; ?>
                                    <br />Kode Fix&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_kodefix'] ?? 'Belum diatur'; ?>
                                    <br />Speeling&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_speeling'] ?? 'Belum diatur'; ?>
                                    <br />Deadline&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_deadline'] ?? 'Belum diatur'; ?>
                                <?php elseif ($p['product_tipe'] == '1') : ?>
                                    <!-- Aksesoris -->
                                    <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                        <p style="text-align: left;">Nama&nbsp; &nbsp; : <?= $o['pelanggan_nama'] ?><br />Quantity: <?= $o['transaksi_jumlah'] ?><br />Tanggal : <?= $dt->format('d-m-Y H:i'); ?>
                                            <br>Operator: <?= $o['transaksi_spk_operator'] ?>
                                        </p>
                                        <tbody>
                                            <tr style="height: 18px;">
                                                <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Kode Produk</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_kode'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Jenis Produk</td>
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
                                                <?php $yoyo = ['Tidak dipilih', 'Yoyo Putar', 'Yoyo Standar', 'Yoyo Transparan']; ?>
                                                <td style="width: 50%; height: 18px;">Yoyo</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $yoyo[$o['transaksi_yoyo'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $warna = ['Tidak dipilih', 'Hitam', 'Putih', 'Hijau', 'Biru', 'Merah', 'Kuning', 'Orange', 'Silver', 'Coklat', 'Hitam Transparan', 'Putih Transparan', 'Biru Transparan', 'Custom']; ?>
                                                <td style="width: 50%; height: 18px;">Warna</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $warna[$o['transaksi_warna'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $Casing = ['Tidak dipilih', 'Casing ID Card Acrylic', 'Casing ID Card Solid', 'Casing ID Card Karet', 'Casing ID Card Kulit']; ?>
                                                <td style="width: 50%; height: 18px;">Casing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $Casing[$o['transaksi_casing'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $CasingKaret = ['Tidak dipilih', 'Casing karet 1 sisi', 'Casing karet 2 sisi', 'Casing karet double landscape', 'Casing karet single landscape']; ?>
                                                <td style="width: 50%; height: 18px;">CasingKaret</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $CasingKaret[$o['transaksi_ck'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $LogoResin = ['Tidak memakai logo', 'Logo Resin']; ?>
                                                <td style="width: 50%; height: 18px;">Logo Resin</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $LogoResin[$o['transaksi_logo'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $penjepitBuaya = ['Tidak dipilih', 'Penjepit Buaya Besi', 'Penjepit Buaya Plastik']; ?>
                                                <td style="width: 50%; height: 18px;">Penjepit Buaya</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $penjepitBuaya[$o['transaksi_pb'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>Tanggal/Jam Fix : <?= $o['transaksi_spk_tanggaljamfix'] ?? 'Belum diatur'; ?>
                                    <br>Kode Fix&nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_kodefix'] ?? 'Belum diatur'; ?>
                                    <br>Speeling&nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_speeling'] ?? 'Belum diatur'; ?>
                                    <br>Deadline&nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_deadline'] ?? 'Belum diatur'; ?>
                                <?php elseif ($p['product_tipe'] == '2') : ?>
                                    <!-- Tali -->
                                    <pre style="text-align: left;">Nama&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <?= $o['pelanggan_nama'] ?><br />Quantity&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $o['transaksi_jumlah'] ?><br />Tanggal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <?= $o['transaksi_tanggal'] ?>
                                        <br />Jumlah Tali Awal/Akhir &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;: <?= $o['transaksi_spk_jumlahtaliawal'] ?? '0'; ?> / <?= $o['transaksi_spk_jumlahtaliakhir'] ?? '0'; ?>
                                        <br />Jumlah Tali Stopper Awal/Akhir : <?= $o['transaksi_spk_jumlahtalistopperawal'] ?? '0'; ?> / <?= $o['transaksi_spk_jumlahtalistopperakhir'] ?? '0'; ?>
                                        <br />Jumlah Klem Awal/Akhir &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_jumlahklemawal'] ?? '0'; ?> / <?= $o['transaksi_spk_jumlahklemakhir'] ?? '0'; ?>
                                        <br />Jumlah Kait Awal/Akhir &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: <?= $o['transaksi_spk_jumlahkaitawal'] ?? '0'; ?> / <?= $o['transaksi_spk_jumlahkaitakhir'] ?? '0'; ?>
                                        <br />Jumlah Stopper Awal/Akhir &nbsp; &nbsp;&nbsp; : <?= $o['transaksi_spk_jumlahstopperawal'] ?? '0'; ?> / <?= $o['transaksi_spk_jumlahstopperakhir'] ?? '0'; ?>
                                        <br />Operator &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_operator'] ?? 'Belum diatur'; ?>
                                    </pre>
                                    <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                        <tbody>
                                            <tr style="height: 18px;">
                                                <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Kode Produk</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_kode'] ?></td>
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
                                                <?php $namaMaterial = ['Tidak dipilih', 'Polyester 1,5CM', 'Polyester 2CM', 'Polyester 2,5CM', 'Tissue 1,5CM', 'Tissue 2CM', 'Tissue 2,5CM', 'Tali gelang 1,5cm printing', 'Tali gelang 2cm printing']; ?>
                                                <td style="width: 50%; height: 18px;">Material</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaMaterial[$o['transaksi_material'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaFinishing = ['Tidak dipilih', 'Kait Oval', 'Kait HP', 'Kait Standar', 'Tambah Warna Sablon', 'Double Stopper', 'Stopper Tas'];
                                                $finishing = explode(',', $o['transaksi_finish'] ?? 0);
                                                $statusFinishing = "";
                                                foreach ($finishing as $f) {
                                                    $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$f];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Finishing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $jenisProduksi = ['Tidak dipilih', 'Sablon', 'Printing']; ?>
                                                <td style="width: 50%; height: 18px;">Jenis Produksi</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $jenisProduksi[$o['transaksi_jp'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />Tanggal/Jam Fix &nbsp; &nbsp; : <?= $o['transaksi_spk_tanggaljamfix'] ?? 'Belum diatur'; ?>
                                    <br />Kode Fix&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_kodefix'] ?? 'Belum diatur'; ?>
                                    <br />Speeling&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_speeling'] ?? 'Belum diatur'; ?>
                                    <br />Deadline&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_deadline'] ?? 'Belum diatur'; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </page>
                <div class="modal-footer">
                    <button class="btn btn-primary status" data-toggle="modal" data-target="#status_printedit2">Edit</button>
                    <button class="btn btn-primary" id="printSpk1">Print</button>
                </div>
                <div id="alert_status"></div>
                <div id="data_status"></div>
            </div>
        </div>
    </div>

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
                                <?php if ($p['product_tipe'] == '0') : ?>
                                    <!-- Kartu -->
                                    <?php
                                    $JLembarAwal = $this->db->query("SELECT transaksi_spkkartu_jumlahlembarawal FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $JLembarAkhir = $this->db->query("SELECT transaksi_spkkartu_jumlahlembarakhir FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $JOverlayAwal = $this->db->query("SELECT transaksi_spkkartu_jumlahoverlayawal FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $JOverlayAkhir = $this->db->query("SELECT transaksi_spkkartu_jumlahoverlayakhir FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $spkOperator = $this->db->query("SELECT transaksi_spk_operator FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $JChipAwal = $this->db->query("SELECT transaksi_spkkartu_jumlahchipawal FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $JChipAkhir = $this->db->query("SELECT transaksi_spkkartu_jumlahchipakhir FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $JLembarRusak = $this->db->query("SELECT transaksi_spkkartu_jumlahlembarrusak FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $JKartuRusak = $this->db->query("SELECT transaksi_spkkartu_jumlahkarturusak FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $JMagneticAwal = $this->db->query("SELECT transaksi_spkkartu_jumlahmagneticawal FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $JMagneticAkhir = $this->db->query("SELECT transaksi_spkkartu_jumlahmagneticakhir FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $tanggalJamFix = $this->db->query("SELECT transaksi_spk_tanggaljamfix FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $kodeFix = $this->db->query("SELECT transaksi_spk_kodefix FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $Speeling = $this->db->query("SELECT transaksi_spk_speeling FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $deadline = $this->db->query("SELECT transaksi_spk_deadline FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $noPenyelesaian = $this->db->query("SELECT transaksi_no_penyelesaian FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    ?>
                                    <p style="text-align: left;">Nama&nbsp; &nbsp; : <?= $o['pelanggan_nama'] ?><br />Quantity: <?= $o['transaksi_jumlah'] ?><br />Tanggal : <?= $o['transaksi_tanggal'] ?>
                                        <br />Jumlah Lembar Awal/Akhir &nbsp; &nbsp;: <input type="number" style="width: 7em" name="JLembarAwal" id="JLembarAwal" placeholder="Awal" value="<?= $JLembarAwal['transaksi_spkkartu_jumlahlembarawal']; ?>"> / <input type="number" style="width: 7em" name="JLembarAkhir" id="JLembarAkhir" placeholder="Akhir" value="<?= $JLembarAkhir['transaksi_spkkartu_jumlahlembarakhir']; ?>">
                                        <br />Jumlah Overlay Awal/Akhir &nbsp; : <input type="number" style="width: 7em" name="JOverlayAwal" id="JOverlayAwal" placeholder="Awal" value="<?= $JOverlayAwal['transaksi_spkkartu_jumlahoverlayawal']; ?>"> / <input type="number" style="width: 7em" name="JOverlayAkhir" id="JOverlayAkhir" placeholder="Akhir" value="<?= $JOverlayAkhir['transaksi_spkkartu_jumlahoverlayakhir']; ?>">
                                        <br />Jumlah Chip Awal/Akhir&nbsp; &nbsp; &nbsp; : <input type="number" style="width: 7em" name="JChipAwal" id="JChipAwal" placeholder="Awal" value="<?= $JChipAwal['transaksi_spkkartu_jumlahchipawal']; ?>"> / <input type="number" style="width: 7em" name="JChipAkhir" id="JChipAkhir" placeholder="Akhir" value="<?= $JChipAkhir['transaksi_spkkartu_jumlahchipakhir']; ?>">
                                        <br />Jumlah Magnetic Awal/Akhir &nbsp;: <input type="number" style="width: 7em" name="JMagneticAwal" id="JMagneticAwal" placeholder="Awal" value="<?= $JMagneticAwal['transaksi_spkkartu_jumlahmagneticawal']; ?>"> / <input type="number" style="width: 7em" name="JMagneticAkhir" id="JMagneticAkhir" placeholder="Akhir" value="<?= $JMagneticAkhir['transaksi_spkkartu_jumlahmagneticakhir']; ?>">
                                        <br />Jumlah Kartu Rusak &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; : <input type="number" name="JKartuRusak" id="JKartuRusak" placeholder="Masukkan Jumlah Kartu Rusak" value="<?= $JKartuRusak['transaksi_spkkartu_jumlahkarturusak']; ?>">
                                        <br />Jumlah Lembar Rusak &nbsp; &nbsp; &nbsp; &nbsp; : <input type="number" name="JLembarRusak" id="JLembarRusak" placeholder="Masukkan Jumlah Lembar Rusak" value="<?= $JLembarRusak['transaksi_spkkartu_jumlahlembarrusak']; ?>">
                                        <br />Operator&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <input type="text" name="spkoperator" id="spkOperator" placeholder="Masukkan nama operator" value="<?= $spkOperator['transaksi_spk_operator']; ?>">
                                    </p>
                                    <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                        <tbody>
                                            <tr style="height: 18px;">
                                                <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Kode Produk</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_kode'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Jenis Kartu</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_nama'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaPersonalisasi = ['Tidak dipilih', 'Blanko', 'Nomerator', 'Barcode', 'Data', 'Data + Foto'];
                                                $personalisasi = explode(',', $o['transaksi_personalisasi'] ?? 0);
                                                $statusPersonalisasi = "";
                                                foreach ($personalisasi as $pe) {
                                                    $statusPersonalisasi .= (!empty($statusPersonalisasi) ? ', ' : '') . $namaPersonalisasi[$pe];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Personalisasi</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusPersonalisasi; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Quantity</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_jumlah'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px; text-align: center;" colspan="2"><strong>Keterangan</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaCoating = ['Tidak dipilih', 'Glossy', 'Doff', 'Glossy + Doff', 'UV']; ?>
                                                <td style="width: 50%; height: 18px;">Coating</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaCoating[$o['transaksi_coating'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaFinishing = ['Tidak dipilih', 'Tidak ada', 'Urutkan', 'Label Gosok', 'Plong Oval', 'Plong Bulat', 'Urutkan', 'Emboss Silver', 'Emboss Gold', 'Panel', 'Hot', 'Swipe'];
                                                $finishing = explode(',', $o['transaksi_finishing'] ?? 0);
                                                $statusFinishing = "";
                                                foreach ($finishing as $f) {
                                                    $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$f];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Finishing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaFunction = ['Tidak dipilih', 'Print Thermal', 'Scan Barcode', 'Swipe Magnetic', 'Tap RFID']; ?>
                                                <td style="width: 50%; height: 18px;">Function</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaFunction[$o['transaksi_function'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaPackaging = ['Tidak dipilih', 'Plastik 1 on 1', 'Plastik Terpisah', 'Box Kartu Nama', 'Box Putih', 'Small UCARD', 'Small Maxi UCARD', 'Large UCARD', 'Large Maxi UCARD'];
                                                $packaging = explode(',', $o['transaksi_packaging'] ?? 0);
                                                $statusPackaging = "";
                                                foreach ($packaging as $pa) {
                                                    $statusPackaging .= (!empty($statusPackaging) ? ', ' : '') . $namaPackaging[$pa];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Packaging</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusPackaging; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />Tanggal/Jam Fix &nbsp; &nbsp; : <input type="datetime-local" name="tanggalJamFix" id="tanggalJamFix" value="<?= $tanggalJamFix['transaksi_spk_tanggaljamfix']; ?>">
                                    <br />Kode Fix&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <input type="text" name="kodeFix" id="kodeFix" placeholder="Masukkan Kode Fix" value="<?= $kodeFix['transaksi_spk_kodefix']; ?>">
                                    <br />Speeling&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <input type="text" name="Speeling" id="Speeling" placeholder="Masukkan Speeling" value="<?= $Speeling['transaksi_spk_speeling']; ?>">
                                    <br />Deadline&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <input type="date" name="deadline" id="deadline" value="<?= $deadline['transaksi_spk_deadline']; ?>">
                                <?php elseif ($p['product_tipe'] == '1') : ?>
                                    <!-- Aksesoris -->
                                    <?php
                                    $tanggalJamFix = $this->db->query("SELECT transaksi_spk_tanggaljamfix FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $kodeFix = $this->db->query("SELECT transaksi_spk_kodefix FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $Speeling = $this->db->query("SELECT transaksi_spk_speeling FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $deadline = $this->db->query("SELECT transaksi_spk_deadline FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $noPenyelesaian = $this->db->query("SELECT transaksi_no_penyelesaian FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    $spkOperator = $this->db->query("SELECT transaksi_spk_operator FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                                    ?>
                                    <p style="text-align: left;">Nama&nbsp; &nbsp; : <?= $o['pelanggan_nama'] ?><br />Quantity: <?= $o['transaksi_jumlah'] ?><br />Tanggal : <?= $dt->format('d-m-Y H:i'); ?>
                                        <br>Operator: <input type="text" name="spkoperator" id="spkOperator" placeholder="Masukkan nama operator" value="<?= $spkOperator['transaksi_spk_operator']; ?>">
                                    </p>
                                    <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                        <tbody>
                                            <tr style="height: 18px;">
                                                <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Kode Produk</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_kode'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Jenis Produk</td>
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
                                                <?php $yoyo = ['Tidak dipilih', 'Yoyo Putar', 'Yoyo Standar', 'Yoyo Transparan']; ?>
                                                <td style="width: 50%; height: 18px;">Yoyo</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $yoyo[$o['transaksi_yoyo'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $warna = ['Tidak dipilih', 'Hitam', 'Putih', 'Hijau', 'Biru', 'Merah', 'Kuning', 'Orange', 'Silver', 'Coklat', 'Hitam Transparan', 'Putih Transparan', 'Biru Transparan', 'Custom']; ?>
                                                <td style="width: 50%; height: 18px;">Warna</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $warna[$o['transaksi_warna'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $Casing = ['Tidak dipilih', 'Casing ID Card Acrylic', 'Casing ID Card Solid', 'Casing ID Card Karet', 'Casing ID Card Kulit']; ?>
                                                <td style="width: 50%; height: 18px;">Casing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $Casing[$o['transaksi_casing'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $CasingKaret = ['Tidak dipilih', 'Casing karet 1 sisi', 'Casing karet 2 sisi', 'Casing karet double landscape', 'Casing karet single landscape']; ?>
                                                <td style="width: 50%; height: 18px;">CasingKaret</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $CasingKaret[$o['transaksi_ck'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $LogoResin = ['Tidak memakai logo', 'Logo Resin']; ?>
                                                <td style="width: 50%; height: 18px;">Logo Resin</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $LogoResin[$o['transaksi_logo'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $penjepitBuaya = ['Tidak dipilih', 'Penjepit Buaya Besi', 'Penjepit Buaya Plastik']; ?>
                                                <td style="width: 50%; height: 18px;">Penjepit Buaya</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $penjepitBuaya[$o['transaksi_pb'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />Tanggal/Jam Fix : <input type="datetime-local" name="tanggalJamFix" id="tanggalJamFix" value="<?= $tanggalJamFix['transaksi_spk_tanggaljamfix']; ?>">
                                    <br />Kode Fix&nbsp; &nbsp; &nbsp; &nbsp; : <input type="text" name="kodeFix" id="kodeFix" placeholder="Masukkan Kode Fix" value="<?= $kodeFix['transaksi_spk_kodefix']; ?>">
                                    <br />Speeling&nbsp; &nbsp; &nbsp; &nbsp; : <input type="text" name="Speeling" id="Speeling" placeholder="Masukkan Speeling" value="<?= $Speeling['transaksi_spk_speeling']; ?>">
                                    <br />Deadline&nbsp; &nbsp; &nbsp; &nbsp; : <input type="date" name="deadline" id="deadline" value="<?= $deadline['transaksi_spk_deadline']; ?>">
                                <?php elseif ($p['product_tipe'] == '2') : ?>
                                    <!-- Tali -->
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
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_kode'] ?></td>
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
                                                <?php $namaMaterial = ['Tidak dipilih', 'Polyester 1,5CM', 'Polyester 2CM', 'Polyester 2,5CM', 'Tissue 1,5CM', 'Tissue 2CM', 'Tissue 2,5CM', 'Tali gelang 1,5cm printing', 'Tali gelang 2cm printing']; ?>
                                                <td style="width: 50%; height: 18px;">Material</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaMaterial[$o['transaksi_material'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaFinishing = ['Tidak dipilih', 'Kait Oval', 'Kait HP', 'Kait Standar', 'Tambah Warna Sablon', 'Double Stopper', 'Stopper Tas'];
                                                $finishing = explode(',', $o['transaksi_finish'] ?? 0);
                                                $statusFinishing = "";
                                                foreach ($finishing as $f) {
                                                    $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$f];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Finishing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $jenisProduksi = ['Tidak dipilih', 'Sablon', 'Printing']; ?>
                                                <td style="width: 50%; height: 18px;">Jenis Produksi</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $jenisProduksi[$o['transaksi_jp'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />Tanggal/Jam Fix &nbsp; &nbsp; : <input type="datetime-local" name="tanggalJamFix" id="tanggalJamFix" value="<?= $tanggalJamFix['transaksi_spk_tanggaljamfix']; ?>">
                                    <br />Kode Fix&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <input type="text" name="kodeFix" id="kodeFix" placeholder="Masukkan Kode Fix" value="<?= $kodeFix['transaksi_spk_kodefix']; ?>">
                                    <br />Speeling&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <input type="text" name="Speeling" id="Speeling" placeholder="Masukkan Speeling" value="<?= $Speeling['transaksi_spk_speeling']; ?>">
                                    <br />Deadline&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <input type="date" name="deadline" id="deadline" value="<?= $deadline['transaksi_spk_deadline']; ?>">
                                <?php endif; ?>
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
    <div class="modal fade" id="spk_produksi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                <p style="text-align: left;"><strong> </strong><span style="text-decoration: underline;"><strong>SPK Produksi</strong></span></p>
                                <?php if ($p['product_tipe'] == '0') : ?>
                                    <!-- Kartu -->
                                    <p style="text-align: left;">Nama&nbsp; &nbsp; : <?= $o['pelanggan_nama'] ?><br />Quantity: <?= $o['transaksi_jumlah'] ?><br />Tanggal : <?= $o['transaksi_tanggal'] ?>
                                        <br />Jumlah Lembar Awal/Akhir &nbsp; &nbsp;: <?= $o['transaksi_spkkartu_jumlahlembarawal'] ?> / <?= $o['transaksi_spkkartu_jumlahlembarakhir'] ?>
                                        <br />Jumlah Overlay Awal/Akhir &nbsp; : <?= $o['transaksi_spkkartu_jumlahoverlayawal'] ?> / <?= $o['transaksi_spkkartu_jumlahoverlayakhir'] ?>
                                        <br />Jumlah Chip Awal/Akhir&nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spkkartu_jumlahchipawal'] ?> / <?= $o['transaksi_spkkartu_jumlahchipakhir'] ?>
                                        <br />Jumlah Magnetic Awal/Akhir &nbsp;: <?= $o['transaksi_spkkartu_jumlahmagneticawal'] ?> / <?= $o['transaksi_spkkartu_jumlahmagneticakhir'] ?>
                                        <br />Jumlah Kartu Rusak &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; : <?= $o['transaksi_spkkartu_jumlahkarturusak'] ?>
                                        <br />Jumlah Lembar Rusak &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spkkartu_jumlahlembarrusak'] ?>
                                        <br />Operator&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_operator'] ?>
                                    </p>
                                    <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                        <tbody>
                                            <tr style="height: 18px;">
                                                <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Kode Produk</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_kode'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Jenis Kartu</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_nama'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaPersonalisasi = ['Tidak dipilih', 'Blanko', 'Nomerator', 'Barcode', 'Data', 'Data + Foto'];
                                                $personalisasi = explode(',', $o['transaksi_personalisasi'] ?? 0);
                                                $statusPersonalisasi = "";
                                                foreach ($personalisasi as $pe) {
                                                    $statusPersonalisasi .= (!empty($statusPersonalisasi) ? ', ' : '') . $namaPersonalisasi[$pe];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Personalisasi</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusPersonalisasi; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Quantity</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_jumlah'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px; text-align: center;" colspan="2"><strong>Keterangan</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaCoating = ['Tidak dipilih', 'Glossy', 'Doff', 'Glossy + Doff', 'UV']; ?>
                                                <td style="width: 50%; height: 18px;">Coating</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaCoating[$o['transaksi_coating'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaFinishing = ['Tidak dipilih', 'Tidak ada', 'Urutkan', 'Label Gosok', 'Plong Oval', 'Plong Bulat', 'Urutkan', 'Emboss Silver', 'Emboss Gold', 'Panel', 'Hot', 'Swipe'];
                                                $finishing = explode(',', $o['transaksi_finishing'] ?? 0);
                                                $statusFinishing = "";
                                                foreach ($finishing as $f) {
                                                    $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$f];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Finishing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaFunction = ['Tidak dipilih', 'Print Thermal', 'Scan Barcode', 'Swipe Magnetic', 'Tap RFID']; ?>
                                                <td style="width: 50%; height: 18px;">Function</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaFunction[$o['transaksi_function'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaPackaging = ['Tidak dipilih', 'Plastik 1 on 1', 'Plastik Terpisah', 'Box Kartu Nama', 'Box Putih', 'Small UCARD', 'Small Maxi UCARD', 'Large UCARD', 'Large Maxi UCARD'];
                                                $packaging = explode(',', $o['transaksi_packaging'] ?? 0);
                                                $statusPackaging = "";
                                                foreach ($packaging as $pa) {
                                                    $statusPackaging .= (!empty($statusPackaging) ? ', ' : '') . $namaPackaging[$pa];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Packaging</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusPackaging; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p style="text-align: left;">No.Penyelesain &nbsp; &nbsp; &nbsp;: <?= $o['transaksi_no_penyelesaian'] ?>
                                        <br />Deadline&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_deadline'] ?>
                                    </p>
                                <?php elseif ($p['product_tipe'] == '1') : ?>
                                    <!-- Aksesoris -->
                                    <p style="text-align: left;">Nama&nbsp; &nbsp; : <?= $o['pelanggan_nama'] ?><br />Quantity: <?= $o['transaksi_jumlah'] ?><br />Tanggal : <?= $o['transaksi_tanggal'] ?>
                                        <br />Operator &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_operator'] ?>
                                    </p>
                                    <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                        <tbody>
                                            <tr style="height: 18px;">
                                                <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Kode Produk</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_kode'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Jenis Produk</td>
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
                                                <?php $yoyo = ['Tidak dipilih', 'Yoyo Putar', 'Yoyo Standar', 'Yoyo Transparan']; ?>
                                                <td style="width: 50%; height: 18px;">Yoyo</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $yoyo[$o['transaksi_yoyo'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $warna = ['Tidak dipilih', 'Hitam', 'Putih', 'Hijau', 'Biru', 'Merah', 'Kuning', 'Orange', 'Silver', 'Coklat', 'Hitam Transparan', 'Putih Transparan', 'Biru Transparan', 'Custom']; ?>
                                                <td style="width: 50%; height: 18px;">Warna</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $warna[$o['transaksi_warna'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $Casing = ['Tidak dipilih', 'Casing ID Card Acrylic', 'Casing ID Card Solid', 'Casing ID Card Karet', 'Casing ID Card Kulit']; ?>
                                                <td style="width: 50%; height: 18px;">Casing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $Casing[$o['transaksi_casing'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $CasingKaret = ['Tidak dipilih', 'Casing karet 1 sisi', 'Casing karet 2 sisi', 'Casing karet double landscape', 'Casing karet single landscape']; ?>
                                                <td style="width: 50%; height: 18px;">CasingKaret</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $CasingKaret[$o['transaksi_ck'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $LogoResin = ['Tidak Memakai Logo', 'Logo Resin']; ?>
                                                <td style="width: 50%; height: 18px;">Logo Resin</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $LogoResin[$o['transaksi_logo'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $penjepitBuaya = ['Tidak dipilih', 'Penjepit Buaya Besi', 'Penjepit Buaya Plastik']; ?>
                                                <td style="width: 50%; height: 18px;">Penjepit Buaya</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $penjepitBuaya[$o['transaksi_pb'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p style="text-align: left;">No.Penyelesain &nbsp; &nbsp; &nbsp;: <?= $o['transaksi_no_penyelesaian'] ?>
                                        <br />Deadline&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_deadline'] ?>
                                    </p>
                                <?php elseif ($p['product_tipe'] == '2') : ?>
                                    <!-- Tali -->
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
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_kode'] ?></td>
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
                                                <?php $namaMaterial = ['Tidak dipilih', 'Polyester 1,5CM', 'Polyester 2CM', 'Polyester 2,5CM', 'Tissue 1,5CM', 'Tissue 2CM', 'Tissue 2,5CM', 'Tali gelang 1,5cm printing', 'Tali gelang 2cm printing']; ?>
                                                <td style="width: 50%; height: 18px;">Material</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaMaterial[$o['transaksi_material'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaFinishing = ['Tidak dipilih', 'Kait Oval', 'Kait HP', 'Kait Standar', 'Tambah Warna Sablon', 'Double Stopper', 'Stopper Tas'];
                                                $finishing = explode(',', $o['transaksi_finish'] ?? 0);
                                                $statusFinishing = "";
                                                foreach ($finishing as $f) {
                                                    $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$f];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Finishing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $jenisProduksi = ['Tidak dipilih', 'Sablon', 'Printing']; ?>
                                                <td style="width: 50%; height: 18px;">Jenis Produksi</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $jenisProduksi[$o['transaksi_jp'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p style="text-align: left;">No.Penyelesain &nbsp; &nbsp; &nbsp;: <?= $o['transaksi_no_penyelesaian'] ?>
                                        <br />Deadline&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_deadline'] ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary status" data-toggle="modal" data-target="#status_printedit3">Edit</button><br>
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
                                <?php if ($p['product_tipe'] == '0') : ?>
                                    <!-- Kartu -->
                                    <p style="text-align: left;">Nama&nbsp; &nbsp; : <?= $o['pelanggan_nama'] ?><br />Quantity: <?= $o['transaksi_jumlah'] ?><br />Tanggal : <?= $o['transaksi_tanggal'] ?>
                                        <br />Jumlah Lembar Awal/Akhir &nbsp; &nbsp;: <input type="number" style="width: 7em" name="JLembarAwalp" id="JLembarAwalp" placeholder="Awal" value="<?= $JLembarAwal['transaksi_spkkartu_jumlahlembarawal']; ?>"> / <input type="number" style="width: 7em" name="JLembarAkhirp" id="JLembarAkhirp" placeholder="Akhir" value="<?= $JLembarAkhir['transaksi_spkkartu_jumlahlembarakhir']; ?>">
                                        <br />Jumlah Overlay Awal/Akhir &nbsp; : <input type="number" style="width: 7em" name="JOverlayAwalp" id="JOverlayAwalp" placeholder="Awal" value="<?= $JOverlayAwal['transaksi_spkkartu_jumlahoverlayawal']; ?>"> / <input type="number" style="width: 7em" name="JOverlayAkhirp" id="JOverlayAkhirp" placeholder="Akhir" value="<?= $JOverlayAkhir['transaksi_spkkartu_jumlahoverlayakhir']; ?>">
                                        <br />Jumlah Chip Awal/Akhir&nbsp; &nbsp; &nbsp; : <input type="number" style="width: 7em" name="JChipAwalp" id="JChipAwalp" placeholder="Awal" value="<?= $JChipAwal['transaksi_spkkartu_jumlahchipawal']; ?>"> / <input type="number" style="width: 7em" name="JChipAkhirp" id="JChipAkhirp" placeholder="Akhir" value="<?= $JChipAkhir['transaksi_spkkartu_jumlahchipakhir']; ?>">
                                        <br />Jumlah Magnetic Awal/Akhir &nbsp;: <input type="number" style="width: 7em" name="JMagneticAwalp" id="JMagneticAwalp" placeholder="Awal" value="<?= $JMagneticAwal['transaksi_spkkartu_jumlahmagneticawal']; ?>"> / <input type="number" style="width: 7em" name="JMagneticAkhirp" id="JMagneticAkhirp" placeholder="Akhir" value="<?= $JMagneticAkhir['transaksi_spkkartu_jumlahmagneticakhir']; ?>">
                                        <br />Jumlah Kartu Rusak &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; : <input type="number" name="JKartuRusakp" id="JKartuRusakp" placeholder="Masukkan Jumlah Kartu Rusak" value="<?= $JKartuRusak['transaksi_spkkartu_jumlahkarturusak']; ?>">
                                        <br />Jumlah Lembar Rusak &nbsp; &nbsp; &nbsp; &nbsp; : <input type="number" name="JLembarRusakp" id="JLembarRusakp" placeholder="Masukkan Jumlah Lembar Rusak" value="<?= $JLembarRusak['transaksi_spkkartu_jumlahlembarrusak']; ?>">
                                        <br />Operator&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <input type="text" name="spkoperatorp" id="spkOperatorp" placeholder="Masukkan nama operator" value="<?= $spkOperator['transaksi_spk_operator']; ?>">
                                    </p>
                                    <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                        <tbody>
                                            <tr style="height: 18px;">
                                                <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Kode Produk</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_kode'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Jenis Kartu</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_nama'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaPersonalisasi = ['Tidak dipilih', 'Blanko', 'Nomerator', 'Barcode', 'Data', 'Data + Foto'];
                                                $personalisasi = explode(',', $o['transaksi_personalisasi'] ?? 0);
                                                $statusPersonalisasi = "";
                                                foreach ($personalisasi as $p) {
                                                    $statusPersonalisasi .= (!empty($statusPersonalisasi) ? ', ' : '') . $namaPersonalisasi[$p];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Personalisasi</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusPersonalisasi; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Quantity</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $o['transaksi_jumlah'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px; text-align: center;" colspan="2"><strong>Keterangan</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaCoating = ['Tidak dipilih', 'Glossy', 'Doff', 'Glossy + Doff', 'UV']; ?>
                                                <td style="width: 50%; height: 18px;">Coating</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaCoating[$o['transaksi_coating'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaFinishing = ['Tidak dipilih', 'Tidak ada', 'Urutkan', 'Label Gosok', 'Plong Oval', 'Plong Bulat', 'Urutkan', 'Emboss Silver', 'Emboss Gold', 'Panel', 'Hot', 'Swipe'];
                                                $finishing = explode(',', $o['transaksi_finishing'] ?? 0);
                                                $statusFinishing = "";
                                                foreach ($finishing as $p) {
                                                    $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$p];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Finishing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusFinishing; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaFunction = ['Tidak dipilih', 'Print Thermal', 'Scan Barcode', 'Swipe Magnetic', 'Tap RFID']; ?>
                                                <td style="width: 50%; height: 18px;">Function</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaFunction[$o['transaksi_function'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaPackaging = ['Tidak dipilih', 'Plastik 1 on 1', 'Plastik Terpisah', 'Box Kartu Nama', 'Box Putih', 'Small UCARD', 'Small Maxi UCARD', 'Large UCARD', 'Large Maxi UCARD'];
                                                $packaging = explode(',', $o['transaksi_packaging'] ?? 0);
                                                $statusPackaging = "";
                                                foreach ($packaging as $p) {
                                                    $statusPackaging .= (!empty($statusPackaging) ? ', ' : '') . $namaPackaging[$p];
                                                }
                                                ?>
                                                <td style="width: 50%; height: 18px;">Packaging</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $statusPackaging; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p style="text-align: left;">No.Penyelesain &nbsp; &nbsp; &nbsp;: <input type="text" name="noPenyelesaian" id="noPenyelesaian" placeholder="Masukkan no penyelesaian" value="<?= $noPenyelesaian['transaksi_no_penyelesaian']; ?>">
                                        <br />Deadline&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_deadline'] ?>
                                    </p>
                                <?php elseif ($p['product_tipe'] == '1') : ?>
                                    <!-- Aksesoris -->
                                    <p style="text-align: left;">Nama&nbsp; &nbsp; : <?= $o['pelanggan_nama'] ?><br />Quantity: <?= $o['transaksi_jumlah'] ?><br />Tanggal : <?= $o['transaksi_tanggal'] ?>
                                        <br />Operator &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <input type="text" name="spkoperatorp" id="spkOperatorp" placeholder="Masukkan nama operator" value="<?= $spkOperator['transaksi_spk_operator']; ?>">
                                    </p>
                                    <table style="border-collapse: collapse; width: 49.9029%; height: 198px;" border="1">
                                        <tbody>
                                            <tr style="height: 18px;">
                                                <td style="width: 100%; text-align: center; height: 18px;" colspan="2"><strong>General</strong></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Kode Produk</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_kode'] ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <td style="width: 50%; height: 18px;">Jenis Produk</td>
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
                                                <?php $yoyo = ['Tidak dipilih', 'Yoyo Putar', 'Yoyo Standar', 'Yoyo Transparan']; ?>
                                                <td style="width: 50%; height: 18px;">Yoyo</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $yoyo[$o['transaksi_yoyo'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $warna = ['Tidak dipilih', 'Hitam', 'Putih', 'Hijau', 'Biru', 'Merah', 'Kuning', 'Orange', 'Silver', 'Coklat', 'Hitam Transparan', 'Putih Transparan', 'Biru Transparan', 'Custom']; ?>
                                                <td style="width: 50%; height: 18px;">Warna</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $warna[$o['transaksi_warna'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $Casing = ['Tidak dipilih', 'Casing ID Card Acrylic', 'Casing ID Card Solid', 'Casing ID Card Karet', 'Casing ID Card Kulit']; ?>
                                                <td style="width: 50%; height: 18px;">Casing</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $Casing[$o['transaksi_casing'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $CasingKaret = ['Tidak dipilih', 'Casing karet 1 sisi', 'Casing karet 2 sisi', 'Casing karet double landscape', 'Casing karet single landscape']; ?>
                                                <td style="width: 50%; height: 18px;">CasingKaret</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $CasingKaret[$o['transaksi_ck'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $LogoResin = ['Tidak Memakai Logo', 'Logo Resin']; ?>
                                                <td style="width: 50%; height: 18px;">Logo Resin</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $LogoResin[$o['transaksi_logo'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $penjepitBuaya = ['Tidak dipilih', 'Penjepit Buaya Besi', 'Penjepit Buaya Plastik']; ?>
                                                <td style="width: 50%; height: 18px;">Penjepit Buaya</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $penjepitBuaya[$o['transaksi_pb'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p style="text-align: left;">No.Penyelesain &nbsp; &nbsp; &nbsp;: <input type="text" name="noPenyelesaian" id="noPenyelesaian" placeholder="Masukkan no penyelesaian" value="<?= $noPenyelesaian['transaksi_no_penyelesaian']; ?>">
                                        <br />Deadline&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_deadline'] ?>
                                    </p>
                                <?php elseif ($p['product_tipe'] == '2') : ?>
                                    <!-- Tali -->
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
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $y['product_kode'] ?></td>
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
                                                <?php $namaMaterial = ['Tidak dipilih', 'Polyester 1,5CM', 'Polyester 2CM', 'Polyester 2,5CM', 'Tissue 1,5CM', 'Tissue 2CM', 'Tissue 2,5CM', 'Tali gelang 1,5cm printing', 'Tali gelang 2cm printing']; ?>
                                                <td style="width: 50%; height: 18px;">Material</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaMaterial[$o['transaksi_material'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php
                                                $namaFinishing = ['Tidak dipilih', 'Kait Oval', 'Kait HP', 'Kait Standar', 'Tambah Warna Sablon', 'Double Stopper', 'Stopper Tas'];
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
                                                <?php $jenisProduksi = ['Tidak dipilih', 'Sablon', 'Printing']; ?>
                                                <td style="width: 50%; height: 18px;">Jenis Produksi</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $jenisProduksi[$o['transaksi_jp'] ?? 0]; ?></td>
                                            </tr>
                                            <tr style="height: 18px;">
                                                <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                                <td style="width: 50%; height: 18px;">Status</td>
                                                <td style="width: 50%; height: 18px;">&nbsp;<?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p style="text-align: left;">No.Penyelesain &nbsp; &nbsp; &nbsp;: <input type="text" name="noPenyelesaian" id="noPenyelesaian" placeholder="Masukkan no penyelesaian" value="<?= $noPenyelesaian['transaksi_no_penyelesaian']; ?>">
                                        <br />Deadline&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?= $o['transaksi_spk_deadline'] ?>
                                    </p>
                                <?php endif; ?>
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
    <div id="printThis2" style="display: none;">
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
        var url = document.URL.substring(0, document.URL.lastIndexOf('#'));
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
        var url = document.URL.substring(0, document.URL.lastIndexOf('#'));
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
        var url = document.URL.substring(0, document.URL.lastIndexOf('#'));
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

    $('#savespkapv').click(function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: "<?= base_url('Order/savespkapv') ?>",
            data: {
                id: $('#id').val(),
                JLembarAwal: $('#JLembarAwal').val(),
                JLembarAkhir: $('#JLembarAkhir').val(),
                JOverlayAwal: $('#JOverlayAwal').val(),
                JOverlayAkhir: $('#JOverlayAkhir').val(),
                JChipAwal: $('#JChipAwal').val(),
                JChipAkhir: $('#JChipAkhir').val(),
                JMagneticAwal: $('#JMagneticAwal').val(),
                JMagneticAkhir: $('#JMagneticAkhir').val(),
                JKartuRusak: $('#JKartuRusak').val(),
                JLembarRusak: $('#JLembarRusak').val(),
                spkOperator: $('#spkOperator').val(),
                tanggalJamFix: $('#tanggalJamFix').val(),
                kodeFix: $('#kodeFix').val(),
                Speeling: $('#Speeling').val(),
                deadline: $('#deadline').val(),
                noPenyelesaian: $('#noPenyelesaian').val(),
                JTaliAwal: $('#JTaliAwal').val(),
                JTaliAkhir: $('#JTaliAkhir').val(),
                JTaliStopperAwal: $('#JTaliStopperAwal').val(),
                JTaliStopperAkhir: $('#JTaliStopperAkhir').val(),
                JKlemAwal: $('#JKlemAwal').val(),
                JKlemAkhir: $('#JKlemAkhir').val(),
                JKaitAwal: $('#JKaitAwal').val(),
                JKaitAkhir: $('#JKaitAkhir').val(),
                JStopperAwal: $('#JStopperAwal').val(),
                JStopperAkhir: $('#JStopperAkhir').val(),
            },
            success: function(data) {
                window.location = '<?= base_url('Order/detail/' . $this->uri->segment(3) . '#status_print4') ?>';
                location.reload();
            }
        });
    });

    $('#savespkprdksi').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "<?= base_url('Order/savespkprdksi') ?>",
            data: {
                id: $('#id').val(),
                JLembarAwal: $('#JLembarAwalp').val(),
                JLembarAkhir: $('#JLembarAkhirp').val(),
                JOverlayAwal: $('#JOverlayAwalp').val(),
                JOverlayAkhir: $('#JOverlayAkhirp').val(),
                JChipAwal: $('#JChipAwalp').val(),
                JChipAkhir: $('#JChipAkhirp').val(),
                JMagneticAwal: $('#JMagneticAwalp').val(),
                JMagneticAkhir: $('#JMagneticAkhirp').val(),
                JKartuRusak: $('#JKartuRusakp').val(),
                JLembarRusak: $('#JLembarRusakp').val(),
                spkOperator: $('#spkOperatorp').val(),
                tanggalJamFix: $('#tanggalJamFix').val(),
                kodeFix: $('#kodeFix').val(),
                Speeling: $('#Speeling').val(),
                deadline: $('#deadline').val(),
                noPenyelesaian: $('#noPenyelesaian').val(),
                JTaliAwal: $('#JTaliAwalp').val(),
                JTaliAkhir: $('#JTaliAkhirp').val(),
                JTaliStopperAwal: $('#JTaliStopperAwalp').val(),
                JTaliStopperAkhir: $('#JTaliStopperAkhirp').val(),
                JKlemAwal: $('#JKlemAwalp').val(),
                JKlemAkhir: $('#JKlemAkhirp').val(),
                JKaitAwal: $('#JKaitAwalp').val(),
                JKaitAkhir: $('#JKaitAkhirp').val(),
                JStopperAwal: $('#JStopperAwalp').val(),
                JStopperAkhir: $('#JStopperAkhirp').val(),
            },
            success: function(data) {
                window.location = '<?= base_url('Order/detail/' . $this->uri->segment(3) . '#spk_produksi') ?>';
                location.reload();
            }
        });
    });
</script>
<script>
    document.getElementById("printSpk").onclick = function() {
        printElement(document.getElementById("printThis"));
        $('#printThis2').show();
        printElement(document.getElementById("printThis2"), true, "<hr>");
        $('#printThis2').hide();
        window.print();
    }
    document.getElementById("printSpk1").onclick = function() {
        printElement(document.getElementById("printThis3"));
        $('#printThis2').show();
        printElement(document.getElementById("printThis2"), true, "<hr />");
        $('#printThis2').hide();
        window.print();
    }
    document.getElementById("printSpk2").onclick = function() {
        printElement(document.getElementById("printThis4"));
        $('#printThis2').show();
        printElement(document.getElementById("printThis2"), true, "<hr />");
        $('#printThis2').hide();
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