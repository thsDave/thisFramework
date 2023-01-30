import {str_check, validation} from './config.js';

var req = 'selecttab';

$.ajax({
	type: 'post',
	url: 'internal_data',
	data: req
}).done(function(idtab){
	$('a[href="#'+idtab+'"]').tab('show');
});

$('#profile-info-tab').click(() => {
	let data = 'nowselecttab=info';
	$.ajax({
		type: 'post',
		url: 'internal_data',
		data: data
	});
});

$('#profile-access-tab').click(() => {
	let data = 'nowselecttab=access';
	$.ajax({
		type: 'post',
		url: 'internal_data',
		data: data
	});
});

/************************************************************************************************/

function picprofile(val) {
	let arr_data = new FormData();

	arr_data.append('id', val);
	arr_data.append('picprofile', true);

	fetch('internal_data', {
		method: 'POST',
		body: arr_data
	})
	.then(res => res.json())
	.then(data => {

		$('#picProfile').modal('hide');

		if (data) {
			Swal.fire({
				icon: 'success',
				title: '😃 Exito!! 🥳',
				text: 'Imagen de perfil actualizada con éxito!',
				confirmButtonText: `Genial 👍`
			}).then(()=>{
				location.reload();
			});
		}else {
			Swal.fire({
				icon: 'error',
				title: '😦 Error! 😞',
				text: 'La imagen de perfil no pudo se actualizada.',
				confirmButtonText: 'Continuar 😞'
			});
		}
	});
}

/************************************************************************************************/

var btn = document.getElementById('btn_update');

$("#name").keyup(() => {
	let name = document.getElementById('name').value;

	if (str_check(name.trim())) {
		$("#name").removeClass('is-invalid');
		$("#name").addClass('is-valid');
		btn.disabled = false;
	}else {
		$("#name").removeClass('is-valid');
		$("#name").addClass('is-invalid');
		btn.disabled = true;
	}
});

$("#country").change(function(){
	var valor = $(this).children("option:selected").val();

	if (valor != '') {
		$("#country").removeClass('is-invalid');
		$("#country").addClass('is-valid');
		btn.disabled = false;
	}else {
		$("#country").removeClass('is-valid');
		$("#country").addClass('is-invalid');
		btn.disabled = true;
	}
});

$("#lang").change(function(){
	var valor = $(this).children("option:selected").val();

	if (valor != '') {
		$("#lang").removeClass('is-invalid');
		$("#lang").addClass('is-valid');
		btn.disabled = false;
	}else {
		$("#lang").removeClass('is-valid');
		$("#lang").addClass('is-invalid');
		btn.disabled = true;
	}
});

$("#level").change(function(){
	var valor = $(this).children("option:selected").val();

	if (valor != '') {
		$("#level").removeClass('is-invalid');
		$("#level").addClass('is-valid');
		btn.disabled = false;
	}else {
		$("#level").removeClass('is-valid');
		$("#level").addClass('is-invalid');
		btn.disabled = true;
	}
});

$("#status").change(function(){
	var valor = $(this).children("option:selected").val();

	if (valor != '') {
		$("#status").removeClass('is-invalid');
		$("#status").addClass('is-valid');
		btn.disabled = false;
	}else {
		$("#status").removeClass('is-valid');
		$("#status").addClass('is-invalid');
		btn.disabled = true;
	}
});

var userProfileForm = document.getElementById('user_form');

userProfileForm.addEventListener('submit', (e) => {
	e.preventDefault();

	let arr_data = new FormData(userProfileForm);

	arr_data.append('update_user', 'true');

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
				text: 'La información del usuario ha sido actualizada! 👍',
				confirmButtonText: 'Aceptar'
			}).then(()=>{
				location.reload();
			});
		}else {
			Swal.fire({
				icon: 'error',
				title: '😦 Error! 😞',
				text: 'Usuario no actualizado',
				confirmButtonText: 'Aceptar'
			});
		}
	});
});

/************************************************************************************************/

var btn = document.getElementById('btn_pass');

btn.disabled = true;

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
		mensaje.innerHTML = 'Valores permitidos: Mayus, Minus, Números, _ . @';
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
			mensaje.className = 'form-text text-success';
			mensaje.innerHTML = 'Las contraseñas coinciden!';
			btn.disabled = false;
		}
		else
		{
			pass2.className = 'form-control is-invalid';
			mensaje.className = 'form-text text-danger';
			mensaje.innerHTML = 'Valores permitidos: Mayus, Minus, Números, _ . @';
			btn.disabled = true;
		}
	}
	else
	{
		pass2.className = 'form-control is-invalid';
		mensaje.className = 'form-text text-danger';
		mensaje.innerHTML = 'Valores permitidos: Mayus, Minus, Números, _ . @';
		btn.disabled = true;
	}
});

/************************************************************************************************/

var passform = document.getElementById('password-form');

passform.addEventListener('submit', (e) => {
	e.preventDefault();

	let arr_data = new FormData(passform);

	arr_data.append('updtpwd', 'true');

	if (arr_data.get('pass1') == '' || arr_data.get('pass2') == '')
	{
		Swal.fire({
			icon: 'error',
			title: '😦 Error! 😞',
			text: 'Ingrese datos válidos',
		});
	}
	else
	{
		fetch('internal_data', {
			method: 'POST',
			body: arr_data
		})
		.then(res => res.json())
		.then(data => {
			if (data) {
				Swal.fire({
					icon: 'success',
					title: '😃 Felicidades!! 🥳',
					text: 'La contraseña ha sido actualizada!',
					confirmButtonText: `Genial! 👍`
				});
			}else {
				Swal.fire({
					icon: 'error',
					title: '😦 Error! 😞',
					text: 'La contraseña no pudo ser actualizada.',
					confirmButtonText: `Continuar`
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
	}
});