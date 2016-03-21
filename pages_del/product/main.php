<h3>Product</h3>
<div class="data-wrapper">
	<div class="plugin-data-filter row">
		<div class="col-sm-6"></div>
		<div class="col-sm-4">
			<div class="input-group">
				<input type="text" id="txt-search" class="form-control" placeholder="(nama)">
				<span class="input-group-btn">
					<button id="btn-search" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
				</span>
			</div>
		</div>
		<div class="col-sm-2">
			<label class="">Jumlah list:</label>
			<select id="data-limit" class="">
				<option value="1" <?php if( get_option( 'product_list_limit' ) == 1 ) _e( "selected='selected'" ); ?> >1</option>
				<option value="2" <?php if( get_option( 'product_list_limit' ) == 2 ) _e( "selected='selected'" ); ?> >2</option>
				<option value="3" <?php if( get_option( 'product_list_limit' ) == 3 ) _e( "selected='selected'" ); ?> >3</option>
			</select>
		</div>
	</div>
	<div id="plugin-data-list"></div>
	<div id="plugin-data-pagination">
	</div>
</div>
<div class="plugin-content-link">
	<button id="add-product" class="btn btn-primary" data-toggle="modal" data-target="#modal-form-product">
		<span class="glyphicon glyphicon-plus"></span> Add
	</button>
