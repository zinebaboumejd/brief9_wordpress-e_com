<?php
/**
 * Displays top header
 *
 * @package Kids Gift Shop
 */
?>

<div class="top-info">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-8 align-self-center">
				<?php if(get_theme_mod('kids_online_store_email_info') != ''){ ?>
					<span><i class="far fa-envelope"></i><?php esc_html_e( 'Email: ','kids-gift-shop' ); ?><?php echo esc_html(get_theme_mod('kids_online_store_email_info','')); ?></span>
				<?php }?>
				<?php if(get_theme_mod('kids_online_store_phone_number_info') != ''){ ?>
					<span><i class="fas fa-phone"></i><?php esc_html_e( 'Call Us: ','kids-gift-shop' ); ?><?php echo esc_html(get_theme_mod('kids_online_store_phone_number_info','')); ?></span>
				<?php }?>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 align-self-center">
                <div class="social-link">
                    <?php if(get_theme_mod('kids_online_store_facebook_url') != ''){ ?>
                        <a href="<?php echo esc_url(get_theme_mod('kids_online_store_facebook_url','')); ?>"><i class="fab fa-facebook-f mr-3"></i></a>
                    <?php }?>
                    <?php if(get_theme_mod('kids_online_store_twitter_url') != ''){ ?>
                        <a href="<?php echo esc_url(get_theme_mod('kids_online_store_twitter_url','')); ?>"><i class="fab fa-twitter mr-3"></i></a>
                    <?php }?>
                    <?php if(get_theme_mod('kids_online_store_intagram_url') != ''){ ?>
                        <a href="<?php echo esc_url(get_theme_mod('kids_online_store_intagram_url','')); ?>"><i class="fab fa-instagram mr-3"></i></a>
                    <?php }?>
                    <?php if(get_theme_mod('kids_online_store_linkedin_url') != ''){ ?>
                        <a href="<?php echo esc_url(get_theme_mod('kids_online_store_linkedin_url','')); ?>"><i class="fab fa-linkedin-in mr-3"></i></a>
                    <?php }?>
                    <?php if(get_theme_mod('kids_online_store_pintrest_url') != ''){ ?>
                        <a href="<?php echo esc_url(get_theme_mod('kids_online_store_pintrest_url','')); ?>"><i class="fab fa-pinterest-p"></i></a>
                    <?php }?>
                </div>
			</div>
		</div>
	</div>
</div>