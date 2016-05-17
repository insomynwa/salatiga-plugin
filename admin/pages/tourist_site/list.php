<?php 
	$data = $attributes[ 'touristsite' ];
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
			<?php foreach( $data as $crf ): ?>
			<tr>
				<td><?php _e( $crf->GetNama() ) ?></td>
				<td><a href="?page=sltg-touristsite&detail=<?php _e( $crf->GetID() ); ?>">Detail</a> | <a href="?page=sltg-touristsite&doaction=edit&touristsite=<?php _e( $crf->GetID() ); ?>">Edit</a> | <a href="?page=sltg-touristsite&doaction=delete&touristsite=<?php _e( $crf->GetID() ); ?>">Delete</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>