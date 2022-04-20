# product_tipe
| # | Tipe | Kustomisasi | Proses produksi |
| - | ---- | ----------- | --------------- |
| 0 | Kartu | Personalisasi, coating, finishing, function, packaging, ambil/kirim | Gudang, cetak, press, plong, quality control, siap kirim<br>1, 3, 4, 5, 7, 8 |
| 1 | Aksesoris | Yoyo, warna, casing, logo resin, penjepit buaya, ambil/kirim | Cetak, quality control, siap kirim<br>3, 7, 8 |
| 2 | Tali | Material, finishing, jenis produksi, ambil/kirim | Gudang, cetak, finishing, quality control, siap kirim<br>1, 3, 6, 7, 8 |
| 3 | E-money | Bank, print, personalisasi, packaging, coating, finishing, ambil/kirim | Gudang, Input nomor identifikasi, cetak, quality control, siap kirim<br>1, 2, 3, 7, 8 |
| 4 | Flashdisk | Varian, print, personalisasi, packaging, coating, finishing, ambil/kirim | Cetak, quality control, siap kirim<br>3, 7, 8 |

# transaksi_status_id

<table>
    <thead>
        <thead>
            <tr>
                <td>#</td>
                <td colspan="2">status</td>
            </tr>
        </thead>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td colspan="2">Verifikasi</td>
        </tr>
        <tr>
            <td>2</td>
            <td colspan="2">Kirim Design</td>
        </tr>
        <tr>
            <td>3</td>
            <td colspan="2">Pembayaran</td>
        </tr>
        <tr>
            <td>4</td>
            <td colspan="2">Approval</td>
        </tr>
        <tr>
            <td>5</td>
            <td colspan="2">Proses Produksi</td>
        </tr>
        <tr>
            <td></td>
            <td>51</td>
            <td>Gudang</td>
        </tr>
        <tr>
            <td></td>
            <td>52</td>
            <td>Input Identifikasi</td>
        </tr>
        <tr>
            <td></td>
            <td>53</td>
            <td>Cetak</td>
        </tr>
        <tr>
            <td></td>
            <td>54</td>
            <td>Press</td>
        </tr>
        <tr>
            <td></td>
            <td>55</td>
            <td>Plong</td>
        </tr>
        <tr>
            <td></td>
            <td>56</td>
            <td>Finishing</td>
        </tr>
        <tr>
            <td></td>
            <td>57</td>
            <td>Quality Control</td>
        </tr>
		<tr>
			<td></td>
			<td>58</td>
            <td>Siap Kirim</td>
		</tr>
        <tr>
            <td>6</td>
            <td colspan="2">Ambil/Kirim</td>
        </tr>
    </tbody>
</table>

# transaksi_paket
| # | status |
| - | ------ |
| 0 | Ambil sendiri |
| 1 | Kirim paket |
