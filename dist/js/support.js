$('#sendreq').click(() => {
	var subject = $('#subject').val();
	var mssg = $('#mssg').val();
	var route = 'newreqsupport=&subject='+subject+'&mssg='+mssg;
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