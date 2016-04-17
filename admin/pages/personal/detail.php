<?php $person = $attributes[ 'person' ]; ?>
<h3>Personal</h3>
<hr>
<div>
	<div class="row">
		<div class="col col-sm-4">
			<h3 class=""><?php _e( $person->GetNama() ); ?></h3>
			<img src="<?php _e( $person->GetGambarUtama()->GetLinkGambar() ); ?>">
		</div>
		<div class="col col-sm-8">
			<p><?php _e( $person->GetDeskripsi() ); ?></p>
			<p><?php _e( $person->GetAlamat() ); ?></p>
			<p><?php _e( $person->GetTelp() ); ?></p>
			<p><?php _e( $person->GetOther() ); ?></p>
		</div>
	</div>
	<div>
		<ul><h4>Gambar:</h4>
			<?php foreach( $person->GetGambars() as $gbr ): ?>
			<?php //var_dump($gbr); ?>
				<li><img src="<?php _e( $gbr->GetLinkGambar() ) ?>" width="10%"></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div>
		<ul><h4>UKM:</h4>
			<?php foreach( $person->GetUKMs() as $ukm ): ?>
			<?php //var_dump($gbr); ?>
				<li><a href="?page=sltg-ukm&detail=<?php _e( $ukm->GetID() ); ?>"><img src="<?php _e( $ukm->GetGambarUtama()->GetLinkGambar() ) ?>" width="10%"></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>