<?php
  require_once __DIR__.'/../../admin/ConnexionBD.php';
  
  global $connexion;
  $stmt = $connexion -> prepare("SELECT * FROM capteur where idD = 15 or idD = 16");
  $stmt -> execute();

  echo "<script>";
  
  foreach ($stmt as $c) {
    $x = $c['posXC'];
    $y = $c['posYC'];
    $z = $c['posZC'];
    $nom = $c['nomC'];
    $idC = $c['idC'];
    $idD = $c['idD'];

    if($idD == 15){
      echo "placer_capteur_sonde('".$nom."',".$idC."," . $idD . ",".$x.",".$y.",".$z.",0,191,255);\n";
    }
    else{
      echo "placer_capteur_sonde('".$nom."',".$idC."," . $idD . ",".$x.",".$y.",".$z.",255,165,0);\n";
    }
  }

  echo "</script>";
?>