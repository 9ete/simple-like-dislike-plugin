<?php
/**
 * Plugin Name:       Simple Like Dislike
 * Plugin URI:        
 * Description:       
 * Version:           0.0.1
 * Author:            9ete
 * Author URI:        9ete.dev
 * Text Domain:       simple-like-dislike
 * Domain Path:       /languages/
 *
 */
global $sld_db_version, $plugin_namespace, $plugin_dir;
$sld_db_version = '1.0.0';
$plugin_namespace = 'simple_like_dislike';
$plugin_dir = plugin_dir_url( __FILE__ );

require_once( 'includes/helpers.php' );
// enqueue JS
require_once( 'includes/hooks/activation.php' );
require_once( 'includes/hooks/scripts.php' );
require_once( 'includes/hooks/shortcode.php' );

function displayShortcode() {
    return do_shortcode('[simple_like_dislike]');   
}

add_action( 'wp_footer', 'displayShortcode' );

// create database entry
// create admin
    // create entries list
// support do_shortcode