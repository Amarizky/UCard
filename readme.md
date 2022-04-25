# product_tipe
| # | Tipe | Kustomisasi | Proses produksi |
| - | ---- | ----------- | --------------- |
| 0 | Kartu | Personalisasi, coating, finishing, function, packaging, ambil/kirim | Gudang, cetak, press, plong, quality control, siap kirim<br>1, 3, 4, 5, 7, 8 |
| 1 | Aksesoris | Yoyo, warna, casing, logo resin, penjepit buaya, ambil/kirim | Cetak, quality control, siap kirim<br>3, 7, 8 |
| 2 | Tali | Material, finishing, jenis produksi, ambil/kirim | Gudang, cetak, finishing, quality control, siap kirim<br>1, 3, 6, 7, 8 |
| 3 | E-money | Bank, print, personalisasi, packaging, coating, finishing, ambil/kirim | Gudang, Input nomor identifikasi, cetak, quality control, siap kirim<br>1, 2, 3, 7, 8 |
| 4 | Flashdisk | Varian, print, personalisasi, packaging, coating, finishing, ambil/kirim | Cetak, quality control, siap kirim<br>3, 7, 8 |

# status_id
<table><thead><thead><tr><td>#</td><td colspan="2">status</td><td>permission name</td></tr></thead></thead><tbody><tr><td>1</td><td colspan="2">Verifikasi</td><td>admin_perm_orderverifikasi</td></tr><tr><td>2</td><td colspan="2">Kirim Design</td><td>admin_perm_orderkirimdesign</td></tr><tr><td>3</td><td colspan="2">Pembayaran</td><td>admin_perm_orderpembayaran</td></tr><tr><td>4</td><td colspan="2">Approval</td><td>admin_perm_orderapproval</td></tr><tr><td>5</td><td colspan="2">Cetak Produk</td><td>admin_perm_orderproduksi</td></tr><tr><td></td><td>51</td><td>Gudang</td><td>admin_perm_orderproduksi_gudang</td></tr><tr><td></td><td>52</td><td>Input Identifikasi</td><td>admin_perm_orderproduksi_identifikasi</td></tr><tr><td></td><td>53</td><td>Cetak</td><td>admin_perm_orderproduksi_cetak</td></tr><tr><td></td><td>54</td><td>Press</td><td>admin_perm_orderproduksi_press</td></tr><tr><td></td><td>55</td><td>Plong</td><td>admin_perm_orderproduksi_plong</td></tr><tr><td></td><td>56</td><td>Finishing</td><td>admin_perm_orderproduksi_finishing</td></tr><tr><td></td><td>57</td><td>Quality Control</td><td>admin_perm_orderproduksi_qualitycontrol</td></tr><tr><td></td><td>58</td><td>Siap Kirim</td><td>admin_perm_orderproduksi_siapkirim</td></tr><tr><td>6</td><td colspan="2">Ambil/Kirim</td><td>admin_perm_orderkirimambil</td></tr></tbody></table>

# transaksi_paket
| # | status |
| - | ------ |
| 0 | Ambil sendiri |
| 1 | Kirim paket |
