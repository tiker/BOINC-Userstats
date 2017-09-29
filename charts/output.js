	<script type="text/javascript">
	Highcharts.setOptions({
        global: {
			useUTC: true
//            timezoneOffset: 60
        }
});
var chart;
	$(document).ready(function() {

             chart = new Highcharts.stockChart({
                chart: {
                	renderTo: output,
			defaultSeriesType: 'areaspline'
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
			alternateGridColor: '#FDFFD5',
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


//, { // Rank y axis
//					opposite: true,
//					floor: 0,
//					labels: {
//						enabled: false
//						}
//					}, { // rank team y axis
//					opposite: true,
//					floor: 0,
//					labels: {
//						enabled: false
//						}
//					}],
		series: [{
		        name: '<?php echo $tr_ch_go_header;?>',
			type: 'areaspline',
			color: '#5883A6',
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
			color: 'darkred',
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
// ranking netsoft - seit 11.09.2015 inaktiv
/*
					{
		        name: '<?php echo $tr_ch_rw;?>',
					type: 'spline',
					color: 'green',
					lineWidth: 1,
		        data: [<?php echo $output_gesamt_rank_html;?>],
					dataGrouping: {
							forced: true,
							units: [
								['day', [1]]
								]
							},
				yAxis: 3
		      		},
					{
		        name: '<?php echo $tr_ch_ra;?>',
					type: 'spline',
					color: 'darkblue',
					lineWidth: 1,
		        data: [<?php echo $output_gesamt_rank_team_html;?>],
					dataGrouping: {
							forced: true,
							units: [
								['day', [1]]
								]
							},
				yAxis: 4
		      		}
*/
			]
		   });
		});
</script>
