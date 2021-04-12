$('#btn_pass').click(() => {
	var pass1 = $('#pass1').val();
	var pass2 = $('#pass2').val();
	var action = $('#btn_pass').val();
	if ($('#currentPass').length) {
		var currentPass = $('#currentPass').val();
		var route = action+'=&currentPass='+currentPass+'&pass1='+pass1+'&pass2='+pass2;
	}else {
		var route = action+'&pass1='+pass1+'&pass2='+pass2;
	}
	$.ajax({
		type: 'post',
		url: 'internal_data',
		data: route
	})
	.done((res) => {
		var Toast = Swal.mixin({
			toast: false,
			position: 'center',
			showConfirmButton: false,
			timer: '2000',
			timerProgressBar: true
		});
		if (res) {
			Toast.fire({
				icon: 'success',
				title: '😃 Success!! 🥳',
				text: 'Información actualizada'
			});
		}else {
			Toast.fire({
				icon: 'error',
				title: '😦 Fail! 😞',
				text: 'Usuario no actualizado'
			});
		}
		if ($('#currentPass').length) { $('#currentPass').val(''); }
		$('#pass1').val('');
		$('#pass1').removeClass("is-valid");
		$('#mnsj').html('');
		$('#pass2').val('');
		$('#pass2').removeClass("is-valid");
		$('#mnsj2').html('');
		$("#modal_pwd").modal('hide');
	});
});