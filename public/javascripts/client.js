$(document).ready(function() {
	function getEmailTrail(queryTerm, successCallback, errorCallback) {
		function authenticateUser(authenticationUrl, successfullyAuthenticatedCallback) {
			$('#query-submit').popover({
				placement: 'bottom',
				trigger: 'manual',
				html: true
			}).popover('show').on('shown.bs.popover', function() {
				$('button#authenticate-now').click(function() {
					var authenticationWindow = window.open(authenticationUrl, '_blank', 'location=no,menubar=no,resizable=no,scrollbars=no,status=no,toolbar=no,height=360,width=640');
					
					authenticationWindow.addEventListener('message', function(event) {
						authenticationWindow.close();
						successfullyAuthenticatedCallback();
					});

					$('#query-submit').removeAttr('disabled').popover('hide');

				});
			});
		};

		(function getTimeline() {
			$.getJSON('/timeline', {term: queryTerm}).done(function(res) {
				switch(res.type) {
					case 'needs_authentication':
						authenticateUser(res.payload.authenticationUrl, getTimeline);
						break;
					case 'email_trail':
						successCallback(res.payload);
						break;						
					default:
						console.error('Unexpected response type: "'+res.type+'"', res.payload);
						errorCallback(res.payload);
				}
			});
		})();	
	};

	$('#query-submit').click(function() {
		$('#query-submit').attr('disabled', 'disabled');

		getEmailTrail($('#query-term').val(), function(emailTrail) {
			$('body').append(JSON.stringify(emailTrail));
		}, function(error) {

		});
	});

});