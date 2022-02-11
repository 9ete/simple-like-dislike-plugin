<?php
class Scripts extends SimpleLikeDislike_Plugin {
    function simple_like_dislike_scripts() {   
        global $SimpleLikeDislike_Plugin;
        wp_enqueue_script( 'simple-like-dislike-js', $SimpleLikeDislike_Plugin->plugin_dir . '/js/scripts.js', array( 'jquery' ), '20202020', true );
        wp_localize_script( 'simple-like-dislike-js', 'simple_like_dislike_js_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );
    }
    function sld_submit_feedback() {
        global $wpdb;
        $whatever = intval( $_POST['whatever'] );
        $whatev = $_POST['whatever'];
        // $whatever =+ 10;
        echo ( 10 + intval($whatev) ) . ' - ' . $whatever;
        wp_die();
    }

    public function sld_check_entry_id() {

    }

    public function sld_add_entry() {

    }

    public function sld_update_entry() {

    }

    public function sld_delete_entry() {

    }
}