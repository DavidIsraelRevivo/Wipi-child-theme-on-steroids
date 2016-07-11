<?php
/**
 * Functions.php file for WiPi child theme on Steroids.
 *
 * @package   wipi-child-theme-on-steroids
 * @version   1.0.6
 * @link      http://www.davidrevivo.co.il/
 * @author    David Israel Revivo
 * @copyright Copyright (c) 2016, David Israel Revivo
 * @license   GPL-2.0+
 */

 // Enqueue css files from parent theme
 add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
 function my_theme_enqueue_styles() {
     wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
 }

// Include TGMPA class
require_once get_stylesheet_directory() . '/lib/tgm/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'wipi_child_theme_on_steroids_require_plugins' );

// Register "ACF-Pro" plugin
function wipi_child_theme_on_steroids_require_plugins() {

	$plugins = array(
	array(
	'name'	=> 'Adanced Custom Fields Pro',
	'slug'	=> 'acf-pro',
	'source'	=> get_stylesheet_directory_uri() . '/lib/plugins/advanced-custom-fields-pro.zip',
	'required'	=> true,
	'version'	=> '5.3.7',
	'force_deactivation'	=> true, // if the theme is disabled the acf will disabled too.
	'force_activation'	=> true // if the theme is activated the acf will activated too.
	)
	);

	$config = array (
	'id'	=> 'wipi_child_theme_on_steroids-tgmpa',
	'default_path'	=> get_stylesheet_directory_uri() . '/lib/plugins/',
	'menu'	=> 'wipi_child_theme_on_steroids-install-required-plugins',
	'has_notices'	=> true,
	'dismissble'	=> false,
	'dismiss_msg'  => 'על מנת להנות מכל האפשרויות של התבנית עלייך להתקין את התוספים הנדרשים', // this message will be output at top of nag
	'is_automatic'	=> true,
    'message'      => '<!--Hey there.-->' // message to output right before the plugins table
	);

tgmpa( $plugins, $config );
}

// If ACF pro is activate (Check if the class exist).
if (class_exists('acf'))  {
  // Create the options page
  if( function_exists('acf_add_options_page') ) {
  	acf_add_options_page(array(
  		'page_title'	=> 'Child Theme on Steroids Features',
  		'menu_title'	=> 'Theme Features',
  		'menu-slug'		=> 'child-theme-on-steroids-features'
  	));
  }
  // Include the data of the custom fields groups.
    require_once ('lib/cfg-acf.php');

  // Include the built-in Features
    require_once ('lib/features.php');
}
?>
