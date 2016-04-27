<?php
	$genre = $attributes[ 'genre' ];
	if( isset( $_POST[ 'submit-genre' ] ) ) {
		$get_post_nama = sanitize_text_field( $_POST[ 'nama-genre' ] );
		if( $get_post_nama!="" && $get_post_nama!=$genre->GetNama() ) {
			$genre->SetNama( $get_post_nama );
			$result = $genre->Update();
			
			$message = "ERROR";
			if( $result[ 'status' ] )
				$message = $result[ 'message' ];
		}
	}
?>

<h3>Edit Music Genre</h3>
<div class="data-wrapper">
	<form class="form-horizontal" id="form-genre" method="post" action="#">
		<?php if( isset( $message ) ) { ?><div class="form-group"><div class="col-sm-offset-2  col-sm-4 form-message"><p class="text-success"><?php _e( $message ); ?></p></div></div><?php } ?>
		<div class="form-group">
			<label class="col-sm-offset-2  col-sm-4 control-label form-message" for="message-genre"></label>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="nama-genre">Name <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" value="<?php _e( $genre->GetNama() ); ?>" name="nama-genre" class="form-control" id="nama-genre" placeholder="nama" required="required">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-4">
				<button class="form-control btn btn-success" type="submit" name="submit-genre" id="submit-genre"><span class="glyphicon glyphicon-save"></span> Save</button>
			</div>	
		</div>
	</form>
</div>
<div class="plugin-content-link">
</div>