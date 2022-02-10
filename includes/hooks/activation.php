<?php


    global $sld_db_version, $plugin_namespace;
    $sld_db_version = '1.0.0';
    $plugin_namespace = 'simple_like_dislike';

    function sld_create_database() {
        global $wpdb, $sld_db_version, $plugin_namespace;

        // if ( get_option( "sld_db_version" ) != $sld_db_version ) {

            $table_name = $wpdb->prefix . $plugin_namespace;

            $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                feedback text NOT NULL,
                userip text NOT NULL,
                time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                url varchar(100) DEFAULT '' NOT NULL,
                PRIMARY KEY  (id)
            );";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );

            update_option( "sld_db_version", $sld_db_version );
        // }
    }

    function sld_add_db_entry($ip = '192.168.0.0.2', $feedback = 'dislike') {
        global $wpdb, $plugin_namespace;
        // update_option( "sld_db_version", "1.0" );
        $table_name = $wpdb->prefix . $plugin_namespace;
        $user_ip = $ip;
        $user_feedback = $feedback;

        $wpdb->insert( 
            $table_name, 
            array( 
                'time' => current_time( 'mysql' ), 
                'userip' => $user_ip, 
                'feedback' => $user_feedback, 
            ) 
        );
    }

    function sld_update_db_check() {
        global $sld_db_version;
        // echo "sld version check {$sld_db_version} " . get_site_option( 'sld_db_version' );
        if ( get_site_option( 'sld_db_version' ) != $sld_db_version ) {
            sld_create_database();
            sld_add_db_entry();
        } else {
            sld_add_db_entry($ip = '192.168.0.0.4', $feedback = 'like');
        }
    }
    // add_action( 'plugins_loaded', 'sld_update_db_check' );
    register_activation_hook( __FILE__, 'sld_create_database' );
    register_activation_hook( __FILE__, 'sld_add_db_entry' );