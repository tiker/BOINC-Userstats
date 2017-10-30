<script type="text/javascript">
Highcharts.setOptions({
	global: {
		useUTC: true
	}
});

$(function () {
	var chart = new Highcharts.StockChart({
		chart: {
			renderTo: 'project_output_hour',
			defaultSeriesType: 'column'
		},    
		navigator: {
			enabled: false,
			height: 40,
			series: {
				type: 'area',
				dataGrouping: {
					forced: true,
					units: [
						['hour', [1]]
					]
				}, 
				lineWidth: 1,
				marker: {
					enabled: false
				},
				shadow: false
			}
		},
		rangeSelector: {
			inputEnabled: false,
			selected: 0,
			buttons: [{
				type: 'day',
				count: 1,
				text: '1d'
				},{
				type: 'day',
				count: 7,
				text: '1w'
				},{
				type: 'day',
				count: 14,
				text: '2w'
				},{		
				type: 'day',
				count: 31,
				text: '1m'					
			}]
		},
		plotOptions: {
			column: {
				dataGrouping: {
					dateTimeLabelFormats: {
						hour: ['<?php echo $tr_ch_dateformat; ?>, %H:00 - %H:59']
					}
				}
			}
		},
		xAxis: {
			type: 'datetime',
			ordinal: false,
			maxZoom: 1 * 24 * 3600000 // one day
		},
		yAxis: [{ // left y axis
			opposite: false,
			alternateGridColor: '#FDFFD5',
			showFirstLabel: false
			}, { // right y axis
			linkedTo: 0,
			gridLineWidth: 0,
			opposite: true,
			showFirstLabel: false
		}],
		series: [{
			name: '<?php echo $tr_ch_yaxis_hour;?>',
			color: '#5883A6',
			data: [<?php echo $output_project_html;?>],
			dataGrouping: {
				forced: true,
				units: [
					['hour', [1]]
				]
			} 
		}]
	});
});
</script>
