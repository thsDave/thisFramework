import {mail_check} from './config.js';

var form = document.getElementById('forgot-form');

var btn = document.getElementById('btn');

btn.disabled = true;

$("#mail").keyup(() => {
	$('#mnsj').html('');
	$("#mnsj").removeClass('text-muted');
	$("#mnsj").removeClass('text-danger');
	$("#mnsj").removeClass('text-success');

	let email = document.getElementById('mail').value;

	if (mail_check(email.trim()))
	{
		let arr_data = new FormData();

		arr_data.append('isavailablemail', true);
		arr_data.append('email', email);

		fetch('external_data', {
			method: 'POST',
			body: arr_data
		})
		.then(res => res.json())
		.then(data => {

			if (data) {
				$("#mail").removeClass('is-invalid');
				$("#mail").addClass('is-valid');

				$("#mnsj").addClass('text-success');
				$('#mnsj').html('e-mail registrado');
				btn.disabled = false;
			}else {
				$("#mail").removeClass('is-valid');
				$("#mail").addClass('is-invalid');

				$("#mnsj").addClass('text-danger');
				$('#mnsj').html('e-mail no registrado');
				btn.disabled = true;
			}

		});
	}
	else
	{
		$("#mail").removeClass('is-valid');
		$("#mail").addClass('is-invalid');

		$("#mnsj").addClass('text-danger');
		$('#mnsj').html('e-mail inválido');
		btn.disabled = true;
	}
});

form.addEventListener('submit', async (e) => {

	e.preventDefault();

	let arr_data = new FormData(form);

	arr_data.append('forgot-email', true);

	Swal.fire({
        title: '📨 Iniciando restablecimiento 📬',
        html: 'Estamos enviando las instrucciones por correo electrónico, por favor no cierres la ventana del navegador.',
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const result = await fetch('external_data', {
        method: 'POST',
        body: arr_data
    })
    .then(res => res.json())
    .then(data => {
        return data;
    });

	if (result) {
		Swal.fire({
			icon: 'success',
			title: '😃 Restablecimiento iniciado 🥳',
			text: 'Por favor revisa tu correo y sigue las instrucciones.',
			confirmButtonText: `De acuerdo 👍`
		})
		.then(() => {
			let url = window.location;
			window.open(url+'?action=login','_self');
		});
	}else {
		Swal.fire({
			icon: 'error',
			title: '😯 Error 😯',
			text: 'Ingresa un correo electrónico válido',
			confirmButtonText: `Aceptar 👍`
		});
	}

	$('#mail').val('');

});