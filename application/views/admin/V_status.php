<style>
    .jangka {
        height: fit-content;
        width: 50px;
    }
</style>

<!-- Header -->

<!-- Page content -->
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header bstatus-0">
                    <table style="width: 100%;">
                        <tr>
                            <td style="text-align: left;">
                                <h3 class="mb-0" id="judul">Status</h3>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table table-flush" id="datatable-basic">
                        <thead>
                            <tr>
                                <th>Icon</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Aktifkan?</th>
                                <th>Jangka Hari</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($status as $s) : ?>
                                <tr>
                                    <td><i class="<?= $s['status_icon'] ?> fa-2x"></i></td>
                                    <td><?= $s['status_status'] ?></td>
                                    <td><?= $s['status_keterangan'] ?></td>
                                    <td class="text-center">
                                        <input id-s="<?= $s['status_id'] ?>" id="jangka_tidak_ada<?= $s['status_id'] ?>" type="checkbox" value="1" class="jangka_tidak_ada" <?= !is_null($s['status_jangka_waktu']) ? 'checked' : ''; ?>>
                                    </td>
                                    <td class="p-2 text-center">
                                        <input class="form-control m-auto jangka" id-s="<?= $s['status_id']; ?>" id="jangka<?= $s['status_id'] ?>" type="number" placeholder="Hari" min="1" <?= is_null($s['status_jangka_waktu']) ? 'value="1" style="display: none;"' : 'value="' . $s["status_jangka_waktu"] . '"'; ?>>
                                    </td>
                                </tr>
                            <?php endforeach ?>
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
    $('.jangka_tidak_ada').change(function() {
        var id = $(this).attr('id-s');
        if ($(this).is(":checked")) {
            $('#jangka' + id).css('display', 'block');
            var j = 1;
            $.ajax({
                type: 'POST',
                url: '<?= base_url('Status/status_jangka') ?>',
                data: {
                    id: id,
                    j: j
                },
                success: function(data) {

                }
            });
        } else {
            $('#jangka' + id).css('display', 'none');
            var j = 0;
            $.ajax({
                type: 'POST',
                url: '<?= base_url('Status/status_jangka') ?>',
                data: {
                    id: id,
                    j: j
                },
                success: function(data) {

                }
            });
        }
    });
    $('.jangka').change(function() {
        var h = $(this).val();
        var id = $(this).attr('id-s');
        $.ajax({
            type: 'POST',
            url: '<?= base_url('Status/status_hari') ?>',
            data: {
                id: id,
                h: h
            }
        });
    });
</script>