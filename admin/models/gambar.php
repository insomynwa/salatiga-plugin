<?php

class Sltg_Gambar {

	private $table_name;
	/*private $owner_pict_name;*/

	private $id;
	public function GetId(){ return $this->id; }

	private $link_gambar;
	public function GetLinkGambar() { return $this->link_gambar; }
	public function SetLinkGambar( $link_gambar ) { $this->link_gambar = $link_gambar; }
	
	private $deskripsi;
	public function GetDeskripsi() { return $this->deskripsi; }
	public function SetDeskripsi($deskripsi) { $this->deskripsi = $deskripsi; }

	/*private $owner;
	public function GetProduk() { return $this->owner; }
	public function SetProduk($owner) { 
		global $wpdb;

		$this->owner = $owner;

		$rows =
			$wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name ".
					"WHERE owner = %d",
					$this->owner
					)
				);
		return $rows;
	}*/
	private $owner;
	public function GetOwner() { return $this->owner; }
	public function SetOwner($owner) { $this->owner = $owner; }

	private $gambar_utama;
	public function GetGambarUtama() { return $this->gambar_utama; }
	public function SetGambarUtama($gambar_utama) { $this->gambar_utama = $gambar_utama; }

	private $post_id;
	public function GetPostId() { return $this->post_id; }
	public function SetPostId($post_id) { $this->post_id = $post_id; }

	function __construct() {
		$this->table_name = 'ext_gambar';

		/*if( $table_name == 'ext_gambar_owner')
			$this->owner_pict_name = 'owner';*/
	}

	function HasID( $gambar_id = 0 ) {
		global $wpdb;

		$row =
			$wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name 
					WHERE id_gambar = %d",
					$gambar_id
					),
				ARRAY_A
				);
		$result = ! is_null( $row );
		if ( $result ){
			$this->id = $row[ 'id_gambar' ];
			$this->link_gambar = $row[ 'link_gambar' ];
			$this->deskripsi = $row[ 'deskripsi_gambar' ];
			$this->owner = $row[ 'owner' ];
			$this->gambar_utama = $row[ 'gambar_utama' ];
			$this->post_id = $row[ 'post_id' ];

		}
		return $result;
	}

	function AddNew() {
		global $wpdb;

		$result = array( 'status' => false, 'message' => 'Error AddNew()-gambar' );

		if( $wpdb->insert(
			$this->table_name,
			array(
				'link_gambar' => $this->link_gambar,
				'deskripsi_gambar' => $this->deskripsi,
				'owner' => $this->owner,
				'gambar_utama' => $this->gambar_utama,
				'post_id' => $this->post_id
				),
			array(
				'%s', '%s', '%s', '%d', '%d'
				)
			) ){
			$result[ 'status' ] = true;
			$result[ 'message' ] = 'Berhasil menambah gambar';
		}
		return $result;
	}

	public function Delete(){
		global $wpdb;

		$result = array( "status" => false, "message" => "" );
		if( $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $this->table_name WHERE id_gambar = %d",
				$this->id
			)
		)) {
			$result ['status'] = true;
			$result ['status'] = $result['status'] && $this->DeletePost();
		}

		return $result;

	}

	public function DeleteMultiple() {
		global $wpdb;
		//wp_delete_post( $this->post_id, true );
		if( $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $this->table_name WHERE owner = %s",
				$this->owner
			)
		) ){
			return true;
		}
		return false;
	}

	public function DeletePost() {
		if( wp_delete_post( $this->post_id, true ) === false) return false;
		return true;
	}

	public function SetAsGambarUtama(){
		$clearOther = $this->clearOtherSelectedUtama();
		global $wpdb;
		$result = array( "status" => false, "message" => "gagal update gambar utama" );
		$queryReset = 
				"UPDATE $this->table_name 
				SET gambar_utama = %d 
				WHERE id_gambar <> %d AND owner = %s";
		$querySetNew = 
				"UPDATE $this->table_name 
				SET gambar_utama = %d 
				WHERE id_gambar = %d";

		if( 
			$clearOther && 
			$wpdb->query($wpdb->prepare( $querySetNew, 1, $this->id )) )
		{
			$result[ 'status' ] = true;
			$result[ 'message' ] = "berhasil update gambar utama";
		}
		return $result;
	}

	private function clearOtherSelectedUtama() {
		global $wpdb;
		$queryReset = 
				"UPDATE $this->table_name 
				SET gambar_utama = %d 
				WHERE id_gambar <> %d AND owner = %s";
		if( $wpdb->query(
			$wpdb->prepare( 
				$queryReset, 
				0, $this->id, $this->owner 
				)
			)){
			return true;
		}
		return false;
	}

	public function ClearSelectedUtama() {
		global $wpdb;
		$queryReset = 
				"UPDATE $this->table_name 
				SET gambar_utama = %d 
				WHERE gambar_utama = %d AND owner = %s";
		$wpdb->query(
			$wpdb->prepare( 
				$queryReset, 
				0, 1, $this->owner 
				)
			);
	}

	public function ListByOwner( $owner ) {
		global $wpdb;

		$rows =
			$wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name ".
					"WHERE owner = %s ORDER BY gambar_utama DESC",
					$owner
					)
				);//var_dump($rows);
		return $rows;
	}

	public function UtamaByOwner( $owner ){
		global $wpdb;
		$row =
			$wpdb->get_row(
				$wpdb->prepare(
					"SELECT * FROM $this->table_name ".
					"WHERE owner = %s AND gambar_utama = %d LIMIT 1",
					$owner, 1
					),
				ARRAY_A
				);

		$result = ! is_null( $row );
		if ( $result ){
			$this->id = $row[ 'id_gambar' ];
			$this->link_gambar = $row[ 'link_gambar' ];
			$this->deskripsi = $row[ 'deskripsi_gambar' ];
			$this->owner = $row[ 'owner' ];
			$this->gambar_utama = $row[ 'gambar_utama' ];
			$this->post_id = $row[ 'post_id' ];

		}
		return $result;
	}

}