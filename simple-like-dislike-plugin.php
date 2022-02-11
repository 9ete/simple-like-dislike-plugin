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

class SimpleLikeDislike_Plugin {
    public static $plugin_dir;
    public static $plugin_version;
    public static $plugin_namespace;
    public function __construct() {
        $this->plugin_dir = plugin_dir_url( __FILE__ );
        $this->plugin_version = '0.0.3';//( $version = get_option('sld_db_version') ? $version : '0.0.1' );
        $this->plugin_namespace = 'simple_like_dislike';
        $this->load_dependencies();
        $this->install();
        $this->add_wp_actions();
    }
    public function get_value($value_name) {
        return $this->{$value_name};
    }
    public function display_value($value_name) {
       echo $this->get_value($value_name);
    }
    protected function load_dependencies() {
        require_once( 'includes/helpers.php' );
        require_once( 'includes/hooks/scripts.php' );
        require_once( 'includes/hooks/shortcode.php' );
        require_once( 'includes/hooks/activation.php' );
    }
    protected function install() {
        Activation::sld_create_database($this->plugin_namespace, $this->plugin_version);
        Activation::sld_add_db_entry($this->plugin_namespace, $this->plugin_version);
    }
    protected function update_db() {
        Activation::sld_add_db_entry($this->plugin_namespace, $this->plugin_version);
    }
    public function check_db_version() {
        Activation::sld_update_db_check($this->plugin_namespace, $this->plugin_version);
    }
    protected function add_wp_actions() {
        register_activation_hook( __FILE__, array( $this, 'install' ) );
        register_activation_hook( __FILE__, array( $this, 'update_db' ) );
        add_action( 'wp_footer', array( 'Helpers','displayShortcode' ) );
        add_action( 'plugins_loaded', array( $this, 'check_db_version' ) );
        add_action('wp_enqueue_scripts', array( 'Scripts', 'simple_like_dislike_scripts' ));
        add_action( 'wp_ajax_sld_submit_feedback', array( 'Scripts', 'sld_submit_feedback' ) );
        add_action( 'wp_ajax_nopriv_sld_submit_feedback', array( 'Scripts', 'sld_submit_feedback' ) );
    }
}
global $SimpleLikeDislike_Plugin;
$SimpleLikeDislike_Plugin = new SimpleLikeDislike_Plugin();

// create database entry
// create admin
    // create entries list
// support do_shortcode