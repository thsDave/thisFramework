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
	var data = 'nowselecttab=info';
	$.ajax({
		type: 'post',
		url: 'internal_data',
		data: data
	});
});

$('#profile-access-tab').click(() => {
	var data = 'nowselecttab=access';
	$.ajax({
		type: 'post',
		url: 'internal_data',
		data: data
	});
});

/************************************************************************************************/

var btn = document.getElementById('btn_pass');

btn.disabled = true;

var	campos = {
	pass1: false,
	pass2: false,
	curpass: false
}

const validateform = () => {
	let res = true;
	let btn = document.getElementById('btn_pass');

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

$('#curpass').keyup(async () => {
    let arr_data = new FormData();

    arr_data.append('curpass', $('#curpass').val());
    arr_data.append('validate_pass', true);

    try {
        const response = await fetch('internal_data', {
            method: 'POST',
            body: arr_data
        });

        const data = await response.json();

        campos.curpass = (data) ? true : false;
        validateform();
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error dentro del sistema, actualiza el sitio e intentalo nuevamente o ponte en contacto con el administrador del sistema.',
            confirmButtonText: 'Aceptar'
        });
    }
});


$('#pass1').keyup(() => {
	var pass = document.getElementById('pass1');
	var mensaje = document.getElementById('mnsj1');

	if (pass.value.length >= 8 && validation(pass.value) == true) {
		pass.className = 'form-control is-valid';
		mensaje.className = 'form-text text-success';
		mensaje.innerHTML = 'Contraseña válida';
		campos.pass1 = true;
		validateform();
	}else {
		pass.className = 'form-control is-invalid';
		mensaje.className = 'form-text text-danger';
		mensaje.innerHTML = 'Valores permitidos: Mayus, Minus, Números, _ . @';
		campos.pass2 = false;
		validateform();
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

			campos.pass2 = true;
			validateform();
		}
		else
		{
			pass2.className = 'form-control is-invalid';
			mensaje.className = 'form-text text-danger';
			mensaje.innerHTML = 'Valores permitidos: Mayus, Minus, Números, _ . @';
			campos.pass2 = false;
			validateform();
		}
	}
	else
	{
		pass2.className = 'form-control is-invalid';
		mensaje.className = 'form-text text-danger';
		mensaje.innerHTML = 'Valores permitidos: Mayus, Minus, Números, _ . @';
		campos.pass2 = false;
		validateform();
	}
});

/************************************************************************************************/

var passform = document.getElementById('password-form');

passform.addEventListener('submit', async (e) => {
    e.preventDefault();

    let arr_data = new FormData(passform);
    arr_data.append('updtpwd', 'true');

    if (arr_data.get('pass1') === '' || arr_data.get('pass2') === '') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ingrese datos válidos',
        });
    } else {
        try {
            const response = await fetch('internal_data', {
                method: 'POST',
                body: arr_data
            });

            const data = await response.json();

            if (data) {
                Swal.fire({
                    icon: 'success',
                    title: 'Actualización exitosa',
                    text: 'La contraseña ha sido actualizada',
                    confirmButtonText: `Aceptar`
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La contraseña no pudo ser actualizada.',
                    confirmButtonText: `Continuar`
                });
            }

            if ($('#currentPass').length) { $('#currentPass').val(''); }

            $('#curpass').val('');
            $('#pass1').val('');
            $('#pass2').val('');

            $('#pass1').removeClass("is-valid");
            $('#pass2').removeClass("is-valid");

            $('#mnsj1').html('');
            $('#mnsj2').html('');

            $("#modal_pwd").modal('hide');

            let mensaje1 = document.getElementById('mnsj1');
            let mensaje2 = document.getElementById('mnsj2');

            mensaje1.className = 'form-text text-muted';
            mensaje2.className = 'form-text text-muted';
        } catch (error) {
            Swal.fire({
	            icon: 'error',
	            title: 'Error',
	            text: 'Ocurrió un error dentro del sistema, actualiza el sitio e intentalo nuevamente o ponte en contacto con el administrador del sistema.',
	            confirmButtonText: 'Aceptar'
	        });
        }
    }
});


/************************************************************************************************/

var userProfileForm = document.getElementById('profile_form');

userProfileForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    let arr_data = new FormData(userProfileForm);
    arr_data.append('update_profile', 'true');

    if (arr_data.get('name') == '') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ingresa datos válidos',
            confirmButtonText: 'Aceptar'
        });
    } else {
        try {
            const response = await fetch('internal_data', {
                method: 'POST',
                body: arr_data
            });

            const data = await response.json();

            if (data) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Actualización exitosa',
                    text: 'La información del usuario ha sido actualizada',
                    confirmButtonText: 'Aceptar'
                });
                location.reload();
            } else {
                await Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Usuario no actualizado',
                    confirmButtonText: 'Aceptar'
                });
            }
        } catch (error) {
            Swal.fire({
	            icon: 'error',
	            title: 'Error',
	            text: 'Ocurrió un error dentro del sistema, actualiza el sitio e intentalo nuevamente o ponte en contacto con el administrador del sistema.',
	            confirmButtonText: 'Aceptar'
	        });
        }
    }
});
