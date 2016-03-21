jQuery(document).ready( function ($) {

	/*function data_ajax( action, listfor, limit ){
		this.action = action;
		this.listfor = listfor;
		this.limit = limit;
	}

	window.Pagination = function SltgPagination(listfor, limit, search, targetElement ){

		this.action = 'RetrivePagination' ;
		this.listfor = listfor;
		this.limit = limit;
		this.search = search;
		this.targetElement = targetElement;
		this.retrieve =  function(){
			var data = new data_ajax(this.action, this.listfor, this.limit);
			if( (this.search).split(' ').pop() != "" )
				data.prototype.search = this.search;
			$.get(
				sltg_ajax.ajaxurl,
				data,
				function (response) {alert(response);
					$( targetElement ).html(response);
				}
			);
		}
	}*/

	window.doRetrievePagination = function RetrivePagination( target_data, limit, searchfor, target_element ) {
		var data = {
			action: 'RetrievePagination',
			listfor: target_data,
			limit: limit,
			//security: sltgtempscript.security
		};
		if( searchfor != "" ) {
			data.search = searchfor;
		}

		$.get(
			sltg_ajax.ajaxurl,
			data,
			function (response) {
				$( target_element ).html( response );
			}
		);
	}

	window.doRetrieveList = function RetrieveList( target_data, limit, page, searchfor, target_element) {
		var data = {
			action: 'RetrieveList',
			listfor: target_data,
			page: page,
			limit: limit
		};
		if( searchfor != "" ) {
			data.search = searchfor;
		}
		$.get(
			sltg_ajax.ajaxurl,
			data,
			function( response ) {
				$(target_element).html( response );
		});
	}
});