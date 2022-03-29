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
                            <td style="text-align: right;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addimage"><i class="fa fa-plus"></i></button></td>
                        </tr>
                    </table>
                </div>

                <!-- Light table -->
                <div class="table-responsive">
                    <table class="table table-flush" id="datatable-basic">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Image Name</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $n = 1;
                            foreach ($image as $i) : ?>
                                <?php $id = $i['image_admin_id'];
                                $a = $this->db->get_where('tbl_admin', ['admin_id' => $id])->row_array(); ?>
                                <tr>
                                    <td><?= $n++ ?></td>
                                    <td><?= $a['admin_nama'] ?>
                                    </td>
                                    <td><?= $i['image_nama'] ?></td>
                                    <td style="text-align: center;"><img style="width: 100px;" src="<?= base_url('image_assets/' . $i['image_nama']) ?>" alt=""></td>
                                    <td>
                                        <button id="<?= $i['image_id'] ?>" name="<?= $i['image_nama'] ?>" type="button" class="btn btn-danger btn-sm hapus" data-toggle="modal" data-target="#hapus"><i class="fa fa-times"></i></button>
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
<!-- Modal -->
<div class="modal fade" id="addimage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Image/tambah_image') ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Upload</label>
                        <input type="file" name="image" class="form-control" required>
                        <input type="hidden" name="id_user" value="<?= $_SESSION['admin_id'] ?>" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Hapus status</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert_hapus"></div>
                <h3>Apakah anda yakin?</h3>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn_hapus">hapus</button>
                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

</div>

<script>
    $(document).on('click', '.hapus', function() {
        var id = $(this).attr('id');
        var nama = $(this).attr('name');
        $('.btn_hapus').attr('id', id);
        $('.btn_hapus').attr('name', nama);
    });
    $(document).on('click', '.btn_hapus', function() {
        var url = document.URL;
        var id = $(this).attr('id');
        var nama = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "<?= base_url('Image/hapus_image_assets') ?>",
            data: {
                id: id,
                nama: nama
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