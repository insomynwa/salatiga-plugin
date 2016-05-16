<?php 
	$katcraft = $attributes[ 'katcraft' ];

	if( isset( $_POST[ 'submit-delete-katcraft' ] ) ) {
		$result = $katcraft->Delete();
		$message = "ERROR";
		if( $result[ 'status' ] )
			_e( "SUCCESS" );
	}
	else {

?>
<div class="form-delete-area">
	<form id="form-delete-katcraft" method="post">
		<label>Yakin hapus <?php _e( $katcraft->GetNama() ) ?>?</label>
		<input type="hidden" value="<?php _e( $katcraft->GetId() ); ?>" name="id-katcraft" id="id-katcraft">
		<button class="btn btn-danger" type="submit" id="btn-delete-katcraft" name="submit-delete-katcraft">YES</button>
	</form>
</div>
<?php } ?>