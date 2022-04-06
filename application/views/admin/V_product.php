<link rel="stylesheet" type="text/css" media="all" href="<?= base_url('assets/admin/css/mab-jquery-taginput.css?v2') ?>">

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
                                <h3 class="mb-0" id="judul">Produk</h3>
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
                                <th>Kode</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Detail</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($product as $p) : ?>
                                <tr>
                                    <td>
                                        <img style="width:100px;" src="<?= base_url('image/' . $p['product_image']) ?>" alt="">
                                    </td>
                                    <td><?= $p['product_kode'] ?></td>
                                    <td><?= $p['product_nama'] ?></td>
                                    <td><?= 'Rp' . number_format($p['product_harga'], 2, ',', '.'); ?></td>
                                    <td><button id="<?= $p['product_id'] ?>" type="button" class="btn btn-info btn-sm detail" data-toggle="modal" data-target="#detail"><i class="fa fa-eye"></i></button></td>
                                    <td>
                                        <button id="<?= $p['product_id'] ?>" type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit<?= $p['product_id'] ?>"><i class="fa fa-pen"></i></button>
                                        <button id="<?= $p['product_id'] ?>" type="button" class="btn btn-danger btn-sm hapus" data-toggle="modal" data-target="#hapus"><i class="fa fa-times"></i></button>
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
                <h6 class="modal-title" id="modal-title-default">Tambah Produk</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('Product/tambah_product') ?>" enctype="multipart/form-data">
                    <b>Kode</b><br>
                    <div class="form-group">
                        <input type="text" placeholder="Masukkan kode" name="kode" class="form-control">
                    </div>
                    <b>Nama</b><br>
                    <div class="form-group">
                        <input type="text" placeholder="Masukkan nama" name="nama" class="form-control">
                    </div>
                    <b>Kategori</b><br>
                    <div class="form-group">
                        <input type="text" class="form-control tag-input narrow" name="category" id="tags3" placeholder="Kategori">
                    </div>
                    <b>Tipe Produk</b><br>
                    <div class="form-group">
                        <select class="form-control" name="tipe">
                            <option value="0">Kartu</option>
                            <option value="1">Aksesoris</option>
                            <option value="2">Tali</option>
                        </select>
                    </div>
                    <b>Deskripsi</b><br>
                    <div class="form-group">
                        <textarea name="deskripsi" class="form-control" placeholder="Masukkan deskripsi"></textarea>
                    </div>
                    <b>Keunggulan</b><br>
                    <div class="form-group">
                        <textarea name="keunggulan" class="form-control" placeholder="Masukkan keunggulan"></textarea>
                    </div>
                    <b>Keterangan</b><br>
                    <div class="form-group">
                        <textarea name="keterangan" class="form-control" placeholder="Masukkan keterangan"></textarea>
                    </div>
                    <b>Harga</b><br>
                    <div class="form-group">
                        <input type="number" name="harga" class="form-control" placeholder="Masukkan harga">
                    </div>
                    <b>Gambar</b><br>
                    <div class="form-group">
                        <input type="file" class="form-control" name="gambar">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                </form>
                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php foreach ($product as $p) : ?>
    <div class="modal fade" id="edit<?= $p['product_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Edit Produk</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= base_url('Product/edit_product') ?>">
                        <input type="hidden" name="id" value="<?= $p['product_id'] ?>">
                        <b>Kode</b><br>
                        <div class="form-group">
                            <input type="text" placeholder="Masukkan kode" value="<?= $p['product_kode'] ?>" name="kode" class="form-control" required>
                        </div>
                        <b>Nama</b><br>
                        <div class="form-group">
                            <input type="text" placeholder="Masukkan nama" value="<?= $p['product_nama'] ?>" name="nama" class="form-control" required>
                        </div>
                        <b>Kategori</b><br>
                        <div class="form-group">
                            <input type="text" class="form-control tag-input narrow" value="<?= $this->M_category->kode_to_text($p['product_category'], '|') ?>" name="category" id="tags3" placeholder="Masukkan kategori" required>
                        </div>
                        <b>Tipe Produk</b><br>
                        <div class="form-group">
                            <select class="form-control" name="redirect">
                                <option value="0" <?= $p['product_tipe'] == 0 ? 'selected' : ''; ?>>Kartu</option>
                                <option value="1" <?= $p['product_tipe'] == 1 ? 'selected' : ''; ?>>Aksesoris</option>
                                <option value="2" <?= $p['product_tipe'] == 2 ? 'selected' : ''; ?>>Tali</option>
                            </select>
                        </div>
                        <b>Deskripsi</b><br>
                        <div class="form-group">
                            <textarea name="deskripsi" class="form-control" placeholder="Masukkan deskripsi" required><?= $p['product_deskripsi'] ?></textarea>
                        </div>
                        <b>Keunggulan</b><br>
                        <div class="form-group">
                            <textarea name="keunggulan" class="form-control" placeholder="Masukkan keunggulan"><?= $p['product_keunggulan'] ?></textarea>
                        </div>
                        <b>Keterangan</b><br>
                        <div class="form-group">
                            <textarea name="keterangan" class="form-control" placeholder="Masukkan keterangan"><?= $p['product_keterangan'] ?></textarea>
                        </div>
                        <b>Harga</b><br>
                        <div class="form-group">
                            <input type="number" name="harga" value="<?= $p['product_harga'] ?>" class="form-control" placeholder="Masukkan harga" required>
                        </div>
                        <b>Gambar</b><br>
                        <div class="form-group">
                            <input type="file" class="form-control" name="gambar">
                            <input type="hidden" value="<?= $p['product_image'] ?>" class="form-control" name="gambar_lama">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                    <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>

