<?php 
/*This file is part of Startup Shop, Startup Store child theme.

All functions of this file will be loaded before of parent theme functions.
Learn more at https://codex.wordpress.org/Child_Themes.

Note: this function loads the parent stylesheet before, then child theme stylesheet
(leave it in place unless you know what you are doing.)
*/

if( !function_exists('startup_store_theme_setup') ):
    function startup_store_theme_setup(){
        // Make theme available for translation.
        load_theme_textdomain( 'startup-store', get_stylesheet_directory_uri() . '/languages' );
    }
    add_action( 'after_setup_theme', 'startup_store_theme_setup' );
endif;

if ( ! function_exists( 'startup_store_enqueue_child_styles' ) ) {
    function startup_store_enqueue_child_styles() {
        // loading parent style
        wp_register_style(
          'startup-parent-style',
          get_template_directory_uri() . '/style.css'
        );

        wp_enqueue_style( 'startup-parent-style' );
        // loading child style
        wp_register_style(
          'startup-store-style',
          get_stylesheet_directory_uri() . '/style.css'
        );
        wp_enqueue_style( 'startup-store-style');
        
     }
}
add_action( 'wp_enqueue_scripts', 'startup_store_enqueue_child_styles',999  );


if( !function_exists('startup_store_disable_from_parent') ):

    add_action('init','startup_store_disable_from_parent',50);
    function startup_store_disable_from_parent(){
        
        global $startup_shop_Header_Layout;

        remove_action('startup_shop_site_header', array( $startup_shop_Header_Layout, 'site_header_layout' ), 30 );

        remove_action( 'woocommerce_before_main_content', 'startup_shop_woocommerce_wrapper_before' );
        remove_action( 'woocommerce_after_main_content', 'startup_shop_woocommerce_wrapper_after' );
    }
    
endif;

if( !function_exists('startup_store_header_layout') ):
    add_action('startup_shop_site_header','startup_store_header_layout', 30 );
/**
* Container before
*
* @return $html
*/
function startup_store_header_layout(){
    ?>
    <header id="masthead" class="site-header">
    
        <div class="container">
            <div class="header-table">
                <div class="table-cell branding-wrap">
                    <div class="block">
                        <?php do_action('startup_shop_header_layout_1_branding');?>
                    </div>
                </div>
                
                <div class="table-cell text-right">
                    <?php
                    if ( is_active_sidebar( 'logo-right' ) ) {
                        
                        dynamic_sidebar( 'logo-right' );

                    }else if( class_exists('APSW_Product_Search_Finale_Class') || class_exists('APSW_Product_Search_Finale_Class_Pro') ){

                        do_action('apsw_search_bar_preview');

                    }
                    
                    if ( class_exists( 'WooCommerce' ) ) :
                        ?>
                        <div class="menu-category-list responsive" tabindex="0" autofocus="true">
                            <span class="click-event" >
                                <i class="icofont-navigation-menu"></i> 
                              <?php echo esc_html__('ALL CATEGORIES','startup-store');?>
                            </span>
                            <?php 
                                $instance = array(
                                    'title' => '',
                                    'before_widget' => '',
                                    'after_widget' => '',

                                );  
                                the_widget( 'WC_Widget_Product_Categories', $instance, $instance );
                            ?>
                        </div>
                        <?php endif;?>
                    <button class="startup-shop-rd-navbar-toggle" tabindex="0" autofocus="true"><i class="icofont-navigation-menu"></i></button>
                    
                </div>

                
            </div>
        </div>
        
        <nav id="navbar">
        <div class="container">
            <div class="row">
                <div class="col-md-10 my-auto d-flex">
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <div class="menu-category-list" tabindex="0" autofocus="true">
                    <span class="click-event">
                        <i class="icofont-navigation-menu"></i><?php echo esc_html__('ALL CATEGORIES','startup-store');?>
                    </span>
                    <?php 
                        $instance = array(
                            'title' => '',
                        );  
                        the_widget( 'WC_Widget_Product_Categories', $instance, $instance );
                    ?>
                </div>
                <?php endif;?>
                
                <?php do_action('startup_shop_header_layout_1_navigation');?></div>

                <div class="col-md-2 text-right"><?php //echo wp_kses( $this->get_site_header_icon(), $this->alowed_tags() ); ?></div>
            </div>
        </div>
        <div class="clearfix"></div>
        </nav>

       
        
    </header>
    <?php       
}
endif;

if( !function_exists('startup_store_filter_default_options') ):
    function startup_store_filter_default_options( $value ) {

        $value['blog_layout']         = 'sidebar-content';
        $value['single_post_layout']  = 'sidebar-content';
        
        return $value;
    }
    add_filter( 'startup_shop_filter_default_theme_options', 'startup_store_filter_default_options' );
endif;


/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function startup_store_woocommerce_loop_columns() {
    return 4;
}
add_filter( 'loop_shop_columns', 'startup_store_woocommerce_loop_columns',999 );

//add_filter( 'loop_shop_columns', 'startup_shop_woocommerce_loop_columns' );

if ( ! function_exists( 'startup_store_woocommerce_wrapper_before' ) ) {
   
    /**
     * Before Content.
     *
     * Wraps all WooCommerce content in wrappers which match the theme markup.
     *
     * @return void
     */
    function startup_store_woocommerce_wrapper_before() {
        /**
        * Hook - startup_shop_container_wrap_start  
        *
        * @hooked startup_shop_container_wrap_start - 5
        */
         $layout = ( is_shop() || is_product_category() ) ? 'full-container': 'no-sidebar';
         
         do_action( 'startup_shop_container_wrap_start', esc_attr( $layout ) );
    }
   
    add_action( 'woocommerce_before_main_content', 'startup_store_woocommerce_wrapper_before' );
}



if ( ! function_exists( 'startup_store_woocommerce_wrapper_after' ) ) {
    /**
     * After Content.
     *
     * Closes the wrapping divs.
     *
     * @return void
     */
    function startup_store_woocommerce_wrapper_after() {
        /**
        * Hook - startup_shop_container_wrap_end    
        *
        * @hooked container_wrap_end - 999
        */
        $layout = ( is_shop() || is_product_category() ) ? 'full-container': 'no-sidebar';
         
        do_action( 'startup_shop_container_wrap_end', esc_attr( $layout ) );
    }
  
   add_action( 'woocommerce_after_main_content', 'startup_store_woocommerce_wrapper_after' );

}
