// Datatables
$(document).ready( function(){
	var oldStart = 0;
	$("#playerstats").dataTable( {
		"order": [[2, "desc"]],
		"columnDefs": [{"orderable": false, "targets": 4}, {"orderable": false, "targets": 5}, {"orderable": false, "targets": 6}],
		"lengthMenu": [[15, 30, -1], [15, 30, "All"]], "bLengthChange": false,
		"fnDrawCallback": function (o) {
			if ( o._iDisplayStart != oldStart ) {
				var targetOffset = $('#playerstats').offset().top - 45;
				$('html,body').animate({scrollTop: targetOffset}, 500);
				oldStart = o._iDisplayStart;
			}
			$('[data-toggle="popover"]').popover();
			$('[data-toggle="tooltip"]').tooltip();
		}
	});

	$("#banlist").DataTable( {
		"order": [[ 4, "desc" ]],
		"columnDefs": [{"orderable": false, "targets": 0}, {"orderable": false, "targets": 1}, {"orderable": false, "targets": 2}, {"orderable": false, "targets": 3}, {"orderable": false, "targets": 6}],
		"lengthMenu": [[25, 50, -1], [25, 50, "All"]], "bLengthChange": false, "searching": false,
		"fnDrawCallback": function (o) {
			if ( o._iDisplayStart != oldStart ) {
				var targetOffset = $('#banlist').offset().top - 45;
				$('html,body').animate({scrollTop: targetOffset}, 500);
				oldStart = o._iDisplayStart;
			}
			$('[data-toggle="popover"]').popover();
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
});

// Toggle Up/Down icon
$('.toggle').on('click', function(){
	$(this).toggleClass('fa-plus-circle fa-minus-circle');
});

// Popovers
$(document).ready(function(){
	$('[data-toggle="popover"]').popover(); 
});

// Tooltips
$(function(){
	$('[data-toggle="tooltip"]').tooltip();
});
