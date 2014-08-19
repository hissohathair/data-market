var timeline = require('../lib/api/timeline'),
	google = require('../lib/api/google');

exports.init = function(app) {
	app.get('/', function(req, res){
	  res.render('index', { title: 'Express' });
	});	

	app.get('/timeline', function(req, res) {
		google.authorize(app, res, function(res, oauth2Client) {
			timeline.getTimeline(req.query.term, function(payload) {
				res.json(payload);
			});
		});
	});
};
