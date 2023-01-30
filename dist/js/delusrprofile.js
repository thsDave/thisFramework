$("#userdel").hide();

$("#delphrase").keyup(() => {

	let arr_data = new FormData();

	arr_data.append('phrase', $("#delphrase").val());
	arr_data.append('valphrase', true);

	fetch('internal_data', {
		method: 'POST',
		body: arr_data
	})
	.then(res => res.json())
	.then(data => {
		if (data) {
			$("#userdel").show();
		}else {
			$("#userdel").hide();
		}
	});
});

$("#userdel").click(() => {

	let arr_data = new FormData();

	arr_data.append('phrase', $("#delphrase").val());
	arr_data.append('deluser', true);

	fetch('internal_data', {
		method: 'POST',
		body: arr_data
	})
	.then(res => res.json())
	.then(data => {
		if (data) {
			Swal.fire({
				icon: 'success',
				title: '😃 Exito!! 🥳',
				html: 'El estado del usuario ha pasado a inactivo.<br>No podrá iniciar sesión hasta que su estado vuelva a activarse.'
			});
		}else {
			Swal.fire({
				icon: 'error',
				title: '😦 Fail! 😞',
				text: 'No se pudo eliminar el usuario'
			});
		}
	}).then(()=>{
		$("#userdel").hide();
		$("#delphrase").val('');
		$("#modal_del").modal('hide');
	});
});