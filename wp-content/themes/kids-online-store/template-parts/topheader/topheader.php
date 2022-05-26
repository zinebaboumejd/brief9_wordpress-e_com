<?php
/**
 * Displays top header
 *
 * @package Kids Online Store
 */
?>

<div class="top-info">
	<div class="container">
		<?php if(get_theme_mod('kids_online_store_phone_number_info') != ''){ ?>
			<span><i class="fas fa-phone"></i><?php echo esc_html(get_theme_mod('kids_online_store_phone_number_info','')); ?></span>
		<?php }?>
		<?php if(get_theme_mod('kids_online_store_email_info') != ''){ ?>
			<span><i class="far fa-envelope"></i><?php echo esc_html(get_theme_mod('kids_online_store_email_info','')); ?></span>
		<?php }?>
	</div>
</div>