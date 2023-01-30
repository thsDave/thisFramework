
const bstrpBtn = Swal.mixin({
  confirmButtonClass: 'btn btn-primary mr-2',
  cancelButtonClass: 'btn btn-secondary',
  denyButtonClass: 'btn btn-danger mr-2',
  buttonsStyling: false
});

let arr_data = new FormData();

arr_data.append('starter', true);

fetch('internal_data', {
  method: 'POST',
  body: arr_data
})
.then(res => res.json())
.then(data => {

  if (data.welcome == 0 && data.wcancel == 0)
  {
    bstrpBtn.fire({
      icon: 'info',
      title: `👋 Hola de nuevo 😁`,
      html: `
        <p class="text-justify">
          Te damos la bienvenida a nuestra nueva versión de sistema.
        </p>
        <p class="text-justify">
          A continuación, te presentamos las novedades que ofrece esta versión la cual será de mucha ayuda 
          para los procesos y seguimiento de tus registros.
        </p>
      `,
      showDenyButton: true,
      showCancelButton: true,
      cancelButtonText: 'Lo haré después',
      denyButtonText: 'Omitir',
      confirmButtonText: 'Conocer más',
      allowOutsideClick: false,
      customClass: {
        confirmButton: 'btn',
        denyButton: 'btn',
        cancelButton: 'btn'
      }
    }).then((result) => {

      if (result.isConfirmed)
      {
        bstrpBtn.fire({
          title: `📑 Noticia 1 📊`,
          imageUrl: 'dist/img/grafica.gif',
          imageWidth: 160,
          imageHeight: 160,
          imageAlt: 'Gráfica',
          html: `
            <p class="text-justify">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
              Ut enim ad minim veniam.
            </p>
          `,
          showDenyButton: true,
          showCancelButton: true,
          cancelButtonText: 'terminar después',
          denyButtonText: 'Finalizar',
          confirmButtonText: 'Siguiente',
          allowOutsideClick: false,
          customClass: {
            confirmButton: 'btn',
            denyButton: 'btn',
            cancelButton: 'btn'
          }
        }).then((result) => {

          if (result.isConfirmed)
          {
            bstrpBtn.fire({
              title: `📑 Noticia 2 📖`,
              imageUrl: 'dist/img/form.gif',
              imageWidth: 160,
              imageHeight: 160,
              imageAlt: 'Reporte',
              html: `
                <p class="text-justify">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                  Ut enim ad minim veniam.
                </p>
              `,
              showDenyButton: true,
              showCancelButton: true,
              cancelButtonText: 'terminar después',
              denyButtonText: 'Finalizar',
              confirmButtonText: 'Siguiente',
              allowOutsideClick: false,
              customClass: {
                confirmButton: 'btn',
                denyButton: 'btn',
                cancelButton: 'btn'
              }
            }).then((result) => {

              if (result.isConfirmed)
              {
                bstrpBtn.fire({
                  title: `📔 Noticia 3 📒`,
                  imageUrl: 'dist/img/steps.gif',
                  imageWidth: 160,
                  imageHeight: 160,
                  imageAlt: 'Reporte',
                  html: `
                    <p class="text-justify">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                      Ut enim ad minim veniam.
                    </p>
                  `,
                  showDenyButton: false,
                  showCancelButton: false,
                  cancelButtonText: 'terminar después',
                  denyButtonText: 'Cancelar',
                  confirmButtonText: 'Guardar y finalizar',
                  allowOutsideClick: false,
                  customClass: {
                    confirmButton: 'btn',
                    denyButton: 'btn',
                    cancelButton: 'btn'
                  }
                }).then((result) => {

                  if (result.isConfirmed)
                  {
                    var arr_data = new FormData();

                    arr_data.append('welcome_finished', true);

                    fetch('internal_data', {
                      method: 'POST',
                      body: arr_data
                    })
                    .then(res => res.json())
                    .then(data => {
                      if (data)
                      {
                        Swal.fire('Acciones actualizadas', '', 'success');
                      }
                      else
                      {
                        Swal.fire('Error', '', 'error');
                      }
                    });
                  }
                  else if (result.isDenied)
                  {
                    var arr_data = new FormData();

                    arr_data.append('welcome_denied', true);

                    fetch('internal_data', {
                      method: 'POST',
                      body: arr_data
                    })
                    .then(res => res.json())
                    .then(data => {
                      if (data)
                      {
                        Swal.fire('Omitido', '', 'success');
                      }
                      else
                      {
                        Swal.fire('Error', '', 'error');
                      }
                    });
                  }
                  else if (result.dismiss)
                  {
                    var arr_data = new FormData();

                    arr_data.append('welcome_cancel', true);

                    fetch('internal_data', {
                      method: 'POST',
                      body: arr_data
                    })
                    .then(res => res.json())
                    .then(data => {
                      if (data)
                      {
                        Swal.fire('Acción cancelada', 'Se activará nuevamente al próximo inicio de sesión.', 'info');
                      }
                      else
                      {
                        Swal.fire('Error', '', 'error');
                      }
                    });
                  }
                });
              }
              else if (result.isDenied)
              {
                var arr_data = new FormData();

                arr_data.append('welcome_denied', true);

                fetch('internal_data', {
                  method: 'POST',
                  body: arr_data
                })
                .then(res => res.json())
                .then(data => {
                  if (data)
                  {
                    Swal.fire('Omitido', '', 'success');
                  }
                  else
                  {
                    Swal.fire('Error', '', 'error');
                  }
                });
              }
              else if (result.dismiss)
              {
                var arr_data = new FormData();

                arr_data.append('welcome_cancel', true);

                fetch('internal_data', {
                  method: 'POST',
                  body: arr_data
                })
                .then(res => res.json())
                .then(data => {
                  if (data)
                  {
                    Swal.fire('Acción cancelada', 'Se activará nuevamente al próximo inicio de sesión.', 'info');
                  }
                  else
                  {
                    Swal.fire('Error', '', 'error');
                  }
                });
              }
            });
          }
          else if (result.isDenied)
          {
            var arr_data = new FormData();

            arr_data.append('welcome_denied', true);

            fetch('internal_data', {
              method: 'POST',
              body: arr_data
            })
            .then(res => res.json())
            .then(data => {
              if (data)
              {
                Swal.fire('Omitido', '', 'success');
              }
              else
              {
                Swal.fire('Error', '', 'error');
              }
            });
          }
          else if (result.dismiss)
          {
            var arr_data = new FormData();

            arr_data.append('welcome_cancel', true);

            fetch('internal_data', {
              method: 'POST',
              body: arr_data
            })
            .then(res => res.json())
            .then(data => {
              if (data)
              {
                Swal.fire('Acción cancelada', 'Se activará nuevamente al próximo inicio de sesión.', 'info');
              }
              else
              {
                Swal.fire('Error', '', 'error');
              }
            });
          }
        });
      }
      else if (result.isDenied)
      {
        var arr_data = new FormData();

        arr_data.append('welcome_denied', true);

        fetch('internal_data', {
          method: 'POST',
          body: arr_data
        })
        .then(res => res.json())
        .then(data => {
          if (data)
          {
            Swal.fire('Omitido', '', 'success');
          }
          else
          {
            Swal.fire('Error', '', 'error');
          }
        });
      }
      else if (result.dismiss)
      {
        var arr_data = new FormData();

        arr_data.append('welcome_cancel', true);

        fetch('internal_data', {
          method: 'POST',
          body: arr_data
        })
        .then(res => res.json())
        .then(data => {
          if (data)
          {
            Swal.fire('Acción cancelada', 'Se activará nuevamente al próximo inicio de sesión.', 'info');
          }
          else
          {
            Swal.fire('Error', '', 'error');
          }
        });
      }
    });
  }
});
