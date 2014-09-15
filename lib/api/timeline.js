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
			console.log('Batch of '+result.messages.length + ' messages received');
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
		id: messageId,
		format: 'metadata',
		metadataHeaders: ['Date', 'Subject', 'From' ,'To']
	}, function(__unused__, emailDetails) {
		callback(emailDetails);
	});
};

function splitEmails(emailString) {
	if (typeof emailString === 'string') {
		console.log('Now splitting: '+emailString);

		var inQuote = false;

		for (var i=0, len=emailString.length; i<len; ++i) {
			switch (emailString.charAt(i)) {
				case '"':
					inQuote = !inQuote;
					break;
				case ',':
					console.log('Found comma at position '+i);
					if (inQuote) {
						console.log('in quote');
						emailString = emailString.substring(0, i)+ '§' + emailString.substring(i+1);
					}
					break;
			}
		}

		var addresses = emailString.split(', ');
		for (var i=0, len=addresses.length; i<len; ++i) {
			addresses[i].replace('§', ',');
		}

		console.log('Returning ('+addresses.length+')', JSON.stringify(addresses));
		return addresses;
	}

	return [];
};

function parseEssence(emailDetails) {
	if (emailDetails) {
		var emailEssence = {
			id: emailDetails.id,
			direction: ((emailDetails.labelIds instanceof Array) && (emailDetails.labelIds.indexOf('SENT') >= 0)) ? 'sent' : 'received'
		}

		if (emailDetails && emailDetails.payload && emailDetails.payload.headers) {
			for (var i=0, len=emailDetails.payload.headers.length; i<len; ++i) {
				switch(emailDetails.payload.headers[i].name) {
					case 'Date':
						try {
							emailEssence.timestamp = new Date(emailDetails.payload.headers[i].value).getTime();
						} catch (error) {
							// date parsing error
						}
						break;
					case 'Subject':
						emailEssence.subject = emailDetails.payload.headers[i].value;
						break;
					case 'From':
						emailEssence.from = splitEmails(emailDetails.payload.headers[i].value);
						break;
					case 'To':
						emailEssence.to = splitEmails(emailDetails.payload.headers[i].value);
						break;
					case 'Cc':
						emailEssence.cc = splitEmails(emailDetails.payload.headers[i].value);
						break;
				}
			}
		}

		return emailEssence;
	} 

	return {};
};

exports.getTimeline = function(queryTerm, responseCallback) {
	retrieveMessageIds(queryTerm, function(messages) {
		var details = [];
		
		(function getNextMessage() {
			if (messages.length>0) {
				console.log('Retrieving next message, '+messages.length+' remaining');
				retrieveMessageDetails(messages.pop().id, function(emailDetails) {
					var emailEssence = parseEssence(emailDetails);
					if (typeof emailEssence.timestamp === 'number') {
						details.push(emailEssence);
					}
					getNextMessage();
				});
			} else {
				responseCallback(details.sort(function(msg1, msg2) {
					function sgn(value) {
						return (value < 0 ? -1 : (value === 0 ? 0 : 1));
					}

					return sgn(msg1.timestamp - msg2.timestamp);
				}));
			}
		})();	
	});
};

