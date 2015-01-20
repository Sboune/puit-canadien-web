<?php

require_once(__dir__."/Capteur.php");

class Donnee{

  private $idC;
  private $capteur;
  private $date;
  private $valeur;

  function __construct(){

  }

  public function getIdC(){
    return $this->idC;
  }
  public function setIdC($idC){
    $this->idC = $idC;
  }
  public function getCapteur(){
    if(isset($capteur) && $capteur != ""){
      return $capteur;
    }
    else{
      $capteur = getCapteurById($this->idC);
      return $capteur;
    }
  }
  public function getDate(){
    return $date;
  }
  public function setDate($date){
    $this->date = $date;
  }

  public function getValeur(){
    return $valeur;
  }
  public function setValeur($valeur){
    $this->valeur = $valeur;
  }

}

function getDonneeFromRow($row){
  $donnee = new Donnees();
  $donnee->setIdC($row["idC"]);
  $donnee->setDate($row["date"]);
  $donnee->setDate($row["valeur"]);
  return $donnee;
}



?>