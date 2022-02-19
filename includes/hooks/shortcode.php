<?php

	class Shortcode {
		
		public static function simple_like_dislike_buttons( $atts ) {
			$ip_address = Helpers::get_user_ip_address();
			$postid = get_the_ID();
			?>
				<a data-function="post-feedback-input" data-value="like" data-postid="<?= $postid ?>" data-ip="<?= $ip_address ?>" href="/">
					<svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" viewBox="0 0 100 100">
						<g id="Group_569" data-name="Group 569" transform="translate(-530.002 -2363.999)">
							<rect id="Rectangle_98" data-name="Rectangle 98" width="100" height="100" rx="50" transform="translate(530.002 2363.999)" fill="#90bc53"/>
							<path id="icons8_facebook_like_1" d="M20.384,4,14.067,16.633H4V41.9H33.757a4.763,4.763,0,0,0,4.639-3.75l3.4-15.791a4.773,4.773,0,0,0-4.639-5.724H24.874a16.754,16.754,0,0,1,.888-4.244,10.546,10.546,0,0,0,.345-3.652,4.688,4.688,0,0,0-1.283-3.158A4.679,4.679,0,0,0,21.371,4ZM22.16,7.553c.1.074.259.049.346.148a1.749,1.749,0,0,1,.444,1.036,9.393,9.393,0,0,1-.2,2.665,30.161,30.161,0,0,0-1.382,6.711l-.1,1.678h15.89a1.548,1.548,0,0,1,1.53,1.925L35.336,37.507a1.59,1.59,0,0,1-1.579,1.234H16.633V18.607Zm-15,12.238h6.317v18.95H7.158ZM10.317,34A1.579,1.579,0,1,0,11.9,35.583,1.582,1.582,0,0,0,10.317,34Z" transform="translate(557.05 2390.999)" fill="#fff"/>
						</g>
					</svg>
				</a>
				<span>&nbsp;</span>
				<a data-function="post-feedback-input" data-value="dislike" data-postid="<?= $postid ?>" data-ip="<?= $ip_address ?>" href="/">
					<svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" viewBox="0 0 100 100">
						<g id="Group_570" data-name="Group 570" transform="translate(-650.002 -2363.999)">
							<rect id="Rectangle_99" data-name="Rectangle 99" width="100" height="100" rx="50" transform="translate(650.002 2363.999)" fill="#f76b1c"/>
							<path id="icons8_facebook_like_1" d="M25.52,41.9l6.317-12.633H41.9V4H12.147A4.763,4.763,0,0,0,7.508,7.75L4.1,23.542a4.773,4.773,0,0,0,4.639,5.724H21.029a16.753,16.753,0,0,1-.888,4.244,10.546,10.546,0,0,0-.345,3.652A4.882,4.882,0,0,0,24.533,41.9Zm-1.777-3.553c-.1-.074-.259-.049-.346-.148a1.749,1.749,0,0,1-.444-1.036,9.393,9.393,0,0,1,.2-2.665,30.161,30.161,0,0,0,1.382-6.711l.1-1.678H8.742a1.548,1.548,0,0,1-1.53-1.925L10.568,8.392a1.59,1.59,0,0,1,1.579-1.234H29.271V27.292Zm15-12.238H32.429V7.158h6.317ZM35.587,11.9a1.579,1.579,0,1,0-1.579-1.579A1.582,1.582,0,0,0,35.587,11.9Z" transform="translate(677.05 2390.999)" fill="#fff"/>
						</g>
					</svg>
				</a>
			<?php
		}
	}