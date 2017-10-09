<script type="text/javascript">
Highcharts.setOptions({
	global: {
		useUTC: true
	}
});

$(function () {
	var chart = new Highcharts.stockChart({
		chart: {
			renderTo: 'output_gesamt_day',
			defaultSeriesType: 'column'
		},    
		navigator: {
			enabled: false,
			height: 40,
			series: {
				type: 'column',
				dataGrouping: {
					forced: true,
					units: [
						['day', [1]]
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
			selected: 0
		},
		plotOptions: {
			column: {
				dataGrouping: {
					dateTimeLabelFormats: {
						day: ['<?php echo $tr_ch_dateformat; ?>']
					}
				}
			}
		},					
		xAxis: {
			type: 'datetime',
			ordinal: false,
			maxZoom: 14 * 1 * 24 * 3600000
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
			name: '<?php echo $tr_ch_yaxis_day; ?>',
			color: '#5883A6',
			data: [<?php echo $output_html;?>],
			dataGrouping: {
				forced: true,
				units: [
					['day', [1]]
				]
			} 
		}]
	});
});
</script>
