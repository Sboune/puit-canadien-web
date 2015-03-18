<?php
  include('GestionBase.php');

  suppressionDonnees($_POST['id']);
  suppressionCapteur($_POST['id']);

  header("Location: ../administration.php");
?>
