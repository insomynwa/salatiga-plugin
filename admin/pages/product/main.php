<h3>Product</h3>
<div class="data-wrapper">
	<div class="plugin-data-filter row">
		<div class="col-sm-6">
			<?php if( sizeof( $attributes[ 'kategori' ] ) > 0 ): ?>
				<label class="">Kategori:</label>
				<select id="data-filter-kategori" class="">
					<option value="0">semua</option>
					<?php foreach( $attributes[ 'kategori' ] as $kategori ): ?>
						<option value="<?php _e( $kategori->GetId() ); ?>" ><?php _e( $kategori->GetNama() ); ?></option>
					<?php endforeach; ?>
				</select>
			<?php endif; ?>
		</div>
		<div class="col-sm-4">
			<div class="input-group">
				<input type="text" id="txt-search" class="form-control" placeholder="(nama)">
				<span class="input-group-btn">
					<button id="btn-search" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search">Cari</span></button>
				</span>
			</div>
		</div>
		<div class="col-sm-2">
			<label class="">Jumlah list:</label>
			<select id="data-limit" class="">
				<option value="5" <?php if( get_option( 'product_list_limit' ) == 5 ) _e( "selected='selected'" ); ?> >5</option>
				<option value="10" <?php if( get_option( 'product_list_limit' ) == 10 ) _e( "selected='selected'" ); ?> >10</option>
				<option value="25" <?php if( get_option( 'product_list_limit' ) == 25 ) _e( "selected='selected'" ); ?> >25</option>
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
				<form class="form-horizontal" id="form-product">
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
						<label class="col-sm-2 control-label" for="creator-product">Gambar</label>
						<!-- <input type="hidden" name="gambar-arr-product[]"> -->
						<!-- <div class="col-sm-8">
							<button id="btn-open-modal-gambar" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-gambar"><span class="glyphicon glyphicon-picture"></span></button>
						</div> -->
						<div class="col-sm-10">
							<button id="btn-open-modal-gambar" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-gambar"><span class="glyphicon glyphicon-picture"></span></button>
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
					<?php if( sizeof( $attributes[ 'kategori' ] ) > 0 ): ?>
						<?php foreach( $attributes[ 'kategori' ] as $kategori ): ?>
							<a href="#" class="list-kategori list-group-item" id="<?php _e( $kategori->GetId() ); ?>"><?php _e( $kategori->GetNama() ); ?></a>
						<?php endforeach; ?>
					<?php endif; ?>
					<!-- <a href="#" class="list-kategori list-group-item" id="1">kategori A</a>
					<a href="#" class="list-kategori list-group-item" id="2">kategori B</a>
					<a href="#" class="list-kategori list-group-item" id="3">kategori C</a> -->
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
					<?php if( sizeof( $attributes[ 'ukm' ] ) > 0 ): ?>
						<?php foreach( $attributes[ 'ukm' ] as $ukm ): ?>
							<a href="#" class="list-creator list-group-item" id="<?php _e( $ukm->GetId() ); ?>"><?php _e( $ukm->GetNama() ); ?></a>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<div id="modal-gambar" class="modal fade" role="dialog" aria-labelledby="gambarModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-primary">Gambar</h4>
			</div>
			<div class="modal-body">
				<div id="form-gambar-area">
					<div class="row">
						<div class="col-sm-12">
							<button class="btn btn-primary upload-btn" id="1">Add Picture</button>
						</div>
						<div class="col-sm-12">
							<div class="list-group">
							</div>
						</div>
					</div>
					<div id="list-tambah-gambar"></div>
					<div class="row">
						<div class="col-sm-offset-4 col-sm-4"><button class="btn btn-primary" id="btn-confirm-gambar">OK</button></div>
					</div>
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
	$( "#modal-gambar" ).on( "hidden.bs.modal", function (event) {
		$( "#modal-form-product" ).modal( "show" );
	});

	/*$( "#modal-kategori" ).on( "show.bs.modal", function (event) {
		$( "#modal-form-product" ).modal( "hide" );
	});
	$( "#modal-creator" ).on( "show.bs.modal", function (event) {
		$( "#modal-form-product" ).modal( "hide" );
	});*/
	$( "#modal-kategori, #modal-creator, #modal-gambar" ).on( "show.bs.modal", function (event) {
		hide_modal_product();
	});

	function hide_modal_product() {
		$( "#modal-form-product" ).modal( "hide" );
	}

	$( ".list-kategori" ).click( function(){
		$( "#kategori-product-id" ).val( (this).id );
		$( "#kategori-product" ).val( (this).text );//alert( (this).text );
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

	// UPLOAD PICTURES
	var arrGambar = [];
	var n_upload = 0;
	$('.upload-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            multiple: true
        }).open()
        .on('select', function(e){
            var selected = image.state().get('selection');
            var list_item = "";
            selected.each( function( att ) {
            	var url = att.toJSON().url;
            	//console.log(att.toJSON());
            	if( n_upload < 5 ) {
            		n_upload += 1;
            		list_item += "<div class='list-gambar list-group-item'><input class='list-gambar-radio' type='radio' name='gambar-product' value='" + url + "'> <label>" + att.toJSON().filename + "</label>  <a href='#' class='text-danger btn-remove-gambar' >remove</a></div>";
            	}
            });

            $( '#list-tambah-gambar' ).append(list_item);
            if ( n_upload == 5 ) {
            	$( "button.upload-btn").hide();
            }
        });
    });

	$( "#list-tambah-gambar" ).on( 'click', '.btn-remove-gambar', function() {
		$(this).parent().remove();
		n_upload -= 1;
		if( n_upload <= 5 && (! $( "button.upload-btn").is(":visible")) ) {
			$( "button.upload-btn").show();
		}
	});

	$( "#btn-confirm-gambar" ).click( function() {
		var i = 0;
		$( "input.list-gambar-radio" ).each( function(att) {
			//console.log( $(this).val() );
			arrGambar[i] = $( this ).val();
			i++;
		});
		//console.log( arrGambar );
		$( "#modal-gambar" ).modal( "hide" );
	});
	// END UPLOAD PICTURES

	$( "#form-product").submit( function(e) {
		e.preventDefault();
		//alert(arrGambar);
		var data = {
			action: "CreateNewProduct",
			nama: $( "#nama-product" ).val(),
			deskripsi: $( "#deskripsi-product" ).val(),
			infolain: $( "#info-lain-product" ).val(),
		};
		data.kategori = $( "#kategori-product-id" ).val();
		data.kreator = $( "#creator-product-id" ).val();
		data.gambararr = arrGambar;
		//alert("TEST");
		$.post(
			sltg_ajax.ajaxurl,
			data,
			function( response ) {
				var result = jQuery.parseJSON( response );
				if( result.status ) {
					hide_modal_product();
					reset_form_product();
					doRetrievePagination( "product", limit, kategori, searchfor, "#plugin-data-pagination" );
				}else{
					alert( result.message );
				}
			}
		);
	});

	function reset_form_product() {
		$( "#nama-product" ).val( "" );
		$( "#deskripsi-product" ).val( "" );
		$( "#info-lain-product" ).val( "" );
		$( "#kategori-product-id" ).val( 0 );
		$( "#kategori-product" ).val( "" );
		$( "#creator-product-id" ).val( 0 );
		$( "#creator-product" ).val( "" );

		arrGambar.length = 0;
		n_upload = 0;

		$( "#list-tambah-gambar" ).html( "" );
		if( (! $( "button.upload-btn").is(":visible")) ) {
			$( "button.upload-btn").show();
		}
	}


	var limit = $( "#data-limit" ).val();
	var searchfor = $( "#txt-search").val();
	var isSearching = false;
	var kategori = $( "#data-filter-kategori" ).val();

	doRetrievePagination( "product", limit, kategori, searchfor, "#plugin-data-pagination" );

	$( "#data-limit" ).on( "change", function() {

		limit = this.value;

		doRetrievePagination( "product", limit, kategori, searchfor, "#plugin-data-pagination" );

	});	

	$( "#data-filter-kategori").on( "change", function() {
		kategori = this.value;
		doRetrievePagination( "product", limit, kategori, searchfor, "#plugin-data-pagination");
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

			doRetrievePagination( "product", limit, kategori, searchfor, "#plugin-data-pagination" );
		}

	});
	
});
</script>