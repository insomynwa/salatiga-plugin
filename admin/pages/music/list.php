<?php 
	$data = $attributes[ 'music' ];
?>
<?php if( sizeof( $data ) > 0 ): ?>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Music</th>
				<th>Source</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach( $data as $m ): ?>
			<tr>
				<td><?php _e( $m->GetTitle() ) ?></td>
				<td><a href="?page=sltg-music&detail=<?php _e( $m->GetID() ); ?>">Detail</a> | <a href="?page=sltg-music&doaction=edit&music=<?php _e( $m->GetID() ); ?>">Edit</a> | <a href="?page=sltg-music&doaction=delete&music=<?php _e( $m->GetID() ); ?>">Delete</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>