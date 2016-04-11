<?php 
	$data = $attributes[ 'ukm' ];
	//var_dump($data);
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
			<?php foreach( $data as $ul ): ?>
			<tr>
				<td><?php _e( $ul->GetNama() ) ?></td>
				<td><a href="?page=sltg-ukm&detail=<?php _e( $ul->GetId() ); ?>">Detail</a> | <a href="?page=sltg-ukm&doaction=edit&ukm=<?php _e( $ul->GetId() ); ?>">Edit</a> | <a href="?page=sltg-ukm&doaction=delete&ukm=<?php _e( $ul->GetId() ); ?>">Delete</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>