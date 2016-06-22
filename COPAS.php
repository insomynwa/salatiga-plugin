<?php 
	$data = $attributes[ 'touristsite' ];
?>
<?php if( sizeof( $data ) > 0 ): ?>
	<?php foreach( $data as $pl ): ?>
		<?php $w = 1 + 3 * rand_num() << 0;?>
		<div class="brick" style="width:25%; height:200px; ?>px;">
			<a href="<?php echo home_url().'/detail-tourist-site?touristsite='. $pl->GetID(); ?>">
				<h3 style="width:100%"><?php _e( strtoupper( $pl->GetNama() ) ); ?></h3>
				<img src="<?php _e( $pl->GetGambarUtama()->GetLinkGambar() ); ?>?<?php echo millitime(); ?>" width="100%" alt="<?php _e( $pl->GetNama() ); ?>">
			</a>
		</div>
	<?php endforeach; ?>
<?php endif; ?>
<script type="text/javascript">
jQuery(document).ready( function($) {
	var w = 1, h = 1, html = '', limitItem = 9;

	var wall = new Freewall("#sltg-content");
	wall.reset({
		selector: '.brick',
		animate: true,
		cellW: 150,
		cellH: 'auto',
		onResize: function() {
			wall.fitWidth();
		}
	});
	var images = wall.container.find('.brick');
	images.find('img').load(function() {
		wall.fitWidth();
	});
} );
</script>