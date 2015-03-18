<?php 
  include('GestionBase.php');

  AjouterCapteur($_POST['relier'], $_POST['nom'], $_POST['type'], $_POST['unite'], $_POST['posx'], $_POST['posz'], $_POST['posy']);

  header("Location: ../administration.php");
?>
