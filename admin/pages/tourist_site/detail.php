<?php $touristsite = $attributes[ 'touristsite' ]; ?>
<h3>Craft</h3>
<hr>
<div>
	<div class="row">
		<div class="col col-sm-4">
			<h3 class=""><?php _e( $touristsite->GetNama() ); ?></h3>
			<img src="<?php _e( $touristsite->GetGambarUtama()->GetLinkGambar() ); ?>">
		</div>
		<div class="col col-sm-8">
			<p><?php _e( $touristsite->GetKategori()->GetNama() ); ?></p>
			<p><?php _e( $touristsite->GetDeskripsi() ); ?></p>
			<p><?php _e( $touristsite->GetAlamat() ); ?></p>
			<p><?php _e( $touristsite->GetOther() ); ?></p>
		</div>
	</div>
	<div>
		<ul><h4>Gambar:</h4>
			<?php foreach( $touristsite->GetGambars() as $gbr ): ?>
			<?php //var_dump($gbr); ?>
				<li><img src="<?php _e( $gbr->GetLinkGambar() ) ?>" width="10%"></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<div class="plugin-content-link">
	<a href="?page=sltg-touristsite&doaction=create-new">
		<button id="add-touristsite" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus"></span> Add
		</button>
	</a>
	<a href="?page=sltg-touristsite&doaction=edit&touristsite=<?php _e( $touristsite->GetID() ) ?>">
		<button id="edit-touristsite" class="btn btn-warning">
			<span class="glyphicon glyphicon-edit"></span> Edit
		</button>
	</a>
	<a href="?page=sltg-touristsite&doaction=delete&touristsite=<?php _e( $touristsite->GetID() ) ?>">
		<button id="delete-touristsite" class="btn btn-danger">
			<span class="glyphicon glyphicon-trash"></span> Delete
		</button>
	</a>
	| Go to <a href="<?php echo admin_url( 'admin.php?page=sltg-touristsite' ); ?>">touristsite list</a>.
</div>