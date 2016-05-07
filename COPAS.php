<?php
public function render_craft_page(){
		if( isset( $_GET[ 'detail' ] ) && $_GET[ 'detail' ] > 0) {

			$get_detail = sanitize_text_field( $_GET[ 'detail'] );
			$obj = new Sltg_Craft();

			$content = $this->load_detail( $obj, $get_detail, "craft", "craft" );
		}
		else if( isset( $_GET[ 'doaction' ] ) && $_GET[ 'doaction' ] != "" ){
			$get_action = sanitize_text_field( $_GET[ 'doaction' ] );

			$attributes = array();

			$attributes[ 'kategori' ] = $this->get_array_datalist( 'katprodukukm' );

			$attributes[ 'ukm' ] = $this->get_array_datalist( 'ukm' );

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
			else{
				if( isset( $_GET[ 'craft' ] ) && ($_GET[ 'craft' ] > 0) ) {
					$get_craft_id = sanitize_text_field( $_GET[ 'craft' ] );

					if( $get_action == "edit" ) {
						$action_template = "edit";

						if( isset( $_GET[ 'status' ] )) {
							$get_status = sanitize_text_field( $_GET[ 'status' ] );
							if( $get_status == 'success' ) {
								$attributes[ 'message' ] = "Success Bro!";
							}
						}
					}
					else if( $get_action == 'delete' ) {
						$action_template = 'delete';
					}

					$obj = new Sltg_Craft();
					$obj->HasID( $get_craft_id );
					$attributes[ 'craft' ] = $obj;
				}
			}

			$content = $this->get_html_template( 'pages/craft', $action_template, $attributes, TRUE );
		}
		else {
			$attributes = array();

			$attributes[ 'kategori' ] = $this->get_array_datalist( 'katprodukukm' );
			$attributes[ 'ukm' ] = $this->get_array_datalist( 'ukm' );

			$content = $this->get_html_template( 'pages/craft', 'main', $attributes, TRUE);
		}	
		$this->get_html_template( 'pages', 'template', $content );
	}