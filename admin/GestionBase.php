<?php
  include("ConnexionBD.php");

  // renvoie le nom de tous les dispositifs
    function nomDispositif() {
    global $connexion;
    $result = $connexion->prepare("SELECT idD, nomD from dispositif");
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
  
      // fonction qui renvoie les infos d'une corbeille ou d'un puit en fonction de son nom
  function rechercheNom($nom) {
    global $connexion;
    $result = $connexion -> prepare( "SELECT * FROM Corbeille where Nom = :n");
    $result -> bindParam(':n', $nom);
    $result -> execute();
    $data = $result->fetch(PDO::FETCH_ASSOC);
    if($data) {
      return $data;
    }
    else {  
      $result = $connexion -> prepare("SELECT * FROM Puits where Nom_puits = :nom");
      $result -> bindParam(':nom', $nom);
      $result -> execute();
      $data = $result->fetch(PDO::FETCH_ASSOC);
      if($data) {
        return $data;
      }
    }
    return NULL;
  }
  
      // fonction qui renvoi l'id d'une sonde a partir de son nom
  function rechercheIdSonde($nom) {
    global $connexion;
    $result = $connexion -> prepare("SELECT * FROM Sonde where Nom = :n");
    $result -> bindParam(':n', $nom);
    $result->execute();
    $data = $result->fetch(PDO::FETCH_ASSOC);
    if($data["Sonde_id"]) {
      return $data["Sonde_id"];
    }
    else return NULL;
  }
  
      // associe une sondes a un puit ou une corbeille
  function AjouterDependance($nom_Sonde, $nom_Corbeille) {
    global $connexion;
    $data = rechercheNom($nom_Corbeille);
    $id = rechercheIdSonde($nom_Sonde);
    if($data == NULL && $id == NULL) {
      exit();
    }
    elseif($data["Corbeille_id"]) {
      $req = 'INSERT INTO Appartient_Corbeille VALUES ('.$id.','.$data["Corbeille_id"].')';    
      $result = $connexion -> prepare($req);
      $result -> execute();
    }
    elseif($data["Nom_puits"]) {
      $req = 'INSERT INTO Appartient_Puits VALUES ('.$id.',"'.$data["Nom_puits"].'")';
      $result = $connexion -> prepare($req);
      $result -> execute();
    }
  }
  
  function AjouterPuits($nom) {
    global $connexion;
    $result = $connexion -> prepare("INSERT INTO Puits VALUES(:n)");
    $result -> bindParam(':n', $nom);
    $result -> execute();
  }
  
  //~ function AjouterCorbeille($nom, $posX, $posZ) {
    //~ global $connexion;        
    //~ $result = $connexion -> prepare("INSERT INTO Corbeille VALUES(NULL, :nom, :posX , 210 , :posZ )");
    //~ $result -> bindParam(':nom', $nom);
    //~ $result -> bindParam(':posX', $posX);
    //~ $result -> bindParam(':posZ', $posZ);
    //~ $result -> execute();
  //~ }

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
  
  function suppressionPuits($nomPuits) {
    global $connexion;
    $result = $connexion -> prepare("DELETE from Puits where Nom_puits = :nom");
    $result -> bindParam(':nom', $nomPuits);
    $result -> execute();
  }
  
  function suppressionCorbeille($id) {
    global $connexion;
    $result = $connexion -> prepare("DELETE from dispositif where idD = :id");
    $result -> bindParam(':id', $id);
    $result -> execute();
  }
?>
