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
			echo ' > <span class="clickable btn" onclick="javascript:changerPage(\'default\')">'.$monProjet->getNom().'</span>'; 
			$tailleFil = sizeof($fil);
			$index = 0;
			while($index < $tailleFil-1){
				echo ' > <span class="clickable btn" onclick="javascript:changerPage('.$fil[$index][0].')">'.$fil[$index][1].'</span>'; 	
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
		
		<div style="width:100%; text-align:left;">
		<?php
			foreach($listeFonctionnalites as $sousFonctionnalite){
				echo "<div class='panelFonctionnalite'>";
						?>
							<table style="width:100%;">
								<tr>
									<td colspan="2" style='text-align:center;'><?php echo "<span>".$sousFonctionnalite->getNom()."</span>"; ?><hr/></td>
								</tr>
								<tr>
									<td>
										<div class="gaugeMeter"  id="PreviewGaugeMeter_<?php echo $sousFonctionnalite->getId(); ?>" data-percent="<?php echo $sousFonctionnalite->getCompletion(); ?>" data-append="%" data-size="180" data-theme="Red-Gold-Green" data-back="RGBa(0,0,0,.1)" data-animate_gauge_colors="1" data-animate_text_colors="1" data-width="15" data-label="" data-label_color="#FFF" data-stripe="2"></div>
									</td>
									<td class="justifyTd">
										<?php 
											echo "<span style='font-size:13px;'>".$sousFonctionnalite->getCommentaire()."</span>"; 
										?>
										<hr/>
										<img class="avatar" title="<?php echo $sousFonctionnalite->getAffectation(); ?>" src="../img/collab/<?php echo $sousFonctionnalite->getAffectation();?>.png" alt="<?php echo $sousFonctionnalite->getAffectation();?>.png" />
									</td>
								</tr>
							</table>
							<div style="position:relative; right : 5px; text-align:right;">
								<img class="clickable" style="width : 30px;" src="../img/consulter.png" title='Consulter la fonctionnalité' onclick='javascript:changeProjet(<?php echo $sousFonctionnalite->getId(); ?>)'/>
							</div>
						<?php
				echo "</div>";
			}
		?> 
		</div>
	</form>
	<form id="ajoutFonctionnalite">
		<table style="margin:auto;">
			<tr>
				<th>Nom</th>
				<th>Priorité</th>
				<th>Affectation</th>
			</tr>
			<tr>
				<td><input type="text" placeholder="Nom" id="ajoutNomFonctionnalite" name="ajoutNomFonctionnalite" required/></td>
				<td>
					<select id="ajoutPrioriteFonctionnalite" name="ajoutPrioriteFonctionnalite">
						<option class="ui-selectmenu-button ui-button" value="1">Prioritaire</option>
						<option class="ui-selectmenu-button ui-button" value="2">Important</option>
						<option class="ui-selectmenu-button ui-button" value="3" selected>Moyen</option>
						<option class="ui-selectmenu-button ui-button" value="4">Mineur</option>
					</select>
				</td>
				<td>
					<select id="ajoutAffectationFonctionnalite" name="ajoutAffectationFonctionnalite">
						<?php
							
							$tousLesUtilisateurs = $DAO->getUtilisateursByProjectId($id);
							foreach($tousLesUtilisateurs as $user){
								echo "<option value='".$user->getId()."'>".$user->getNom()."</option>";
							}
						 ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<input class="boutonAjout" onclick="javascript:ajouterFonctionnalite()" type='button' value="Créer une fonctionnalité"/>
				</td>
			</tr>
		</table>
	</form>
	<br/>
	<?php 
		if($currentFonction != "default"){
	?>
	<div class="backlogDiv">
		<table class="tableauTache">
			<tr>
				<td style="vertical-align:top; border-right : solid grey 1px;" id="affichageTaches">
					
				</td>
				<td style="vertical-align:top; border-left : solid grey 1px;" id="affichageTests">
				
				</td>
			</tr>
		</table>
		
	</div>	
	<?php
		}
	?>
	<div id="dialog" title="Erreur"></div>
</div>
</body>
</html>

<script>
	$(function(){
		refreshTaches();
		refreshTests();
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
							url:"../moteurs/updateTache.php",
							dataType:"text",
							method:"POST",
							data:{idTache:this.name, nouveau:ui.item.value, idFonctionnalite:$("#fonctionnaliteId").val(), type:"Statut"},
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
	function refreshTests(){
		$.ajax({
			url:"../moteurs/afficherTestsDansFonctionnalite.php",
			dataType:"text",
			method:"POST",
			data:{"idProjet":document.getElementById('projetId').value, "idFonctionnalite":$('#fonctionnaliteId').val()},
			success:function(data){
				$("#affichageTests").html(data);			
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
	
	function ajouterFonctionnalite(){
		var message = "";
		if($("#ajoutNomFonctionnalite").val())
			var nomFonctionnalite = $("#ajoutNomFonctionnalite").val();
		else		
			message+="Erreur : le nom n'est pas renseigné.\n";
		if($("#ajoutAffectationFonctionnalite").val())
			var affectationFonctionnalite = $("#ajoutAffectationFonctionnalite").val();
		else		
			message+="Erreur : veuillez affecter une personne au projet.\n";

		var prioriteFonctionnalite = $("#ajoutPrioriteFonctionnalite").val();
		if(message != ""){
			$("#dialog").html(message);
			$("#dialog" ).dialog();	
		}else{
			var idFonctionnalite = $("#fonctionnaliteId").val();
			var idProjet = $("#projetId").val();
			$.ajax({
				url:"../moteurs/addFonctionnalite.php",
				dataType:"text",
				method:"POST",
				data:{idFonctionnalite:idFonctionnalite, idProjet:idProjet, nomFonctionnalite:nomFonctionnalite,affectationFonctionnalite:affectationFonctionnalite, prioriteFonctionnalite:prioriteFonctionnalite},
				success:function(data){
					$("#refreshPage").submit();						
				}
			})		
		}
	}
</script>