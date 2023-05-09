</div>
<!-- jquery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- adminlte -->
<script src="dist/js/adminlte.min.js"></script>
<!-- sweetalert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>

<script>
	$(document).ready(function () {
		$('[data-toggle="tooltip"]').tooltip();
		$('[data-toggle="popover"]').popover({ container: 'body' });
		$('.select2').select2({ theme: 'bootstrap4' });
	});
</script>