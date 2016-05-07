<?php $craft = $attributes[ 'craft' ]; ?>
<h3>Craft</h3>
<hr>
<div>
	<div class="row">
		<div class="col col-sm-4">
			<h3 class=""><?php _e( $craft->GetNama() ); ?></h3>
			<img src="<?php _e( $craft->GetGambarUtama()->GetLinkGambar() ); ?>">
		</div>
		<div class="col col-sm-8">
			<p><a href="?page=sltg-personal&detail=<?php _e( $craft->GetProducer()->GetID() ); ?>"><?php _e( $craft->GetProducer()->GetNama() ); ?></a></p>
			<p><?php _e( $craft->GetKategori()->GetNama() ); ?></p>
			<p><?php _e( $craft->GetDeskripsi() ); ?></p>
			<p><?php _e( $craft->GetOther() ); ?></p>
		</div>
	</div>
	<div>
		<ul><h4>Gambar:</h4>
			<?php foreach( $craft->GetGambars() as $gbr ): ?>
			<?php //var_dump($gbr); ?>
				<li><img src="<?php _e( $gbr->GetLinkGambar() ) ?>" width="10%"></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>