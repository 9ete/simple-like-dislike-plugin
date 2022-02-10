<?php
function simple_like_dislike_scripts() {   
    global $plugin_dir;
    wp_enqueue_script( 'simple-like-dislike-js', $plugin_dir . '/js/scripts.js', array( 'jquery' ), '20202020', true );
    wp_localize_script( 'simple-like-dislike-js', 'simple_like_dislike_js_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );
}
add_action('wp_enqueue_scripts', 'simple_like_dislike_scripts');

add_action( 'wp_ajax_sld_submit_feedback', 'sld_submit_feedback' );
add_action( 'wp_ajax_nopriv_sld_submit_feedback', 'sld_submit_feedback' );
function sld_submit_feedback() {
    global $wpdb;
    $whatever = intval( $_POST['whatever'] );
    $whatev = $_POST['whatever'];
    // $whatever =+ 10;
    echo ( 10 + intval($whatev) ) . ' - ' . $whatever;
    wp_die();
}

function sld_check_entry_id() {

}

function sld_add_entry() {

}

function sld_update_entry() {

}

function sld_delete_entry() {
    
}