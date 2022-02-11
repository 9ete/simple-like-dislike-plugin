<?php

    class Activation extends SimpleLikeDislike_Plugin {

        public static function sld_create_database($namespace, $version) {
            global $wpdb, $version;

            // if ( get_option( "sld_db_version" ) != $version ) {

                $table_name = $wpdb->prefix . $namespace;

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

                // update_option( "sld_db_version", $version );
            // }
        }

        public static function sld_add_db_entry($namespace, $version, $ip = '192.168.0.0.2', $feedback = 'dislike') {
            global $wpdb;
            // update_option( "sld_db_version", "1.0" );
            $table_name = $wpdb->prefix . $namespace;
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

        public static function sld_update_db_check($namespace, $version) {
            // echo "Simple Like Dislike version check {$version} " . get_site_option( 'sld_db_version' );
            if ( get_site_option( 'sld_db_version' ) != $version ) {
                self::sld_create_database($namespace,$version);
                self::sld_add_db_entry($namespace,$version);
            } else {
                self::sld_add_db_entry($ip = '192.168.0.0.4', $feedback = 'like');
            }
        }
    }