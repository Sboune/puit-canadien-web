<?php include('/admin/ConnexionBD.php'); ?>

<?php

	function valider(){
  	if(isset($_POST['generer'])){
    	generer_graph();
  	}
  }

//fonction qui génére un graph en fonction des capteurs et des dates selectionnées
	function generer_graph()
  {
		if(isset($_POST['A1-1'])&& isset($_POST['dateDebut']) && isset($_POST['dateFin'])){
			echo "Interval du :";
			echo $_POST['dateDebut'];
			echo " au ";
			echo $_POST['dateFin'];
			$dateDebut = $_POST['dateDebut'];
			$dateFin = $_POST['dateFin'];
			$capteur1 = getCapteur("A1-1");
			$dataCapteur1 = getData($capteur1, $dateDebut, $dateFin);
			testPrint($dataCapteur1);
		}
		else{
			echo "choisissez un capteur, et des dates";
		}
	}

//fonction qui prend en paramètre le nom d'un capteur et renvoie le capteur
	function getCapteur($nom){
		global $connexion;
		$pstmt = $connexion->prepare("Select * from capteur where nomD = :nom");
    $pstmt -> bindParam(':nom', $nom);
    $pstmt -> execute();
    $capteur = $pstmt -> fetch();
    return $capteur;
	}

//fonction qui prend en paramètre un capteur, une date de début et une date de fin et retourne les données enregistrer par le capteur pendant cet interval de temps
	function getData($capteur , $dateDebut, $dateFin){
		global $connexion;

		//transformation des dates pour qu'elles soient reconnu par MySQL
		$date_explosee = explode("/", $dateDebut);  // la fonction explode permet de séparer la chaine en tableau selon un délimiteur

  	$jourDeb = $date_explosee[1];
 		$moisDeb = $date_explosee[0];
 		$anneeDeb = $date_explosee[2];

		$date_explosee = explode("/", $dateFin);

 	 	$jourFin = $date_explosee[1];
 	 	$moisFin = $date_explosee[0];
 	 	$anneeFin = $date_explosee[2];

	 	$dateDebut = $anneeDeb."-".$jourDeb."-".$moisDeb;
 		$dateFin = $anneeFin."-".$jourFin."-".$moisFin;

 		//requete de selection des données
		$stmt = $connexion->prepare("Select date,valeur from donnees where date >= DATE_FORMAT(:date_d,'%d/%m/%Y %T') and date <= DATE_FORMAT(:date_f,'%d/%m/%Y %T') and idC = :id_capteur ");
    $stmt -> bindParam(':date_d' , $dateDebut);
    $stmt -> bindParam(':date_f' , $dateFin);
    $stmt -> bindParam(':id_capteur' , $capteur[0]);
    $stmt -> execute();

    $i = 0;
    $data = array();
    //$date = array(); non prise en compte de la date des données pour le moment

    foreach($stmt as $requete) { 
      $data[$i] = $requete[1];
      //$date[$i] = $requete[0];
      $i = $i+1;
    }
    return $data;
	}

	function testPrint($data){
		echo " Données : ";
		foreach ($data as $d) {
			echo " / ";
			echo $d;
		}
	}




?>



