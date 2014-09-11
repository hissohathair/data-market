var gmail = require('googleapis').gmail('v1');

function retrieveMessageIds(queryTerm, callback) {
	var messages = [];

	(function getNextBatch(pageToken) {
		gmail.users.messages.list({
			userId: 'me',
			pageToken: pageToken,
			includeSpamTrash: false,
			q: queryTerm
		}, function(__unused__, result) {
			console.log(arguments);
			console.log(result.messages.length + ' messages received');
			messages = messages.concat(result.messages);
			if (result.nextPageToken) {
				console.log('Retrieving next batch');
				getNextBatch(result.nextPageToken);
			} else {
				console.log('Received '+messages.length+' messages in total');
				callback(messages);
			}
		});
	})();	
};

function retrieveMessageDetails(messageId, callback) {
	gmail.users.messages.get({
		userId: 'me',
		id: messageId
	}, function(__unused__, result) {
		callback(result);
	});
};

exports.getTimeline = function(queryTerm, responseCallback) {
	retrieveMessageIds(queryTerm, function(messages) {
		var details = [];
		
		(function getNextMessage() {
			if (messages.length>0) {
				console.log('Retrieving next message, '+messages.length+' remaining');
				retrieveMessageDetails(messages.pop().id, function(message) {
					details.push(message);
					getNextMessage();
				});
			} else {
				responseCallback(details);
			}
		})();	
	});
};

