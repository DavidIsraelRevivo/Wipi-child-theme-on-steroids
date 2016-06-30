<?php
// Enqueue css files from parent theme
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

// 1. Hide WordPress version
remove_action('wp_head', 'wp_generator');

// 2. Disable emoji icons

function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );

  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );

  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );

  remove_action( 'wp_print_styles', 'print_emoji_styles' );

  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );

  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  // Warning: If you have TinyMCE plugin I highly recommended to remove this function because this function cause to some bugs like Color text button doesnt appear, etc.
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );

}

add_action( 'init', 'disable_wp_emojicons' );


// 3. Disable the themes and plugins text editor in Admin panel
define('DISALLOW_FILE_EDIT', true);

// 4. single login error message in wp-login
function wpfme_login_obscure(){ return '<strong>אופס!</strong> נראה שהפרטים שגויים!';}
add_filter( 'login_errors', 'wpfme_login_obscure' );

// 5. Change Admin footer text
function remove_footer_admin () { return '<a href="https://www.davidrevivo.co.il/wipi-child-theme-%D7%AA%D7%91%D7%A0%D7%99%D7%AA-%D7%91%D7%AA/" alt="WiPi Child theme on steroids to download">WiPi Child Theme on Steroids</a>'; } add_filter('admin_footer_text', 'remove_footer_admin');

// 6. Change wp-login Logo
function my_custom_login_logo() { echo '<style type="text/css"> h1 a { background-image: url(http://your-domain.com/image-path.png) !important; }
 </style>'; } add_action('login_head', 'my_custom_login_logo');

// 7. Change wp-login logo url
function custom_login_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'custom_login_url' );

// 8. Change wp-login logo title
function custom_login_title() {
    return get_option( 'blogname' );
}
add_filter( 'login_headertitle', 'custom_login_title' );

// 9. Load js in footer
function remove_head_scripts() {
   remove_action('wp_head', 'wp_print_scripts');
   remove_action('wp_head', 'wp_print_head_scripts', 9);
   remove_action('wp_head', 'wp_enqueue_scripts', 1);
 
   add_action('wp_footer', 'wp_print_scripts', 5);
   add_action('wp_footer', 'wp_enqueue_scripts', 5);
   add_action('wp_footer', 'wp_print_head_scripts', 5);
}
add_action( 'wp_enqueue_scripts', 'remove_head_scripts' );

// 10. Use Google CDN to load Jquery
function savvy_remove_jquery_migrate_use_google_hosted_jquery() {
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js', false, null);
        wp_enqueue_script('jquery');
    }
}
add_action('init', 'savvy_remove_jquery_migrate_use_google_hosted_jquery');

// 11. Remove Query Strings
function _remove_script_version( $src ){
	$parts = explode( '?ver', $src );
        return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

?>
