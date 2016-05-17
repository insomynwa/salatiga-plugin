<?php 
	$touristsite = $attributes[ 'touristsite' ]; 
?>
<h3>Edit Tourist Site</h3>
<div class="data-wrapper">
	<form class="form-horizontal" id="form-touristsite">
		<?php if( isset( $attributes[ 'message' ] ) ) { ?><div class="form-group"><div class="col-sm-offset-2  col-sm-4 form-message"><p class="text-success"><?php _e( $attributes[ 'message' ] ); ?></p></div></div><?php } ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="nama-touristsite">Name <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="nama-touristsite" class="form-control" id="nama-touristsite" placeholder="nama" required="required" value="<?php _e( $touristsite->GetNama() ) ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="alamat-touristsite">Address <strong>*</strong></label>
			<div class="col-sm-4">
				<textarea name="alamat-touristsite" class="form-control" id="alamat-touristsite"><?php _e( $touristsite->GetAlamat() ) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="deskripsi-touristsite">Description</label>
			<div class="col-sm-4">
				<textarea name="deskripsi-touristsite" class="form-control" id="deskripsi-touristsite"><?php _e( $touristsite->GetDeskripsi() ) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="info-lain-touristsite">Other</label>
			<div class="col-sm-4">
				<textarea name="info-lain-touristsite" class="form-control" id="info-lain-touristsite"><?php _e( $touristsite->GetOther() ) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="telp-touristsite">Telp</label>
			<div class="col-sm-4">
				<input type="number" value="<?php _e( $touristsite->GetTelp() ); ?>" name="telp-touristsite" class="form-control" id="telp-touristsite" placeholder="telp">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="latitude-touristsite">Latitude</label>
			<div class="col-sm-4">
				<input type="text" value="<?php _e( $touristsite->GetLatitude() ); ?>" name="latitude-touristsite" class="form-control" id="latitude-touristsite" pattern="-?[0-9]{1,2}[\.][0-9]{1,6}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="longitude-touristsite">Longitude</label>
			<div class="col-sm-4">
				<input type="text" value="<?php _e( $touristsite->GetLongitude() ); ?>" name="longitude-touristsite" class="form-control" id="longitude-touristsite"  pattern="-?[0-9]{1,3}[\.][0-9]{1,6}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="kategori-touristsite">Category <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="kategori-touristsite" class="form-control" id="kategori-touristsite" placeholder="kategori" required="required" value="<?php _e( $touristsite->GetKategori()->GetNama() ) ?>">
				<input type="hidden" name="kategori-touristsite-id" id="kategori-touristsite-id" value="<?php _e( $touristsite->GetKategori()->GetID() ) ?>">
			</div>
			<div class="col-sm-2">
				<button id="btn-refresh-kategori" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-refresh"></span></button>
				<button id="btn-open-modal-kategori" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-kategori"><span class="glyphicon glyphicon-list"></span></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="creator-touristsite">Picture(s) <strong>*</strong></label>
			<div class="col-sm-2">
				<button class="btn btn-primary upload-btn" id="1">Add Picture</button>
			</div>
		</div>
		<?php for( $i = 0; $i < 5; $i++ ): ?>
		<?php $gbr = $touristsite->GetGambars()[ $i ]; ?>
		<?php
			if( !is_null( $gbr ) ) {
				$linkGbr = $gbr->GetLinkGambar();
				$arrLinkGambar = explode( "/", $linkGbr ); 
			}
		?>
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-1">
				<img id="gbr-view<?php _e($i); ?>" src="<?php if( !is_null($gbr ) ) _e( $gbr->GetLinkGambar() ) ?>" alt="" class="gambar-view-touristsite" height="50">
			</div>
			<div class="col-sm-3">
				<input id="gbr-fname<?php _e($i); ?>" type="text" name="gambar-url-touristsite[]" class="form-control gambar-url-touristsite" readonly="readonly" value="<?php if( !is_null($gbr ) ) _e( end($arrLinkGambar) ); ?>">
				<input id="gbr-id<?php _e($i); ?>" type="hidden" name="gambar-id-touristsite[]" value="<?php if( !is_null( $gbr ) ) _e( $gbr->GetPostId() ) ; ?>" class="gambar-id-touristsite">
			</div>
			<div class="col-sm-1">
				<button id="rem-gbr<?php _e($i); ?>" class="btn btn-primary remove-gambar-touristsite" type="button"><span class="glyphicon glyphicon-remove"></span></button>
			</div>
			<div class="col-sm-2">
				<input id="gbr-radio<?php _e($i); ?>" class='gambar-utama-touristsite' type='radio' name='gambar-utama-touristsite' value='<?php if( !is_null( $gbr ) ) _e( $gbr->GetGambarUtama() ) ; ?>' <?php if( !is_null( $gbr ) && $gbr->GetGambarUtama()==1 ) _e( 'checked="checked"' ) ; ?>> gambar utama
			</div>
		</div>
		<?php endfor; ?>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-4">
				<button class="form-control btn btn-success" type="submit" name="submit-touristsite" id="submit-touristsite"><span class="glyphicon glyphicon-save"></span> Save</button>
			</div>	
		</div>
	</form>
