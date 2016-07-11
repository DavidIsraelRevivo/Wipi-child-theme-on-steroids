<?php
// Security functions:
// Hide WordPress version
$hide_wp_version = get_field('hide_wp_version', 'option');
if ($hide_wp_version == "yes") {
  remove_action('wp_head', 'wp_generator');
}
// Disable the themes and plugins text editor in Admin panel
$disable_edit_in_control_panel = get_field('disable_edit_in_control_panel', 'option');
if ($disable_edit_in_control_panel == "yes") {
  define('DISALLOW_FILE_EDIT', true);
}
// single login error message in wp-login
$hide_wp_login_errors = get_field('hide_wp_login_errors', 'option');
if ($hide_wp_login_errors == "yes") {
  function wpfme_login_obscure() {
    $single_login_error_message = get_field('single_login_error_message', 'option');
    return $single_login_error_message;
  }
  add_filter( 'login_errors', 'wpfme_login_obscure' );
}
// Appereance functions:
// Change Admin footer text
function remove_footer_admin () {
  $change_wp_admin_footer_text = get_field('change_wp_admin_footer_text', 'option');
  return $change_wp_admin_footer_text;
}
add_filter('admin_footer_text', 'remove_footer_admin');

// Change wp-login Logo
function my_custom_login_logo() {
  $change_wp_login_logo = get_field('change_wp_login_logo', 'option');
  echo '<style type="text/css"> h1 a { background-image: url("'. $change_wp_login_logo .'") !important; }
  </style>';
}
add_action('login_head', 'my_custom_login_logo');

// Change wp-login logo url
function custom_login_url() {
  $change_wp_login_logo_url = get_field('change_wp_login_logo_url', 'option');
  return $change_wp_login_logo_url;
}
add_filter( 'login_headerurl', 'custom_login_url' );

// Change wp-login logo title
function custom_login_title() {
  $change_wp_login_title = get_field('change_wp_login_title', 'option');
  return $change_wp_login_title;
}
add_filter( 'login_headertitle', 'custom_login_title' );

// Performance functions:
// Load js in footer
$load_js_in_footer = get_field('load_js_in_footer', 'option');
if ($load_js_in_footer == "yes") {
  function remove_head_scripts() {
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);

    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5);
  }
  add_action( 'wp_enqueue_scripts', 'remove_head_scripts' );
}
// Use Google CDN to load Jquery
$load_jquery_google_cdn = get_field('load_jquery_google_cdn', 'option');
if ($load_jquery_google_cdn == "yes") {
  function google_jquery_cdn() {
    if (!is_admin()) {
      wp_deregister_script('jquery');
      wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js', false, null);
      wp_enqueue_script('jquery');
    }
  }
  add_action('init', 'google_jquery_cdn');
}
// Disable emoji icons
$disable_emoji = get_field('disable_emoji', 'option');
if ($disable_emoji == "yes") {
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
    /* Warning: If you have TinyMCE plugin I
    highly recommended to remove this function because this function cause to
    some bugs like Color text button doesnt appear, etc. */
    add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
  }
  add_action( 'init', 'disable_wp_emojicons' );
}

// Remove Query strings
$remove_query_strings = get_field('remove_query_strings', 'option');
if ($remove_query_strings == "yes") {
  function remove_script_version( $src ){
    $parts = explode( '?ver', $src );
      return $parts[0];
  }
  add_filter( 'script_loader_src', 'remove_script_version', 15, 1 );
  add_filter( 'style_loader_src', 'remove_script_version', 15, 1 );
}
 ?>