</div>
<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Hapus Produk</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert_hapus"></div>
                <h3>Apakah anda yakin ingin menghapus produk ini?</h3>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn_hapus">Hapus</button>
                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>
<div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Detail Produk</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div id="view_detail"></div>
        </div>
    </div>
</div>

</div>
<script type="text/javascript" src="<?= base_url('assets/admin/js/typeahead.bundle.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/js/mab-jquery-taginput.js?v2') ?>"></script>
<script>
    $(document).on('click', '.update', function() {
        var id = $(this).attr('id');
        var kode = $('#kode').val();
        var nama = $('#nama').val();
        var url = document.URL;
        if (kode !== '' && nama !== '') {
            $.ajax({
                type: "POST",
                url: "<?= base_url('Product/edit_product') ?>",
                data: {
                    id: id,
                    kode: kode,
                    nama: nama
                },
                success: function(data) {
                    $('#alert').html('<div class="alert alert-success alert-dismissible fade show" role="alert"><span class="alert-icon"><i class="fa fa-check"></i></span><span class="alert-text"><strong>Berhasil!</strong> Data terupdate</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    setTimeout(function() {
                        window.location.href = url;
                    }, 1000);
                }
            });
        } else {
            $('#alert').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><span class="alert-icon"><i class="fa fa-times"></i></span><span class="alert-text"><strong>Gagal!</strong> Data gagal terupdate</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    });

    $(document).on('click', '.hapus', function() {
        var id = $(this).attr('id');
        $('.btn_hapus').attr('id', id);
    });
    $(document).on('click', '.btn_hapus', function() {
        var url = document.URL;
        var id = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: "<?= base_url('Product/hapus_product') ?>",
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
    $('.detail').click(function() {
        var id = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: "<?= base_url('Product/get_detail') ?>",
            data: {
                id: id
            },
            success: function(data) {
                $('#view_detail').html(data);
            }
        })
    });
</script>
<script type="text/javascript">
    $(function() {

        // Instantiate the Bloodhound suggestion engine
        var tags = new Bloodhound({
            datumTokenizer: function(d) {
                return Bloodhound.tokenizers.whitespace(d.tag);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: [
                <?php foreach ($category as $c) : ?> {
                        tag: '<?= $c['category_nama'] ?>'
                    },
                <?php endforeach ?> {
                    tag: ''
                }
            ]
        });

        tags.initialize();

        // Set up an on-screen console for the demo
        var screenConsole = $('#console');

        // Write callback data to the screen when tags are added or removed in demo inputs
        var logCallbackDataToConsole = function(added, removed) {
            screenConsole.append('Tag Data: ' + (this.val() || null) + ', Added: ' + added + ', Removed: ' + removed + '\n');
        };

        // Create typeahead-enabled tag inputs
        $('.tag-input').tagInput({
            allowDuplicates: false,
            typeahead: true,
            typeaheadOptions: {
                highlight: true
            },
            typeaheadDatasetOptions: {
                display: function(d) {
                    return d.tag;
                },
                source: tags.ttAdapter()
            },
            onTagDataChanged: logCallbackDataToConsole
        });

        // Create basic tag inputs with no typeahead
        $('.tag-input-basic').tagInput({
            onTagDataChanged: logCallbackDataToConsole
        });

        $('#results a[rel="external"]').attr('target', '_blank');

    });
</script>