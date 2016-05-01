<?php 
	$hotel = $attributes[ 'hotel' ];

	if( isset( $_POST[ 'submit-delete-hotel' ] ) ) {
		$result = $hotel->Delete();
		$message = "ERROR";
		if( $result[ 'status' ] )
			_e( "SUCCESS" );
	}
	else {

?>
<div class="form-delete-area">
	<form id="form-delete-hotel" method="post">
		<label>Yakin hapus <?php _e( $hotel->GetNama() ) ?>?</label>
		<input type="hidden" value="<?php _e( $hotel->GetId() ); ?>" name="id-hotel" id="id-hotel">
		<button class="btn btn-danger" type="submit" id="btn-delete-hotel" name="submit-delete-hotel">YES</button>
	</form>
</div>
<?php } ?>