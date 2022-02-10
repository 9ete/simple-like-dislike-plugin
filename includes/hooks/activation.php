<?php

    function sld_create_database() {
        global $wpdb, $sld_db_version, $plugin_namespace;

        if ( $installed_ver != $sld_db_version ) {

            $table_name = $wpdb->prefix . $plugin_namespace;

            $sql = "CREATE TABLE $tablename (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                name tinytext NOT NULL,
                text text NOT NULL,
                url varchar(100) DEFAULT '' NOT NULL,
                PRIMARY KEY  (id)
            );";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );

            update_option( "sld_db_version", $sld_db_version );
        }
    }

    function sld_add_db_entry() {
        global $wpdb, $plugin_namespace;
        add_option( "sld_db_version", "1.0" );
        $table_name = $wpdb->prefix . $plugin_namespace;
        $welcome_name = 'Mr. WordPress';
        $welcome_text = 'Congratulations, you just completed the installation!';

        $wpdb->insert( 
            $table_name, 
            array( 
                'time' => current_time( 'mysql' ), 
                'name' => $welcome_name, 
                'text' => $welcome_text, 
            ) 
        );
    }

    function sld_update_db_check() {
        global $sld_db_version;
        // echo "sld version check {$sld_db_version} " . get_site_option( 'sld_db_version' );
        if ( get_site_option( 'sld_db_version' ) != $sld_db_version ) {
            sld_create_database();
        }
    }
    add_action( 'plugins_loaded', 'sld_update_db_check' );

    register_activation_hook( __FILE__, 'sld_create_database' );
    register_activation_hook( __FILE__, 'sld_add_db_entry' );