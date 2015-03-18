<?php 
  include('GestionBase.php');

  if ($_POST['tout'] == "non") {
    suppressionDispositif($_POST['id']);
  } else {
    suppressionDispositifCapteur($_POST['id']);
  }

  header("Location: ../administration.php"); 
?>
