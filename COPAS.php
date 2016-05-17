<?php
	public function update_touristsite() {
		$result = array( 'status' => false, 'message' => '' );
		$post_isset = isset( $_POST[ 'touristsite' ] ) && isset( $_POST[ 'nama' ] ) && isset( $_POST[ 'alamat' ] ) && isset( $_POST[ 'deskripsi' ] ) && isset( $_POST[ 'infolain' ] ) &&
			isset( $_POST[ 'telp' ] ) && isset( $_POST[ 'kategori' ] ) && isset( $_POST[ 'gambararr' ] ) &&
			isset( $_POST[ 'latitude' ] ) && isset( $_POST[ 'longitude' ] );
		
		if( $post_isset ) {
			$post_touristsite_id = sanitize_text_field( $_POST[ 'touristsite' ] );
			$post_nama = sanitize_text_field( $_POST[ 'nama' ] );
			$post_alamat = sanitize_text_field( $_POST[ 'alamat' ] );
			$post_deskripsi = sanitize_text_field( $_POST[ 'deskripsi' ] );
			$post_infolain = sanitize_text_field( $_POST[ 'infolain' ] );
			$post_telp = sanitize_text_field( $_POST[ 'telp' ] );
			$post_latitude = sanitize_text_field( $_POST[ 'latitude' ] );
			$post_longitude = sanitize_text_field( $_POST[ 'longitude' ] );
			$post_kategori = sanitize_text_field( $_POST[ 'kategori' ] );
			$post_gambararr = $_POST[ 'gambararr' ] ;

			$is_new_kategori = (! is_numeric( $post_kategori ) );
			$valid_kategori = $this->validate_kategori( $is_new_kategori, $post_kategori );

			$post_not_empty = ($post_touristsite_id > 0) && ($post_nama!="") && ($valid_kategori) && ($post_alamat!="") && (sizeof($post_gambararr)>0);

			if( $post_not_empty ) {
				if( $is_new_kategori ) {
					$result_add = $this->add_kategori( $post_kategori );
					$post_kategori = $result_add[ 'new_id' ];
				}
				$touristsite = new Sltg_TouristSite();
				$touristsite->HasID( $post_touristsite_id );

				// compare data
				$oldData = array(
					$touristsite->GetNama(), // nama touristsite
					$touristsite->GetALamat(), // alamat
					$touristsite->GetDeskripsi(), // deskripsi
					$touristsite->GetOther(), // other
					$touristsite->GetTelp(), // telp
					$touristsite->GetLatitude(), // latitude
					$touristsite->GetLongitude(), // longitude
					$touristsite->GetKategori()->GetID() // kategori
					);
				$newData = array(
					$post_nama, // nama touristsite
					$post_alamat, // alamat
					$post_deskripsi, // deskripsi
					$post_infolain, // other
					$post_telp, // telp
					$post_latitude, // latitude
					$post_longitude, // longitude
					$post_kategori // kategori,
					);

				$result = $this->update_pictures( $touristsite, /*'touristsite',*/ $post_gambararr );

				if ( $oldData !== $newData ) {
					$touristsite->SetNama( $post_nama );
					$touristsite->SetDeskripsi( $post_deskripsi );
					$touristsite->SetOther( $post_infolain );
					$touristsite->SetKategori( $post_kategori );
					$touristsite->SetProducer( $post_kreator );
					$result = $touristsite->Update();
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