<?php 
	$jeniskamar = $attributes[ 'jeniskamar' ];

	if( isset( $_POST[ 'submit-delete-jeniskamar' ] ) ) {
		$result = $jeniskamar->Delete();
		$message = "ERROR";
		if( $result[ 'status' ] )
			_e( "SUCCESS" );
	}
	else {
		if( !is_null( $jeniskamar->GetId() ) ) {
?>
<div class="form-delete-area">
	<form id="form-delete-jeniskamar" method="post">
		<label>Yakin hapus <?php _e( $jeniskamar->GetNama() ) ?>?</label>
		<input type="hidden" value="<?php _e( $jeniskamar->GetID() ); ?>" name="id-jeniskamar" id="id-jeniskamar">
		<button class="btn btn-danger" type="submit" id="btn-delete-jeniskamar" name="submit-delete-jeniskamar">YES</button>
	</form>
</div>
<?php } } ?>
Go to <a href="<?php echo admin_url( 'admin.php?page=sltg-jeniskamar' ); ?>">Kamar list</a>.