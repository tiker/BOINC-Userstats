<script type="text/javascript">
Highcharts.setOptions({
	global: {
		useUTC: true
	}
});
var chart;
$(document).ready(function() {
	chart = new Highcharts.stockChart({
		chart: {
			renderTo: 'output',
			defaultSeriesType: 'areaspline',
			backgroundColor: 'rgb(252, 250, 249)'
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
			selected: 2
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
			alternateGridColor: 'rgba(104, 100, 100, 0.063)',
			showFirstLabel: false
			}, { // right y axis
			linkedTo: 0,
			gridLineWidth: 0,
			opposite: true,
			showFirstLabel: false
			}, { // Pendings y axis
			opposite: true,
			labels: {
				enabled: false
			}
		}],
		series: [{
			name: '<?php echo $tr_ch_go_header;?>',
			type: 'areaspline',
			color: 'rgba(104, 100, 100, 0.565)',
			lineWidth: 1,
			data: [<?php echo $output_gesamt_html;?>],
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
			color: 'rgba(104, 100, 100, 0.843)',
			lineWidth: 1,
			data: [<?php echo $output_gesamt_pendings_html;?>],
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
