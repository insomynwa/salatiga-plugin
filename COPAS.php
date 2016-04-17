<?php

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

			$obj_kat = new Sltg_Kategori_Product();
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
			else if( $get_action == 'delete' && isset( $_GET[ 'person' ] ) && ( $_GET[ 'person' ] ) ) {
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