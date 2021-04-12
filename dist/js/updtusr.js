$('#updtinfousr').click(() => {
	var name = $('#name').val();
	var position = $('#position').val();
	var level = $('#level').val();
	var state = $('#state').val();
	var route = 'updtinfousr=&name='+name+'&position='+position+'&level='+level+'&state='+state;
	$.ajax({
		type: 'post',
		url: 'internal_data',
		data: route
	})
	.done((res) => {
		var Toast = Swal.mixin({
			toast: false,
			position: 'center',
			showConfirmButton: true
		});
		if (res) {
			Toast.fire({
				icon: 'success',
				title: '😃 Success!! 🥳',
				text: 'La información del usuario ha sido actualizada! 👍',
				confirmButtonText: 'Continue..'
			}).then(()=>{
				location.reload();
			});
		}else {
			Toast.fire({
				icon: 'error',
				title: '😦 Fail! 😞',
				text: 'Usuario no actualizado',
				confirmButtonText: 'Continue..'
			});
		}
	});
});