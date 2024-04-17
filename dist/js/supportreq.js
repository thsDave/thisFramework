function get_supports() {
    let info = new FormData();

    info.append('getmessages', true);

    fetch('internal_data', {
        method: 'POST',
        body: info
    })
    .then(res => res.json())
    .then(data => {
        var container = document.getElementById('container_supports');

        container.innerHTML = '';

        if (data != 'empty') {
            for (var index = 0; index < data.subject.length; index++)
            {
                html = `
                <div class='card-body p-0'>
                    <div class='mailbox-read-info'>
                        <div class='row'>
                            <div class='col-8'>
                                <h4>subject: ${data.subject[index]}</h4>
                                <h6 class='mt-2'>from: ${data.user[index]}</h6>
                            </div>
                            <div class='col-4'>
                                <span class='float-right'>${data.btbadge[index]}</span>
                            </div>
                        </div>
                    </div>
                    <div class='mailbox-read-message'>
                        <p><strong>request:</strong></p>
                        <p>${data.mssg[index]}</p>
                        <hr>
                        <p><strong>response:</strong></p>
                        <p>${data.response[index]}</p>
                    </div>
                </div>
                <div class='card-footer'>
                    <button type="button" class="btn btn-link text-primary" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button type="button" class="btn btn-link text-success" data-toggle="tooltip" data-placement="top" title="Finalizar"><i class="fa-solid fa-check-double"></i></button>
                    <button type="button" class="btn btn-link text-danger" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fa-solid fa-trash-can"></i></button>
                </div>`;

                var containerId = Object.keys(data)[0];

                container.innerHTML += html;
            }
        }else {
            html = `
            <div class='card-body p-0'>
                <div class='row'>
                    <div class='col-8'>
                        <h6>No supports to show</h6>
                    </div>
                </div>
            </div>`;

            container.innerHTML += html;
        }
    });
}

setInterval(get_supports(), 5000);


let form = document.getElementById('support-form');

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    let arr_data = new FormData(form);
    arr_data.append('newreqsupport', true);

    try {
        const response = await fetch('internal_data', {
            method: 'POST',
            body: arr_data
        });

        const data = await response.json();

        if (data) {
            await Swal.fire({
                icon: 'success',
                text: 'Tu solicitud de soporte ha sido enviada.',
                confirmButtonText: 'Aceptar'
            });
        } else {
            await Swal.fire({
                icon: 'error',
                text: 'No se pudo enviar la solicitud, verifica la información e intenta nuevamente.',
                confirmButtonText: 'Aceptar'
            });
        }

        get_supports();
        form.reset();
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error dentro del sistema, actualiza el sitio e intentalo nuevamente o ponte en contacto con el administrador del sistema.',
            confirmButtonText: 'Aceptar'
        });
    }
});