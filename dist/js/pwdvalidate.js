$( document ).ready(function() {
  var btn = document.getElementById('btn_pass');
  btn.disabled = true;
});

function validation(pass) {
  var banco = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789abcdefghijklmnñopqrstuvwxyz_@-$!';
  var arr_banco = banco.split('');
  var arr_pass = pass.split('');

  var x = true;

  arr_pass.forEach( function(element) {
    if (!arr_banco.includes(element)) {
      x = false;
    }
  });

  return x;
}

function validapass1() {
  var pass = document.getElementById('pass1');
  var mensaje = document.getElementById('mnsj');
  var btn = document.getElementById('btn_pass');

  if (pass.value.length >= 8 && validation(pass.value) == true) {
    pass.className = 'form-control is-valid';
    mensaje.className = 'form-text text-success';
    mensaje.innerHTML = 'Contraseña válida';
  }
  else {
    pass.className = 'form-control is-invalid';
    mensaje.className = 'form-text text-danger';
    mensaje.innerHTML = 'Contraseña inválida';
  }
}

function validapass2() {
  var pass1 = document.getElementById('pass1');
  var pass2 = document.getElementById('pass2');
  var mensaje = document.getElementById('mnsj2');
  var btn = document.getElementById('btn_pass');

  if (pass2.value.length >= 8 && validation(pass2.value) == true) {
    pass2.className = 'form-control is-valid';

    if (pass1.value == pass2.value) {
      btn.disabled = false;
      mensaje.className = 'form-text text-success';
      mensaje.innerHTML = 'Las contraseñas coinciden!';
    }
    else
    {
      btn.disabled = true;
      pass2.className = 'form-control is-invalid';
      mensaje.className = 'form-text text-danger';
      mensaje.innerHTML = 'Contraseña inválida';
    }
  }
  else {
    btn.disabled = true;
    pass2.className = 'form-control is-invalid';
    mensaje.className = 'form-text text-danger';
    mensaje.innerHTML = 'Contraseña inválida';
  }
}