<?php
	if( isset( $_POST[ 'submit-kattouristsite' ] ) ) {
		$get_post_nama = sanitize_text_field( $_POST[ 'nama-kattouristsite' ] );
		if( $get_post_nama!="" ) {
			$kattouristsite = new Sltg_Kategori_TouristSite();
			$kattouristsite->SetNama( $get_post_nama );
			$result = $kattouristsite->AddNew();
			$message = "ERROR";
			if( $result[ 'status' ] )
				$message = $result[ 'message' ];
		}
	}
?>

<h3>Create Tourist Site Category</h3>
<div class="data-wrapper">
	<form class="form-horizontal" id="form-kattouristsite" method="post" action="#">
		<?php if( isset( $message ) ) { ?><div class="form-group"><div class="col-sm-offset-2  col-sm-4 form-message"><p class="text-success"><?php _e( $message ); ?></p></div></div><?php } ?>
		<div class="form-group">
			<label class="col-sm-offset-2  col-sm-4 control-label form-message" for="message-kattouristsite"></label>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="nama-kattouristsite">Name <strong>*</strong></label>
			<div class="col-sm-4">
				<input type="text" name="nama-kattouristsite" class="form-control" id="nama-kattouristsite" placeholder="nama" required="required">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-4">
				<button class="form-control btn btn-success" type="submit" name="submit-kattouristsite" id="submit-kattouristsite"><span class="glyphicon glyphicon-save"></span> Save</button>
			</div>	
		</div>
	</form>
</div>
<div class="plugin-content-link">
	Go to <a href="<?php echo admin_url( 'admin.php?page=sltg-kattouristsite' ); ?>">Category Tourist Site list</a>.
</div>