<?php
  require_once __DIR__.'/../../admin/ConnexionBD.php';
  
  global $connexion;
  $stmt = $connexion -> prepare("SELECT * FROM dispositif WHERE typeD='corbeille'");
  $stmt -> execute();

  echo "<script>";
  
  foreach ($stmt as $q) {
    $x = $q['posXD'];
    $y = $q['posYD'];
    $z = $q['posZD'];
    $nom = $q['nomD'];
    echo "placer_corbeille('".$nom."',".$x.",".$y.",".$z.");\n";
  }

  echo "</script>";
?>