<h3>Music</h3>
<div class="data-wrapper">
	<div class="plugin-data-filter row">
		<div class="col-sm-6">
			<?php if( sizeof( $attributes[ 'genre' ] ) > 0 ): ?>
				<label class="">Genre:</label>
				<select id="data-filter-genre" class="">
					<option value="0">semua</option>
					<?php foreach( $attributes[ 'genre' ] as $genre ): ?>
						<option value="<?php _e( $genre->GetID() ); ?>" ><?php _e( $genre->GetNama() ); ?></option>
					<?php endforeach; ?>
				</select>
			<?php endif; ?>
		</div>
		<div class="col-sm-4">
			<div class="input-group">
				<input type="text" id="txt-search" class="form-control" placeholder="(title)">
				<span class="input-group-btn">
					<button id="btn-search" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search">Cari</span></button>
				</span>
			</div>
		</div>
		<div class="col-sm-2">
			<label class="">Jumlah list:</label>
			<select id="data-limit" class="">
				<option value="5" <?php if( get_option( 'music_list_limit' ) == 5 ) _e( "selected='selected'" ); ?> >5</option>
				<option value="10" <?php if( get_option( 'music_list_limit' ) == 10 ) _e( "selected='selected'" ); ?> >10</option>
				<option value="25" <?php if( get_option( 'music_list_limit' ) == 25 ) _e( "selected='selected'" ); ?> >25</option>
			</select>
		</div>
	</div>
	<div id="plugin-data-list"></div>
	<div id="plugin-data-pagination">
	</div>
</div>
<div class="plugin-content-link">
	<!-- <button id="add-music" class="btn btn-primary" data-toggle="modal" data-target="#modal-form-music">
		<span class="glyphicon glyphicon-plus"></span> Add
	</button> -->
	<a href="?page=sltg-music&doaction=create-new">
		<button id="add-music" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus"></span> Add
		</button>
	</a>
</div>
<script type="text/javascript">
jQuery(document).ready( function($) {

	var limit = $( "#data-limit" ).val();
	var searchfor = $( "#txt-search").val();
	var isSearching = false;
	var genre = $( "#data-filter-genre" ).val();

	var data = {
			action: 'RetrievePagination',
			listfor: "music",
			limit: limit
		};

	if( searchfor != "" ) {
		data.search = searchfor;
	}
	if( genre != 0 ) {
		data.genre = genre;
	}
	
	doRetrievePagination( data, "#plugin-data-pagination" );

	// doRetrievePagination( "music", limit, genre, searchfor, "#plugin-data-pagination" );

	$( "#data-limit" ).on( "change", function() {

		limit = this.value;
		data.limit = limit;

		// doRetrievePagination( "music", limit, genre, searchfor, "#plugin-data-pagination" );
		doRetrievePagination( data, "#plugin-data-pagination" );
	});	

	$( "#data-filter-genre").on( "change", function() {
		genre = this.value;
		data.genre = genre;
		// doRetrievePagination( "music", limit, genre, searchfor, "#plugin-data-pagination");
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
			data.search = searchfor;
			data.limit = limit;
			doRetrievePagination( data, "#plugin-data-pagination" );
			// doRetrievePagination( "music", limit, genre, searchfor, "#plugin-data-pagination" );
		}

	});
	
});
</script>