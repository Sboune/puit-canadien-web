<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>

  <?php
    $title = "Administration";
    include('includes/layout/head.php');
    include('admin/GestionBase.php');
  ?>

  <!-- POUR LA SELECTION A VOIR SI IL FAUT GARDER -->
  <link rel="stylesheet" href="assets/vendor/jquery/jquery-ui.css">
  <link rel="stylesheet" href="assets/vendor/jquery/jquery.ui.theme.css">
  <script type="text/javascript" src="assets/vendor/jquery/jquery-ui.js"></script>
  <!-- !! -->

  <script type="text/javascript" src="assets/vendor/tabs/js/easyResponsiveTabs.js"></script>
  <link rel="stylesheet" href="assets/vendor/tabs/css/easy-responsive-tabs.css">

  <script type="text/javascript">
    $(document).ready(function () { 
      $(function() {
        $( "#selectable" ).selectable();
        $( "#selectable2" ).selectable();
        $( "#selectable3" ).selectable();
      });

    $('#supprSonde').click(function () {
      $('#selectable .ui-widget-content.ui-selected').each(function(index) {
        var tmp = $(this).attr('data-userid');
        $.post('admin/supprSonde.php', { id : tmp })
          .done(function (data) { location.reload(); })
          .fail(function (data) {});
      });
    });

    $('#supprCorbeille').click(function () {
      $('#selectable2 .ui-widget-content.ui-selected').each(function(index) {
        var tmp = $(this).attr('data-userid');
        $.post('admin/supprCorbeille.php', { id : tmp })
          .done(function (data) { location.reload(); })
          .fail(function (data) {});
      });
    });

    $('#supprPuits').click(function () {
      $('#selectable3 .ui-widget-content.ui-selected').each(function(index){
        var tmp = $(this).text();
        $.post('admin/supprPuits.php', { nom : tmp })
          .done(function (data) { location.reload(); })
          .fail(function (data) {  });
      });
    });	

    <?php
      $res = nomCorbeille();
      $res2 = nomPuits();

      while($data = $res->fetch(PDO::FETCH_ASSOC)) {
        echo "$('#sondeCorbeille').append('<option>" . $data['Nom'] . "');\n";
      }

      while($data = $res2->fetch(PDO::FETCH_ASSOC)) {
        echo "$('#sondeCorbeille').append('<option>" . $data['Nom_puits']. "');\n";
      }
    ?>
    });
  </script>
</head>

