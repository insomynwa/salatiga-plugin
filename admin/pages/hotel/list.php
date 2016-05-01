<?php 
	$data = $attributes[ 'hotel' ];
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
			<?php foreach( $data as $h ): ?>
			<tr>
				<td><?php _e( $h->GetNama() ) ?></td>
				<td><a href="?page=sltg-hotel&detail=<?php _e( $h->GetID() ); ?>">Detail</a> | <a href="?page=sltg-hotel&doaction=edit&hotel=<?php _e( $h->GetID() ); ?>">Edit</a> | <a href="?page=sltg-hotel&doaction=delete&hotel=<?php _e( $h->GetID() ); ?>">Delete</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>