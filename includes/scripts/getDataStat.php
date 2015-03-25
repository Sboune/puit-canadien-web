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
$connexion->exec("SET NAMES UTF8");
// set some utility variables
$range = $end - $start;
$startTime = gmstrftime('%Y-%m-%d %H:%M:%S', $start / 1000);
$endTime = gmstrftime('%Y-%m-%d %H:%M:%S', $end / 1000);
// find the right table
// two days range loads minute data
$q = $connexion->query("select nomC, unite from capteur where idC =". $connexion->quote($_GET["id"]))->fetch();

$idC = $q[0];
$unite = $q[1];

$sql = "select ROUND(min(valeur), 2), ROUND(max(valeur), 2), ROUND(avg(valeur), 2), ROUND(std(valeur), 2) from donnees where date >= "
                               . $connexion->quote($startTime) ." and date <= ". $connexion->quote($endTime) ." and idC = ". $connexion->quote($_GET["id"]);
$result = $connexion->query($sql)->fetch();
$rows = [];
    // echo "/*$idC*/";
    // echo "/*$result[0]*/";
    // echo "/*$result[1]*/";
    // echo "/*$result[2]*/";
    // echo "/*$result[3]*/";


    $rows[] = "[ '".$idC."', ".$result[0].", ".$result[1].", ".$result[2].", ".$result[3].", '".$unite."' ]";
  
    //$rows[] = "[".$row["date"].",".$row["valeur"]./*",".$row["idC"].*/"]";

// print it
header('Content-Type: text/javascript');
// echo "/* console.log(' start = $start, end = $end, startTime = $startTime, endTime = $endTime '); */";
echo $callback ."([\n" . join(",\n", $rows) ."\n]);";


?>