<script type="text/javascript">
Highcharts.setOptions({
	global: {
		useUTC: true
	}
});

$(function () {
	var chart = new Highcharts.StockChart({
		chart: {
			renderTo: 'output_project_day',
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
			alternateGridColor: '#68646410',
			showFirstLabel: false
			}, { // right y axis
			linkedTo: 0,
			gridLineWidth: 0,
			opposite: true,
			showFirstLabel: false
		}],
		series: [{
			name: '<?php echo $tr_ch_yaxis_day;?>',
			color: '#686464d7',
			data: [<?php echo $output_project_html;?>],
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
