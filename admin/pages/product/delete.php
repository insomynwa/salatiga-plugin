<?php 
	$product = $attributes[ 'product' ];
	
	// if( isset( $_POST[ 'submit-delete-product' ] ) ) {
	/*if( ! isset( $_POST[ 'sltg_nonce_delete_field' ] ) || ! wp_verify_nonce( $_POST[ 'sltg_nonce_delete_field' ] ) ) {
		_e("belum post");
	}
	else {
		// echo $product->GetNama() . " dihapus";
		_e( $_POST['sltg_nonce_delete_field']);
		foreach( $product->GetGambars() as $gbr ) {
			_e( $gbr->GetLinkGambar() . ' -- ' . $gbr->GetPostId() . '<br/>');
		}
	}*/
	/*foreach( $product->GetGambars() as $gbr ) {
			_e( $gbr->GetPostId() . '<br/>');
		}*/

	if( isset( $_POST[ 'submit-delete-product' ] ) ) {
		$result = $product->Delete();
		$message = "ERROR";
		//var_dump($result);
		if( $result[ 'status' ] )
			_e( "SUCCESS" );
	}
	else {

?>
<div class="form-delete-area">
	<form id="form-delete-product" method="post">
		<label>Yakin hapus <?php _e( $product->GetNama() ) ?>?</label>
		<input type="hidden" value="<?php _e( $product->GetId() ); ?>" name="id-product" id="id-product">
		<button class="btn btn-danger" type="submit" id="btn-delete-product" name="submit-delete-product">YES</button>
		<?php //wp_nonce_field( 'sltg_action_delete_product', 'sltg_nonce_delete_field' ); ?>
	</form>
</div>
<?php } ?>