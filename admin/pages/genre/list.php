<?php 
	$data = $attributes[ 'genre' ];
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
			<?php foreach( $data as $g ): ?>
			<tr>
				<td><?php _e( $g->GetNama() ) ?></td>
				<td><a href="?page=sltg-genre&doaction=edit&genre=<?php _e( $g->GetID() ); ?>">Edit</a> | <a href="?page=sltg-genre&doaction=delete&genre=<?php _e( $g->GetID() ); ?>">Delete</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>