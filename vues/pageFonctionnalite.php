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
		$completion = $maFonctionnalite->getCompletion();
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
	<form id="refreshPage" method="POST" action="#"> 
		<input type="hidden" id="projetId" name="project" value="<?php echo $id;?>"/>
		<input type="hidden" id="fonctionnaliteId" name="fonctionnalite" value="<?php echo $currentFonction;?>"/>
	</form>
	<form method='POST' action='#' id='submitFonctionnalite'>
		<input type="hidden" name="project" value="<?php echo $id; ?>"/>
		<input type="hidden" id="changeFonctionnality" name="fonctionnalite" value="default"/>
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
				echo $maFonctionnalite->getNom().' - '.$completion.'%';
			else
				echo $monProjet->getNom();
		?>
	</h1><hr/>
	<h2>Fonctionnalités</h2>
	<form action="#" method="post" id="navigateFonctionnalite">
		<input type='hidden' name='project' value="<?php echo $id; ?>"/>
		<input type="hidden" id="navigateFonctionnality" name="fonctionnalite" value="default"/>

		<table id="tableauLargeSize" class="tableauProjet tableauFonctionnalite">
			<?php
				$index = 0;
				foreach($listeFonctionnalites as $sousFonctionnalite){
					if($index % 4 == 0){
						echo "<tr>";
					}
						echo "<td class='clickable'>";
							?>
								<div class="gaugeMeter clickable" onclick='javascript:changeProjet(<?php echo $sousFonctionnalite->getId(); ?>)' id="PreviewGaugeMeter_<?php echo $sousFonctionnalite->getId(); ?>" data-percent="<?php echo $sousFonctionnalite->getCompletion(); ?>" data-append="%" data-size="180" data-theme="Red-Gold-Green" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="" data-label_color="#FFF" data-stripe="2"></div>
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
								<div class="gaugeMeter clickable" onclick='javascript:changeProjet(<?php echo $sousFonctionnalite->getId(); ?>)' id="PreviewGaugeMeter_<?php echo $sousFonctionnalite->getId(); ?>" data-percent="<?php echo $sousFonctionnalite->getCompletion(); ?>" data-append="%" data-size="180" data-theme="Red-Gold-Green" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="" data-label_color="#FFF" data-stripe="2"></div>
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
								<div class="gaugeMeter clickable" onclick='javascript:changeProjet(<?php echo $sousFonctionnalite->getId(); ?>)' id="PreviewGaugeMeter_<?php echo $sousFonctionnalite->getId(); ?>" data-percent="<?php echo $sousFonctionnalite->getCompletion(); ?>" data-append="%" data-size="180" data-theme="Red-Gold-Green" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="" data-label_color="#FFF" data-stripe="2"></div>
							<?php
							echo "<br/><span onclick='javascript:changeProjet(\"".$sousFonctionnalite->getId()."\")'>".$sousFonctionnalite->getNom()."</span>";
						echo "</td>";
					echo "</tr>";
					$index++;
				}
			?> 
		</table>
	</form>
	<br/>
	<?php 
		if($currentFonction != "default"){
	?>
	<div class="backlogDiv">
		<table class="tableauTache">
			<tr>
				<td style="vertical-align:top;" id="affichageTaches">
					
				</td>
				<td style="vertical-align:top;">
					<h1>Tests</h1><hr/>
				</td>
			</tr>
		</table>
		
	</div>	
	<?php
		}
	?>
	
</div>
</body>
</html>

<script>
	$(function(){
		refreshTaches();
	});

	function refreshTaches(){
		$.ajax({
			url:"../moteurs/afficherTachesDansFonctionnalite.php",
			dataType:"text",
			method:"POST",
			data:{"idProjet":document.getElementById('projetId').value, "idFonctionnalite":$('#fonctionnaliteId').val()},
			success:function(data){
				$("#affichageTaches").html(data);	
				$( ".statut" ).selectmenu({
					change:function(event,ui){
						$.ajax({
							url:"../moteurs/updateStatutTache.php",
							dataType:"text",
							method:"POST",
							data:{idTache:this.name, statut:ui.item.value, idFonctionnalite:$("#fonctionnaliteId").val()},
							success:function(data){
								$("#refreshPage").submit();							
							}
						})
					}
				});
				refreshColor();				
			}
		})
	}
	$(".gaugeMeter").gaugeMeter();
	  
	function changeProjet(index){
		document.getElementById('navigateFonctionnality').value=index;
		$("#navigateFonctionnalite").submit();
	}
	function changerStatut(){	
		$("#changerVue").submit();
	}
	function changerPage(index){
		document.getElementById('changeFonctionnality').value=index;
		$("#submitFonctionnalite").submit();
	}
	
	function refreshColor(){
		var index = 1;
		if($("#nombreTaches").val()){
			var nombreMax = $("#nombreTaches").val();
			while(index <= nombreMax){
				var valueAvancement = document.getElementById("avancement_"+(index-1)).value;
				if(valueAvancement == "A analyser"){
					$( "#ui-id-"+index+"-button" ).addClass( "aAnalyser");
					$( "#ui-id-"+index+"-button" ).removeClass("aFaire enCours aTester termine");
				}else if(valueAvancement == "A faire"){
					$( "#ui-id-"+index+"-button" ).addClass( "aFaire");
					$( "#ui-id-"+index+"-button" ).removeClass("aAnalyser enCours aTester termine");
				}else if(valueAvancement == "En cours"){
					$( "#ui-id-"+index+"-button" ).addClass( "enCours");
					$( "#ui-id-"+index+"-button" ).removeClass("aAnalyser aFaire aTester termine");
				}else if(valueAvancement == "A tester"){
					$( "#ui-id-"+index+"-button" ).addClass( "aTester");
					$( "#ui-id-"+index+"-button" ).removeClass("aAnalyser aFaire enCours termine");
				}else if(valueAvancement == "Terminé"){
					$( "#ui-id-"+index+"-button" ).addClass( "termine");
					$( "#ui-id-"+index+"-button" ).removeClass("aAnalyser aFaire enCours aTester");
				}
				index++;
			}
		}
	}
</script>