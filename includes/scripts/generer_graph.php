<?php

  require_once __DIR__.'/../../admin/ConnexionBD.php';

  function getCapteurNameById($id){
    global $connexion;
    return $connexion->query("select nomC from capteur where idC =".$id)->fetch()[0];
  }

  function getInfoTableau(){

    $idCapt = isset($_POST["capteursId"]) ? $_POST["capteursId"] : [1,7,10,16,19,22];

    $dateDebut = isset($_POST['dateDebut']) ? $_POST['dateDebut'] : date('j/m/Y',mktime(0, 0, 0, date("m")  , date("d"), date("Y")-1));
    $dateFin = isset($_POST['dateFin']) ? $_POST['dateFin'] : date('j/m/Y',mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
    $donnees = [];
      
    $date_explosee = explode("/", $dateDebut);  // la fonction explode permet de séparer la chaine en tableau selon un délimiteur
      
    $jourDeb  = $date_explosee[1];
    $moisDeb  = $date_explosee[0];
    $anneeDeb = $date_explosee[2];
  
    $date_explosee = explode("/", $dateFin);
  
    $jourFin  = $date_explosee[1];
    $moisFin  = $date_explosee[0];
    $anneeFin = $date_explosee[2];
      
    $dateDebut = $anneeDeb."-".$jourDeb."-".$moisDeb;
    $dateFin   = $anneeFin."-".$jourFin."-".$moisFin;

    $data = "";

    global $connexion;

    foreach ($idCapt as $idCapt) {
      $connexion->exec("SET NAMES UTF8");
      $res = $connexion->query("select ROUND(min(valeur), 2), ROUND(max(valeur), 2), ROUND(avg(valeur), 2), ROUND(std(valeur), 2) from donnees where date >= "
                               . $connexion->quote($dateDebut) ." and date <= ". $connexion->quote($dateFin) ." and idC = ". $connexion->quote($idCapt))->fetch();
      $capt = $connexion->query("select nomC, unite  from Capteur where idC = ".$connexion->quote($idCapt))->fetch();
      $nomCapt = $capt[0];
      $unite = $capt[1];

      $data .= "<tr>\n";
      $data .= "  <td><span class=\"sonde-selected\" sonde-id=".$idCapt."><span class=\"sonde-color\" style=\"background-color: #27636D;\"></span> ".$nomCapt."</span>\n";
      $data .= "  <td data-value='".$res[0]."''>".$res[0]. " " . $unite."</td>\n";
      $data .= "  <td data-value='".$res[1]."''>".$res[1]. " " . $unite."</td>\n";
      $data .= "  <td data-value='".$res[2]."''>".$res[2]. " " . $unite."</td>\n";
      $data .= "  <td data-value='".$res[3]."''>".$res[3]. " " . $unite."</td>\n";
      $data .= "</tr>\n";


    }
    echo $data;

    



  }



?>
<script type="text/javascript">
  
  function refreshTab(){
    var chart = $('#chart').highcharts();
    $("#tabStat").html("");
    if(!captParDefaut){
      $("#selected-sonde .sonde-selected").each(function(){
        var id = $(this).attr("sonde-id");
        $.getJSON('includes/scripts/getDataStat.php?id='+ id 
                + '&start=' + Math.round(chart.xAxis[0].getExtremes().min) 
                + '&end=' + Math.round(chart.xAxis[0].getExtremes().max)
                + '&callback=?', function (data) {
          var spanColorContent = $(".sonde-selected[sonde-id="+id+"] .sonde-color").attr('style');
          console.log(data[0][1]);
          $("#tabStat").append(
             "<tr>\n"
            + "<td data-sort-value=\"" + data[0][0] + "\"><span class=\"sonde-selected\" sonde-id=" + id + "><span class=\"sonde-color\" style=\"" + spanColorContent + "\"></span> "+ data[0][0] + "</span>\n"
            + "  <td data-sort-value='" + (data[0][1] == null ? "-1337" : data[0][1]) + "'>"+data[0][1]+ " " + data[0][5]+"</td>\n"
            + "  <td data-sort-value='" + (data[0][2] == null ? "-1337" : data[0][2]) + "'>"+data[0][2]+ " " + data[0][5]+"</td>\n"
            + "  <td data-sort-value='" + (data[0][3] == null ? "-1337" : data[0][3]) + "'>"+data[0][3]+ " " + data[0][5]+"</td>\n"
            + "  <td data-sort-value='" + (data[0][4] == null ? "-1337" : data[0][4]) + "'>"+data[0][4]+ " " + data[0][5]+"</td>\n"
            + "</tr>\n");
        });
      });
    }else{
      $.each([1,7,10,16,19,22], function(i , l){
        var id = l;
        $.getJSON('includes/scripts/getDataStat.php?id='+ id 
                + '&start=' + Math.round(chart.xAxis[0].getExtremes().min) 
                + '&end=' + Math.round(chart.xAxis[0].getExtremes().max)
                + '&callback=?', function (data) {
          $("#tabStat").append(
             "<tr>\n"
            + "<td data-sort-value=\"" + data[0][0] + "\"><span class=\"sonde-selected\" sonde-id="+id+"><span class=\"sonde-color\" style=\"background-color: #27636D;\"></span> "+data[0][0]+"</span>\n"
            + "  <td data-sort-value='" + (data[0][1] == null ? "-1337" : data[0][1]) + "'>"+data[0][1]+ " " + data[0][5]+"</td>\n"
            + "  <td data-sort-value='" + (data[0][2] == null ? "-1337" : data[0][2]) + "'>"+data[0][2]+ " " + data[0][5]+"</td>\n"
            + "  <td data-sort-value='" + (data[0][3] == null ? "-1337" : data[0][3]) + "'>"+data[0][3]+ " " + data[0][5]+"</td>\n"
            + "  <td data-sort-value='" + (data[0][4] == null ? "-1337" : data[0][4]) + "'>"+data[0][4]+ " " + data[0][5]+"</td>\n"
            + "</tr>\n");

        });
      });
    }
      
  }

  function addCaptTab(id){
    var chart = $('#chart').highcharts();
    $.getJSON('includes/scripts/getDataStat.php?id='+ id 
              + '&start=' + Math.round(chart.xAxis[0].getExtremes().min) 
              + '&end=' + Math.round(chart.xAxis[0].getExtremes().max)
              + '&callback=?', function (data) {
      var spanColorContent = $(".sonde-selected[sonde-id="+id+"] .sonde-color").attr('style');
      console.log(data[0][1]);
      $("#tabStat").append(
        "<tr>\n"
        + "<td data-sort-value=\"" + data[0][0] + "\"><span class=\"sonde-selected\" sonde-id=" + id + "><span class=\"sonde-color\" style=\"" + spanColorContent + "\"></span> "+ data[0][0] + "</span>\n"
        + "  <td data-sort-value='" + (data[0][1] == null ? "-1337" : data[0][1]) + "'>"+data[0][1]+ " " + data[0][5]+"</td>\n"
        + "  <td data-sort-value='" + (data[0][2] == null ? "-1337" : data[0][2]) + "'>"+data[0][2]+ " " + data[0][5]+"</td>\n"
        + "  <td data-sort-value='" + (data[0][3] == null ? "-1337" : data[0][3]) + "'>"+data[0][3]+ " " + data[0][5]+"</td>\n"
        + "  <td data-sort-value='" + (data[0][4] == null ? "-1337" : data[0][4]) + "'>"+data[0][4]+ " " + data[0][5]+"</td>\n"
        + "</tr>\n");

    });
  }

  function removeCaptTab(id) {
    $("tr td .sonde-selected[sonde-id="+id+"]").parent().parent().remove();
  }
  


</script>