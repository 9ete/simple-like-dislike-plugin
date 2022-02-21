<?php
/**
 * Plugin Name:       Simple Like Dislike
 * Plugin URI:        
 * Description:       Add like/dislike feedback to all pages
 * Version:           0.0.3
 * Author:            9ete
 * Author URI:        9ete.dev
 * Text Domain:       simple-like-dislike
 * Domain Path:       /languages/
 *
 */

class SimpleLikeDislike_Plugin {
    public function __construct() {
        $this->plugin_dir = plugin_dir_url( __FILE__ );
        $this->plugin_version = get_file_data(__FILE__, array('Version' => 'Version'), false)['Version'];
        $this->plugin_namespace = 'simple_like_dislike';
        $this->load_dependencies();
        $this->install_db();
        $this->run_activation_hooks();
        $this->add_wp_actions();
    }
    protected function load_dependencies() {
        require_once( 'includes/helpers.php' );
        require_once( 'includes/hooks/admin.php' );
        require_once( 'includes/hooks/scripts.php' );
        require_once( 'includes/hooks/shortcode.php' );
        require_once( 'includes/hooks/database.php' );
    }
    protected function run_activation_hooks() {
        register_activation_hook( __FILE__, array( $this, 'install_db' ) );
        register_activation_hook( __FILE__, array( $this, 'check_db_version' ) );
    }
    protected function add_wp_actions() {
        add_action( 'plugins_loaded', array( $this, 'check_db_version' ) );
        add_action( 'wp_enqueue_scripts', array( 'Scripts', 'simple_like_dislike_scripts' ));
        add_action( 'wp_ajax_sld_submit_feedback', array( $this, 'sld_submit_feedback' ) );
        add_action( 'wp_ajax_nopriv_sld_submit_feedback', array( $this, 'sld_submit_feedback' ) );
        add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ) );
        add_shortcode( 'simple_like_dislike', array( 'Shortcode', 'simple_like_dislike_buttons' ) );
        if ( ! is_admin() ) {
            add_action('admin_bar_menu', array( 'Admin', 'add_toolbar_items'), 100);
        }
    }
    public function install_db() {
        Database::sld_create_database($this->plugin_namespace, $this->plugin_version);
    }
    public function check_db_version() {
        Database::sld_update_db_check($this->plugin_namespace, $this->plugin_version);
    }
    public function sld_submit_feedback() {
        Database::sld_add_db_entry($this->plugin_namespace, $this->plugin_version, wp_filter_nohtml_kses( $_POST['ip'] ), wp_filter_nohtml_kses( $_POST['postid'] ), wp_filter_nohtml_kses( $_POST['feedback'] ));
    }
    public function add_dashboard_widget() {
        wp_add_dashboard_widget( 'add_dashboard_widget', 'Simple Like/Dislike Info', array( 'Admin', 'widget_html' ) );
    }
}
global $SimpleLikeDislike_Plugin;
$SimpleLikeDislike_Plugin = new SimpleLikeDislike_Plugin();
