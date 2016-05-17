<?php 
	$touristsite = $attributes[ 'touristsite' ];

	if( isset( $_POST[ 'submit-delete-touristsite' ] ) ) {
		$result = $touristsite->Delete();
		$message = "ERROR";
		if( $result[ 'status' ] )
			_e( "SUCCESS" );
	}
	else {

?>
<div class="form-delete-area">
	<form id="form-delete-touristsite" method="post">
		<label>Yakin hapus <?php _e( $touristsite->GetNama() ) ?>?</label>
		<input type="hidden" value="<?php _e( $touristsite->GetID() ); ?>" name="id-touristsite" id="id-touristsite">
		<button class="btn btn-danger" type="submit" id="btn-delete-touristsite" name="submit-delete-touristsite">YES</button>
	</form>
</div>
<?php } ?>
| Go to <a href="<?php echo admin_url( 'admin.php?page=sltg-touristsite' ); ?>">touristsite list</a>.