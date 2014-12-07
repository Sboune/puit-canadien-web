<!DOCTYPE html>

<html lang="fr">
	<head>
		<meta charset="utf-8">
      		<title>Affichage graphique</title>

	</head>

	<body>

	<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	<?php
	require_once("includes/scripts/dessiner_graph.php");
	require_once("includes/scripts/exportation_fichier.php");

	if( !empty($_GET["datedeb"]) && !empty($_GET["datefin"]) && !empty($_GET["Sondes"]) ){

	$v = explode("Sonde ",$_GET["Sondes"]);

	$res = array();

	foreach($v as $i)
		   $res[] = substr($i,0,-6);

	unset($res[0]);

    	generer_Graphique($_GET["datedeb"],$_GET["datefin"], $res,"container" );

	echo "<form action='graph.php'> ";
	      echo "<input type='submit' value='Exporter les données des sondes sous format tableur' />";
	      echo "<input type = 'hidden' name='datedeb2' value='" . $_GET['datedeb']. "'/>";
	      echo "<input type = 'hidden' name='datefin2' value='" . $_GET['datefin']. "'/>";
	      echo "<input type = 'hidden' name='Sondes2' value='" . $_GET['Sondes']. "'/>";
	echo "</form>";


	}
	else{	

	if(!empty($_GET["datedeb2"]) && !empty($_GET["datefin2"]) && !empty($_GET["Sondes2"]) ){


	$v = explode("Sonde ",$_GET["Sondes2"]);

	$res = array();

	foreach($v as $i)
		   $res[] = substr($i,0,-6);

	unset($res[0]);


	   Exportation_Fichier($_GET["datedeb2"], $_GET["datefin2"], $res );
	   //header("location:".  $_SERVER['HTTP_REFERER']);

	}

	}

	?>



	</body>

</html>
