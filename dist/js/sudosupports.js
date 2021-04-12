function getmssg(id) {
	var idreq = id;
	var route = 'getsupportreq=&id='+idreq;
	$.ajax({
		type: 'post',
		url: 'internal_data',
		data: route
	})
	.done((res) => {
		let data =  JSON.parse(res);
		$('#modal-request').modal('show');
		$('#name').html(data.name);
		$('#subject').html('<strong>Asunto: </strong>'+data.subject);
		$('#mssg').html('<strong>Mensaje: </strong>'+data.mssg);
		$('#response').val(data.response);
		$('#sendres').val(data.idsupport);
	});
}

$('#sendres').click(() => {
	var id = $('#sendres').val();
	var response = $('#response').val();
	var route = 'savesupportres=&id='+id+'&response='+response;
	$.ajax({
		type: 'post',
		url: 'internal_data',
		data: route
	})
	.done((res) => {
		$('#modal-request').modal('hide');
		var Toast = Swal.mixin({
			toast: false,
			position: 'center',
			showConfirmButton: true
		});
		if (res) {
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