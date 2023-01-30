
req = 'selecttab';

function selecttab (tab) {
	data = 'nowselecttab='+tab;
	$.ajax({
		type: 'post',
		url: 'internal_data',
		data: data
	});
}

$('#tab-new-countries').click(() => {
	data = 'nowselecttab=new-countries';
	$.ajax({
		type: 'post',
		url: 'internal_data',
		data: data
	});
});

function edit(id) {

	let arr_data = new FormData();

	arr_data.append('id', id);
	arr_data.append('infocountries', true);

	fetch('internal_data', {
		method: 'POST',
		body: arr_data
	})
	.then(res => res.json())
	.then(data => {
		$('#edit-countries').modal('show');
		$('#editname').val(data.country);
		$('#editbadge').val(data.badge);
		$('#editcode').val(data.isocode);
		$('#btn_editcountry').val(data.idcountry);
	});
}

function change(id, status) {

	let arr_data = new FormData();

	arr_data.append('id', id);
	arr_data.append('status', status);
	arr_data.append('ch_countries_status', true);

	if (status === 1) {
		var titulo = '¿Deseas desactivar este país?';
		var mnsj = 'No podrás visualizarla en ningún formulario.';
		var confirm = 'Desactivar país';
		var color = '#F85656';
	}else {
		var titulo = '¿Deseas activar este país?';
		var mnsj = 'Aparecerá en todos los formularios que visualices.';
		var confirm = 'Activar país';
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
                        title: '😃 País actualizado!! 🥳',
                        confirmButtonText: `Genial! 👍`
                    }).then(()=>{
                        location.reload();
                    });
                }else {
                    Swal.fire({
                        icon: 'error',
                        title: '😦 Error 😞',
                        html: 'No se logró actualizar el país, intentalo nuevamente.',
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

$('#btn_editcountry').click(() => {
	let arr_data = new FormData();

	arr_data.append('editcountry', true);
	arr_data.append('country', $('#editname').val());
	arr_data.append('badge', $('#editbadge').val());
	arr_data.append('code', $('#editcode').val());
	arr_data.append('id', $('#btn_editcountry').val());

	fetch('internal_data', {
		method: 'POST',
		body: arr_data
	})
	.then(res => res.json())
	.then(data => {
		if (data) {
			Swal.fire({
				icon: 'success',
				title: '😃 País Actualizado! 🥳',
				confirmButtonText: `Genial! 👍`
			}).then(() => {
				location.reload();
			});
		}else {
			Swal.fire({
				icon: 'error',
				title: '😦 País no actualizado 😞',
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

	arr_data.append('new_country', true);

	fetch('internal_data', {
		method: 'POST',
		body: arr_data
	})
	.then(res => res.json())
	.then(data => {
		if (data) {
			Swal.fire({
				icon: 'success',
				title: '😃 País registrado! 🥳',
				confirmButtonText: `Genial! 👍`
			}).then(() => {
				location.reload();
			});
		}else {
			Swal.fire({
				icon: 'error',
				title: '😦 País no registrado 😞',
				html: '<p>Por favor verifica los datos e intenta nuevamente.</p>',
				confirmButtonText: `De acuerdo! 👍`
			}).then(() => {
				location.reload();
			});
		}
	});
});