$(document).ready(function(){
    var login_form = document.getElementById('login_form');

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

    // Tiempo de inactividad en milisegundos (por ejemplo, 1 minuto)
    var tiempoInactividad = 1 * 60 * 1000; // 1 minuto en milisegundos

    // Variable para almacenar el temporizador de inactividad
    var temporizadorInactividad;

    // Función para reiniciar el temporizador de inactividad
    function reiniciarTemporizador() {
        clearTimeout(temporizadorInactividad);
        temporizadorInactividad = setTimeout(function() {
            location.reload();
        }, tiempoInactividad);
    }

    // Eventos de interacción del usuario que reinician el temporizador de inactividad
    window.addEventListener('mousemove', reiniciarTemporizador);
    window.addEventListener('scroll', reiniciarTemporizador);
    window.addEventListener('keypress', reiniciarTemporizador);
    window.addEventListener('click', reiniciarTemporizador);

    // Iniciar el temporizador de inactividad
    reiniciarTemporizador();

});