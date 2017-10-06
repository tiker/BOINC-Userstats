<script type="text/javascript">
Highcharts.setOptions({
	global: {
		useUTC: true
	}
});

$(function () {
	var chart = new Highcharts.StockChart({
		chart: {
			renderTo: 'project_output_week',
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
						['week', [1]]
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
			selected: 2
		},
		plotOptions: {
			column: {
				dataGrouping: {
					dateTimeLabelFormats: {
						week: ['<?php echo $tr_ch_week; ?> <?php echo $tr_ch_dateformat; ?>']
					}
				}
			}
		},
		xAxis: {
			type: 'datetime',
			ordinal: false,
			maxZoom: 12 * 7 * 24 * 3600000
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
			name: '<?php echo $tr_ch_yaxis_week;?>',
			color: '#5883A6',
			data: [<?php echo $output_project_html;?>],
			dataGrouping: {
				forced: true,
				units: [
					['week', [1]]
				]
			} 
		}]
	});
});
</script>
