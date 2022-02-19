<?php
	class Helpers {

		public static function get_user_ip_address() {
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}

		public static function get_current_page_feedback($post_id) {
			global $wpdb;
			$feedback_info = $wpdb->get_results( $wpdb->prepare("SELECT * FROM wp_simple_like_dislike WHERE post_id = %d", $post_id) ); // search DB for IP
			$likes = $dislikes = 0;

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