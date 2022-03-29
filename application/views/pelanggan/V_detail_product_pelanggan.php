<style type="text/css">
    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
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

    .solid {
        border-style: solid;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }
</style>
<!-- Header -->

<!-- Page content -->
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <h3><?= $p['product_nama'] ?></h3>
                </div>

                <!-- Light table -->
                <div class="card-body row">
                    <div class="col-md-6">
                        <img class="img-fluid" style="width: 500px;" src="<?= base_url('image/' . $p['product_image']) ?>">
                    </div>
                    <div class="col-md-6">
                        <div>
                            <br>
                            <b>Nama</b>
                            <p><?= $p['product_nama'] ?></p>
                            <b>Deskripsi</b>
                            <p><?= $p['product_deskripsi'] ?></p>
                            <b>Keunggulan</b>
                            <p><?= $p['product_keunggulan'] ?></p>
                            <b>Keterangan Produk</b>
                            <p><?= $p['product_keterangan'] ?></p>
                        </div>
                        <br>
                        <form method="post" onsubmit="if(document.getElementById('agree').checked) { return true; } else { alert('Silahkan baca dan setujui syarat & ketentuan yang berlaku terlebih dahulu'); return false; }" action="<?= base_url('Detail_product_pelanggan/order') ?>">
                            <input type="hidden" value="<?= $p['product_id'] ?>" name="id_product">
                            <input type="hidden" value="<?= $_SESSION['pelanggan_nohp'] ?>" name="nohp">
                            <div class="form-group">
                                <b>Jumlah Pesanan</b>
                                <br><br>
                                <input type="number" placeholder="jumlah" name="jumlah" class="form-control" required>
                                <input type="hidden" value="<?= $p['product_harga'] ?>" name="harga">
                            </div>
                            <div class="grid-container">
                                <div class="grid-item">
                                    <b>Personalisasi</b>
                                    <br><br>
                                    <div class="form-group" required>
                                        <input type="checkbox" id="persona1" placeholder="personalisasi" name="personalisasi" value="1">
                                        <label for="persona1">Blanko</label><br>
                                        <input type="checkbox" id="persona2" placeholder="personalisasi" name="personalisasi" value="2">
                                        <label for="persona2">Nomerator</label><br>
                                        <input type="checkbox" id="persona3" placeholder="personalisasi" name="personalisasi" value="3">
                                        <label for="persona3">Barcode</label><br>
                                        <input type="checkbox" id="persona4" placeholder="personalisasi" name="personalisasi" value="4">
                                        <label for="persona4">Data</label><br>
                                        <input type="checkbox" id="persona5" placeholder="personalisasi" name="personalisasi" value="5">
                                        <label for="persona5">Data + Foto</label>
                                    </div>
                                </div>
                                <div class="grid-item">
                                    <b>Coating</b>
                                    <br><br>
                                    <input type="radio" id="coating1" placeholder="coating" name="coating" value="1">
                                    <label for="coating1">Glossy</label><br>
                                    <input type="radio" id="coating2" placeholder="coating" name="coating" value="2">
                                    <label for="coating2">Doff</label><br>
                                    <input type="radio" id="coating3" placeholder="coating" name="coating" value="3">
                                    <label for="coating3">Glossy + Doff</label><br>
                                    <input type="radio" id="coating4" placeholder="coating" name="coating" value="4">
                                    <label for="coating3">UV</label>
                                </div>
                                <div class="grid-item">
                                    <b>Finishing</b>
                                    <br><br>
                                    <input type="radio" id="finish1" placeholder="finishing" name="finishing" value="1">
                                    <label for="finish1">Tidak ada</label><br>
                                    <input type="radio" id="finish2" placeholder="finishing" name="finishing" value="2">
                                    <label for="finish2">Urutkan</label><br>
                                    <input type="radio" id="finish3" placeholder="finishing" name="finishing" value="3">
                                    <label for="finish3">Label Gosok</label><br>
                                    <input type="radio" id="finish4" placeholder="finishing" name="finishing" value="4">
                                    <label for="finish4">Plong Oval</label><br>
                                    <input type="radio" id="finish5" placeholder="finishing" name="finishing" value="5">
                                    <label for="finish5">Plong Bulat</label><br>
                                    <input type="radio" id="finish6" placeholder="finishing" name="finishing" value="6">
                                    <label for="finish6">Copy Data RFID</label><br>
                                    <input type="radio" id="finish7" placeholder="finishing" name="finishing" value="7">
                                    <label for="finish7">Emboss Silver</label><br>
                                    <input type="radio" id="finish8" placeholder="finishing" name="finishing" value="8">
                                    <label for="finish8">Emboss Gold</label><br>
                                    <input type="radio" id="finish9" placeholder="finishing" name="finishing" value="9">
                                    <label for="finish9">Panel</label><br>
                                    <input type="radio" id="finish10" placeholder="finishing" name="finishing" value="10">
                                    <label for="finish10">Hot Print</label><br>
                                    <input type="radio" id="finish11" placeholder="finishing" name="finishing" value="11">
                                    <label for="finish11">Swipe</label><br>
                                </div>
                                <div class="grid-item">
                                    <b>Function</b>
                                    <br><br>
                                    <input type="radio" id="function1" placeholder="function" name="function" value="1">
                                    <label for="function1">Print Thermal</label><br>
                                    <input type="radio" id="function2" placeholder="function" name="function" value="2">
                                    <label for="function2">Scan Barcode</label><br>
                                    <input type="radio" id="function3" placeholder="function" name="function" value="3">
                                    <label for="function3">Swipe Magnetic</label><br>
                                    <input type="radio" id="function4" placeholder="function" name="function" value="4">
                                    <label for="function4">Tap RFID</label>
                                </div>
                                <div class="grid-item">
                                    <b>Packaging</b>
                                    <br><br>
                                    <input type="radio" id="packaging1" placeholder="packaging" name="packaging" value="1">
                                    <label for="packaging1">Plastik 1 on 1</label><br>
                                    <input type="radio" id="packaging2" placeholder="packaging" name="packaging" value="2">
                                    <label for="packaging2">Plastik Terpisah</label><br>
                                    <input type="radio" id="packaging3" placeholder="packaging" name="packaging" value="3">
                                    <label for="packaging3">Box Kartu Nama</label><br>
                                    <input type="radio" id="packaging4" placeholder="packaging" name="packaging" value="4">
                                    <label for="packaging4">Box Putih</label><br>
                                    <input type="radio" id="packaging5" placeholder="packaging" name="packaging" value="5">
                                    <label for="packaging5">Small UCARD</label><br>
                                    <input type="radio" id="packaging6" placeholder="packaging" name="packaging" value="6">
                                    <label for="packaging6">Small Maxi UCARD</label><br>
                                    <input type="radio" id="packaging7" placeholder="packaging" name="packaging" value="7">
                                    <label for="packaging7">Large UCARD</label><br>
                                    <input type="radio" id="packaging8" placeholder="packaging" name="packaging" value="8">
                                    <label for="packaging8">Large Maxi UCARD</label>
                                </div>
                                <div class="grid-item">
                                    <b>Ambil/Kirim</b>
                                    <br><br>
                                    <input type="radio" id="kirim" placeholder="status" name="status" value="1">
                                    <label for="kirim">Kirim Produk</label><br>
                                    <input type="radio" id="ambil" placeholder="status" name="status" value="2">
                                    <label for="ambil">Ambil Sendiri</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="keterangan" placeholder="Keterangan"></textarea>
                            </div>
                            <br>
                            <input type="checkbox" name="checkbox" value="check" id="agree"></a>
                            <label for="agree">Saya telah membaca & menyetujui <a style="color:blue;" data-toggle="modal" data-target="#sak">Syarat & Ketentuan</a></label>
                            <br>
                            <button type="submit" class="btn btn-info">Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sak" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Syarat dan Ketentuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="content-area">
                        <div id="content" class="site-content" role="main">

                            <h2 style="text-align: left">KETENTUAN FIX ORDER</h2>

                            <ol>
                                <li>Jasa desain kartu dikenakan biaya sebesar Rp 150.000</li>
                                <li>Revisi jasa desain kartu dilakukan 2X, dan revisi wajib dibuat secara TERTULIS atau melalui EMAIL.</li>
                                <li>Kesalahan revisi yang tidak dibuat secara TERTULIS / melalui EMAIL bukan menjadi tanggung jawab kami.</li>
                                <li>Jika revisi dilakukan lebih dari 2X akan dikenakan biaya tambahan Rp. 100.000</li>
                                <li>Estimasi waktu pengerjaan Proof yaitu 2-3 hari.</li>
                                <li>Waktu pengerjaan desain memakan waktu kurang lebih 3-4 hari.</li>
                                <li>Revisi proof &amp; desain membutuhkan waktu kurang lebih 1-2 hari.</li>
                                <li>Pesanan akan diproduksi setelah membayar Dont Payment (DP) / melunasi seluruh biaya produksi + ongkos kirim.</li>
                                <li>Harga&nbsp;yang tercantum belum termasuk PPN dan ongkos kirim.</li>
                                <li>Hari kerja aktif Senin – Sabtu, yaitu : Hari Senin sampai Jumat (09.00 – 17.00) dan Hari Sabtu (09.00 – 14.00). Hari Minggu dan hari libur nasional tutup.</li>
                                <li>Hasil yang tidak maksimal karena resolusi di bawah 300 dpi bukan menjadi tanggung jawab pihak UCard Indonesia.</li>
                                <li>Kami hanya menerima file design yang legal &amp; resmi / tidak melanggar undang – undang Hak Cipta dan dapat dipertanggung jawabkan secara hukum oleh pihak customer.</li>
                                <li>File desain dalam format PNG, JPG, PSD, Corel, PDF, AI dengan ukuran 8.5 x 5.4 cm resolusi minimal 300 dpi.</li>
                                <li>Hasil warna tidak akan sama persis dengan file dan contoh kartu dari percetakan lain.</li>
                                <li>Hasil warna dari UCard Indonesia mungkin lebih gelap / lebih terang dari preview monitor.</li>
                                <li>Minimum order di 50 pcs. (50 pcs max 1 desain).</li>
                                <li>Hasil warna yg berbeda karena mengabaikan proses approval terlebih dahulu bukan menjadi tanggung jawab pihak UCard Indonesia.</li>
                                <li>Proses adjust warna WAJIB melampirkan kode panthone, acuan fisik seperti hasil cetakan, warna layar monitor, file berupa foto dsb tidak dapat dilayani.</li>
                                <li>Hasil produksi kami tidak dapat diterima dalam kondisi 100% warna sama, melainkan terdapat toleransi naik turun warna sekitar 10% s/d 20%. (PRINT OUT NOT A PRINT PREVIEW)</li>
                                <li>Klaim perbedaan warna yang diakibatkan toleransi naik turun mesin tidak dapat dilayani, kecuali hasil yang diterima berbeda 100% dari acuan proof yang telah disepakati.</li>
                                <li>Format pemesanan kartu yang tidak sesuai dengan SOP (Standar Operasional Pemesanan) tidak dapat diproses.</li>
                                <li>DP yang sudah dibayarkan tidak dapat dikembalikan dengan alasan apapun.</li>
                                <li>Pengiriman dilakukan H+1 setelah melunasi biaya produksi ongkir.</li>
                                <li>Proses pengecekan file kami meliputi: kuantiti, ukuran file, resolusi, data, finishing.</li>
                                <li>Mengingat proses pengolahan data sudah menggunakan sistem input data otomatis (automatic filled database), maka jika terdapat kesalahan&nbsp; data atau ada data yang terduplikasi dikarenakan kelalaian pelanggan dalam menyerahkan file, bukan menjadi tanggung jawab pihak kami.</li>
                                <li>Khusus untuk jenis kartu personalisasi seperti (kartu identitas, kartu member, kartu pegawai dsb) format file wajib sesuai SOP, jika format yang diberikan tidak sesuai SOP maka jika terdapat keterlambatan proses produksi &amp; kesalahan produksi kartu bukan kesalahan produksi kartu bukan menjadi tanggung jawab kami.</li>
                            </ol>

                            <div style="height: 32px"></div>
                            <h2 style="text-align: left">APPROVAL</h2>

                            <ol>
                                <li>Hasil warna tidak akan sama persis baik dengan file atau dari contoh percetakan lain.</li>
                                <li>Hasil warna dari UCard Indonesia mungkin lebih gelap / lebih terang.</li>
                                <li>Proses adjust warna WAJIB melampirkan kode panthone, acuan fisik seperti hasil cetakan, warna layar monitor, file berupa foto dsb tidak dapat dilayani.</li>
                                <li>Free proof bagi Customer yang terikat pemesanan langsung. Maximal 1 kali. Lebih dari 1 kali dikenakan biaya proof (harga sesuai dengan ketentuan).</li>
                                <li>Proses proof kartu membutuhkan waktu pengerjaan 3-4 hari (tidak termasuk waktu produksi) kerja atau bahkan bisa lebih tergantung tingkat kompleksitas komposisi warna.</li>
                                <li>Proses revisi proof membutuhkan waktu produksi 3-4 hari setelah desain fix diproses.</li>
                                <li>Proses approval tidak termasuk <em>waktu produksi kartu.</em></li>
                                <li>Kartu proof tidak untuk diperjual belikan.</li>
                                <li>Biaya proof di atas belum termasuk ongkir (jika ada permintaan pengiriman).</li>
                                <li>Proof kartu berlaku untuk semua jenis pemesanan kartu PVC terkecuali untuk pemesanan “KartuNama”. (harga sesuai dengan ketentuan proof).</li>
                                <li>Revisi proof WAJIB dibuat secara tertulis atau by email.</li>
                                <li>Revisi yang tidak dilakukan sesuai prosedur tidak akan diproses diproses oleh tim UCard Indonesia.</li>
                                <li>Pelanggan wajib memberikan konfirmasi terkait approval kartu maksimal paling lambat 3 hari setelah proof diterima.</li>
                                <li>Apabila terjadi keterlambatan proses produksi yang diakibatkan oleh keterlambatan customer dalam memberikan konfirmasi bukan menjadi tanggung jawab tim Ucard Indonesia.</li>
                                <li>ACC Proof wajib ditandatangani secara tertulis guna dijadikan sebagai bahan acuan produksi.</li>
                            </ol>


                            <div style="height: 32px"></div>
                            <h2 style="text-align: left">PEMBAYARAN</h2>

                            <p>Beberapa hal yang perlu diperhatikan dalam melakukan proses pembayaran :</p>
                            <ol>
                                <li>Bank yang kami gunakan untuk untuk penerimaan pembayaran adalah Bank BCA dan Bank Mandiri.</li>
                                <li>Bank Account : BCA : 7880868017, Mandiri : 1420018447325 (a/n <strong>PT. Solusi Kartu Indonesia</strong>)</li>
                                <li>Setelah transfer, silakan mengirim SMS / WA KONFIRMASI PEMBAYARAN ke nomor : <strong>0821-1839-4404</strong> (UCard Surabaya), <strong>0812-3260-0700</strong> (UCard Jakarta), <strong>0813-3140-9700</strong>&nbsp;(UCard Semarang) atau klik <strong>“<a href="https://idcardjakarta.com/konfirmasi-pembayaran/">Konfirmasi Pembayaran</a>”</strong></li>
                                <li>Apabila anda melakukan pembayaran melalui giro, mohon bantuannya agar giro tersebut di tuliskan atas nama kami. Pembayaran melalui giro kami anggap sah setelah giro tersebut cair.</li>
                                <li>Pemesanan di bawah nominal 1.000.000 WAJIB LUNAS sebelum proses produksi dimulai.</li>
                                <li>DP 50% hanya berlaku untuk pemesanan dengan minimal transaksi 1.000.000 di bawah 1 juta di bayar keseluruhan.</li>
                                <li>Jika terdapat pengambilan secara PARSIAL maka tagihan WAJIB LUNAS sejak pengambilan barang TAHAP PERTAMA.</li>
                                <li>Setelah melakukan pembayaran wajib melampirkan Bukti pembayaran secara yang SAH.</li>
                                <li>Mohon diperhatikan term of payment ! kami tidak dapat memulai proses produksi jika belum ada DP/Pembayaran</li>
                                <li>Pembayaran/DP yang sudah dibayar tidak dapat dikembalikan dengan alasan apapun.</li>
                            </ol>


                            <div style="height: 32px"></div>
                            <h2 style="text-align: left">WAKTU PRODUKSI</h2>

                            <ol>
                                <li>Waktu pengerjaan dihitung dari fix approval proof/layout yang kami terima dan dengan syarat pembayaran telah dipenuhi.</li>
                                <li>Untuk estimasi standar waktu pengerjaan silahkan langsung menghubungi Customer Relation Officer UCard Jakarta, UCard Surabaya atau UCard Semarang.</li>
                                <li>Dimohon untuk customer mengkomunikasikan kebutuhan kami dengan baik dan jelas agar tidak terjadinya <em>Miskomunikasi</em></li>
                                <li>Permintaan penyelesaian produksi di luar standar waktu produksi yang ditentukan akan dikenakan biaya tambahan (Biaya Express).</li>
                                <li>Estimasi waktu produksi yang diberikan merupakan dasar estimasi waktu produksi kami dan bukan merupakan acuan utama.</li>
                                <li>Jika terdapat keterlambatan waktu produksi yang disebabkan oleh faktor baik teknis maupun non teknis staf kami akan memberi informasi sesegera mungkin.</li>
                                <li>Jika pesanan Anda belum tercantum pada kategori produk, berarti pesanan Anda termasuk dalam kategori custom card.</li>
                                <li>Untuk mengetahui progress produksi silahkan langsung menghubungi Customer Relation Officer UCard Jakarta, UCard Surabaya atau UCard Semarang.</li>
                            </ol>



                            <h2 style="text-align: left">PENGIRIMAN</h2>

                            <ol>
                                <li>Pengiriman akan dilakukan setelah pemesan membayar seluruh biaya pemesanan sekaligus biaya ongkos kirim.</li>
                                <li>Kiriman yang tidak sampai di tempat pemesan karena alamat tidak lengkap, menjadi tanggung jawab pemesan.</li>
                                <li>Pengiriman dilakukan H+1 setelah melunasi biaya produksi &amp; ongkir.</li>
                                <li>Ketentuan jenis pengiriman yang sudah di lampirkan melalui subjek pemesanan tidak dapat dirubah. (Kecuali kondisi tertentu).</li>
                            </ol>


                            <div style="height: 32px"></div>
                            <h2 style="text-align: left">GARANSI</h2>

                            <h3><span class="ez-toc-section" id="KESALAHAN_YANG_DITANGGUNG_PERCETAKAN"></span>KESALAHAN YANG DITANGGUNG PERCETAKAN :<span class="ez-toc-section-end"></span></h3>
                            <p>UCard Indonesia memberikan garansi berupa penggantian kartu atau pengembalian uang karena alasan-alasan tertentu seperti :</p>
                            <ol>
                                <li>Kartu tidak diterima dalam kondisi baik secara fisik (cacat, blur, buram dsb).</li>
                                <li>Kartu tidak diterima dalam kondisi baik secara fungsi (khusus barcode, magnetik, dan RFID).</li>
                                <li>Kartu dicetak dengan desain terbalik atau finishing yang tidak sesuai approval.</li>
                            </ol>
                            <h3><span class="ez-toc-section" id="KESALAHAN_YANG_TIDAK_DITANGGUNG_PERCETAKAN"></span>KESALAHAN YANG TIDAK DITANGGUNG PERCETAKAN :<span class="ez-toc-section-end"></span></h3>
                            <p>Kami tidak menanggung kesalahan hasil cetakan meliputi beberapa hal berikut :</p>
                            <p><strong>Kalibrasi Warna.</strong></p>
                            <p>Kami tidak bisa menjamin warna seusai dengan file asli, hal ini meliputi karena perbedaan setting RGB dan CMYK yang Anda lakukan, perbedaan kalibrasi monitor, dan faktor-faktor pendukung lainnya.</p>
                            <p><strong>Missing gambar yang mengakibatkan gambar tidak tercetak dengan sempurna.</strong></p>
                            <p>Pastikan Anda menggunakan software desain grafis dan memeriksa kembali bagian-bagian gambar yang akan Anda print, kami tidak bertanggung jawab jika ada beberapa gambar yang tidak bisa terprint dengan sempurna karena kelalaian Anda tersebut.</p>
                            <p><strong>Isi Konten, Foto, dan Data</strong></p>
                            <p>Bagi kartu yang terdapat personalisasi data seperti nama, foto, dan biodata kesalahan konten yang disebabkan kekeliruan pengisian database bukan menjadi tanggung jawab kami.</p>
                            <p><strong>Kesalahan Spesifikasi</strong></p>
                            <p>Mengeluhkan klaim di luar approval yang sudah disetujui di awal tidak akan dilayani.</p>


                            <div style="height: 32px"></div>
                            <h2 style="text-align: left">NOTE</h2>

                            <ul>
                                <li>Barang yang sudah diterima mohon dicek kembali.</li>
                                <li>Batas waktu klaim hanya 3 hari setelah kartu diterima.</li>
                                <li>Apabila klaim dilakukan lebih dari 3 hari maka kerusakan bukan menjadi tanggung jawab kami.</li>
                                <li>Wajib menyertakan bukti fisik kartu yang cacat sebagai syarat penggantian kartu baru.</li>
                            </ul>



                        </div> <!-- #content -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sa" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Syarat dan Ketentuan</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>