<?php

public function update_hotel() {
		$result = array( 'status' => false, 'message' => '' );
		$post_isset = isset( $_POST[ 'hotel' ] ) && isset( $_POST[ 'nama' ] ) && isset( $_POST[ 'deskripsi' ] ) && isset( $_POST[ 'infolain' ] ) &&
			isset( $_POST[ 'alamat' ] ) && isset( $_POST[ 'telp' ] ) && isset( $_POST[ 'gambararr' ] );
		
		//var_dump($_POST);
		if( $post_isset ) {
			$post_hotel_id = sanitize_text_field( $_POST[ 'hotel' ] );
			$post_nama = sanitize_text_field( $_POST[ 'nama' ] );
			$post_deskripsi = sanitize_text_field( $_POST[ 'deskripsi' ] );
			$post_infolain = sanitize_text_field( $_POST[ 'infolain' ] );
			$post_alamat = sanitize_text_field( $_POST[ 'alamat' ] );
			$post_telp = sanitize_text_field( $_POST[ 'telp' ] );
			$post_gambararr = $_POST[ 'gambararr' ] ;

			$post_not_empty = ($post_hotel_id > 0) && ($post_nama!="") && ($post_alamat!="") && (sizeof($post_gambararr)>0);

			if( $post_not_empty ) {
				
				$hotel = new Sltg_Hotel();
				$hotel->HasID( $post_hotel_id );

				// compare data
				$oldData = array(
					$hotel->GetNama(), // nama 
					$hotel->GetDeskripsi(), // deskripsi
					$hotel->GetOther(), // other
					$hotel->GetAlamat(), // alamat
					$hotel->GetTelp() // telp
					);
				$newData = array(
					$post_nama, // nama 
					$post_deskripsi, // deskripsi
					$post_infolain, // other
					$post_alamat, // alamat,
					$post_telp // telp
					);

				// compare Picture
				$arrOldPict = $hotel->GetGambars();

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
						$temp_gbr->SetOwner( $hotel->GetPictCode() );
						$temp_gbr->ClearSelectedUtama();
					}
					$result = $this->add_picture( 'hotel', $hotel->GetPictCode(), $arrAddedPictId );
				}

				if ( $oldData !== $newData ) {
					$hotel->SetNama( $post_nama );
					$hotel->SetDeskripsi( $post_deskripsi );
					$hotel->SetOther( $post_infolain );
					$hotel->SetAlamat( $post_alamat );
					$hotel->SetTelp( $post_telp );
					$result = $hotel->Update();
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