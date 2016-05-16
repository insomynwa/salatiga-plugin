<?php $hotel = $attributes[ 'hotel' ]; ?>
<h3>HOTEL</h3>
<hr>
<div>
	<div class="row">
		<div class="col col-sm-4">
			<h3 class=""><?php _e( $hotel->GetNama() ); ?></h3>
			<img src="<?php _e( $hotel->GetGambarUtama()->GetLinkGambar() ); ?>">
		</div>
		<div class="col col-sm-8">
			<p><?php _e( $hotel->GetDeskripsi() ); ?></p>
			<p><?php _e( $hotel->GetAlamat() ); ?></p>
			<p><?php _e( $hotel->GetTelp() ); ?></p>
			<p><?php _e( $hotel->GetOther() ); ?></p>
		</div>
	</div>
	<div>
		<ul><h4>Gambar:</h4>
			<?php foreach( $hotel->GetGambars() as $gbr ): ?>
			<?php //var_dump($gbr); ?>
				<li><img src="<?php _e( $gbr->GetLinkGambar() ) ?>" width="10%"></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div>
		<ul><h4>Kamar:</h4>
			<?php foreach( $hotel->GetJenisKamars() as $jeniskamar ): ?>
			<?php /*var_dump($jeniskamar);*/ ?>
				<li>
					<h5><?php _e( $jeniskamar->GetNama() ); ?></h5>
					<a href="?page=sltg-jeniskamar&detail=<?php _e( $jeniskamar->GetID() ); ?>"><img src="<?php _e( $jeniskamar->GetGambarUtama()->GetLinkGambar() ) ?>" width="10%"></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<div class="plugin-content-link">
	<a href="?page=sltg-hotel&doaction=create-new">
		<button id="add-hotel" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus"></span> Add
		</button>
	</a>
	<a href="?page=sltg-hotel&doaction=edit&hotel=<?php _e( $hotel->GetID() ) ?>">
		<button id="edit-hotel" class="btn btn-warning">
			<span class="glyphicon glyphicon-edit"></span> Edit
		</button>
	</a>
	<a href="?page=sltg-hotel&doaction=delete&hotel=<?php _e( $hotel->GetID() ) ?>">
		<button id="delete-hotel" class="btn btn-danger">
			<span class="glyphicon glyphicon-trash"></span> Delete
		</button>
	</a>
	| Go to <a href="<?php echo admin_url( 'admin.php?page=sltg-hotel' ); ?>">Hotel list</a>.
</div>