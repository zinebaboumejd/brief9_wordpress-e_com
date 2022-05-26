<?php 
/*This file is part of BeShop child theme.

All functions of this file will be loaded before of parent theme functions.
Learn more at https://codex.wordpress.org/Child_Themes.

Note: this function loads the parent stylesheet before, then child theme stylesheet
(leave it in place unless you know what you are doing.)
*/

if ( ! defined( 'XSHOP_LITE_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'XSHOP_LITE_VERSION', '1.0.2' );
}



function xshop_lite_fonts_url() {
	$fonts_url = '';

		$font_families = array();

		$font_families[] = 'Gemunu Libre:400,500,700';
		$font_families[] = 'Roboto Condensed:400,500,500i,700,700i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );


	return esc_url_raw( $fonts_url );
}


function xshop_lite_enqueue_child_styles() {
	wp_enqueue_style( 'xshop-lite-google-font',xshop_lite_fonts_url(), array(), null );
	wp_enqueue_style( 'xshop-lite-parent-style', get_template_directory_uri() . '/style.css',array('xshop-main-style','xshop-main-style','xshop-google-font', 'xshop-default-style', 'xshop-responsive-style','xshop-woocommerce-style'), '', 'all');
   wp_enqueue_style( 'xshop-lite-main',get_stylesheet_directory_uri() . '/assets/css/main.css',array(), XSHOP_LITE_VERSION, 'all');


  
}
add_action( 'wp_enqueue_scripts', 'xshop_lite_enqueue_child_styles');




/**
 * Customizer additions.
 */
 require get_stylesheet_directory() . '/inc/customizer.php';
// // Nav walker for menu


function xshop_lite_header_top_output(){
?>
	<header id="masthead" class="site-header <?php if( has_header_image() ): ?>has-head-img<?php endif; ?>">
			<?php if( has_header_image() ): ?>
				<?php if( has_header_image() ): ?>
				<div class="header-img"> 
					<?php the_header_image_tag(); ?>
				</div>
				<?php endif; ?>
			<?php endif; ?>
		

        <div class="menu-bar text-center">
			<div class="container">
				<div class="col-auto">
				<?php
			if(has_custom_logo() || display_header_text() == true || (display_header_text() == true && is_customize_preview()) ): ?>
			<div class="site-branding brand-logo">
				<?php
				if(has_custom_logo()):
					the_custom_logo();
				endif;
				?>
			</div>
			<div class="site-branding brand-text">
					<?php if (display_header_text() == true || (display_header_text() == true && is_customize_preview()) ): ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php
						$xshop_description = get_bloginfo( 'description', 'display' );
						if ( $xshop_description || is_customize_preview() ) :
							?>
							<p class="site-description"><?php echo $xshop_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
						<?php endif; ?>	
					<?php endif; ?>	

			</div><!-- .site-branding -->
			
		<?php endif; ?>
				</div>
				<div class="col-auto">
					<div class="xshop-container menu-inner">
						<nav id="site-navigation" class="main-navigation">
							<?php
								wp_nav_menu( array(
									'theme_location' => 'main-menu',
									'menu_id'        => 'xshop-menu',
									'menu_class'        => 'xshop-menu',
								) );
							?>
						</nav><!-- #site-navigation -->	
					</div>
				</div>
				
			</div>
		</div>

		

		
	</header><!-- #masthead -->


<?php
}
add_action('xshop_lite_header','xshop_lite_header_top_output');