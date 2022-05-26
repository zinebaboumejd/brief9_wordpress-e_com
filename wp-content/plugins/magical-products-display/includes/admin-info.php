<?php
/*
* Magical products display info
*
*
*/
//Admin notice 
function mpd_display_admin_info()
{
    global $pagenow;
    if (get_option('mgpdreview5') || $pagenow == 'themes.php') {
        return;
    }
    $class = 'eye-notice notice notice-success is-dismissible';
    $message = __('<strong>A 5 stars review would be very helpful for me and encourage me a lot for adding more features in the Magical products Display plugin. <br> Hope you will give me five stars and stay with us. </strong> ', 'magical-products-display');
    $url1 = esc_url('https://wordpress.org/support/plugin/magical-products-display/reviews/?filter=5');

    printf('<div class="%1$s" style="padding:10px 15px 20px;"><p>%2$s</p><a target="_blank" class="button button-primary" href="%3$s" style="margin-right:10px">' . __('Yes, you deserve it', 'magical-products-display') . '</a><button class="button button-info mgpd-dismiss" style="margin-left:10px">' . __('No, Maybe later', 'magical-products-display') . '</button></div>', esc_attr($class), wp_kses_post($message), $url1);
}
add_action('admin_notices', 'mpd_display_admin_info');

function mpd_display_admin_info_init()
{
    if (isset($_GET['mgpdismissed']) && $_GET['mgpdismissed'] == 1) {
        //  delete_option('wpeditpass_rev');
        update_option('mgpdreview5', 1);
    }
}
add_action('init', 'mpd_display_admin_info_init');
