<?php 
	$jeniskamar = $attributes[ 'jeniskamar' ]; 
?>
<h3>Edit Kamar</h3>
<div class="data-wrapper">
	<form class="form-horizontal" id="form-jeniskamar">
		<?php if( isset( $attributes[ 'message' ] ) ) { ?><div class="form-group"><div class="col-sm-offset-2  col-sm-4 form-message"><p class="text-success"><?php _e( $attributes[ 'message' ] ); ?></p></div></div><?php } ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="nama-jeniskamar">Name <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="nama-jeniskamar" class="form-control" id="nama-jeniskamar" placeholder="nama" required="required" value="<?php _e( $jeniskamar->GetNama() ) ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="deskripsi-jeniskamar">Description</label>
			<div class="col-sm-4">
				<textarea name="deskripsi-jeniskamar" class="form-control" id="deskripsi-jeniskamar"><?php _e( $jeniskamar->GetDeskripsi() ) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="hotel-jeniskamar">Hotel <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="hotel-jeniskamar" class="form-control" id="hotel-jeniskamar" placeholder="nama hotel (Soekarno) " required="required" readonly value="<?php _e( $jeniskamar->GetHotel()->GetNama() ) ?>">
				<input type="hidden" name="hotel-jeniskamar-id" id="hotel-jeniskamar-id" value="<?php _e( $jeniskamar->GetHotel()->GetID() ) ?>">
			</div>
			<div class="col-sm-2">
				<button id="btn-refresh-hotel" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-refresh"></span></button>
				<button id="btn-open-modal-hotel" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-hotel"><span class="glyphicon glyphicon-user"></span></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="hotel-jeniskamar">Picture(s) <strong>*</strong></label>
			<div class="col-sm-2">
				<button class="btn btn-primary upload-btn" id="1">Add Picture</button>
			</div>
		</div>
		<?php for( $i = 0; $i < 5; $i++ ): ?>
		<?php $gbr = $jeniskamar->GetGambars()[ $i ]; ?>
		<?php
			if( !is_null( $gbr ) ) {
				$linkGbr = $gbr->GetLinkGambar();
				$arrLinkGambar = explode( "/", $linkGbr ); 
			}
		?>
		<div class="form-group">
			<div class="col-sm-offset-1 col-sm-1">
				<img id="gbr-view<?php _e($i); ?>" src="<?php if( !is_null($gbr ) ) _e( $gbr->GetLinkGambar() ) ?>" alt="" class="gambar-view-jeniskamar" height="50">
			</div>
			<div class="col-sm-3">
				<input id="gbr-fname<?php _e($i); ?>" type="text" name="gambar-url-jeniskamar[]" class="form-control gambar-url-jeniskamar" readonly="readonly" value="<?php if( !is_null($gbr ) ) _e( end($arrLinkGambar) ); ?>">
				<input id="gbr-id<?php _e($i); ?>" type="hidden" name="gambar-id-jeniskamar[]" value="<?php if( !is_null( $gbr ) ) _e( $gbr->GetPostId() ) ; ?>" class="gambar-id-jeniskamar">
			</div>
			<div class="col-sm-1">
				<button id="rem-gbr<?php _e($i); ?>" class="btn btn-primary remove-gambar-jeniskamar" type="button"><span class="glyphicon glyphicon-remove"></span></button>
			</div>
			<div class="col-sm-2">
				<input id="gbr-radio<?php _e($i); ?>" class='gambar-utama-jeniskamar' type='radio' name='gambar-utama-jeniskamar' value='<?php if( !is_null( $gbr ) ) _e( $gbr->GetGambarUtama() ) ; ?>' <?php if( !is_null( $gbr ) && $gbr->GetGambarUtama()==1 ) _e( 'checked="checked"' ) ; ?>> gambar utama
			</div>
		</div>
		<?php endfor; ?>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-4">
				<button class="form-control btn btn-success" type="submit" name="submit-jeniskamar" id="submit-jeniskamar"><span class="glyphicon glyphicon-save"></span> Save</button>
			</div>	
		</div>
	</form>
</div>
<div class="plugin-content-link">
	Go to <a href="<?php echo admin_url( 'admin.php?page=sltg-jeniskamar' ); ?>">Kamar list</a>.
	<!-- <button id="add-jeniskamar" class="btn btn-primary" data-toggle="modal" data-target="#modal-form-jeniskamar">
		<span class="glyphicon glyphicon-plus"></span> Add
	</button> -->
