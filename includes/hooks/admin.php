<?php

	class Admin {

		public static function add_toolbar_items($admin_bar){
			$page_feedback = Helpers::get_current_page_feedback( get_the_ID() );
			$likes = $page_feedback[0];
			$dislikes = $page_feedback[1];
			$admin_bar->add_menu( array(
				'id'    => 'sld-page-count',
				'title' => "$likes likes - $dislikes dislikes",
				'href'  => '/'
			));
		}

	    public static function widget_html() {
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
	            $page_feedback = Helpers::get_current_page_feedback( $post->ID );
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
	}