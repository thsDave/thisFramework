
$(document).ready(function() {

    // var fila captura la fila para editar o eliminar un registro

    var idlang, fila, option;

    var tbl_languages = $('#datable').DataTable({
        "ajax":{
            "url": "internal_data",
            "method": 'POST',
            "data": { crud_language: true, option: 'read' },
            "dataSrc": ""
        },
        "columns":[
            {"data": "no"},
            {"data": "language"},
            {"data": "lancode"},
            {"data": "lanicon"},
            {"data": "btbadge"},
            {"data": "updated_at"},
            {
                "data": "idlang",
                "render": function (data, type, row) {
                    return `<div class='wrapper'>
                        <button type="button" class="btn btn-sm btn-info edit-data" value="${row.idlang}" data-toggle="tooltip" data-bs-placement="top" title="editar registro">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-warning edit-status" value="${row.idlang}" data-toggle="tooltip" data-bs-placement="top" title="cambiar estado">
                            <i class="fa-solid fa-rotate"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger delete-data" value="${row.idlang}" data-toggle="tooltip" data-bs-placement="top" title="eliminar registro">
                            <i class="fa-solid fa-trash-can"></i>
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

    var lang_form = document.getElementById('lang_form');

    lang_form.addEventListener('submit', async (e) => {
        e.preventDefault();

        let arr_data = new FormData(lang_form);
        arr_data.append('crud_language', true);
        arr_data.append('option', option);
        arr_data.append('idlang', idlang);

        try {
            const response = await fetch('internal_data', {
                method: 'POST',
                body: arr_data
            });

            const data = await response.json();

            if (data) {
                let mnsj = (option == 'update') ? 'Registro actualizado' : 'País registrado';

                await Swal.fire({
                    icon: 'success',
                    title: mnsj,
                    confirmButtonText: `Aceptar`
                });
                tbl_languages.ajax.reload(null, false);
            } else {
                await Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hemos tenido problemas para actualizar este registro, por favor intenta nuevamente.',
                    confirmButtonText: `Aceptar`
                });
            }

            lang_form.reset();

            $('#modal_lang').modal('hide');

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

    $("#add_lang").click(() => {
        option = 'create';
        idlang = null;

        $(".modal-title").text("Nuevo idioma");
    });

    //Evento de edición

    $(document).on("click", ".edit-data", function(){
        option = 'update';

        fila = $(this).closest("tr");

        idlang = this.value;
        lang = fila.find('td:eq(1)').text();
        lancode = fila.find('td:eq(2)').text();
        lanicon = fila.find('td:eq(3)').text();

        $("#language").val(lang);
        $("#lancode").val(lancode);
        $("#lanicon").val(lanicon);

        $(".modal-title").text("Editar idioma");

        $('#modal_lang').modal('show');
    });

    // Evento de actualización de estado

    $(document).on("click", ".edit-status", async function() {
        let arr_data = new FormData();

        arr_data.append('crud_language', true);
        arr_data.append('option', 'change');
        arr_data.append('idlang', this.value);

        const confirmation = await Swal.fire({
            icon: 'question',
            title: 'Actualizar idioma',
            html: '¿Realmente deseas actualizar el estado de este idioma?',
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
                        title: 'Idioma actualizado',
                        confirmButtonText: `Aceptar`
                    });
                    tbl_languages.ajax.reload(null, false);
                } else {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: 'No se logró actualizar el idioma, inténtalo nuevamente.',
                        confirmButtonText: `Aceptar`
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error dentro del sistema, actualiza el sitio e intentalo nuevamente o ponte en contacto con el administrador del sistema.',
                    confirmButtonText: 'Aceptar'
                });
            }
        } else if (confirmation.isDenied) {
            Swal.fire('Acción cancelada', '', 'info');
        }
    });

    //Borrar
    $(document).on("click", ".delete-data", async function() {
        let arr_data = new FormData();

        arr_data.append('crud_language', true);
        arr_data.append('option', 'delete');
        arr_data.append('idlang', this.value);

        const confirmation = await Swal.fire({
            icon: 'question',
            title: 'Eliminar idioma',
            html: '¿Realmente deseas eliminar este idioma?',
            showCancelButton: true,
            confirmButtonText: 'Eliminar idioma',
            confirmButtonColor: '#dc3545',
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
                        title: 'Idioma eliminado',
                        confirmButtonText: `Aceptar`
                    });
                    tbl_languages.ajax.reload(null, false);
                } else {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: 'No se logró eliminar el idioma, inténtalo nuevamente.',
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