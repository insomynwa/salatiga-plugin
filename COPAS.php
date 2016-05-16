<?php
	public function render_kattouristsite_page(){
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
			else {
				if( isset( $_GET[ 'kattouristsite' ] ) && ($_GET[ 'kattouristsite' ] > 0) ) {
					$get_kattouristsite_id = sanitize_text_field( $_GET[ 'kattouristsite' ] );
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

					$obj = new Sltg_Kategori_TouristSite();
					$obj->HasID( $get_kattouristsite_id );
					$attributes[ 'kattouristsite' ] = $obj;
				}
			}

			$content = $this->get_html_template( 'pages/kategori_touristsite', $action_template, $attributes, TRUE );
		}
		else {
			$content = $this->get_html_template( 'pages/kategori_touristsite', 'main', null, TRUE);
		}
		$this->get_html_template( 'pages', 'template', $content );
	}