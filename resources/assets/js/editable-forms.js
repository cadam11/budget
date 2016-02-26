"use strict";


/**
 *
 * Global configuration for editable forms plugin
 * https://github.com/vitalets/x-editable
 * 
 */

$.fn.editableform.buttons =
  '<button type="submit" class="btn btn-primary btn-sm editable-submit">'+
    '<i class="fa fa-fw fa-check"></i>'+
  '</button>'+
  '<button type="button" class="btn btn-default btn-sm editable-cancel">'+
    '<i class="fa fa-fw fa-times"></i>'+
  '</button>';

$.fn.editable.defaults.params = function (params) {
    params._token = $("#_token").data("token");
    return params;
};

$('.editable').editable({
	mode: 'inline',
	clear: true
});