console.log('pete here', document.querySelectorAll('[data-function="post-feedback-input"]'));

function recordFeedbackValue(e) {
	e.preventDefault();
	alert( `{'${this.dataset.ip}','${this.dataset.value}' }` );
	console.log( `{'${this.dataset.ip}','${this.dataset.value}' }` );

	// connect to wordpress and save/update DB value

	// check current value for IP address
		// if value and IP found
			// overwrite
		// else
			// add to db table {ip, value} //{{192.168.0.0.1: 'like'},{192.168.0.0.2: 'dislike'}}
}
document.querySelectorAll('[data-function="post-feedback-input"]').forEach( element => element.addEventListener( 'click', recordFeedbackValue ) );