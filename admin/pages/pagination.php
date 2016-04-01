<ul class="pagination">
	<?php for( $i = 0; $i < $attributes[ 'n-page' ]; $i++ ): ?>
	<li><a class="page-<?php _e( ($i + 1) ); ?>" href="#"><?php _e( ($i + 1) ); ?></a></li>
	<?php endfor; ?>
</ul>
<script type="text/javascript">
jQuery(document).ready(function($){

	var current_page = 1;
	var selected_page = 1;
	var limit = $( "#data-limit" ).val();
	var kategori = $( "#data-filter-kategori" ).val();
	var searchfor = '';

	if( $( "#btn-search" ).hasClass( 'searching' ) )
		searchfor = $( "#txt-search" ).val();

	$( ".pagination a.page-" + selected_page ).parent().addClass( "active" );

	doRetrieveList( "<?php _e($attributes[ 'listfor' ]); ?>", limit, selected_page, searchfor, kategori, "#plugin-data-list");

	$( ".pagination a").click( function() {
		selected_page = $( this ).text();

		$( ".pagination a.page-" + current_page).parent().removeClass("active");
		$( ".pagination a.page-" + selected_page ).parent().addClass("active");
		current_page = selected_page;

		doRetrieveList( "<?php _e($attributes[ 'listfor' ]); ?>", limit, selected_page, searchfor, kategori, "#plugin-data-list" );
	});

});
</script>