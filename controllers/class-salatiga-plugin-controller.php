<?php

class Salatiga_Plugin_Controller {

	//private $models;

	public function __construct() {
		//$this->models  = array( "kategori", "personal", "product", "ukm");

		//$this->load_models();
	}

	public function retrieve_pagination() {

		if( isset( $_GET[ 'listfor' ] ) && isset( $_GET[ 'limit' ] ) ) {

			$get_listfor = sanitize_text_field( $_GET[ 'listfor' ] );
			$get_limit = sanitize_text_field( $_GET[ 'limit' ] );
			$get_search = "";
			$get_kategori = 0;

			if( isset( $_GET[ 'category' ] ) ) {
				$get_kategori = sanitize_text_field( $_GET[ 'category' ] );
			}
			if( isset( $_GET[ 'search' ] ) ) {
				$get_search = sanitize_text_field( $_GET[ 'search' ] );
			}

			$obj = null;
			$option_limit_name = "";
			if( $get_listfor == 'personal' ){
				//require( 'models/personal.php');
				$obj = new Sltg_Personal();
				$attributes[ 'listfor' ] = 'personal';
				$option_limit_name = "personal_list_limit";

				/*if( isset( $get_search) )
					$attributes[ 'n-page' ] = $this->create_pagination( $obj, 'personal_list_limit', $get_limit, $get_search );
				else
					$attributes[ 'n-page' ] = $this->create_pagination( $obj, 'personal_list_limit', $get_limit );*/
			}
			else if( $get_listfor == 'product' ) {
				//require( 'models/product.php');
				$obj = new Sltg_Product();
				$attributes[ 'listfor' ] = 'product';
				$option_limit_name = "product_list_limit";

				/*if( isset( $get_search) )
					$attributes[ 'n-page' ] = $this->create_pagination( $obj, 'product_list_limit', $get_limit, $get_search );
				else
					$attributes[ 'n-page' ] = $this->create_pagination( $obj, 'product_list_limit', $get_limit );*/
			}
			else if( $get_listfor == 'ukm' ) {
				//require( 'models/ukm.php');
				$obj = new Sltg_UKM();
				$attributes[ 'listfor' ] = 'ukm';
				$option_limit_name = "ukm_list_limit";

				/*if( isset( $get_search) )
					$attributes[ 'n-page' ] = $this->create_pagination( $obj, 'ukm_list_limit', $get_limit, $get_search );
				else
					$attributes[ 'n-page' ] = $this->create_pagination( $obj, 'ukm_list_limit', $get_limit );*/
			}
			update_option( $option_limit_name, $get_limit );
			$attributes[ 'n-page' ] = $this->create_pagination( $obj, $get_limit, $get_search, $get_kategori );

			//var_dump($attributes[ 'n-page' ]);
			//if( $attributes[ 'n-page' ] > 0 )
			 /*$this->*/get_html_template( 'templates', 'pagination' , $attributes, FALSE );
			//else
				//echo "";
		}
		wp_die();
	}

	private function create_pagination( $obj, /*$limit_opt,*/ $limit, $search = "", $kategori = 0 ) {
		/*if( is_null( $search ) )
			$jumlah_data = $obj->CountData();
		else
			$jumlah_data = $obj->CountData( $search );*/
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

			if( isset( $_GET[ 'category' ] ) ) {
				$get_kategori = sanitize_text_field( $_GET[ 'category' ] );
			}
			if( isset( $_GET[ 'search' ] ) ) {
				$get_search = sanitize_text_field( $_GET[ 'search' ] );
			}

			//parse_str($_SERVER['QUERY_STRING']);

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

			/*if( isset( $_GET[ 'search' ] ) )
				$rows = $obj->DataList( $get_limit, $offset, $get_search);
			else
				$rows = $obj->DataList( $get_limit, $offset);*/
			$rows = $obj->DataList( $get_limit, $offset, $get_search, $get_kategori );

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
			}
			//var_dump( $arrObj );
			get_html_template( 'templates' /*. $dir_obj*/, 'ukm-list-template', $arrObj , false);
		}
		wp_die();
	}

	/*public function load_models() {
		foreach( $this->models as $model ) {
			require plugin_dir_path( dirname( __FILE__ ) ) . 'admin/models/'. $model . '.php';
		}
	}*/

}