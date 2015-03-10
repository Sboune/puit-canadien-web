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
      echo "placer_capteur_sonde('".$nom."',".$idC.",".$x.",".$y.",".$z.",0,255,0);\n";
    }
    else{
      echo "placer_capteur_sonde('".$nom."',".$idC.",".$x.",".$y.",".$z.",0,255,255);\n";
    }
  }

  echo "</script>";
?>