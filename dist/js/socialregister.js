import {data, url, sweet} from './socialconfig.js';

firebase.initializeApp(data);
firebase.analytics();

const auth = firebase.auth();

if (document.getElementById('fb')) {
	document.getElementById('fb').addEventListener('click', () => {
	    let provider = new firebase.auth.FacebookAuthProvider();
	    auth.signInWithPopup(provider)
	    .then((result) => {
	        let user = result.user;
		    let route = "fireregister=&name="+user.providerData[0].displayName+"&email="+user.providerData[0].email;
			$.ajax({
				type: 'post',
				url: 'external_data',
				data: route
			}).done((res) => {
				sweet(res);
			});
	    }).catch(function (error) {
	        console.log(error);
	    });
	});
}

if (document.getElementById('gl')) {
	document.getElementById('gl').addEventListener('click', () => {
		let provider = new firebase.auth.GoogleAuthProvider();
		auth.signInWithPopup(provider)
		.then((result) => {
		    let user = result.user;
		    let route = "fireregister=&name="+user.providerData[0].displayName+"&email="+user.providerData[0].email;
			$.ajax({
				type: 'post',
				url: 'external_data',
				data: route
			}).done((res) => {
				sweet(res);
			});
		}).catch((error)=>{
		  	console.log(error);
		  });
	});
}

if (document.getElementById('tw')) {
	document.getElementById('tw').addEventListener('click', () => {
		let provider = new firebase.auth.TwitterAuthProvider();
		auth.signInWithPopup(provider)
		.then((result) => {
		    let user = result.user;
		    let route = "fireregister=&name="+user.providerData[0].displayName+"&email="+user.providerData[0].email;
			$.ajax({
				type: 'post',
				url: 'external_data',
				data: route
			}).done((res) => {
				sweet(res);
			});
		}).catch((error)=>{
		  	console.log(error);
		  });
	});
}

if (document.getElementById('ms')) {
	document.getElementById('ms').addEventListener('click', () => {
	    let provider = new firebase.auth.OAuthProvider('microsoft.com');
	    auth.signInWithPopup(provider)
	    .then((result) => {
	        let user = result.user;
	        console.log(user);
		    let route = "fireregister=&name="+user.providerData[0].displayName+"&email="+user.providerData[0].email;
			$.ajax({
				type: 'post',
				url: 'external_data',
				data: route
			}).done((res) => {
				sweet(res);
			});
	    }).catch(function (error) {
	        console.log(error);
	    });
	});
}

if (document.getElementById('gh')) {
	document.getElementById('gh').addEventListener('click', () => {
	    let provider = new firebase.auth.GithubAuthProvider();
	    auth.signInWithPopup(provider)
	    .then((result) => {
	        let user = result.user;
		    let route = "fireregister=&name="+user.providerData[0].displayName+"&email="+user.providerData[0].email;
			$.ajax({
				type: 'post',
				url: 'external_data',
				data: route
			}).done((res) => {
				sweet(res);
			});
	    }).catch(function (error) {
	        console.log(error);
	    });
	});
}