<?php

class Dispositif{

  private $idD;
  private $nomD;
  private $typeD;
  private $lieu;
  private $posXD;
  private $posYD;
  private $posZD;

  function __construc(){

  }

  public function getIdD(){
    return $this->idD;
  }
  public function setIdD($idD){
    $this->idD = $idD;
  }
  public function getNomD(){
    return $this->nomD;
  }
  public function setNomD($nomD){
    $this->nomD = $nomD;
  }
  public function getTypeD(){
    return $this->typeD;
  }
  public function setTypeD($typeD){
    $this->typeD = $typeD;
  }
  public function getLieu(){
    return $this->lieu;
  }
  public function setLieu($lieu){
    $this->lieu = $lieu;
  }
  public function getPosXD(){
    return $this->posXD;
  }
  public function setPosXD($posXD){
    $this->posXD = $posXD;
  }
  public function getPosYD(){
    return $this->posYD;
  }
  public function setPosYD($posYD){
    $this->posYD = $posYD;
  }
  public function getPosZD(){
    return $this->posZD;
  }
  public function setPosZD($posZD){
    $this->posZD = $posZD;
  }

}

function getDispositifFromRow($row){
  $dispo = new Dispositif();
  $dispo->setIdD($row["idD"]);
  $dispo->setNomD($row["nomD"]);
  $dispo->setTypeD($row["typeD"]);
  $dispo->setLieu($row["lieu"]);
  $dispo->setPosXD($row["posXD"]);
  $dispo->setPosYD($row["posYD"]);
  $dispo->setPosZD($row["posZD"]);
  return $dispo;
}

function getDispositifByIdP($idD){
  require_once(__dir__."\..\admin\ConnexionBD.php");
  $query = $connexion->query("select * from Dispositif where idD = ".$connexion->quote($idD));
  foreach ($query as $row) {
    return getDispositifFromRow($row);
  }
}


?>