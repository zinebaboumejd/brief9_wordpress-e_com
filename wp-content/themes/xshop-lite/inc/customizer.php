<?php
/**
 *XShop Lite Theme Customizer
 *
 * @package XShop Lite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */


function xshop_lite_customize_register( $wp_customize ) {

    $wp_customize->remove_control('xshop_header_address1');
    $wp_customize->remove_control('xshop_header_address2');
    $wp_customize->remove_control('xshop_blog_layout');
    $wp_customize->remove_control('xshop_blog_style');
    
    $wp_customize->add_setting('xshop_lite_blog_layout', array(
        'default'        => 'leftside',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'xshop_sanitize_select',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('xshop_lite_blog_layout', array(
        'label'      => __('Select Blog Layout', 'xshop-lite'),
        'description'=> __('Right and Left sidebar only show when sidebar widget is available. ', 'xshop-lite'),
        'section'    => 'xshop_blog',
        'settings'   => 'xshop_lite_blog_layout',
        'type'       => 'select',
        'choices'    => array(
            'rightside' => __('Right Sidebar', 'xshop-lite'),
            'leftside' => __('Left Sidebar', 'xshop-lite'),
            'fullwidth' => __('No Sidebar', 'xshop-lite'),
        ),
    ));
	$wp_customize->add_setting('xshop_lite_blog_style', array(
        'default'        => 'list',
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'xshop_sanitize_select',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('xshop_lite_blog_style', array(
        'label'      => __('Select Blog Style', 'xshop-lite'),
        'section'    => 'xshop_blog',
        'settings'   => 'xshop_lite_blog_style',
        'type'       => 'select',
        'choices'    => array(
            'list' => __('List Style', 'xshop-lite'),
            'grid' => __('Grid Style', 'xshop-lite'),
            'classic' => __('Classic Style', 'xshop-lite'),
        ),
    ));
    


}
add_action( 'customize_register', 'xshop_lite_customize_register',99 );

