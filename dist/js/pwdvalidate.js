
var btn = document.getElementById('btn_pass');
btn.disabled = true;

async function getUserInfo() {
  try {
    let arr_data = new FormData();
    arr_data.append('getusrinfo', true);

    const response = await fetch('external_data', {
      method: 'POST',
      body: arr_data
    });

    const data = await response.json();

    if (data) {
      $('#username').html(data.name);
      $('#usermail').html(data.email);
    } else {
      window.open(window.location + '?action=login', '_self');
    }
  } catch (error) {
    window.open(window.location + '?action=login', '_self');
  }
}

getUserInfo();

$('#pass1').keyup(()=>{
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
});

$('#pass2').keyup(()=>{
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
});

function validation(pass) {
  var banco = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789abcdefghijklmnñopqrstuvwxyzÁÉÍÓÚáéíóú_@-$!.';
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

var form = document.getElementById('restorepass');

form.addEventListener('submit', async (e) => {
  e.preventDefault();

  let arr_data = new FormData(form);
  arr_data.append('restorepwd', true);

  try {
    const response = await fetch('external_data', {
      method: 'POST',
      body: arr_data
    });

    const data = await response.json();

    if (data) {
      $('#restore-card').hide();
      await Swal.fire({
        icon: 'success',
        title: 'Contraseña actualizada',
        text: 'Su contraseña ha sido actualizada satisfactoriamente.',
        confirmButtonText: `Aceptar`
      });
      let url = window.location;
      window.open(url + '?action=login', '_self');
    } else {
      await Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'No se pudo actualizar su contraseña, inténtelo nuevamente.',
        confirmButtonText: `Aceptar`
      });
    }
  } catch (error) {
    await Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'No se pudo actualizar su contraseña, inténtelo nuevamente.',
      confirmButtonText: `Aceptar`
    });
  }
});