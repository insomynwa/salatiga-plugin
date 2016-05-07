<?php 
	$craft = $attributes[ 'craft' ]; 
?>
<h3>Edit Craft</h3>
<div class="data-wrapper">
	<form class="form-horizontal" id="form-craft">
		<?php if( isset( $attributes[ 'message' ] ) ) { ?><div class="form-group"><div class="col-sm-offset-2  col-sm-4 form-message"><p class="text-success"><?php _e( $attributes[ 'message' ] ); ?></p></div></div><?php } ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="nama-craft">Name <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="nama-craft" class="form-control" id="nama-craft" placeholder="nama" required="required" value="<?php _e( $craft->GetNama() ) ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="deskripsi-craft">Description</label>
			<div class="col-sm-4">
				<textarea name="deskripsi-craft" class="form-control" id="deskripsi-craft"><?php _e( $craft->GetDeskripsi() ) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="info-lain-craft">Other</label>
			<div class="col-sm-4">
				<textarea name="info-lain-craft" class="form-control" id="info-lain-craft"><?php _e( $craft->GetOther() ) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="kategori-craft">Category <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="kategori-craft" class="form-control" id="kategori-craft" placeholder="kategori" required="required" value="<?php _e( $craft->GetKategori()->GetNama() ) ?>">
				<input type="hidden" name="kategori-craft-id" id="kategori-craft-id" value="<?php _e( $craft->GetKategori()->GetID() ) ?>">
			</div>
			<div class="col-sm-2">
				<button id="btn-refresh-kategori" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-refresh"></span></button>
				<button id="btn-open-modal-kategori" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-kategori"><span class="glyphicon glyphicon-list"></span></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="creator-craft">Creator <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="creator-craft" class="form-control" id="creator-craft" placeholder="nama creator (Soekarno) " required="required" readonly value="<?php _e( $craft->GetProducer()->GetNama() ) ?>">
				<input type="hidden" name="creator-craft-id" id="creator-craft-id" value="<?php _e( $craft->GetProducer()->GetID() ) ?>">
			</div>
			<div class="col-sm-2">
				<button id="btn-refresh-creator" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-refresh"></span></button>
				<button id="btn-open-modal-creator" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-creator"><span class="glyphicon glyphicon-user"></span></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="creator-craft">Picture(s) <strong>*</strong></label>
			<div class="col-sm-2">
				<button class="btn btn-primary upload-btn" id="1">Add Picture</button>
			</div>
		</div>
		<?php for( $i = 0; $i < 5; $i++ ): ?>
		<?php $gbr = $craft->GetGambars()[ $i ]; ?>
		<?php
			if( !is_null( $gbr ) ) {
				$linkGbr = $gbr->GetLinkGambar();
				$arrLinkGambar = explode( "/", $linkGbr ); 
			}
		?>
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-1">
				<img id="gbr-view<?php _e($i); ?>" src="<?php if( !is_null($gbr ) ) _e( $gbr->GetLinkGambar() ) ?>" alt="" class="gambar-view-craft" height="50">
			</div>
			<div class="col-sm-3">
				<input id="gbr-fname<?php _e($i); ?>" type="text" name="gambar-url-craft[]" class="form-control gambar-url-craft" readonly="readonly" value="<?php if( !is_null($gbr ) ) _e( end($arrLinkGambar) ); ?>">
				<input id="gbr-id<?php _e($i); ?>" type="hidden" name="gambar-id-craft[]" value="<?php if( !is_null( $gbr ) ) _e( $gbr->GetPostId() ) ; ?>" class="gambar-id-craft">
			</div>
			<div class="col-sm-1">
				<button id="rem-gbr<?php _e($i); ?>" class="btn btn-primary remove-gambar-craft" type="button"><span class="glyphicon glyphicon-remove"></span></button>
			</div>
			<div class="col-sm-2">
				<input id="gbr-radio<?php _e($i); ?>" class='gambar-utama-craft' type='radio' name='gambar-utama-craft' value='<?php if( !is_null( $gbr ) ) _e( $gbr->GetGambarUtama() ) ; ?>' <?php if( !is_null( $gbr ) && $gbr->GetGambarUtama()==1 ) _e( 'checked="checked"' ) ; ?>> gambar utama
			</div>
		</div>
		<?php endfor; ?>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-4">
				<button class="form-control btn btn-success" type="submit" name="submit-craft" id="submit-craft"><span class="glyphicon glyphicon-save"></span> Save</button>
			</div>	
		</div>
	</form>
