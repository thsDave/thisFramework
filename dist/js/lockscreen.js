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
                        })
                        .then(()=>{
                            location.reload();
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