<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Test Your Code</title>
	<script src="js/jquery-3.1.1.js"></script>
  	<script src="js/jquery-ui-1.12.1/jquery-ui.js"></script>
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
		<h1>Sélectionnez votre projet</h1>
		<form id="formulaireRedirectProjet" method="post" action="vues/pageBacklog.php">
			<table id="tableauLargeSize" class="tableauProjet">
				<?php
					foreach($listeProjets as $projet){
						if($index % 4 == 0){
							echo "<tr>";
						}
							echo "<td>";
								echo "<span><div class='clickable' onclick='javascript:changeProjet(\"".$projet->getId()."\")' style='width : 100px; height : 100px; margin:auto;'><img style='max-width:100%; max-height:100%;' src='img/projets/".$projet->getImage()."'/></div></span>";
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
								echo "<span><div class='clickable' onclick='javascript:changeProjet(\"".$projet->getId()."\")' style='width : 100px; height : 100px;  margin:auto;'><img style='max-width:100%; max-height:100%;' src='img/projets/".$projet->getImage()."'/></div></span>";
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
								echo "<span><div class='clickable' onclick='javascript:changeProjet(\"".$projet->getId()."\")' style='width : 100px; height : 100px; margin:auto;'><img style='max-width:100%; max-height:100%;' src='img/projets/".$projet->getImage()."'/></div></span>";
								echo "<span class='clickable' onclick='javascript:changeProjet(\"".$projet->getId()."\")'>".$projet->getNom()."</span>";
							echo "</td>";
						echo "</tr>";
						$index++;
					}
				?> 
			</table>
			<input type="hidden" name="project"/>
		</form>
		<form id="ajouterProjet" style="width : 500px; margin:auto; text-align:center;" enctype="multipart/form-data" method="POST" action="moteurs/addProjet.php">
			<fieldset>
				<legend>Nouveau projet</legend>
				<table style="width:100%;">
					<tr>
						<td style="text-align:right;">Nom :</td>
						<td style="text-align:left;"><input type="text" name="nomProjet"/></td>
					</tr>
					<tr>
						<td style="text-align:right;">Image : </td>
						<td style="text-align:left;"><input type="file" name="imageProjet" accept="image/*"></td>
					</tr>
				</table>
				<input class="boutonAjout" type='submit' value="Créer un projet"/>
			</fieldset>
		</form>
	</div>
</body>
</html>
<script>
function changeProjet(index){
	document.getElementsByName('project')[0].value = index;
	document.getElementById('formulaireRedirectProjet').submit();
}
</script>