<body>
  <?php include('includes/layout/header.php'); ?>

  <?php include("admin/pass.php"); ?> <!-- Verifie le mot de passe de l'admin -->

  <div class="container">
  <div class="wrapper">
  <h2>Administration</h2>
    <?php
    if($_SESSION['pass'] == false) {
    ?>

    <div class="login-box">
      <p>Veuillez entrer le mot de passe !</p>
      <form style="text-align: center" action="#" method="post">
        <input type="password" name="pass" value=""/>   
        <input type="submit" value="Valider"/>
      </form>
    </div>

    <?php } else { ?>

    <div id="parentTab">
      <ul class="resp-tabs-list hor_1">
        <li>Gérer sondes</li>
        <li>Gérer dispositifs</li>
        <li>Impoter/Exporter</li>
        <li>Arduino</li>
      </ul>
      <div class="resp-tabs-container hor_1">
        <div>
          <br>
          <form action="admin/ajouterSonde.php" method="post">
            <h6>Ajouter une sonde</h6>
            <div class="row">
              <div class="six columns">
                <label for="nom">Nom de la sonde : </label>
                <input type="text" class="u-full-width" name="nom" id="nom">
              </div>
              <div class="six columns">
                <label for="relier">Dispositif parent : </label>
                <select name="relier" class="u-full-width" id="sondeCorbeille"></select>
              </div>
            </div>
            <div class="row">
              <div class="four columns">
                <label for="niveau">Niveau (y): </label>
                <select name="niveau" class="u-full-width">
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2.5">2.5</option>
                  <option value="4">4</option>
                </select>
              </div>
              <div class="four columns">
                <label for="posx">Position x :</label>
                <input type="text" class="u-full-width" name="posx" id="posx">
              </div>
              <div class="four columns">
                <label for="posz">Position z :</label>
                <input type="text" class="u-full-width" name="posz" id="posz">
              </div>
              <input type="submit" value="Ajouter" class="button-primary u-pull-right" />
            </div>
          </form>
          <hr>
          <h6>Supprimer des sondes</h6>
          <div class="tabs-listeSondes">
            <ul id="selectable">
            <?php
              $res = nomSonde();
              while($data = $res->fetch(PDO::FETCH_ASSOC)) {
                echo '<li class="ui-widget-content" data-userid="' . $data['Sonde_id'] . '">' . $data['Nom'] . '</li>';
              }
            ?>
            </ul>
          </div>
          <button type="button" class="button-primary u-pull-right" id="supprSonde">Supprimer</button>
          <div class="u-cf"></div>
        </div>
        <div>
          <br>
          <form action="#" method="post">
            <h6>Ajouter un dispositif</h6>
            <div class="row">
              <div class="six columns">
                <label for="nom">Nom du dispositif :</label>
                <input type="text" class="u-full-width" name="nom" id="nom">
              </div>
              <div class="six columns">
                <label for="type">Type du dispositif :</label>
                <select name="type" class="u-full-width">
                  <option value="corbeille">Corbeille</option>
                  <option value="puit">Puit Canadien</option>
                  <option value="autre">Autre</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="twelve columns">
                <label for="lieu">Lieu :</label>
                <select name="lieu" class="u-full-width">
                  <option value="devantGTE">Devant batiment GTE</option>
                  <option value="cafeteria">À côté de la cafétéria</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="four columns">
                <label for="posx">Position x :</label>
                <input type="text" class="u-full-width" name="posx" id="posx">
              </div>
              <div class="four columns">
                <label for="posy">Position y :</label>
                <input type="text" class="u-full-width" name="posy" id="posy">
              </div>
              <div class="four columns">
                <label for="posz">Position z :</label>
                <input type="text" class="u-full-width" name="posz" id="posz">
              </div>
            </div>
            <input type="submit" value="Ajouter" class="button-primary u-pull-right" />
          </form>
          <hr>
          <h6>Supprimer un dispositif</h6>
          <p>Corbeilles : </p>
          <div class="tabs-listeSondes">
            <ul id="selectable2">
              <?php
                $res = nomCorbeille();
                while($data = $res->fetch(PDO::FETCH_ASSOC)){
                  echo '<li class="ui-widget-content" data-userid="' . $data['Corbeille_id'] . '">' . $data['Nom'] . '</li>';
                }
              ?>
            </ul>
          </div>
          <button type="button" class="button-primary u-pull-right" id="supprCorbeille">Supprimer</button>
          <div class="u-cf"></div>
          <p>Puits canadien : </p>
          <div class="tabs-listeSondes">
            <ul id="selectable2">
              <?php
                $res = nomPuits();
                while( $data = $res->fetch(PDO::FETCH_ASSOC) ){
                  echo '<li class="ui-widget-content" data-userid=>'. $data['Nom_puits'] . '</li>';
                }
              ?>
            </ul>
          </div>
          <button type="button" class="button-primary u-pull-right" id="supprCorbeille">Supprimer</button>
          <div class="u-cf"></div>
        </div>
        <div>
          <br>
          <h6>Import d'un fichier .sql</h6>
          <form name="import" enctype="multipart/form-data" action="admin/backupBase.php" method="post">
            <div class="row">
              <div class="twelve columns">
                <label for="file">Fichier .sql:</label>
                <input type="file" class="u-full-width" name="sql">
              </div>
            </div>
            <input type="hidden" name="action" value="import">
            <input type="hidden" name="MAX_FILE_SIZE" value="300000">
            <input type="submit" class="button-primary u-pull-right" value="Valider">
            <br>
          </form>
          <h6>Export de la base :</h6>
          <form name="export" action="admin/backupBase.php" method="post">
            <div class="row">
              <div class="twelve columns">
                <label for="filename">Nom du fichier :</label>
                <input type="text" name="filename" class="u-full-width">
              </div>
            </div>
            <input type="hidden" name="action" value="export">
            <input type="submit" class="button-primary u-pull-right" value="Valider">
          </form>
          <div class="u-cf"></div>
        </div>
        <div>
          <br>
          <h6>Changement de la fréquence des saisies</h6>
          <form name="chgFreq" action="admin/arduino.php" method="post">
            <div class="row">
              <div class="twelve columns">
                <label for="freq">Fréquence (en ms):</label> 
                <input type="text" name="freq" class="u-full-width" id="freq">
              </div>
            </div>
            <input type="submit" class="button-primary u-pull-right" value="Valider">
          </form>
          <div class="u-cf"></div>
        </div>
      </div>
    </div>
    <?php } ?>
    <div class="push"></div>
    <div class="push"></div>
  </div> <!-- wrapper -->
  </div> <!-- container -->

<?php include('includes/layout/footer.php');  ?>

  <script type="text/javascript">
    $(document).ready(function() {
        //Horizontal Tab
        $('#parentTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            tabidentify: 'hor_1', // The tab groups identifier
            active_border_color: '#e1e1e1', // border color for active tabs heads in this group
            active_content_border_color: '#E94F51',
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });
    });
  </script>

</body>
</html>