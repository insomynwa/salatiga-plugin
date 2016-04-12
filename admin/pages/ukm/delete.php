<?php 
	$ukm = $attributes[ 'ukm' ];

	if( isset( $_POST[ 'submit-delete-ukm' ] ) ) {
		$result = $ukm->Delete();
		$message = "ERROR";
		if( $result[ 'status' ] )
			_e( "SUCCESS" );
	}
	else {

?>
<div class="form-delete-area">
	<form id="form-delete-ukm" method="post">
		<label>Yakin hapus <?php _e( $ukm->GetNama() ) ?>?</label>
		<input type="hidden" value="<?php _e( $ukm->GetId() ); ?>" name="id-ukm" id="id-ukm">
		<button class="btn btn-danger" type="submit" id="btn-delete-ukm" name="submit-delete-ukm">YES</button>
	</form>
</div>
<?php } ?>