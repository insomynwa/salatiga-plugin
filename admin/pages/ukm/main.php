<script type="text/javascript">
jQuery(document).ready( function ($) {
	$( "#modal-personal" ).on( "hidden.bs.modal", function (event) {
		$( "#modal-form-ukm" ).modal( "show" );
	});
	$( "#modal-personal" ).on( "show.bs.modal", function (event) {
		$( "#modal-form-ukm" ).modal( "hide" );
	});
	$( ".list-personal" ).click( function(){
		$( "#pemilik-ukm-id" ).val( (this).id );
		$( "#pemilik-ukm" ).val( (this).text );
		$( "#pemilik-ukm" ).prop( "readonly", true );
		$( "#modal-personal" ).modal( "hide" );
	});
	$( "#btn-refresh-pemilik").click( function(){
		$( "#pemilik-ukm" ).prop( "readonly", false );
		$( "#pemilik-ukm" ).val( "" );
		$( "#pemilik-ukm" ).focus();
		$( "#pemilik-ukm-id" ).val( 0 );
	});

	var limit = $( "#data-limit" ).val();
	var searchfor = $( "#txt-search").val();
	var isSearching = false;
	
	doRetrievePagination( "ukm", limit, 0, searchfor, "#plugin-data-pagination" );

	$( "#data-limit" ).on( "change", function() {
		limit = this.value;

		doRetrievePagination( "ukm", limit, 0, searchfor, "#plugin-data-pagination" );
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
			doRetrievePagination( "ukm", limit, 0, searchfor, "#plugin-data-pagination" );
		}
	});
});
</script>
<h3>UKM</h3>
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
				<option value="3" <?php if( get_option( 'ukm_list_limit' ) == 3 ) _e( "selected='selected'" ); ?> >3</option>
				<option value="10" <?php if( get_option( 'ukm_list_limit' ) == 10 ) _e( "selected='selected'" ); ?> >10</option>
				<option value="25" <?php if( get_option( 'ukm_list_limit' ) == 25 ) _e( "selected='selected'" ); ?> >25</option>
			</select>
		</div>
	</div>
	<div id="plugin-data-list"></div>
	<div id="plugin-data-pagination">
	</div>
</div>
<div class="plugin-content-link">
	<a href="?page=sltg-ukm&doaction=create-new">
		<button id="add-ukm" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus"></span> Add New
		</button>
	</a>
	<!-- <button id="add-new-ukm" class="btn btn-primary" data-toggle="modal" data-target="#modal-form-ukm"><span class="glyphicon glyphicon-plus"></span> Add New</button> -->
</div>