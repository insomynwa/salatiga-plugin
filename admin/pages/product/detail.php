<?php $product = $attributes[ 'product' ]; ?>
<h3>Product</h3>
<hr>
<div>
	<div class="row">
		<div class="col col-sm-4">
			<h3 class=""><?php _e( $product->GetNama() ); ?></h3>
			<img src="<?php _e( $product->GetGambarUtama()->GetLinkGambar() ); ?>">
		</div>
		<div class="col col-sm-8">
			<p><?php _e( $product->GetUKM()->GetNama() ); ?></p>
			<p><?php _e( $product->GetKategori()->GetNama() ); ?></p>
			<p><?php _e( $product->GetDeskripsi() ); ?></p>
			<p><?php _e( $product->GetOther() ); ?></p>
		</div>
	</div>
	<div>
		<ul><h4>Gambar:</h4>
			<?php foreach( $product->GetGambars() as $gbr ): ?>
			<?php //var_dump($gbr); ?>
				<li><img src="<?php _e( $gbr->GetLinkGambar() ) ?>" width="10%"></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>