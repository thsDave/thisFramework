$('#btn_pass').click(() => {
	const arr_data = new FormData();

	arr_data.append('restorepwd', true);
	arr_data.append('pass1', $('#pass1').val());
	arr_data.append('pass2', $('#pass2').val());

	fetch('external_data', {
		method: 'POST',
		body: arr_data
	})
	.then(res => res.json())
	.then(data => {
		var Toast = Swal.mixin({
			toast: false,
			position: 'center',
			showConfirmButton: true
		});
		if (data) {
			$('#restore-card').hide();
			Toast.fire({
				icon: 'success',
				title: '😃 Success!! 🥳',
				text: 'Contraseña restablecida con éxito!',
				confirmButtonText: `Iniciar sesión 👍`
			}).then(()=>{
				let url = window.location;
				window.open(url+'?action=login','_self');
			});
		}else {
			Toast.fire({
				icon: 'error',
				title: '😦 Fail! 😞',
				text: 'No se pudo restablecer la contraseña, intenta nuevamente',
				confirmButtonText: `Ok! 👍`
			});
		}
	});
});