</div>
<div class="plugin-content-link">
	<!-- <button id="add-craft" class="btn btn-primary" data-toggle="modal" data-target="#modal-form-craft">
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
				<h4 class="modal-title text-primary">Producer (Person)</h4>
			</div>
			<div class="modal-body">
				<div class="list-group">
					<?php if( sizeof( $attributes[ 'person' ] ) > 0 ): ?>
						<?php foreach( $attributes[ 'person' ] as $person ): ?>
							<a href="#" class="list-creator list-group-item" id="<?php _e( $person->GetID() ); ?>"><?php _e( $person->GetNama() ); ?></a>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<!-- <a href="?page=sltg-craft&doaction=create-new"> -->
				<a href="?page=sltg-personal&doaction=create-new">
					<button id="add-craft" class="btn btn-primary">
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
		$( "#kategori-craft-id" ).val( (this).id );
		$( "#kategori-craft" ).val( (this).text );//alert( (this).text );
		$( "#kategori-craft" ).prop( "readonly", true );
		$( "#modal-kategori" ).modal( "hide" );
	});
	$( ".list-creator" ).click( function(){
		$( "#creator-craft-id" ).val( (this).id );
		$( "#creator-craft" ).val( (this).text );
		$( "#creator-craft" ).prop( "readonly", true );
		$( "#modal-creator" ).modal( "hide" );
	});
	$( "#btn-refresh-kategori").click( function(){
		$( "#kategori-craft" ).prop( "readonly", false );
		$( "#kategori-craft" ).val( "" );
		$( "#kategori-craft" ).focus();
		$( "#kategori-craft-id" ).val( 0 );
	});
	$( "#btn-refresh-creator").click( function(){
		//$( "#creator-craft" ).prop( "readonly", false );
		$( "#creator-craft" ).val( "" );
		$( "#creator-craft" ).focus();
		$( "#creator-craft-id" ).val( 0 );
	});

	// UPLOAD PICTURES
	/*var arrGambar = [];*/
	var arrImgList = [];
	var initIdx = 0, initUrl = "", initPostId = 0, initFname = "", initAlter = "";
	var initImg;
	<?php foreach( $craft->GetGambars() as $gbr ): ?>
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

	$( ".remove-gambar-craft" ).click( function() {
		var idBtn = ((this).id).split('rem-gbr').pop();

		if( $( "#gbr-fname" + idBtn).val() != "" ) {
			arrImgList.splice( idBtn, 1);

			clearImageForm();
			loadImageToForm();
		}
	});

	$( ".gambar-utama-craft" ).on( "click", function(e) {
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
		$( ".gambar-url-craft" ).val( "" );
		$( ".gambar-id-craft" ).val( "" );
		$( ".gambar-view-craft" ).prop( "src", "" );
		$( ".gambar-view-craft" ).prop( "alt", "" );
		$( ".gambar-utama-craft" ).val( 0 );
		$( ".gambar-utama-craft" ).prop( "checked", 0 );
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
		$( ".gambar-utama-craft" ).prop( "checked", 0 );
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

	$( "#form-craft").submit( function(e) {
		e.preventDefault();
		
		var iNama = $( "#nama-craft" ),
			iKatId = $( "#kategori-craft-id" ),
			iKatTxt = $( "#kategori-craft" ),
			iCreId = $( "#creator-craft-id" ),
			iCreTxt = $( "#creator-craft" ),
			iInfo = $( "#info-lain-craft" ),
			iDes = $( "#deskripsi-craft" ),
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
				action: "UpdateCraft",
				craft: <?php _e( $craft->GetID() ) ?>,
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
						//reset_form_craft();
						location.href = "<?php echo admin_url('admin.php?page=sltg-craft&doaction=edit&craft='); ?><?php _e($craft->GetID()); ?>&status=success";
					}else{
						$( "div.form-message").html( "<p class='text-danger'>" + result.message + "</p>");
					}
				}
			);
		}else{
			$( "div.form-message").html( "<p class='text-danger'>Name, Category, Creator, and Picture(s) are required.</p>");
		}
	});

	function reset_form_craft() {
		$( "#nama-craft" ).val( "" );
		$( "#deskripsi-craft" ).val( "" );
		$( "#info-lain-craft" ).val( "" );
		$( "#kategori-craft-id" ).val( 0 );
		$( "#kategori-craft" ).val( "" );
		$( "#creator-craft-id" ).val( 0 );
		$( "#creator-craft" ).val( "" );

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