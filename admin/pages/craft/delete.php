<?php 
	$craft = $attributes[ 'craft' ];

	if( isset( $_POST[ 'submit-delete-craft' ] ) ) {
		$result = $craft->Delete();
		$message = "ERROR";
		if( $result[ 'status' ] )
			_e( "SUCCESS" );
	}
	else {

?>
<div class="form-delete-area">
	<form id="form-delete-craft" method="post">
		<label>Yakin hapus <?php _e( $craft->GetNama() ) ?>?</label>
		<input type="hidden" value="<?php _e( $craft->GetID() ); ?>" name="id-craft" id="id-craft">
		<button class="btn btn-danger" type="submit" id="btn-delete-craft" name="submit-delete-craft">YES</button>
	</form>
</div>
<?php } ?>