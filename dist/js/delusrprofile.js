$(document).ready(function () {

	$("#userdel").hide();

	$("#delphrase").keyup(() => {
		var delphrase = $("#delphrase").val();
		var ruta = "valphrase=&phrase="+delphrase;
		$.ajax({
			type: 'post',
			url: 'internal_data',
			data: ruta
		}).done(function(res){
			if (res) {
				$("#userdel").show();
			}else {
				$("#userdel").hide();
			}
		});
	});

	$("#userdel").click(() => {
		var delphrase = $("#delphrase").val();
		var ruta = "deluser=&phrase="+delphrase;
		$.ajax({
			type: 'post',
			url: 'internal_data',
			data: ruta
		}).done(function(res){
			var Toast = Swal.mixin({
				toast: false,
				position: 'center',
				showConfirmButton: false,
				timer: '2000',
				timerProgressBar: true
			});
			if (res) {
				let url = window.location['href']+'?req=users';
				window.open(url,'_self');
			}else {
				Toast.fire({
					icon: 'error',
					title: '😦 Fail! 😞',
					text: 'No se pudo eliminar el usuario'
				});
				$("#userdel").hide();
				$("#delphrase").val('');
				$("#modal_del").modal('hide');
			}
		});
	});
});