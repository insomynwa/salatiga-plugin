<?php 
	$data = $attributes[ 'kattouristsite' ];
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
			<?php foreach( $data as $kc ): ?>
			<tr>
				<td><?php _e( $kc->GetNama() ) ?></td>
				<td><a href="?page=sltg-kattouristsite&doaction=edit&kattouristsite=<?php _e( $kc->GetID() ); ?>">Edit</a> | <a href="?page=sltg-kattouristsite&doaction=delete&kattouristsite=<?php _e( $kc->GetID() ); ?>">Delete</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>