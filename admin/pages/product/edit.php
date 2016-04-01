<?php $product = $attributes[ 'product' ]; ?>
<h3>Edit Product</h3>
<div class="data-wrapper">
	<form class="form-horizontal" id="form-product">
		<div class="col-sm-offset-2 form-message"></div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="nama-product">Name <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="nama-product" class="form-control" id="nama-product" placeholder="nama" required="required" value="<?php _e( $product->GetNama() ); ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="deskripsi-product">Description</label>
			<div class="col-sm-4">
				<textarea name="deskripsi-product" class="form-control" id="deskripsi-product"><?php _e( $product->GetDeskripsi() ); ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="info-lain-product">Other</label>
			<div class="col-sm-4">
				<textarea name="info-lain-product" class="form-control" id="info-lain-product"><?php _e( $product->GetOther() ); ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="kategori-product">Category <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="kategori-product" class="form-control" id="kategori-product" placeholder="kategori" required="required" value="<?php _e( $product->GetKategori()->GetNama() ); ?>" readonly="readonly">
				<input type="hidden" name="kategori-product-id" id="kategori-product-id" value="<?php _e( $product->GetKategori()->GetId() ); ?>">
			</div>
			<div class="col-sm-2">
				<button id="btn-refresh-kategori" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-refresh"></span></button>
				<button id="btn-open-modal-kategori" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-kategori"><span class="glyphicon glyphicon-list"></span></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="creator-product">Creator <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="creator-product" class="form-control" id="creator-product" placeholder="nama creator (Soekarno) " required="required" value="<?php _e( $product->GetUKM()->GetNama() ); ?>" readonly="readonly">
				<input type="hidden" name="creator-product-id" id="creator-product-id" value="<?php _e( $product->GetUKM()->GetId() ); ?>">
			</div>
			<div class="col-sm-2">
				<button id="btn-refresh-creator" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-refresh"></span></button>
				<button id="btn-open-modal-creator" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-creator"><span class="glyphicon glyphicon-user"></span></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="creator-product">Picture(s) <strong>*</strong></label>
			<div class="col-sm-4">
				<button id="btn-open-modal-gambar" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-gambar"><span class="glyphicon glyphicon-picture"></span></button>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-4">
				<button class="form-control btn btn-success" type="submit" name="submit-product" id="submit-product"><span class="glyphicon glyphicon-save"></span> Save</button>
			</div>	
		</div>
	</form>
</div>
<div class="plugin-content-link">
	<!-- <button id="add-product" class="btn btn-primary" data-toggle="modal" data-target="#modal-form-product">
		<span class="glyphicon glyphicon-plus"></span> Add
	</button> -->
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
					<div id="list-tambah-gambar">
						<div class='list-gambar list-group-item'><input class='list-gambar-radio' type='radio' name='gambar-product' value='<?php _e( $product->GetGambarUtama()->GetLinkGambar() ); ?>'> <label><?php _e( $product->GetGambarUtama()->GetLinkGambar() ); ?></label>  <a href='#' class='text-danger btn-remove-gambar' >remove</a></div>
						<?php foreach( $product->GetGambars() as $gbr ): ?>
							<?php if( $gbr->GetGambarUtama() == 0 ): ?>
								<div class='list-gambar list-group-item'><input class='list-gambar-radio' type='radio' name='gambar-product' value='<?php _e( $gbr->GetLinkGambar() ); ?>'> <label><?php _e( $gbr->GetLinkGambar() ); ?></label>  <a href='#' class='text-danger btn-remove-gambar' >remove</a></div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
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
	n_upload = <?php _e( sizeof( $product->GetGambars() ) ) ?>;
	var i = 0;
	<?php foreach( $product->GetGambars() as $gbr ): ?>
		arrGambar[i] = "<?php _e( $gbr->GetLinkGambar() ); ?>";
		i += 1;
	<?php endforeach; ?>

	if ( n_upload == 5 ) {
    	$( "button.upload-btn").hide();
    }

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
		
		var iNama = $( "#nama-product" ),
			iKatId = $( "#kategori-product-id" ),
			iKatTxt = $( "#kategori-product" ),
			iCreId = $( "#creator-product-id" ),
			iCreTxt = $( "#creator-product" ),
			iInfo = $( "#info-lain-product" ),
			iDes = $( "#deskripsi-product" ),
			not_empty = true;

		if( $.trim( iNama.val() ) == '' ) {
			iNama.addClass( 'req-input input-empty');
			iNama.focus();
			not_empty = false;
		}
		if( iKatId.val() == 0 && $.trim( iKatTxt.val() ) == '' )
			not_empty = false;
		if( iCreId.val() == 0 && $.trim( iCreTxt.val() ) == '' )
			not_empty = false;
		if( arrGambar.length < 1 ){
			not_empty = false;
		}
		console.log(not_empty);

		if( not_empty ) {
			var data = {
				action: "CreateNewProduct",
				nama: iNama.val(),
				deskripsi: iDes.val(),
				infolain: iInfo.val(),
			};
			data.kategori = iKatId.val();
			data.kreator = iCreId.val();
			data.gambararr = arrGambar;
			//alert("TEST");
			$.post(
				sltg_ajax.ajaxurl,
				data,
				function( response ) {
					var result = jQuery.parseJSON( response );
					if( result.status ) {
						$( "div.form-message").html( "<p class='text-success'>Success!</p>");
						//location.href = "<?php echo admin_url('admin.php?page=sltg-product'); ?>";
					}else{
						$( "div.form-message").html( "<p class='text-danger'>" + result.message + "</p>");
					}
				}
			);
		}else{
			$( "div.form-message").html( "<p class='text-danger'>Name, Category, Creator, and Picture(s) are required.</p>");
		}
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
	
});
</script>