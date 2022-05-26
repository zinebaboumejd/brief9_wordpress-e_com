<?php
/**
 * Displays top navigation
 *
 * @package Kids Online Store
 */

$kids_online_store_sticky_header = get_theme_mod('kids_online_store_sticky_header');
    $data_sticky = "false";
    if ($kids_online_store_sticky_header) {
        $data_sticky = "true";
    }
?>
<div class="header-menu" data-sticky="<?php echo esc_attr($data_sticky); ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-9">
                <div class="navbar-brand">
                    <?php if ( has_custom_logo() ) : ?>
                        <div class="site-logo"><?php the_custom_logo(); ?></div>
                    <?php endif; ?>
                    <?php $blog_info = get_bloginfo( 'name' ); ?>
                        <?php if ( ! empty( $blog_info ) ) : ?>
                            <?php if ( is_front_page() && is_home() ) : ?>
                            <?php if( get_theme_mod('kids_online_store_logo_title',true) != ''){ ?>
                                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                            <?php }?>
                            <?php else : ?>
                                <?php if( get_theme_mod('kids_online_store_logo_title',true) != ''){ ?>
                                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                                <?php }?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php
                            $description = get_bloginfo( 'description', 'display' );
                            if ( $description || is_customize_preview() ) :
                        ?>
                        <?php if( get_theme_mod('kids_online_store_logo_text',true) != ''){ ?>
                            <p class="site-description"><?php echo esc_html($description); ?></p>
                        <?php } ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-3 col-3">
                <div class="toggle-nav mobile-menu">
                    <?php if(has_nav_menu('primary')){ ?>
                        <button onclick="kids_online_store_openNav()"><i class="fas fa-th"></i></button>
                    <?php }?>
                </div>
                <div id="mySidenav" class="nav sidenav">
                    <nav id="site-navigation" class="main-navigation navbar navbar-expand-xl" aria-label="<?php esc_attr_e( 'Top Menu', 'kids-online-store' ); ?>">
                        <?php if(has_nav_menu('primary')){
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'primary',
                                    'menu_class'     => 'menu',
                                    'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                )
                            );
                        } ?>
                    </nav>
                    <a href="javascript:void(0)" class="closebtn mobile-menu" onclick="kids_online_store_closeNav()"><i class="far fa-times-circle"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-5">
                <div class="social-link">
                    <?php if(class_exists('woocommerce')){ ?>
                        <?php global $woocommerce; ?>
                        <a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e( 'shopping cart','kids-online-store' ); ?>"><i class="fas fa-shopping-cart"></i></a>
                    <?php }?>
                    <?php if(get_theme_mod('kids_online_store_facebook_url') != ''){ ?>
                        <a href="<?php echo esc_url(get_theme_mod('kids_online_store_facebook_url','')); ?>"><i class="fab fa-facebook-f"></i></a>
                    <?php }?>
                    <?php if(get_theme_mod('kids_online_store_twitter_url') != ''){ ?>
                        <a href="<?php echo esc_url(get_theme_mod('kids_online_store_twitter_url','')); ?>"><i class="fab fa-twitter"></i></a>
                    <?php }?>
                    <?php if(get_theme_mod('kids_online_store_intagram_url') != ''){ ?>
                        <a href="<?php echo esc_url(get_theme_mod('kids_online_store_intagram_url','')); ?>"><i class="fab fa-instagram"></i></a>
                    <?php }?>
                    <?php if(get_theme_mod('kids_online_store_linkedin_url') != ''){ ?>
                        <a href="<?php echo esc_url(get_theme_mod('kids_online_store_linkedin_url','')); ?>"><i class="fab fa-linkedin-in"></i></a>
                    <?php }?>
                    <?php if(get_theme_mod('kids_online_store_pintrest_url') != ''){ ?>
                        <a href="<?php echo esc_url(get_theme_mod('kids_online_store_pintrest_url','')); ?>"><i class="fab fa-pinterest-p"></i></a>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>