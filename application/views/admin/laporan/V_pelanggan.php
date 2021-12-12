<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pelanggan</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
</head>

<body class="container mt-4">
    <div class="text-center">
        <h5>PT. SOLUSI KARTU INDONESIA</h5>
        <h2>Laporan Pelanggan</h2>
    </div>
    <br>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col" style="width: 48px;">No</th>
                <th scope="col" style="width: 100px;">ID Pelanggan</th>
                <th scope="col" style="width: 180px;">Nama</th>
                <th scope="col" style="width: 120px;">No. Telepon</th>
                <th scope="col" style="width: 120px;">Handphone</th>
                <th scope="col" style="width: 120px;">E-mail</th>
                <th scope="col" style="width: 300px;">Alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($data as $val) { ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $val['pelanggan_id']; ?></td>
                    <td><?= $val['pelanggan_nama']; ?></td>
                    <td><?= $val['pelanggan_nohp']; ?></td>
                    <td><?= $val['pelanggan_telephone']; ?></td>
                    <td><?= $val['pelanggan_email']; ?></td>
                    <td><?= $val['pelanggan_alamat']; ?></td>
                </tr>
                <?php $i++; ?>
            <?php } ?>
        </tbody>
    </table>
    <p>Dicetak pada tanggal <?= date("j F Y"); ?> jam <?= date("h:i:s"); ?></p>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>