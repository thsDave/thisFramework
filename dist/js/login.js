var login_form = document.getElementById('login_form');
var tokenlogin = '';

grecaptcha.ready(function() {
    grecaptcha.execute('6Ld7NrgpAAAAACIokUnERwXs4qmJcN3S3KRWxUfd', {
        action: 'login'
    }).then(function(token) {
        login_form.addEventListener('submit', async (e) => {
            e.preventDefault();

            let arr_data = new FormData(login_form);

            arr_data.append('localogin', true);

            arr_data.append('token', token);

            try {

                const response = await fetch('external_data', {
                    method: 'POST',
                    body: arr_data
                });

                const data = await response.json();

                if (data) {
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Usuario y/o Contraseña incorrectos',
                        confirmButtonText: `Aceptar`
                    });

                    $('#user').val('');
                    $('#pwd').val('');
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error dentro del sistema, actualiza el sitio e intentalo nuevamente o ponte en contacto con el administrador del sistema.',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
});
