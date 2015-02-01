
<?php 
  $idCapt = isset($_POST["capteursId"]) ? $_POST["capteursId"] : [1,7,10,16,19,22];
?>
<script>
$.ajaxSetup({'async': false});

function afterSetExtremes(e) {
  var chart = $('#chart').highcharts();
  //console.dir(chart);
  <?php
  $ii = 0;
  foreach ($idCapt as $idCC) {
?>
    chart.showLoading('Loading data from server...');
    $.getJSON('includes/scripts/getDataChart.php?id=<?php echo $idCC ?>&start=' 
                + Math.round(e.min) +
                '&end=' + Math.round(e.max) + '&callback=?', function (data) {
                    chart.series[<?php echo $ii;?>].setData(data);
                    chart.hideLoading();
                });
<?php
        $ii++;
    }
?>

}

/*
$('#chart').highcharts('StockChart', {

		chart: {
			zoomType: 'xz', // x tout seul ne marche pas, ça marche avec z 
			resetZoomButton:{enabled:true},
			
		},

		navigator: {
                adaptToUpdatedData: false,
                enabled: false}, // enlever la mini chart

		title: {text: ' '}, // pour ne pas avoir de titre ' ' 
	
	    xAxis: {
            events : {
                afterSetExtremes : afterSetExtremes
            },
            minRange: 3600 * 1000,
            type: 'candlestick',
            dateTimeLabelFormats: {
            	second: '%H:%M:%S',
            },
            title: {text: 'Temps'},
        },

	    yAxis: { floor: 0,
            title: { text:'Temperature (°C)' }},

	    // petite fenetre de valeur
	    tooltip: {
	    	xDateFormat: "%d %b %Y, %H:%M:%S",
	    	valueDecimals: 2, 
	    	valueSuffix: '°C', 
	    },
	
		plotOptions: {
            series: {
                pointStart: Date.UTC(2015, 0, 20, 0, 0),
                pointInterval: 900000, 
            }
        },

        legend: {enabled: true}, // pdf pas de legend sur H.Stock

        rangeSelector: {

        		enabled: true,

        		// le style des bouton
        		buttonTheme: {
        			fill: 'none',
                	stroke: 'none',
                	'stroke-width': 0,
                	r: 8,
                	style: {
                	    color: '#E94F51',
                	    fontWeight: 'bold'
                	},
                	states: {
                	    hover: {
                	    },
                	    select: {
                	        fill: '#E94F51',
                	        style: {
                	            color: 'white'
                	        }
                	    }
                	}
        		},

        		// champs de date à remplir
        		inputDateFormat: '%d-%m-%Y',
        		inputDateParser: '%d-%m-%Y',
        		inputEditDateFormat: '%d-%m-%Y',
        		inputBoxBorderColor: 'gray',
	            inputBoxWidth: 120,
	            inputBoxHeight: 18,
	            inputStyle: {
	                color: '#E94F51',
	                fontWeight: 'bold'
	            },
	            labelStyle: {
	                color: 'silver',
	                fontWeight: 'bold'
	            },
	            selected: 1,

        		// les boutons de intervalle
                buttons: [{
                    type: 'hour',
                    count: 1,
                    text: '1h'
                	}, {
                    type: 'day',
                    count: 1,
                    text: '1j'
                	}, {
                    type: 'month',
                    count: 1,
                    text: '1m'
                	}, {
                    type: 'year',
                    count: 1,
                    text: '1a'
                	}, {
                    type: 'all',
                    text: 'All'
                	}],
                	inputEnabled: true, // avoir les champs "from...to..."
                	selected : 4 // all
            	},


	    series: [],
});
*/
var options = {series:[]};
<?php
  $dateDebut = isset($_POST['dateDebut']) ? strtotime(str_replace("/","-",$_POST['dateDebut'])) :
                                             strtotime(date('Y-j-m',mktime(0, 0, 0, date("m")  , date("d")-7, date("Y")))) ;
  $dateFin = isset($_POST['dateFin']) ? strtotime(str_replace("/","-",$_POST['dateFin'])) :
                                             strtotime(date('Y-j-m',mktime(0, 0, 0, date("m")  , date("d")-7, date("Y")))) ;
  foreach ($idCapt as $idCC) {

?>
  var adr = 'includes/scripts/getDataChart.php?id=<?php echo $idCC ?>&start=' 
              + Math.round(<?php echo $dateDebut*1000;?>) +
        '&end=' + Math.round(<?php echo $dateFin*1000;?>) + '&callback=?';


$.getJSON(adr, function (data) {
  options.series.push({
    name : '<?php echo getCapteurNameById($idCC);?>',
    data: data
  });
});

<?php
}
?>


var oppppt = {
                chart : {
                    zoomType: 'x'
                },
                navigator : {
                    adaptToUpdatedData: false
                },
                scrollbar: {
                    liveRedraw: false
                },
                title: {text: ' '},
                rangeSelector : {
                    buttons: [{
                        type: 'hour',
                        count: 1,
                        text: '1h'
                    }, {
                        type: 'day',
                        count: 1,
                        text: '1d'
                    }, {
                        type: 'month',
                        count: 1,
                        text: '1m'
                    }, {
                        type: 'year',
                        count: 1,
                        text: '1y'
                    }, {
                        type: 'all',
                        text: 'All'
                    }],
                    inputEnabled: false, // it supports only days
                    selected : 4 // all
                },
                xAxis : {
                    events : {
                        afterSetExtremes : afterSetExtremes
                    },
                    minRange: 3600 * 1000 // one hour
                },
                yAxis: {
                }
            };

    oppppt.series = options.series;

    $('#chart').highcharts('StockChart', oppppt);


</script>
