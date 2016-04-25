<?php 
	$music = $attributes[ 'music' ];
?>
<h3>Edit Music</h3>
<div class="data-wrapper">
	<form class="form-horizontal" id="form-music">
		<?php if( isset( $attributes[ 'message' ] ) ) { ?><div class="form-group"><div class="col-sm-offset-2  col-sm-4 form-message"><p class="text-success"><?php _e( $attributes[ 'message' ] ); ?></p></div></div><?php } ?>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="title-music">Title <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" value="<?php _e( str_replace("\'", "'", $music->GetTitle() ) ) ?>" name="title-music" class="form-control" id="title-music" placeholder="title" required="required">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="source-music">Source <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" value="<?php _e($music->GetSource()) ?>" name="source-music" class="form-control" id="source-music" placeholder="(soundcloud)" required="required">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="deskripsi-music">Description</label>
			<div class="col-sm-4">
				<textarea name="deskripsi-music" class="form-control" id="deskripsi-music"><?php _e($music->GetInfo()) ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="genre-music">Genre <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" value="<?php _e($music->GetGenre()->GetNama()) ?>" name="genre-music" class="form-control" id="genre-music" placeholder="genre" required="required">
				<input type="hidden" name="genre-music-id" id="genre-music-id" value="<?php _e($music->GetGenre()->GetId()) ?>">
			</div>
			<div class="col-sm-2">
				<button id="btn-refresh-genre" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-refresh"></span></button>
				<button id="btn-open-modal-genre" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-genre"><span class="glyphicon glyphicon-list"></span></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="creator-music">Creator <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" value="<?php _e($music->GetCreator()->GetNama()) ?>" name="creator-music" class="form-control" id="creator-music" placeholder="creator (Soekarno) " required="required" readonly>
				<input type="hidden" name="creator-music-id" id="creator-music-id" value="<?php _e($music->GetCreator()->GetID()) ?>">
			</div>
			<div class="col-sm-2">
				<button id="btn-refresh-creator" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-refresh"></span></button>
				<button id="btn-open-modal-creator" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-creator"><span class="glyphicon glyphicon-user"></span></button>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-4">
				<button class="form-control btn btn-success" type="submit" name="submit-music" id="submit-music"><span class="glyphicon glyphicon-save"></span> Save</button>
			</div>	
		</div>
	</form>
</div>
<div class="plugin-content-link">
</div>
<div id="modal-genre" class="modal fade" role="dialog" aria-labelledby="genreModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-primary">Genre</h4>
			</div>
			<div class="modal-body">
				<div id="genre-list" class="list-group">
					<?php if( sizeof( $attributes[ 'genre' ] ) > 0 ): ?>
						<?php foreach( $attributes[ 'genre' ] as $genre ): ?>
							<a href="#" class="list-genre list-group-item" id="<?php _e( $genre->GetID() ); ?>"><?php _e( $genre->GetNama() ); ?></a>
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
				<h4 class="modal-title text-primary">Creator</h4>
			</div>
			<div class="modal-body">
				<div class="list-group">
					<?php if( sizeof( $attributes[ 'person' ] ) > 0 ): ?>
						<?php foreach( $attributes[ 'person' ] as $person ): ?>
							<a href="#" class="list-creator list-group-item" id="<?php _e( $person->GetID() ); ?>"><?php _e( $person->GetNama() ); ?></a>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<a href="?page=sltg-personal&doaction=create-new">
					<button id="add-music" class="btn btn-primary">
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

	$( ".list-genre" ).click( function(){
		$( "#genre-music-id" ).val( (this).id );
		$( "#genre-music" ).val( (this).text );//alert( (this).text );
		$( "#genre-music" ).prop( "readonly", true );
		$( "#modal-genre" ).modal( "hide" );
	});
	$( ".list-creator" ).click( function(){
		$( "#creator-music-id" ).val( (this).id );
		$( "#creator-music" ).val( (this).text );
		$( "#creator-music" ).prop( "readonly", true );
		$( "#modal-creator" ).modal( "hide" );
	});
	$( "#btn-refresh-genre").click( function(){
		$( "#genre-music" ).prop( "readonly", false );
		$( "#genre-music" ).val( "" );
		$( "#genre-music" ).focus();
		$( "#genre-music-id" ).val( 0 );
	});
	$( "#btn-refresh-creator").click( function(){
		$( "#creator-music" ).val( "" );
		$( "#creator-music" ).focus();
		$( "#creator-music-id" ).val( 0 );
	});

	$( "#form-music").submit( function(e) {
		e.preventDefault();
		
		var iTitle = $( "#title-music" ),
			iSource = $( "#source-music" ),
			iGenId = $( "#genre-music-id" ),
			iGenTxt = $( "#genre-music" ),
			iCreId = $( "#creator-music-id" ),
			iCreTxt = $( "#creator-music" ),
			iDes = $( "#deskripsi-music" ),
			not_empty = true;

		if( $.trim( iTitle.val() ) == '' ) {
			iTitle.addClass( 'req-input input-empty');
			iTitle.focus();
			not_empty = false;
		}
		if( $.trim( iSource.val() ) == '' ) {
			iSource.addClass( 'req-input input-empty');
			iSource.focus();
			not_empty = false;
		}
		if( iGenId.val() == 0 && $.trim( iGenTxt.val() ) == '' )
			not_empty = false;
		if( iCreId.val() == 0 && $.trim( iCreTxt.val() ) == '' )
			not_empty = false;

		if( not_empty ) {
			var data = {
				action: "UpdateMusic",
				music: <?php _e( $music->GetId() ) ?>,
				title: iTitle.val(),
				deskripsi: iDes.val(),
				source: iSource.val(),
			};
			data.genre = iGenId.val();
			if ( iGenId.val() == 0 ) {
				data.genre = iGenTxt.val();
			}
			data.creator = iCreId.val();
			$.post(
				sltg_ajax.ajaxurl,
				data,
				function( response ) {
					var result = jQuery.parseJSON( response );
					if( result.status ) {
						$( "div.form-message").html( "<p class='text-success'>Success!</p>");
						location.href = "<?php echo admin_url('admin.php?page=sltg-music&doaction=edit&music='); ?><?php _e($music->GetId()); ?>&status=success";
					}else{
						$( "div.form-message").html( "<p class='text-danger'>" + result.message + "</p>");
					}
				}
			);
		}else{
			$( "div.form-message").html( "<p class='text-danger'>Title, Genre, Creator, and Picture(s) are required.</p>");
		}
	});

	function reset_form_music() {
		$( "#title-music" ).val( "" );
		$( "#source-music" ).val( "" );
		$( "#deskripsi-music" ).val( "" );
		$( "#genre-music-id" ).val( 0 );
		$( "#genre-music" ).val( "" );
		$( "#creator-music-id" ).val( 0 );
		$( "#creator-music" ).val( "" );
	}

	function reloadGenre() {

	}
	
});
</script>