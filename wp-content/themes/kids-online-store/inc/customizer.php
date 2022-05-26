<?php
/**
 * Kids Online Store Theme Customizer
 *
 * @link: https://developer.wordpress.org/themes/customize-api/customizer-objects/
 *
 * @package Kids Online Store
 */

if ( ! defined( 'KIDS_ONLINE_STORE_URL' ) ) {
    define( 'KIDS_ONLINE_STORE_URL', esc_url( 'https://www.themagnifico.net/themes/kids-wordpress-theme/', 'kids-online-store') );
}
if ( ! defined( 'KIDS_ONLINE_STORE_TEXT' ) ) {
    define( 'KIDS_ONLINE_STORE_TEXT', __( 'Kids Online Store Pro','kids-online-store' ));
}

use WPTRT\Customize\Section\Kids_Online_Store_Button;

add_action( 'customize_register', function( $manager ) {

    $manager->register_section_type( Kids_Online_Store_Button::class );

    $manager->add_section(
        new Kids_Online_Store_Button( $manager, 'kids_online_store_pro', [
            'title'       => esc_html( KIDS_ONLINE_STORE_TEXT,'kids-online-store' ),
            'priority'    => 0,
            'button_text' => __( 'GET PREMIUM', 'kids-online-store' ),
            'button_url'  => esc_url( KIDS_ONLINE_STORE_URL )
        ] )
    );

} );

