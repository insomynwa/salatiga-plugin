<?php $jeniskamar = $attributes[ 'jeniskamar' ]; ?>
<h3>Product</h3>
<hr>
<div>
	<div class="row">
		<div class="col col-sm-4">
			<h3 class=""><?php _e( $jeniskamar->GetNama() ); ?></h3>
			<img src="<?php _e( $jeniskamar->GetGambarUtama()->GetLinkGambar() ); ?>">
		</div>
		<div class="col col-sm-8">
			<p><a href="?page=sltg-hotel&detail=<?php _e( $jeniskamar->GetHotel()->GetID() ); ?>"><?php _e( $jeniskamar->GetHotel()->GetNama() ); ?></a></p>
			<p><?php _e( $jeniskamar->GetDeskripsi() ); ?></p>
		</div>
	</div>
	<div>
		<ul><h4>Gambar:</h4>
			<?php foreach( $jeniskamar->GetGambars() as $gbr ): ?>
			<?php //var_dump($gbr); ?>
				<li><img src="<?php _e( $gbr->GetLinkGambar() ) ?>" width="10%"></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<div class="plugin-content-link">
	<a href="?page=sltg-jeniskamar&doaction=create-new">
		<button id="add-jeniskamar" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus"></span> Add
		</button>
	</a>
	<a href="?page=sltg-jeniskamar&doaction=edit&jeniskamar=<?php _e( $jeniskamar->GetID() ) ?>">
		<button id="edit-jeniskamar" class="btn btn-warning">
			<span class="glyphicon glyphicon-edit"></span> Edit
		</button>
	</a>
	<a href="?page=sltg-jeniskamar&doaction=delete&jeniskamar=<?php _e( $jeniskamar->GetID() ) ?>">
		<button id="delete-jeniskamar" class="btn btn-danger">
			<span class="glyphicon glyphicon-trash"></span> Delete
		</button>
	</a>
	| Go to <a href="<?php echo admin_url( 'admin.php?page=sltg-jeniskamar' ); ?>">jeniskamar list</a>.
</div>