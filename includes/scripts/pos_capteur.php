<?php
  require_once __DIR__.'/../../admin/ConnexionBD.php';
  
  $couleursParDispositifs = array('1' => '255, 255, 255', // Puit
                                  '2' => '235, 151, 78', // REF
                                  '3' => '31, 58, 147', // Air
                                  '4' => '255, 255, 255', // Tube
                                  '5' => '244, 208, 63', // VMC
                                  '6' => '214, 69, 65', // A
                                  '7' => '42, 187, 155', // B
                                  '8' => '30, 144, 245', // C
                                  '9' => '216, 191, 216', // D
                                  '12' => '42, 187, 155'); // E
  
  global $connexion;
  $stmt = $connexion -> prepare("SELECT * FROM capteur where idD < 15");
  $stmt -> execute();

  echo "<script>";
  
  foreach ($stmt as $q) {
    $x = $q['posXC'];
    $y = $q['posYC'];
    $z = $q['posZC'];
    $nom = $q['nomC'];
    $id = $q['idC'];

    echo "placer_capteur('".$nom."',". $id ."," . $q['idD'] . ",".$x.",".$y.",".$z.",". $couleursParDispositifs[$q['idD']] .");\n";

  }

  echo "</script>";
?>