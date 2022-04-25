<button id="notif-pesan-tombol" type="button" style="display:none;" data-toggle="modal" data-target="#notif-pesan"></button>
<div class="modal fade" id="notif-pesan" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Notification</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <h2>Ada pesanan baru!</h2>
            </div>
            <div class="modal-footer">
                <a href="<?= base_url('Order/verifikasi') ?>" class="btn btn-primary ml-auto">Lihat</a>
            </div>
        </div>
    </div>
</div>

<!-- Argon Scripts -->
<!-- Core -->
<script src="<?= base_url('assets/admin/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/vendor/js-cookie/js.cookie.js') ?>"></script>
<script src="<?= base_url('assets/admin/vendor/jquery.scrollbar/jquery.scrollbar.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') ?>"></script>
<!-- Optional JS -->
<script src="<?= base_url('assets/admin/vendor/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/vendor/datatables.net-buttons/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/vendor/datatables.net-buttons/js/buttons.flash.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/vendor/datatables.net-buttons/js/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/vendor/datatables.net-select/js/dataTables.select.min.js') ?>"></script>
<!-- Argon JS -->
<script src="<?= base_url('assets/admin/js/argon.js?v=1.1.0') ?>"></script>
<!-- Demo JS - remove this in your project -->
<script src="<?= base_url('assets/admin/js/demo.min.js') ?>"></script>
<button style="display:none;" id="notif" onclick="notifyMe()"></button>
</body>

</html>
<script>
    $("body").addClass((window.innerWidth <= 1200 ? "g-sidenav-hidden" : "g-sidenav-pinned"));

    var po = document.getElementById('pill-o');
    var pv = document.getElementById('pill-v');
    var pd = document.getElementById('pill-d');
    var pp = document.getElementById('pill-p');
    var pa = document.getElementById('pill-a');
    var pc = document.getElementById('pill-c');
    var pk = document.getElementById('pill-k');
    var btnNotif = document.getElementById('notif-pesan-tombol');

    window.setInterval(function() {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('Order/check') ?>',
            success: function(data) {
                data = JSON.parse(data);

                po.textContent = data.o;
                pd.textContent = data.d;
                pp.textContent = data.p;
                pa.textContent = data.a;
                pc.textContent = data.c;
                pk.textContent = data.k;

                if (pv.textContent < data.v) btnNotif.click();
                else pv.textContent = data.v;
            }
        });
    }, 6000);
</script>