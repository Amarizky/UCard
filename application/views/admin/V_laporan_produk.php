<!-- Header -->

<!-- Page content -->
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header bstatus-0">
                    <div class="row">
                        <div class="col">
                            <h3>Laporan Produk</h3>
                        </div>
                        <div class="col text-right">
                            <div class="text-left ml-auto" style="width: 140px;">
                                <input type="radio" name="interval" id="rad_30_hari" checked>
                                <label for="rad_30_hari" style="margin: 0 !important;">30 hari terakhir</label>
                                <br>
                                <input type="radio" name="interval" id="rad_semua">
                                <label for="rad_semua" style="margin: 0 !important;">Semua</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Light table -->
                <div id="tab-30" class="table-responsive">
                    <table class="table table-flush" id="table-30">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Produk</th>
                                <th>Harga Satuan</th>
                                <th>Terjual</th>
                                <th>Total Penjualan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $n = 1;
                            foreach ($data30 as $d) :
                            ?>
                                <tr>
                                    <td><?= $n++ ?></td>
                                    <td><?= $d['product_kode'] ?></td>
                                    <td><?= $d['product_nama'] ?></td>
                                    <td>Rp<?= number_format($d['product_harga'], 2, ',', '.'); ?></td>
                                    <td><?= $d['terjual'] ?></td>
                                    <td>Rp<?= number_format($d['total'], 2, ',', '.'); ?></td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="tab-semua" class="table-responsive" style="display: none;">
                    <table class="table table-flush" id="table-semua">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Produk</th>
                                <th>Harga Satuan</th>
                                <th>Terjual</th>
                                <th>Total Penjualan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $n = 1;
                            foreach ($dataSemua as $d) :
                            ?>
                                <tr>
                                    <td><?= $n++ ?></td>
                                    <td><?= $d['product_kode'] ?></td>
                                    <td><?= $d['product_nama'] ?></td>
                                    <td>Rp<?= number_format($d['product_harga'], 2, ',', '.'); ?></td>
                                    <td><?= $d['terjual'] ?></td>
                                    <td>Rp<?= number_format($d['total'], 2, ',', '.'); ?></td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- Card footer -->
                <div class="card-footer py-4">
                    <nav aria-label="...">
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#rad_30_hari').click(function() {
            $('#tab-30').show();
            $('#tab-semua').hide();
        });
        $('#rad_semua').click(function() {
            $('#tab-semua').show();
            $('#tab-30').hide();
        });
        var options = {
            keys: !0,
            select: {
                style: "multi"
            },
            language: {
                paginate: {
                    previous: "<i class='fas fa-angle-left'>",
                    next: "<i class='fas fa-angle-right'>"
                }
            }
        };

        $('#table-30').DataTable(options);
        $('#table-semua').DataTable(options);
    });
</script>