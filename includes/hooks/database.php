<?php

    class Database {

        public static function sld_create_database($namespace, $version) {
            global $wpdb;

            if ( get_option( "sld_db_version" ) != $version || ! self::sld_does_table_exist() ) {

                $table_name = $wpdb->prefix . $namespace;

                // IF CHANGED: make sure version is changed so DB updates
                $sql = "CREATE TABLE $table_name (
                    id mediumint(9) NOT NULL AUTO_INCREMENT,
                    feedback text NOT NULL,
                    post_id bigint(20),
                    userip text NOT NULL,
                    userip_num bigint NOT NULL,
                    time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                    PRIMARY KEY  (id),
                    INDEX post_id_ind (post_id)
                );";

                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta( $sql );

                update_option( "sld_db_version", $version );
            }
        }

        public static function sld_add_db_entry($namespace, $version, $ip = '192.168.0.0.2', $postid = 0, $feedback = 'dislike') {
            global $wpdb;
            // update_option( "sld_db_version", "1.0" );
            $table_name = $wpdb->prefix . $namespace;
            $user_ip = $ip;
            $ip_num = str_replace('.', '', $ip);
            $user_feedback = $feedback;

            $insert_payload = array( 
                'time' => current_time( 'mysql' ), 
                'userip' => $ip, 
                'userip_num' => $ip_num, 
                'feedback' => $feedback, 
                'post_id' => $postid, 
            );

            $user_exists = $wpdb->get_var( // search DB for IP
                $wpdb->prepare("SELECT userip_num FROM wp_simple_like_dislike WHERE userip_num = %d", $ip_num)
            );
            if($user_exists) { // if found
                $user_has_page_feedback = $wpdb->get_var( // search DB for IP
                    $wpdb->prepare("SELECT userip_num FROM wp_simple_like_dislike WHERE post_id = %d", $postid)
                );
                if($user_has_page_feedback) { // if found
                    $wpdb->update( // update
                        $table_name, 
                        $insert_payload,
                        array( 'userip_num' => $ip_num, 'post_id' => $postid),
                        array('%s','%d')
                    );

                } else {
                    $wpdb->insert( // insert new
                        $table_name, 
                        $insert_payload
                    );
                }
            } else {
                $wpdb->insert( // insert new
                    $table_name, 
                    $insert_payload
                );
            }
        }

        public static function sld_update_db_check($namespace, $version) {
            if ( get_site_option( 'sld_db_version' ) != $version || ! self::sld_does_table_exist() ) {
                self::sld_create_database($namespace,$version);
                update_option( 'sld_db_version', $version );
            }
        }

        public static function sld_does_table_exist() {
            global $wpdb;
            return ( $wpdb->get_var("SHOW TABLES LIKE 'wp_simple_like_dislike'") );
        }
    }