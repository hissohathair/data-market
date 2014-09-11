var google = require('googleapis');

// Google API credentials (see https://console.developers.google.com/project/apps~long-ceiling-673)
var CLIENT_ID = '367292805571-htumsm36g5u1828qq88fkuj88s32idbv.apps.googleusercontent.com',
	CLIENT_SECRET = '8rlMAJJ-_gYs9LyE9YVw_A0T',
	REDIRECT_SEARCH = '/oauth2callback';
	REDIRECT_URL = 'http://localhost:3000'+REDIRECT_SEARCH;

var SCOPES = ['https://www.googleapis.com/auth/gmail.readonly'];

var oauth2Client = new google.auth.OAuth2(CLIENT_ID, CLIENT_SECRET, REDIRECT_URL);


google.options({ 
	auth: oauth2Client 
});

exports.setCredentials = function(accessCode, successfullyAuthorizedCallback) {
	oauth2Client.getToken(accessCode, function(err, tokens) {
		oauth2Client.setCredentials(tokens);
		successfullyAuthorizedCallback();
	});
};

exports.ensureAuthorization = function(alreadyAuthorizedCallback, needsAuthorizationCallback) {
	if (oauth2Client.credentials && oauth2Client.credentials.access_token) {
		// we were authorized before, Bearer token refreshes automatically
		alreadyAuthorizedCallback(oauth2Client);
	} else {
		needsAuthorizationCallback(oauth2Client.generateAuthUrl({
			access_type: 'online',
			scope: SCOPES
		}));
	}
};
