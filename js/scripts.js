function recordFeedbackValue(e) {
	e.preventDefault();

	var userIP = this.dataset.ip;
	var userFeedback = this.dataset.value;
	var postID = this.dataset.postid;
	console.log(userIP, userFeedback,postID);

	jQuery(document).ready(function($) {
		var data = {
			'action': 'sld_submit_feedback',
			'ip': userIP,
			'feedback': userFeedback,
			'postid': postID
		}

		jQuery.post(simple_like_dislike_js_object.ajax_url, data, function(response) {
			console.log('Response: ', response)
		})
	});

	// connect to wordpress and save/update DB value

	// check current value for IP address
		// if value and IP found
			// overwrite
		// else
			// add to db table {ip, value} //{{192.168.0.0.1: 'like'},{192.168.0.0.2: 'dislike'}}
}
document.querySelectorAll('[data-function="post-feedback-input"]').forEach( element => element.addEventListener( 'click', recordFeedbackValue ) );