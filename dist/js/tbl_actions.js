
$(document).ready(function() {

    // var fila captura la fila para editar o eliminar un registro

    var idaction, fila, option;

    var tbl_actions = $('#datable').DataTable({
        "ajax":{
            "url": "internal_data",
            "method": 'POST',
            "data": { crud_actions: true, option: 'read' },
            "dataSrc": ""
        },
        "columns":[
            {"data": "no"},
            {"data": "action"},
            {"data": "btbadge"},
            {"data": "showfield"},
            {"data": "created_at"},
            {
                "data": "idaction",
                "render": function (data, type, row) {
                    return `<div class='wrapper'>
                        <button type="button" class="btn btn-sm btn-info edit-data" value="${row.idaction}" data-toggle="tooltip" data-bs-placement="top" title="editar registro">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-warning edit-status" value="${row.idaction}" data-toggle="tooltip" data-bs-placement="top" title="cambiar estado">
                            <i class="fa-solid fa-rotate"></i>
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

    //submit para el Alta y Actualización

    var country_form = document.getElementById('action_form');

    country_form.addEventListener('submit', async (e) => {
        e.preventDefault();

        let arr_data = new FormData(country_form);
        arr_data.append('crud_actions', true);
        arr_data.append('option', option);
        arr_data.append('idaction', idaction);

        try {
            const response = await fetch('internal_data', {
                method: 'POST',
                body: arr_data
            });

            const data = await response.json();

            if (data) {
                let mnsj = (option == 'update') ? 'Registro actualizado' : 'Acción registrada';

                await Swal.fire({
                    icon: 'success',
                    title: mnsj,
                    confirmButtonText: `Aceptar`
                });

                tbl_actions.ajax.reload(null, false);
            } else {
                await Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hemos tenido problemas para actualizar este registro, por favor intenta nuevamente.',
                    confirmButtonText: `Aceptar`
                });
            }

            country_form.reset();
            $('#modal_action').modal('hide');
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error dentro del sistema, actualiza el sitio, intentalo nuevamente o ponte en contacto con el administrador del sistema.',
                confirmButtonText: 'Aceptar'
            });
        }
    });

    //para limpiar los campos antes de dar de Alta una Persona

    $("#add_action").click(() => {
        option = 'create';
        idaction = null;

        $(".modal-title").text("Nueva acción");
    });

    //Evento de edición

    $(document).on("click", ".edit-data", function(){
        option = 'update';

        fila = $(this).closest("tr");

        idaction = this.value;
        accion = fila.find('td:eq(1)').text();
        btbadge = fila.find('td:eq(2)').text();

        $("#action").val(accion);
        $("#text").val(btbadge);

        $(".modal-title").text("Editar país");

        $('#modal_action').modal('show');
    });

    // Evento de actualización de estado

    $(document).on("click", ".edit-status", async function() {
        let arr_data = new FormData();

        arr_data.append('crud_actions', true);
        arr_data.append('option', 'change');
        arr_data.append('idaction', this.value);

        const confirmation = await Swal.fire({
            icon: 'question',
            title: 'Actualizar acción',
            html: '¿Realmente deseas actualizar el estado de este acción?',
            showCancelButton: true,
            confirmButtonText: 'Actualizar estado',
            confirmButtonColor: '#007bff',
            cancelButtonText: 'Cancelar'
        });

        if (confirmation.isConfirmed) {
            try {
                const response = await fetch('internal_data', {
                    method: 'POST',
                    body: arr_data
                });

                const data = await response.json();

                if (data) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Acción actualizada',
                        confirmButtonText: `Aceptar`
                    });
                    tbl_actions.ajax.reload(null, false);
                } else {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: 'No se logró actualizar la acción, inténtalo nuevamente.',
                        confirmButtonText: `Aceptar`
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error dentro del sistema, actualiza el sitio, intentalo nuevamente o ponte en contacto con el administrador del sistema.',
                    confirmButtonText: 'Aceptar'
                });
            }
        } else if (confirmation.isDenied) {
            Swal.fire('Acción cancelada', '', 'info');
        }
    });

});