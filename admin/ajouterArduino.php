<?php  
  include('GestionBase.php');

  AjouterArduino($_POST['nom'],$_POST['adress']);
  
  header("Location: ../administration.php");
?>
