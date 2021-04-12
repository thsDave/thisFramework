$('#login').click(() => {
	var user = $('#user').val();
	var pwd = $('#pwd').val();
	var remember = $('#remember').val();
	var route = 'localogin=&user='+user+'&pwd='+pwd+'&remember='+remember;
	$.ajax({
		type: 'post',
		url: 'external_data',
		data: route
	})
	.done((res) => {
		var Toast = Swal.mixin({
			toast: false,
			position: 'center',
			showConfirmButton: true
		});
		console.log(res);
		if (res) {
			location.reload();
		}else {
			Toast.fire({
				icon: 'error',
				title: '😦 Fail! 😞',
				text: 'Usuario y/o Contraseña incorrectos',
				confirmButtonText: `Ok! 👍`
			});
		}
	});
});