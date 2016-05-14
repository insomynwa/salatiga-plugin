<?php
	public function update_product() {
		$result = array( 'status' => false, 'message' => '' );
		$post_isset = isset( $_POST[ 'product' ] ) && isset( $_POST[ 'nama' ] ) && isset( $_POST[ 'deskripsi' ] ) && isset( $_POST[ 'infolain' ] ) &&
			isset( $_POST[ 'kategori' ] ) && isset( $_POST[ 'kreator' ] ) && isset( $_POST[ 'gambararr' ] );
		
		if( $post_isset ) {
			$post_product_id = sanitize_text_field( $_POST[ 'product' ] );
			$post_nama = sanitize_text_field( $_POST[ 'nama' ] );
			$post_deskripsi = sanitize_text_field( $_POST[ 'deskripsi' ] );
			$post_infolain = sanitize_text_field( $_POST[ 'infolain' ] );
			$post_kategori = sanitize_text_field( $_POST[ 'kategori' ] );
			$post_kreator = sanitize_text_field( $_POST[ 'kreator' ] );
			$post_gambararr = $_POST[ 'gambararr' ] ;

			$is_new_kategori = (! is_numeric( $post_kategori ) );
			$valid_kategori = $this->validate_kategori( $is_new_kategori, $post_kategori );

			$post_not_empty = ($post_product_id > 0) && ($post_nama!="") && ($valid_kategori) && ($post_kreator>0) && (sizeof($post_gambararr)>0);

			if( $post_not_empty ) {
				if( $is_new_kategori ) {
					$result_add = $this->add_kategori( $post_kategori );
					$post_kategori = $result_add[ 'new_id' ];
				}
				$product = new Sltg_Product();
				$product->HasID( $post_product_id );

				// compare data
				$oldData = array(
					$product->GetNama(), // nama produk
					$product->GetDeskripsi(), // deskripsi
					$product->GetOther(), // other
					$product->GetKategori()->GetID(), // kategori
					$product->GetProducer()->GetID() // ukm
					);
				$newData = array(
					$post_nama, // nama produk
					$post_deskripsi, // deskripsi
					$post_infolain, // other
					$post_kategori, // kategori,
					$post_kreator // ukm
					);

				$result = $this->update_pictures( $product, /*'produk',*/ $post_gambararr );

				if ( $oldData !== $newData ) {
					$product->SetNama( $post_nama );
					$product->SetDeskripsi( $post_deskripsi );
					$product->SetOther( $post_infolain );
					$product->SetKategori( $post_kategori );
					$product->SetProducer( $post_kreator );
					$result = $product->Update();
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