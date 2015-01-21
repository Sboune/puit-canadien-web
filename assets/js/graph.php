
<script>
var tempO = [-2, -2.6, -2.5, -2.2, -4.7, -4.2, -3.7, -4.2, -3.8, -4.4, -2, -0.6, 1.6, 2, 2.6, 2.6, 2.1, 1.4, 0, -0.7, -1.2, -1.1, -1.2, -0.9]
var temp = [3.1, 3.1, 3.9, 4, 4, 3, 3.7, 3.6, 2.2, 2.4, 2.4, 3, 1.5, 2, 1.1, 1.7, 1.8, -0.3, -0.5, 0.2, -0.1, 0.7, -0.4, -0.3];
var tempP=[];
//for (var i = 0; i < 290; i++) { tempP.push((Math.random()*10)-5);}; // création  de tableau random
for (var i = 0; i < 5; i++) {
	var tab=[];
	for (var j = 0; j < 5; j++) {
		tab.push((Math.random()*10)-5);
	};
	tempP.push(tab);
};



var chartHC = $('#chart').highcharts({


		chart: {
            zoomType: 'x',
        },
	
		title: {
	        text: ' ',
	        x: -20, //center
	    },
	
	    subtitle: {
	        text: ' ',
	        x: -20,
	    },
	
	    xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {second: '%H:%M:%S',},
            //pointInterval:  14400*60*24,
        },


	    yAxis: { title: { text:'Temperature (°C)' },},


	    tooltip: { valueSuffix: '°C' },
	
		plotOptions: {
            series: {
                pointStart: Date.UTC(2015, 0, 20, 0, 0),
                pointInterval: 900000, // mettre en ms : http://unit-converter.org/fr/temps.html
            }
        },

	    legend: {
	        layout: 'vertical',
	        align: 'right',
	        verticalAlign: 'middle',
	        borderWidth: 0,
	    },
	
	    series: [],
});


<?php 
$name = 0;
	foreach (generer_graph() as $courbe) {
		$dataC = "[";
		foreach ($courbe as $data) {
			if($dataC != "["){
				$dataC = $dataC . " , ";
			}
			$dataC = $dataC . $data; 
		}
		$dataC = $dataC."]";


		?>

	$('#chart').highcharts().addSeries({/*id: 0+'',*/ name: 'courbe '+ <?php echo $name;?>,
										data:<?php echo $dataC;?>},
										true);

<?php
$name +=1;
	}

?>
</script>
