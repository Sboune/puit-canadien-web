<!doctype html>
<html lang="fr">
<head>
  <title>Vue 3D sondes</title>
  <meta charset="utf-8">
  <link rel=stylesheet href="assets/css/sonde3d.css"/>
</head>
<body>

  <script src="assets/vendor/threejs/Three.js"></script>
  <script src="assets/vendor/threejs/Detector.js"></script>
  <script src="assets/vendor/threejs/Stats.js"></script>
  <script src="assets/vendor/threejs/OrbitControls.js"></script>
  <script src="assets/vendor/threejs/THREEx.KeyboardState.js"></script>
  <script src="assets/vendor/threejs/THREEx.FullScreen.js"></script>
  <script src="assets/vendor/threejs/THREEx.WindowResize.js"></script>

  <div id="container" style="z-index: 1; position: absolute; left:300px; right:50px; top:100px; bottom:100px"></div>
  <script src="assets/js/main.js"></script>
  <script src="assets/js/placer_sonde.js"></script>
  <script src="assets/js/placer_corbeille.js"></script>
  <script src="assets/js/placer_puit.js"></script>

  <?php include 'includes/scripts/pos_corbeille.php'; ?>
  <?php include 'includes/scripts/pos_sonde.php'; ?>
  <?php echo "<script> placer_puit(); </script>"; ?>

</body>
</html>