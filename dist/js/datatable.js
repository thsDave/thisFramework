$(document).ready(function () {
	$('.datable_es').DataTable({
		"responsive": true,
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"language":
		{
			"emptyTable":			"No hay datos disponibles en la tabla.",
			"info":		   			"Del _START_ al _END_ de _TOTAL_ ",
			"infoEmpty":			"Mostrando 0 registros de un total de 0.",
			"infoFiltered":			"(filtrados de un total de _MAX_ registros)",
			"infoPostFix":			" ",
			"lengthMenu":			"Mostrar &nbsp; _MENU_",
			"loadingRecords":		"Cargando...",
			"processing":			"Procesando...",
			"search":				"Buscar:",
			"searchPlaceholder":	"Dato para buscar",
			"zeroRecords":			"No se han encontrado coincidencias.",
			"paginate":
			{
				"first":			"Primera",
				"last":				"Última",
				"next":				"Siguiente",
				"previous":			"Anterior"
			},
			"aria":
			{
				"sortAscending":	"Ordenación ascendente",
				"sortDescending":	"Ordenación descendente"
			}
		},
		"lengthMenu": [[5, 10, 20, 25, 50, -1], [5, 10, 20, 25, 50, "Todos"]]
	});

	$('.datable_en').DataTable({
		"responsive": true,
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"language":
		{
			"emptyTable":			"No data available in table.",
			"info":		   			"From _START_ to _END_ of _TOTAL_ ",
			"infoEmpty":			"Showing 0 records out of a total of 0.",
			"infoFiltered":			"(filtered from a total of _MAX_ records)",
			"infoPostFix":			" ",
			"lengthMenu":			"Show &nbsp; _MENU_",
			"loadingRecords":		"Charging...",
			"processing":			"Processing...",
			"search":				"Search:",
			"searchPlaceholder":	"Data to search",
			"zeroRecords":			"No matches found.",
			"paginate":
			{
				"first":			"First",
				"last":				"Last",
				"next":				"Next",
				"previous":			"Previous"
			},
			"aria":
			{
				"sortAscending":	"Ascending sort",
				"sortDescending":	"Descending sort"
			}
		},
		"lengthMenu": [[5, 10, 20, 25, 50, -1], [5, 10, 20, 25, 50, "All"]]
	});
});