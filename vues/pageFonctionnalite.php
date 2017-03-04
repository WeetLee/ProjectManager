<!DOCTYPE html>
<html>
<?php
	define('__ROOT__',dirname(dirname(__FILE__)));
  	require_once(__ROOT__.'/utils/links.php');
	if(isset($_POST['project'])){
		$id = $_POST['project'];
	}else{
		header("Location:../index.php");
	}
	$monProjet = $DAO->getProjetById($id);
	if(isset($_POST['fonctionnalite'])){
		$currentFonction = $_POST['fonctionnalite'];
	}else{
		$currentFonction = "default";
	}

	if($currentFonction == "default"){
		$listeFonctionnalites = $monProjet->getSousFonctionnalites();
	}else{
		$maFonctionnalite = $DAO->getFonctionnaliteById($currentFonction);
		$listeFonctionnalites = $maFonctionnalite->getSousFonctionnalites();
		$fil = $maFonctionnalite->getFilAriane();
	}	
	?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $monProjet->getNom(); ?></title>
	<script src="../js/jquery-3.1.1.js"></script>
  	<script src="../js/jquery-ui-1.12.1/jquery-ui.js"></script>
  	<script src="../js/gaugeMeter.js"></script>
 	<link rel="stylesheet" href="../css/jquery-ui.css"/>
 	<link rel="stylesheet" href="../css/style.css"/>
</head> 
<body>
<p>
	<form method='POST' action='#' id='submitFonctionnalite'>
		<input type="hidden" name="project" value="<?php echo $id; ?>"/>
		<input type="hidden" name="fonctionnalite" value="default"/>
	<a class="linkAriane btn" href="../index.php">Projets</a> 
	<?php 
	 	if($currentFonction != "default"){
			echo ' > <span class="clickable linkAriane btn" onclick="javascript:changerPage(\'default\')">'.$monProjet->getNom().'</span>'; 
			$tailleFil = sizeof($fil);
			$index = 0;
			while($index < $tailleFil-1){
				echo ' > <span class="clickable linkAriane btn" onclick="javascript:changerPage('.$fil[$index][0].')">'.$fil[$index][1].'</span>'; 	
				$index++;
			}
			echo ' > <span class="lastFonctionnality">'.$fil[$tailleFil-1][1].'</span>';
		}else
			echo ' > <span class="lastFonctionnality">'.$monProjet->getNom().'</span>'; 
	?>
	</form>
</p>
<div class="mainPage">
	<form id="changerVue" method="post" action="pageBacklog.php">
		<input type="hidden" name="project" value="<?php echo $id; ?>"/>
		<p onclick="javascript:changerStatut();" class="clickable">Afficher le backlog</p>
	</form>
	<h1>
		<?php 
			if($currentFonction != "default")
				echo $maFonctionnalite->getNom();
			else
				echo $monProjet->getNom();
		?>
	</h1><hr/>
	<h2>Fonctionnalités</h2>
	<form action="#" method="post" id="navigateFonctionnalite">
		<input type='hidden' name='project' value="<?php echo $id; ?>"/>
		<input type="hidden" name="fonctionnalite" value="default"/>

		<table id="tableauLargeSize" class="tableauProjet tableauFonctionnalite">
			<?php
				$index = 0;
				foreach($listeFonctionnalites as $sousFonctionnalite){
					if($index % 4 == 0){
						echo "<tr>";
					}
						echo "<td class='clickable'>";
							?>
								<div class="gaugeMeter clickable" onclick='javascript:changeProjet(<?php echo $sousFonctionnalite->getId(); ?>)' id="PreviewGaugeMeter_<?php echo $sousFonctionnalite->getId(); ?>" data-percent="50" data-append="%" data-size="180" data-theme="Red-Gold-Green" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="" data-label_color="#FFF" data-stripe="2"></div>
							<?php
							echo "<br/><span onclick='javascript:changeProjet(\"".$sousFonctionnalite->getId()."\")'>".$sousFonctionnalite->getNom()."</span>";
						echo "</td>";
					if($index % 4 == 3 || $index == sizeof($listeFonctionnalites)-1){
						echo "</tr>";
					}
					$index++;
				}
			?> 
		</table>

		<table id="tableauMediumSize" class="tableauProjet tableauFonctionnalite">
			<?php
				$index = 0;
				foreach($listeFonctionnalites as $projet){
					if($index % 2 == 0){
						echo "<tr>";
					}
						echo "<td class='clickable'>";
							?>
								<div class="gaugeMeter clickable" onclick='javascript:changeProjet(<?php echo $sousFonctionnalite->getId(); ?>)' id="PreviewGaugeMeter_<?php echo $sousFonctionnalite->getId(); ?>" data-percent="50" data-append="%" data-size="180" data-theme="Red-Gold-Green" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="" data-label_color="#FFF" data-stripe="2"></div>
							<?php
							echo "<br/><span onclick='javascript:changeProjet(\"".$sousFonctionnalite->getId()."\")'>".$sousFonctionnalite->getNom()."</span>";
						echo "</td>";
					if($index % 2 == 1 || $index == sizeof($listeFonctionnalites)-1){
						echo "</tr>";
					}
					$index++;
				}
			?> 
		</table>

		<table id="tableauLittleSize" class="tableauProjet tableauFonctionnalite">
			<?php
				$index = 0;
				foreach($listeFonctionnalites as $projet){
					echo "<tr>";
						echo "<td class='clickable'>";
							?>
								<div class="gaugeMeter clickable" onclick='javascript:changeProjet(<?php echo $sousFonctionnalite->getId(); ?>)' id="PreviewGaugeMeter_<?php echo $sousFonctionnalite->getId(); ?>" data-percent="50" data-append="%" data-size="180" data-theme="Red-Gold-Green" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="" data-label_color="#FFF" data-stripe="2"></div>
							<?php
							echo "<br/><span onclick='javascript:changeProjet(\"".$sousFonctionnalite->getId()."\")'>".$sousFonctionnalite->getNom()."</span>";
						echo "</td>";
					echo "</tr>";
					$index++;
				}
			?> 
		</table>
	</form>
	
	
</div>
</body>
</html>

<script>
	$(".gaugeMeter").gaugeMeter();
	function changeProjet(index){
		document.getElementsByName('fonctionnalite')[1].value=index;
		$("#navigateFonctionnalite").submit();
	}
	function changerStatut(){
		$("#changerVue").submit();
	}
	function changerPage(index){
		document.getElementsByName('fonctionnalite')[0].value=index;
		$("#submitFonctionnalite").submit();
	}
</script>