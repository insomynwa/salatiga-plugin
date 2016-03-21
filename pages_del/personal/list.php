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
			<?php foreach( $data as $pl ): ?>
			<tr>
				<td><?php _e( $pl->GetNama() ) ?></td>
				<td>Edit | Delete</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>