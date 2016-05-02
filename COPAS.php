<?php

public function render_katcraft(){
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
			else if( $get_action == "edit" && isset( $_GET[ 'katcraft' ] ) && ($_GET[ 'katcraft' ] > 0) ) {
				$get_katcraft_id = sanitize_text_field( $_GET[ 'katcraft' ] );

				$action_template = "edit";

				if( isset( $_GET[ 'status' ] )) {
					$get_status = sanitize_text_field( $_GET[ 'status' ] );
					if( $get_status == 'success' ) {
						$attributes[ 'message' ] = "Success Bro!";
					}
				}

				$obj = new Sltg_Kategori_Craft();
				$obj->HasID( $get_katcraft_id );
				$attributes[ 'katcraft' ] = $obj;
			}
			else if( $get_action == 'delete' && isset( $_GET[ 'katcraft' ] ) && ( $_GET[ 'katcraft' ] > 0 ) ) {
				$get_katcraft_id = sanitize_text_field( $_GET[ 'katcraft' ] );

				$action_template = 'delete';

				$obj = new Sltg_Kategori_Craft();
				$obj->HasID( $get_katcraft_id );
				$attributes[ 'katcraft' ] = $obj;
			}

			$content = $this->get_html_template( 'pages/kategori_craft', $action_template, $attributes, TRUE );
			$this->get_html_template( 'pages', 'template', $content );
		}
		else {
			$obj = new Sltg_Kategori_Craft();
			$content = $this->get_html_template( 'pages/kategori_craft', 'main', null, TRUE);
			$this->get_html_template( 'pages', 'template', $content );
		}
	}