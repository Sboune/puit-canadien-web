<?php 
  include('GestionBase.php');

  suppressionDispositif($_POST['id']);

  header("Location: ../administration.php"); 
?>
