<?php
	if( isset( $_POST[ 'submit-katprodukukm' ] ) ) {
		$get_post_nama = sanitize_text_field( $_POST[ 'nama-katprodukukm' ] );
		if( $get_post_nama!="" ) {
			$katprodukukm = new Sltg_Kategori_Product_UKM();
			$katprodukukm->SetNama( $get_post_nama );
			$result = $katprodukukm->AddNew();
			$message = "ERROR";
			if( $result[ 'status' ] )
				$message = $result[ 'message' ];
		}
	}
?>

<h3>Create New UKM Product Category</h3>
<div class="data-wrapper">
	<form class="form-horizontal" id="form-katprodukukm" method="post" action="#">
		<?php if( isset( $message ) ) { ?><div class="form-group"><div class="col-sm-offset-2  col-sm-4 form-message"><p class="text-success"><?php _e( $message ); ?></p></div></div><?php } ?>
		<div class="form-group">
			<label class="col-sm-offset-2  col-sm-4 control-label form-message" for="message-katprodukukm"></label>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="nama-katprodukukm">Name <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="nama-katprodukukm" class="form-control" id="nama-katprodukukm" placeholder="nama" required="required">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-4">
				<button class="form-control btn btn-success" type="submit" name="submit-katprodukukm" id="submit-katprodukukm"><span class="glyphicon glyphicon-save"></span> Save</button>
			</div>	
		</div>
	</form>
</div>
<div class="plugin-content-link">
</div>