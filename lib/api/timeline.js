exports.getTimeline = function(queryTerm, responseCallback) {
	console.log('query term is', queryTerm)
	// TODO: still need to perform proper GMail API call
	responseCallback({echo: queryTerm});
};