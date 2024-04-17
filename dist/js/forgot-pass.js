import {mail_check} from './config.js';

grecaptcha.ready(function() {
    grecaptcha.execute('6Ld7NrgpAAAAACIokUnERwXs4qmJcN3S3KRWxUfd', {
        action: 'forgot'
    }).then(function(token) {
		var form = document.getElementById('forgot-form');

		form.addEventListener('submit', async (e) => {

			e.preventDefault();

			let arr_data = new FormData(form);

			arr_data.append('forgot-email', true);

			arr_data.append('token', token);

			Swal.fire({
		        title: '📨 Iniciando reinicio 📬',
		        html: 'Estamos enviando instrucciones por correo electrónico, por favor no cierre la ventana del navegador.',
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
					title: 'Reinicio iniciado',
					text: 'Por favor revisa tu correo electrónico y sigue las instrucciones.',
					confirmButtonText: `Aceptar`
				})
				.then(() => {
					window.open(window.location+'?action=login','_self');
				});
			}else {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Por favor introduzca una dirección de correo electrónico válida',
					confirmButtonText: `Aceptar`
				});
			}

			$('#mail').val('');

		});
	});
});
