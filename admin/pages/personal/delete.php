<?php 
	$person = $attributes[ 'person' ];

	if( isset( $_POST[ 'submit-delete-person' ] ) ) {
		$result = $person->Delete();
		$message = "ERROR";
		if( $result[ 'status' ] )
			_e( "SUCCESS" );
	}
	else {

?>
<div class="form-delete-area">
	<form id="form-delete-person" method="post">
		<label>Yakin hapus <?php _e( $person->GetNama() ) ?>?</label>
		<input type="hidden" value="<?php _e( $person->GetId() ); ?>" name="id-person" id="id-person">
		<button class="btn btn-danger" type="submit" id="btn-delete-person" name="submit-delete-person">YES</button>
	</form>
</div>
<?php } ?>