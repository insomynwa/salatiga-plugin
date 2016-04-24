jQuery(document).ready( function ($) {

	window.doRetrievePagination = function RetrivePagination( data, target_element ) {

		$.get(
			sltg_ajax.ajaxurl,
			data,
			function (response) {
				$( target_element ).html( response );
			}
		);
	}

	window.doRetrieveList = function RetrieveList( data, target_element) {
		$.get(
			sltg_ajax.ajaxurl,
			data,
			function( response ) {
				$(target_element).html( response );
		});
	}
});