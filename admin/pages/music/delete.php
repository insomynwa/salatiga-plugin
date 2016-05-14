<?php 
	$music = $attributes[ 'music' ];

	if( isset( $_POST[ 'submit-delete-music' ] ) ) {
		$result = $music->Delete();
		$message = "ERROR";
		if( $result[ 'status' ] )
			_e( "SUCCESS" );
	}
	else {

?>
<div class="form-delete-area">
	<form id="form-delete-music" method="post">
		<label>Yakin hapus <?php _e( str_replace("\'", "'", $music->GetTitle() ) ) ?>?</label>
		<input type="hidden" value="<?php _e( $music->GetId() ); ?>" name="id-music" id="id-music">
		<button class="btn btn-danger" type="submit" id="btn-delete-music" name="submit-delete-music">YES</button>
	</form>
</div>
<?php } ?>