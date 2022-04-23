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

    .btnreviewcenter {
        text-align: center;
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
                            $id_status = $s['status_id'];
                            $st = $this->db->query("SELECT * FROM tbl_status_transaksi WHERE transaksi_order_id = '$id_transaksi' AND transaksi_status_id = '$id_status' ORDER BY transaksi_id DESC ")->row_array();
                            $verif = $this->db->query("SELECT * FROM tbl_verifikasi WHERE transaksi_id = '$id_transaksi';")->row_array();
                            ?>
                            <?php if (!empty($st) && ($st['transaksi_status'] == NULL || $st['transaksi_status'] == '2')) : ?>
                                <div class="timeline-block">
                                    <span style="background-color: blue;color: white;" class="timeline-step badge-success">
                                        <i class="<?= $s['status_icon'] ?>"></i>
                                    </span>
                                    <div class="timeline-content">
                                        <a type="button" class="tablinks" onclick="status(event, 'status<?= $s['status_id'] ?>')" id="defaultOpen"><b class="font-weight-bold"><?= $s['status_status'] ?></b></a>
                                        <p class=" text-sm mt-1 mb-0"><?= $s['status_keterangan'] ?></p>
                                        <?php if ($s['status_jangka_waktu'] != NULL) : ?>
                                            <?php if ($st['transaksi_status'] == '4') : ?>
                                                <b>Sudah lewat tanggal</b>
                                            <?php else : ?>
                                                <strong>Kirim sebelum:</strong>
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
                                        $max = $this->db->query("SELECT MAX(transaksi_status_id) AS akhir FROM tbl_status_transaksi WHERE transaksi_order_id = '$id_transaksi'  ")->row_array();
                                        if ($s['status_id'] == $max['akhir']) :
                                        ?>
                                            <a type="button" class="tablinks" onclick="status(event, 'status<?= $s['status_id'] ?>')" id="defaultOpen"><b class="font-weight-bold"><?= $s['status_status'] . (!empty($verif['verif_kirimambil']) ? " ($verif[verif_kirimambil])" : "") ?></b></a>
                                        <?php else : ?>
                                            <?php
                                            $verifikator = "";
                                            switch ($s['status_id']) {
                                                case "1":
                                                    $verifikator = !empty($verif['verif_pesanan']) ? $verif['verif_pesanan'] : "-";
                                                    break;
                                                case "2":
                                                    $verifikator = !empty($verif['verif_desain']) ? $verif['verif_desain'] : "-";
                                                    break;
                                                case "3":
                                                    $verifikator = !empty($verif['verif_pembayaran']) ? $verif['verif_pembayaran'] : "-";
                                                    break;
                                                case "4":
                                                    $verifikator = !empty($verif['verif_approval']) ? $verif['verif_approval'] : "-";
                                                    break;
                                                case "5":
                                                    $verifikator = !empty($verif['verif_produksi']) ? $verif['verif_produksi'] : "-";
                                                    break;
                                                default:
                                                    $verifikator = "admin";
                                            }
                                            ?>
                                            <a type="button" class="tablinks" onclick="status(event, 'status<?= $s['status_id'] ?>')"><b class="font-weight-bold"><?= $s['status_status'] . (!empty($verifikator) ? " ($verifikator)" : "") ?></b></a>
                                        <?php endif; ?>
                                        <p class=" text-sm mt-1 mb-0"><?= $s['status_keterangan'] ?></p>
                                        <div class="mt-3">
                                            <span class="badge badge-pill badge-success">Diterima</span>
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
                                        <a type="button" class="tablinks" onclick="status(event, 'status<?= $s['status_id'] ?>')" id="defaultOpen"><b class="font-weight-bold"><?= $s['status_status'] ?></b></a>
                                        <p class=" text-sm mt-1 mb-0"><?= $s['status_keterangan'] ?></p>
                                        <?php if ($s['status_jangka_waktu'] != NULL) : ?>
                                            <?php if ($st['transaksi_status'] == '4') : ?>
                                                <b>Sudah lewat tanggal</b>
                                            <?php else : ?>
                                                <strong>Kirim sebelum</strong>
                                                <b><?= date('d/m/Y H:m', $st['transaksi_tanggal_hangus']) ?></b>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <div class="mt-3">
                                            <span class="badge badge-pill badge-danger">Ditolak</span>
                                            <p class="text-sm mt-2">
                                                <?= $st['transaksi_keterangan'] ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="timeline-block">
                                    <span style="background-color: grey; color: white;" class="timeline-step badge-success">
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
        <div class="col-lg-6 <?= $o['transaksi_terima'] == '0' ? 'd-none' : ''; ?>">
            <div id="status1" class="tabcontent">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="row">
                            <div class="col">
                                <div class="text-left">
                                    <h3 class="mb-0">Produk</h3>
                                </div>
                            </div>
                            <?php
                            $st = $this->db
                                ->select('transaksi_status_id')
                                ->where('transaksi_order_id', $id_transaksi)
                                ->order_by('transaksi_id', 'DESC')
                                ->limit(1)
                                ->get('tbl_status_transaksi')
                                ->row_array();
                            ?>
                            <?php if (($o['transaksi_terima'] == '0' || $o['transaksi_terima'] == null) && $st['transaksi_status_id'] == '1') : ?>
                                <div class="col">
                                    <div class="text-right">
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#perbaikan">
                                            Perbaikan <i class="fa fa-pen"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid" style="padding: 0 !important;">
                            <b>Nama Produk</b>
                            <p><?= $p['product_nama']; ?></p>
                            <b>Deskripsi</b>
                            <p><?= $p['product_deskripsi']; ?></p>
                            <b>Keunggulan</b>
                            <p><?= $p['product_keunggulan']; ?></p>
                            <b>Keterangan Produk</b>
                            <p><?= !empty($p['product_keterangan']) && !is_null($p['product_keterangan']) ? $p['product_keterangan'] : 'Tidak ada keterangan'; ?></p>
                            <!--<b>Harga satuan</b>
                            <p><//?= 'Rp' . number_format($p['product_harga'] ?? 0, 2, ',', '.'); 
                                ?></p>-->
                            <b>Jumlah dipesan</b>
                            <p><?= $o['transaksi_jumlah']; ?></p>
                            <!--<b>Total dipesan</b>
                            <p><//?= 'Rp' . number_format($o['transaksi_harga'] ?? 0, 2, ',', '.'); 
                                ?></p>-->
                            <b>Keterangan Pesanan</b>
                            <p><?= !empty($o['transaksi_keterangan']) && !is_null($o['transaksi_keterangan']) ? $o['transaksi_keterangan'] : 'Tidak ada keterangan'; ?></p>
                            <b>Kustomisasi</b>
                            <?php if ($p['product_tipe'] == '0') : ?>
                                <!-- Kartu -->
                                <div class="grid-container">
                                    <div class="grid-item p-0 pb-3">
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
                                    <div class="grid-item p-0 pb-3">
                                        <?php $namaCoating = ['Tidak dipilih', 'Glossy', 'Doff', 'Glossy + Doff', 'UV']; ?>
                                        <b>Coating</b>
                                        <p><?= $namaCoating[$o['transaksi_coating'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
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
                                    <div class="grid-item p-0 pb-3">
                                        <?php $namaFunction = ['Tidak dipilih', 'Print Thermal', 'Scan Barcode', 'Swipe Magnetic', 'Tap RFID']; ?>
                                        <b>Function</b>
                                        <p><?= $namaFunction[$o['transaksi_function'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
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
                                    <div class="grid-item p-0 pb-3">
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
                                        <p><?= $yoyo[$o['transaksi_yoyo'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $warna = ['Tidak dipilih', 'Hitam', 'Putih', 'Hijau', 'Biru', 'Merah', 'Kuning', 'Orange', 'Silver', 'Coklat', 'Hitam Transparan', 'Putih Transparan', 'Biru Transparan', 'Custom']; ?>
                                        <b>Warna</b>
                                        <p><?= $warna[$o['transaksi_warna'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $Casing = ['Tidak dipilih', 'Casing ID Card Acrylic', 'Casing ID Card Solid', 'Casing ID Card Karet', 'Casing ID Card Kulit']; ?>
                                        <b>Casing</b>
                                        <p><?= $Casing[$o['transaksi_casing'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $CasingKaret = ['Tidak dipilih', 'Casing karet 1 sisi', 'Casing karet 2 sisi', 'Casing karet double landscape', 'Casing karet single landscape']; ?>
                                        <b>Casing Karet</b>
                                        <p><?= $CasingKaret[$o['transaksi_ck'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $LogoResin = ['Tidak memakai logo', 'Logo Resin']; ?>
                                        <b>Logo Resin</b>
                                        <p><?= $LogoResin[$o['transaksi_logo'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $penjepitBuaya = ['Tidak dipilih', 'Penjepit Buaya Besi', 'Penjepit Buaya Plastik']; ?>
                                        <b>Penjepit Buaya</b>
                                        <p><?= $penjepitBuaya[$o['transaksi_pb'] ?? 0]; ?></p>
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
                                    <div class="grid-item p-0 pb-3">
                                        <?php $namaMaterial = ['Tidak dipilih', 'Polyester 1,5CM', 'Polyester 2CM', 'Polyester 2,5CM', 'Tissue 1,5CM', 'Tissue 2CM', 'Tissue 2,5CM', 'Tali gelang 1,5cm printing', 'Tali gelang 2cm printing']; ?>
                                        <b>Material</b>
                                        <p><?= $namaMaterial[$o['transaksi_material'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php
                                        $namaFinishing = ['Tidak dipilih', 'Kait Oval', 'Kait Tebal', 'Kait HP', 'Kait Standar', 'Tambah Warna Sablon', 'Double Stopper', 'Stopper Tas', 'Stopper Rotate', 'Jahit', 'Tali Karung', 'Ring Vape'];
                                        $finishing = explode(',', $o['transaksi_finish'] ?? 0);
                                        $statusFinishing = "";
                                        foreach ($finishing as $f) {
                                            $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$f];
                                        }
                                        ?>
                                        <b>Finishing</b>
                                        <p><?= $statusFinishing; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $jenisProduksi = ['Tidak dipilih', 'Sablon', 'Printing']; ?>
                                        <b>Jenis Produksi</b>
                                        <p><?= $jenisProduksi[$o['transaksi_jp'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                        <b>Ambil/Kirim</b>
                                        <p><?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></p>
                                    </div>
                                </div>
                            <?php elseif ($p['product_tipe'] == '3') : ?>
                                <div class="grid-container">
                                    <div class="grid-item p-0 pb-3">
                                        <?php $namaBank = ['Tidak dipilih', 'Bank BCA (Flazz)', 'Bank Mandiri (E-Toll)', 'Bank BRI (Brizzi)', 'Bank BNI (Tapcash)']; ?>
                                        <b>Bank</b>
                                        <p>&nbsp;<?= $namaBank[$o['transaksi_spk_bank'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $Print = ['Tidak dipilih', '1 Sisi', '2 Sisi']; ?>
                                        <b>Print</b>
                                        <p>&nbsp;<?= $Print[$o['transaksi_spk_print'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
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
                                    <div class="grid-item p-0 pb-3">
                                        <?php
                                        $namaPackaging = ['Tidak dipilih', 'Plastik 1 on 1', 'Box Putih', 'Small UCARD', 'Small Maxi UCARD', 'Large UCARD', 'Large Maxi UCARD'];
                                        $packaging = explode(',', $o['transaksi_packaging'] ?? 0);
                                        $statusPackaging = "";
                                        foreach ($packaging as $pa) {
                                            $statusPackaging .= (!empty($statusPackaging) ? ', ' : '') . $namaPackaging[$pa];
                                        }
                                        ?>
                                        <b>Packaging</b>
                                        <p><?= $statusPackaging; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $namaCoating = ['Tidak dipilih', 'UV']; ?>
                                        <b>Coating</b>
                                        <p><?= $namaCoating[$o['transaksi_coating'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php
                                        $namaFinishing = ['Tidak dipilih', 'Tidak Ada', 'Urutkan', 'Pakai NO', 'Tanpa NO'];
                                        $finishing = explode(',', $o['transaksi_finishing'] ?? 0);
                                        $statusFinishing = "";
                                        foreach ($finishing as $f) {
                                            $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$f];
                                        }
                                        ?>
                                        <b>Finishing</b>
                                        <p>&nbsp;<?= $statusFinishing; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                        <b>Ambil/Kirim</b>
                                        <p><?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></p>
                                    </div>
                                </div>
                            <?php elseif ($p['product_tipe'] == '4') : ?>
                                <div class="grid-container">
                                    <div class="grid-item p-0 pb-3">
                                        <?php $namaVarian = ['Tidak dipilih', 'USB Flashdisk Card 8 GB', 'USB Flashdisk Card 16 GB']; ?>
                                        <b>Varian</b>
                                        <p>&nbsp;<?= $namaVarian[$o['transaksi_spk_varian'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $Print = ['Tidak dipilih', '1 Sisi', '2 Sisi']; ?>
                                        <b>Print</b>
                                        <p>&nbsp;<?= $Print[$o['transaksi_spk_print'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
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
                                    <div class="grid-item p-0 pb-3">
                                        <?php
                                        $namaPackaging = ['Tidak dipilih', 'Plastik 1 on 1', 'Box Putih', 'Small UCARD', 'Small Maxi UCARD', 'Large UCARD', 'Large Maxi UCARD'];
                                        $packaging = explode(',', $o['transaksi_packaging'] ?? 0);
                                        $statusPackaging = "";
                                        foreach ($packaging as $pa) {
                                            $statusPackaging .= (!empty($statusPackaging) ? ', ' : '') . $namaPackaging[$pa];
                                        }
                                        ?>
                                        <b>Packaging</b>
                                        <p><?= $statusPackaging; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $namaCoating = ['Tidak dipilih', 'UV']; ?>
                                        <b>Coating</b>
                                        <p><?= $namaCoating[$o['transaksi_coating'] ?? 0]; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php
                                        $namaFinishing = ['Tidak dipilih', 'Tidak Ada', 'Urutkan'];
                                        $finishing = explode(',', $o['transaksi_finishing'] ?? 0);
                                        $statusFinishing = "";
                                        foreach ($finishing as $f) {
                                            $statusFinishing .= (!empty($statusFinishing) ? ', ' : '') . $namaFinishing[$f];
                                        }
                                        ?>
                                        <b>Finishing</b>
                                        <p>&nbsp;<?= $statusFinishing; ?></p>
                                    </div>
                                    <div class="grid-item p-0 pb-3">
                                        <?php $namaPaket = ['Tidak dipilih', 'Kirim Produk', 'Ambil Sendiri']; ?>
                                        <b>Ambil/Kirim</b>
                                        <p><?= $namaPaket[$o['transaksi_paket'] ?? 0]; ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="status2" class="tabcontent">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0">Kirim Desain</h3>
                    </div>
                    <div class="card-body">
                        <p>
                            Jika ukuran file terlalu besar silahkan upload ke file hosting lalu masukkan link ke kolom Link File.
                            <br>Jika sudah silahkan tunggu sampai Admin memverifikasi desain Anda.
                        </p>
                        <hr>
                        <?php if ($o['transaksi_terima'] !== '1') : ?>
                            <form method="post" action="<?= base_url('Order_pelanggan/upload_design') ?>" enctype="multipart/form-data">
                                <h3>Unggah Desain</h3>
                                <input type="file" class="form-control" multiple name="design[]">
                                <input type="hidden" value="<?= $this->uri->segment(3) ?>" name="id_transaksi">
                                <br>
                                <button type="submit" style="width: 100%;" class="btn btn-primary">Kirim</button>
                            </form>
                            <hr>
                        <?php endif ?>
                        <?php
                        $id = $this->uri->segment(3);
                        $design = $this->db->query("SELECT * FROM tbl_user_design WHERE design_transaksi_id = '$id' ")->result_array();
                        $upload = $this->db->query("SELECT * FROM tbl_design_kirim WHERE design_transaksi_id = '$id' ")->result_array();
                        if ($design) : ?>
                            <h3>Desain Anda</h3>
                            <br>
                            <?php
                            foreach ($design as $d) :
                            ?>
                                <a title="<?= $d['design_id'] ?>" id="modal_lihat" type="button" class="modal_lihat" data-toggle="modal" data-target="#lihat"><img style="width:100%;" src="<?= base_url('design_user/' . $d['design_image']) ?>" alt=""></a>
                                <hr>
                        <?php
                            endforeach;
                        endif;
                        ?>
                        <?php if ($upload) : ?>
                            <h3>Desain Terunggah</h3>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-flush">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama File</th>
                                            <th>Lihat</th>
                                            <th>Unduh</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($upload as $u) : ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $u['design_image']; ?></td>
                                                <td><a href="<?= base_url('design_user/' . $u['design_image']) ?>" target="_blank">Lihat</a></td>
                                                <td><a href="<?= base_url('design_user/' . $u['design_image']) ?>" download>Unduh</a></td>
                                                <td><a id="<?= $u['design_id'] ?>" type="button" class="hapus" data-toggle="modal" data-target="#hapus" style="color:red;">Hapus</a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        endif;
                        ?>
                        <?php
                        $link = $this->db->query("SELECT transaksi_link_desain FROM tbl_transaksi WHERE transaksi_id='$id';")->row_array();
                        ?>
                        <hr>
                        <h3>Link File</h3>
                        <form method="post" action="<?= base_url('Order_pelanggan/update_link'); ?>" class="form-group row">
                            <input type="hidden" name="transaksi_id" value="<?= $id; ?>">
                            <div class="col-sm-9 pr-1">
                                <input type="text" class="form-control" name="link" placeholder="Masukkan link file" value="<?= $link['transaksi_link_desain']; ?>">
                            </div>
                            <div class="col-sm-3 pl-1">
                                <button type="submit" class="btn btn-primary mb-2 w-100">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="status3" class="tabcontent">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0">Pembayaran</h3>
                    </div>
                    <div class="card-body">
                        <p>Silahkan melakukan transfer ke rekening di bawah sesuai harga yang telah disepakati.</p>
                        <hr>
                        <b>Pilih metode pengiriman pesanan Anda</b>
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
                        <hr>
                        <?php $total = $o['transaksi_paket'] == '1' ? $o['transaksi_harga'] + $o['transaksi_ongkir'] : $o['transaksi_harga']; ?>
                        <?php $k = @$this->db->where('kupon_id', $o['transaksi_kupon_id'])->get('tbl_kupon')->row_array(); ?>
                        <?php $diskon = @$k['kupon_fixed'] ? $k['kupon_fixed'] : $o['transaksi_harga'] * @$k['kupon_persentase'] / 100; ?>
                        <?php if ($o['transaksi_harga'] == NULL || $o['transaksi_harga'] == '0') : ?>
                            <h3>Harga belum ditentukan. Harap tunggu sampai Admin menentukan harga yang perlu Anda bayar.</h3>
                        <?php else : ?>
                            <h3>Kupon</h3>
                            <p>Punya kupon? Masukkan di sini!</p>
                            <div class="form-group">
                                <input class="form-control" style="text-transform: uppercase;" type="text" id="kupon" placeholder="Masukkan kupon di sini" value="<?= @$k['kupon_kode']; ?>">
                                <br>
                                <button class="btn btn-primary w-100" id="btn-kupon">Cek</button>
                            </div>
                            <hr id="part-bayar">
                            <h3>Perhitungan Harga</h3>
                            <b>Subtotal</b>
                            <p id="subtotal">Rp<?= number_format($o['transaksi_harga'] ?? 0, 2, ',', '.') ?></p>
                            <b>Diskon</b>
                            <p id="diskon">Rp<?= number_format($diskon ?? 0, 2, ',', '.') ?></p>
                            <?php if ($o['transaksi_paket'] == '1') : ?>
                                <b>Ongkir</b>
                                <p>Rp<?= number_format($o['transaksi_ongkir'] ?? 0, 2, ',', '.') ?></p>
                            <?php endif ?>
                            <b>Total dibayar <?= $total >= 1000000 ? 'jika lunas' : ''; ?></b>
                            <p id="total">Rp<?= number_format($o['transaksi_kupon_id'] ? $total - $diskon : $total ?? 0, 2, ',', '.') ?></p>
                            <input type="hidden" id="total_perlu_dibayar" value="<?= $total; ?>">
                            <?php if ($total >= 1000000) : ?>
                                <b>Total perlu dibayar jika DP/uang muka</b>
                                <p>Rp<?= number_format($total * 0.5 ?? 0, 2, ',', '.') ?></p>
                            <?php endif; ?>

                        <?php endif ?>
                        <hr>
                        <?php
                        $id = $this->uri->segment(3);
                        $pembayaran = $this->db->query("SELECT * FROM tbl_pembayaran WHERE pembayaran_transaksi_id = '$id' ")->result_array();
                        ?>
                        <h3>Bukti Transfer</h3>
                        <div class="table-responsive">
                            <table class="table table-flush" id="datatable-basic">
                                <thead>
                                    <tr>
                                        <td>Atas Nama</td>
                                        <td>Bank</td>
                                        <td>Jumlah Yang Ditransfer</td>
                                        <td>Tanggal</td>
                                        <td>Download</td>
                                        <td>Hapus</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($pembayaran) : ?>
                                        <?php foreach ($pembayaran as $pem) : ?>
                                            <tr>
                                                <td><?php echo $pem['pembayaran_atas_nama']; ?></td>
                                                <?php $pembank = ['Tunai', 'BCA', 'Mandiri', 'BRI']; ?>
                                                <td><?= $pembank[$pem['pembayaran_bank'] ?? 0]; ?></td>
                                                <td><?php echo $pem['pembayaran_nominal']; ?></td>
                                                <?php $dt = new DateTime("@$pem[pembayaran_tgl]"); ?>
                                                <td><?= $dt->format('d-m-Y'); ?></td>
                                                <td><a href="<?= base_url('bukti_transaksi/' . $pem['pembayaran_file']) ?>" download>Unduh</a></td>
                                                <td><a id="<?= $pem['pembayaran_id'] ?>" type="button" class="hapusp" data-toggle="modal" data-target="#hapusp" style="color:red;">Hapus</a></td>

                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="2">Pelanggan belum mengirimkan Bukti Pembayaran</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <form method="post" action="<?= base_url('Order_pelanggan/upload_bukti') ?>" enctype="multipart/form-data">
                            <input type="hidden" value="<?= $o['transaksi_id'] ?>" name="transaksi_id">
                            <input type="hidden" value="<?= $o['transaksi_bukti'] ?>" name="bukti_lama">
                            <h3>Pembayaran</h3>
                            <b>1. Pilih rekening transfer</b>
                            <table class="table table-bordered" id="pilih_bank">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Logo</th>
                                        <th>Atas Nama</th>
                                        <th>Nomor Rekening</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bank as $b) : ?>
                                        <?php if ($b['bank_nama'] === 'TUNAI') : ?>
                                            <tr>
                                                <td class="text-center p-2">
                                                    <input type="radio" name="bank" id="bank<?= $b['bank_id']; ?>" value="<?= $b['bank_id']; ?>">
                                                </td>
                                                <td class="p-2" colspan="3"><b>TUNAI</b></td>
                                            </tr>
                                        <?php else : ?>
                                            <tr>
                                                <td class="text-center p-2">
                                                    <input type="radio" name="bank" id="bank<?= $b['bank_id']; ?>" value="<?= $b['bank_id']; ?>">
                                                </td>
                                                <td class="p-2">
                                                    <img style="width: 60px;" src="<?= base_url('assets/img/bank/' . $b['bank_image']) ?>">
                                                </td>
                                                <td class="p-2"><?= $b['bank_atas_nama']; ?></td>
                                                <td class="p-2"><?= $b['bank_no_rek']; ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <br>
                            <?php if ($o['transaksi_terima'] !== '1') : ?>
                                <input type="hidden" value="<?= $this->uri->segment(3) ?>" name="id_transaksi">
                                <div class="form-group">
                                    <label for="atas_nama" class="mb-1"><b>2. Atas nama</b></label>
                                    <input id="atas_nama" placeholder="Misal: Reza Fabriza Lesmana" type="text" name="atas_nama" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="transfer" class="mb-1"><b>3. Jumlah yang ditransfer</b></label>
                                    <input id="transfer" placeholder="Misal: 500000" type="number" name="transfer" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="file"><b>4. Bukti transfer</b></label>
                                    <input id="file" type="file" name="bukti" class="form-control" required>
                                </div>
                                <button type="submit" style="width: 100%;" class="btn btn-primary">Kirim</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            <div id="status4" class="tabcontent">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0">Approval</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!isset($o['transaksi_approval_1'])) : ?>
                            <div>Harap tunggu sampai Admin mengunggah foto untuk Anda pilih</div>
                        <?php else : ?>
                            <form id="formApproval" method="post" action="<?= base_url('Order_pelanggan/upload_approval_acc') ?>" enctype="multipart/form-data">
                                <input type="hidden" name="transaksi_id" value="<?= $this->uri->segment(3) ?>">
                                <?php if (empty($o['transaksi_approval_acc'])) : ?>
                                    <div>Silahkan pilih produk yang akan di-approve dan dibuat</div>
                                <?php else : ?>
                                    <div>Harap tunggu Admin untuk meneruskan ke proses produksi.</div>
                                <?php endif; ?>
                                <br>
                                <input type="radio" value="1" name="approval" id="apv1" <?= $o['transaksi_approval_acc'] == '1' ? ' checked' : null; ?> required onclick="pilihGambar()">
                                <label for="apv1" style="white-space: pre-wrap;">Original</label>
                                <br>
                                <label for="apv1">
                                    <img class="w-100 border border-dark" src="<?= base_url('design_approval/' . $o['transaksi_approval_1']) ?>">
                                    <br>
                                </label>
                                <?php if (!empty($o['transaksi_approval_2'])) : ?>
                                    <br>
                                    <input type="radio" value="2" name="approval" id="apv2" <?= $o['transaksi_approval_acc'] == '2' ? ' checked' : null; ?> required onclick="pilihGambar()">
                                    <label for="apv2">Gelap</label>
                                    <br>
                                    <label for="apv2">
                                        <img class="w-100 border border-dark" src="<?= base_url('design_approval/' . $o['transaksi_approval_2']) ?>">
                                        <br>
                                    </label>
                                <?php endif; ?>
                                <?php if (!empty($o['transaksi_approval_3'])) : ?>
                                    <br>
                                    <input type="radio" value="3" name="approval" id="apv3" <?= $o['transaksi_approval_acc'] == '3' ? ' checked' : null; ?> required onclick="pilihGambar()">
                                    <label for="apv3">Terang</label>
                                    <br>
                                    <label for="apv3">
                                        <img class="w-100 border border-dark" src="<?= base_url('design_approval/' . $o['transaksi_approval_3']) ?>">
                                        <br>
                                    </label>
                                <?php endif; ?>
                                <br>
                                <input type="radio" value="4" name="approval" id="apv4" <?= $o['transaksi_approval_acc'] == '4' ? ' checked' : null; ?> required onclick="pilihGambar()">
                                <label for="apv4">Revisi</label>
                                <br>
                                <button type="submit" class="btn btn-primary w-100">Pilih</button>

                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div id="status5" class="tabcontent">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0">Proses Produksi</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if (!empty($ctk['transaksi_status']) && @$ctk['transaksi_status'] == '1') :
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
                                $tipe = $this->db->select('product_tipe')->where('product_id', $o['transaksi_product_id'])->get('tbl_product')->row_array()['product_tipe'];
                                $produksi = $this->db;
                                switch ($tipe) {
                                    case '0':
                                        $produksi = $produksi->where_in('status_id', ['52', '53', '54', '56', '57']);
                                        break;
                                    case '1':
                                    case '4':
                                        $produksi = $produksi->where_in('status_id', ['52', '56', '57']);
                                        break;
                                    case '2':
                                        $produksi = $produksi->where_in('status_id', ['52', '55', '56', '57']);
                                        break;
                                    case '3':
                                        $produksi = $produksi->where_in('status_id', ['51', '52', '56', '57']);
                                        break;
                                }

                                $produksi = $this->db->get('tbl_status')->result_array();
                                $produksicount = current($produksi);
                                ?>
                                <?php foreach ($produksi as $pr) : ?>
                                    <div class="timeline-block mt-1 mb-0">
                                        <span style="background-color: <?= ($statusproduksi == $produksicount['status_id']) ? "blue" : ($statusproduksi > $produksicount['status_id'] ? "green" : "grey"); ?>;color: white;" class="timeline-step badge-success">
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
                                    <?php $produksicount = next($produksi) ?>
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
                        <p>Harap tunggu sampai Admin mengirim produk Anda dan memasukkan resi</p>
                        <?php if ($o['transaksi_terima'] == NULL) : ?>
                            <?php
                            $resi = $this->db
                                ->select('transaksi_resi, transaksi_ekspedisi')
                                ->where('transaksi_id', $id)
                                ->get('tbl_transaksi')
                                ->row_array();
                            ?>
                            <?php if ($o['transaksi_paket'] == '1') : ?>
                                <div class="wrapper">
                                    <div class="form-group row w-100">
                                        <label for="ekspedisi" class="col-sm-4 col-form-label">Jasa Ekspedisi:</label>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext" id="ekspedisi" value="<?= (is_null($resi['transaksi_ekspedisi']) || empty($resi['transaksi_ekspedisi']) ? 'Belum ada ekspedisi' : $resi['transaksi_ekspedisi']); ?>">
                                        </div>
                                        <label for="noresi" class="col-sm-4 col-form-label">Nomor Resi:</label>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext" id="noresi" value="<?= (is_null($resi['transaksi_resi']) || empty($resi['transaksi_resi']) ? 'Belum ada resi' : $resi['transaksi_resi']); ?>">
                                        </div>
                                        <label class="col-sm-4 col-form-label">Foto Resi :</label>
                                        <div class="col-sm-4">
                                            <?php if (!empty($o['transaksi_foto_resi'])) : ?>
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#foto_resi"> Lihat Foto
                                                </button>
                                            <?php else : ?>
                                                <input type="text" readonly class="form-control-plaintext" id="noresi" value="Belum ada foto resi">
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                                <p></p>
                                <div>
                                    <?php if (!is_null($resi['transaksi_resi']) && !empty($resi['transaksi_resi'])) : ?>
                                        <a class="btn btn-success" style="width:100%;" style="text-align: center;" href="https://cekresi.com/?v=wdg&noresi=<?= $resi['transaksi_resi'] ?>">
                                            Cek Resi
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <br>
                            <div id="paket_terima">
                                <!-- <button style="width:100%;display:none;" class="btn btn-primary terima">Paket sudah diterima</button> -->
                                <?php
                                if ($o['transaksi_paket'] != NULL) :
                                ?>
                                    <button id="terima" style="width:100%;" class="btn btn-primary terima">Paket sudah diterima</button>
                                <?php
                                endif;
                                ?>
                            </div>
                        <?php else : ?>
                            <h2 style="text-align: center;">Transaksi Anda Selesai</h2>
                            <h2 style="text-align: center;">Terima kasih telah berbelanja di<br>UCARD Indonesia</h2>
                            <br>
                            <h2 style="text-align: center;">Tulis review tentang kami di Google</h2>
                            <br>
                            <div class="btnreviewcenter">
                                <a class="btn btn-info" style="text-align: center;" href="https://g.page/r/Ce2lxSIiDOxWEAE/review">
                                    UCARD Surabaya
                                </a>
                                <a class="btn btn-danger" style="text-align: center;" href="https://g.page/r/CTvioWQ51qDNEAg/review">
                                    UCARD Semarang
                                </a>
                                <br>
                                <br>
                                <a class="btn btn-success" style="text-align: center;" href="https://g.page/r/CQCSzZXego0MEAg/review">
                                    UCARD Jakarta
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="perbaikan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form id="form_perbaikan" action="<?= base_url('Detail_product_pelanggan/perbaikan'); ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Perbaikan Pesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                    $d = $this->db->where("transaksi_id", $this->uri->segment(3))->get('tbl_transaksi')->row_array();
                    $p = $this->db->where("product_id", $d['transaksi_product_id'])->get('tbl_product')->row_array();
                    ?>
                    <div class="modal-body">
                        <input type="hidden" value="<?= $d['transaksi_id'] ?>" name="transaksi_id">
                        <input type="hidden" value="<?= $d['transaksi_product_id'] ?>" name="product_id">
                        <div class="form-group">
                            <b>Jumlah Pesanan</b>
                            <br><br>
                            <input type="number" placeholder="jumlah" name="jumlah" class="form-control" value="<?= $d['transaksi_jumlah']; ?>" required>
                        </div>
                        <?php if ($p['product_tipe'] == '0') : ?>
                            <!-- Kartu -->
                            <div class="grid-container">
                                <div class="grid-item">
                                    <?php $personalisasi = explode(',', $o['transaksi_personalisasi']); ?>
                                    <b>Personalisasi</b>
                                    <br><br>
                                    <div class="form-group">
                                        <input type="checkbox" id="persona1" placeholder="personalisasi" name="personalisasi[]" value="1" <?= in_array('1', $personalisasi) ? 'checked' : ''; ?>>
                                        <label for="persona1">Blanko</label><br>
                                        <input type="checkbox" id="persona2" placeholder="personalisasi" name="personalisasi[]" value="2" <?= in_array('2', $personalisasi) ? 'checked' : ''; ?>>
                                        <label for="persona2">Nomerator</label><br>
                                        <input type="checkbox" id="persona3" placeholder="personalisasi" name="personalisasi[]" value="3" <?= in_array('3', $personalisasi) ? 'checked' : ''; ?>>
                                        <label for="persona3">Barcode</label><br>
                                        <input type="checkbox" id="persona4" placeholder="personalisasi" name="personalisasi[]" value="4" <?= in_array('4', $personalisasi) ? 'checked' : ''; ?>>
                                        <label for="persona4">Data</label><br>
                                        <input type="checkbox" id="persona5" placeholder="personalisasi" name="personalisasi[]" value="5" <?= in_array('5', $personalisasi) ? 'checked' : ''; ?>>
                                        <label for="persona5">Data + Foto</label>
                                    </div>
                                </div>
                                <div class="grid-item">
                                    <b>Coating</b>
                                    <br><br>
                                    <input type="radio" id="coating1" placeholder="coating" name="coating" value="1" <?= $o['transaksi_coating'] == '1' ? 'checked' : ''; ?> required>
                                    <label for="coating1">Glossy</label><br>
                                    <input type="radio" id="coating2" placeholder="coating" name="coating" value="2" <?= $o['transaksi_coating'] == '2' ? 'checked' : ''; ?> required>
                                    <label for="coating2">Doff</label><br>
                                    <input type="radio" id="coating3" placeholder="coating" name="coating" value="3" <?= $o['transaksi_coating'] == '3' ? 'checked' : ''; ?> required>
                                    <label for="coating3">Glossy + Doff</label><br>
                                    <input type="radio" id="coating4" placeholder="coating" name="coating" value="4" <?= $o['transaksi_coating'] == '4' ? 'checked' : ''; ?> required>
                                    <label for="coating3">UV</label>
                                </div>
                                <div class="grid-item">
                                    <?php $finishing = explode(',', $o['transaksi_finishing']); ?>
                                    <b>Finishing</b>
                                    <br><br>
                                    <input type="checkbox" id="finish1" placeholder="finishing" name="finishing[]" value="1" <?= in_array('1', $finishing) ? 'checked' : ''; ?>>
                                    <label for="finish1">Tidak ada</label><br>
                                    <input type="checkbox" id="finish2" placeholder="finishing" name="finishing[]" value="2" <?= in_array('2', $finishing) ? 'checked' : ''; ?>>
                                    <label for="finish2">Urutkan</label><br>
                                    <input type="checkbox" id="finish3" placeholder="finishing" name="finishing[]" value="3" <?= in_array('3', $finishing) ? 'checked' : ''; ?>>
                                    <label for="finish3">Label Gosok</label><br>
                                    <input type="checkbox" id="finish4" placeholder="finishing" name="finishing[]" value="4" <?= in_array('4', $finishing) ? 'checked' : ''; ?>>
                                    <label for="finish4">Plong Oval</label><br>
                                    <input type="checkbox" id="finish5" placeholder="finishing" name="finishing[]" value="5" <?= in_array('5', $finishing) ? 'checked' : ''; ?>>
                                    <label for="finish5">Plong Bulat</label><br>
                                    <input type="checkbox" id="finish6" placeholder="finishing" name="finishing[]" value="6" <?= in_array('6', $finishing) ? 'checked' : ''; ?>>
                                    <label for="finish6">Copy Data RFID</label><br>
                                    <input type="checkbox" id="finish7" placeholder="finishing" name="finishing[]" value="7" <?= in_array('7', $finishing) ? 'checked' : ''; ?>>
                                    <label for="finish7">Emboss Silver</label><br>
                                    <input type="checkbox" id="finish8" placeholder="finishing" name="finishing[]" value="8" <?= in_array('8', $finishing) ? 'checked' : ''; ?>>
                                    <label for="finish8">Emboss Gold</label><br>
                                    <input type="checkbox" id="finish9" placeholder="finishing" name="finishing[]" value="9" <?= in_array('9', $finishing) ? 'checked' : ''; ?>>
                                    <label for="finish9">Panel</label><br>
                                    <input type="checkbox" id="finish10" placeholder="finishing" name="finishing[]" value="10" <?= in_array('10', $finishing) ? 'checked' : ''; ?>>
                                    <label for="finish10">Hot Print</label><br>
                                    <input type="checkbox" id="finish11" placeholder="finishing" name="finishing[]" value="11" <?= in_array('11', $finishing) ? 'checked' : ''; ?>>
                                    <label for="finish11">Swipe</label><br>
                                </div>
                                <div class="grid-item">
                                    <b>Function</b>
                                    <br><br>
                                    <input type="radio" id="function1" placeholder="function" name="function" value="1" <?= $o['transaksi_function'] == '1' ? 'checked' : ''; ?> required>
                                    <label for="function1">Print Thermal</label><br>
                                    <input type="radio" id="function2" placeholder="function" name="function" value="2" <?= $o['transaksi_function'] == '2' ? 'checked' : ''; ?> required>
                                    <label for="function2">Scan Barcode</label><br>
                                    <input type="radio" id="function3" placeholder="function" name="function" value="3" <?= $o['transaksi_function'] == '3' ? 'checked' : ''; ?> required>
                                    <label for="function3">Swipe Magnetic</label><br>
                                    <input type="radio" id="function4" placeholder="function" name="function" value="4" <?= $o['transaksi_function'] == '4' ? 'checked' : ''; ?> required>
                                    <label for="function4">Tap RFID</label>
                                </div>
                                <div class="grid-item">
                                    <?php $packaging = explode(',', $o['transaksi_packaging']); ?>
                                    <b>Packaging</b>
                                    <br><br>
                                    <input type="checkbox" id="packaging1" placeholder="packaging" name="packaging[]" value="1" <?= in_array('1', $packaging) ? 'checked' : ''; ?>>
                                    <label for="packaging1">Plastik 1 on 1</label><br>
                                    <input type="checkbox" id="packaging2" placeholder="packaging" name="packaging[]" value="2" <?= in_array('2', $packaging) ? 'checked' : ''; ?>>
                                    <label for="packaging2">Plastik Terpisah</label><br>
                                    <input type="checkbox" id="packaging3" placeholder="packaging" name="packaging[]" value="3" <?= in_array('3', $packaging) ? 'checked' : ''; ?>>
                                    <label for="packaging3">Box Kartu Nama</label><br>
                                    <input type="checkbox" id="packaging4" placeholder="packaging" name="packaging[]" value="4" <?= in_array('4', $packaging) ? 'checked' : ''; ?>>
                                    <label for="packaging4">Box Putih</label><br>
                                    <input type="checkbox" id="packaging5" placeholder="packaging" name="packaging[]" value="5" <?= in_array('5', $packaging) ? 'checked' : ''; ?>>
                                    <label for="packaging5">Small UCARD</label><br>
                                    <input type="checkbox" id="packaging6" placeholder="packaging" name="packaging[]" value="6" <?= in_array('6', $packaging) ? 'checked' : ''; ?>>
                                    <label for="packaging6">Small Maxi UCARD</label><br>
                                    <input type="checkbox" id="packaging7" placeholder="packaging" name="packaging[]" value="7" <?= in_array('7', $packaging) ? 'checked' : ''; ?>>
                                    <label for="packaging7">Large UCARD</label><br>
                                    <input type="checkbox" id="packaging8" placeholder="packaging" name="packaging[]" value="8" <?= in_array('8', $packaging) ? 'checked' : ''; ?>>
                                    <label for="packaging8">Large Maxi UCARD</label>
                                </div>
                                <div class="grid-item">
                                    <b>Ambil/Kirim</b>
                                    <br><br>
                                    <input type="radio" id="kirim" placeholder="status" name="status" value="1" <?= $o['transaksi_paket'] == '1' ? 'checked' : ''; ?> required>
                                    <label for="kirim">Kirim Produk</label><br>
                                    <input type="radio" id="ambil" placeholder="status" name="status" value="2" <?= $o['transaksi_paket'] == '2' ? 'checked' : ''; ?> required>
                                    <label for="ambil">Ambil Sendiri</label>
                                </div>
                            </div>
                        <?php elseif ($p['product_tipe'] == '1') : ?>
                            <!-- Aksesoris -->
                            <div class="grid-container">
                                <input type="hidden" id="tipe" name="tipe" value="<?= $p['product_tipe']; ?>">
                                <div class="grid-item p-0 pb-3">
                                    <b>Yoyo</b>
                                    <br><br>
                                    <input id="yoyo1" type="radio" placeholder="yoyo" name="yoyo" value="1" <?= $o['transaksi_yoyo'] == '1' ? 'checked' : ''; ?> required>
                                    <label for="yoyo1">Yoyo Putar</label><br>
                                    <input id="yoyo2" type="radio" placeholder="yoyo" name="yoyo" value="2" <?= $o['transaksi_yoyo'] == '2' ? 'checked' : ''; ?> required>
                                    <label for="yoyo2">Yoyo Standar</label><br>
                                    <input id="yoyo3" type="radio" placeholder="yoyo" name="yoyo" value="3" <?= $o['transaksi_yoyo'] == '3' ? 'checked' : ''; ?> required>
                                    <label for="yoyo3">Yoyo Transparan</label>
                                    <br><br><br>
                                    <b>Casing</b>
                                    <br><br>
                                    <input id="casing1" type="radio" placeholder="casing" name="casing" value="1" <?= $o['transaksi_casing'] == '1' ? 'checked' : ''; ?> required>
                                    <label for="casing1">Casing ID Card Acrylic</label><br>
                                    <input id="casing2" type="radio" placeholder="casing" name="casing" value="2" <?= $o['transaksi_casing'] == '2' ? 'checked' : ''; ?> required>
                                    <label for="casing2">Casing ID Card Solid</label><br>
                                    <input id="casing3" type="radio" placeholder="casing" name="casing" value="3" <?= $o['transaksi_casing'] == '3' ? 'checked' : ''; ?> required>
                                    <label for="casing3">Casing ID Card Karet</label><br>
                                    <input id="casing4" type="radio" placeholder="casing" name="casing" value="4" <?= $o['transaksi_casing'] == '4' ? 'checked' : ''; ?> required>
                                    <label for="casing4">Casing ID Card Kulit</label>
                                </div>
                                <div class="grid-item p-0 pb-3">
                                    <b>Warna</b>
                                    <br><br>
                                    <input id="warna1" type="radio" placeholder="warna" name="warna" value="1" <?= $o['transaksi_warna'] == '1' ? 'checked' : ''; ?> required>
                                    <label for="warna1">Hitam</label><br>
                                    <input id="warna2" type="radio" placeholder="warna" name="warna" value="2" <?= $o['transaksi_warna'] == '2' ? 'checked' : ''; ?> required>
                                    <label for="warna2">Putih</label><br>
                                    <input id="warna3" type="radio" placeholder="warna" name="warna" value="3" <?= $o['transaksi_warna'] == '3' ? 'checked' : ''; ?> required>
                                    <label for="warna3">Hijau</label><br>
                                    <input id="warna4" type="radio" placeholder="warna" name="warna" value="4" <?= $o['transaksi_warna'] == '4' ? 'checked' : ''; ?> required>
                                    <label for="warna4">Biru</label><br>
                                    <input id="warna5" type="radio" placeholder="warna" name="warna" value="5" <?= $o['transaksi_warna'] == '5' ? 'checked' : ''; ?> required>
                                    <label for="warna5">Merah</label><br>
                                    <input id="warna6" type="radio" placeholder="warna" name="warna" value="6" <?= $o['transaksi_warna'] == '6' ? 'checked' : ''; ?> required>
                                    <label for="warna6">Kuning</label><br>
                                    <input id="warna7" type="radio" placeholder="warna" name="warna" value="7" <?= $o['transaksi_warna'] == '7' ? 'checked' : ''; ?> required>
                                    <label for="warna7">Orange</label><br>
                                    <input id="warna8" type="radio" placeholder="warna" name="warna" value="8" <?= $o['transaksi_warna'] == '8' ? 'checked' : ''; ?> required>
                                    <label for="warna8">Silver</label><br>
                                    <input id="warna9" type="radio" placeholder="warna" name="warna" value="9" <?= $o['transaksi_warna'] == '9' ? 'checked' : ''; ?> required>
                                    <label for="warna9">Coklat</label><br>
                                    <input id="warna10" type="radio" placeholder="warna" name="warna" value="10" <?= $o['transaksi_warna'] == '10' ? 'checked' : ''; ?> required>
                                    <label for="warna10">Hitam Transparan</label><br>
                                    <input id="warna11" type="radio" placeholder="warna" name="warna" value="11" <?= $o['transaksi_warna'] == '11' ? 'checked' : ''; ?> required>
                                    <label for="warna11">Putih Transparan</label><br>
                                    <input id="warna12" type="radio" placeholder="warna" name="warna" value="12" <?= $o['transaksi_warna'] == '12' ? 'checked' : ''; ?> required>
                                    <label for="warna12">Biru Transparan</label><br>
                                    <input id="warna13" type="radio" placeholder="warna" name="warna" value="13" <?= $o['transaksi_warna'] == '13' ? 'checked' : ''; ?> required>
                                    <label for="warna13">Custom (isi di keterangan)</label>
                                </div>
                                <div class="grid-item p-0 pb-3">
                                    <b>Varian Casing Karet</b>
                                    <br><br>
                                    <input id="ck1" type="radio" placeholder="ck" name="ck" value="1" <?= $o['transaksi_ck'] == '1' ? 'checked' : ''; ?> required>
                                    <label for="ck1">Casing karet 1 sisi</label><br>
                                    <input id="ck2" type="radio" placeholder="ck" name="ck" value="2" <?= $o['transaksi_ck'] == '2' ? 'checked' : ''; ?> required>
                                    <label for="ck2">Casing karet 2 sisi</label><br>
                                    <input id="ck3" type="radio" placeholder="ck" name="ck" value="3" <?= $o['transaksi_ck'] == '3' ? 'checked' : ''; ?> required>
                                    <label for="ck3">Casing karet double landscape</label><br>
                                    <input id="ck4" type="radio" placeholder="ck" name="ck" value="4" <?= $o['transaksi_ck'] == '4' ? 'checked' : ''; ?> required>
                                    <label for="ck4">Casing karet single landscape</label>
                                </div>
                                <div class="grid-item p-0 pb-3">
                                    <b>Logo Resin</b>
                                    <br><br>
                                    <input id="lr" type="checkbox" placeholder="lr" name="lr" value="1" <?= $o['transaksi_logo'] == '1' ? 'checked' : ''; ?>>
                                    <label for="lr">Logo resin</label>
                                </div>
                                <div class="grid-item p-0 pb-3">
                                    <b>Penjepit Buaya</b>
                                    <br><br>
                                    <input id="pb1" type="radio" placeholder="pb" name="pb" value="1" <?= $o['transaksi_pb'] == '1' ? 'checked' : ''; ?> required>
                                    <label for="pb1">Penjepit Buaya Besi</label><br>
                                    <input id="pb2" type="radio" placeholder="pb" name="pb" value="2" <?= $o['transaksi_pb'] == '2' ? 'checked' : ''; ?> required>
                                    <label for="pb2">Penjepit Buaya Plastik</label>
                                </div>
                                <div class="grid-item p-0 pb-3">
                                    <b>Ambil/Kirim</b>
                                    <br><br>
                                    <input id="kirim" type="radio" placeholder="status" name="status" value="1" <?= $o['transaksi_paket'] == '1' ? 'checked' : ''; ?> required>
                                    <label for="kirim">Kirim Produk</label><br>
                                    <input id="ambil" type="radio" placeholder="status" name="status" value="2" <?= $o['transaksi_paket'] == '2' ? 'checked' : ''; ?> required>
                                    <label for="ambil">Ambil Sendiri</label>
                                </div>
                            </div>
                        <?php elseif ($p['product_tipe'] == '2') : ?>
                            <!-- Tali -->
                            <div class="grid-container">
                                <div class="grid-item p-0 pb-3">
                                    <b>Material</b>
                                    <br><br>
                                    <input id="material1" type="radio" placeholder="material" name="material" value="1" <?= $o['transaksi_material'] == '1' ? 'checked' : ''; ?> required>
                                    <label for="material1">Polyester 1,5CM</label><br>
                                    <input id="material2" type="radio" placeholder="material" name="material" value="2" <?= $o['transaksi_material'] == '2' ? 'checked' : ''; ?> required>
                                    <label for="material2">Polyester 2CM</label><br>
                                    <input id="material3" type="radio" placeholder="material" name="material" value="3" <?= $o['transaksi_material'] == '3' ? 'checked' : ''; ?> required>
                                    <label for="material3">Polyester 2,5CM</label><br>
                                    <input id="material4" type="radio" placeholder="material" name="material" value="4" <?= $o['transaksi_material'] == '4' ? 'checked' : ''; ?> required>
                                    <label for="material4">Tissue 1,5CM</label><br>
                                    <input id="material5" type="radio" placeholder="material" name="material" value="5" <?= $o['transaksi_material'] == '5' ? 'checked' : ''; ?> required>
                                    <label for="material5">Tissue 2CM</label><br>
                                    <input id="material6" type="radio" placeholder="material" name="material" value="6" <?= $o['transaksi_material'] == '6' ? 'checked' : ''; ?> required>
                                    <label for="material6">Tissue 2,5CM</label>
                                    <input id="material7" type="radio" placeholder="material" name="material" value="7" <?= $o['transaksi_material'] == '7' ? 'checked' : ''; ?>required>
                                    <label for="material7">Tali gelang 1,5cm printing</label><br>
                                    <input id="material8" type="radio" placeholder="material" name="material" value="8" <?= $o['transaksi_material'] == '8' ? 'checked' : ''; ?>required>
                                    <label for="material8">Tali gelang 2cm printing</label>
                                </div>
                                <div class="grid-item p-0 pb-3">
                                    <?php $finish = explode(',', $o['transaksi_finish']); ?>
                                    <b>Finishing</b>
                                    <br><br>
                                    <input id="finishing1" type="checkbox" placeholder="finish" name="finish[]" value="1" <?= in_array('1', $finish) ? 'checked' : ''; ?>>
                                    <label for="finishing1">Kait Oval</label><br>
                                    <input id="finishing11" type="checkbox" placeholder="finish" name="finish[]" value="2" <?= in_array('2', $finish) ? 'checked' : ''; ?>>
                                    <label for="finishing11">Kait Tebal</label><br>
                                    <input id="finishing2" type="checkbox" placeholder="finish" name="finish[]" value="3" <?= in_array('3', $finish) ? 'checked' : ''; ?>>
                                    <label for="finishing2">Kait HP</label><br>
                                    <input id="finishing3" type="checkbox" placeholder="finish" name="finish[]" value="4" <?= in_array('4', $finish) ? 'checked' : ''; ?>>
                                    <label for="finishing3">Kait Standar</label><br>
                                    <input id="finishing4" type="checkbox" placeholder="finish" name="finish[]" value="5" <?= in_array('5', $finish) ? 'checked' : ''; ?>>
                                    <label for="finishing4">Tambah Warna Sablon</label><br>
                                    <input id="finishing5" type="checkbox" placeholder="finish" name="finish[]" value="6" <?= in_array('6', $finish) ? 'checked' : ''; ?>>
                                    <label for="finishing5">Double Stopper</label><br>
                                    <input id="finishing6" type="checkbox" placeholder="finish" name="finish[]" value="7" <?= in_array('7', $finish) ? 'checked' : ''; ?>>
                                    <label for="finishing6">Stopper Tas</label><br>
                                    <input id="finishing7" type="checkbox" placeholder="finish" name="finish[]" value="8" <?= in_array('8', $finish) ? 'checked' : ''; ?>>
                                    <label for="finishing7">Stopper Rotate</label><br>
                                    <input id="finishing8" type="checkbox" placeholder="finish" name="finish[]" value="9" <?= in_array('9', $finish) ? 'checked' : ''; ?>>
                                    <label for="finishing8">Jahit</label><br>
                                    <input id="finishing9" type="checkbox" placeholder="finish" name="finish[]" value="10" <?= in_array('10', $finish) ? 'checked' : ''; ?>>
                                    <label for="finishing9">Tali Karung</label><br>
                                    <input id="finishing10" type="checkbox" placeholder="finish" name="finish[]" value="11" <?= in_array('11', $finish) ? 'checked' : ''; ?>>
                                    <label for="finishing10">Ring Vape</label><br>
                                </div>
                                <div class="grid-item p-0 pb-3">
                                    <b>Jenis Produksi</b>
                                    <br><br>
                                    <input id="jp1" type="radio" placeholder="jp" name="jp" value="1" <?= $o['transaksi_jp'] == '1' ? 'checked' : ''; ?> required>
                                    <label for="jp1">Sablon</label><br>
                                    <input id="jp2" type="radio" placeholder="jp" name="jp" value="2" <?= $o['transaksi_jp'] == '2' ? 'checked' : ''; ?> required>
                                    <label for="jp2">Printing</label><br>
                                </div>
                                <div class="grid-item p-0 pb-3">
                                    <b>Ambil/Kirim</b>
                                    <br><br>
                                    <input id="kirim" type="radio" placeholder="status" name="status" value="1" <?= $o['transaksi_paket'] == '1' ? 'checked' : ''; ?> required>
                                    <label for="kirim">Kirim Produk</label><br>
                                    <input id="ambil" type="radio" placeholder="status" name="status" value="2" <?= $o['transaksi_paket'] == '2' ? 'checked' : ''; ?> required>
                                    <label for="ambil">Ambil Sendiri</label>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <b>Keterangan</b><br>
                            <textarea class="form-control" name="keterangan" placeholder="Masukkan keterangan"><?= $d['transaksi_keterangan']; ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="lihat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Detail Desain</h5>
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
    <div class="modal fade" id="lihatp" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Detail Desain</h5>
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
    <div class="modal fade" id="hapusp" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Hapus Bukti Pembayaran ini</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="alert_hapus"></div>
                    <h3>Apakah anda yakin?</h3>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn_hapusp">Hapus</button>
                    <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php if ($o['transaksi_terima'] !== '1') : ?>
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
</div>
<?php endif ?>
<script src="<?= base_url('assets/admin/vendor/dropzone/dist/min/dropzone.min.js') ?>"></script>
<div class="modal fade" id="foto_resi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Bukti Pengiriman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img style="width: 100%;" src="<?= base_url('foto_resi/' . $o['transaksi_foto_resi']) ?>">
            </div>
            <div class="modal-footer">
                <a href="<?= base_url('foto_resi/' . $o['transaksi_foto_resi']) ?>" class="btn btn-primary"><i class="fa fa-download"></i> Download</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#pilih_bank tbody').find('tr').on('click', function(e) {
            var inp = $(this).find('input:first')[0];
            inp.checked = true;
        });
    });

    var kupon = $('#kupon');
    var total_perlu_dibayar = parseInt($('#total_perlu_dibayar').val());
    $('#btn-kupon').click(function() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('Kupon/cek_kupon'); ?>',
            data: {
                transaksi_id: <?= $this->uri->segment(3); ?>,
                kupon: kupon.val(),
            },
            success: function(data) {
                data = JSON.parse(data);
                console.log(data);
                if (data.alert) alert(data.msg);
                if (!data.cont) return successOrNoKupon(false);
                successOrNoKupon(data);
            }
        })
    });

    kupon.focus(function() {
        $(this).removeClass('bg-success text-white');
    })

    function successOrNoKupon(data) {
        if (data) {
            var subtotal = $('#subtotal');
            var diskon = $('#diskon');
            var total = $('#total');

            kupon.addClass('bg-success text-white');
            subtotal.text(data.subtotal);
            diskon.text(data.diskon);
            total.text(data.total);

            document.getElementById('part-bayar').scrollIntoView({
                block: 'start',
                behavior: 'smooth'
            });

            subtotal.addClass('text-danger');
            diskon.addClass('text-danger');
            total.addClass('text-danger');

            setTimeout(function() {
                subtotal.removeClass('text-danger');
                diskon.removeClass('text-danger');
                total.removeClass('text-danger');
            }, 1000);
        } else {
            kupon.addClass('bg-pink');
            setTimeout(function() {
                kupon.removeClass('bg-pink');
                kupon.focus();
            }, 600);
        }
    }

    function pilihGambar() {
        if (confirm('Anda yakin ingin memilih varian ini?')) {
            $('#formApproval').submit();
        }
    }
    $('#form_perbaikan').submit(function(evt) {
        evt.preventDefault();

        $.ajax({
            type: 'POST',
            url: $('#form_perbaikan').attr('action'),
            data: {
                product_id: $('input[name="product_id"]').val(),
                transaksi_id: $('input[name="transaksi_id"]').val(),
                jumlah: $('input[name="jumlah"]').val(),
                keterangan: $('#keterangan').val(),
                personalisasi: $('input[name="personalisasi[]"]:checked').map((i, el) => el.value).get().join(','),
                coating: $('input[name="coating"]:checked').val(),
                finishing: $('input[name="finishing[]"]:checked').map((i, el) => el.value).get().join(','),
                function: $('input[name="function"]:checked').val(),
                packaging: $('input[name="packaging[]"]:checked').map((i, el) => el.value).get().join(','),
                status: $('input[name="status"]:checked').val(),
            },
            success: function(data) {
                window.location.href = location.URL;
            }
        });
    })
    $('.modal_lihat').click(function() {
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
    $(document).on('click', '.hapus', function() {
        var id = $(this).attr('id');
        $('.btn_hapus').attr('id', id);
    });
    $(document).on('click', '.btn_hapus', function() {
        var url = document.URL.substring(0, document.URL.lastIndexOf('#'));
        var id = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: "<?= base_url('Order_pelanggan/hapus_design_upload') ?>",
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
    $(document).on('click', '.hapusp', function() {
        var id = $(this).attr('id');
        $('.btn_hapusp').attr('id', id);
    });
    $(document).on('click', '.btn_hapusp', function() {
        var url = document.URL.substring(0, document.URL.lastIndexOf('#'));
        var id = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: "<?= base_url('Order_pelanggan/hapus_pembayaran') ?>",
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
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        $('#' + status).css('display', 'block');
        $(evt.currentTarget).addClass(" active");
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
            url: '<?= base_url('Order_pelanggan/paket') ?>',
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
            $.ajax({
                type: 'POST',
                url: "<?= base_url('Order_pelanggan/terima') ?>",
                data: {
                    val: val,
                    id: id,
                },
                success: function(data) {
                    $('#terima_p').html(data);
                    location.reload();
                }
            });
        }
    });
</script>
<?php
$statusRefresh = $this->db->query("SELECT max(transaksi_status_id) st, max(transaksi_produksi_status_id) pd FROM tbl_status_transaksi WHERE transaksi_order_id=" . $this->uri->segment(3))->row_array();

?>
<script>
    $(document).ready(function() {
        setInterval(function() {
            var id = $('#id').val();
            var status = '<?= $statusRefresh['st']; ?>';
            var produksi = '<?= $statusRefresh['pd']; ?>';
            $.ajax({
                type: 'POST',
                url: '<?= base_url('Detail_product_pelanggan/checkStatus') ?>',
                data: {
                    id: id,
                    status: status,
                    produksi: produksi
                },
                success: function(data) {
                    if (data === 'refresh') {
                        location.reload();
                    }
                }
            });
        }, 5000);
    });
</script>