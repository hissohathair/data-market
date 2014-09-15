$(document).ready(function() {
	function getEmailTrail(queryTerm, successCallback, errorCallback) {
		function authenticateUser(authenticationUrl, successfullyAuthenticatedCallback) {
			$('#query-submit').popover({
				placement: 'bottom',
				trigger: 'manual',
				html: true
			}).popover('show').on('shown.bs.popover', function() {
				$('button#authenticate-now').click(function() {
					window.open(authenticationUrl, '_blank', 'location=no,menubar=no,resizable=no,scrollbars=no,status=no,toolbar=no,height=360,width=640');
					
					self.addEventListener('message', function(event) {
						event.source.close();
						successfullyAuthenticatedCallback();
					});

					$('#query-submit').popover('hide');

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

	function padZeros(value, length) {
		var text = value.toString();
		while (text.length < length) {
			text = '0'+text;
		}

		return text;
	};

	function renderDateString(timestamp) {
		var date = new Date(timestamp);
		return padZeros(date.getFullYear(), 4)+padZeros(date.getMonth()+1, 2)+padZeros(date.getDate(), 2);
	};

	function renderRangeString(directionRecord) {
		var min = directionRecord.fromCount, 
			avg = directionRecord.fromCount+directionRecord.toCount, 
			max = directionRecord.fromCount+directionRecord.toCount+directionRecord.ccCount;

		return min+';'+avg+';'+max; 
	};

	function renderTotalString(directionRecord1, directionRecord2) {
		var min1 = directionRecord1.fromCount, 
			avg1 = directionRecord1.fromCount+directionRecord1.toCount, 
			max1 = directionRecord1.fromCount+directionRecord1.toCount+directionRecord1.ccCount;

		var min2 = directionRecord2.fromCount, 
			avg2 = directionRecord2.fromCount+directionRecord2.toCount, 
			max2 = directionRecord2.fromCount+directionRecord2.toCount+directionRecord2.ccCount;

		return (min1+min2)+';'+(avg1+avg2)+';'+(max1+max2); 
	};

	function getChartDataFunc(emailTrail) {
		return function() {
			var dateMapping = {};

			for (var i=0, len=emailTrail.emails.length; i<len; ++i) {
				var dateString = renderDateString(emailTrail.emails[i].timestamp);
				var dateRecord = dateMapping[dateString];

				if (!dateRecord) {
					dateRecord = {
						received: {
							fromCount: 0, 
							toCount: 0,
							ccCount: 0
						}, 
						sent: {
							fromCount: 0,
							toCount: 0,
							ccCount: 0
						}
					};
					dateMapping[dateString] = dateRecord;
				}

				var directionRecord = dateRecord[emailTrail.emails[i].direction];
				directionRecord.fromCount+=((emailTrail.emails[i].from && emailTrail.emails[i].from.length) || 1);
				directionRecord.toCount+=((emailTrail.emails[i].to && emailTrail.emails[i].to.length) || 0);
				directionRecord.ccCount+=((emailTrail.emails[i].cc && emailTrail.emails[i].cc.length) || 0);
			}

			var chartData = 'Date,Received,Sent,Total\n';
			for (var dateString in dateMapping) {
				if (dateMapping.hasOwnProperty(dateString)) {
					var dateRecord = dateMapping[dateString];

					chartData += dateString+','+renderRangeString(dateRecord.received)+','+renderRangeString(dateRecord.sent)+','+renderTotalString(dateRecord.received, dateRecord.sent)+'\n';
				}
			}

			return chartData;
		};
	};

	function renderChart(queryTerm, emailTrail) {
		$('#timeline').empty();

		new Dygraph(document.getElementById("timeline"), getChartDataFunc(emailTrail), {
			customBars : true,
			title : 'Email density for "'+queryTerm+'"',
			ylabel : '#Reached People',
			legend : 'always',
			labelsDivStyles : {
				'textAlign' : 'right'
			},
			showRangeSelector : true
		});
	};

	var EMAIL_PATTERN = /<([^@>]*@[^>]*)>/;

	function getEmail(person) {
		var match = EMAIL_PATTERN.exec(person);
		if (match) {
			return match[1];
		} else {
			return person;
		}
	};

	function renderDecomposition(queryTerm, emailTrail) {
		var persons = {}, domains = {};

		for (var i=0, ii=emailTrail.emails.length; i<ii; ++i) {
			if (emailTrail.emails[i].direction === 'received') {
				// "from" sender (ignore cc)
				if (emailTrail.emails[i].from) {
					for (var j=0, jj=emailTrail.emails[i].from.length; j<jj; ++j) {
						var email = getEmail(emailTrail.emails[i].from[j]);
						persons[email] = (persons[email] || 0) + 1;

						var domain = email.substring(email.indexOf('@')+1);
						domains[domain] = (domains[domain] || 0) + 1;
					}
				}
			} else {
				// "to" receipients (ignore cc)
				if (emailTrail.emails[i].to) {
					for (var j=0, jj=emailTrail.emails[i].to.length; j<jj; ++j) {
						var email = getEmail(emailTrail.emails[i].to[j]);
						persons[email] = (persons[email] || 0) + 1;

						var domain = email.substring(email.indexOf('@')+1);
						domains[domain] = (domains[domain] || 0) + 1;
					}
				}
			}
		};

		function sgn(value) {
			return value<0 ? -1 : (value > 0 ? 1 : 0);
		};

		function desc(v1, v2) {
			return sgn(v2.count-v1.count);
		}

		function getChartData(hits) {
			var ranked = [], total = 0;
			for (key in hits) {
				if (hits.hasOwnProperty(key)) {
					ranked.push({
						key: key,
						count: hits[key]
					});

					total += hits[key];
				}
			}

			ranked.sort(desc);

			var numbers = [], sum = 0;
			for (var i=0, len=ranked.length; i<len; ++i) {
				if (ranked[i].count/total >= 0.05) {
					numbers = numbers.concat([ranked[i].count]);
					sum += ranked[i].count;
				} else {
					// longtail
					numbers = numbers.concat([total-sum]);
					break;
				}
			}

			return {
				total: total,
				ranked: ranked,
				distribution: numbers.join(',')
			};
		};

		var PALETTE = ['D95B43', 'C02942', '542437', '53777A', '00A0B0', '6A4A3C', 'CC333F', 'EB6841', 'EDC951', 'E6DCCC', '1E214F', 'B5242E', '1E4F34', '537B99', 'FF003C', '88C100', '00C176', 'C56894', '833974', '562A5F'];

		function populateUI(name, hits, tableId, chartId) {
			var chartData = getChartData(hits);

			// $('#'+chartId).html('<span class="sparkline display-inline" data-sparkline-type="pie" data-sparkline-offset="90" data-sparkline-piesize="250px">'+chartData.distribution+'</span>');
		
			var pieData = [[name, 'Number of sent or received emails']];
			var sliceColors = {};

			for (var i=0, len=chartData.ranked.length; i<len; ++i) {
				var percent = 100.0*chartData.ranked[i].count/chartData.total;
				var color = '#'+PALETTE[i%PALETTE.length];

				$('#'+tableId).append('<tr><td><div class="easy-pie-chart easyPieChart" style="color: '+color+'!important;" data-percent="'+percent+'" data-size="40" data-pie-size="60"></div></td><td>'+chartData.ranked[i].key+'</td><td>'+chartData.ranked[i].count+'</td><td>'+Math.round(percent)+'%</td></tr>');

				pieData = pieData.concat([[chartData.ranked[i].key, chartData.ranked[i].count]]);
				sliceColors[i] = {
					color: color
				}
			}

			(new google.visualization.PieChart(document.getElementById(chartId))).draw(google.visualization.arrayToDataTable(pieData), {
				pieHole: 0.5,
				slices: sliceColors,
				legend: {
					position: 'none'
				},
				chartArea: {
					left: 10,
					top: 10,
					width: 330,
					height: 330
				}
			});
		};

		populateUI('sender or receiver emails', persons, 'person-table', 'person-decomposition');
		populateUI('sender or receiver domains', domains, 'domain-table', 'domain-decomposition');

	};

	$('#query-submit').click(function() {
		$('#query-submit').attr('disabled', 'disabled');
		var queryTerm = $('#query-term').val();

		getEmailTrail(queryTerm, function(emailTrail) {
			renderChart(queryTerm, emailTrail);
			renderDecomposition(queryTerm, emailTrail);

			pageSetUp();
			$('#query-submit').removeAttr('disabled');
		}, function(error) {
			$('#query-submit').attr('disabled', 'disabled');
		});
	});

});