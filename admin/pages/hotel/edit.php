<style type="text/css">
input[type=number] {
    -moz-appearance:textfield;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
<?php 
	$hotel = $attributes[ 'hotel' ]; 
?>
<h3>Edit Hotel</h3>
<div class="data-wrapper">
	<form class="form-horizontal" id="form-hotel">
		<?php if( isset( $attributes[ 'message' ] ) ) { ?><div class="form-group"><div class="col-sm-offset-2  col-sm-4 form-message"><p class="text-success"><?php _e( $attributes[ 'message' ] ); ?></p></div></div><?php } ?>
		<div class="form-group">
			<label class="col-sm-offset-2  col-sm-4 control-label form-message" for="message-hotel"></label>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="nama-hotel">Name <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="nama-hotel" class="form-control" id="nama-hotel" placeholder="nama" required="required" value="<?php _e( $hotel->GetNama() ) ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="address-hotel">Address <strong>*</strong></label>
			<div class="col-sm-4">
				<textarea required='required' name="address-hotel" class="form-control" id="address-hotel"><?php _e( $hotel->GetAlamat() ) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="telp-hotel">Telp</label>
			<div class="col-sm-4">
				<input type="number" name="telp-hotel" class="form-control" id="telp-hotel" placeholder="telp" value="<?php _e( $hotel->GetTelp() ) ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="deskripsi-hotel">Description</label>
			<div class="col-sm-4">
				<textarea name="deskripsi-hotel" class="form-control" id="deskripsi-hotel"><?php _e( $hotel->GetDeskripsi() ) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="info-lain-hotel">Other</label>
			<div class="col-sm-4">
				<textarea name="info-lain-hotel" class="form-control" id="info-lain-hotel"><?php _e( $hotel->GetOther() ) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="founder-hotel">Picture(s) <strong>*</strong></label>
			<div class="col-sm-2">
				<button class="btn btn-primary upload-btn" id="1">Add Picture</button>
			</div>
		</div>
		<?php for( $i = 0; $i < 5; $i++ ): ?>
		<?php $gbr = $hotel->GetGambars()[ $i ];//var_dump($gbr); ?>
		<?php
			if( !is_null( $gbr ) ) {
				$linkGbr = $gbr->GetLinkGambar();//var_dump(sizeof($gbr));
				$arrLinkGambar = explode( "/", $linkGbr ); 
			}
		?>
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-1">
				<img id="gbr-view<?php _e($i); ?>" src="<?php if( !is_null($gbr ) ) _e( $gbr->GetLinkGambar() ) ?>" alt="" class="gambar-view-hotel" height="50">
			</div>
			<div class="col-sm-3">
				<input id="gbr-fname<?php _e($i); ?>" type="text" name="gambar-url-hotel[]" class="form-control gambar-url-hotel" readonly="readonly" value="<?php if( !is_null($gbr ) ) _e( end($arrLinkGambar) ); ?>" >
				<input id="gbr-id<?php _e($i); ?>" type="hidden" name="gambar-id-hotel[]" value="<?php if( !is_null( $gbr ) ) _e( $gbr->GetPostId() ) ; ?>" class="gambar-id-hotel">
			</div>
			<div class="col-sm-1">
				<button id="rem-gbr<?php _e($i); ?>" class="btn btn-primary remove-gambar-hotel" type="button"><span class="glyphicon glyphicon-remove"></span></button>
			</div>
			<div class="col-sm-2">
				<input id="gbr-radio<?php _e($i); ?>" class='gambar-utama-hotel' type='radio' name='gambar-utama-hotel' value='<?php if( !is_null( $gbr ) ) _e( $gbr->GetGambarUtama() ) ; ?>' <?php if( !is_null( $gbr ) && $gbr->GetGambarUtama()==1 ) _e( 'checked="checked"' ) ; ?>> gambar utama
			</div>
		</div>
		<?php endfor; ?>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-4">
				<button class="form-control btn btn-success" type="submit" name="submit-hotel" id="submit-hotel"><span class="glyphicon glyphicon-save"></span> Save</button>
			</div>	
		</div>
	</form>
</div>
<div class="plugin-content-link">

</div>

<script type="text/javascript">
jQuery(document).ready( function($) {

	// UPLOAD PICTURES
	/*var arrGambar = [];*/
	var arrImgList = [];
	var initIdx = 0, initUrl = "", initPostId = 0, initFname = "", initAlter = "";
	var initImg;
	<?php foreach( $hotel->GetGambars() as $gbr ): ?>
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
            	var alter = attJSON.title;

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

	$( ".remove-gambar-hotel" ).click( function() {
		var idBtn = ((this).id).split('rem-gbr').pop();

		if( $( "#gbr-fname" + idBtn).val() != "" ) {
			arrImgList.splice( idBtn, 1);

			clearImageForm();
			loadImageToForm();
		}
	});

	$( ".gambar-utama-hotel" ).on( "click", function(e) {
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
		$( ".gambar-url-hotel" ).val( "" );
		$( ".gambar-id-hotel" ).val( "" );
		$( ".gambar-view-hotel" ).prop( "src", "" );
		$( ".gambar-view-hotel" ).prop( "alt", "" );
		$( ".gambar-utama-hotel" ).val( 0 );
		$( ".gambar-utama-hotel" ).prop( "checked", 0 );
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
		$( ".gambar-utama-hotel" ).prop( "checked", 0 );
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

	$( "#form-hotel").submit( function(e) {
		e.preventDefault();
		
		var iNama = $( "#nama-hotel" ),
			iAddr = $( "#address-hotel" ),
			iTelp = $( "#telp-hotel" ),
			iInfo = $( "#info-lain-hotel" ),
			iDes = $( "#deskripsi-hotel" ),
			not_empty = true;

		if( $.trim( iNama.val() ) == '' ) {
			iNama.addClass( 'req-input input-empty');
			iNama.focus();
			not_empty = false;
		}

		if( $.trim( iAddr.val() ) == '' ) {
			not_empty = false;
		}

		if( arrImgList.length == 0 ) {
			not_empty = false;
		}

		if( not_empty ) {
			var data = {
				action: "UpdateHotel",
				hotel: <?php _e( $hotel->GetID() ) ?>,
				nama: iNama.val(),
				alamat: iAddr.val(),
				telp: iTelp.val(),
				deskripsi: iDes.val(),
				infolain: iInfo.val(),
			};

			setDefaultGambarUtama();
			data.gambararr = arrImgList;
			$.post(
				sltg_ajax.ajaxurl,
				data,
				function( response ) {
					var result = jQuery.parseJSON( response );
					if( result.status ) {
						$( "div.form-message").html( "<p class='text-success'>Success!</p>");
						//reset_form_hotel();
						location.href = "<?php echo admin_url('admin.php?page=sltg-hotel&doaction=edit&hotel='); ?><?php _e($hotel->GetID()); ?>&status=success";
					}else{
						$( "div.form-message").html( "<p class='text-danger'>" + result.message + "</p>");
					}
				}
			);
		}else{
			$( "label.form-message").html( "<p class='text-danger'>Name, Address, Founder, and Picture(s) are required.</p>");
		}
	});

	function reset_form_hotel() {
		$( "#nama-hotel" ).val( "" );
		$( "#deskripsi-hotel" ).val( "" );
		$( "#address-hotel" ).val( "" );
		$( "#telp-hotel" ).val( "" );
		$( "#info-lain-hotel" ).val( "" );

		/*arrGambar.length = 0;*/
		arrImgList.length = 0;
		//n_upload = 0;

		// $( "#list-tambah-gambar" ).html( "" );
		showButtonUploadImage();
		clearImageForm();
	}
	
});
</script>