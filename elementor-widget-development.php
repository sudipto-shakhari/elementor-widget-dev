<?php
/**
 * Plugin Name: Elementor Widget Development
 * Plugin URI:  https://www.pluginever.com/plugins/wocommerce-serial-numbers-pro/
 * Description: Elementor Widget Development
 * Version:     1.0.0
 * Author:      Sudipto Shakhari
 * Author URI:  https://shakahri.cc/
 * License:     GPLv2+
 * Text Domain: elementor-widget-developments
 * Domain Path: /i18n/languages/
 * Tested up to: 6.3.1
 */

// don't call the file directly
defined( 'ABSPATH' ) || exit();
/**
 * Elementor_Widget_Development class.
 *
 * @class Elementor_Widget_Development contains everything for the plugin.
 */
class Elementor_Widget_Development {
	/**
	 * Elementor_Widget_Development version.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	public $version = '1.0.0';

	/**
	 * This plugin's instance
	 *
	 * @var Elementor_Widget_Development The one true Elementor_Widget_Development
	 * @since 1.0
	 */
	private static $instance;

	/**
	 * Main Elementor_Widget_Development Instance
	 *
	 * Insures that only one instance of Elementor_Widget_Development exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @return Elementor_Widget_Development The one true Elementor_Widget_Development
	 * @since 1.0.0
	 * @static var array $instance
	 */
	public static function init() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Elementor_Widget_Development ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * Return plugin version.
	 *
	 * @return string
	 * @since 1.0.0
	 * @access public
	 **/
	public function get_version() {
		return $this->version;
	}

	/**
	 * Plugin URL getter.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Plugin path getter.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Plugin base path name getter.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function plugin_basename() {
		return plugin_basename( __FILE__ );
	}

	/**
	 * Initialize plugin for localization
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function localization_setup() {
		load_plugin_textdomain( 'elementor-widget-developments', false, plugin_basename( dirname( __FILE__ ) ) . '/i18n/languages' );
	}

	/**
	 * Determines if the wc active.
	 *
	 * @return bool
	 * @since 1.0.0
	 *
	 */
	public function is_elementor_active() {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';

		return is_plugin_active( 'elementor/elementor.php' ) == true;
	}

	/**
	 * WooCommerce plugin dependency notice
	 * @since 1.0.0
	 */
	public function elementor_missing_notice() {
		if ( ! $this->is_elementor_active() ) {
			$message = sprintf(
				__( '<strong>Elementor Widget Development</strong> requires <strong>Elementor</strong> installed and activated. Please Install %1$s Elementor. %2$s', 'elementor-widget-developments' ),
				'<a href="https://wordpress.org/plugins/elementor/" target="_blank">',
				'</a>'
			);
			echo sprintf( '<div class="notice notice-error"><p>%s</p></div>', $message );
		}
	}

	/**
	 * Define constant if not already defined
	 *
	 * @param string $name
	 * @param string|bool $value
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @access protected
	 * @return void
	 */

	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'elementor-widget-developments' ), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @access protected
	 * @return void
	 */

	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'elementor-widget-developments' ), '1.0.0' );
	}

	/**
	 * WC_Serial_Numbers constructor.
	 */
	private function __construct() {
		$this->define_constants();
		register_activation_hook( __FILE__, array( $this, 'activate_plugin' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate_plugin' ) );

		add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
		add_action( 'admin_notices', array( $this, 'elementor_missing_notice' ) );
	}

	/**
	 * Define all constants
	 * @return void
	 * @since 1.0.0
	 */
	public function define_constants() {
		$this->define( 'ELEMENTOR_WIDGET_DEVELOPMENT_PLUGIN_VERSION', $this->version );
		$this->define( 'ELEMENTOR_WIDGET_DEVELOPMENT_PLUGIN_FILE', __FILE__ );
		$this->define( 'ELEMENTOR_WIDGET_DEVELOPMENT_PLUGIN_DIR', dirname( __FILE__ ) );
		$this->define( 'ELEMENTOR_WIDGET_DEVELOPMENT_PLUGIN_INC_DIR', dirname( __FILE__ ) . '/includes' );
	}

	/**
	 * Activate plugin.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function activate_plugin() {
	}

	/**
	 * Deactivate plugin.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function deactivate_plugin() {

	}

	/**
	 * Load the plugin when WooCommerce loaded.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function init_plugin() {
		$this->includes();
		$this->init_hooks();
	}


	/**
	 * Include required core files used in admin and on the frontend.
	 * @since 1.0.0
	 */
	public function includes() {
		do_action( 'elementor_widget_development__loaded' );
	}


	/**
	 * Hook into actions and filters.
	 *
	 * @since 1.0.0
	 */
	private function init_hooks() {
		add_action( 'plugins_loaded', array( $this, 'localization_setup' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );
		add_action( 'elementor/widgets/register', array( $this, 'register_custom_elementor_widgets' ) );
		//add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded' ), - 1 );
	}

	public function add_scripts() {
		$css_url = $this->plugin_url() . '/assets/css';
		$js_url  = $this->plugin_url() . '/assets/js';
		wp_register_style( 'owl-carousel-min', $css_url . '/vendors/owl-carousel/owl.carousel.css' );//phpcs:ignore
		wp_register_style( 'owl-carousel-theme-default', $css_url . '/vendors/owl-carousel/owl.theme.default.css' );//phpcs:ignore
		wp_register_style( 'home-testimonial', $css_url . '/home-testimonial.css' );//phpcs:ignore
		wp_register_style( 'custom-slider', $css_url . '/custom-slider.css' );//phpcs:ignore
		wp_register_script('owl-carousel-scripts', $js_url.'/vendors/owl-carousel/owl.carousel.js', array('jquery'), $this->get_version(),false );//phpcs:ignore

	}

	/**
	 * Register custom elementor widgets with all other widgets.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widget manager.
	 * @return void
	*/
	public function register_custom_elementor_widgets( $widgets_manager ) {
		require_once __DIR__ . '/includes/elementor/home-testimonials.php';
		require_once __DIR__ . '/includes/elementor/custom-slider.php';
		$widgets_manager->register( new \Home_Testimonials() );
		$widgets_manager->register( new \Custom_Sliders() );

	}
	/**
	 * When WP has loaded all plugins, trigger the `wc_serial_numbers__loaded` hook.
	 *
	 * This ensures `wc_serial_numbers__loaded` is called only after all other plugins
	 * are loaded, to avoid issues caused by plugin directory naming changing
	 *
	 * @since 1.0.0
	 */
	public function on_plugins_loaded() {
		do_action( 'elementor_widget_development__loaded' );
	}

}

/**
 * The main function responsible for returning the one true Elementor Widget Development
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * @return Elementor_Widget_Development
 * @since 1.2.0
 */
function elementor_widget_development() {
	return Elementor_Widget_Development::init();
}

//lets go.
elementor_widget_development();
