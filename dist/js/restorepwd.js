import {url} from './socialconfig.js';

$('#btn_pass').click(() => {
	var pass1 = $('#pass1').val();
	var pass2 = $('#pass2').val();
	var route = 'restorepwd=&pass1='+pass1+'&pass2='+pass2;
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
		if (res) {
			$('#restore-card').hide();
			Toast.fire({
				icon: 'success',
				title: '😃 Success!! 🥳',
				text: 'Contraseña restablecida con éxito!',
				confirmButtonText: `Iniciar sesión 👍`
			}).then(()=>{
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