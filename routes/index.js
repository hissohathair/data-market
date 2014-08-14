var timelineAPI = require('../lib/api/timeline')

exports.init = function(app) {
	app.get('/', function(req, res){
	  res.render('index', { title: 'Express' });
	});	

	app.get('/timeline', function(req, res) {
		timelineAPI.getTimeline(req.query.term, function(responsePayload) {			
			res.json(responsePayload);
		});
	});
};