</div>
<div id="modal-hotel" class="modal fade" role="dialog" aria-labelledby="hotelModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-primary">Producer (UKM)</h4>
			</div>
			<div class="modal-body">
				<div class="list-group">
					<?php if( sizeof( $attributes[ 'hotel' ] ) > 0 ): ?>
						<?php foreach( $attributes[ 'hotel' ] as $hotel ): ?>
							<a href="#" class="list-hotel list-group-item" id="<?php _e( $hotel->GetID() ); ?>"><?php _e( $hotel->GetNama() ); ?></a>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<!-- <a href="?page=sltg-jeniskamar&doaction=create-new"> -->
				<a href="?page=sltg-hotel&doaction=create-new">
					<button id="add-hotel" class="btn btn-primary">
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
	$( ".list-hotel" ).click( function(){
		$( "#hotel-jeniskamar-id" ).val( (this).id );
		$( "#hotel-jeniskamar" ).val( (this).text );
		$( "#hotel-jeniskamar" ).prop( "readonly", true );
		$( "#modal-hotel" ).modal( "hide" );
	});
	$( "#btn-refresh-hotel").click( function(){
		//$( "#hotel-jeniskamar" ).prop( "readonly", false );
		$( "#hotel-jeniskamar" ).val( "" );
		$( "#hotel-jeniskamar" ).focus();
		$( "#hotel-jeniskamar-id" ).val( 0 );
	});

	// UPLOAD PICTURES
	/*var arrGambar = [];*/
	var arrImgList = [];
	var initIdx = 0, initUrl = "", initPostId = 0, initFname = "", initAlter = "";
	var initImg;
	<?php foreach( $jeniskamar->GetGambars() as $gbr ): ?>
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

	$( ".remove-gambar-jeniskamar" ).click( function() {
		var idBtn = ((this).id).split('rem-gbr').pop();

		if( $( "#gbr-fname" + idBtn).val() != "" ) {
			arrImgList.splice( idBtn, 1);

			clearImageForm();
			loadImageToForm();
		}
	});

	$( ".gambar-utama-jeniskamar" ).on( "click", function(e) {
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
		$( ".gambar-url-jeniskamar" ).val( "" );
		$( ".gambar-id-jeniskamar" ).val( "" );
		$( ".gambar-view-jeniskamar" ).prop( "src", "" );
		$( ".gambar-view-jeniskamar" ).prop( "alt", "" );
		$( ".gambar-utama-jeniskamar" ).val( 0 );
		$( ".gambar-utama-jeniskamar" ).prop( "checked", 0 );
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
		$( ".gambar-utama-jeniskamar" ).prop( "checked", 0 );
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

	$( "#form-jeniskamar").submit( function(e) {
		e.preventDefault();
		
		var iNama = $( "#nama-jeniskamar" ),
			iHotId = $( "#hotel-jeniskamar-id" ),
			iHotTxt = $( "#hotel-jeniskamar" ),
			iDes = $( "#deskripsi-jeniskamar" ),
			not_empty = true;

		if( $.trim( iNama.val() ) == '' ) {
			iNama.addClass( 'req-input input-empty');
			iNama.focus();
			not_empty = false;
		}

		if( iHotId.val() == 0 && $.trim( iHotTxt.val() ) == '' )
			not_empty = false;
		/*if( arrGambar.length < 1 ){
			not_empty = false;
		}*/
		if( arrImgList.length == 0 ) {
			not_empty = false;
		}

		if( not_empty ) {
			var data = {
				action: "UpdateKamar",
				jeniskamar: <?php _e( $jeniskamar->GetID() ) ?>,
				nama: iNama.val(),
				deskripsi: iDes.val()
			};

			data.hotel = iHotId.val();
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
						//reset_form_jeniskamar();
						location.href = "<?php echo admin_url('admin.php?page=sltg-jeniskamar&doaction=edit&jeniskamar='); ?><?php _e($jeniskamar->GetID()); ?>&status=success";
					}else{
						$( "div.form-message").html( "<p class='text-danger'>" + result.message + "</p>");
					}
				}
			);
		}else{
			$( "div.form-message").html( "<p class='text-danger'>Name, Category, Creator, and Picture(s) are required.</p>");
		}
	});

	function reset_form_jeniskamar() {
		$( "#nama-jeniskamar" ).val( "" );
		$( "#deskripsi-jeniskamar" ).val( "" );
		$( "#hotel-jeniskamar-id" ).val( 0 );
		$( "#hotel-jeniskamar" ).val( "" );

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