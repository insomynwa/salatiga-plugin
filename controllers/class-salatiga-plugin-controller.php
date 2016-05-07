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
				// $attributes[ 'listfor' ] = 'product';
				// $option_limit_name = "product_list_limit";

			}
			else if( $get_listfor == 'ukm' ) {
				$obj = new Sltg_UKM();
				// $attributes[ 'listfor' ] = 'ukm';
				// $option_limit_name = "ukm_list_limit";
			}
			else if( $get_listfor == 'music' ) {
				$obj = new Sltg_Music();
				// $attributes[ 'listfor' ] = 'music';
				// $option_limit_name = "music_list_limit";
			}
			else if( $get_listfor == 'hotel' ) {
				$obj = new Sltg_Hotel();
				// $attributes[ 'listfor' ] = 'hotel';
				// $option_limit_name = "hotel_list_limit";
			}
			else if( $get_listfor == 'craft' ) {
				$obj = new Sltg_Craft();
				// $attributes[ 'listfor' ] = 'craft';
				// $option_limit_name = "craft_list_limit";
			}

			$attributes[ 'listfor' ] = $obj->iGet_Listfor();
			$option_limit_name = $obj->iGet_LimitName();

			update_option( $option_limit_name, $get_limit );
			$attributes[ 'n-page' ] = $this->create_pagination( $obj, $get_limit, $get_search, $filter );

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

			/*if( $get_listfor == 'personal' ) {
				$obj = new Sltg_Personal();
				$dir_obj = "personal";
			}
			else */if( $get_listfor == 'product' ) {
				$obj = new Sltg_Product();
				$dir_obj = "product-list-template";
			}
			/*else if( $get_listfor == 'ukm' ) {
				$obj = new Sltg_UKM();
				$dir_obj = "ukm";
			}*/
			else if( $get_listfor == 'music' ) {
				//require( 'models/ukm.php' );
				$obj = new Sltg_Music();
				$dir_obj = "music-list-template";
			}
			else if( $get_listfor == 'hotel' ) {
				//require( 'models/ukm.php' );
				$obj = new Sltg_Hotel();
				$dir_obj = "hotel-list-template";
			}
			else if( $get_listfor == 'craft' ) {
				//require( 'models/ukm.php' );
				$obj = new Sltg_Craft();
				$dir_obj = "craft-list-template";
			}

			$rows = $obj->DataList( $get_limit, $offset, $get_search, $filter );

			$arrObj = array();

			foreach( $rows as $row ){
				/*if( $get_listfor == 'personal' ){
					$personal = new Sltg_Personal();
					$personal->HasID( $row->id_personal );
					$arrObj['personal'][] = $personal;
				}
				else */if( $get_listfor == 'product' ){
					$product = new Sltg_Product();
					$product->HasID( $row->id_produk );
					$arrObj['product'][] = $product;
				}
				else if( $get_listfor == 'ukm' ){
					$ukm = new Sltg_UKM();
					$ukm->HasID( $row->id_ukm );
					$arrObj['ukm'][] = $ukm;
				}
				else if( $get_listfor == 'music' ){
					$music = new Sltg_Music();
					$music->HasID( $row->id_music );
					$arrObj['music'][] = $music;
				}
				else if( $get_listfor == 'hotel' ){
					$hotel = new Sltg_Hotel();
					$hotel->HasID( $row->id_hotel );
					$arrObj['hotel'][] = $hotel;
				}
				else if( $get_listfor == 'craft' ){
					$craft = new Sltg_Craft();
					$craft->HasID( $row->id_craft );
					$arrObj['craft'][] = $craft;
				}
			}

			get_html_template( 'templates', $dir_obj/*'product-list-template'*/, $arrObj , false);
		}
		wp_die();
	}

}