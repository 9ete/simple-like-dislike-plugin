<?php
function simple_like_dislike_scripts() {   
    wp_enqueue_script( 'simple-like-dislike-js', plugin_dir_url( __FILE__ ) . '../../js/scripts.js' );
}
add_action('wp_enqueue_scripts', 'simple_like_dislike_scripts');