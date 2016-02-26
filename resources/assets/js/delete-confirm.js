'use strict';

/**
 * Used to implement delete buttons in DataTable tables
 *
 * Note that this removes the row as well
 * 
 */

$('.delete[data-toggle="confirmation"]').confirmation({
	popout: true,
	singleton: true,
	btnOkIcon: 'fa fa-check',
	btnCancelIcon: 'fa fa-times',
    copyAttributes: 'onclick',
    onConfirm: function() {
        var table = $(this).parents('table').DataTable();
        var row = $(this).parents('tr');
       $.get($(this).data('target'))
        .done(function(response){
            table.row(row).remove().draw(false);
        });
    }
});