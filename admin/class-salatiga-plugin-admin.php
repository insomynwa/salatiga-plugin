<?php
class Salatiga_Plugin_Admin {

	protected $version;

	public function __construct( $version ) {
		$this->version = $version;
	}

	public function enqueue_scripts_and_styles() {
		wp_enqueue_media();

		wp_register_script( 'sltg-script', plugin_dir_url( __FILE__ ) . 'js/sltg-script.js' );
		wp_register_script( 'jquery-ui-script', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.js' );
		wp_register_script( 'bootstrap-js', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.js' );
		wp_register_script( 'freewall-js', plugin_dir_url( __FILE__ ) . 'js/freewall.js' );
		wp_register_style( 'jquery-min-style', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css' );
		wp_register_style( 'bootstrap-css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css' );

		wp_enqueue_script( 'sltg-script' );
		wp_enqueue_script( 'freewall-js' );
		wp_enqueue_script( 'jquery-ui-script' );
		wp_enqueue_script( 'bootstrap-js' );
		wp_enqueue_style( 'jquery-min-style' );
		wp_enqueue_style( 'bootstrap-css' );

		wp_localize_script( "sltg-script", "sltg_ajax", array('ajaxurl'=>admin_url('admin-ajax.php')) );
	}

	public function create_admin_menus_and_subs() {
		// Main Menu
		add_menu_page(
			'SALATIGA',
			'SALATIGA',
			'manage_options',
			'sltg-main-page',
			array( $this, 'render_main_page'),
			'',
			3
			);

		// Menu UKM
		// UKM
		add_submenu_page(
			null,
			'UKM',
			'UKM',
			'manage_options',
			'sltg-ukm',
			array( $this, 'render_ukm_page' )
			);
		// PRODUCT
		add_submenu_page(
			null,
			'Product',
			'Product',
			'manage_options',
			'sltg-product',
			array( $this, 'render_product_page' )
			);
		// PERSONAL
		add_submenu_page(
			null,
			'Founder/Creator',
			'Founder/Creator',
			'manage_options',
			'sltg-personal',
			array( $this, 'render_personal_page' )
			);
		// KATEGORI PRODUK UKM
		add_submenu_page(
			null,
			'Kategori Produk UKM',
			'Kategori Produk UKM',
			'manage_options',
			'sltg-katprodukukm',
			array( $this, 'render_katprodukukm' )
			);

		// MUSIC
		add_submenu_page(
			null,
			'Music',
			'Music',
			'manage_options',
			'sltg-music',
			array( $this, 'render_music_page' )
			);

		// GENRE
		add_submenu_page(
			null,
			'Genre Music',
			'Genre Music',
			'manage_options',
			'sltg-genre',
			array( $this, 'render_genre_page' )
			);
	}

	// Render Main Page
	public function render_main_page(){
		$content = $this->get_html_template( 'pages', 'main', null, TRUE);
		$this->get_html_template( 'pages', 'template', $content );
	}

	// Render UKM page
	public function render_ukm_page(){
		if( isset( $_GET[ 'detail' ] ) && $_GET[ 'detail' ] > 0 ) {
			$get_detail = sanitize_text_field( $_GET[ 'detail'] );
			$obj = new Sltg_UKM();

			$obj->HasID( $get_detail );
			$attributes[ 'ukm' ] = $obj;

			$content = $this->get_html_template( 'pages/ukm', 'detail', $attributes, TRUE);
			$this->get_html_template( 'pages', 'template', $content );
		}
		else if( isset( $_GET[ 'doaction' ] ) && $_GET[ 'doaction' ] != "" ){
			$get_action = sanitize_text_field( $_GET[ 'doaction' ] );

			$obj_kat = new Sltg_Kategori_Product_UKM();
			$obj_person = new Sltg_Personal();
			
			$attributes = array();

			$persons = $obj_person->DataList();
			foreach( $persons as $p ){
				$person = new Sltg_Personal();
				$person->HasID( $p->id_personal );
				$attributes[ 'person' ][] = $person;
			}

			$action_template = "";
			if( $get_action == "create-new" ){
				$action_template = "add";

				if( isset( $_GET[ 'status' ] )) {
					$get_status = sanitize_text_field( $_GET[ 'status' ] );
					if( $get_status == 'success' ) {
						$attributes[ 'message' ] = "Success Bro!";
					}
				}
			}
			else if( $get_action == "edit" && isset( $_GET[ 'ukm' ] ) && ($_GET[ 'ukm' ] > 0) ) {
				$get_ukm_id = sanitize_text_field( $_GET[ 'ukm' ] );

				$action_template = "edit";

				if( isset( $_GET[ 'status' ] )) {
					$get_status = sanitize_text_field( $_GET[ 'status' ] );
					if( $get_status == 'success' ) {
						$attributes[ 'message' ] = "Success Bro!";
					}
				}

				$obj = new Sltg_UKM();
				$obj->HasID( $get_ukm_id );
				$attributes[ 'ukm' ] = $obj;
			}
			else if( $get_action == 'delete' && isset( $_GET[ 'ukm' ] ) && ( $_GET[ 'ukm' ] > 0 ) ) {
				$get_ukm_id = sanitize_text_field( $_GET[ 'ukm' ] );

				$action_template = 'delete';

				$obj = new Sltg_UKM();
				$obj->HasID( $get_ukm_id );
				$attributes[ 'ukm' ] = $obj;
			}

			$content = $this->get_html_template( 'pages/ukm', $action_template, $attributes, TRUE );
			$this->get_html_template( 'pages', 'template', $content );
		}
		else {
			$obj = new Sltg_UKM();
			$content = $this->get_html_template( 'pages/ukm', 'main', null, TRUE);
			$this->get_html_template( 'pages', 'template', $content );
		}
		

	}
	// Render Product page
	public function render_product_page(){
		if( isset( $_GET[ 'detail' ] ) && $_GET[ 'detail'] > 0) {

			$get_detail = sanitize_text_field( $_GET[ 'detail'] );
			$obj = new Sltg_Product();

			$obj->HasID( $get_detail );
			$attributes[ 'product' ] = $obj;

			$content = $this->get_html_template( 'pages/product', 'detail', $attributes, TRUE);
			$this->get_html_template( 'pages', 'template', $content );
		}
		else if( isset( $_GET[ 'doaction' ] ) && $_GET[ 'doaction' ] != "" ){
			$get_action = sanitize_text_field( $_GET[ 'doaction' ] );

			$obj_kat = new Sltg_Kategori_Product_UKM();
			$obj_ukm = new Sltg_UKM();
			
			$attributes = array();
			$kats = $obj_kat->Datalist();
			foreach( $kats as $kat ) {
				$kategori = new Sltg_Kategori_Product_UKM();
				$kategori->HasID( $kat->id_kategori );
				$attributes[ 'kategori' ][] = $kategori;
			}

			$ukms = $obj_ukm->DataList();
			foreach( $ukms as $ukm ){
				$ukm_new = new Sltg_UKM();
				$ukm_new->HasID( $ukm->id_ukm );
				$attributes[ 'ukm' ][] = $ukm_new;
			}

			$action_template = "";
			if( $get_action == "create-new" ){
				$action_template = "add";

				if( isset( $_GET[ 'status' ] )) {
					$get_status = sanitize_text_field( $_GET[ 'status' ] );
					if( $get_status == 'success' ) {
						$attributes[ 'message' ] = "Success Bro!";
					}
				}
			}
			else if( $get_action == "edit" && isset( $_GET[ 'product' ] ) && ($_GET[ 'product' ] > 0) ) {
				$get_product_id = sanitize_text_field( $_GET[ 'product' ] );

				$action_template = "edit";

				if( isset( $_GET[ 'status' ] )) {
					$get_status = sanitize_text_field( $_GET[ 'status' ] );
					if( $get_status == 'success' ) {
						$attributes[ 'message' ] = "Success Bro!";
					}
				}

				$obj = new Sltg_Product();
				$obj->HasID( $get_product_id );
				$attributes[ 'product' ] = $obj;
			}
			else if( $get_action == 'delete' && isset( $_GET[ 'product' ] ) && ( $_GET[ 'product' ] > 0 ) ) {
				$get_product_id = sanitize_text_field( $_GET[ 'product' ] );

				$action_template = 'delete';

				$obj = new Sltg_Product();
				$obj->HasID( $get_product_id );
				$attributes[ 'product' ] = $obj;
			}

			$content = $this->get_html_template( 'pages/product', $action_template, $attributes, TRUE );
			$this->get_html_template( 'pages', 'template', $content );
		}
		else {
			$obj = new Sltg_Product();
			$obj_kat = new Sltg_Kategori_Product_UKM();
			$obj_ukm = new Sltg_UKM();

			$attributes = array();
			$kats = $obj_kat->Datalist();
			foreach( $kats as $kat ) {
				$kategori = new Sltg_Kategori_Product_UKM();
				$kategori->HasID( $kat->id_kategori );
				$attributes[ 'kategori' ][] = $kategori;
			}

			$ukms = $obj_ukm->DataList();
			foreach( $ukms as $ukm ){
				$ukm_new = new Sltg_UKM();
				$ukm_new->HasID( $ukm->id_ukm );
				$attributes[ 'ukm' ][] = $ukm_new;
			}
			$content = $this->get_html_template( 'pages/product', 'main', $attributes, TRUE);
			$this->get_html_template( 'pages', 'template', $content );
		}	
	}
	// Render Personal page
	public function render_personal_page(){
		if( isset( $_GET[ 'detail' ] ) && $_GET[ 'detail' ] > 0 ) {
			$get_detail = sanitize_text_field( $_GET[ 'detail'] );
			$obj = new Sltg_Personal();

			$obj->HasID( $get_detail );
			$attributes[ 'person' ] = $obj;

			$content = $this->get_html_template( 'pages/personal', 'detail', $attributes, TRUE);
			$this->get_html_template( 'pages', 'template', $content );
		}
		else if( isset( $_GET[ 'doaction' ] ) && $_GET[ 'doaction' ] != "" ){
			$get_action = sanitize_text_field( $_GET[ 'doaction' ] );

			$obj_kat = new Sltg_Kategori_Product_UKM();
			$obj_person = new Sltg_Personal();
			
			$attributes = array();

			$persons = $obj_person->DataList();
			foreach( $persons as $p ){
				$person = new Sltg_Personal();
				$person->HasID( $p->id_personal );
				$attributes[ 'person' ][] = $person;
			}

			$action_template = "";
			if( $get_action == "create-new" ){
				$action_template = "add";

				if( isset( $_GET[ 'status' ] )) {
					$get_status = sanitize_text_field( $_GET[ 'status' ] );
					if( $get_status == 'success' ) {
						$attributes[ 'message' ] = "Success Bro!";
					}
				}
			}
			else if( $get_action == "edit" && isset( $_GET[ 'person' ] ) && ($_GET[ 'person' ] > 0) ) {
				$get_person_id = sanitize_text_field( $_GET[ 'person' ] );

				$action_template = "edit";

				if( isset( $_GET[ 'status' ] )) {
					$get_status = sanitize_text_field( $_GET[ 'status' ] );
					if( $get_status == 'success' ) {
						$attributes[ 'message' ] = "Success Bro!";
					}
				}

				$obj = new Sltg_Personal();
				$obj->HasID( $get_person_id );
				$attributes[ 'person' ] = $obj;
			}
			else if( $get_action == 'delete' && isset( $_GET[ 'person' ] ) && ( $_GET[ 'person' ] > 0 ) ) {
				$get_person_id = sanitize_text_field( $_GET[ 'person' ] );

				$action_template = 'delete';

				$obj = new Sltg_Personal();
				$obj->HasID( $get_person_id );
				$attributes[ 'person' ] = $obj;
			}

			$content = $this->get_html_template( 'pages/personal', $action_template, $attributes, TRUE );
			$this->get_html_template( 'pages', 'template', $content );
		}
		else {
			$obj = new Sltg_Personal();
			$content = $this->get_html_template( 'pages/personal', 'main', null, TRUE);
			$this->get_html_template( 'pages', 'template', $content );
		}
	}
	// Render Kategori Produk UKM page
	public function render_katprodukukm(){
		if( isset( $_GET[ 'doaction' ] ) && $_GET[ 'doaction' ] != "" ){
			$get_action = sanitize_text_field( $_GET[ 'doaction' ] );
			
			$attributes = array();

			$action_template = "";
			if( $get_action == "create-new" ){
				$action_template = "add";

				if( isset( $_GET[ 'status' ] )) {
					$get_status = sanitize_text_field( $_GET[ 'status' ] );
					if( $get_status == 'success' ) {
						$attributes[ 'message' ] = "Success Bro!";
					}
				}
			}
			else if( $get_action == "edit" && isset( $_GET[ 'katprodukukm' ] ) && ($_GET[ 'katprodukukm' ] > 0) ) {
				$get_katprodukukm_id = sanitize_text_field( $_GET[ 'katprodukukm' ] );

				$action_template = "edit";

				if( isset( $_GET[ 'status' ] )) {
					$get_status = sanitize_text_field( $_GET[ 'status' ] );
					if( $get_status == 'success' ) {
						$attributes[ 'message' ] = "Success Bro!";
					}
				}

				$obj = new Sltg_Kategori_Product_UKM();
				$obj->HasID( $get_katprodukukm_id );
				$attributes[ 'katprodukukm' ] = $obj;
			}
			else if( $get_action == 'delete' && isset( $_GET[ 'katprodukukm' ] ) && ( $_GET[ 'katprodukukm' ] > 0 ) ) {
				$get_katprodukukm_id = sanitize_text_field( $_GET[ 'katprodukukm' ] );

				$action_template = 'delete';

				$obj = new Sltg_Kategori_Product_UKM();
				$obj->HasID( $get_katprodukukm_id );
				$attributes[ 'katprodukukm' ] = $obj;
			}

			$content = $this->get_html_template( 'pages/kategori_produk_ukm', $action_template, $attributes, TRUE );
			$this->get_html_template( 'pages', 'template', $content );
		}
		else {
			$obj = new Sltg_Kategori_Product_UKM();
			$content = $this->get_html_template( 'pages/kategori_produk_ukm', 'main', null, TRUE);
			$this->get_html_template( 'pages', 'template', $content );
		}
	}
	// Render Personal page
	public function render_music_page(){
		if( isset( $_GET[ 'detail' ] ) && $_GET[ 'detail' ] > 0 ) {
			$get_detail = sanitize_text_field( $_GET[ 'detail'] );
			$obj = new Sltg_Music();

			$obj->HasID( $get_detail );
			$attributes[ 'music' ] = $obj;

			$content = $this->get_html_template( 'pages/music', 'detail', $attributes, TRUE);
			$this->get_html_template( 'pages', 'template', $content );
		}
		else if( isset( $_GET[ 'doaction' ] ) && $_GET[ 'doaction' ] != "" ){
			$get_action = sanitize_text_field( $_GET[ 'doaction' ] );

			$obj_genre = new Sltg_Genre_Music();
			$obj_person = new Sltg_Personal();
			
			$attributes = array();

			$genres = $obj_genre->Datalist();
			foreach( $genres as $g ) {
				$genre = new Sltg_Genre_Music();
				$genre->HasID( $g->id_genre );
				$attributes[ 'genre' ][] = $genre;
			}

			$persons = $obj_person->DataList();
			foreach( $persons as $p ){
				$person = new Sltg_Personal();
				$person->HasID( $p->id_personal );
				$attributes[ 'person' ][] = $person;
			}

			$action_template = "";
			if( $get_action == "create-new" ){
				$action_template = "add";

				if( isset( $_GET[ 'status' ] )) {
					$get_status = sanitize_text_field( $_GET[ 'status' ] );
					if( $get_status == 'success' ) {
						$attributes[ 'message' ] = "Success Bro!";
					}
				}
			}
			else if( $get_action == "edit" && isset( $_GET[ 'music' ] ) && ($_GET[ 'music' ] > 0) ) {
				$get_music_id = sanitize_text_field( $_GET[ 'music' ] );

				$action_template = "edit";

				if( isset( $_GET[ 'status' ] )) {
					$get_status = sanitize_text_field( $_GET[ 'status' ] );
					if( $get_status == 'success' ) {
						$attributes[ 'message' ] = "Success Bro!";
					}
				}

				$obj = new Sltg_Music();
				$obj->HasID( $get_music_id );
				$attributes[ 'music' ] = $obj;
			}
			else if( $get_action == 'delete' && isset( $_GET[ 'music' ] ) && ( $_GET[ 'music' ] > 0 ) ) {
				$get_music_id = sanitize_text_field( $_GET[ 'music' ] );

				$action_template = 'delete';

				$obj = new Sltg_Music();
				$obj->HasID( $get_music_id );
				$attributes[ 'music' ] = $obj;
			}

			$content = $this->get_html_template( 'pages/music', $action_template, $attributes, TRUE );
			$this->get_html_template( 'pages', 'template', $content );
		}
		else {
			$obj = new Sltg_Music();
			$obj_genre = new Sltg_Genre_Music();

			$attributes = array();
			$genres = $obj_genre->Datalist();
			foreach( $genres as $g ) {
				$genre = new Sltg_Genre_Music();
				$genre->HasID( $g->id_genre );
				$attributes[ 'genre' ][] = $genre;
			}
			$content = $this->get_html_template( 'pages/music', 'main', $attributes, TRUE);
			$this->get_html_template( 'pages', 'template', $content );
		}
	}

	private function get_html_template( $location, $template_name, $attributes = null , $return_val = FALSE) {
		if (! $attributes ) {
			$attributes = array();
		}
		ob_start();
		require( $location . '/' . $template_name . '.php' );
		$html = ob_get_contents();
		ob_end_clean();
		if ( $return_val )
			return $html;
		echo $html;
	}

	public function retrieve_pagination() {

		if( isset( $_GET[ 'listfor' ] ) && isset( $_GET[ 'limit' ] ) ) {

			$get_listfor = sanitize_text_field( $_GET[ 'listfor' ] );
			$get_limit = sanitize_text_field( $_GET[ 'limit' ] );
			$get_search = "";
			$get_kategori = 0;
			$get_genre = 0;
			$filter = 0;

			if( isset( $_GET[ 'category' ] ) ) {
				$get_kategori = sanitize_text_field( $_GET[ 'category' ] );
				$filter = $get_kategori;
			}
			if( isset( $_GET[ 'search' ] ) ) {
				$get_search = sanitize_text_field( $_GET[ 'search' ] );
			}
			if( isset( $_GET[ 'genre' ] ) ) {
				$get_genre = sanitize_text_field( $_GET[ 'genre' ] );
				$filter = $get_genre;
			}

			$obj = null;
			$option_limit_name = "";
			if( $get_listfor == 'personal' ){
				$obj = new Sltg_Personal();
				$attributes[ 'listfor' ] = 'personal';
				$option_limit_name = "personal_list_limit";
			}
			else if( $get_listfor == 'product' ) {
				$obj = new Sltg_Product();
				$attributes[ 'listfor' ] = 'product';
				$option_limit_name = "product_list_limit";
			}
			else if( $get_listfor == 'ukm' ) {
				//require( 'models/ukm.php');
				$obj = new Sltg_UKM();
				$attributes[ 'listfor' ] = 'ukm';
				$option_limit_name = "ukm_list_limit";
			}
			else if( $get_listfor == 'katprodukukm' ) {
				$obj = new Sltg_Kategori_Product_UKM();
				$attributes[ 'listfor' ] = 'katprodukukm';
				$option_limit_name = "katprodukukm_list_limit";
			}
			else if( $get_listfor == 'music' ) {
				$obj = new Sltg_Music();
				$attributes[ 'listfor' ] = 'music';
				$option_limit_name = "music_list_limit";
			}
			else if( $get_listfor == 'genre' ) {
				$obj = new Sltg_Genre_Music();
				$attributes[ 'listfor' ] = 'genre';
				$option_limit_name = "genre_list_limit";
			}
			update_option( $option_limit_name, $get_limit );

			$attributes[ 'n-page' ] = $this->create_pagination( $obj, $get_limit, $get_search, $filter );

			echo $this->get_html_template( 'pages', 'pagination' , $attributes, FALSE );

		}
		wp_die();
	}

	private function create_pagination( $obj, /*$limit_opt,*/ $limit, $search = "", $kategori = 0 ) {

		$jumlah_data = $obj->CountData( $search, $kategori );
		//update_option( $limit_opt, $limit );
		$jumlah_page = intval( $jumlah_data / $limit );
		if( $jumlah_data % $limit > 0 ) $jumlah_page += 1;
		//var_dump($limit_opt, $limit, $jumlah_data, $jumlah_page);die;
		return $jumlah_page;
	}

	public function retrieve_list(){
		
		if( isset( $_GET[ 'listfor' ] ) && isset( $_GET[ 'page' ] ) && isset( $_GET[ 'limit' ] ) ) {
			
			$n_get = count( $_GET );
			$get_listfor = sanitize_text_field( $_GET[ 'listfor' ] );
			$get_limit = sanitize_text_field( $_GET[ 'limit' ] );
			$get_page = sanitize_text_field( $_GET[ 'page' ] );
			$get_search = "";
			$get_kategori = 0;
			$get_genre = 0;
			$filter = 0;

			if( isset( $_GET[ 'category' ] ) ) {
				$get_kategori = sanitize_text_field( $_GET[ 'category' ] );
				$filter = $get_kategori;
			}
			if( isset( $_GET[ 'search' ] ) ) {
				$get_search = sanitize_text_field( $_GET[ 'search' ] );
			}
			if( isset( $_GET[ 'genre' ] ) ) {
				$get_genre = sanitize_text_field( $_GET[ 'genre' ] );
				$filter = $get_genre;
			}

			$offset = ( $get_page - 1 ) * $get_limit;
			$obj = null;
			$dir_obj = "";

			if( $get_listfor == 'personal' ) {
				//require( 'models/personal.php' );
				$obj = new Sltg_Personal();
				$dir_obj = "personal";
			}
			else if( $get_listfor == 'product' ) {
				//require( 'models/product.php' );
				$obj = new Sltg_Product();
				$dir_obj = "product";
			}
			else if( $get_listfor == 'ukm' ) {
				//require( 'models/ukm.php' );
				$obj = new Sltg_UKM();
				$dir_obj = "ukm";
			}
			else if( $get_listfor == 'katprodukukm' ) {
				//require( 'models/ukm.php' );
				$obj = new Sltg_Kategori_Product_UKM();
				$dir_obj = "kategori_produk_ukm";
			}
			else if( $get_listfor == 'music' ) {
				//require( 'models/ukm.php' );
				$obj = new Sltg_Music();
				$dir_obj = "music";
			}
			else if( $get_listfor == 'genre' ) {
				//require( 'models/ukm.php' );
				$obj = new Sltg_Genre_Music();
				$dir_obj = "genre";
			}

			$rows = $obj->DataList( $get_limit, $offset, $get_search, $filter );

			$arrObj = array();

			foreach( $rows as $row ){
				if( $get_listfor == 'personal' ){
					$personal = new Sltg_Personal();
					$personal->HasID( $row->id_personal );
					$arrObj['personal'][] = $personal;
				}
				else if( $get_listfor == 'product' ){
					$product = new Sltg_Product();
					$product->HasID( $row->id_produk );
					$arrObj['product'][] = $product;
				}
				else if( $get_listfor == 'ukm' ){
					$ukm = new Sltg_UKM();
					$ukm->HasID( $row->id_ukm );
					$arrObj['ukm'][] = $ukm;
				}
				else if( $get_listfor == 'katprodukukm' ){
					$katprodukukm = new Sltg_Kategori_Product_UKM();
					$katprodukukm->HasID( $row->id_kategori );
					$arrObj['katprodukukm'][] = $katprodukukm;
				}
				else if( $get_listfor == 'music' ){
					$music = new Sltg_Music();
					$music->HasID( $row->id_music );
					$arrObj['music'][] = $music;
				}
				else if( $get_listfor == 'genre' ){
					$genre = new Sltg_Genre_Music();
					$genre->HasID( $row->id_genre );
					$arrObj['genre'][] = $genre;
				}
			}
			//var_dump( $arrObj );
			$this->get_html_template( 'pages/' . $dir_obj, 'list', $arrObj , false);
		}
		wp_die();
	}

	public function test( $times ) {
		print str_repeat( ' foo ', (int) $times );
		//wp_die();
	}

	public function create_product() {
		$result = array( 'status' => false, 'message' => '' );
		$post_isset = isset( $_POST[ 'nama' ] ) && isset( $_POST[ 'deskripsi' ] ) && isset( $_POST[ 'infolain' ] ) &&
			isset( $_POST[ 'kategori' ] ) && isset( $_POST[ 'kreator' ] ) && isset( $_POST[ 'gambararr' ] );
		if( $post_isset ) {
			$post_nama = sanitize_text_field( $_POST[ 'nama' ] );
			$post_deskripsi = sanitize_text_field( $_POST[ 'deskripsi' ] );
			$post_infolain = sanitize_text_field( $_POST[ 'infolain' ] );
			$post_kategori = sanitize_text_field( $_POST[ 'kategori' ] );
			$post_kreator = sanitize_text_field( $_POST[ 'kreator' ] );
			$post_gambararr = $_POST[ 'gambararr' ] ;

			$is_new_kategori = (! is_numeric( $post_kategori ) );
			$valid_kategori = $this->validate_kategori( $is_new_kategori, $post_kategori );

			$post_not_empty = ($post_nama!="") && ($valid_kategori) && ($post_kreator>0) && (sizeof($post_gambararr)>0);

			if( $post_not_empty ) {
				if( $is_new_kategori ) {
					$result_add = $this->add_kategori( $post_kategori );
					$post_kategori = $result_add[ 'new_id' ];
				}
				$product = new Sltg_Product();
				$product->SetNama( $post_nama );
				$product->SetDeskripsi( $post_deskripsi );
				$product->SetOther( $post_infolain );
				$product->SetKategori( $post_kategori );
				$product->SetProducer( $post_kreator );

				$result = $product->AddNew();
				$newProduct = new Sltg_Product();
				$newProduct->HasID( $result[ 'new_id' ] );
				$this->add_picture( 'produk', $newProduct->GetPictCode(), $post_gambararr );
			}
			else {
				$result[ 'message' ] = 'parameter tidak valid!';
			}
		}
		else {
			$result[ 'message' ] = 'parameter tidak lengkap!';
		}

		echo wp_json_encode( $result );

		wp_die();
	}

	public function update_product() {
		$result = array( 'status' => false, 'message' => '' );
		$post_isset = isset( $_POST[ 'product' ] ) && isset( $_POST[ 'nama' ] ) && isset( $_POST[ 'deskripsi' ] ) && isset( $_POST[ 'infolain' ] ) &&
			isset( $_POST[ 'kategori' ] ) && isset( $_POST[ 'kreator' ] ) && isset( $_POST[ 'gambararr' ] );
		
		if( $post_isset ) {
			$post_product_id = sanitize_text_field( $_POST[ 'product' ] );
			$post_nama = sanitize_text_field( $_POST[ 'nama' ] );
			$post_deskripsi = sanitize_text_field( $_POST[ 'deskripsi' ] );
			$post_infolain = sanitize_text_field( $_POST[ 'infolain' ] );
			$post_kategori = sanitize_text_field( $_POST[ 'kategori' ] );
			$post_kreator = sanitize_text_field( $_POST[ 'kreator' ] );
			$post_gambararr = $_POST[ 'gambararr' ] ;

			$is_new_kategori = (! is_numeric( $post_kategori ) );
			$valid_kategori = $this->validate_kategori( $is_new_kategori, $post_kategori );

			$post_not_empty = ($post_product_id > 0) && ($post_nama!="") && ($valid_kategori) && ($post_kreator>0) && (sizeof($post_gambararr)>0);

			if( $post_not_empty ) {
				if( $is_new_kategori ) {
					$result_add = $this->add_kategori( $post_kategori );
					$post_kategori = $result_add[ 'new_id' ];
				}
				$product = new Sltg_Product();
				$product->HasID( $post_product_id );

				// compare data
				$oldData = array(
					$product->GetNama(), // nama produk
					$product->GetDeskripsi(), // deskripsi
					$product->GetOther(), // other
					$product->GetKategori()->GetID(), // kategori
					$product->GetProducer()->GetID() // ukm
					);
				$newData = array(
					$post_nama, // nama produk
					$post_deskripsi, // deskripsi
					$post_infolain, // other
					$post_kategori, // kategori,
					$post_kreator // ukm
					);

				// compare Picture
				$arrOldPict = $product->GetGambars();

				$arrAddedPict = array();
				$arrAddedPictId = array();
				$utamaInNew = false;
				$selectedUtama = 0;
				foreach( $post_gambararr as $newPict) {
					$isNew = true;
					foreach( $arrOldPict as $oldPict) {
						if( $newPict['post_id'] == $oldPict->GetPostId() ) {
							$isNew = false;
							break;
						}
					}
					$arrAddedPict[] = $isNew;
					if( $newPict[ 'utama'] == 1) $selectedUtama = $newPict['post_id'];
					if( $isNew ) {
						$arrAddedPictId[] = $newPict;
						if( $newPict['utama'] == 1){
							$utamaInNew = true;
						}
					}
				}

				// get deleted picture
				$arrDelPict = array();
				$arrDelPictId = array();
				$utamaInDel = false;
				foreach( $arrOldPict as $oldPict) {
					$isDel = true;
					foreach( $post_gambararr as $newPict) {
						if( $oldPict->GetPostId() == $newPict['post_id'] ) {
							$isDel = false;
							break;
						}
					}
					$arrDelPict[] = $isDel;
					if( $isDel ) {
						$arrDelPictId[] = $oldPict;
						if( $oldPict->GetPostId() == 1){
							$utamaInDel = true;
						}
					}
				}

				// var_dump( "select utama: ". $selectedUtama );

				if( !$utamaInNew && !$utamaInDel ) {
					// update gambar utama
					foreach ( $arrOldPict as $oldPict ) {
						if( $oldPict->GetPostId() == $selectedUtama && $oldPict->GetGambarUtama() == 0) {
							$result = $oldPict->SetAsGambarUtama();
							break;
						}
					}
				}

				// delete old picture
				if ( sizeof( $arrDelPictId ) > 0 ) {
					foreach( $arrDelPictId as $delGbr ) {
						$result = $delGbr->Delete();
					}
				}

				// add new picture
				if( sizeof( $arrAddedPictId ) > 0 ) {
					if( $utamaInNew ) {
						$temp_gbr = new Sltg_Gambar();
						$temp_gbr->SetOwner( $product->GetPictCode() );
						$temp_gbr->ClearSelectedUtama();
					}
					$result = $this->add_picture( 'produk', $product->GetPictCode(), $arrAddedPictId );
				}

				if ( $oldData !== $newData ) {
					$product->SetNama( $post_nama );
					$product->SetDeskripsi( $post_deskripsi );
					$product->SetOther( $post_infolain );
					$product->SetKategori( $post_kategori );
					$product->SetProducer( $post_kreator );
					$result = $product->Update();
				}
			}
			else {
				$result[ 'message' ] = 'parameter tidak valid!';
			}
		}
		else {
			$result[ 'message' ] = 'parameter tidak lengkap!';
		}

		echo wp_json_encode( $result );

		wp_die();
	}

	private function add_picture( $type_pict, $pict_code, $pictureArr ) {
		$result = array();
		/*if ( $type_pict == "produk" ){
			$table = "ext_gambar_produk";
		}*/

		$gambar = new Sltg_Gambar();
		// if ( $type_pict == "produk" ){
			$gambar->SetOwner( $pict_code );
			//$gambar_utama = 1;
			for( $i = 0; $i < sizeof( $pictureArr ); $i++) {
				//$gambar->SetGambarUtama( $gambar_utama );
				$gambar->SetGambarUtama( $pictureArr[ $i ][ 'utama' ] );
				$gambar->SetLinkGambar( $pictureArr[ $i ][ 'url' ] );
				$gambar->SetDeskripsi( "" );
				$gambar->SetPostId( $pictureArr[ $i ][ 'post_id' ] );
				$result = $gambar->AddNew();
				/*$gambar_utama = 0;*/
			}
		// }
		// else if ( $type_pict == "ukm" ){
		// 	$gambar->SetOwner( $pict_code );
		// 	//$gambar_utama = 1;
		// 	for( $i = 0; $i < sizeof( $pictureArr ); $i++) {
		// 		//$gambar->SetGambarUtama( $gambar_utama );
		// 		$gambar->SetGambarUtama( $pictureArr[ $i ][ 'utama' ] );
		// 		$gambar->SetLinkGambar( $pictureArr[ $i ][ 'url' ] );
		// 		$gambar->SetDeskripsi( "" );
		// 		$gambar->SetPostId( $pictureArr[ $i ][ 'post_id' ] );
		// 		$result = $gambar->AddNew();
		// 		/*$gambar_utama = 0;*/
		// 	}
		// }

		return $result;
	}

	private function add_kategori( $kategori_name ) {
		$kategori = new Sltg_Kategori_Product_UKM();

		$kategori->SetNama( $kategori_name );


		if( ! $kategori->FindName() )
			$result = $kategori->AddNew();
		else
			$result[ 'new_id' ] = $kategori->GetID();
		return $result;
	}

	private function add_genre( $genre_name ) {
		$genre = new Sltg_Genre_Music();

		$genre->SetNama( $genre_name );


		if( ! $genre->FindName() )
			$result = $genre->AddNew();
		else
			$result[ 'new_id' ] = $genre->GetID();
		return $result;
	}

	private function validate_kategori( $is_new_kategori, $kategori ) {
		return ( ( $is_new_kategori && $kategori != "" ) || (!$is_new_kategori && $kategori>0) );
	}

	private function validate_genre( $is_new_genre, $genre ) {
		return ( ( $is_new_genre && $genre != "" ) || (!$is_new_genre && $genre>0) );
	}

	public function add_meta_box() {

	}

	private function TESTFROMPLUGIN() {
		_e( "HELLO BRO");
	}

	function delete_post_attachments($post_id) {
	    global $wpdb;
	 
	    $sql = "SELECT ID FROM {$wpdb->posts} ";
	    $sql .= " WHERE post_parent = $post_id ";
	    $sql .= " AND post_type = 'attachment'";
	 
	    $ids = $wpdb->get_col($sql);
	 
	    foreach ( $ids as $id ) {
	        wp_delete_attachment($id);
	    }
	}

	public function create_ukm() {
		$result = array( 'status' => false, 'message' => '' );
		$post_isset = isset( $_POST[ 'nama' ] ) && isset( $_POST[ 'deskripsi' ] ) && isset( $_POST[ 'infolain' ] ) &&
			isset( $_POST[ 'alamat' ] ) && isset( $_POST[ 'telp' ] ) && isset( $_POST[ 'founder' ] ) && isset( $_POST[ 'gambararr' ] );
		// var_dump($_POST);
		if( $post_isset ) {
			$post_nama = sanitize_text_field( $_POST[ 'nama' ] );
			$post_deskripsi = sanitize_text_field( $_POST[ 'deskripsi' ] );
			$post_infolain = sanitize_text_field( $_POST[ 'infolain' ] );
			$post_alamat = sanitize_text_field( $_POST[ 'alamat' ] );
			$post_telp = sanitize_text_field( $_POST[ 'telp' ] );
			$post_founder = sanitize_text_field( $_POST[ 'founder' ] );
			$post_gambararr = $_POST[ 'gambararr' ] ;

			$post_not_empty = ($post_nama!="") && ($post_alamat!="") && ($post_founder>0) && (sizeof($post_gambararr)>0);

			if( $post_not_empty ) {
				$ukm = new Sltg_UKM();
				$ukm->SetNama( $post_nama );
				$ukm->SetAlamat( $post_alamat );
				$ukm->SetTelp( $post_telp );
				$ukm->SetDeskripsi( $post_deskripsi );
				$ukm->SetOther( $post_infolain );
				$ukm->SetPemilik( $post_founder );

				$result = $ukm->AddNew();
				$newUKM = new Sltg_UKM();
				$newUKM->HasID( $result[ 'new_id' ] );

				$this->add_picture( 'ukm', $newUKM->GetPictCode(), $post_gambararr );
			}
			else {
				$result[ 'message' ] = 'parameter tidak valid!';
			}
		}
		else {
			$result[ 'message' ] = 'parameter tidak lengkap!';
		}

		echo wp_json_encode( $result );

		wp_die();
	}

	public function update_ukm() {
		$result = array( 'status' => false, 'message' => '' );
		$post_isset = isset( $_POST[ 'ukm' ] ) && isset( $_POST[ 'nama' ] ) && isset( $_POST[ 'deskripsi' ] ) && isset( $_POST[ 'infolain' ] ) &&
			isset( $_POST[ 'alamat' ] ) && isset( $_POST[ 'telp' ] ) && isset( $_POST[ 'founder' ] ) && isset( $_POST[ 'gambararr' ] );
		
		//var_dump($_POST);
		if( $post_isset ) {
			$post_ukm_id = sanitize_text_field( $_POST[ 'ukm' ] );
			$post_nama = sanitize_text_field( $_POST[ 'nama' ] );
			$post_deskripsi = sanitize_text_field( $_POST[ 'deskripsi' ] );
			$post_infolain = sanitize_text_field( $_POST[ 'infolain' ] );
			$post_alamat = sanitize_text_field( $_POST[ 'alamat' ] );
			$post_telp = sanitize_text_field( $_POST[ 'telp' ] );
			$post_founder = sanitize_text_field( $_POST[ 'founder' ] );
			$post_gambararr = $_POST[ 'gambararr' ] ;
			//var_dump($post_gambararr[0]['fname']);die;
			//print_r($post_gambararr);


			$post_not_empty = ($post_ukm_id > 0) && ($post_nama!="") && ($post_alamat!="") && ($post_founder>0) && (sizeof($post_gambararr)>0);

			if( $post_not_empty ) {
				
				$ukm = new Sltg_UKM();
				$ukm->HasID( $post_ukm_id );

				// compare data
				$oldData = array(
					$ukm->GetNama(), // nama 
					$ukm->GetDeskripsi(), // deskripsi
					$ukm->GetOther(), // other
					$ukm->GetAlamat(), // alamat
					$ukm->GetTelp(), // telp
					$ukm->GetPemilik()->GetID() // pemilik
					);
				$newData = array(
					$post_nama, // nama 
					$post_deskripsi, // deskripsi
					$post_infolain, // other
					$post_alamat, // alamat,
					$post_telp, // telp
					$post_founder // pemilik
					);

				// compare Picture
				$arrOldPict = $ukm->GetGambars();
				//$sameSize = ( sizeof( $arrOldPict ) == sizeof( $post_gambararr ) );
				// if( $sameSize ) {
					// get added Picture
				$arrAddedPict = array();
				$arrAddedPictId = array();
				$utamaInNew = false;
				$selectedUtama = 0;
				foreach( $post_gambararr as $newPict) {
					$isNew = true;
					foreach( $arrOldPict as $oldPict) {
						if( $newPict['post_id'] == $oldPict->GetPostId() ) {
							$isNew = false;
							break;
						}
					}
					$arrAddedPict[] = $isNew;
					if( $newPict[ 'utama'] == 1) $selectedUtama = $newPict['post_id'];
					if( $isNew ) {
						$arrAddedPictId[] = $newPict;
						if( $newPict['utama'] == 1){
							$utamaInNew = true;
						}
					}
				}

				// get deleted picture
				$arrDelPict = array();
				$arrDelPictId = array();
				$utamaInDel = false;
				foreach( $arrOldPict as $oldPict) {
					$isDel = true;
					foreach( $post_gambararr as $newPict) {
						if( $oldPict->GetPostId() == $newPict['post_id'] ) {
							$isDel = false;
							break;
						}
					}
					$arrDelPict[] = $isDel;
					if( $isDel ) {
						$arrDelPictId[] = $oldPict;
						if( $oldPict->GetPostId() == 1){
							$utamaInDel = true;
						}
					}
				}

				if( !$utamaInNew && !$utamaInDel ) {
					// update gambar utama
					foreach ( $arrOldPict as $oldPict ) {
						if( $oldPict->GetPostId() == $selectedUtama && $oldPict->GetGambarUtama() == 0) {
							$result = $oldPict->SetAsGambarUtama();
							break;
						}
					}
				}

				// delete old picture
				if ( sizeof( $arrDelPictId ) > 0 ) {
					foreach( $arrDelPictId as $delGbr ) {
						$result = $delGbr->Delete();
					}
				}

				// add new picture
				if( sizeof( $arrAddedPictId ) > 0 ) {
					if( $utamaInNew ) {
						$temp_gbr = new Sltg_Gambar();
						$temp_gbr->SetOwner( $ukm->GetPictCode() );
						$temp_gbr->ClearSelectedUtama();
					}
					$result = $this->add_picture( 'ukm', $ukm->GetPictCode(), $arrAddedPictId );
				}

				if ( $oldData !== $newData ) {
					$ukm->SetNama( $post_nama );
					$ukm->SetDeskripsi( $post_deskripsi );
					$ukm->SetOther( $post_infolain );
					$ukm->SetAlamat( $post_alamat );
					$ukm->SetTelp( $post_telp );
					$ukm->SetPemilik( $post_founder );
					$result = $ukm->Update();
				}
			}
			else {
				$result[ 'message' ] = 'parameter tidak valid!';
			}
		}
		else {
			$result[ 'message' ] = 'parameter tidak lengkap!';
		}

		echo wp_json_encode( $result );

		wp_die();
	}

	public function create_person() {
		$result = array( 'status' => false, 'message' => '' );
		$post_isset = isset( $_POST[ 'nama' ] ) && isset( $_POST[ 'deskripsi' ] ) && isset( $_POST[ 'infolain' ] ) &&
			isset( $_POST[ 'alamat' ] ) && isset( $_POST[ 'telp' ] ) && isset( $_POST[ 'gambararr' ] );
		// var_dump($_POST);
		if( $post_isset ) {
			$post_nama = sanitize_text_field( $_POST[ 'nama' ] );
			$post_alamat = sanitize_text_field( $_POST[ 'alamat' ] );
			$post_deskripsi = sanitize_text_field( $_POST[ 'deskripsi' ] );
			$post_telp = sanitize_text_field( $_POST[ 'telp' ] );
			$post_infolain = sanitize_text_field( $_POST[ 'infolain' ] );
			$post_gambararr = $_POST[ 'gambararr' ] ;

			$post_not_empty = ($post_nama!="") && (sizeof($post_gambararr)>0);

			if( $post_not_empty ) {
				$person = new Sltg_Personal();
				$person->SetNama( $post_nama );
				$person->SetAlamat( $post_alamat );
				$person->SetTelp( $post_telp );
				$person->SetDeskripsi( $post_deskripsi );
				$person->SetOther( $post_infolain );

				$result = $person->AddNew();
				$newPersonal = new Sltg_Personal();
				$newPersonal->HasID( $result[ 'new_id' ] );

				$this->add_picture( 'personal', $newPersonal->GetPictCode(), $post_gambararr );
			}
			else {
				$result[ 'message' ] = 'parameter tidak valid!';
			}
		}
		else {
			$result[ 'message' ] = 'parameter tidak lengkap!';
		}

		echo wp_json_encode( $result );

		wp_die();
	}

	public function update_person() {
		$result = array( 'status' => false, 'message' => '' );
		$post_isset = isset( $_POST[ 'person' ] ) && isset( $_POST[ 'nama' ] ) && isset( $_POST[ 'deskripsi' ] ) && isset( $_POST[ 'infolain' ] ) &&
			isset( $_POST[ 'alamat' ] ) && isset( $_POST[ 'telp' ] ) && isset( $_POST[ 'gambararr' ] );
		
		//var_dump($_POST);
		if( $post_isset ) {
			$post_person_id = sanitize_text_field( $_POST[ 'person' ] );
			$post_nama = sanitize_text_field( $_POST[ 'nama' ] );
			$post_alamat = sanitize_text_field( $_POST[ 'alamat' ] );
			$post_deskripsi = sanitize_text_field( $_POST[ 'deskripsi' ] );
			$post_telp = sanitize_text_field( $_POST[ 'telp' ] );
			$post_infolain = sanitize_text_field( $_POST[ 'infolain' ] );
			$post_gambararr = $_POST[ 'gambararr' ] ;
			//var_dump($post_gambararr[0]['fname']);die;
			//print_r($post_gambararr);


			$post_not_empty = ($post_person_id>0) && ($post_nama!="") && (sizeof($post_gambararr)>0);

			if( $post_not_empty ) {
				
				$person = new Sltg_Personal();
				$person->HasID( $post_person_id );

				// compare data
				$oldData = array(
					$person->GetNama(), // nama 
					$person->GetDeskripsi(), // deskripsi
					$person->GetOther(), // other
					$person->GetAlamat(), // alamat
					$person->GetTelp() // telp
					);
				$newData = array(
					$post_nama, // nama 
					$post_deskripsi, // deskripsi
					$post_infolain, // other
					$post_alamat, // alamat,
					$post_telp // telp
					);

				// compare Picture
				$arrOldPict = $person->GetGambars();
				//$sameSize = ( sizeof( $arrOldPict ) == sizeof( $post_gambararr ) );
				// if( $sameSize ) {
					// get added Picture
				$arrAddedPict = array();
				$arrAddedPictId = array();
				$utamaInNew = false;
				$selectedUtama = 0;
				foreach( $post_gambararr as $newPict) {
					$isNew = true;
					foreach( $arrOldPict as $oldPict) {
						if( $newPict['post_id'] == $oldPict->GetPostId() ) {
							$isNew = false;
							break;
						}
					}
					$arrAddedPict[] = $isNew;
					if( $newPict[ 'utama'] == 1) $selectedUtama = $newPict['post_id'];
					if( $isNew ) {
						$arrAddedPictId[] = $newPict;
						if( $newPict['utama'] == 1){
							$utamaInNew = true;
						}
					}
				}

				// get deleted picture
				$arrDelPict = array();
				$arrDelPictId = array();
				$utamaInDel = false;
				foreach( $arrOldPict as $oldPict) {
					$isDel = true;
					foreach( $post_gambararr as $newPict) {
						if( $oldPict->GetPostId() == $newPict['post_id'] ) {
							$isDel = false;
							break;
						}
					}
					$arrDelPict[] = $isDel;
					if( $isDel ) {
						$arrDelPictId[] = $oldPict;
						if( $oldPict->GetPostId() == 1){
							$utamaInDel = true;
						}
					}
				}

				if( !$utamaInNew && !$utamaInDel ) {
					// update gambar utama
					foreach ( $arrOldPict as $oldPict ) {
						if( $oldPict->GetPostId() == $selectedUtama && $oldPict->GetGambarUtama() == 0) {
							$result = $oldPict->SetAsGambarUtama();
							break;
						}
					}
				}

				// delete old picture
				if ( sizeof( $arrDelPictId ) > 0 ) {
					foreach( $arrDelPictId as $delGbr ) {
						$result = $delGbr->Delete();
					}
				}

				// add new picture
				if( sizeof( $arrAddedPictId ) > 0 ) {
					if( $utamaInNew ) {
						$temp_gbr = new Sltg_Gambar();
						$temp_gbr->SetOwner( $person->GetPictCode() );
						$temp_gbr->ClearSelectedUtama();
					}
					$result = $this->add_picture( 'person', $person->GetPictCode(), $arrAddedPictId );
				}

				if ( $oldData !== $newData ) {
					$person->SetNama( $post_nama );
					$person->SetDeskripsi( $post_deskripsi );
					$person->SetOther( $post_infolain );
					$person->SetAlamat( $post_alamat );
					$person->SetTelp( $post_telp );
					$result = $person->Update();
				}
			}
			else {
				$result[ 'message' ] = 'parameter tidak valid!';
			}
		}
		else {
			$result[ 'message' ] = 'parameter tidak lengkap!';
		}

		echo wp_json_encode( $result );

		wp_die();
	}

	public function create_music() {
		$result = array( 'status' => false, 'message' => '' );
		$post_isset = isset( $_POST[ 'title' ] ) && isset( $_POST[ 'source' ] ) && isset( $_POST[ 'deskripsi' ] ) &&
			isset( $_POST[ 'genre' ] ) && isset( $_POST[ 'creator' ] );
		
		//var_dump($_POST);
		
		if( $post_isset ) {
			$post_title = sanitize_text_field( $_POST[ 'title' ] );
			$post_source = sanitize_text_field( $_POST[ 'source' ] );
			$post_deskripsi = sanitize_text_field( $_POST[ 'deskripsi' ] );
			$post_genre = sanitize_text_field( $_POST[ 'genre' ] );
			$post_creator = sanitize_text_field( $_POST[ 'creator' ] );

			$is_new_genre = (! is_numeric( $post_genre ) );
			$valid_genre = $this->validate_genre( $is_new_genre, $post_genre );

			$post_not_empty = ($post_title!="") && ($post_source!="") && ($valid_genre) && ($post_creator>0);

			if( $post_not_empty ) {
				$music = new Sltg_Music();
				$music->SetTitle( $post_title );
				$music->SetSource( $post_source );
				$music->SetInfo( $post_deskripsi );
				$music->SetGenre( $post_genre );
				$music->SetCreator( $post_creator );

				$result = $music->AddNew();
			}
			else {
				$result[ 'message' ] = 'parameter tidak valid!';
			}
		}
		else {
			$result[ 'message' ] = 'parameter tidak lengkap!';
		}

		echo wp_json_encode( $result );

		wp_die();
	}

	public function update_music() {
		$result = array( 'status' => false, 'message' => '' );
		$post_isset = isset( $_POST[ 'music' ] ) && isset( $_POST[ 'title' ] ) && isset( $_POST[ 'source' ] ) && isset( $_POST[ 'deskripsi' ] ) &&
			isset( $_POST[ 'genre' ] ) && isset( $_POST[ 'creator' ] );

		//var_dump($_POST);
		if( $post_isset ) {
			$post_music_id = sanitize_text_field( $_POST[ 'music' ] );
			$post_title = sanitize_text_field( $_POST[ 'title' ] );
			$post_source = sanitize_text_field( $_POST[ 'source' ] );
			$post_deskripsi = sanitize_text_field( $_POST[ 'deskripsi' ] );
			$post_genre = sanitize_text_field( $_POST[ 'genre' ] );
			$post_creator = sanitize_text_field( $_POST[ 'creator' ] );

			$is_new_genre = (! is_numeric( $post_genre ) );
			$valid_genre = $this->validate_genre( $is_new_genre, $post_genre );

			$post_not_empty = ($post_music_id>0) && ($post_title!="") && ($post_source!="") && ($valid_genre) && ($post_creator>0);

			if( $post_not_empty ) {
				if( $is_new_genre ) {
					$result_add = $this->add_genre( $post_genre );
					$post_genre = $result_add[ 'new_id' ];
				}
				$music = new Sltg_Music();
				$music->HasID( $post_music_id );

				// compare data
				$oldData = array(
					$music->GetTitle(), // title 
					$music->GetSource(), // source
					$music->GetInfo(), // info
					$music->GetGenre()->GetID(), // genre
					$music->GetCreator()->GetID() // creator
					);
				$newData = array(
					$post_title, // title 
					$post_source, // source
					$post_deskripsi, // info
					$post_genre, // genre,
					$post_creator // creator
					);

				if ( $oldData !== $newData ) {
					$music->SetTitle( $post_title );
					$music->SetSource( $post_source );
					$music->SetInfo( $post_deskripsi );
					$music->SetGenre( $post_genre );
					$music->SetCreator( $post_creator );
					$result = $music->Update();
				}
			}
			else {
				$result[ 'message' ] = 'parameter tidak valid!';
			}
		}
		else {
			$result[ 'message' ] = 'parameter tidak lengkap!';
		}

		echo wp_json_encode( $result );

		wp_die();
	}
	// Render Genre
	public function render_genre_page(){
		if( isset( $_GET[ 'doaction' ] ) && $_GET[ 'doaction' ] != "" ){
			$get_action = sanitize_text_field( $_GET[ 'doaction' ] );
			
			$attributes = array();

			$action_template = "";
			if( $get_action == "create-new" ){
				$action_template = "add";

				if( isset( $_GET[ 'status' ] )) {
					$get_status = sanitize_text_field( $_GET[ 'status' ] );
					if( $get_status == 'success' ) {
						$attributes[ 'message' ] = "Success Bro!";
					}
				}
			}
			else if( $get_action == "edit" && isset( $_GET[ 'genre' ] ) && ($_GET[ 'genre' ] > 0) ) {
				$get_genre_id = sanitize_text_field( $_GET[ 'genre' ] );

				$action_template = "edit";

				if( isset( $_GET[ 'status' ] )) {
					$get_status = sanitize_text_field( $_GET[ 'status' ] );
					if( $get_status == 'success' ) {
						$attributes[ 'message' ] = "Success Bro!";
					}
				}

				$obj = new Sltg_Genre_Music();
				$obj->HasID( $get_genre_id );
				$attributes[ 'genre' ] = $obj;
			}
			else if( $get_action == 'delete' && isset( $_GET[ 'genre' ] ) && ( $_GET[ 'genre' ] > 0 ) ) {
				$get_genre_id = sanitize_text_field( $_GET[ 'genre' ] );

				$action_template = 'delete';

				$obj = new Sltg_Genre_Music();
				$obj->HasID( $get_genre_id );
				$attributes[ 'genre' ] = $obj;
			}

			$content = $this->get_html_template( 'pages/genre', $action_template, $attributes, TRUE );
			$this->get_html_template( 'pages', 'template', $content );
		}
		else {
			$obj = new Sltg_Genre_Music();
			$content = $this->get_html_template( 'pages/genre', 'main', null, TRUE);
			$this->get_html_template( 'pages', 'template', $content );
		}
	}
}