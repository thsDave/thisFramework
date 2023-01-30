import {social_data, log} from './config.js';

firebase.initializeApp(social_data);
firebase.analytics();

const auth = firebase.auth();

if (document.getElementById('fb')) {
	document.getElementById('fb').addEventListener('click', () => {
	    let provider = new firebase.auth.FacebookAuthProvider();
	    auth.signInWithPopup(provider)
	    .then((result) => {
	        log(result);
	    }).catch(function (error) {
	        Swal.fire({
				icon: 'error',
				title: '😦 Usuario no registrado!! 😞',
				text: '¿Ya estas registrado con nosotros? intenta restablecer tu contraseña o verifica los datos y vuelve a intentarlo',
				confirmButtonText: `Ok! 👍`
			});
	    });
	});
}

if (document.getElementById('gl')) {
	document.getElementById('gl').addEventListener('click', () => {
		let provider = new firebase.auth.GoogleAuthProvider();
		auth.signInWithPopup(provider)
		.then((result) => {
		    log(result);
		}).catch((error)=>{
			Swal.fire({
				icon: 'error',
				title: '😦 Usuario no registrado!! 😞',
				text: '¿Ya estas registrado con nosotros? intenta restablecer tu contraseña o verifica los datos y vuelve a intentarlo',
				confirmButtonText: `Ok! 👍`
			});
		});
	});
}

if (document.getElementById('tw')) {
	document.getElementById('tw').addEventListener('click', () => {
		let provider = new firebase.auth.TwitterAuthProvider();
		auth.signInWithPopup(provider)
		.then((result) => {
		    log(result);
		}).catch((error)=>{
			Swal.fire({
				icon: 'error',
				title: '😦 Usuario no registrado!! 😞',
				text: '¿Ya estas registrado con nosotros? intenta restablecer tu contraseña o verifica los datos y vuelve a intentarlo',
				confirmButtonText: `Ok! 👍`
			});
		});
	});
}

if (document.getElementById('ms')) {
	document.getElementById('ms').addEventListener('click', () => {
	    let provider = new firebase.auth.OAuthProvider('microsoft.com');
	    auth.signInWithPopup(provider)
	    .then((result) => {
	        log(result);
	    }).catch(function (error) {
	        Swal.fire({
				icon: 'error',
				title: '😦 Usuario no registrado!! 😞',
				text: '¿Ya estas registrado con nosotros? intenta restablecer tu contraseña o verifica los datos y vuelve a intentarlo',
				confirmButtonText: `Ok! 👍`
			});
	    });
	});
}

if (document.getElementById('gh')) {
	document.getElementById('gh').addEventListener('click', () => {
	    let provider = new firebase.auth.GithubAuthProvider();
	    auth.signInWithPopup(provider)
	    .then((result) => {
	        log(result);
	    }).catch(function (error) {
	        Swal.fire({
				icon: 'error',
				title: '😦 Usuario no registrado!! 😞',
				text: '¿Ya estas registrado con nosotros? intenta restablecer tu contraseña o verifica los datos y vuelve a intentarlo',
				confirmButtonText: `Ok! 👍`
			});
	    });
	});
}