</div>
<div class="plugin-content-link">
	<a href="?page=sltg-touristsite&doaction=create-new">
		<button id="add-touristsite" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus"></span> Add
		</button>
	</a>
	<a href="?page=sltg-touristsite&doaction=delete&touristsite=<?php _e( $touristsite->GetID() ) ?>">
		<button id="delete-touristsite" class="btn btn-danger">
			<span class="glyphicon glyphicon-trash"></span> Delete
		</button>
	</a>
	| Go to <a href="<?php echo admin_url( 'admin.php?page=sltg-touristsite' ); ?>">Tourist Site list</a>.
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

<script type="text/javascript">
jQuery(document).ready( function($) {

	$( ".list-kategori" ).click( function(){
		$( "#kategori-touristsite-id" ).val( (this).id );
		$( "#kategori-touristsite" ).val( (this).text );//alert( (this).text );
		$( "#kategori-touristsite" ).prop( "readonly", true );
		$( "#modal-kategori" ).modal( "hide" );
	});
	$( "#btn-refresh-kategori").click( function(){
		$( "#kategori-touristsite" ).prop( "readonly", false );
		$( "#kategori-touristsite" ).val( "" );
		$( "#kategori-touristsite" ).focus();
		$( "#kategori-touristsite-id" ).val( 0 );
	});

	// UPLOAD PICTURES
	/*var arrGambar = [];*/
	var arrImgList = [];
	var initIdx = 0, initUrl = "", initPostId = 0, initFname = "", initAlter = "";
	var initImg;
	<?php foreach( $touristsite->GetGambars() as $gbr ): ?>
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

	$( ".remove-gambar-touristsite" ).click( function() {
		var idBtn = ((this).id).split('rem-gbr').pop();

		if( $( "#gbr-fname" + idBtn).val() != "" ) {
			arrImgList.splice( idBtn, 1);

			clearImageForm();
			loadImageToForm();
		}
	});

	$( ".gambar-utama-touristsite" ).on( "click", function(e) {
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
		$( ".gambar-url-touristsite" ).val( "" );
		$( ".gambar-id-touristsite" ).val( "" );
		$( ".gambar-view-touristsite" ).prop( "src", "" );
		$( ".gambar-view-touristsite" ).prop( "alt", "" );
		$( ".gambar-utama-touristsite" ).val( 0 );
		$( ".gambar-utama-touristsite" ).prop( "checked", 0 );
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
		$( ".gambar-utama-touristsite" ).prop( "checked", 0 );
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

	$( "#form-touristsite").submit( function(e) {
		e.preventDefault();
		
		var iNama = $( "#nama-touristsite" ),
			iKatId = $( "#kategori-touristsite-id" ),
			iKatTxt = $( "#kategori-touristsite" ),
			iAlam = $( "#alamat-touristsite"),
			iTelp = $( "#telp-touristsite"),
			iLat = $( "#latitude-touristsite"),
			iLong = $( "#longitude-touristsite" ),
			iInfo = $( "#info-lain-touristsite" ),
			iDes = $( "#deskripsi-touristsite" ),
			not_empty = true;

		if( $.trim( iNama.val() ) == '' ) {
			iNama.addClass( 'req-input input-empty');
			iNama.focus();
			not_empty = false;
		}

		if( $.trim( iAlam.val() ) == '' ) {
			iAlam.addClass( 'req-input input-empty');
			iAlam.focus();
			not_empty = false;
		}
		if( iKatId.val() == 0 && $.trim( iKatTxt.val() ) == '' )
			not_empty = false;

		if( arrImgList.length == 0 ) {
			not_empty = false;
		}

		if( not_empty ) {

			var data = {
				action: "UpdateTouristSite",
				touristsite: <?php _e( $touristsite->GetID() ) ?>,
				nama: iNama.val(),
				alamat: iAlam.val(),
				deskripsi: iDes.val(),
				infolain: iInfo.val(),
				latitude: iLat.val(),
				longitude: iLong.val(),
				telp: iTelp.val()
			};
			data.kategori = iKatId.val();
			if ( iKatId.val() == 0 ) {
				data.kategori = iKatTxt.val();
			}

			setDefaultGambarUtama();
			data.gambararr = arrImgList;
			//console.log(data);
			$.post(
				sltg_ajax.ajaxurl,
				data,
				function( response ) {
					var result = jQuery.parseJSON( response );
					if( result.status ) {
						$( "div.form-message").html( "<p class='text-success'>Success!</p>");
						//reset_form_touristsite();
						location.href = "<?php echo admin_url('admin.php?page=sltg-touristsite&doaction=edit&touristsite='); ?><?php _e($touristsite->GetID()); ?>&status=success";
					}else{
						$( "div.form-message").html( "<p class='text-danger'>" + result.message + "</p>");
					}
				}
			);
		}else{
			$( "div.form-message").html( "<p class='text-danger'>Name, Address, Category, and Picture(s) are required.</p>");
		}
	});

	function reset_form_touristsite() {
		$( "#nama-touristsite" ).val( "" );
		$( "#deskripsi-touristsite" ).val( "" );
		$( "#info-lain-touristsite" ).val( "" );
		$( "#kategori-touristsite-id" ).val( 0 );
		$( "#kategori-touristsite" ).val( "" );

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