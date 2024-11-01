<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       www.codevigor.com
 * @since      1.0.0
 *
 * @package    Wp_Db_Error_Manager
 * @subpackage Wp_Db_Error_Manager/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Db_Error_Manager
 * @subpackage Wp_Db_Error_Manager/includes
 * @author     Codevigor Ltd <suyash@codevigor.com>
 */
class Wp_Db_Error_Manager {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_Db_Error_Manager_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'wp-db-error-manager';
		$this->version = '2.1.6';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_Db_Error_Manager_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_Db_Error_Manager_i18n. Defines internationalization functionality.
	 * - Wp_Db_Error_Manager_Admin. Defines all hooks for the admin area.
	 * - Wp_Db_Error_Manager_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-db-error-manager-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-db-error-manager-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-db-error-manager-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-db-error-manager-public.php';

		$filesList = scandir(plugin_dir_path( dirname( __FILE__ ) ) . '/admin/includes/');

		for($i=0;$i<count($filesList);$i++) {
			if($filesList[$i] != "." && $filesList[$i] != "..") {
				require_once plugin_dir_path( dirname( __FILE__ ) ) . '/admin/includes/'.$filesList[$i];
			}
		}

		$this->loader = new Wp_Db_Error_Manager_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Db_Error_Manager_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wp_Db_Error_Manager_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wp_Db_Error_Manager_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Add menu item
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

		// Add Settings link to the plugin
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

		$this->define_admin_ajax_actions();//define ajax actions for admin
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wp_Db_Error_Manager_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wp_Db_Error_Manager_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	private function define_admin_ajax_actions() {
		add_action('wp_enqueue_scripts', array($this, 'addajaxurl'));

		$actions = array(
				"generate_preview",
				"generate_file",
				"login",
				"register",
				"save_premium_settings",
				"load_premium_settings",
				"logout",
				"get_active_plan",
				"user_track"
			);

		for($i=0;$i<count($actions);$i++) {
			add_action('wp_ajax_'.$actions[$i], array($this, $actions[$i]));
		}
	}

	public function addajaxurl() {
	    wp_localize_script( 'frontend-ajax', 'frontendajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	}

	function generate_preview() {
		Wp_Db_Error_Manager_Template_Utility::generate_preview();
		wp_die();
	}

	function generate_file() {
		Wp_Db_Error_Manager_Template_Utility::generate_file();
		wp_die();
	}

	function login() {
		Wp_Db_Error_Manager_Auth::login();
		wp_die();
	}

	function register() {
		Wp_Db_Error_Manager_Auth::register();
		wp_die();
	}

	function save_premium_settings() {
		Wp_Db_Error_Manager_Premium::save_premium_settings();
		wp_die();
	}

	function load_premium_settings() {
		Wp_Db_Error_Manager_Premium::load_premium_settings();
		wp_die();
	}

	function logout() {
		Wp_Db_Error_Manager_Auth::logout();
		wp_die();
	}

	function get_active_plan() {
		Wp_Db_Error_Manager_Premium::get_active_plan();
		wp_die();
	}

	function user_track() {
		Wp_Db_Error_Manager_User_Tracking::record_ui_action();
		wp_die();
	}

}
