export const data = {
	apiKey: "",
    authDomain: "",
    projectId: "",
    storageBucket: "",
    messagingSenderId: "",
    appId: "",
    measurementId: ""
};

export const url = "http://localhost/thisframework/";

export const sweet = (res) => {
	var Toast = Swal.mixin({
		toast: false,
		position: 'center',
		showConfirmButton: true
	});
	if (res) {
		Toast.fire({
			icon: 'success',
			title: '😃 Usuario registrado!! 🥳',
			text: 'Ya puedes inicar tu sesión, gracias por registrarte.',
			confirmButtonText: `Genial! 👍`
		});
	}else {
		Toast.fire({
			icon: 'error',
			title: '😦 Usuario no registrado!! 😞',
			text: '¿Ya estas registrado con nosotros? intenta restablecer tu contraseña o verifica los datos y vuelve a intentarlo',
			confirmButtonText: `Ok! 👍`
		});
	}
}