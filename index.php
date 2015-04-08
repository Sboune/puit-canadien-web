<!DOCTYPE html>
<html lang="fr">
  <head>
    <?php
      $title = "Accueil";
      include('includes/layout/head.php');
      include("admin/ConnexionBD.php");
      include("includes/scripts/generer_graph.php");
    ?>
    <link rel="stylesheet" href="assets/css/datepicker.css">
    <link rel="stylesheet" href="assets/css/sortable-theme-bootstrap.css" />

    <!-- SCRIPTS
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <script src="assets/vendor/d3/d3.min.js" charset="utf-8"></script>
    <script src="assets/vendor/c3/c3.min.js"></script>
    <!--<script src="assets/vendor/highcharts/highcharts.js"></script>-->
    <script src="assets/vendor/highcharts/highstock.js"></script>
    <script src="assets/vendor/highcharts/exporting.js"></script>
    <script src="assets/js/datepicker.js"></script>
    <script src="assets/js/datepicker.fr.js"></script>
    <script src="assets/js/utils.js"></script>
    <script src="assets/js/jquery.sortable.js" ></script>
    <script src="assets/js/export-csv.js"></script>

  </head>
  <body>
    <div class="container">

      <?php include('includes/layout/header.php'); ?>

      <!-- Page Content - Boxes
      –––––––––––––––––––––––––––––––––––––––––––––––––– -->
      <div class="boxes">

        <h2>Générer un graphe</h2>

        <section>
          <h5 class="section-header">Filtres</h5>
          <div class="box">
            <div class="box-section">
              <p class="ta-center">Choisissez la vue à étudier</p>
              <div class="switcher-wraper u-cf">
                <div class="switcher switcher-left active">Vue 1</div>
                <div class="switcher switcher-right">Vue 2</div>
              </div>
              <p>Utilisez la vue 3D pour sélectionner des sondes</p>
              <iframe id="iframe" class="u-full-width" src="includes/layout/vue3D.php"></iframe>
              <button type="button" class="u-pull-right action-button" id="reset" onclick="resetIframe()">Reset</button>
              <button type="button" class="u-pull-right action-button" id="zoomPlus" onclick="zoomIframe()">Zoom +</button>
              <button type="button" class="u-pull-right action-button" id="zoomMoins" onclick="dezoomIframe()">Zoom -</button>
            </div>
            <div class="u-cf"></div>
            <hr>
            <div class="box-section">
              <h6>Sondes sélectionnées : </h6>
              <div id="selected-sonde">
                Aucune sonde sélectionnée.
              </div>
            </div>
            <hr>
            <?php
              $day = date('w');
              $week_start = date('d/m/Y', strtotime('-'.($day - 1).' days'));
              $week_end = date('d/m/Y', strtotime('+'.(7-$day).' days'));
            ?>
            <div class="box-section">
              <form action="index.php" id="generate-graph-form" method="POST">
                <h6>Afficher sur une période de :</h6>
                <div class="row input-daterange" id="datepicker">
                  <div class="one-half column">
                    <label for="dateDebut">Date de début</label>
                    <input class="u-full-width input-sm" value="<?php echo $week_start; ?>" type="text" id="dateDebut" name="dateDebut" size="18" name="start" >
                  </div>
                  <div class="one-half column">
                    <label for="dateFin">Date de fin</label>
                    <input class="u-full-width input-sm" value="<?php echo $week_end; ?>" type="text" id="dateFin" name="dateFin" size="18" name="end" >
                  </div>
                </div>
                <div class="row">
                  <div class="twelve columns">
                    <input class="button-primary u-full-width" type="submit" name="generer" value="Génerer" id="sendFormButton">  
                  </div>
                </div>
              </form>
            </div>
          </div>
        </section>

        <section>
          <h5 class="section-header" id="chartsection">Graphique des températures</h5>
          <div class="box">
            <div class="box-section">
              <div id="chart"></div>
              <h6 id="no-selection" style="display: none;">Aucun capteur sélectionné</h6>
            </div>
          </div>
        </section>

        <section>
          <h5 class="section-header">Statistiques</h5>
          <div class="box">
            <div class="box-section">
              <table id="statTable" class="sortable sortable-theme-bootstrap u-full-width" data-sortable>
                <thead data-header="true">
                  <tr>
                    <th data-sort-column="true">Sonde</th>
                    <th data-sort-column="true">min</th>
                    <th data-sort-column="true">max</th>
                    <th data-sort-column="true">moy</th>
                    <th data-sort-column="true">ecart-type</th>
                  </tr>
                </thead>
                <tbody data-body="true" id="tabStat">
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </div>
    </div>
    <div class="push"></div>
    <?php include('includes/layout/footer.php'); ?>
    <?php include("includes/scripts/graph.php"); ?>
    <script>

      $(document).ready(function() {

        // $("#dateDebut").val(firstday.getDate() + '/' + (firstday.getMonth() + 1) + '/' +  firstday.getFullYear());
        // $("#dateFin").val(lastday.getDate() + '/' + (lastday.getMonth() + 1) + '/' +  lastday.getFullYear());
      
        // listener du message de l'iframe
        if (window.addEventListener) {
          window.addEventListener('message', receiveMessage, false);
        } else if (window.attachEvent) { // pour IE8
          window.attachEvent('onmessage', receiveMessage);
        }

        $('#iframe').height($('#iframe').width() / ($(window).width() / $(window).height()));

        $("#sendFormButton").click(function(event) {
          event.preventDefault();
          $(this).blur();
          changeExtremes(0, false);
          scrollToAnchor(chartsection);
          return false;
        });

        $('.switcher-wraper .switcher').click(function(event) {
          if ($(this).hasClass('active')) {
            return;
          }
          $('.switcher-wraper .switcher.active').removeClass('active');
          $(this).addClass('active');
          
          var source = $('#iframe').attr('src');
          $("input[name='capteursId[]']").each(function(index) {
            removeSerie($(this).attr('sonde-name'));
            removeCaptTab($(this).val());

            // on supprimer les elt qui ont l'attribut sonde-id égal à l'id du message
            $('#selected-sonde > span[sonde-id="'+$(this).val()+'"]').remove();
            $(this).remove();
            // si le div est vide, on remet le texte "Aucune sonde sélectionnée."
            if( !$.trim( $("#selected-sonde").html() ).length ){
              $("#selected-sonde").append('Aucune sonde sélectionnée.');
            }
          });
          for(var key in graphColors) {
            for(color in graphColors[key]) {
              graphColors[key][color] = -1;
            }
          }
          if (source == "includes/layout/vue3D.php") {
            $('#iframe').attr('src','includes/layout/vue3D-2.php');
          } else {
            $('#iframe').attr('src','includes/layout/vue3D.php'); 
          }
        });
        
        $('.sortable').sortable();

        refreshTab();

      });

      $('#datepicker').datepicker({
        format: "dd/mm/yyyy",
        weekStart: 1,
        todayBtn: "linked",
        language: "fr"
      }).on("changeDate", function(e){
          if($(e.target).is("#dateDebut")) {
            changeExtremes(e.date, true);
          } else {
            changeExtremes(e.date, false);
          }
        });

      var curr = new Date;
        var firstday = new Date(curr.setDate(curr.getDate() - curr.getDay() + 1));
        var lastday = new Date(curr.setDate(curr.getDate() - curr.getDay() + 7));

        console.log(firstday.getDate() + '/' + (firstday.getMonth() + 1) + '/' +  firstday.getFullYear());
        console.log(lastday.getDate() + '/' + (lastday.getMonth() + 1) + '/' +  lastday.getFullYear());
      $('#datepicker').datepicker('setUTCDate', firstday);

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

      var graphColors = {
                        "1" : {
                          "#BFBFBF" : -1,
                          "#ABB7B7" : -1,
                          "#DADFE1" : -1,
                          "#95A5A6" : -1,
                          "#BDC3C7" : -1
                        },
                        "2" : {
                          "#EB9532" : -1,
                          "#E67E22" : -1,
                          "#F27935" : -1,
                          "#F9BF3B" : -1,
                          "#F9690E" : -1,
                          "#F39C12" : -1,
                          "#EB974E" : -1
                        },
                        "3" : {
                          "#4B77BE" : -1,
                          "#1F3A93" : -1,
                          "#3A539B" : -1
                        },
                        "4" : {
                          "#BFBFBF" : -1,
                          "#ABB7B7" : -1,
                          "#DADFE1" : -1,
                          "#95A5A6" : -1,
                          "#BDC3C7" : -1
                        },
                        "5" : {
                          "#F7CA18" : -1,
                          "#F5AB35" : -1,
                          "#F4B350" : -1,
                          "#FFD700" : -1
                        },
                        "6" : {
                          "#E74C3C" : -1,
                          "#D91E18" : -1,
                          "#E26A6A" : -1,
                          "#C0392B" : -1,
                          "#EF4836" : -1,
                          "#96281B" : -1
                        },
                        "7" : {
                          "#3FC380" : -1,
                          "#2ABB9B" : -1,
                          "#16A085" : -1
                        },
                        "8" : {
                          "#59ABE3" : -1,
                          "#89C4F4" : -1,
                          "#52B3D9" : -1,
                          "#3498DB" : -1,
                          "#19B5FE" : -1,
                          "#1E8BC3" : -1
                        },
                        "9" : {
                          "#9B59B6" : -1,
                          "#9A12B3" : -1,
                          "#BF55EC" : -1
                        },
                        "12" : {
                          "#86E2D5" : -1,
                          "#C8F7C5" : -1,
                          "#1BBC9B" : -1
                        },
                        "16" : {
                          "#FF4500" : -1,
                          "#FF8C00" : -1,
                          "#F4A460" : -1,
                          "#F9690E" : -1,
                          "#E87E04" : -1,
                          "#D35400" : -1,
                          "#E67E22" : -1,
                          "#EB9532" : -1
                        },
                        "15" : {
                          "#87CEEB" : -1,
                          "#00BFFF" : -1,
                          "#1E90FF" : -1,
                          "#0000FF" : -1,
                          "#00008B" : -1,
                          "#4169E1" : -1,
                          "#6495ED" : -1,
                          "#2574A9" : -1
                        }
    }

      // fonction appelée lors de la reception d'un message de l'iframe
      function receiveMessage(event) {
        // match un message de la forme "fonction:nom,id"
        var match = event.data.match("(^[a-z]*):([^,]+),([^,]+),(.+)");
        if (match[1]=="selected") {
          // si le div contient le texte "Aucune sonde sélectionnée.", on le vide
          if ($('#selected-sonde:contains("Aucune sonde sélectionnée.")').length > 0) {
            $("#selected-sonde").empty();
          }
          var couleur;
          for(var key in graphColors[match[4]]) {
            if(graphColors[match[4]][key] == -1) {
              couleur = key;
              graphColors[match[4]][key] = match[3];
              break;
            }
          }
          // on ajoute le span de la sonde selectionnée, et le champ caché au formulaire
          $("#selected-sonde").append('<span class="sonde-selected" sonde-id="'+match[3]+'"><span> - </span><span class="sonde-color" style="background-color: ' + couleur + ';"></span> '+match[2]+'</span>\n')
          $("#generate-graph-form").append('<input type="hidden" name="capteursId[]" sonde-name="'+ match[2] + '" value="' + match[3] + '" sonde-color="' + couleur + '">');
          addSerie(match[3],match[2], couleur);
        } else if (match[1]=="deleted") {
          removeSerie(match[2]);
          removeCaptTab(match[3]);

          // on remet la couleur à inutilisée
          var couleur = $('#generate-graph-form > input[type="hidden"][value="'+match[3]+'"]').attr('sonde-color');
          graphColors[match[4]][couleur] = -1;

          // on supprimer les elt qui ont l'attribut sonde-id égal à l'id du message
          $('#selected-sonde > span[sonde-id="'+match[3]+'"]').remove();
          $('#generate-graph-form > input[type="hidden"][value="'+match[3]+'"]').remove();
          // si le div est vide, on remet le texte "Aucune sonde sélectionnée."
          if( !$.trim( $("#selected-sonde").html() ).length ){
            $("#selected-sonde").append('Aucune sonde sélectionnée.');
          }
        }
        // si le premier elt contient un " - ", il faut le supprimer
        if ($("#selected-sonde > span:first-child > span:first-child").text() == " - ") {
          $("#selected-sonde > span:first-child > span:first-child").remove();
        }
      }

      function resetIframe() {
        $("#iframe")[0].contentWindow.reset();
      }

      function zoomIframe(){
        $("#iframe")[0].contentWindow.zoomPlus();
      }

      function dezoomIframe(){
        $("#iframe")[0].contentWindow.zoomMoins();
      } 
      
    </script>
  </body>
</html>
