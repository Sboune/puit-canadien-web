<?php
  require_once __DIR__.'/../../admin/ConnexionBD.php';
  
  global $connexion;
  $stmt = $connexion -> prepare("SELECT * FROM capteur");
  $stmt -> execute();

  echo "<script>";
  
  foreach ($stmt as $q) {
    $x = $q['posXC'];
    $y = $q['posYC'];
    $z = $q['posZC'];
    $nom = $q['nomC'];
    if($x != 0){
      if($nom[0] == 'A'){
        if($nom[1] == 'i')
          echo "placer_sonde('".$nom."',".$x.",".$y.",".$z.",255,255,255);\n";
        else
          echo "placer_sonde('".$nom."',".$x.",".$y.",".$z.",255,0,0);\n";
      } 
      elseif($nom[0] == 'B')
        echo "placer_sonde('".$nom."',".$x.",".$y.",".$z.",0,255,0);\n";
      elseif($nom[0] == 'C')  
        echo "placer_sonde('".$nom."',".$x.",".$y.",".$z.",0,0,255);\n";
      elseif($nom[0] == 'D')  
        echo "placer_sonde('".$nom."',".$x.",".$y.",".$z.",255,0,255);\n";
      elseif($nom[0] == 'E')
        echo "placer_sonde('".$nom."',".$x.",".$y.",".$z.",205,85,0);\n";
      elseif($nom[0] == 'R')
        echo "placer_sonde('".$nom."',".$x.",".$y.",".$z.",125,125,125);\n";
      elseif($nom[0] == 'T')
        echo "placer_sonde('".$nom."',".$x.",".$y.",".$z.",255,255,255);\n";
      elseif($nom[0] == 'V')
        echo "placer_sonde('".$nom."',".$x.",".$y.",".$z.",255,255,0);\n";
      else
        echo "placer_sonde('".$nom."',".$x.",".$y.",".$z.",0,0,0);\n";
    }
  }

  echo "</script>";
?>