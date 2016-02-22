'use strict';

/**
 * Used to implement delete buttons in DataTable tables
 *
 * Note that this removes the row as well
 * 
 */

$('.delete[data-toggle="confirmation"]').confirmation({
    onConfirm: function() {
        var row = $(this).parents('tr');
       $.get($(this).data('target'))
        .done(function(response){
            $(row).remove();
        })
        .fail(function(response){ 
            console.error(response);
        });
    }
});