<?php
require_once("../admin/config.php");


	/* =====================================================================================
	 Cette fonction prend en parametre une date de debut une date de fin et une sonde.
	 Elle interoge la base de donnée afin de gerer un fichier ods ( format libre office tableur )
	 qui contient les données de temperature demandées.
	 Les variables renseignant les dates doivent être au format suivant : 
	 '2013-02-25' ou si on veut plus de précision : '2013-02-25 19:20:00'
	 les noms des sondes sont de simples nom : 'A1-1' , 'B1-2.5' ...
	 exemple d'appel : Exportation_Fichier ( '2013-02-14' , '2013-02-15 19:20:00' , array( 'A1-1' , 'B1-2.5') )

	 /!\ le dossier ou sera placer le fichier doit avoir les droits d'ecriture de même que ce fichier
	 sinon cela posera probleme, actuellement c'est le dossier WWW.
	===================================================================================== */

	Function Exportation_Fichier( $dateDeb , $dateFin , $nom_sonde ){

		 global $connexion;
		 $id_sonde = array();

		 foreach( $nom_sonde as $val ){
		 	  $pstmt = $connexion->prepare("Select Sonde_id from Sonde where Nom = :nom");
		 	  $pstmt->bindParam(':nom' , $val);
			  $pstmt->execute();

			  $aux = $pstmt -> fetch();
			  $id_sonde[] = $aux[0]; 

		}


		$date_explosee = explode("/", $dateDeb);  // la fonction explode permet de séparer la chaine en tableau selon un délimiteur

		$jourDeb = $date_explosee[1];
		$moisDeb = $date_explosee[0];
		$anneeDeb = $date_explosee[2];

		$date_explosee = explode("/", $dateFin);

		$jourFin = $date_explosee[1];
		$moisFin = $date_explosee[0];
		$anneeFin = $date_explosee[2];

		$dateDeb = $anneeDeb."-".$moisDeb."-".$jourDeb;// on remet la date au format de la base de donnée
		$dateFin = $anneeFin."-".$moisFin."-".$jourFin;// de même

		$req = "Select Date from Temperature where Date >= :date_d and Date <= :date_f and (";
		$cpt = 0;
		foreach($id_sonde as $id){
				  $req = $req . "Sonde_id = :id" . $cpt . " or ";
				  $cpt++;
		}	
			  
		$req = substr($req,0,-3);// en enlève le chaine "or " superflue
		$req = $req . ")";


		 $stmt = $connexion->prepare($req);// requete pour recuperer les donnes demandees
	         $stmt->bindParam(':date_d' , $dateDeb);	
	         $stmt->bindParam(':date_f' , $dateFin);

		 $cpt = 0;
		 foreach($id_sonde as $id){	
	         		   $stmt->bindParam(':id' . $cpt , $id);
		 		   $cpt++;
		 }		  

		 $stmt->execute();

		 $tabDate = array();
		 foreach($stmt as $dateT)
		 	       $tabDate[] = $dateT[0]; 
		

		/* on obtient un tableau de toutes les dates qui seront a mettre dans notre fichier, ceci est fait dans le but d'avoir toutes les dates de toutes les sondes et de palier le problème une sonde n'a pas de valeur a cette date et une autre oui*/


		foreach($id_sonde as $id){// on va générer un tableau associatif pour chaque sonde pour permettre l'écriture dans le fichier plus facilement
		
			$stmt = $connexion->prepare("Select Date,Valeur from Temperature where Date >= :date_d and Date <= :date_f and Sonde_id = :id_sonde");// requete pour recuperer les donnees demandees
	         	$stmt->bindParam(':date_d' , $dateDeb);	
	         	$stmt->bindParam(':date_f' , $dateFin);
			$stmt->bindParam(':id_sonde', $id);
			$stmt->execute();


			$id_sonde[$id] = array();

			foreach($stmt as $val)
				      $id_sonde[$id][ $val[0] ] =  $val[1]; // la date donne une valeur

		}

		$telechargement = $dateDeb.'_'.$dateFin;
		$nom = $_SERVER['DOCUMENT_ROOT'] . '/' . $dateDeb . '_' . $dateFin; 
		foreach( $nom_sonde as $n){
			$nom = $nom . '_' . $n;
			$telechargement = $telechargement.'_'.$n;
		}

		$nom = $nom . '.ods';
		$telechargement = $telechargement.'.ods';
		$fichier = fopen( $nom , 'w' );// on cree un fichier ods

		fwrite($fichier ,  "Date" . chr(59));

		foreach( $tabDate as $val )
			 fwrite($fichier, $val . chr(59));

		$cpt = 1;

		foreach( $id_sonde as $id => $valeur )
			 if( is_array($valeur) ){ // si la sonde que l'on gère contient des valeur de température aux dates fixées
			     fwrite($fichier, "\nSonde" . $nom_sonde[$cpt] . chr(59));
			     foreach( $tabDate as $val )
			 	  if( !empty($id_sonde[$id][$val]) )
			 	      fwrite($fichier, $id_sonde[$id][$val] . chr(59) .chr(59) );
				  else
			 	      fwrite($fichier, chr(59));
			     $cpt++;
			}

	 	    fclose($fichier);// fermeture du fichier

	 	header("location: ../../../../".$telechargement);    
	}
?>