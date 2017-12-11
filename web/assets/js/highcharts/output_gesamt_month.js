<script type="text/javascript">
	$(function () {
		var chart = new Highcharts.StockChart({
			chart: {
				renderTo: 'output_gesamt_month',
				defaultSeriesType: 'column',
				backgroundColor: '<?php echo $highchartsBGColor; ?>'
			},    
			navigator: {
				enabled: false,
				height: 40,
				series: {
					type: 'column',
					dataGrouping: {
						forced: true,
						units: [
							['month', [1]]
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
				selected: 4
			},
			xAxis: {
				type: 'datetime',
				ordinal: false,
				maxZoom: 12 * 30 * 1 * 24 * 3600000
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
				name: '<?php echo $tr_ch_yaxis_month; ?>',
				color: '<?php echo $highchartBarChartColor; ?>',
				data: [<?php echo $output_html;?>],
				dataGrouping: {
					forced: true,
					units: [
						['month', [1]]
					]
				} 
			}]
		});
	});
</script>
