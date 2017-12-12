<script type="text/javascript">
	$(function () {
		var chart=new Highcharts.StockChart({
			chart: {
				renderTo: 'output_project',
				defaultSeriesType: 'areaspline',
				backgroundColor: '<?php echo $highchartsBGColor; ?>'
			},  
			legend: {
				enabled: true
			},	
			navigator: {
				enabled: false,
				height: 40,
				series: {
				}
			},
			rangeSelector: {
				inputEnabled: false,
				selected: 4
			},
			plotOptions: {
				areaspline: {
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
				maxZoom: 1 * 24 * 3600000 // one day
			},
			yAxis: [{ // credits insgesamt y axis
				opposite: false,
				floor: 0,
				alternateGridColor: '<?php echo $highchartAlternateGridColor; ?>',
				showFirstLabel: false
				}, { // right y axis
				linkedTo: 0,
				gridLineWidth: 0,
				opposite: true,
				showFirstLabel: false
				}, { // Pendings y axis
				floor: 0,
				opposite: true,
				labels: {
					enabled: false
				}
			}],			
			series: [{
				name: '<?php echo $table_row["project_name"];?>',
				type: 'areaspline',
				color: '<?php echo $highchartAreasplineColor; ?>',
				lineWidth: 1,
				data: [<?php echo $output_project_gesamt_html;?>],
				dataGrouping: {
					forced: true,
					units: [
						['day', [1]]
					]
				}, 
				yAxis: 0,
			},
			{
				name: '<?php echo $tr_ch_pc;?>',
				type: 'column',
				color: '<?php echo $highchartBarChartColor; ?>',
				lineWidth: 1,
				data: [<?php echo $output_project_gesamt_pendings_html;?>],
				dataGrouping: {
					forced: true,
					units: [
						['day', [1]]
					]
				},
				yAxis: 2
			}				
			]
		});
	});
</script>
