<?php $ukm = $attributes[ 'ukm' ]; ?>
<h3>UKM</h3>
<hr>
<div>
	<div class="row">
		<div class="col col-sm-4">
			<h3 class=""><?php _e( $ukm->GetNama() ); ?></h3>
			<img src="<?php _e( $ukm->GetGambarUtama()->GetLinkGambar() ); ?>">
		</div>
		<div class="col col-sm-8">
			<p><?php _e( $ukm->GetDeskripsi() ); ?></p>
			<p><?php _e( $ukm->GetAlamat() ); ?></p>
			<p><?php _e( $ukm->GetTelp() ); ?></p>
			<p><?php _e( $ukm->GetOther() ); ?></p>
			<p><?php _e( $ukm->GetPemilik()->GetNama() ); ?></p>
		</div>
	</div>
	<div>
		<ul><h4>Gambar:</h4>
			<?php //foreach( $ukm->GetGambars() as $gbr ): ?>
			<?php //var_dump($gbr); ?>
				<li><img src="<?php //_e( $gbr->GetLinkGambar() ) ?>" width="10%"></li>
			<?php //endforeach; ?>
		</ul>
	</div>
</div>