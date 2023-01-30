
req = 'selecttab';

function selecttab (tab) {
	data = 'nowselecttab='+tab;
	$.ajax({
		type: 'post',
		url: 'internal_data',
		data: data
	});
}

$('#tab-new-language').click(() => {
	data = 'nowselecttab=new-language';
	$.ajax({
		type: 'post',
		url: 'internal_data',
		data: data
	});
});

function edit(id) {

	let arr_data = new FormData();

	arr_data.append('id', id);
	arr_data.append('infolanguage', true);

	fetch('internal_data', {
		method: 'POST',
		body: arr_data
	})
	.then(res => res.json())
	.then(data => {
		$('#edit-language').modal('show');
		$('#editname').val(data.language);
		$('#editlancode').val(data.lancode);
		$('#editlanicon').val(data.lanicon);
		$('#btn_editlanguage').val(data.idlang);
	});
}

function change(id, status) {

	let arr_data = new FormData();

	arr_data.append('id', id);
	arr_data.append('status', status);
	arr_data.append('ch_language_status', true);

	if (status === 1) {
		var titulo = '¿Deseas desactivar este idioma?';
		var mnsj = 'No podrás visualizarla en ningún formulario.';
		var confirm = 'Desactivar idioma';
		var color = '#F85656';
	}else {
		var titulo = '¿Deseas activar este idioma?';
		var mnsj = 'Aparecerá en todos los formularios que visualices.';
		var confirm = 'Activar idioma';
		var color = '#45B25D';
	}

	Swal.fire({
        icon: 'question',
        title: titulo,
        html: mnsj,
        showCancelButton: true,
        confirmButtonText: confirm,
        confirmButtonColor: color,
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('internal_data', {
                method: 'POST',
                body: arr_data
            })
            .then(res => res.json())
            .then(data => {
                if (data) {
                    Swal.fire({
                        icon: 'success',
                        title: '😃 Idioma actualizado!! 🥳',
                        confirmButtonText: `Genial! 👍`
                    }).then(()=>{
                        location.reload();
                    });
                }else {
                    Swal.fire({
                        icon: 'error',
                        title: '😦 Error 😞',
                        html: 'No se logró actualizar el idioma, intentalo nuevamente.',
                        confirmButtonText: `Ok! 👍`
                    }).then(()=>{
                        location.reload();
                    });
                }
            });
        } else if (result.isDenied) {
            Swal.fire('Acción cancelada', '', 'info');
        }
    });
}

$('#btn_editlanguage').click(() => {
	let arr_data = new FormData();

	arr_data.append('editlanguage', true);
	arr_data.append('language', $('#editname').val());
	arr_data.append('lancode', $('#editlancode').val());
	arr_data.append('lanicon', $('#editlanicon').val());
	arr_data.append('id', $('#btn_editlanguage').val());

	fetch('internal_data', {
		method: 'POST',
		body: arr_data
	})
	.then(res => res.json())
	.then(data => {
		if (data) {
			Swal.fire({
				icon: 'success',
				title: '😃 Idioma Actualizado! 🥳',
				confirmButtonText: `Genial! 👍`
			}).then(() => {
				location.reload();
			});
		}else {
			Swal.fire({
				icon: 'error',
				title: '😦 Idioma no actualizado 😞',
				html: '<p>Por favor verifica los datos e intenta nuevamente.</p>',
				confirmButtonText: `De acuerdo! 👍`
			}).then(() => {
				location.reload();
			});
		}
	});
});

var new_form = document.getElementById('new_form');

new_form.addEventListener('submit', (e) => {
	e.preventDefault();

	let arr_data = new FormData(new_form);

	arr_data.append('new_language', true);

	fetch('internal_data', {
		method: 'POST',
		body: arr_data
	})
	.then(res => res.json())
	.then(data => {
		if (data) {
			Swal.fire({
				icon: 'success',
				title: '😃 Idioma registrado! 🥳',
				confirmButtonText: `Genial! 👍`
			}).then(() => {
				location.reload();
			});
		}else {
			Swal.fire({
				icon: 'error',
				title: '😦 Idioma no registrado 😞',
				html: '<p>Por favor verifica los datos e intenta nuevamente.</p>',
				confirmButtonText: `De acuerdo! 👍`
			}).then(() => {
				location.reload();
			});
		}
	});
});