<!-- Header -->

<!-- Page content -->
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <table style="width: 100%;">
                        <tr>
                            <td style="text-align: left;">
                                <h3 class="mb-0" id="judul">Kupon</h3>
                            </td>
                            <td style="text-align: right;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i></button></td>
                        </tr>
                    </table>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table table-flush" id="datatable-basic">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Kode</th>
                                <th>Minimal Pembelian</th>
                                <th>Diskon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $n = 1;
                            foreach ($kupon as $k) : ?>
                                <tr>
                                    <td><?= $n++ ?></td>
                                    <td><?= $k['kupon_nama']; ?></td>
                                    <td><?= $k['kupon_deskripsi']; ?></td>
                                    <td><?= $k['kupon_kode']; ?></td>
                                    <td>Rp<?= number_format($k['kupon_min'] ?? 0, 2, ',', '.'); ?></td>
                                    <td><?= $k['kupon_persentase'] ? $k['kupon_persentase'] . '%' : 'Rp' . number_format($k['kupon_fixed'] ?? 0, 2, ',', '.'); ?></td>
                                    <td>
                                        <button data-id="<?= $k['kupon_id']; ?>" type="button" class="btn btn-info btn-sm edit" data-toggle="modal" data-target="#edit"><i class="fa fa-pen"></i></button>
                                        <button data-id="<?= $k['kupon_id']; ?>" type="button" class="btn btn-danger btn-sm hapus" data-toggle="modal" data-target="#hapus"><i class="fa fa-times"></i></button>
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

<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Tambah Kupon</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('Kupon/tambah_kupon') ?>">
                    <div class="form-group">
                        <label for="nama" class="required">Nama</label>
                        <input type="text" placeholder="Masukkan nama" id="nama" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" placeholder="Masukkan deskripsi" id="deskripsi" name="deskripsi" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kode" class="required">Kode</label>
                        <input type="text" placeholder="Masukkan kode kupon" id="kode" name="kode" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="min" class="required">Minimal Pembelian</label>
                        <input type="number" placeholder="Masukkan minimal pembelian" id="min" name="min" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="fixed" class="required">Diskon Rp</label>
                        <input type="number" placeholder="Masukkan diskon (Rupiah)" id="fixed" name="fixed" class="form-control" min="0" max="100" value="0" required>
                    </div>
                    <div class="form-group">
                        <label for="persentase" class="required">Diskon %</label>
                        <input type="number" placeholder="Masukkan diskon (persentase)" id="persentase" name="persentase" class="form-control" min="0" max="100" value="0" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                </form>
                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Edit Kupon</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div id="form_edit"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Hapus Kupon</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert_hapus"></div>
                <h3>Apakah anda yakin ingin menghapus kupon ini?</h3>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn_hapus">Hapus</button>
                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('.edit').click(function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('Kupon/get_edit') ?>",
            data: {
                kupon_id: $(this).attr('data-id')
            },
            success: function(data) {
                $('#form_edit').html(data);
            }
        });
    });
    $('#tambah #fixed').val() == ''
</script>