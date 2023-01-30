import {str_check, mail_check, validation} from './config.js';

var form = document.getElementById('register-form');

var	campos = {
	nombre: false,
	email: false,
	email2: false,
	country: false,
	lang: false,
	level: false,
	password: false
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

$("#country").change(function(){
	var valor = $(this).children("option:selected").val();

	if (valor != '') {
		$("#country").removeClass('is-invalid');
		$("#country").addClass('is-valid');
		campos.country = true;
	}else {
		$("#country").removeClass('is-valid');
		$("#country").addClass('is-invalid');
		campos.country = false;
	}

	validateform();
});

$("#lang").change(function(){
	var valor = $(this).children("option:selected").val();

	if (valor != '') {
		$("#lang").removeClass('is-invalid');
		$("#lang").addClass('is-valid');
		campos.lang = true;
	}else {
		$("#lang").removeClass('is-valid');
		$("#lang").addClass('is-invalid');
		campos.lang = false;
	}

	validateform();
});

$("#level").change(function(){
	var valor = $(this).children("option:selected").val();

	if (valor != '') {
		$("#level").removeClass('is-invalid');
		$("#level").addClass('is-valid');
		campos.level = true;
	}else {
		$("#level").removeClass('is-valid');
		$("#level").addClass('is-invalid');
		campos.level = false;
	}

	validateform();
});

$('#pass1').keyup(() => {
	var pass = document.getElementById('pass1');
	var mensaje = document.getElementById('mnsj');

	if (pass.value.length >= 8 && validation(pass.value) == true) {
		pass.className = 'form-control is-valid';
		mensaje.className = 'form-text text-success';
		mensaje.innerHTML = 'Contraseña válida';
	}else {
		pass.className = 'form-control is-invalid';
		mensaje.className = 'form-text text-danger';
		mensaje.innerHTML = 'Contraseña inválida';
	}
});

$('#pass2').keyup(() => {
	var pass1 = document.getElementById('pass1');
	var pass2 = document.getElementById('pass2');
	var mensaje = document.getElementById('mnsj2');

	if (pass2.value.length >= 8 && validation(pass2.value) == true)
	{
		pass2.className = 'form-control is-valid';

		if (pass1.value == pass2.value)
		{
			campos.password = true;
			mensaje.className = 'form-text text-success';
			mensaje.innerHTML = 'Las contraseñas coinciden!';
			validateform();
		}
		else
		{
			campos.password = false;
			pass2.className = 'form-control is-invalid';
			mensaje.className = 'form-text text-danger';
			mensaje.innerHTML = 'Contraseña inválida';
			validateform();
		}
	}
	else
	{
		campos.password = false;
		pass2.className = 'form-control is-invalid';
		mensaje.className = 'form-text text-danger';
		mensaje.innerHTML = 'Contraseña inválida';
		validateform();
	}
});

form.addEventListener('submit', async (e) => {

	e.preventDefault();

	let arr_data = new FormData(form);

	arr_data.append('newuser', true);

	Swal.fire({
        title: '✍️ Iniciando registro 👌',
        html: 'Estamos registrando los datos en nuestra base de datos, por favor no cierres la ventana del navegador.',
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const result = await fetch('internal_data', {
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
			confirmButtonText: `Aceptar`
		});
	}else {
		Swal.fire({
			icon: 'error',
			title: 'Usuario no registrado',
			text: 'Muy probablemente el usuario ya está registrado con nosotros. Verifica los datos y vuelve a intentarlo',
			confirmButtonText: `Aceptar`
		});
	}

	document.getElementById('register-form').reset();

	$('#name').removeClass('is-valid');
	$('#email').removeClass('is-valid');
	$('#email2').removeClass('is-valid');
	$('#country').removeClass('is-valid');
	$('#lang').removeClass('is-valid');
	$('#level').removeClass('is-valid');
	$('#pass1').removeClass('is-valid');
	$('#pass2').removeClass('is-valid');

	$('#name').removeClass('is-invalid');
	$('#email').removeClass('is-invalid');
	$('#email2').removeClass('is-invalid');
	$('#country').removeClass('is-invalid');
	$('#lang').removeClass('is-invalid');
	$('#level').removeClass('is-invalid');
	$('#pass1').removeClass('is-invalid');
	$('#pass2').removeClass('is-invalid');

	let mensaje1 = document.getElementById('mnsj');
	let mensaje2 = document.getElementById('mnsj2');

	mensaje1.className = 'form-text text-muted';
	mensaje1.innerHTML = 'Valores permitidos: Mayus, Minus, Números, _ . @';

	mensaje2.className = 'form-text text-muted';
	mensaje2.innerHTML = 'Valores permitidos: Mayus, Minus, Números, _ . @';
});