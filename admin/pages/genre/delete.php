<?php 
	$genre = $attributes[ 'genre' ];

	if( isset( $_POST[ 'submit-delete-genre' ] ) ) {
		$result = $genre->Delete();
		$message = "ERROR";
		if( $result[ 'status' ] )
			_e( "SUCCESS" );
	}
	else {

?>
<div class="form-delete-area">
	<form id="form-delete-genre" method="post">
		<label>Yakin hapus <?php _e( $genre->GetNama() ) ?>?</label>
		<input type="hidden" value="<?php _e( $genre->GetId() ); ?>" name="id-genre" id="id-genre">
		<button class="btn btn-danger" type="submit" id="btn-delete-genre" name="submit-delete-genre">YES</button>
	</form>
</div>
<?php } ?>