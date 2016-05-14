<?php 
	$product = $attributes[ 'product' ]; 
?>
<h3>Edit Product</h3>
<div class="data-wrapper">
	<form class="form-horizontal" id="form-product">
		<?php if( isset( $attributes[ 'message' ] ) ) { ?><div class="form-group"><div class="col-sm-offset-2  col-sm-4 form-message"><p class="text-success"><?php _e( $attributes[ 'message' ] ); ?></p></div></div><?php } ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="nama-product">Name <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="nama-product" class="form-control" id="nama-product" placeholder="nama" required="required" value="<?php _e( $product->GetNama() ) ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="deskripsi-product">Description</label>
			<div class="col-sm-4">
				<textarea name="deskripsi-product" class="form-control" id="deskripsi-product"><?php _e( $product->GetDeskripsi() ) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="info-lain-product">Other</label>
			<div class="col-sm-4">
				<textarea name="info-lain-product" class="form-control" id="info-lain-product"><?php _e( $product->GetOther() ) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="kategori-product">Category <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="kategori-product" class="form-control" id="kategori-product" placeholder="kategori" required="required" value="<?php _e( $product->GetKategori()->GetNama() ) ?>">
				<input type="hidden" name="kategori-product-id" id="kategori-product-id" value="<?php _e( $product->GetKategori()->GetID() ) ?>">
			</div>
			<div class="col-sm-2">
				<button id="btn-refresh-kategori" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-refresh"></span></button>
				<button id="btn-open-modal-kategori" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-kategori"><span class="glyphicon glyphicon-list"></span></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="creator-product">Creator <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="creator-product" class="form-control" id="creator-product" placeholder="nama creator (Soekarno) " required="required" readonly value="<?php _e( $product->GetProducer()->GetNama() ) ?>">
				<input type="hidden" name="creator-product-id" id="creator-product-id" value="<?php _e( $product->GetProducer()->GetID() ) ?>">
			</div>
			<div class="col-sm-2">
				<button id="btn-refresh-creator" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-refresh"></span></button>
				<button id="btn-open-modal-creator" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-creator"><span class="glyphicon glyphicon-user"></span></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="creator-product">Picture(s) <strong>*</strong></label>
			<div class="col-sm-2">
				<button class="btn btn-primary upload-btn" id="1">Add Picture</button>
			</div>
		</div>
		<?php for( $i = 0; $i < 5; $i++ ): ?>
		<?php $gbr = $product->GetGambars()[ $i ]; ?>
		<?php
			if( !is_null( $gbr ) ) {
				$linkGbr = $gbr->GetLinkGambar();
				$arrLinkGambar = explode( "/", $linkGbr ); 
			}
		?>
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-1">
				<img id="gbr-view<?php _e($i); ?>" src="<?php if( !is_null($gbr ) ) _e( $gbr->GetLinkGambar() ) ?>" alt="" class="gambar-view-product" height="50">
			</div>
			<div class="col-sm-3">
				<input id="gbr-fname<?php _e($i); ?>" type="text" name="gambar-url-product[]" class="form-control gambar-url-product" readonly="readonly" value="<?php if( !is_null($gbr ) ) _e( end($arrLinkGambar) ); ?>">
				<input id="gbr-id<?php _e($i); ?>" type="hidden" name="gambar-id-product[]" value="<?php if( !is_null( $gbr ) ) _e( $gbr->GetPostId() ) ; ?>" class="gambar-id-product">
			</div>
			<div class="col-sm-1">
				<button id="rem-gbr<?php _e($i); ?>" class="btn btn-primary remove-gambar-product" type="button"><span class="glyphicon glyphicon-remove"></span></button>
			</div>
			<div class="col-sm-2">
				<input id="gbr-radio<?php _e($i); ?>" class='gambar-utama-product' type='radio' name='gambar-utama-product' value='<?php if( !is_null( $gbr ) ) _e( $gbr->GetGambarUtama() ) ; ?>' <?php if( !is_null( $gbr ) && $gbr->GetGambarUtama()==1 ) _e( 'checked="checked"' ) ; ?>> gambar utama
			</div>
		</div>
		<?php endfor; ?>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-4">
				<button class="form-control btn btn-success" type="submit" name="submit-product" id="submit-product"><span class="glyphicon glyphicon-save"></span> Save</button>
			</div>	
		</div>
	</form>
