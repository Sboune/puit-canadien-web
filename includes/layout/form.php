<form action= "graph.php" method="GET">

	<br />
	<br />

	Liste des sondes sélectionnées : 
	<br />
	<br />
	
	<div id="baseSondes"></div> <!-- div qui contiendra la liste des sondes selectionnées -->
	
	<br />
	<br />
	
	<script src="assets/vendor/jquery/jquery-1.9.1.js"></script>
	<script src="assets/vendor/jquery/jquery-ui.js"></script>
	<label>Date de début</label><br/>
	<script>
		$(function() {
			$( "#datepicker" ).datepicker();
		});
	</script>
	<input type="text" name="datedeb" id="datepicker"/>

	<br />
	<br />

	<label>Date de fin</label><br/>
	<br />
	<script>
		$(function() {
			$( "#datepicker2" ).datepicker();
		});
	</script>
	<input type="text" name="datefin" id="datepicker2"/>
	<br />
	<br />

   <input type ="hidden" value="" id="Sondes" name="Sondes" value="ok"/>


	<input type="submit" value="Generer graphe"/>	 

</form>
<div id="test" name="test">

</div>
