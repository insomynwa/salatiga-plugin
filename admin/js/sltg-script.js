jQuery(document).ready( function ($) {

	window.doRetrievePagination = function RetrivePagination( data, target_element ) {
	//window.doRetrievePagination = function RetrivePagination( target_data, limit, kategori, searchfor, target_element ) {
		// var data = {
		// 	action: 'RetrievePagination',
		// 	listfor: target_data,
		// 	limit: limit
		// };
		// if( kategori != 0 ){
		// 	data.category = kategori;
		// }
		// if( searchfor != "" ) {
		// 	data.search = searchfor;
		// }

		$.get(
			sltg_ajax.ajaxurl,
			data,
			function (response) {
				$( target_element ).html( response );
			}
		);
	}

	window.doRetrieveList = function RetrieveList( data, target_element) {
	// window.doRetrieveList = function RetrieveList( target_data, limit, page, searchfor, kategori, target_element) {
		// var data = {
		// 	action: 'RetrieveList',
		// 	listfor: target_data,
		// 	page: page,
		// 	limit: limit
		// };
		// if( kategori != 0 ){
		// 	data.category = kategori;
		// }
		// if( searchfor != "" ) {
		// 	data.search = searchfor;
		// }
		$.get(
			sltg_ajax.ajaxurl,
			data,
			function( response ) {
				$(target_element).html( response );
		});
	}
});