
$('#registerbox').hide();

Swal.fire({
	icon: 'info',
	title: 'Actualización de perfil',
	html: `
	<p class="text-justify">Antes de continuar, agradecemos tu colaboración para actualizar tu información personal, de esta manera, nos ayudarás a poder brindarte un mejor servicio.</p>
	`,
	confirmButtonText: 'De acuerdo 👍'
}).then(()=>{
	$('#registerbox').show();

	let arr_data = new FormData();

	arr_data.append('starter', true);

	fetch('internal_data', {
		method: 'POST',
		body: arr_data
	})
	.then(res => res.json())
	.then(data => {
		$('#name').val(data.name);
	});
});

var form = document.getElementById('update-form');

form.addEventListener('submit', (e) => {
	e.preventDefault();

	let arr_data = new FormData(form);

	arr_data.append('welcomeform', true);

	Swal.fire({
        icon: 'question',
        title: 'Actualizar datos',
        text: '¿Deseas finalizar tu actualización de perfil?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: 'Guardar y finalizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed)
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
                        title: '😃 Perfil actualizado!! 🥳',
                        confirmButtonText: `Genial! 👍`
                    }).then(()=>{
                        location.reload();
                    });
                }else {
                    Swal.fire({
                        icon: 'error',
                        title: '😦 Error 😞',
                        html: 'No se logró actualizar tu perfil, intentalo nuevamente.',
                        confirmButtonText: `Aceptar`
                    });
                }
            });
        } else if (result.isDenied) {
            Swal.fire('Acción cancelada', '', 'info');
        }
    });
});