<?php $music = $attributes[ 'music' ]; ?>
<h3>Personal</h3>
<hr>
<div>
	<div class="">
		<div class="">
			<h3 class=""><?php _e( str_replace("\'", "'", $music->GetTitle() ) ) ?></h3>
			<?php echo do_shortcode( '[soundcloud url="https://api.soundcloud.com/tracks/'. $music->GetSource() . '" params="auto_play=false&hide_related=true&show_comments=false&show_user=true&show_reposts=false&visual=false&sharing=false&download=false&liking=false&buying=false" width="100%" height="120" iframe="true" /]' ); ?>
		</div>
		<div class="">
			<p><?php _e( $music->GetInfo() ); ?></p>
			<p><?php _e( $music->GetGenre()->GetNama() ); ?></p>
			<p><?php _e( $music->GetCreator()->GetNama() ); ?></p>
		</div>
	</div>
</div>
<div class="plugin-content-link">
	<a href="?page=sltg-music&doaction=create-new">
		<button id="add-music" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus"></span> Add
		</button>
	</a>
	<a href="?page=sltg-music&doaction=edit&music=<?php _e( $music->GetID() ) ?>">
		<button id="edit-music" class="btn btn-warning">
			<span class="glyphicon glyphicon-edit"></span> Edit
		</button>
	</a>
	<a href="?page=sltg-music&doaction=delete&music=<?php _e( $music->GetID() ) ?>">
		<button id="delete-music" class="btn btn-danger">
			<span class="glyphicon glyphicon-trash"></span> Delete
		</button>
	</a>
	| Go to <a href="<?php echo admin_url( 'admin.php?page=sltg-music' ); ?>">music list</a>.
</div>