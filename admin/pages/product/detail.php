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
			<p><a href="?page=sltg-ukm&detail=<?php _e( $product->GetProducer()->GetID() ); ?>"><?php _e( $product->GetProducer()->GetNama() ); ?></a></p>
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
<div class="plugin-content-link">
	<a href="?page=sltg-product&doaction=create-new">
		<button id="add-product" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus"></span> Add
		</button>
	</a>
	<a href="?page=sltg-product&doaction=edit&product=<?php _e( $product->GetID() ) ?>">
		<button id="edit-product" class="btn btn-warning">
			<span class="glyphicon glyphicon-edit"></span> Edit
		</button>
	</a>
	<a href="?page=sltg-product&doaction=delete&product=<?php _e( $product->GetID() ) ?>">
		<button id="delete-product" class="btn btn-danger">
			<span class="glyphicon glyphicon-trash"></span> Delete
		</button>
	</a>
	| Go to <a href="<?php echo admin_url( 'admin.php?page=sltg-product' ); ?>">product list</a>.
</div>