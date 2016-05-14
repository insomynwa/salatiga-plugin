<?php
	private function update_pictures( $obj, $picture_owner, $arr_post_gambar) {
		$result = array( 'status' => false, 'message' => '' );

		// compare Picture
		$arrOldPict = $obj->GetGambars();

		$arrAddedPict = array();
		$arrAddedPictId = array();
		$utamaInNew = false;
		$selectedUtama = 0;
		foreach( $arr_post_gambar as $newPict) {
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
			foreach( $arr_post_gambar as $newPict) {
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
				$temp_gbr->SetOwner( $obj->GetPictCode() );
				$temp_gbr->ClearSelectedUtama();
			}
			$result = $this->add_picture( $picture_owner, $obj->GetPictCode(), $arrAddedPictId );
		}

		return $result;
	}