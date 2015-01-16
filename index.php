<!DOCTYPE html>
<html lang="fr">
  <head>

    <!-- Basic Page Needs
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <title>Géothermie - Accueil</title>
    <meta name="author" content="IUT Informatique d'Orléans">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <!-- Mobile Specific Metas
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="stylesheet" href="assets/css/fonts/fonts.css">
    <link rel="stylesheet" href="assets/vendor/c3/c3.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/datepicker.css">

    <!-- SCRIPTS
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <script src="assets/vendor/d3/d3.min.js" charset="utf-8"></script>
    <script src="assets/vendor/c3/c3.min.js"></script>
    <script src="assets/vendor/jquery/jquery-1.9.1.min.js"></script>
    <script src="assets/js/datepicker.js"></script>
    <script src="assets/js/datepicker.fr.js"></script>

  </head>
  <body>
    <div class="container">

      <!-- Page Nav
      –––––––––––––––––––––––––––––––––––––––––––––––––– -->
      <nav class="navbar row u-cf">
        <div class="container">
          <a href="#" class="navbar-title u-pull-left">Graphe GTE</a>
          <ul class="navbar-list u-pull-right">
            <li class="navbar-item"><a href="#" class="navbar-link">Administration</a></li>
            <li class="navbar-item"><a href="#" class="navbar-link">Aide</a></li>
          </ul>
        </div>
      </nav>

      <!-- Page Content - Boxes
      –––––––––––––––––––––––––––––––––––––––––––––––––– -->
      <div class="boxes">

        <h2>Générer un graphe</h2>

        <section>
          <h5 class="section-header">Filtres</h5>
          <div class="box">
            <div class="box-section">
              <p>Utilisez la vue 3D pour sélectionner des sondes</p>
              <img src="assets/images/3D-debug.png" alt="3D-debug" class="responsive-image">
            </div>
            <hr>
            <div class="box-section">
              <h6>Sondes sélectionnées : </h6>
              <canvas class="sonde1-canevas" width="10" height="10"></canvas> Sonde 2m - 
              <canvas class="sonde2-canevas" width="10" height="10"></canvas> Sonde 3m - 
              <canvas class="sonde3-canevas" width="10" height="10"></canvas> Sonde 1.5m
            </div>
            <hr>
            <div class="box-section">
              <form action="#">
                <h6>Afficher sur une période de :</h6>
                <div class="row input-daterange" id="datepicker">
                  <div class="one-half column">
                    <label for="dateDebut">Date de début</label>
                    <input class="u-full-width input-sm" value="10/01/2015" type="text" id="dateDebut" size="18" name="start" >
                  </div>
                  <div class="one-half column">
                    <label for="dateFin">Date de fin</label>
                    <input class="u-full-width input-sm" value="16/01/2015" type="text" id="dateFin" size="18" name="end" >
                  </div>
                </div>
                <div class="row">
                  <div class="twelve columns">
                    <input class="button-primary u-full-width" type="submit" value="Génerer">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </section>

        <section>
          <h5 class="section-header">Graphique des températures</h5>
          <div class="box">
            <div class="box-section">
              <div id="chart"></div>
            </div>
          </div>
        </section>

        <section>
          <h5 class="section-header">Statistiques</h5>
          <div class="box">
            <div class="box-section">
              <table class="u-full-width">
                <thead>
                  <tr>
                    <th>Sonde</th>
                    <th>min</th>
                    <th>max</th>
                    <th>ecart-type</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><canvas class="sonde1-canevas" width="10" height="10"></canvas> Sonde 2m</td>
                    <td>9</td>
                    <td>25</td>
                    <td>18</td>
                  </tr>
                  <tr>
                    <td><canvas class="sonde2-canevas" width="10" height="10"></canvas> Sonde 3m</td>
                    <td>5</td>
                    <td>12</td>
                    <td>8</td>
                  </tr>
                  <tr>
                    <td><canvas class="sonde3-canevas" width="10" height="10"></canvas> Sonde 1.5m</td>
                    <td>1</td>
                    <td>8</td>
                    <td>3</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </div>
    </div>
    <footer class="footer-bar">
      <div class="container">
        <ul class="footer-list">
          <li class="footer-item">Projet de l'<a class="footer-link" href="#">IUT Informatique d'Orléans</a></li> <span>|</span>
          <li class="footer-item"><a class="footer-link" href="#">License</a></li> <span>|</span>
          <li class="footer-item"><a class="footer-link" href="#">Contact</a></li>
        </ul>
      </div>
    </footer>

    <script src="assets/js/graph.js"></script>
    <script>

      $('#datepicker').datepicker({
        format: "dd/mm/yyyy",
        weekStart: 1,
        todayBtn: "linked",
        language: "fr"
      });

      $('.sonde1-canevas').each(function(index) {
        var canvas = this;
        var context = canvas.getContext('2d');
        context.rect(0, 0, 10, 10);
        context.fillStyle = '#27636D';
        context.fill();
      });

      $('.sonde2-canevas').each(function(index) {
        var canvas = this;
        var context = canvas.getContext('2d');
        context.rect(0, 0, 10, 10);
        context.fillStyle = '#FA7577';
        context.fill();
      });

      $('.sonde3-canevas').each(function(index) {
        var canvas = this;
        var context = canvas.getContext('2d');
        context.rect(0, 0, 10, 10);
        context.fillStyle = '#C5DFA2';
        context.fill();
      });

    </script>
  </body>
</html>