// Load the JS and CSS.
add_action( 'customize_controls_enqueue_scripts', function() {

    $version = wp_get_theme()->get( 'Version' );

    wp_enqueue_script(
        'kids-online-store-customize-section-button',
        get_theme_file_uri( 'vendor/wptrt/customize-section-button/public/js/customize-controls.js' ),
        [ 'customize-controls' ],
        $version,
        true
    );

    wp_enqueue_style(
        'kids-online-store-customize-section-button',
        get_theme_file_uri( 'vendor/wptrt/customize-section-button/public/css/customize-controls.css' ),
        [ 'customize-controls' ],
        $version
    );

} );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function kids_online_store_customize_register($wp_customize){

    $wp_customize->add_setting('kids_online_store_logo_title', array(
        'default' => true,
        'sanitize_callback' => 'kids_online_store_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'kids_online_store_logo_title',array(
        'label'          => __( 'Enable Disable Title', 'kids-online-store' ),
        'section'        => 'title_tagline',
        'settings'       => 'kids_online_store_logo_title',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting('kids_online_store_logo_text', array(
        'default' => true,
        'sanitize_callback' => 'kids_online_store_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'kids_online_store_logo_text',array(
        'label'          => __( 'Enable Disable Tagline', 'kids-online-store' ),
        'section'        => 'title_tagline',
        'settings'       => 'kids_online_store_logo_text',
        'type'           => 'checkbox',
    )));

    // Theme Color
    $wp_customize->add_section('kids_online_store_color_option',array(
        'title' => esc_html__('Theme Color','kids-online-store'),
        'description' => esc_html__('Change theme color on one click.','kids-online-store'),
        'priority'   => 10,
    ));

    $wp_customize->add_setting( 'kids_online_store_theme_color_one', array(
        'default' => '#ff6f69',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'kids_online_store_theme_color_one', array(
        'label' => esc_html__('First Color Option','kids-online-store'),
        'section' => 'kids_online_store_color_option',
        'settings' => 'kids_online_store_theme_color_one' 
    )));

    $wp_customize->add_setting( 'kids_online_store_theme_color_two', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'kids_online_store_theme_color_two', array(
        'label' => esc_html__('Second Color Option','kids-online-store'),
        'section' => 'kids_online_store_color_option',
        'settings' => 'kids_online_store_theme_color_two' 
    )));

    // Top Header
    $wp_customize->add_section('kids_online_store_top_header',array(
        'title' => esc_html__('Top Header','kids-online-store'),
    ));

    $wp_customize->add_setting('kids_online_store_phone_number_info',array(
        'default' => '',
        'sanitize_callback' => 'kids_online_store_sanitize_phone_number'
    )); 
    $wp_customize->add_control('kids_online_store_phone_number_info',array(
        'label' => esc_html__('Phone Number','kids-online-store'),
        'section' => 'kids_online_store_top_header',
        'setting' => 'kids_online_store_phone_number_info',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('kids_online_store_email_info',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_email'
    ));
    $wp_customize->add_control('kids_online_store_email_info',array(
        'label' => esc_html__('Email Address','kids-online-store'),
        'section' => 'kids_online_store_top_header',
        'setting' => 'kids_online_store_email_info',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('kids_online_store_sticky_header', array(
        'default' => false,
        'sanitize_callback' => 'kids_online_store_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'kids_online_store_sticky_header',array(
        'label'          => __( 'Show Sticky Header', 'kids-online-store' ),
        'section'        => 'kids_online_store_top_header',
        'settings'       => 'kids_online_store_sticky_header',
        'type'           => 'checkbox',
    )));

    // Social Link
    $wp_customize->add_section('kids_online_store_social_link',array(
        'title' => esc_html__('Social Links','kids-online-store'),
    ));

    $wp_customize->add_setting('kids_online_store_facebook_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    )); 
    $wp_customize->add_control('kids_online_store_facebook_url',array(
        'label' => esc_html__('Facebook Link','kids-online-store'),
        'section' => 'kids_online_store_social_link',
        'setting' => 'kids_online_store_facebook_url',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('kids_online_store_twitter_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    )); 
    $wp_customize->add_control('kids_online_store_twitter_url',array(
        'label' => esc_html__('Twitter Link','kids-online-store'),
        'section' => 'kids_online_store_social_link',
        'setting' => 'kids_online_store_twitter_url',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('kids_online_store_intagram_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    )); 
    $wp_customize->add_control('kids_online_store_intagram_url',array(
        'label' => esc_html__('Intagram Link','kids-online-store'),
        'section' => 'kids_online_store_social_link',
        'setting' => 'kids_online_store_intagram_url',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('kids_online_store_linkedin_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    )); 
    $wp_customize->add_control('kids_online_store_linkedin_url',array(
        'label' => esc_html__('Linkedin Link','kids-online-store'),
        'section' => 'kids_online_store_social_link',
        'setting' => 'kids_online_store_linkedin_url',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('kids_online_store_pintrest_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    )); 
    $wp_customize->add_control('kids_online_store_pintrest_url',array(
        'label' => esc_html__('Pinterest Link','kids-online-store'),
        'section' => 'kids_online_store_social_link',
        'setting' => 'kids_online_store_pintrest_url',
        'type'  => 'url'
    ));

    //Slider
    $wp_customize->add_section('kids_online_store_top_slider',array(
        'title' => esc_html__('Slider Settings','kids-online-store'),
        'description' => esc_html__('Here you have to add 3 different pages in below dropdown. Note: Image Dimensions 1200 x 550 px','kids-online-store')
    ));

    for ( $count = 1; $count <= 3; $count++ ) {

        $wp_customize->add_setting( 'kids_online_store_top_slider_page' . $count, array(
            'default'           => '',
            'sanitize_callback' => 'kids_online_store_sanitize_dropdown_pages'
        ) );
        $wp_customize->add_control( 'kids_online_store_top_slider_page' . $count, array(
            'label'    => __( 'Select Slide Page', 'kids-online-store' ),
            'section'  => 'kids_online_store_top_slider',
            'type'     => 'dropdown-pages'
        ) );
    }

    // Footer
    $wp_customize->add_section('kids_online_store_site_footer_section', array(
        'title' => esc_html__('Footer', 'kids-online-store'),
    ));

    $wp_customize->add_setting('kids_online_store_footer_text_setting', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('kids_online_store_footer_text_setting', array(
        'label' => __('Replace the footer text', 'kids-online-store'),
        'section' => 'kids_online_store_site_footer_section',
        'priority' => 1,
        'type' => 'text',
    ));
}
add_action('customize_register', 'kids_online_store_customize_register');