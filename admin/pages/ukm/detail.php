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
			<p><a href="?page=sltg-personal&detail=<?php _e( $ukm->GetPemilik()->GetID() ); ?>"><?php _e( $ukm->GetPemilik()->GetNama() ); ?></a></p>
		</div>
	</div>
	<div>
		<ul><h4>Gambar:</h4>
			<?php foreach( $ukm->GetGambars() as $gbr ): ?>
			<?php //var_dump($gbr); ?>
				<li><img src="<?php _e( $gbr->GetLinkGambar() ) ?>" width="10%"></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div>
		<ul><h4>Product:</h4>
			<?php foreach( $ukm->GetProducts() as $product ): ?>
			<?php //var_dump($gbr); ?>
				<li><a href="?page=sltg-product&detail=<?php _e( $product->GetID() ); ?>"><img src="<?php _e( $product->GetGambarUtama()->GetLinkGambar() ) ?>" width="10%"></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>