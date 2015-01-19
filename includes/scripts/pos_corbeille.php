<?php
  require_once __DIR__.'/../../admin/ConnexionBD.php';
  
  global $connexion;
  $stmt = $connexion -> prepare("SELECT * FROM dispositif");
  $stmt -> execute();
  
  foreach ($stmt as $q) {
    $x = $q['posXD'];
    $y = $q['posYD'];
    $z = $q['posZD'];
    $nom = $q['nomD'];
    echo " <script> placer_corbeille('".$nom."',".$x.",".$y.",".$z."); </script>";
  }
?>