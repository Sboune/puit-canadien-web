<?php
  include("ConnexionBD.php");

  // renvoie le nom de tous les dispositifs
    function infoDispositif() {
    global $connexion;
    $result = $connexion->prepare("SELECT * from dispositif");
    $result->execute();
    return $result;
  }
  
  // renvoie les infos de tous les capteurs
  function infoCapteur() {
    global $connexion;
    $result = $connexion -> prepare("SELECT * from capteur");
    $result -> execute();
    return $result;
  }

function AjouterArduino($nom, $adress) {
     global $connexion;
     $result = $connexion -> prepare("INSERT INTO arduino VALUES (NULL, :nom, NULL, :adress)");
     $result -> bindParam(':nom', $nom);
     $result -> bindParam(':adress', $adress);
     $result -> execute();
   }

  function AjouterCapteur($idD, $nom, $type, $unite, $x, $z, $y) {
    global $connexion;
    $niveau = (420-$y)/100;
    $result = $connexion -> prepare("INSERT INTO capteur VALUES (NULL, :idD, :nomC, :typeC, :unite, :nivProfond, :posXC, :posYC, :posZC)");
    $result -> bindParam(':idD', $idD);
    $result -> bindParam(':nomC', $nom);
    $result -> bindParam(':typeC', $type);
    $result -> bindParam(':unite', $unite);
    $result -> bindParam(':nivProfond', $niveau);
    $result -> bindParam(':posXC', $x);
    $result -> bindParam(':posYC', $y);
    $result -> bindParam(':posZC', $z);
    $result -> execute();
  }

  function AjouterDispositif($nom, $type, $lieu, $posx, $posy, $posz) {
     global $connexion;
     $result = $connexion -> prepare("INSERT INTO dispositif VALUES (NULL, :nom, :type, :lieu, :posx, :posy, :posz)");
     $result -> bindParam(':nom', $nom);
     $result -> bindParam(':type', $type);
     $result -> bindParam(':lieu', $lieu);
     $result -> bindParam(':posx', $posx);
     $result -> bindParam(':posy', $posy);
     $result -> bindParam(':posz', $posz);
     $result -> execute();
   }
  
  function suppressionDonnees($id) {
	global $connexion;
    $result = $connexion -> prepare("DELETE from donnees where idC = :id");
    $result -> bindParam(':id', $id);
    $result -> execute();
  }

  function suppressionCapteur($id) {
    global $connexion;
    $result = $connexion -> prepare("DELETE from capteur where idC = :id");
    $result -> bindParam(':id', $id);
    $result -> execute();
  }

  
  function suppressionDispositif($id) {
    global $connexion;
    $result = $connexion -> prepare("DELETE from dispositif where idD = :id");
    $result -> bindParam(':id', $id);
    $result -> execute();
  }
?>
