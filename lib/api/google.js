var google = require('googleapis');

// Google API credentials (see https://console.developers.google.com/project/apps~long-ceiling-673)
var CLIENT_ID = '367292805571-htumsm36g5u1828qq88fkuj88s32idbv.apps.googleusercontent.com',
	CLIENT_SECRET = '8rlMAJJ-_gYs9LyE9YVw_A0T',
	REDIRECT_SEARCH = '/oauth2callback';
	REDIRECT_URL = 'http://localhost:3000'+REDIRECT_SEARCH;

var SCOPES = ['https://www.googleapis.com/auth/gmail.readonly'];

var oauth2Client = new google.auth.OAuth2(CLIENT_ID, CLIENT_SECRET, REDIRECT_URL);

var isAuthenticated = false;

google.options({ 
	auth: oauth2Client 
});


exports.authorize = function(res, callback) {
	if (oauth2Client.credentials && oauth2Client.credentials.access_token) {
		// we were authorized before, Bearer token refreshes automatically
		callback(res, oauth2Client);
	} else {
		res.app.get(REDIRECT_SEARCH, function(req, res) {
			var accessCode = req.query.code
			oauth2Client.getToken(accessCode, function(err, tokens) {
				oauth2Client.setCredentials(tokens);
      			isAuthenticated = true;
      			callback(res, oauth2Client);
			});
		});

		res.redirect(oauth2Client.generateAuthUrl({
			access_type: 'online',
			scope: SCOPES
		});
	}
};
