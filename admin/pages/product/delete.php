<?php 
	$product = $attributes[ 'product' ];

	if( isset( $_POST[ 'submit-delete-product' ] ) ) {
		$result = $product->Delete();
		$message = "ERROR";
		if( $result[ 'status' ] )
			_e( "SUCCESS" );
	}
	else {

?>
<div class="form-delete-area">
	<form id="form-delete-product" method="post">
		<label>Yakin hapus <?php _e( $product->GetNama() ) ?>?</label>
		<input type="hidden" value="<?php _e( $product->GetID() ); ?>" name="id-product" id="id-product">
		<button class="btn btn-danger" type="submit" id="btn-delete-product" name="submit-delete-product">YES</button>
	</form>
</div>
<?php } ?>