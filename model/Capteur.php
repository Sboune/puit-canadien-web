<?php

require_once(__dir__."/Donnee.php");

class Capteur{

  private $idC;
  private $idD;
  private $nomC;
  private $dispositif;
  private $typeC;
  private $unite;
  private $nivProfond;
  private $posXC;
  private $posYC;
  private $posZC;

  function __construct(){

  }

  public function getIdC(){
    return $this->idC;
  }
  public function setIdC($idC){
    $this->idC=$idC;
  }
  public function getIdD(){
    return $this->idD;
  }
  public function setIdD($idD){
    $this->idD = $idD;
  }
  public function getNomC(){
    return $this->nomC;
  }
  public function setNomC($nomC){
    $this->nomC = $nomC;
  }
  public function getDispositif(){
    return $this->dispositif;
  }
  public function setDispositif($dispositif){
    $this->dispositif = $dispositif;
  }
  public function getTypeC(){
    return $this->typeC;
  }
  public function setTypeC($typeC){
    $this->typeC = $typeC;
  }
  public function getUnite(){
    return $this->unite;
  }
  public function setUnite($unite){
    $this->unite = $unite;
  }
  public function getNivProfond(){
    return $this->nivProfond;
  }
  public function setNivProfond($nivProfond){
    $this->nivProfond = $nivProfond;
  }
  public function getPosXC(){
    return $this->posXC;
  }
  public function setPosXC($posXC){
    $this->posXC = $posXC;
  }
  public function getPosYC(){
    return $this->posYC;
  }
  public function setPosYC($posYC){
    $this->posYC = $posYC;
  }
  public function getPosZC(){
    return $this->posZC;
  }
  public function setPosZC($posZC){
    $this->posZC = $posZC;
  }

}

function getCapteurFromRow($row){
  $capteur = new Capteur();
  $capteur->setIdC($row["idC"]);
  $capteur->setIdD($row["idD"]);
  $capteur->setNomC($row["nomC"]);
  $capteur->setTypeC($row["typeC"]);
  $capteur->setUnite($row["unite"]);
  $capteur->setNivProfond($row["nivProfond"]);
  $capteur->setPosXC($row["posXC"]);
  $capteur->setPosYC($row["posYC"]);
  $capteur->setPosZC($row["posZC"]);
  return $capteur;
}

function getCapteurById($idC){
  require_once(__dir__."\..\admin\ConnexionBD.php");
  $query = $connexion->query("select * from Capteur where idC = ".$connexion->quote($idC));
  foreach ($query as $row) {
    return getCapteurFromRow($row);
  }
}


?>