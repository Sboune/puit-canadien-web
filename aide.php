<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <?php include('includes/layout/head.php'); ?>
  <script type="text/javascript" src="assets/js/scrollspy.js"></script>
</head>
<body>

  <?php include('includes/layout/header.php'); ?>

  <div class="container">
    <div class="wrapper">
      <?php include('includes/layout/doc.html'); ?>
    </div>
  </div>

  <?php include('includes/layout/footer.php'); ?>
  <script>
    $('body').scrollspy({
      target: '.bs-docs-sidebar',
      offset: 180
    });
  </script>
</body>
</html>
