let form = document.getElementById('support-form');

form.addEventListener('submit', (e) => {
	e.preventDefault();

	let arr_data = new FormData(form);

	arr_data.append('newreqsupport', true);

	var Toast = Swal.mixin({
		toast: false,
		position: 'center',
		showConfirmButton: true
	});

	fetch('internal_data', {
		method: 'POST',
		body: arr_data
	})
	.then(res => res.json())
	.then(data => {
		if (data) {
			Toast.fire({
				icon: 'success',
				title: '😃 Success!! 🥳',
				text: 'Tu consulta ha sido enviada! 👍',
				confirmButtonText: '¡Genial!'
			})
			.then(()=>{
				location.reload();
			});
		}else {
			Toast.fire({
				icon: 'error',
				title: '😦 Fail! 😞',
				text: 'No se pudo enviar la consulta, verifica la información ingresada.',
				confirmButtonText: 'De acuerdo'
			}).then(()=>{
				location.reload();
			});
		}
	});
});