<?php
/**
 * Kids Gift Shop functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Kids Gift Shop
 */

if ( ! defined( 'KIDS_ONLINE_STORE_URL' ) ) {
    define( 'KIDS_ONLINE_STORE_URL', esc_url( 'https://www.themagnifico.net/themes/kids-toy-shop-wordpress-theme/', 'kids-gift-shop') );
}
if ( ! defined( 'KIDS_ONLINE_STORE_TEXT' ) ) {
    define( 'KIDS_ONLINE_STORE_TEXT', __( 'Kids Gift Pro','kids-gift-shop' ));
}

function kids_gift_shop_enqueue_styles() {
    wp_enqueue_style('kids-gift-shop-font', kids_online_store_font_url(), array());
    wp_enqueue_style( 'flatly-css', esc_url(get_template_directory_uri()) . '/assets/css/flatly.css');
    $parentcss = 'kids-online-store-style';
    $theme = wp_get_theme(); wp_enqueue_style( $parentcss, get_template_directory_uri() . '/style.css', array(), $theme->parent()->get('Version'));
    wp_enqueue_style( 'kids-gift-shop-style', get_stylesheet_uri(), array( $parentcss ), $theme->get('Version'));

    wp_enqueue_script( 'comment-reply', '/wp-includes/js/comment-reply.min.js', array(), false, true );  
}

add_action( 'wp_enqueue_scripts', 'kids_gift_shop_enqueue_styles' );

function kids_gift_shop_admin_scripts() {
    // demo CSS
    wp_enqueue_style( 'kids-gift-shop-demo-css', get_theme_file_uri( 'assets/css/demo.css' ) );
}
add_action( 'admin_enqueue_scripts', 'kids_gift_shop_admin_scripts' );

function kids_gift_shop_customize_register($wp_customize){
    $wp_customize->add_section('kids_gift_shop_serivces',array(
        'title' => esc_html__('Our Services Section','kids-gift-shop'),
        'description' => esc_html__('Here you have to select category which will display perticular latest blogs in the home page.','kids-gift-shop'),        
    ));
    
    $wp_customize->add_setting('kids_gift_shop_services_category_title', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kids_gift_shop_services_category_title', array(
        'label' => __('Section Title', 'kids-gift-shop'),
        'section' => 'kids_gift_shop_serivces',
        'priority' => 1,
        'type' => 'text',
    ));

    $categories = get_categories();
    $cat_post = array();
    $cat_post[]= 'select';
    $i = 0; 
    foreach($categories as $category){
        if($i==0){
            $default = $category->slug;
            $i++;
        }
        $cat_post[$category->slug] = $category->name;
    }

    $wp_customize->add_setting('kids_gift_shop_menu_items',array(
        'default'   => 'select',
        'sanitize_callback' => 'kids_gift_shop_sanitize_select',
    ));
    $wp_customize->add_control('kids_gift_shop_menu_items',array(
        'type'    => 'select',
        'choices' => $cat_post,
        'label' => __('Select Category to display Services','kids-gift-shop'),
        'section' => 'kids_gift_shop_serivces',
    ));
}
add_action('customize_register', 'kids_gift_shop_customize_register');

if ( ! function_exists( 'kids_gift_shop_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function kids_gift_shop_setup() {

        add_theme_support( 'responsive-embeds' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );

        add_image_size('kids-gift-shop-featured-header-image', 2000, 660, true);

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'kids_online_store_custom_background_args', array(
            'default-color' => '',
            'default-image' => '',
        ) ) );

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support( 'custom-logo', array(
            'height'      => 50,
            'width'       => 50,
            'flex-width'  => true,
        ) );

        add_editor_style( array( '/editor-style.css' ) );

        add_theme_support( 'align-wide' );

        add_theme_support( 'wp-block-styles' );
    }
endif;
add_action( 'after_setup_theme', 'kids_gift_shop_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kids_gift_shop_widgets_init() {
        register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'kids-gift-shop' ),
        'id'            => 'sidebar',
        'description'   => esc_html__( 'Add widgets here.', 'kids-gift-shop' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ) );
}
add_action( 'widgets_init', 'kids_gift_shop_widgets_init' );

function kids_gift_shop_remove_customize_register() {
    global $wp_customize;
    $wp_customize->remove_section( 'kids_online_store_general_settings' ); 
}
add_action( 'customize_register', 'kids_gift_shop_remove_customize_register', 11 );

function kids_gift_shop_sanitize_select( $input, $setting ){
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

if ( ! defined( 'KIDS_ONLINE_STORE_CONTACT_SUPPORT' ) ) {
define('KIDS_ONLINE_STORE_CONTACT_SUPPORT',__('https://wordpress.org/support/theme/kids-gift-shop','kids-gift-shop'));
}
if ( ! defined( 'KIDS_ONLINE_STORE_REVIEW' ) ) {
define('KIDS_ONLINE_STORE_REVIEW',__('https://wordpress.org/support/theme/kids-gift-shop/reviews/#new-post','kids-gift-shop'));
}
if ( ! defined( 'KIDS_ONLINE_STORE_LIVE_DEMO' ) ) {
define('KIDS_ONLINE_STORE_LIVE_DEMO',__('https://themagnifico.net/demo/kids-gift-shop/','kids-gift-shop'));
}
if ( ! defined( 'KIDS_ONLINE_STORE_GET_PREMIUM_PRO' ) ) {
define('KIDS_ONLINE_STORE_GET_PREMIUM_PRO',__('https://www.themagnifico.net/themes/kids-toy-shop-wordpress-theme/','kids-gift-shop'));
}
if ( ! defined( 'KIDS_ONLINE_STORE_PRO_DOC' ) ) {
define('KIDS_ONLINE_STORE_PRO_DOC',__('https://www.themagnifico.net/eard/wathiqa/kids-gift-shop-pro-doc/','kids-gift-shop'));
}