
$(document).ready(function() {

    // var fila captura la fila para editar o eliminar un registro

    // Almacenar la referencia al objeto DataTable en una variable
    var logsTable = $('#datable').DataTable({
        "ajax":{
            "url": "internal_data",
            "method": 'POST',
            "data": { crud_logs: true, option: 'read' },
            "dataSrc": ""
        },
        "columns":[
            {"data": "no"},
            {"data": "name"},
            {"data": "email"},
            {"data": "btbadge"},
            {"data": "description"},
            {"data": "created_at"}
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

    // Función para cargar los datos de la tabla
    function cargarDatos() {
        logsTable.ajax.reload(null, false); // Recargar los datos de la tabla
    }

    // Llamar a la función para cargar datos iniciales
    cargarDatos();

    // Actualizar la tabla cada 5 segundos
    setInterval(cargarDatos, 5000); // ajusta el tiempo según tus necesidades

});