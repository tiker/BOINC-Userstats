<script type="text/javascript">
	$(function () {
		var chart=new Highcharts.Chart({
			chart: {
				renderTo: 'projektverteilung',
				backgroundColor: '<?php echo $highchartsBGColor; ?>'
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
			series: [{
				type: 'pie',
				name: '<?php echo $tr_ch_pie_01; ?>',
				data: [
					<?php echo $pie_html; ?>	
				]
			}]
		})
	});
</script>
