import {str_check, mail_check} from './config.js';

var form = document.getElementById('register-form');

var	campos = {
	nombre: false,
	email: false,
	email2: false
}

const validateform = () => {
	let res = true;
	let btn = document.getElementById('btn_register');

	for (var val in campos) {
	    if (!campos[val]) {
	    	res = false;
	    	break;
	    }
	}

	if (res)
		btn.disabled = false;
	else
		btn.disabled = true;
}

$("#name").keyup(() => {

	let name = document.getElementById('name').value;

	if (str_check(name.trim()))
	{
		$("#name").removeClass('is-invalid');
		$("#name").addClass('is-valid');
		campos.nombre = true;
	}
	else
	{
		$("#name").removeClass('is-valid');
		$("#name").addClass('is-invalid');
		campos.nombre = false;
	}

	validateform();
});

$("#email").keyup(() => {

	let email = document.getElementById('email').value;

	if (mail_check(email.trim()))
	{
		$("#email").removeClass('is-invalid');
		$("#email").addClass('is-valid');
		campos.email = true;
	}
	else
	{
		$("#email").removeClass('is-valid');
		$("#email").addClass('is-invalid');
		campos.email = false;
	}

	validateform();
});

$("#email2").keyup(() => {

	let email2 = document.getElementById('email2').value;

	if (mail_check(email2.trim()))
	{
		let email = document.getElementById('email').value;
		let email2 = document.getElementById('email2').value;

		if (email === email2)
		{
			$("#email2").removeClass('is-invalid');
			$("#email2").addClass('is-valid');
			campos.email2 = true;
		}
		else
		{
			$("#email2").removeClass('is-valid');
			$("#email2").addClass('is-invalid');
			campos.email2 = false
		}
	}
	else
	{
		$("#email2").removeClass('is-valid');
		$("#email2").addClass('is-invalid');
		campos.email2 = false;
	}

	validateform();
});

form.addEventListener('submit', async (e) => {

	e.preventDefault();

	let arr_data = new FormData(form);

	arr_data.append('newregister', true);

	Swal.fire({
        title: '✍️ Iniciando registro 👌',
        html: 'Estamos registrando sus datos en nuestra base de datos, por favor no cierre la ventana del navegador.',
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
			title: 'Usuario registrado',
			text: 'Te hemos enviado un correo electrónico con los pasos finales de registro.',
			confirmButtonText: `Aceptar`
		})
		.then(() => {
			window.open(window.location+'?action=login','_self');
		});
	}else {
		Swal.fire({
			icon: 'error',
			title: 'Usuario no registrado',
			text: '¿Ya estás registrado con nosotros? intenta restablecer tu contraseña o verifica tus datos y vuelve a intentarlo.',
			confirmButtonText: `Aceptar`
		});
	}

	$('#name').val('');
	$('#email').val('');
	$('#email2').val('');
	$('#name').removeClass('is-valid');
	$('#email').removeClass('is-valid');
	$('#email2').removeClass('is-valid');
	$('#name').removeClass('is-invalid');
	$('#email').removeClass('is-invalid');
	$('#email2').removeClass('is-invalid');
});