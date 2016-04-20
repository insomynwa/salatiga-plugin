<?php 
	$katprodukukm = $attributes[ 'katprodukukm' ];

	if( isset( $_POST[ 'submit-delete-katprodukukm' ] ) ) {
		$result = $katprodukukm->Delete();
		$message = "ERROR";
		if( $result[ 'status' ] )
			_e( "SUCCESS" );
	}
	else {

?>
<div class="form-delete-area">
	<form id="form-delete-katprodukukm" method="post">
		<label>Yakin hapus <?php _e( $katprodukukm->GetNama() ) ?>?</label>
		<input type="hidden" value="<?php _e( $katprodukukm->GetId() ); ?>" name="id-katprodukukm" id="id-katprodukukm">
		<button class="btn btn-danger" type="submit" id="btn-delete-katprodukukm" name="submit-delete-katprodukukm">YES</button>
	</form>
</div>
<?php } ?>