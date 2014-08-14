exports.getTimeline = function(queryTerm, responseCallback) {
	console.log('query term is', queryTerm)
	responseCallback({echo: queryTerm});
};