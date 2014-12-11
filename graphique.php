<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <?php
    include('includes/layout/head.php');
    include("admin/ConnexionBD.php");
  ?>

  <link rel="stylesheet" href='assets/css/graphique.css' />
  <link rel="stylesheet" href="assets/vendor/jquery/jquery-ui.css" />

  <script src="assets/vendor/jquery/jquery-1.9.1.min.js"></script>
  <script src="assets/vendor/jquery/jquery-ui.js"></script>
  <script src="assets/vendor/jquery/jquery-ui-i18n.min.js"></script>
  <script type="text/javascript" src="admin/menu.js"></script>
  <script type="text/javascript">      
    $(document).ready(function () {    
      $(function() {
        $("#tabs").tabs({heightStyle: "auto"});
      });
    });
  </script>
</head>

<body>
  <?php include('includes/layout/header.php');?>

  <div id='contenu'>
    <div id="tabs">
      <ul>
        <li><a href="#tabs-1">Sélection des sondes</a></li>
        <!--<li><a href="#tabs-2">Graphique</a></li>-->
        <li><a href="#tabs-3">Position des sondes</a></li>
      </ul>
      <div id="tabs-1">
        <div id="ui">
          <?php
            include('includes/layout/form.php');  // liste deroulante sondes selectionne
            include('terrain.php');
          ?>
        </div>
      </div>
      <div id="tabs-2">
        <!--<?php //include('scripts/highcharts/graph.php'); ?>-->
      </div> 
      <div id="tabs-3">
        <img src="assets/images/sondes.png" alt="Positions des sondes" width="800px" height="400px"/>
      </div> 
    </div>
  </div>
  <?php include('includes/layout/footer.php');?>
</body>
</html>
