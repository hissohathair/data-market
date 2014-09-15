var timeline = require('../lib/api/timeline'),
	google = require('../lib/api/google');

exports.init = function(app) {
	app.get('/', function(req, res){
	  res.render('index', { title: 'Express' });
	});	

	app.get('/timeline', function(req, res) {
		google.ensureAuthorization(function() {
			console.log('Request is authenticated, proceeding to querying timeline');
			req.setTimeout(10*60*1000, function() {
				console.log('Timeout!');
			});
			timeline.getTimeline(req.query.term, function(emails) {
				console.log('Now sending back', emails);
				res.json({
					type: 'email_trail',
					payload: {
						emails: emails
					}
				});
			});
		}, function(authenticationUrl) {
			console.log('Request needs authentication');
			res.json({
				type: 'needs_authentication',
				payload: {
					authenticationUrl: authenticationUrl
				}	
			});
		});
	});

	app.get('/oauth2callback', function(req, res) {
		google.setCredentials(req.query.code, function() {
			res.redirect('/authenticated.html');
		});
	});
};
