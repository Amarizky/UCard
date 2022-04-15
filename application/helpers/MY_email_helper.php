<?php

function get_email($id, $id_status, $verifier = 'admin', $pelanggan = '[Nama pelanggan]', $tanggal = null)
{
    $subject = null;
    $message = null;
    $detail = base_url('Order_pelanggan/detail/' . $id);
    $logo = base_url('assets/img/logo-kartuidcard-white.png');

    switch ($id_status) {
        case '1':
            // Verifikasi
            $subject = 'UCard Surabaya - Pesananmu sudah diverifikasi!';
            $message = <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$subject}</title>
    <style>
    body{background-color:#f5f5f5;text-align:center}.btn{color:#fff;background-color:#4caf50;font-size:16px;border-radius:8px;border:0;width:180px;height:40px;cursor:pointer}.container{background-image:linear-gradient(87deg,#5e72e4 0,#825ee4 100%);min-width:480px;max-width:700px;border-radius:8px;height:auto;padding-bottom:10px}.body{padding:20px;background-color:#fff;text-align:start;border-radius:8px}.code{text-align:center;color:#000;font-size:18px}.m-auto{margin:auto}.m-10{margin:10px}.p-10{padding:10px}.text-center{text-align:center}.w-100{width:100%}
    </style>
</head>

<body>
    <div class="text-center">
        <div class="container">
            <div class="m-auto p-10 text-center">
                <img src="{$logo}" alt="">
            </div>
            <div class="m-10 body">
                <h2 class="text-center">Halo, {$pelanggan}!</h2>
                <br>
                <p>Pesananmu pada tanggal {$tanggal} sudah diverifikasi oleh {$verifier} nih! Upload desainmu untuk lanjut ke tahap berikutnya!</p>
                <p>Tekan tombol di bawah untuk membuka halaman detail produk.</p>
                <div class="text-center">
                    <a href="{$detail}">
                        <button class="btn">Detail Produk</button>
                    </a>
                </div>
            </div>
            <p style="color: white;">UCard Surabaya<br>Jl. Rungkut Harapan Blk. F No.008, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
        </div>
    </div>
</body>

</html>
HTML;
            break;
        case '2':
            // Kirim Design
            $subject = 'UCard Surabaya - Desainmu sudah diverifikasi!';
            $message = <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$subject}</title>
    <style>
    body{background-color:#f5f5f5;text-align:center}.btn{color:#fff;background-color:#4caf50;font-size:16px;border-radius:8px;border:0;width:180px;height:40px;cursor:pointer}.container{background-image:linear-gradient(87deg,#5e72e4 0,#825ee4 100%);min-width:480px;max-width:700px;border-radius:8px;height:auto;padding-bottom:10px}.body{padding:20px;background-color:#fff;text-align:start;border-radius:8px}.code{text-align:center;color:#000;font-size:18px}.m-auto{margin:auto}.m-10{margin:10px}.p-10{padding:10px}.text-center{text-align:center}.w-100{width:100%}
    </style>
</head>

<body>
    <div class="text-center">
        <div class="container">
            <div class="m-auto p-10 text-center">
                <img src="{$logo}" alt="">
            </div>
            <div class="m-10 body">
                <h2 class="text-center">Halo, {$pelanggan}!</h2>
                <br>
                <p>Desainmu pada tanggal {$tanggal} sudah diverifikasi oleh {$verifier} nih! Ayo cek sekarang juga untuk melanjutkan ke tahap berikutnya!</p>
                <p>Tekan tombol di bawah untuk membuka halaman detail produk.</p>
                <div class="text-center">
                    <a href="{$detail}">
                        <button class="btn">Detail Produk</button>
                    </a>
                </div>
            </div>
            <p style="color: white;">UCard Surabaya<br>Jl. Rungkut Harapan Blk. F No.008, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
        </div>
    </div>
</body>

</html>
HTML;
            break;
        case '3':
            // Pembayaran
            $subject = 'UCard Surabaya - Pembayaranmu sudah diverifikasi!';
            $message = <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$subject}</title>
    <style>
    body{background-color:#f5f5f5;text-align:center}.btn{color:#fff;background-color:#4caf50;font-size:16px;border-radius:8px;border:0;width:180px;height:40px;cursor:pointer}.container{background-image:linear-gradient(87deg,#5e72e4 0,#825ee4 100%);min-width:480px;max-width:700px;border-radius:8px;height:auto;padding-bottom:10px}.body{padding:20px;background-color:#fff;text-align:start;border-radius:8px}.code{text-align:center;color:#000;font-size:18px}.m-auto{margin:auto}.m-10{margin:10px}.p-10{padding:10px}.text-center{text-align:center}.w-100{width:100%}
    </style>
</head>

<body>
    <div class="text-center">
        <div class="container">
            <div class="m-auto p-10 text-center">
                <img src="{$logo}" alt="">
            </div>
            <div class="m-10 body">
                <h2 class="text-center">Halo, {$pelanggan}!</h2>
                <br>
                <p>Pembayaranmu pada tanggal {$tanggal} sudah diverifikasi oleh {$verifier} nih! Tunggu sampai admin upload foto approval ya!</p>
                <p>Tekan tombol di bawah untuk membuka halaman detail produk.</p>
                <div class="text-center">
                    <a href="{$detail}">
                        <button class="btn">Detail Produk</button>
                    </a>
                </div>
            </div>
            <p style="color: white;">UCard Surabaya<br>Jl. Rungkut Harapan Blk. F No.008, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
        </div>
    </div>
</body>

</html>
HTML;
            break;
        case '4':
            // Approval
            $subject = 'UCard Surabaya - Pilih desain cetakanmu!';
            $message = <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$subject}</title>
    <style>
    body{background-color:#f5f5f5;text-align:center}.btn{color:#fff;background-color:#4caf50;font-size:16px;border-radius:8px;border:0;width:180px;height:40px;cursor:pointer}.container{background-image:linear-gradient(87deg,#5e72e4 0,#825ee4 100%);min-width:480px;max-width:700px;border-radius:8px;height:auto;padding-bottom:10px}.body{padding:20px;background-color:#fff;text-align:start;border-radius:8px}.code{text-align:center;color:#000;font-size:18px}.m-auto{margin:auto}.m-10{margin:10px}.p-10{padding:10px}.text-center{text-align:center}.w-100{width:100%}
    </style>
</head>

<body>

    <div class="text-center">
        <div class="container">
            <div class="m-auto p-10 text-center">
                <img src="{$logo}" alt="">
            </div>
            <div class="m-10 body">
                <h2 class="text-center">Halo, {$pelanggan}!</h2>
                <br>
                <p>Proses pemilihan desaimu {$tanggal} sudah diverifikasi oleh {$verifier} nih! Pilih desainnya sekarang untuk melanjutkan ke proses selanjutnya!</p>
                <p>Tekan tombol di bawah untuk membuka halaman detail produk.</p>
                <div class="text-center">
                    <a href="{$detail}">
                        <button class="btn">Detail Produk</button>
                    </a>
                </div>
            </div>
            <p style="color: white;">UCard Surabaya<br>Jl. Rungkut Harapan Blk. F No.008, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
        </div>
    </div>
</body>

</html>
HTML;
            break;
        case '5':
            // Cetak Produk
            $subject = 'UCard Surabaya - Pesananmu sudah selesai dicetak!';
            $message = <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$subject}</title>
    <style>
        body{background-color:#f5f5f5;text-align:center}.btn{color:#fff;background-color:#4caf50;font-size:16px;border-radius:8px;border:0;width:180px;height:40px;cursor:pointer}.container{background-image:linear-gradient(87deg,#5e72e4 0,#825ee4 100%);min-width:480px;max-width:700px;border-radius:8px;height:auto;padding-bottom:10px}.body{padding:20px;background-color:#fff;text-align:start;border-radius:8px}.code{text-align:center;color:#000;font-size:18px}.m-auto{margin:auto}.m-10{margin:10px}.p-10{padding:10px}.text-center{text-align:center}.w-100{width:100%}
    </style>
</head>

<body>
    <div class="text-center">
        <div class="container">
            <div class="m-auto p-10 text-center">
                <img src="{$logo}" alt="">
            </div>
            <div class="m-10 body">
                <h2 class="text-center">Halo, {$pelanggan}!</h2>
                <br>
                <p>Pesananmu pada tanggal {$tanggal} sudah selesai dicetak nih! Ayo cek sekarang juga!</p>
                <p>Tekan tombol di bawah untuk membuka halaman detail produk.</p>
                <div class="text-center">
                    <a href="{$detail}">
                        <button class="btn">Detail Produk</button>
                    </a>
                </div>
            </div>
            <p style="color: white;">UCard Surabaya<br>Jl. Rungkut Harapan Blk. F No.008, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
        </div>
    </div>
</body>

</html>
HTML;
            break;
        case '6':
            // Ambil/Kirim
            // Belum ada
            $subject = '';
            $message = <<<HTML

HTML;
            break;
        default:
            // Ditolak
            $subject = 'UCard Surabaya - Pesananmu ditolak!';
            $message = <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$subject}</title>
    <style>
        body{background-color:#f5f5f5;text-align:center}.btn{color:#fff;background-color:#4caf50;font-size:16px;border-radius:8px;border:0;width:180px;height:40px;cursor:pointer}.container{background-image:linear-gradient(87deg,#5e72e4 0,#825ee4 100%);min-width:480px;max-width:700px;border-radius:8px;height:auto;padding-bottom:10px}.body{padding:20px;background-color:#fff;text-align:start;border-radius:8px}.code{text-align:center;color:#000;font-size:18px}.m-auto{margin:auto}.m-10{margin:10px}.p-10{padding:10px}.text-center{text-align:center}.w-100{width:100%}
    </style>
</head>

<body>
    <div class="text-center">
        <div class="container">
            <div class="m-auto p-10 text-center">
                <img src="{$logo}" alt="">
            </div>
            <div class="m-10 body">
                <h2 class="text-center">Halo, {$pelanggan}!</h2>
                <br>
                <p>Pesananmu pada tanggal {$tanggal} ditolak! Silahkan perbaiki pesananmu agar proses dapat dilanjutkan.</p>
                <p>Tekan tombol di bawah untuk membuka halaman detail produk.</p>
                <div class="text-center">
                    <a href="{$detail}">
                        <button class="btn">Detail Produk</button>
                    </a>
                </div>
            </div>
            <p style="color: white;">UCard Surabaya<br>Jl. Rungkut Harapan Blk. F No.008, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>
        </div>
    </div>
</body>

</html>
HTML;
    }

    return [
        'subject' => $subject,
        'message' => $message,
    ];
}
