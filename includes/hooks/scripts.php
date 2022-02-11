<?php
class Scripts extends SimpleLikeDislike_Plugin {
    public static function simple_like_dislike_scripts() {   
        global $SimpleLikeDislike_Plugin;
        wp_enqueue_script( 'simple-like-dislike-js', $SimpleLikeDislike_Plugin->plugin_dir . '/js/scripts.js', array( 'jquery' ), '20202020', true );
        wp_localize_script( 'simple-like-dislike-js', 'simple_like_dislike_js_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }
}