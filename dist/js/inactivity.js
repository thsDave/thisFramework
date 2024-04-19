$(document).ready(function(){
	// Tiempo de inactividad en milisegundos (por ejemplo, 1 minuto)
	var tiempoInactividad = 5 * 60 * 1000; // 1 minuto en milisegundos

	// Variable para almacenar el temporizador de inactividad
	var temporizadorInactividad;

	// Función para reiniciar el temporizador de inactividad
	function reiniciarTemporizador() {
	    clearTimeout(temporizadorInactividad);
	    temporizadorInactividad = setTimeout(async function() {

	        var req = new FormData();
	        req.append('lockscreen_on', true);

	        try {
	            const response = await fetch('internal_data', {
	                method: 'POST',
	                body: req
	            });

	            location.reload();

	        } catch (error) {
	            Swal.fire({
	                icon: 'error',
	                title: 'Error',
	                text: 'Ocurrió un error dentro del sistema, por motivo de seguridad se cerrará esta sesión, ponte en contacto con el administrador del sistema.',
	                confirmButtonText: 'Aceptar'
	            })
	            .then(()=>{
	                location.replace(window.location+'?event=logout');
	            });
	        }
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