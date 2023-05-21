<?php
/**
 * Plugin Name:       Simple Like Dislike
 * Plugin URI:        
 * Description:       Add like/dislike feedback to all pages
 * Version:           0.0.2
 * Author:            9ete
 * Author URI:        9ete.dev
 * GitHub Plugin URI: 9ete/simple-like-dislike-plugin
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
        $this->run_activation_hooks();
        $this->add_wp_actions();
    }
    /*
     * Dependencies
     *
     */
    protected function load_dependencies() {
        $dependency_array = [
            'includes/helpers.php',
            'includes/hooks/admin.php',
            'includes/hooks/scripts.php',
            'includes/hooks/shortcode.php',
            'includes/hooks/database.php'
        ];
        foreach ($dependency_array as $dependency) {
            require_once( $dependency );
        }
    }
    /*
     * Install table when plugin is activated, only if needed
     *
     */
    protected function run_activation_hooks() {
        register_activation_hook( __FILE__, array( $this, 'install_table_if_needed' ) );
    }
    /*
     * Actions
     *
     */
    protected function add_wp_actions() {
        add_action( 'plugins_loaded', array( $this, 'install_table_if_needed' ) );
        add_action( 'wp_enqueue_scripts', array( 'Scripts', 'simple_like_dislike_scripts' ));
        add_action( 'wp_ajax_sld_submit_feedback', array( $this, 'submit_input_feedback' ) );
        add_action( 'wp_ajax_nopriv_sld_submit_feedback', array( $this, 'submit_input_feedback' ) );
        add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ) );
        add_shortcode( 'simple_like_dislike', array( 'Shortcode', 'simple_like_dislike_buttons' ) );
        if ( ! is_admin() ) {
            add_action('admin_bar_menu', array( 'Admin', 'add_toolbar_items'), 100);
        }
    }
    /*
     * Will check if table is installed and if so what version, will install or update db table as needed
     *
     */
    public function install_table_if_needed() {
        Database::sld_create_table_if_needed($this->plugin_namespace, $this->plugin_version);
    }
    /*
     * Submit like/dislike feedback from front end
     *
     */
    public function submit_input_feedback() {
        Database::sld_add_db_entry($this->plugin_namespace, $this->plugin_version, wp_filter_nohtml_kses( $_POST['ip'] ), wp_filter_nohtml_kses( $_POST['postid'] ), wp_filter_nohtml_kses( $_POST['feedback'] ));
    }
    /*
     * Add dashboard widget to see results
     *
     */
    public function add_dashboard_widget() {
        wp_add_dashboard_widget( 'add_dashboard_widget', 'Simple Like/Dislike Info', array( 'Admin', 'widget_html' ) );
    }
}
global $SimpleLikeDislike_Plugin;
$SimpleLikeDislike_Plugin = new SimpleLikeDislike_Plugin();