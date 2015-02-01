<?php include('/admin/ConnexionBD.php'); ?>

<?php

  function getCapteurNameById($id){
    global $connexion;
    return $connexion->query("select nomC from capteur where idC =".$id)->fetch()[0];
  }


?>



