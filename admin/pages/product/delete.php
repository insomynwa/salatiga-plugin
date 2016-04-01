<?php $product = $attributes[ 'product' ]; ?>
<div class="form-delete-area">
	<form id="form-delete-product" actino="post">
		<label>Yakin hapus <?php _e( $product->GetNama() ) ?>?</label>
		<input type="hidden" value="<?php _e( $product->GetId() ); ?>" name="id-product" id="id-product">
		<button class="btn btn-danger" type="submit" id="btn-delete-product" name="submit-delete-product">YES</button>
	</form>
</div>
<script type="text/javascript">
jQuery(document).ready( function($) {
	$( "form#form-delete-product" ).submit( function(e) {
		e.preventDefault();

		// DELETE PRODUCT, DELETE PICTURE, 
		alert( "BAAA" );
	});
		
	
});
</script>