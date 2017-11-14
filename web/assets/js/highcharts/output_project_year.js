<script type="text/javascript">
	Highcharts.setOptions({
		global: {
			useUTC: true
		}
	});
	$(function () {
		var chart = new Highcharts.StockChart({
			chart: {
				renderTo: 'output_project_year',
				defaultSeriesType: 'column',
				backgroundColor: '<?php echo $highchartsBGColor; ?>'
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
				alternateGridColor: '<?php echo $highchartAlternateGridColor; ?>',
				showFirstLabel: false
				}, { // right y axis
				linkedTo: 0,
				gridLineWidth: 0,
				opposite: true,
				showFirstLabel: false
			}],		
			series: [{
				name: '<?php echo $tr_ch_yaxis_year;?>',
				color: '<?php echo $highchartBarChartColor; ?>',
				data: [<?php echo $output_project_html;?>],
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