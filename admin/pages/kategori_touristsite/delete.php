<?php 
	$kattouristsite = $attributes[ 'kattouristsite' ];

	if( isset( $_POST[ 'submit-delete-kattouristsite' ] ) ) {
		$result = $kattouristsite->Delete();
		$message = "ERROR";
		if( $result[ 'status' ] )
			_e( "SUCCESS" );
	}
	else {

?>
<div class="form-delete-area">
	<form id="form-delete-kattouristsite" method="post">
		<label>Yakin hapus <?php _e( $kattouristsite->GetNama() ) ?>?</label>
		<input type="hidden" value="<?php _e( $kattouristsite->GetId() ); ?>" name="id-kattouristsite" id="id-kattouristsite">
		<button class="btn btn-danger" type="submit" id="btn-delete-kattouristsite" name="submit-delete-kattouristsite">YES</button>
	</form>
</div>
<?php } ?>
Go to <a href="<?php echo admin_url( 'admin.php?page=sltg-kattouristsite' ); ?>">Tourist Site Category list</a>.