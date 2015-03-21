<?php
$callback = $_GET['callback'];
if (!preg_match('/^[a-zA-Z0-9_]+$/', $callback)) {
  die('Invalid callback name');
}
$start = @$_GET['start'];
if ($start && !preg_match('/^[0-9]+$/', $start)) {
  die("Invalid start parameter: $start");
}
$end = @$_GET['end'];
if ($end && !preg_match('/^[0-9]+$/', $end)) {
  die("Invalid end parameter: $end");
}
if (!$end) $end = time() * 1000;
// connect to MySQL

require_once(__dir__."/../../admin/ConnexionBD.php");

// set UTC time
$connexion->exec("SET time_zone = '+00:00'");
// set some utility variables
$range = $end - $start;
$startTime = gmstrftime('%Y-%m-%d %H:%M:%S', $start / 1000);
$endTime = gmstrftime('%Y-%m-%d %H:%M:%S', $end / 1000);
// find the right table
// two days range loads minute data

$taille = "DAYOFYEAR";

if ($range < 2 * 24 * 3600 * 1000) {
  $table = 'stockquotes';
  $taille = "all";
  
// moins d'1 semaine
} elseif ($range < 7 * 24 * 3600 * 1000) {
  $table = 'stockquotes_hour';
  $taille = "all";
  
// moins de 4 mois
}  elseif ($range < 31 * 24 * 3600 * 1000) {
  $table = 'stockquotes_hour';
  $taille = "DAYOFYEAR";
  
// moins de 4 mois
} elseif ($range < 4 * 31 * 24 * 3600 * 1000) {
  $table = 'stockquotes_day';
  $taille = "DAYOFYEAR";
// plus que 4 mois
} elseif ($range < 15 * 31 * 24 * 3600 * 1000) {
  $table = 'stockquotes_day';
  $taille = "WEEKOFYEAR";
// greater range loads monthly data
} else {
  $taille = "DAYOFYEAR";
  $table = 'stockquotes_month';
}
if($taille == "all"){
  $sql = "
  Select date, valeur from donnees 
  where date between '$startTime' and '$endTime'
  and idC = ".@$_GET["id"]."
  order by date
";
}else{

$sql = "
  Select date, avg(valeur) from donnees 
  where date between '$startTime' and '$endTime'
  and idC = ".@$_GET["id"]."
  GROUP BY YEAR(date), ".$taille."(date)
  order by date
";
}
$result = $connexion->query($sql);
$rows = [];
foreach ($result as $row) {
    $donneeX = array();
    
    $date_explosee = explode("-", $row[0]);
    $jourDeb = $date_explosee[2];
    $moisDeb = $date_explosee[1]-1;
    $anneeDeb = $date_explosee[0];
    $jourHeure = explode(" ", $jourDeb);
    $jour = $jourHeure[0];
    //test
    $temp = explode(":", $jourHeure[1]);
    $heure = $temp[0];
    $minute = $temp[1];
    $seconde = $temp[2];

    $rows[] = "[Date.UTC(".$anneeDeb.", ".$moisDeb.", ".$jour.", ".$heure.", ".$minute.", ".$seconde."), ".$row[1]." ]";
      
  
    //$rows[] = "[".$row["date"].",".$row["valeur"]./*",".$row["idC"].*/"]";
}
// print it
header('Content-Type: text/javascript');
echo "/* console.log(' start = $start, end = $end, startTime = $startTime, endTime = $endTime '); */";
echo $callback ."([\n" . join(",\n", $rows) ."\n]);";


?>