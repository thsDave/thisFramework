import {social_data, register} from './config.js';

firebase.initializeApp(social_data);
firebase.analytics();

const auth = firebase.auth();

if (document.getElementById('fb')) {
	document.getElementById('fb').addEventListener('click', () => {
	    let provider = new firebase.auth.FacebookAuthProvider();
	    auth.signInWithPopup(provider)
	    .then((result) => {
	        register(result);
	    }).catch(function (error) {
	        Swal.fire({
				icon: 'error',
				title: 'Usuario no registrado',
				text: 'Lo sentimos, por el momento intenta usar nuestro formulario de registro.',
				confirmButtonText: `Aceptar`
			});
	    });
	});
}

if (document.getElementById('gl')) {
	document.getElementById('gl').addEventListener('click', () => {
		let provider = new firebase.auth.GoogleAuthProvider();
		auth.signInWithPopup(provider)
		.then((result) => {
		    register(result);
		}).catch((error)=>{
			Swal.fire({
				icon: 'error',
				title: 'Usuario no registrado',
				text: 'Lo sentimos, por el momento intenta usar nuestro formulario de registro.',
				confirmButtonText: `Aceptar`
			});
		});
	});
}

if (document.getElementById('tw')) {
	document.getElementById('tw').addEventListener('click', () => {
		let provider = new firebase.auth.TwitterAuthProvider();
		auth.signInWithPopup(provider)
		.then((result) => {
		    register(result);
		}).catch((error)=>{
			Swal.fire({
				icon: 'error',
				title: 'Usuario no registrado',
				text: 'Lo sentimos, por el momento intenta usar nuestro formulario de registro.',
				confirmButtonText: `Aceptar`
			});
		});
	});
}

if (document.getElementById('ms')) {
	document.getElementById('ms').addEventListener('click', () => {
	    let provider = new firebase.auth.OAuthProvider('microsoft.com');
	    auth.signInWithPopup(provider)
	    .then((result) => {
	        register(result);
	    }).catch(function (error) {
	        Swal.fire({
				icon: 'error',
				title: 'Usuario no registrado',
				text: 'Lo sentimos, por el momento intenta usar nuestro formulario de registro.',
				confirmButtonText: `Aceptar`
			});
	    });
	});
}

if (document.getElementById('gh')) {
	document.getElementById('gh').addEventListener('click', () => {
	    let provider = new firebase.auth.GithubAuthProvider();
	    auth.signInWithPopup(provider)
	    .then((result) => {
	        register(result);
	    }).catch(function (error) {
	        Swal.fire({
				icon: 'error',
				title: 'Usuario no registrado',
				text: 'Lo sentimos, por el momento intenta usar nuestro formulario de registro.',
				confirmButtonText: `Aceptar`
			});
	    });
	});
}