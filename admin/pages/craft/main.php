<h3>Craft</h3>
<div class="data-wrapper">
	<div class="plugin-data-filter row">
		<div class="col-sm-6">
			<?php if( sizeof( $attributes[ 'kategori' ] ) > 0 ): ?>
				<label class="">Kategori:</label>
				<select id="data-filter-kategori" class="">
					<option value="0">semua</option>
					<?php foreach( $attributes[ 'kategori' ] as $kategori ): ?>
						<option value="<?php _e( $kategori->GetID() ); ?>" ><?php _e( $kategori->GetNama() ); ?></option>
					<?php endforeach; ?>
				</select>
			<?php endif; ?>
		</div>
		<div class="col-sm-4">
			<div class="input-group">
				<input type="text" id="txt-search" class="form-control" placeholder="(nama)">
				<span class="input-group-btn">
					<button id="btn-search" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search">Cari</span></button>
				</span>
			</div>
		</div>
		<div class="col-sm-2">
			<label class="">Jumlah list:</label>
			<select id="data-limit" class="">
				<option value="1" <?php if( get_option( 'craft_list_limit' ) == 1 ) _e( "selected='selected'" ); ?> >1</option>
				<option value="10" <?php if( get_option( 'craft_list_limit' ) == 10 ) _e( "selected='selected'" ); ?> >10</option>
				<option value="25" <?php if( get_option( 'craft_list_limit' ) == 25 ) _e( "selected='selected'" ); ?> >25</option>
			</select>
		</div>
	</div>
	<div id="plugin-data-list"></div>
	<div id="plugin-data-pagination">
	</div>
</div>
<div class="plugin-content-link">
	<a href="?page=sltg-craft&doaction=create-new">
		<button id="add-craft" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus"></span> Add
		</button>
	</a>
</div>
<script type="text/javascript">
jQuery(document).ready( function($) {

	var limit = $( "#data-limit" ).val();
	var searchfor = $( "#txt-search").val();
	var isSearching = false;
	var kategori = $( "#data-filter-kategori" ).val();

	var data = {
			action: 'RetrievePagination',
			listfor: "craft",
			limit: limit
		};

	if( searchfor != "" ) {
		data.search = searchfor;
	}
	if( kategori != 0 ) {
		data.category = kategori;
	}
	
	doRetrievePagination( data, "#plugin-data-pagination" );

	// doRetrievePagination( "craft", limit, kategori, searchfor, "#plugin-data-pagination" );

	$( "#data-limit" ).on( "change", function() {

		limit = this.value;
		data.limit = limit;

		// doRetrievePagination( "craft", limit, kategori, searchfor, "#plugin-data-pagination" );
		doRetrievePagination( data, "#plugin-data-pagination" );

	});	

	$( "#data-filter-kategori").on( "change", function() {
		kategori = this.value;
		data.category = kategori;
		//doRetrievePagination( "craft", limit, kategori, searchfor, "#plugin-data-pagination");
	
		doRetrievePagination( data, "#plugin-data-pagination" );
	});

	$( "#btn-search" ).click( function(e) {
		if( ($( "#txt-search" ).val()).split(' ').join('') != '' ) {
			if( !isSearching ) {
				isSearching = true;
				$( this ).addClass('searching').html( "<span class='glyphicon glyphicon-remove-circle'></span>" );
				$( "#txt-search").prop( "readonly" , true);
				searchfor = $( "#txt-search" ).val();

			}else {
				isSearching = false;
				$( this ).removeClass('searching').html( "<span class='glyphicon glyphicon-search'></span>" );
				$( "#txt-search").prop( "readonly", false);
				searchfor = "";
				$( "#txt-search").val("");
			}

			data.limit = limit;
			data.search = searchfor;

			// doRetrievePagination( "craft", limit, kategori, searchfor, "#plugin-data-pagination" );
			doRetrievePagination( data, "#plugin-data-pagination" );
		}

	});
	
});
</script>