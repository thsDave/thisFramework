
$(document).ready(function() {

    // var fila captura la fila para editar o eliminar un registro

    var url = window.location;

    $('#datable').DataTable({
        "ajax":{
            "url": "internal_data",
            "method": 'POST',
            "data": { crud_users: true, option: 'read' },
            "dataSrc": ""
        },
        "columns":[
            {"data": "no"},
            {"data": "name"},
            {"data": "email"},
            {"data": "level"},
            {"data": "country"},
            {"data": "btbadge"},
            {
                "data": "iduser",
                "render": function (data, type, row) {
                    return `<a href="${url}?req=user_profile&val=${row.iduser}" class="btn btn-sm btn-dark">ver perfil</a>`
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
});