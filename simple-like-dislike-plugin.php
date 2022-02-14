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
        $this->plugin_version = get_plugin_data(__FILE__)['Version'];
        $this->plugin_namespace = 'simple_like_dislike';
        $this->load_dependencies();
        $this->install_db();
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
        require_once( 'includes/hooks/database.php' );
    }
    public function install_db() {
        Database::sld_create_database($this->plugin_namespace, $this->plugin_version);
    }
    public function update_db() {
        Database::sld_add_db_entry($this->plugin_namespace, $this->plugin_version);
    }
    public function check_db_version() {
        Database::sld_update_db_check($this->plugin_namespace, $this->plugin_version);
    }
    public function sld_submit_feedback() {
        global $wpdb;
        Database::sld_add_db_entry($this->plugin_namespace, $this->plugin_version, wp_filter_nohtml_kses( $_POST['ip'] ), wp_filter_nohtml_kses( $_POST['postid'] ), wp_filter_nohtml_kses( $_POST['feedback'] ));
        wp_die();
    }
    protected function add_wp_actions() {
        register_activation_hook( __FILE__, array( $this, 'install_db' ) );
        register_activation_hook( __FILE__, array( $this, 'check_db_version' ) );
        // add_action( 'wp_footer', array( $this,'displayShortcode' ) );
        add_action( 'plugins_loaded', array( $this, 'check_db_version' ) );
        add_action( 'wp_enqueue_scripts', array( 'Scripts', 'simple_like_dislike_scripts' ));
        add_action( 'wp_ajax_sld_submit_feedback', array( $this, 'sld_submit_feedback' ) );
        add_action( 'wp_ajax_nopriv_sld_submit_feedback', array( $this, 'sld_submit_feedback' ) );
        add_action('wp_dashboard_setup', array( $this, 'add_dashboard_widget' ) );
        if ( ! is_admin() ) {
            add_action('admin_bar_menu', array( $this, 'add_toolbar_items'), 100);
        }
    }

    public function widget_html() {
        global $wpdb;
        // get all posts - title, likes, dislikes
        // show top 10
        $posts_array = get_posts(array('order'=>'asc','numberposts' => -1, 'post_type' => 'page'));
        echo "<div><ul>";
        echo "<li style='display:flex;justify-content:space-between;font-weight:900;'>
                    <span>Post Title</span>
                    <span>
                        <span>Likes</span>
                        <span>Dislikes</span>
                    </span>
                </li>";
        foreach ($posts_array as $post) {
            $page_feedback = $this->get_current_page_feedback( $post->ID );
            // search simple like dislike table by id
            echo "<li style='display:flex;justify-content:space-between'>
                    <span><span style='display:none;'>" . $post->ID . "</span> " . $post->post_title . "</span>
                    <span style='margin-right: 25px;'>
                        <span>" . $page_feedback[0] . "</span><span style='width: 25px;display:inline-block;'> </span>
                        <span>" . $page_feedback[1] . "</span>
                    </span>
                </li>";
        }
        echo "</div></ul>";
    }

    public function add_dashboard_widget() {
        global $wp_meta_boxes;
        wp_add_dashboard_widget( 'add_dashboard_widget', 'Simple Like/Dislike Info', array( $this, 'widget_html' ) );
    }

    public function add_toolbar_items($admin_bar){
        $page_feedback = $this->get_current_page_feedback( get_the_ID() );
        $likes = $page_feedback[0];
        $dislikes = $page_feedback[1];
        $admin_bar->add_menu( array(
            'id'    => 'sld-page-count',
            'title' => "$likes likes - $dislikes dislikes",
            'href'  => '/'
        ));
    }

    public function get_current_page_feedback($post_id) {
        global $wpdb;
        $feedback_info = $wpdb->get_results( // search DB for IP
            $wpdb->prepare("SELECT * FROM wp_simple_like_dislike WHERE post_id = %d", $post_id)
        );
        // var_dump($feedback_info);
        $likes = 0;
        $dislikes = 0;

        foreach ($feedback_info as $feedback) {
            if ( $feedback->feedback === 'like' ) {
                $likes++;
            }
            if ( $feedback->feedback === 'dislike' ) {
                $dislikes++;
            }
        }

        return [$likes, $dislikes];
    }
}
global $SimpleLikeDislike_Plugin;
$SimpleLikeDislike_Plugin = new SimpleLikeDislike_Plugin();
