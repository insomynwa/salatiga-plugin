<?php

class Salatiga_Plugin_Controller {

	public function __construct() {

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
				$obj = new Sltg_UKM();
				$attributes[ 'listfor' ] = 'ukm';
				$option_limit_name = "ukm_list_limit";
			}
			update_option( $option_limit_name, $get_limit );
			$attributes[ 'n-page' ] = $this->create_pagination( $obj, $get_limit, $get_search, $get_kategori );

			get_html_template( 'templates', 'pagination' , $attributes, FALSE );
		}
		wp_die();
	}

	private function create_pagination( $obj, /*$limit_opt,*/ $limit, $search = "", $kategori = 0 ) {
		$jumlah_data = $obj->CountData( $search, $kategori );
		$jumlah_page = intval( $jumlah_data / $limit );
		if( $jumlah_data % $limit > 0 ) $jumlah_page += 1;
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

			$offset = ( $get_page - 1 ) * $get_limit;
			$obj = null;
			$dir_obj = "";

			if( $get_listfor == 'personal' ) {
				$obj = new Sltg_Personal();
				$dir_obj = "personal";
			}
			else if( $get_listfor == 'product' ) {
				$obj = new Sltg_Product();
				$dir_obj = "product";
			}
			else if( $get_listfor == 'ukm' ) {
				$obj = new Sltg_UKM();
				$dir_obj = "ukm";
			}

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

}