<?php 
  include('GestionBase.php');

  AjouterCapteur($_POST['relier'], $_POST['nom'], $_POST['type'], $_POST['unite'], $_POST['niveau'], $_POST['posx'], $_POST['posz']);

  header("Location: ../administration.php");
?>
