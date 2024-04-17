$(document).ready(function(){

    var idsupport, fila, option;

    async function getmssg(id) {
        try {
            let arr_data = new FormData();

            arr_data.append('id', id);
            arr_data.append('getsupportreq', true);

            const response = await fetch('internal_data', {
                method: 'POST',
                body: arr_data
            });

            const data = await response.json();

            $('#modal-request').modal('show');
            $('#name').html(data.name);
            $('#subject').html('<h5>Asunto: </h5>' + data.subject);
            $('#mssg').html('<h5>Mensaje: </h5><p>' + data.mssg + '</p>');
            $('#response').val(data.response);
            $('#sendres').val(data.idsupport);
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error dentro del sistema, actualiza el sitio e intentalo nuevamente o ponte en contacto con el administrador del sistema.',
                confirmButtonText: 'Aceptar'
            });
        }
    }

    var supports = $('#datable').DataTable({
        "ajax":{
            "url": "internal_data",
            "method": 'POST',
            "data": { crud_supports: true, option: 'read' },
            "dataSrc": ""
        },
        "columns":[
            {"data": "no"},
            {"data": "name"},
            {"data": "email"},
            {"data": "level"},
            {"data": "subject"},
            {"data": "btbadge"},
            {
                "data": "idsupport",
                "render": function (data, type, row) {
                    return `<div class='wrapper'>
                        <button type="button" class="btn btn-sm btn-dark open" value="${row.idsupport}" data-toggle="tooltip" data-bs-placement="top" title="Abrir">
                            Abrir
                        </button>
                    </div>`
                }
            }
        ],
        "responsive": true,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "language":
        {
            "emptyTable":           "No hay datos disponibles en la tabla.",
            "info":                 "Del _START_ al _END_ de _TOTAL_",
            "infoEmpty":            "Mostrando 0 registros de un total de 0.",
            "infoFiltered":         "(filtrados de un total de _MAX_ registros)",
            "infoPostFix":          " ",
            "lengthMenu":           "Mostrar &nbsp; _MENU_",
            "loadingRecords":       "Cargando...",
            "processing":           "Procesando...",
            "search":               "Buscar:",
            "searchPlaceholder":    "Dato para buscar",
            "zeroRecords":          "No se han encontrado coincidencias.",
            "paginate":
            {
                "first":            "Primera",
                "last":             "Última",
                "next":             "Siguiente",
                "previous":         "Anterior"
            },
            "aria":
            {
                "sortAscending":    "Ordenación ascendente",
                "sortDescending":   "Ordenación descendente"
            }
        },
        "lengthMenu": [[5, 10, 20, 25, 50], [5, 10, 20, 25, 50]]
    });


    $(document).on("click", ".open", function(){
        idsupport = this.value;
        getmssg(idsupport);
    });


    $('#sendres').click(async () => {
        try {
            let arr_dato = new FormData();

            arr_dato.append('id', $('#sendres').val());
            arr_dato.append('response', $('#response').val());
            arr_dato.append('savesupportres', true);

            const response = await fetch('internal_data', {
                method: 'POST',
                body: arr_dato
            });

            const data = await response.json();

            $('#modal-request').modal('hide');

            if (data) {
                await Swal.fire({
                    icon: 'success',
                    text: 'Tu respuesta ha sido enviada.',
                    confirmButtonText: 'Aceptar'
                });
                supports.ajax.reload(null, false);
            } else {
                await Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo enviar la respuesta.',
                    confirmButtonText: 'Aceptar'
                });
                supports.ajax.reload(null, false);
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error dentro del sistema, actualiza el sitio e intentalo nuevamente o ponte en contacto con el administrador del sistema.',
                confirmButtonText: 'Aceptar'
            });
        }
    });
});

