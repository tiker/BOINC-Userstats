<script type="text/javascript">
	$(function () {
		var chart = new Highcharts.StockChart({
			chart: {
				renderTo: 'output_gesamt_week',
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
				alternateGridColor: '<?php echo $highchartAlternateGridColor; ?>',
				showFirstLabel: false
				}, { // right y axis
				linkedTo: 0,
				gridLineWidth: 0,
				opposite: true,
				showFirstLabel: false
			}],
			series: [{
				name: '<?php echo $tr_ch_yaxis_week; ?>',
				color: '<?php echo $highchartBarChartColor; ?>',
				data: [<?php echo $output_html;?>],
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
