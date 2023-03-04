var cookie_form = document.getElementById('cookie_form');

cookie_form.addEventListener('submit', (e) => {
	e.preventDefault();

	let arr_data = new FormData(cookie_form);

	arr_data.append('cookielogin', true);

	arr_data.append('user', $('#user').val());

	fetch('external_data',{
		method: 'POST',
		body: arr_data
	})
	.then(res => res.json())
	.then(data => {

		if(data) {
			location.reload();
		} else {
			Swal.fire({
				icon: 'error',
				title: '😦 ¡Error! 😞',
				text: 'Hubo un problema al iniciar sesión, cerraremos tu sesión e ingresa tus datos nuevamente.',
				confirmButtonText: `Aceptar`
			});

			$('#user').val('');
			$('#pwd').val('');
		}
	});
});