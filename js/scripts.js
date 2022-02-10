console.log('pete here', document.querySelectorAll('[data-function="post-feedback-input"]'));
var mockEntriesArray = [];

function ajax_check_entry_identifier() {
	// check the identifier (ip, username, saved cookie, etc)
	// return true if found
	console.log('ajax_check_entry_identifier function ran');
}

function ajax_add_entry() {

	// add entry
	// check if identifier exists
	// if not
		// add to log
	// if
		// update log
	ajax_check_entry_identifier();
	console.log('ajax_add_entry function ran');
}

function recordFeedbackValue(e) {
	e.preventDefault();
	alert( `{'${this.dataset.ip}','${this.dataset.value}' }` );
	console.log( `{'${this.dataset.ip}','${this.dataset.value}' }` );
	mockEntriesArray.push([this.dataset.ip, this.dataset.value]);

	ajax_check_entry_identifier();
	ajax_add_entry();
	console.log(mockEntriesArray);

	// connect to wordpress and save/update DB value

	// check current value for IP address
		// if value and IP found
			// overwrite
		// else
			// add to db table {ip, value} //{{192.168.0.0.1: 'like'},{192.168.0.0.2: 'dislike'}}
}
document.querySelectorAll('[data-function="post-feedback-input"]').forEach( element => element.addEventListener( 'click', recordFeedbackValue ) );

jQuery(document).ready(function($) {
	var data = {
		'action': 'sld_submit_feedback',
		'whatever': simple_like_dislike_js_object.we_value
	}

	jQuery.post(simple_like_dislike_js_object.ajax_url, data, function(response) {
		alert('Response: ' + response );
	})
});