</div>
<div class="plugin-content-link">
	Go to <a href="<?php echo admin_url( 'admin.php?page=sltg-product' ); ?>">product list</a>.
	<!-- <button id="add-product" class="btn btn-primary" data-toggle="modal" data-target="#modal-form-product">
		<span class="glyphicon glyphicon-plus"></span> Add
	</button> -->
</div>
<div id="modal-kategori" class="modal fade" role="dialog" aria-labelledby="kategoriModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-primary">Kategori</h4>
			</div>
			<div class="modal-body">
				<div id="kategori-list" class="list-group">
					<?php if( sizeof( $attributes[ 'kategori' ] ) > 0 ): ?>
						<?php foreach( $attributes[ 'kategori' ] as $kategori ): ?>
							<a href="#" class="list-kategori list-group-item" id="<?php _e( $kategori->GetID() ); ?>"><?php _e( $kategori->GetNama() ); ?></a>
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
				<h4 class="modal-title text-primary">Producer (UKM)</h4>
			</div>
			<div class="modal-body">
				<div class="list-group">
					<?php if( sizeof( $attributes[ 'ukm' ] ) > 0 ): ?>
						<?php foreach( $attributes[ 'ukm' ] as $ukm ): ?>
							<a href="#" class="list-creator list-group-item" id="<?php _e( $ukm->GetID() ); ?>"><?php _e( $ukm->GetNama() ); ?></a>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<!-- <a href="?page=sltg-product&doaction=create-new"> -->
				<a href="?page=sltg-ukm&doaction=create-new">
					<button id="add-product" class="btn btn-primary">
						<span class="glyphicon glyphicon-plus"></span> Add
					</button>
				</a>
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
		//$( "#creator-product" ).prop( "readonly", false );
		$( "#creator-product" ).val( "" );
		$( "#creator-product" ).focus();
		$( "#creator-product-id" ).val( 0 );
	});

	// UPLOAD PICTURES
	/*var arrGambar = [];*/
	var arrImgList = [];
	var initIdx = 0, initUrl = "", initPostId = 0, initFname = "", initAlter = "";
	var initImg;
	<?php foreach( $product->GetGambars() as $gbr ): ?>
		initPostId = <?php _e($gbr->GetPostId()); ?>;
		<?php $linkGbr = $gbr->GetLinkGambar(); ?>
		initUrl = "<?php _e( $linkGbr) ?>" ;
		<?php $arrLinkGambar = explode( "/", $linkGbr ); ?>
		initFname = "<?php _e( end( $arrLinkGambar ) ); ?>";
		initAlter = initFname;

		initImg = new ImgList( initPostId, initUrl, initFname, initAlter );
		initImg.utama = <?php _e( $gbr->GetGambarUtama() ); ?>;
		arrImgList[ initIdx ] = initImg;

		//console.log(initIdx);
		initIdx += 1;
	<?php endforeach; ?>
	//var n_upload = 0;
	// var selectedMainImage = 0;
	$('.upload-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            multiple: true
        }).open()
        .on('select', function(e){
            var selected = image.state().get('selection');
            selected.each( function( att ) {
            	var attJSON = att.toJSON();
            	var url = attJSON.url;
            	var post_id = attJSON.id;
            	var fname = attJSON.filename;
            	var alter = fname;

            	if( arrImgList.length < 5) {

	            	var imgList = new ImgList( post_id, url, fname, alter );
	            	if( arrImgList.length == 0 ){
	            		imgList.utama = 1;
	            		// selectedMainImage = post_id;
	            	}

	            	arrImgList.push( imgList );
	            }
            });
			loadImageToForm();
        });
    });

	$( ".remove-gambar-product" ).click( function() {
		var idBtn = ((this).id).split('rem-gbr').pop();

		if( $( "#gbr-fname" + idBtn).val() != "" ) {
			arrImgList.splice( idBtn, 1);

			clearImageForm();
			loadImageToForm();
		}
	});

	$( ".gambar-utama-product" ).on( "click", function(e) {
		var idRadio = ((this).id).split( 'gbr-radio' ).pop();

		if( $( "#gbr-fname" + idRadio).val() != "" ) {
			clearCheckedRadio();

			$( "#gbr-radio" + idRadio).prop( "checked", 1 );
			arrImgList[ idRadio ].utama = 1;

			// selectedMainImage = $( "#gbr-id" + idRadio ).val();
		}else{
			e.preventDefault();
		}
	});


	function loadImageToForm(){
		for( var i=0; i< arrImgList.length; i++ ){
			$( "#gbr-fname" + i).val( arrImgList[i].fname );
			$( "#gbr-id" + i).val( arrImgList[i].post_id );
			$( "#gbr-view" + i).prop( "src", arrImgList[i].url );
			$( "#gbr-view" + i).prop( "alt", arrImgList[i].alter );
			$( "#gbr-radio" + i).prop( "value", arrImgList[i].post_id );
			$( "#gbr-radio" + i).prop( "checked", arrImgList[i].utama );

			if ( arrImgList.length == 5) {
				hideButtonUploadImage();
			}else {
				showButtonUploadImage();
			}
		}
	}

	function clearImageForm() {
		$( ".gambar-url-product" ).val( "" );
		$( ".gambar-id-product" ).val( "" );
		$( ".gambar-view-product" ).prop( "src", "" );
		$( ".gambar-view-product" ).prop( "alt", "" );
		$( ".gambar-utama-product" ).val( 0 );
		$( ".gambar-utama-product" ).prop( "checked", 0 );
	}

	function showButtonUploadImage() {
		if( ! $( "button.upload-btn").is(":visible") ) {
			$( "button.upload-btn").show();
		}
	}

	function hideButtonUploadImage() {
		if( $( "button.upload-btn").is(":visible") ) {
			$( "button.upload-btn").hide();
		}
	}

	function clearCheckedRadio() {
		$( ".gambar-utama-product" ).prop( "checked", 0 );
		for( var i=0; i < arrImgList.length; i++ ){
			arrImgList[ i ].utama = 0;
		}
	}

	function ImgList( post_id, url, fname, alter) {
		this.post_id = post_id;
		this.url = url;
		this.utama = 0;
		this.fname = fname;
		this.alter = alter;
	}
	// END UPLOAD PICTURES

	function setDefaultGambarUtama() {
		var numUtama = 0;
		for( var i=0; i < arrImgList.length; i++ ){
			numUtama += arrImgList[ i ].utama ;
		}
		if (numUtama == 0) {
			arrImgList[ 0 ].utama = 1;
			$( "#gbr-radio0").prop( "checked", arrImgList[ 0 ].utama );
		}
	}

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
		/*if( arrGambar.length < 1 ){
			not_empty = false;
		}*/
		if( arrImgList.length == 0 ) {
			not_empty = false;
		}

		if( not_empty ) {
			var data = {
				action: "UpdateProduct",
				product: <?php _e( $product->GetID() ) ?>,
				nama: iNama.val(),
				deskripsi: iDes.val(),
				infolain: iInfo.val(),
			};
			data.kategori = iKatId.val();
			if ( iKatId.val() == 0 ) {
				data.kategori = iKatTxt.val();
			}
			data.kreator = iCreId.val();
			/*data.gambararr = arrGambar;*/
			setDefaultGambarUtama();
			data.gambararr = arrImgList;
			$.post(
				sltg_ajax.ajaxurl,
				data,
				function( response ) {
					var result = jQuery.parseJSON( response );
					if( result.status ) {
						$( "div.form-message").html( "<p class='text-success'>Success!</p>");
						//reset_form_product();
						location.href = "<?php echo admin_url('admin.php?page=sltg-product&doaction=edit&product='); ?><?php _e($product->GetID()); ?>&status=success";
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

		/*arrGambar.length = 0;*/
		arrImgList.length = 0;
		//n_upload = 0;

		// $( "#list-tambah-gambar" ).html( "" );
		showButtonUploadImage();
		clearImageForm();
	}

	function reloadKategori() {

	}
	
});
</script>