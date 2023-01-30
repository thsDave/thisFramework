var login_form = document.getElementById('login_form');

login_form.addEventListener('submit', (e) => {
	e.preventDefault();

	let arr_data = new FormData(login_form);

	arr_data.append('localogin', true);

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
				title: '😦 Fail! 😞',
				text: 'Usuario y/o Contraseña incorrectos',
				confirmButtonText: `Ok! 👍`
			});

			$('#user').val('');
			$('#pwd').val('');
		}
	});
});

