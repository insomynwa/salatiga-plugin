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
<h3>Create New Founder</h3>
<div class="data-wrapper">
	<form class="form-horizontal" id="form-person">
		<?php if( isset( $attributes[ 'message' ] ) ) { ?><div class="form-group"><div class="col-sm-offset-2  col-sm-4 form-message"><p class="text-success"><?php _e( $attributes[ 'message' ] ); ?></p></div></div><?php } ?>
		<div class="form-group">
			<label class="col-sm-offset-2  col-sm-4 control-label form-message" for="message-person"></label>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="nama-person">Name <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="nama-person" class="form-control" id="nama-person" placeholder="nama" required="required">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="address-person">Address <strong>*</strong></label>
			<div class="col-sm-4">
				<textarea required='required' name="address-person" class="form-control" id="address-person"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="telp-person">Telp</label>
			<div class="col-sm-4">
				<input type="number" name="telp-person" class="form-control" id="telp-person" placeholder="telp">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="deskripsi-person">Description</label>
			<div class="col-sm-4">
				<textarea name="deskripsi-person" class="form-control" id="deskripsi-person"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="info-lain-person">Other</label>
			<div class="col-sm-4">
				<textarea name="info-lain-person" class="form-control" id="info-lain-person"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="founder-person">Picture(s) <strong>*</strong></label>
			<div class="col-sm-2">
				<button class="btn btn-primary upload-btn" id="1">Add Picture</button>
			</div>
		</div>
		<?php for( $i = 0; $i < 5; $i++ ): ?>
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-1">
				<img id="gbr-view<?php _e($i); ?>" src="" alt="" class="gambar-view-person" height="50">
			</div>
			<div class="col-sm-3">
				<input id="gbr-fname<?php _e($i); ?>" type="text" name="gambar-url-person[]" class="form-control gambar-url-person" readonly="readonly" >
				<input id="gbr-id<?php _e($i); ?>" type="hidden" name="gambar-id-person[]" value="0" class="gambar-id-person">
			</div>
			<div class="col-sm-1">
				<button id="rem-gbr<?php _e($i); ?>" class="btn btn-primary remove-gambar-person" type="button"><span class="glyphicon glyphicon-remove"></span></button>
			</div>
			<div class="col-sm-2">
				<input id="gbr-radio<?php _e($i); ?>" class='gambar-utama-person' type='radio' name='gambar-utama-person' value='0'> gambar utama
			</div>
		</div>
		<?php endfor; ?>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-4">
				<button class="form-control btn btn-success" type="submit" name="submit-person" id="submit-person"><span class="glyphicon glyphicon-save"></span> Save</button>
			</div>	
		</div>
	</form>
</div>
<div class="plugin-content-link">
	<!-- <button id="add-person" class="btn btn-primary" data-toggle="modal" data-target="#modal-form-person">
		<span class="glyphicon glyphicon-plus"></span> Add
	</button> -->
</div>

<script type="text/javascript">
jQuery(document).ready( function($) {

	// UPLOAD PICTURES
	/*var arrGambar = [];*/
	var arrImgList = [];
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

	$( ".remove-gambar-person" ).click( function() {
		var idBtn = ((this).id).split('rem-gbr').pop();

		if( $( "#gbr-fname" + idBtn).val() != "" ) {
			arrImgList.splice( idBtn, 1);

			clearImageForm();
			loadImageToForm();
		}
	});

	$( ".gambar-utama-person" ).on( "click", function(e) {
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
		$( ".gambar-url-person" ).val( "" );
		$( ".gambar-id-person" ).val( "" );
		$( ".gambar-view-person" ).prop( "src", "" );
		$( ".gambar-view-person" ).prop( "alt", "" );
		$( ".gambar-utama-person" ).val( 0 );
		$( ".gambar-utama-person" ).prop( "checked", 0 );
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
		$( ".gambar-utama-person" ).prop( "checked", 0 );
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

	$( "#form-person").submit( function(e) {
		e.preventDefault();
		
		var iNama = $( "#nama-person" ),
			iAddr = $( "#address-person" ),
			iTelp = $( "#telp-person" ),
			iInfo = $( "#info-lain-person" ),
			iDes = $( "#deskripsi-person" ),
			not_empty = true;

		if( $.trim( iNama.val() ) == '' ) {
			iNama.addClass( 'req-input input-empty');
			iNama.focus();
			not_empty = false;
		}
		/*if( arrGambar.length < 1 ){
			not_empty = false;
		}*/
		if( $.trim( iAddr.val() ) == '' ) {
			not_empty = false;
		}

		if( arrImgList.length == 0 ) {
			not_empty = false;
		}

		console.log(not_empty);

		if( not_empty ) {
			var data = {
				action: "CreateNewPerson",
				nama: iNama.val(),
				alamat: iAddr.val(),
				telp: iTelp.val(),
				deskripsi: iDes.val(),
				infolain: iInfo.val(),
			};

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
						//reset_form_person();
						location.href = "<?php echo admin_url('admin.php?page=sltg-personal&doaction=create-new&status=success'); ?>";
					}else{
						$( "div.form-message").html( "<p class='text-danger'>" + result.message + "</p>");
					}
				}
			);
		}else{
			$( "label.form-message").html( "<p class='text-danger'>Name, Address, and Picture(s) are required.</p>");
		}
	});

	function reset_form_person() {
		$( "#nama-person" ).val( "" );
		$( "#deskripsi-person" ).val( "" );
		$( "#address-person" ).val( "" );
		$( "#telp-person" ).val( "" );
		$( "#info-lain-person" ).val( "" );

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