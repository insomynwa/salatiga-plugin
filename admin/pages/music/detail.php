<?php $music = $attributes[ 'music' ]; ?>
<h3>Personal</h3>
<hr>
<div>
	<div class="">
		<div class="">
			<h3 class=""><?php _e( $music->GetTitle() ); ?></h3>
			<?php echo do_shortcode( '[soundcloud url="https://api.soundcloud.com/tracks/'. $music->GetSource() . '" params="auto_play=false&hide_related=true&show_comments=false&show_user=true&show_reposts=false&visual=false&sharing=false&download=false&liking=false&buying=false" width="100%" height="120" iframe="true" /]' ); ?>
		</div>
		<div class="">
			<p><?php _e( $music->GetInfo() ); ?></p>
			<p><?php _e( $music->GetGenre()->GetNama() ); ?></p>
			<p><?php _e( $music->GetCreator()->GetNama() ); ?></p>
		</div>
	</div>
</div>