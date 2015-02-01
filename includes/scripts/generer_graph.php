<?php include('/admin/ConnexionBD.php'); ?>

<?php

  function getCapteurNameById($id){
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



