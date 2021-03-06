<?php 

class Salatiga_Plugin {

	protected $loader;

	protected $plugin_slug;

	protected $version;

	protected $models;

	public function __construct() {

		$this->plugin_slug = 'salatiga-plugin-slug';
		$this->version = '0.1.0';
		$this->models  = array( "kategori_produk_ukm", "personal", "product", "ukm", "gambar", 'music', 'music_genre', 'hotel', 'kategori_craft', 'craft', 'jenis_kamar', 'kategori_touristsite', 'tourist_site' );

		$this->load_dependencies();
		$this->define_admin_hooks();
	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-salatiga-plugin-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'controllers/class-salatiga-plugin-controller.php';

		require_once plugin_dir_path( __FILE__ ) . 'class-salatiga-plugin-loader.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/interfaces/IListItem.php';

		foreach( $this->models as $model ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/models/'. $model . '.php';
		}

		$this->loader = new Salatiga_Plugin_Loader();

	}

	private function define_admin_hooks() {

		$admin = new Salatiga_Plugin_Admin( $this->get_version() );

		// $this->loader->add_action( 'init', $admin, 'add_oembed_soundcloud' );
		$this->loader->add_action( 'admin_menu', $admin, 'create_admin_menus_and_subs' );
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts_and_styles' );

		$this->loader->add_action( 'wp_ajax_RetrievePagination', $admin, 'retrieve_pagination' );
		$this->loader->add_action( 'wp_ajax_RetrieveList', $admin, 'retrieve_list' );
		$this->loader->add_action( 'wp_ajax_SearchFor', $admin, 'retrieve_list' );
		$this->loader->add_action( 'sltg_product_category_pagination', $admin, 'get_kategori_product' );
		
		$this->loader->add_action( 'wp_ajax_CreateNewProduct', $admin, 'create_product' );
		$this->loader->add_action( 'delete_post', $admin, 'delete_post_attachments' );
		$this->loader->add_action( 'wp_ajax_UpdateProduct', $admin, 'update_product' );

		$this->loader->add_action( 'wp_ajax_CreateNewUKM', $admin, 'create_ukm' );
		$this->loader->add_action( 'wp_ajax_UpdateUKM', $admin, 'update_ukm' );

		$this->loader->add_action( 'wp_ajax_CreateNewPerson', $admin, 'create_person' );
		$this->loader->add_action( 'wp_ajax_UpdatePerson', $admin, 'update_person' );

		$this->loader->add_action( 'wp_ajax_CreateNewMusic', $admin, 'create_music' );
		$this->loader->add_action( 'wp_ajax_UpdateMusic', $admin, 'update_music' );

		$this->loader->add_action( 'wp_ajax_CreateNewHotel', $admin, 'create_hotel' );
		$this->loader->add_action( 'wp_ajax_UpdateHotel', $admin, 'update_hotel' );

		$this->loader->add_action( 'wp_ajax_CreateNewCraft', $admin, 'create_craft' );
		$this->loader->add_action( 'wp_ajax_UpdateCraft', $admin, 'update_craft' );

		$this->loader->add_action( 'wp_ajax_CreateNewKamar', $admin, 'create_jeniskamar' );
		$this->loader->add_action( 'wp_ajax_UpdateKamar', $admin, 'update_jeniskamar' );

		$this->loader->add_action( 'wp_ajax_UpdateTouristSite', $admin, 'update_touristsite' );
		$this->loader->add_action( 'wp_ajax_CreateNewTouristSite', $admin, 'create_touristsite' );
		
		$controller = new Salatiga_Plugin_Controller();
		$this->loader->add_action( 'wp_ajax_nopriv_RetrievePaginationTemplate', $controller, 'retrieve_pagination' );
		$this->loader->add_action( 'wp_ajax_RetrievePaginationTemplate', $controller, 'retrieve_pagination' );
		$this->loader->add_action( 'wp_ajax_nopriv_RetrieveListTemplate', $controller, 'retrieve_list' );
		$this->loader->add_action( 'wp_ajax_RetrieveListTemplate', $controller, 'retrieve_list' );
	}

	public function run() {
		$this->loader->run();
	}

	public function get_version() {
		return $this->version;
	}
}