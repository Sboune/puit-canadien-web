<?php
  $pass = '0000';

  if(isset($_POST['pass'])) {
    if($_POST['pass'] == $pass) {
      $_SESSION['pass'] = true;  
    }
    else {
      echo "<p style=\"margin-top: 20px ; text-align: center;font-size:16px;font-weight:bold;color:red\">Erreur de mot de passe...</p><br />";
      $_SESSION['pass'] = false;
    }
  }

  if(!isset($_SESSION['pass'])) {
    $_SESSION['pass'] = false;
  }
?>
