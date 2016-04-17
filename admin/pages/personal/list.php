<?php 
	$data = $attributes[ 'personal' ];
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
			<?php foreach( $data as $p ): ?>
			<tr>
				<td><?php _e( $p->GetNama() ) ?></td>
				<td><a href="?page=sltg-personal&detail=<?php _e( $p->GetID() ); ?>">Detail</a> | <a href="?page=sltg-personal&doaction=edit&person=<?php _e( $p->GetID() ); ?>">Edit</a> | <a href="?page=sltg-personal&doaction=delete&person=<?php _e( $p->GetID() ); ?>">Delete</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>