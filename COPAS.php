<?php

		if( isset( $_GET[ 'detail' ] ) && $_GET[ 'detail' ] > 0 ) {
			$get_detail = sanitize_text_field( $_GET[ 'detail'] );
			$obj = new Sltg_UKM();

			$obj->HasID( $get_detail );
			$attributes[ 'ukm' ] = $obj;

			$content = $this->get_html_template( 'pages/ukm', 'detail', $attributes, TRUE);
			$this->get_html_template( 'pages', 'template', $content );
		}

		if( isset( $_GET[ 'detail' ] ) && $_GET[ 'detail'] > 0) {

			$get_detail = sanitize_text_field( $_GET[ 'detail'] );
			$obj = new Sltg_Product();

			$obj->HasID( $get_detail );
			$attributes[ 'product' ] = $obj;

			$content = $this->get_html_template( 'pages/product', 'detail', $attributes, TRUE);
			$this->get_html_template( 'pages', 'template', $content );
		}

/*
Parameters:
obj
id
attribute's key
location (directory & filename)
*/
private function load_detail( $obj, $id_detail, $att_key, $dir, $filename ) {

	$obj->HasID( $id_detail );
	$attributes[ "$att_key" ] = $obj;

	$content = $this->get_html_template( 'pages/' . $dir, $filename, $attributes, TRUE);
	$this->get_html_template( 'pages', 'template', $content );
}






	public function render_product_page(){
		if( isset( $_GET[ 'detail' ] ) && $_GET[ 'detail'] > 0) {

			$get_detail = sanitize_text_field( $_GET[ 'detail'] );
			$obj = new Sltg_Product();

			$this->load_detail( $obj, $get_detail, "product", "product", "detail" );

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