</div>
<div id="modal-form-product" class="modal fade" role="dialog" aria-labelledby="productModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-primary" id="productModalLabel">Form Product</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="nama-product">Name</label>
						<div class="col-sm-10">
							<input type="text" name="nama-product" class="form-control" id="nama-product" placeholder="nama" required="required">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="deskripsi-product">Description</label>
						<div class="col-sm-10">
							<textarea name="deskripsi-product" class="form-control" id="deskripsi-product"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="info-lain-product">Other</label>
						<div class="col-sm-10">
							<textarea name="info-lain-product" class="form-control" id="info-lain-product"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="kategori-product">Category</label>
						<div class="col-sm-6">
							<input type="text" name="kategori-product" class="form-control" id="kategori-product" placeholder="kategori" required="required">
							<input type="hidden" name="kategori-product-id" id="kategori-product-id" value="0">
						</div>
						<div class="col-sm-4">
							<button id="btn-refresh-kategori" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-refresh"></span></button>
							<button id="btn-open-modal-kategori" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-kategori"><span class="glyphicon glyphicon-list"></span></button>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="creator-product">Creator</label>
						<div class="col-sm-6">
							<input type="text" name="creator-product" class="form-control" id="creator-product" placeholder="nama creator (Soekarno) " required="required">
							<input type="hidden" name="creator-product-id" id="creator-product-id" value="0">
						</div>
						<div class="col-sm-4">
							<button id="btn-refresh-creator" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-refresh"></span></button>
							<button id="btn-open-modal-creator" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-creator"><span class="glyphicon glyphicon-user"></span></button>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button class="form-control btn btn-success" type="submit" name="submit-product" id="submit-product"><span class="glyphicon glyphicon-save"></span> Save</button>
						</div>	
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<div id="modal-kategori" class="modal fade" role="dialog" aria-labelledby="kategoriModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-primary">Pemilik</h4>
			</div>
			<div class="modal-body">
				<div class="list-group">
					<a href="#" class="list-kategori list-group-item" id="1">kategori A</a>
					<a href="#" class="list-kategori list-group-item" id="2">kategori B</a>
					<a href="#" class="list-kategori list-group-item" id="3">kategori C</a>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<div id="modal-creator" class="modal fade" role="dialog" aria-labelledby="creatorModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-primary">Pemilik</h4>
			</div>
			<div class="modal-body">
				<div class="list-group">
					<a href="#" class="list-creator list-group-item" id="1">creator A</a>
					<a href="#" class="list-creator list-group-item" id="2">creator B</a>
					<a href="#" class="list-creator list-group-item" id="3">creator C</a>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready( function($) {
	$( "#modal-kategori" ).on( "hidden.bs.modal", function (event) {
		$( "#modal-form-product" ).modal( "show" );
	});
	$( "#modal-creator" ).on( "hidden.bs.modal", function (event) {
		$( "#modal-form-product" ).modal( "show" );
	});

	$( "#modal-kategori" ).on( "show.bs.modal", function (event) {
		$( "#modal-form-product" ).modal( "hide" );
	});
	$( "#modal-creator" ).on( "show.bs.modal", function (event) {
		$( "#modal-form-product" ).modal( "hide" );
	});

	$( ".list-kategori" ).click( function(){
		$( "#kategori-product-id" ).val( (this).id );
		$( "#kategori-product" ).val( (this).text );
		$( "#kategori-product" ).prop( "readonly", true );
		$( "#modal-kategori" ).modal( "hide" );
	});
	$( ".list-creator" ).click( function(){
		$( "#creator-product-id" ).val( (this).id );
		$( "#creator-product" ).val( (this).text );
		$( "#creator-product" ).prop( "readonly", true );
		$( "#modal-creator" ).modal( "hide" );
	});
	$( "#btn-refresh-kategori").click( function(){
		$( "#kategori-product" ).prop( "readonly", false );
		$( "#kategori-product" ).val( "" );
		$( "#kategori-product" ).focus();
		$( "#kategori-product-id" ).val( 0 );
	});
	$( "#btn-refresh-creator").click( function(){
		$( "#creator-product" ).prop( "readonly", false );
		$( "#creator-product" ).val( "" );
		$( "#creator-product" ).focus();
		$( "#creator-product-id" ).val( 0 );
	});
	
	//alert( $("ul.pagination li"))
	// var current_page = 1;
	// var selected_page = current_page;
	var limit = $( "#data-limit" ).val();
	var searchfor = $( "#txt-search").val();
	var isSearching = false;

	/*var pagination = new Pagination( "product", limit, searchfor, "#plugin-data-pagination");
	pagination.retrieve();*/

	doRetrievePagination( "product", limit, searchfor, "#plugin-data-pagination" );

	$( "#data-limit" ).on( "change", function() {
		//selected_page = 1;
		limit = this.value;
		//searchfor = "";//$( "#txt-search" ).val();
		//if( isSearching ) searchfor = $( "#txt-search" ).val();

		// $( ".pagination a.page-" + current_page).parent().removeClass("active");
		// $( ".pagination a.page-" + selected_page ).parent().addClass("active");
		//current_page = selected_page;

		doRetrievePagination( "product", limit, searchfor, "#plugin-data-pagination" );
		//retrieveList( "#plugin-data-list" );
	});	

	$( "#btn-search" ).click( function(e) {
		if( ($( "#txt-search" ).val()).split(' ').join('') != '' ) {
			if( !isSearching ) {
				isSearching = true;
				$( this ).addClass('searching').html( "<span class='glyphicon glyphicon-remove-circle'></span>" );
				$( "#txt-search").prop( "readonly" , true);
				searchfor = $( "#txt-search" ).val();

			}else {
				isSearching = false;
				$( this ).removeClass('searching').html( "<span class='glyphicon glyphicon-search'></span>" );
				$( "#txt-search").prop( "readonly", false);
				searchfor = "";
				$( "#txt-search").val("");
			}
			limit = $( "#data-limit" ).val();

			/*searchfor = ( $( "#txt-search").val() ).split(' ').join('');;
			if( searchfor != "" ) {
				isSearching = true;
			}*/
			doRetrievePagination( "product", limit, searchfor, "#plugin-data-pagination" );
		}
		//current_page = 1;
		//selected_page = current_page;
		//searchFor( searchfor, "#plugin-data-list" );
	});

	/*function searchFor( search, target_element) {

		$.get( sltg_ajax.ajaxurl,
			{
				action: 'SearchFor',
				listfor: 'product', page: current_page, limit: limit, search: search
			},
			function (response) {
				$( target_element ).html( response );
		});
	}*/
	
});
</script>