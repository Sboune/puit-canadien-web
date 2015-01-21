<?php  
  include('GestionBase.php');

  AjouterDispositif($_POST['nom'],$_POST['type'],$_POST['lieu'],$_POST['posx'],$_POST['posy'],$_POST['posz']);
  
  header("Location: ../administration.php");
?>
