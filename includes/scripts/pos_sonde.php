<?php
  require_once __DIR__.'/../../admin/ConnexionBD.php';
  
  global $connexion;
  $stmt = $connexion -> prepare("SELECT * FROM dispositif where nomD = 'sonde80' or nomD = 'sonde70' or nomD='sonde70bis'");
  $stmt -> execute();

  echo "<script>";

  foreach ($stmt as $d) {
    $x = $d['posXD'];
    $y = $d['posYD'];
    $z = $d['posZD'];
    $nom = $d['nomD'];
    echo "placer_sonde('".$nom."',".$x.",".$y.",".$z.");\n";
  }
  echo "</script>";
?>