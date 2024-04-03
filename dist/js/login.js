var login_form = document.getElementById('login_form');

login_form.addEventListener('submit', async (e) => {
    e.preventDefault();

    let arr_data = new FormData(login_form);

    arr_data.append('localogin', true);

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
        console.error('Error:', error);
    }
});