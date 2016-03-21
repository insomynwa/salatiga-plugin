<?php
/*
Plugin Name: Salatiga
Version: 1.0
Author: Fika Ariyanto
Description: Plugin untuk Salatiga
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'controllers/class-salatiga-plugin-controller.php';

require_once plugin_dir_path( __FILE__ ) . 'includes/class-salatiga-plugin.php';

function run_salatiga_plugin() {
	$sp = new Salatiga_Plugin();
	$sp->run();

	$spc = new Salatiga_Plugin_Controller();
}

run_salatiga_plugin();

// class Salatiga_Plugins{

// 	public function __construct(){
// 		// create menu for admin
// 		add_action( 'admin_menu', array( $this, 'create_menu_admin') );
// 		add_action( 'admin_enqueue_scripts', array( $this, 'register_sltg_scripts') );

// 		add_action( 'wp_ajax_RetrievePagination', array( $this, 'retrieve_pagination' ) );
// 		add_action( 'wp_ajax_RetrieveList', array( $this, 'retrieve_list' ) );
// 		add_action( 'wp_ajax_SearchFor', array( $this, 'retrieve_list' ) );
// 		add_action( 'wp_ajax_RetrievePaginationTemplate', array( $this, 'test' ) );
// 	}

// 	public static function plugin_activated(){

// 	}

// 	public function create_menu_admin(){
// 		// Main Menu
// 		add_menu_page(
// 			'SALATIGA',
// 			'SALATIGA',
// 			'manage_options',
// 			'sltg-main-page',
// 			array( $this, 'render_main_page'),
// 			'',
// 			3
// 			);

// 		// Sub Menu
// 		// UKM
// 		add_submenu_page(
// 			null,
// 			'UKM',
// 			'UKM',
// 			'manage_options',
// 			'sltg-ukm',
// 			array( $this, 'render_ukm_page' )
// 			);
// 		// PRODUCT
// 		add_submenu_page(
// 			null,
// 			'Product',
// 			'Product',
// 			'manage_options',
// 			'sltg-product',
// 			array( $this, 'render_product_page' )
// 			);
// 		// PERSONAL
// 		add_submenu_page(
// 			null,
// 			'Founder/Creator',
// 			'Founder/Creator',
// 			'manage_options',
// 			'sltg-personal',
// 			array( $this, 'render_personal_page' )
// 			);
// 	}

// 	public function register_sltg_scripts(){
// 		wp_enqueue_media();

// 		//wp_register_script( 'sltg-jquery', plugin_dir_url( __FILE__ ) . 'styles/jquery-1.12.1.min.js' );
// 		wp_register_script( 'sltg-script', plugin_dir_url( __FILE__ ) . 'js/sltg-script.js' );
// 		wp_register_script( 'jquery-ui-script', plugin_dir_url( __FILE__ ) . 'styles/jquery-ui.min.js' );
// 		wp_register_script( 'bootstrap-js', plugin_dir_url( __FILE__ ) . '/styles/bootstrap.min.js' );
// 		//wp_register_script( 'sltg-jquery-script', plugin_dir_url( __FILE__ ) . 'styles/external/jquery/jquery.js' );
// 		wp_register_style( 'jquery-min-style', plugin_dir_url( __FILE__ ) . 'styles/jquery-ui.min.css' );
// 		//wp_register_style( 'sltg-jquery-structure-style', plugin_dir_url( __FILE__ ) . 'styles/jquery-ui.structure.min.css' );
// 		//wp_register_style( 'sltg-jquery-theme-style' , plugin_dir_url( __FILE__ ) . 'styles/jquery-ui.theme.min.css' );
// 		wp_register_style( 'bootstrap-css', plugin_dir_url( __FILE__ ) . 'styles/bootstrap.min.css' );

// 		wp_enqueue_script( 'sltg-script' );
// 		wp_enqueue_script( 'jquery-ui-script' );
// 		wp_enqueue_script( 'bootstrap-js' );
// 		//wp_enqueue_script( 'sltg-jquery-script' );
// 		wp_enqueue_style( 'jquery-min-style' );
// 		wp_enqueue_style( 'bootstrap-css' );
// 		//wp_enqueue_style( 'sltg-jquery-structure-style' );
// 		//wp_enqueue_style( 'sltg-jquery-theme-style' );

// 		wp_localize_script( "sltg-script", "sltg_ajax", array('ajaxurl'=>admin_url('admin-ajax.php')) );
// 	}

// 	public function render_main_page(){
// 		$content = $this->get_html_template( 'pages', 'main', null, TRUE);
// 		$this->get_html_template( 'pages', 'template', $content );
// 	}

// 	// Render UKM page
// 	public function render_ukm_page(){
// 		require( 'include/ukm.php' );
// 		$obj = new Sltg_UKM();

// 		$content = $this->get_html_template( 'pages/ukm', 'main', null, TRUE);
// 		$this->get_html_template( 'pages', 'template', $content );
// 	}
// 	// Render Product page
// 	public function render_product_page(){
// 		require( 'include/product.php' );
// 		$obj = new Sltg_Product();

// 		$content = $this->get_html_template( 'pages/product', 'main', null, TRUE);
// 		$this->get_html_template( 'pages', 'template', $content );
// 	}
// 	// Render Personal page
// 	public function render_personal_page(){
// 		require( 'include/personal.php' );
// 		$obj = new Sltg_Personal();
// 		//$attributes[ 'n-page' ] = $this->create_pagination( $obj, 'personal_list_limit', 1 );

// 		$content = $this->get_html_template( 'pages/personal', 'main', null, TRUE);
// 		$this->get_html_template( 'pages', 'template', $content );
// 	}

// 	private function get_html_template( $location, $template_name, $attributes = null , $return_val = FALSE) {
// 		if (! $attributes ) {
// 			$attributes = array();
// 		}
// 		ob_start();
// 		require( $location . '/' . $template_name . '.php' );
// 		$html = ob_get_contents();
// 		ob_end_clean();
// 		if ( $return_val )
// 			return $html;
// 		echo $html;
// 	}

// 	public function retrieve_pagination() {

// 		if( isset( $_GET[ 'listfor' ] ) && isset( $_GET[ 'limit' ] ) ) {

// 			$get_listfor = sanitize_text_field( $_GET[ 'listfor' ] );
// 			$get_limit = sanitize_text_field( $_GET[ 'limit' ] );

// 			if( isset( $_GET[ 'search' ] ) ) {
// 				$get_search = sanitize_text_field( $_GET[ 'search' ] );
// 			}

// 			$obj = null;
// 			if( $get_listfor == 'personal' ){
// 				require( 'include/personal.php');
// 				$obj = new Sltg_Personal();
// 				$attributes[ 'listfor' ] = 'personal';
// 				if( isset( $get_search) )
// 					$attributes[ 'n-page' ] = $this->create_pagination( $obj, 'personal_list_limit', $get_limit, $get_search );
// 				else
// 					$attributes[ 'n-page' ] = $this->create_pagination( $obj, 'personal_list_limit', $get_limit );
// 			}
// 			else if( $get_listfor == 'product' ) {
// 				require( 'include/product.php');
// 				$obj = new Sltg_Product();
// 				$attributes[ 'listfor' ] = 'product';
// 				if( isset( $get_search) )
// 					$attributes[ 'n-page' ] = $this->create_pagination( $obj, 'product_list_limit', $get_limit, $get_search );
// 				else
// 					$attributes[ 'n-page' ] = $this->create_pagination( $obj, 'product_list_limit', $get_limit );
// 			}
// 			else if( $get_listfor == 'ukm' ) {
// 				require( 'include/ukm.php');
// 				$obj = new Sltg_UKM();
// 				$attributes[ 'listfor' ] = 'ukm';
// 				if( isset( $get_search) )
// 					$attributes[ 'n-page' ] = $this->create_pagination( $obj, 'ukm_list_limit', $get_limit, $get_search );
// 				else
// 					$attributes[ 'n-page' ] = $this->create_pagination( $obj, 'ukm_list_limit', $get_limit );
// 			}

// 			//var_dump($attributes[ 'n-page' ]);
// 			//if( $attributes[ 'n-page' ] > 0 )
// 				echo $this->get_html_template( 'pages', 'pagination' , $attributes, FALSE );
// 			//else
// 				//echo "";
// 		}
// 		wp_die();
// 	}

// 	private function create_pagination( $obj, $limit_opt, $limit, $search = null) {
// 		if( is_null( $search ) )
// 			$jumlah_data = $obj->CountData();
// 		else
// 			$jumlah_data = $obj->CountData( $search );
// 		update_option( $limit_opt, $limit );
// 		$jumlah_page = intval( $jumlah_data / $limit );
// 		if( $jumlah_data % $limit > 0 ) $jumlah_page += 1;
// 		//var_dump($limit_opt, $limit, $jumlah_data, $jumlah_page);die;
// 		return $jumlah_page;
// 	}

// 	public function retrieve_list(){
		
// 		if( isset( $_GET[ 'listfor' ] ) && isset( $_GET[ 'page' ] ) && isset( $_GET[ 'limit' ] ) ) {
			
// 			$n_get = count( $_GET );
// 			$get_listfor = sanitize_text_field( $_GET[ 'listfor' ] );
// 			$get_limit = sanitize_text_field( $_GET[ 'limit' ] );
// 			$get_page = sanitize_text_field( $_GET[ 'page' ] );

// 			if( isset( $_GET[ 'search' ] ) ) {
// 				$get_search = sanitize_text_field( $_GET[ 'search' ] );
// 			}

// 			//parse_str($_SERVER['QUERY_STRING']);

// 			$offset = ( $get_page - 1 ) * $get_limit;
// 			$obj = null;
// 			$dir_obj = "";

// 			if( $get_listfor == 'personal' ) {
// 				require( 'include/personal.php' );
// 				$obj = new Sltg_Personal();
// 				$dir_obj = "personal";
// 			}
// 			else if( $get_listfor == 'product' ) {
// 				require( 'include/product.php' );
// 				$obj = new Sltg_Product();
// 				$dir_obj = "product";
// 			}
// 			else if( $get_listfor == 'ukm' ) {
// 				require( 'include/ukm.php' );
// 				$obj = new Sltg_UKM();
// 				$dir_obj = "ukm";
// 			}

// 			if( isset( $_GET[ 'search' ] ) )
// 				$rows = $obj->DataList( $get_limit, $offset, $get_search);
// 			else
// 				$rows = $obj->DataList( $get_limit, $offset);

// 			$arrObj = array();

// 			foreach( $rows as $row ){
// 				if( $get_listfor == 'personal' ){
// 					$personal = new Sltg_Personal();
// 					$personal->HasID( $row->id_personal );
// 					$arrObj['personal'][] = $personal;
// 				}
// 				else if( $get_listfor == 'product' ){
// 					$product = new Sltg_Product();
// 					$product->HasID( $row->id_produk );
// 					$arrObj['product'][] = $product;
// 				}
// 				else if( $get_listfor == 'ukm' ){
// 					$ukm = new Sltg_UKM();
// 					$ukm->HasID( $row->id_ukm );
// 					$arrObj['ukm'][] = $ukm;
// 				}
// 			}
// 			//var_dump( $arrObj );
// 			$this->get_html_template( 'pages/' . $dir_obj, 'list', $arrObj , false);
// 		}
// 		wp_die();
// 	}

// 	public function test() {
// 		echo "fika";
// 		wp_die();
// 	}

// 	/*public function test2() {
// 		echo "TEST-2";
// 	}*/

// 	// Retrieve in Template
// 	public function get_kategori_product(){
// 		require( 'include/kategori.php' );
// 		$kategoris = new Sltg_Kategori_Product();

// 		$arrKategori = array();

// 		$rows = $kategoris->DataList();
// 		foreach( $rows as $row ) {
// 			$kategori = new Sltg_Kategori_Product();
// 			$kategori->HasID( $row->id_kategori );
// 			$arrKategori[] = $kategori;
// 		}

// 		return $arrKategori;
// 	}
// }

// $obj_salatiga_plugin = new Salatiga_Plugins();

// register_activation_hook( __FILE__, array( 'Salatiga_Plugin', 'plugin_activated') );
