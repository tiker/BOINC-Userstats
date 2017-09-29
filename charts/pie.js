	<script type="text/javascript">
	Highcharts.setOptions({
        global: {
			useUTC: true
//            timezoneOffset: 60
        }
});

		
			var chart;
			$(document).ready(function() {
    	// Radialize the colors
//		Highcharts.getOptions().colors = $.map(Highcharts.getOptions().colors, function(color) {
//		    return {
//		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
//		        stops: [
//		            [0, color],
//		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
//		        ]
//		    };
//		});
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'projektverteilung'
					},
					title: false,
					plotArea: {
						shadow: true,
						borderWidth: null,
						backgroundColor: null
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
						}
					},
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
		innerSize: 100,
                depth: 45,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
/*
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								color: '#000000',
								connectorColor: '#000000',
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
								}
							}
						}
					},
*/
				    series: [{
						type: 'pie',
						name: '<?php echo $tr_ch_pie_01; ?>',
						data: [
							<? echo $pie_html; ?>	
						]
					}]
				})
			});
				
		</script>

