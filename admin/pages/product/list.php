<?php 
	$data = $attributes[ 'product' ];
?>
<?php if( sizeof( $data ) > 0 ): ?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Name</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach( $data as $pl ): ?>
			<tr>
				<td><?php _e( $pl->GetNama() ) ?></td>
				<td><a href="?page=sltg-product&detail=<?php _e( $pl->GetID() ); ?>">Detail</a> | <a href="?page=sltg-product&doaction=edit&product=<?php _e( $pl->GetID() ); ?>">Edit</a> | <a href="?page=sltg-product&doaction=delete&product=<?php _e( $pl->GetID() ); ?>">Delete</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>