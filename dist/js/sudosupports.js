function getmssg(id) {

	let arr_data = new FormData();

	arr_data.append('id', id);
	arr_data.append('getsupportreq', true);

	fetch('internal_data', {
		method: 'POST',
		body: arr_data
	})
	.then(res => res.json())
	.then(data => {
		$('#modal-request').modal('show');
		$('#name').html(data.name);
		$('#subject').html('<strong>Asunto: </strong>'+data.subject);
		$('#mssg').html('<strong>Mensaje: </strong>'+data.mssg);
		$('#response').val(data.response);
		$('#sendres').val(data.idsupport);
	});
}

$('#sendres').click(() => {

	let arr_dato = new FormData();

	arr_dato.append('id', $('#sendres').val());
	arr_dato.append('response', $('#response').val());
	arr_dato.append('savesupportres', true);

	var Toast = Swal.mixin({
		toast: false,
		position: 'center',
		showConfirmButton: true
	});

	fetch('internal_data', {
		method: 'POST',
		body: arr_dato
	})
	.then(res => res.json())
	.then(data => {
		$('#modal-request').modal('hide');
		if (data) {
			Toast.fire({
				icon: 'success',
				title: '😃 Success!! 🥳',
				text: 'Tu respuesta ha sido enviada! 👍',
				confirmButtonText: 'Continue..'
			}).then(()=>{
				location.reload();
			});
		}else {
			Toast.fire({
				icon: 'error',
				title: '😦 Fail! 😞',
				text: 'No se pudo enviar la respuesta',
				confirmButtonText: 'Continue..'
			}).then(()=>{
				location.reload();
			});
		}
	});
});