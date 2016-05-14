<?php 
	$data = $attributes[ 'jeniskamar' ];
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
			<?php foreach( $data as $jk ): ?>
			<tr>
				<td><?php _e( $jk->GetNama() ) ?></td>
				<td><a href="?page=sltg-jeniskamar&detail=<?php _e( $jk->GetID() ); ?>">Detail</a> | <a href="?page=sltg-jeniskamar&doaction=edit&jeniskamar=<?php _e( $jk->GetID() ); ?>">Edit</a> | <a href="?page=sltg-jeniskamar&doaction=delete&jeniskamar=<?php _e( $jk->GetID() ); ?>">Delete</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>