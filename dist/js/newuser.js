$(document).ready(function () {

	$("#name").keyup(function() {
		var name = $("#name").val();
		var route = "register=&name="+name;
		$.ajax({
			type: 'post',
			url: 'external_data',
			data: route
		}).done(function(res){
			if (res) {
				$("#name").removeClass('is-invalid');
				$("#name").addClass('is-valid');
			}else {
				$("#name").removeClass('is-valid');
				$("#name").addClass('is-invalid');
			}
		});
	});

	$("#position").keyup(function() {
		var position = $("#position").val();
		var route = "register=&position="+position;
		$.ajax({
			type: 'post',
			url: 'external_data',
			data: route
		}).done(function(res){
			if (res) {
				$("#position").removeClass('is-invalid');
				$("#position").addClass('is-valid');
			}else {
				$("#position").removeClass('is-valid');
				$("#position").addClass('is-invalid');
			}
		});
	});

	$("#email").keyup(function() {
		var email = $("#email").val();
		var route = "register=&email="+email;
		$.ajax({
			type: 'post',
			url: 'external_data',
			data: route
		}).done(function(res){
			if (res) {
				$("#email").removeClass('is-invalid');
				$("#email").addClass('is-valid');
			}else {
				$("#email").removeClass('is-valid');
				$("#email").addClass('is-invalid');
			}
		});
	});

	$("#email2").keyup(function() {
		var email2 = $("#email2").val();
		var route = "register=&email2="+email2;
		$.ajax({
			type: 'post',
			url: 'external_data',
			data: route
		}).done(function(res){
			if (res) {
				$("#email2").removeClass('is-invalid');
				$("#email2").addClass('is-valid');
			}else {
				$("#email2").removeClass('is-valid');
				$("#email2").addClass('is-invalid');
			}
		});
	});

	$('#newregister').click(() => {
		var name = $('#name').val();
		var position = $('#position').val();
		var email = $('#email').val();
		var email2 = $('#email2').val();
		var route = 'newregister=&name='+name+'&position='+position+'&email='+email+'&email2='+email2;
		$.ajax({
			type: 'post',
			url: 'external_data',
			data: route
		})
		.done((res) => {
			var Toast = Swal.mixin({
				toast: false,
				position: 'center',
				showConfirmButton: true
			});
			if (res) {
				Toast.fire({
					icon: 'success',
					title: '😃 Usuario registrado!! 🥳',
					text: 'Para que la cuenta finalice su registro, el usuario deberá confirmar su cuenta de correo.',
					confirmButtonText: `De acuerdo! 👍`
				});
			}else {
				Toast.fire({
					icon: 'error',
					title: '😦 Usuario no registrado!! 😞',
					text: 'Verifica los datos e intentalo nuevamente',
					confirmButtonText: `Ok! 👍`
				});
			}
			$('#name').val('');
			$('#position').val('');
			$('#email').val('');
			$('#email2').val('');
			$('#name').removeClass('is-valid');
			$('#position').removeClass('is-valid');
			$('#email').removeClass('is-valid');
			$('#email2').removeClass('is-valid');
			$('#name').removeClass('is-invalid');
			$('#position').removeClass('is-invalid');
			$('#email').removeClass('is-invalid');
			$('#email2').removeClass('is-invalid');
		});
	});
});