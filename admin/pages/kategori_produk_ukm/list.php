<?php 
	$data = $attributes[ 'katprodukukm' ];
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
			<?php foreach( $data as $kpu ): ?>
			<tr>
				<td><?php _e( $kpu->GetNama() ) ?></td>
				<td><a href="?page=sltg-katprodukukm&doaction=edit&katprodukukm=<?php _e( $kpu->GetID() ); ?>">Edit</a> | <a href="?page=sltg-katprodukukm&doaction=delete&katprodukukm=<?php _e( $kpu->GetID() ); ?>">Delete</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>