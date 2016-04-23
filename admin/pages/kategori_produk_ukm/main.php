<h3>Kategori Produk UKM</h3>
<div class="data-wrapper">
	<div class="plugin-data-filter row">
		<div class="col-sm-6"></div>
		<div class="col-sm-4">
			<div class="input-group">
				<input type="text" id="txt-search" class="form-control" placeholder="(nama)">
				<span class="input-group-btn">
					<button id="btn-search" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
				</span>
			</div>
		</div>
		<div class="col-sm-2">
			<label class="">Jumlah list:</label>
			<select id="data-limit" class="">
				<option value="1" <?php if( get_option( 'katprodukukm_list_limit' ) == 1 ) _e( "selected='selected'" ); ?> >1</option>
				<option value="10" <?php if( get_option( 'katprodukukm_list_limit' ) == 10 ) _e( "selected='selected'" ); ?> >10</option>
				<option value="25" <?php if( get_option( 'katprodukukm_list_limit' ) == 25 ) _e( "selected='selected'" ); ?> >25</option>
			</select>
		</div>
	</div>
	<div id="plugin-data-list"></div>
	<div id="plugin-data-pagination">
	</div>
</div>
<div class="plugin-content-link">
	<a href="?page=sltg-katprodukukm&doaction=create-new">
		<button id="add-person" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus"></span> Add
		</button>
	</a>
</div>

<script type="text/javascript">
jQuery(document).ready( function($) {

	var limit = $( "#data-limit" ).val();
	var searchfor = $( "#txt-search").val();
	var isSearching = false;

	var data = {
			action: 'RetrievePagination',
			listfor: "katprodukukm",
			limit: limit
		};

	if( searchfor != "" ) {
		data.search = searchfor;
	}

	doRetrievePagination( data, "#plugin-data-pagination" );

	// doRetrievePagination( "katprodukukm", limit, 0, searchfor, "#plugin-data-pagination" );

	$( "#data-limit" ).on( "change", function() {

		limit = this.value;
		data.limit = limit;

		// doRetrievePagination( "katprodukukm", limit, 0, searchfor, "#plugin-data-pagination" );
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
			limit = $( "#data-limit" ).val();

			data.limit = limit;
			data.search = searchfor;
			// doRetrievePagination( "katprodukukm", limit, 0, searchfor, "#plugin-data-pagination" );
			doRetrievePagination( data, "#plugin-data-pagination" );
		}

	});	
});
</script>