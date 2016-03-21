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

	/*var pagination = new Pagination( "product", limit, searchfor, "#plugin-data-pagination");
	pagination.retrieve();*/

	doRetrievePagination( "ukm", limit, 0, searchfor, "#plugin-data-pagination" );

	$( "#data-limit" ).on( "change", function() {
		//selected_page = 1;
		limit = this.value;
		//searchfor = "";//$( "#txt-search" ).val();
		//if( isSearching ) searchfor = $( "#txt-search" ).val();

		// $( ".pagination a.page-" + current_page).parent().removeClass("active");
		// $( ".pagination a.page-" + selected_page ).parent().addClass("active");
		//current_page = selected_page;

		doRetrievePagination( "ukm", limit, 0, searchfor, "#plugin-data-pagination" );
		//retrieveList( "#plugin-data-list" );
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

			/*searchfor = ( $( "#txt-search").val() ).split(' ').join('');;
			if( searchfor != "" ) {
				isSearching = true;
			}*/
			doRetrievePagination( "ukm", limit, 0, searchfor, "#plugin-data-pagination" );
		}
		//current_page = 1;
		//selected_page = current_page;
		//searchFor( searchfor, "#plugin-data-list" );
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
				<option value="1" <?php if( get_option( 'ukm_list_limit' ) == 1 ) _e( "selected='selected'" ); ?> >1</option>
				<option value="2" <?php if( get_option( 'ukm_list_limit' ) == 2 ) _e( "selected='selected'" ); ?> >2</option>
				<option value="3" <?php if( get_option( 'ukm_list_limit' ) == 3 ) _e( "selected='selected'" ); ?> >3</option>
			</select>
		</div>
	</div>
	<div id="plugin-data-list"></div>
	<div id="plugin-data-pagination">
	</div>
</div>
<div class="plugin-content-link">
	<button id="add-new-ukm" class="btn btn-primary" data-toggle="modal" data-target="#modal-form-ukm"><span class="glyphicon glyphicon-plus"></span> Add New</button>
</div>
<div id="modal-form-ukm" class="modal fade" role="dialog" aria-labelledby="ukmModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-primary" id="ukmModalLabel">Form UKM</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="nama-ukm">Nama</label>
						<div class="col-sm-10">
							<input type="text" name="nama-ukm" class="form-control" id="nama-ukm" placeholder="nama ukm (CV Blablabla) " required="required">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="alamat-ukm">Alamat</label>
						<div class="col-sm-10">
							<textarea name="alamat-ukm" class="form-control" id="alamat-ukm"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="telp-ukm">Telp</label>
						<div class="col-sm-10">
							<input type="text" name="telp-ukm" class="form-control" id="telp-ukm" placeholder="0298xxxxx" required="required">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="deskripsi-ukm">Deskripsi</label>
						<div class="col-sm-10">
							<textarea name="deskripsi-ukm" class="form-control" id="deskripsi-ukm"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="pemilik-ukm">Pemilik</label>
						<div class="col-sm-6">
							<input type="text" name="pemilik-ukm" class="form-control" id="pemilik-ukm" placeholder="nama pemilik (Soekarno) " required="required">
							<input type="hidden" name="pemilik-ukm-id" id="pemilik-ukm-id" value="0">
						</div>
						<div class="col-sm-4">
							<button id="btn-refresh-pemilik" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-refresh"></span></button>
							<button id="btn-open-modal-personal" class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-personal"><span class="glyphicon glyphicon-user"></span></button>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button class="form-control btn btn-success" type="submit" name="submit-ukm" id="submit-ukm"><span class="glyphicon glyphicon-save"></span> Save</button>
						</div>	
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<div id="modal-personal" class="modal fade" role="dialog" aria-labelledby="personalModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-primary">Pemilik</h4>
			</div>
			<div class="modal-body">
				<div class="list-group">
					<a href="#" class="list-personal list-group-item" id="1">Mr. A</a>
					<a href="#" class="list-personal list-group-item" id="2">Mr. B</a>
					<a href="#" class="list-personal list-group-item" id="3">Mr. C</a>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>