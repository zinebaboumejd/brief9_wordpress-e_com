<?php
/*
 * @link              http://wpthemespace.com
 * @since             1.0.0
 * @package           Magical products Display
 *
 * @wordpress-plugin
 * Plugin Name:       Magical products Display
 * Plugin URI:        http://wpthemespace.com
 * Description:       Magical Products Display is an Elementor Addons for WooCommerce products.
 * Version:           1.0.13
 * Author:            Noor alam
 * Author URI:        http://wpthemespace.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       magical-products-display
 * Domain Path:       /languages
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}



/**
 * Main Magical Products Display Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class magicalProductsDisplay
{

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.13';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.6.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.6';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Elementor_Test_Extension The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Test_Extension An instance of the class.
	 */
	public static function instance()
	{

		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct()
	{
		$this->define_constants();
		add_action('init', [$this, 'i18n']);
		add_action('plugins_loaded', [$this, 'init']);
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n()
	{

		load_plugin_textdomain('magical-products-display');
	}

	public function define_constants()
	{
		define('MAGICAL_PRODUCTS_DISPLAY_VERSION', self::VERSION);
		define('MAGICAL_PRODUCTS_DISPLAY_FILE', __FILE__);
		define('MAGICAL_PRODUCTS_DISPLAY_DIR', plugin_dir_path(__FILE__));
		define('MAGICAL_PRODUCTS_DISPLAY_URL', plugins_url('', MAGICAL_PRODUCTS_DISPLAY_FILE));
		define('MAGICAL_PRODUCTS_DISPLAY_ASSETS', MAGICAL_PRODUCTS_DISPLAY_URL . '/assets/');
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init()
	{

		// Check if Elementor installed and activated
		if (!did_action('elementor/loaded')) {
			add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
			return;
		}
		// Check if woocommerce3 installed and activated
		if (!class_exists('WooCommerce')) {
			add_action('admin_notices', [$this, 'admin_notice_missing_woo_plugin']);
			return;
		}
		// Check if Elementor installed and activated
		if (!did_action('elementor/loaded')) {
			add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
			return;
		}

		// Check for required Elementor version
		if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
			add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
			return;
		}

		// Check for required PHP version
		if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
			add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
			return;
		}

		// Load function file
		require_once(__DIR__ . '/includes/functions.php');
		// Load admin info
		require_once(__DIR__ . '/includes/admin-info.php');

		// Add Plugin actions
		//admin scritps added
		add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
		add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
		add_action('elementor/elements/categories_registered', [$this, 'register_new_category']);
		add_action('elementor/frontend/after_enqueue_styles', [$this, 'frontend_widget_styles']);
		add_action("elementor/frontend/after_enqueue_scripts", [$this, 'frontend_assets_scripts']);
	}
	/*
		public function register_new_category($manager){
		$manager->add_category('mgproductwoo',[
			'title' => esc_html__('Magical Products Display','magical-products-display'),
			'icon' => 'eicon-products',
		]);

		
	}
	*/

	public function register_new_category(\Elementor\Elements_Manager $elements_manager)
	{

		//add our categories
		$category_prefix = 'mpd-';

		if (class_exists('magicalProductsDisplayPro')) {
			$elements_manager->add_category($category_prefix . 'productwoo', [
				'title' => esc_html__('Magical Products Display', 'magical-posts-display'),
				'icon' => 'eicon-products',
			]);
		} else {
			$elements_manager->add_category(
				$category_prefix . 'productwoo',
				[
					'title' => esc_html__('Magical Products Display', 'magical-products-display'),
					'icon' => 'eicon-products',
				]
			);
			$reorder_cats = function () use ($category_prefix) {
				uksort($this->categories, function ($keyOne, $keyTwo) use ($category_prefix) {
					if (substr($keyOne, 0, 4) == $category_prefix) {
						return -1;
					}
					if (substr($keyTwo, 0, 4) == $category_prefix) {
						return 1;
					}
					return 0;
				});
			};
			$reorder_cats->call($elements_manager);
		} // check pro version

	}



	/*
	plugin css
	*/
	function frontend_widget_styles()
	{

		wp_enqueue_style('bootstrap-custom',  plugins_url('/assets/css/bootstrap-custom.css', __FILE__), array(), '5.1.0', 'all');
		//swiper style
		wp_enqueue_style('swiper',  plugins_url('/assets/css/swiper.min.css', __FILE__), array(), '1.0', 'all');
		//image hover card
		wp_enqueue_style('mgproducts-hover-card',  plugins_url('/assets/css/imagehover.min.css', __FILE__), array(), '1.0', 'all');
		//tab style
		wp_enqueue_style('mgproducts-tab',  plugins_url('/assets/css/widgets/mpd-tabs.css', __FILE__), array(), '1.0', 'all');
		//pricing style
		wp_enqueue_style('mgproducts-pricing',  plugins_url('/assets/css/widgets/mpd-pricing.css', __FILE__), array(), '1.0', 'all');
		//Accordion style
		wp_enqueue_style('mgproducts-accordion',  plugins_url('/assets/css/widgets/mpd-accordion.css', __FILE__), array(), '1.0', 'all');
		//main style
		wp_enqueue_style('mgproducts-style',  plugins_url('/assets/css/mpd-display-style.css', __FILE__), array(), MAGICAL_PRODUCTS_DISPLAY_VERSION, 'all');
	}
	/*
	plugin js
	*/
	function frontend_assets_scripts()
	{
		wp_enqueue_script("bootstrap", plugins_url("/assets/js/bootstrap.bundle.min.js", __FILE__), array('jquery'), '5.1.0', true);

		wp_enqueue_script("swiper", plugins_url("/assets/js/swiper.min.js", __FILE__), array('jquery'), '1.0.5', true);
		wp_enqueue_script("slick.min-js", plugins_url("/assets/js/slick.min.js", __FILE__), array('jquery'), '1.0.5', true);
		wp_enqueue_script("mgproducts-script-js", plugins_url("/assets/js/main-scripts.js", __FILE__), array('jquery'), MAGICAL_PRODUCTS_DISPLAY_VERSION, true);
		wp_enqueue_script("mgproducts-slider-script-js", plugins_url("/assets/js/widgets-active/products-slider-active.js", __FILE__), array('jquery'), MAGICAL_PRODUCTS_DISPLAY_VERSION, true);
		wp_enqueue_script("mgproducts-carousel-script-js", plugins_url("/assets/js/widgets-active/products-carousel-active.js", __FILE__), array('jquery'), MAGICAL_PRODUCTS_DISPLAY_VERSION, true);
		wp_enqueue_script("testimonail-carousel-script-js", plugins_url("/assets/js/widgets-active/testimonail-carousel-active.js", __FILE__), array('jquery'), MAGICAL_PRODUCTS_DISPLAY_VERSION, true);
	}


	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin()
	{

		if (isset($_GET['activate'])) unset($_GET['activate']);


		if (file_exists(WP_PLUGIN_DIR . '/elementor/elementor.php')) {
			$magial_eactive_url = wp_nonce_url('plugins.php?action=activate&plugin=elementor/elementor.php&plugin_status=all&paged=1', 'activate-plugin_elementor/elementor.php');
			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
				esc_html__('%1$s requires %2$s plugin, which is currently NOT RUNNING  %3$s', 'magical-products-display'),
				'<strong>' . esc_html__('Magical Products Display', 'magical-products-display') . '</strong>',
				'<strong>' . esc_html__('Elementor', 'magical-products-display') . '</strong>',
				'<a class="button button-primary" style="margin-left:20px" href="' . $magial_eactive_url . '">' . __('Activate Elementor', 'magical-products-display') . '</a>'

			);
		} else {

			$magial_einstall_url =  wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');
			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
				esc_html__('%1$s requires %2$s plugin, which is currently NOT RUNNING  %3$s', 'magical-products-display'),
				'<strong>' . esc_html__('Magical Products Display', 'magical-products-display') . '</strong>',
				'<strong>' . esc_html__('Elementor', 'magical-products-display') . '</strong>',
				'<a class="button button-primary" style="margin-left:20px" href="' . $magial_einstall_url . '">' . __('Install Elementor', 'magical-products-display') . '</a>'

			);
		}



		printf('<div class="notice notice-warning is-dismissible"><p style="padding: 13px 0">%1$s</p></div>', $message);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have WooCommerce installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_woo_plugin()
	{

		if (file_exists(WP_PLUGIN_DIR . '/woocommerce/woocommerce.php')) {
			$magial_eactive_url = wp_nonce_url('plugins.php?action=activate&plugin=woocommerce/woocommerce.php&plugin_status=all&paged=1', 'activate-plugin_woocommerce/woocommerce.php');
			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
				esc_html__('%1$s requires %2$s plugin, which is currently NOT RUNNING  %3$s', 'magical-products-display'),
				'<strong>' . esc_html__('Magical Products Display', 'magical-products-display') . '</strong>',
				'<strong>' . esc_html__('woocommerce', 'magical-products-display') . '</strong>',
				'<a class="button button-primary" style="margin-left:20px" href="' . $magial_eactive_url . '">' . __('Activate WooCommerce', 'magical-products-display') . '</a>'

			);
		} else {

			$magial_einstall_url =  wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=woocommerce'), 'install-plugin_woocommerce');
			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
				esc_html__('%1$s requires %2$s plugin, which is currently NOT RUNNING  %3$s', 'magical-products-display'),
				'<strong>' . esc_html__('Magical Products Display', 'magical-products-display') . '</strong>',
				'<strong>' . esc_html__('woocommerce', 'magical-products-display') . '</strong>',
				'<a class="button button-primary" style="margin-left:20px" href="' . $magial_einstall_url . '">' . __('Install woocommerce', 'magical-products-display') . '</a>'

			);
		}



		printf('<div class="notice notice-warning is-dismissible"><p style="padding: 13px 0">%1$s</p></div>', $message);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version()
	{

		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'magical-products-display'),
			'<strong>' . esc_html__('Magical Products Display', 'magical-products-display') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'magical-products-display') . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version()
	{

		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'magical-products-display'),
			'<strong>' . esc_html__('Magical Products Display', 'magical-products-display') . '</strong>',
			'<strong>' . esc_html__('PHP', 'magical-products-display') . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Init admin js
	 *
	 * Include js files 
	 *
	 * @since 1.0.13
	 *
	 * @access public
	 */
	public function admin_scripts()
	{
		wp_enqueue_script('mgpd-admin-js', plugins_url('/assets/js/admin.js', __FILE__), array('jquery'), '1.5.0', true);
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets()
	{

		// Register widget
		require_once(__DIR__ . '/includes/widgets/products-grid.php');
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \mgProducts_Grid());

		require_once(__DIR__ . '/includes/widgets/products-list.php');
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \mgProducts_List());

		require_once(__DIR__ . '/includes/widgets/products-slider.php');
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \mgProducts_slider());

		require_once(__DIR__ . '/includes/widgets/products-carousel.php');
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \mgProducts_carousel());

		require_once(__DIR__ . '/includes/widgets/testimonial-carousel.php');
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \mgp_TestimonialCarousel());

		require_once(__DIR__ . '/includes/widgets/products-tab.php');
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \mgProducts_Tab());

		require_once(__DIR__ . '/includes/widgets/porducts-cat.php');
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \mgProducts_cats());

		require_once(__DIR__ . '/includes/widgets/products-awesome-list.php');
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \mgProducts_AwesomeList());

		require_once(__DIR__ . '/includes/widgets/pricing-table.php');
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \mgProduct_Pricing_Table());

		require_once(__DIR__ . '/includes/widgets/accordion-widget.php');
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \mgProduct_Accordion());
	}
}

magicalProductsDisplay::instance();
