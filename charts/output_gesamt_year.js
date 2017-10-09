<script type="text/javascript">
Highcharts.setOptions({
	global: {
		useUTC: true
	}
});

$(function () {
	var chart = new Highcharts.StockChart({
		chart: {
			renderTo: 'output_gesamt_year',
			defaultSeriesType: 'column'
		},    
		navigator: {
			enabled: false
		},
		rangeSelector: {
			inputEnabled: false,
			enabled: false,
			selected: 0,
			buttons: [{
				type: 'year',
				count: 1,
				text: '1y'
			}]
		}, 
		xAxis: {
			maxZoom: 12 * 30 * 1 * 24 * 3600000,
			type: 'datetime',
			startOnTick:true,
			showFirstLabel: true,
			ordinal: false,
			dateTimeLabelFormats: {
				year: '%Y'
			},
			tickInterval: 86400000 * 31 * 12  // one month
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
			name: '<?php echo $tr_ch_yaxis_year; ?>',
			color: '#5883A6',
			data: [<?php echo $output_html;?>],
			dataGrouping: {
				forced: true,
				units: [
					['year', [1]]
				]
			} 
		}]
	});
});
</script>
