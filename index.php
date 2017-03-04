<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Test Your Code</title>
	<script src="js/Jquery/jquery-3.1.1.js"></script>
  	<script src="js/Jquery/jquery-ui-1.12.1/jquery-ui.js"></script>
 	<link rel="stylesheet" href="css/jquery-ui.css"/>
 	<link rel="stylesheet" href="css/style.css"/>
</head> 
	<?php
		header( 'content-type: text/html; charset=utf-8');
		define('__ROOT__',dirname(__FILE__));
		require_once(__ROOT__.'/utils/links.php');
	?>
<body>
	<?php
		$listeProjets = $DAO->getAllProjets();
		$index = 0;
	?>
	<!--  		 				MENU								-->
	<div id="maPage" class="mainPage">
		<p><a href="vues/gererProjet.php">Gérer les projets</a></p>
		<h1>Sélectionnez votre projet</h1>
		<form id="formulaireRedirectProjet" method="post" action="vues/pageBacklog.php">
			<table id="tableauLargeSize" class="tableauProjet">
				<?php
					foreach($listeProjets as $projet){
						if($index % 4 == 0){
							echo "<tr>";
						}
							echo "<td>";
								echo "<span><div class='clickable' onclick='javascript:changeProjet(\"".$projet->getId()."\")' style='width : 100px; height : 100px; border:solid black 1px; margin:auto;'>Image</div></span>";
								echo "<span class='clickable' onclick='javascript:changeProjet(\"".$projet->getId()."\")'>".$projet->getNom()."</span>";
							echo "</td>";
						if($index % 4 == 3 || $index == sizeof($listeProjets)-1){
							echo "</tr>";
						}
						$index++;
					}
				?> 
			</table>

			<table id="tableauMediumSize" class="tableauProjet">
				<?php
					$index = 0;
					foreach($listeProjets as $projet){
						if($index % 2 == 0){
							echo "<tr>";
						}
							echo "<td>";
								echo "<span><div class='clickable' onclick='javascript:changeProjet(\"".$projet->getId()."\")' style='width : 100px; height : 100px; border:solid black 1px; margin:auto;'>Image</div></span>";
								echo "<span class='clickable' onclick='javascript:changeProjet(\"".$projet->getId()."\")'>".$projet->getNom()."</span>";
							echo "</td>";
						if($index % 2 == 1 || $index == sizeof($listeProjets)-1){
							echo "</tr>";
						}
						$index++;
					}
				?> 
			</table>

			<table id="tableauLittleSize" class="tableauProjet">
				<?php
					$index = 0;
					foreach($listeProjets as $projet){
						echo "<tr>";
							echo "<td>";
								echo "<span><div class='clickable' onclick='javascript:changeProjet(\"".$projet->getId()."\")' style='width : 100px; height : 100px; border:solid black 1px; margin:auto;'>Image</div></span>";
								echo "<span class='clickable' onclick='javascript:changeProjet(\"".$projet->getId()."\")'>".$projet->getNom()."</span>";
							echo "</td>";
						echo "</tr>";
						$index++;
					}
				?> 
			</table>
			<input type="hidden" name="project"/>
		</form>
	</div>
</body>
</html>
<script>
	function changeProjet(index){
		document.getElementsByName('project')[0].value = index;
		document.getElementById('formulaireRedirectProjet').submit();
	}
</script>!