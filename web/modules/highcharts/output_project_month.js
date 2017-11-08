<script type="text/javascript">
Highcharts.setOptions({
	global: {
		useUTC: true
	}
});

$(function () {
	var chart = new Highcharts.StockChart({
		chart: {
			renderTo: 'output_project_month',
			defaultSeriesType: 'column'
		},    
		navigator: {
			enabled: false,
			height: 40,
			xAxis: {
				type: 'datetime',
				ordinal: false,
				maxZoom: 12 * 30 * 1 * 24 * 3600000
			},
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
			alternateGridColor: 'rgba(104, 100, 100, 0.063)',
			showFirstLabel: false
			}, { // right y axis
			linkedTo: 0,
			gridLineWidth: 0,
			opposite: true,
			showFirstLabel: false
		}],
		series: [{
			name: '<?php echo $tr_ch_yaxis_month;?>',
			color: 'rgba(104, 100, 100, 0.843)',
			data: [<?php echo $output_project_html;?>],
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
