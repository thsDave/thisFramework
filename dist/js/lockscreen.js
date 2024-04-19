$(document).ready(function(){
    var lockscreen_form = document.getElementById('lockscreen-form');

    grecaptcha.ready(function() {
        grecaptcha.execute('6Ld7NrgpAAAAACIokUnERwXs4qmJcN3S3KRWxUfd', {
            action: 'lockscreen'
        }).then(function(token) {
            lockscreen_form.addEventListener('submit', async (e) => {
                e.preventDefault();

                let arr_data = new FormData(lockscreen_form);

                arr_data.append('lockscreen_off', true);

                arr_data.append('token', token);

                try {

                    const response = await fetch('internal_data', {
                        method: 'POST',
                        body: arr_data
                    });

                    const data = await response.json();

                    if (data) {
                        location.replace(window.location+'?req=home');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: 'Contraseña incorrecta',
                            confirmButtonText: `Aceptar`
                        });

                        $('#password').val('');
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

});