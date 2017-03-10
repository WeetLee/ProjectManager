<?php 
	define('__ROOT__',dirname(dirname(__FILE__)));
	require_once(__ROOT__.'/utils/links.php');
	$idProjet = $_POST['idProjet'];
	$idFonctionnalite = $_POST['idFonctionnalite'];
	if($idFonctionnalite == "default"){
		exit;
	}else{
		$maFonctionnalite = $DAO->getFonctionnaliteById($idFonctionnalite);
	}	
	$taches = $maFonctionnalite->getTaches();  
	$completionTaches = $maFonctionnalite->getCompletionTaches();
?>
<input type="hidden" id="completionTaches" value=""/>
<input type="hidden" id="nombreTaches" value="<?php echo sizeof($taches); ?>"/>

<h1>Tâches - <span id="affichageCompletionTache"><?php echo round($completionTaches);?></span>%</h1><hr/>
<table>
	<tr>
		<th>Nom</th>
		<th>Statut</th>
		<th>Durée</th>
		<th>Affectation</th>
	</tr>
	<?php 
		$index = 0;
		foreach($taches as $uneTache){
			echo "<tr>";
				echo "<td>".$uneTache->getNom()."</td>";
				echo "<td>";
					echo "<input type='hidden' id='avancement_".$index."' value='".$uneTache->getAvancement()."'/>";
					echo "<select name='tache_".$uneTache->getId()."_".$index."' class='statut'>";
						if($uneTache->getAvancement() == "A analyser")
							echo "<option class='aAnalyser' value='A analyser' selected>A analyser</span></option>";
						else 
							echo "<option class='aAnalyser' value='A analyser'>A analyser</option>";
						if($uneTache->getAvancement() == "A faire")
							echo "<option value='A faire' selected>A faire</option>";
						else
							echo "<option value='A faire'>A faire</option>";
						if($uneTache->getAvancement() == "En cours")
							echo "<option name='enCours' value='En cours' selected>En cours</option>";
						else
							echo "<option class='enCours' value='En cours'>En cours</option>";
						if($uneTache->getAvancement() == "A tester")
							echo "<option value='A tester' selected>A tester</option>";
						else
							echo "<option value='A tester'>A tester</option>";
						if($uneTache->getAvancement() == "Terminé")
							echo "<option value='Terminé' selected>Terminé</option>";
						else	
							echo "<option value='Terminé'>Terminé</option>";										
					echo "</select>";
				echo "</td>";
				echo "<td id='duree_".$uneTache->getId()."' class='modifierDureePrevi'>".$uneTache->getDureePrevisionnelle()." h</td>";
				echo "<td>".$uneTache->getAffectation()->getNom()."</td>";
			echo "</tr>";

			$index++;
		}
	?>
		<form id="ajoutTache">
			<tr>
				<td><input type="text" placeholder="Nom" id="ajoutNomTache" name="ajoutNomTache" required/></td>
				<td>
					<select id="ajoutStatutTache" name="ajoutStatutTache" disabled>
						<option class="ui-selectmenu-button ui-button" value="A analyser"><span class="aAnalyser">A analyser</span></option>
					</select>
				</td>
				<td><input type="text" style="width : 30px;" id="ajoutDureeTache" name="ajoutDureeTache" required/> h</td>
				<td>
					<select id="ajoutAffectationTache" name="ajoutAffectationTache">
							<option value="">---</option>
						<?php
							$tousLesUtilisateurs = $DAO->getUtilisateursByProjectId($idProjet);
							foreach($tousLesUtilisateurs as $user){
								echo "<option value='".$user->getId()."'>".$user->getNom()."</option>";
							}
						 ?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<input class="boutonAjout" onclick="javascript:ajouterTacheFonctionnalite()" type='button' value="Créer une tache"/>
				</td>
			</tr>
		</form>
</table>
<div id="dialog" title="Erreur">
</div>
<div id="dialogChgtDuree" title="Changer la durée">
</div>
<div id="myTextDuree" style="display:none">
	<input type="hidden" name="dureeModifTacheId" id="dureeModifTacheId"/>
  	<label for='dureeModif'>Durée :</label>
  	<input type='text' class="clickable" name='dureeModif' id='dureeModif' value=''><br/>
  	<input class="boutonAjout" type='button' value="Modifier" onclick="javascript:updateDuree();" style="margin-top : 10px; margin-left : 25px;">
</div>
<script>
	function ajouterTacheFonctionnalite(){
		var message = "";
		if($("#ajoutNomTache").val())
			var nomTache = $("#ajoutNomTache").val();
		else		
			message+="Erreur : le nom n'est pas renseigné.\n";
		var statutTache = $("#ajoutStatutTache").val();
		if($("#ajoutDureeTache").val())
			var dureeTache = $("#ajoutDureeTache").val();
		else
			message+="Erreur : la durée n'est pas renseignée.";
		var affectationTache = $("#ajoutAffectationTache").val();
		if(message != ""){
			$("#dialog").html(message);
			$( "#dialog" ).dialog();	
		}else{
			var idFonctionnalite = $("#fonctionnaliteId").val();
			$.ajax({
				url:"../moteurs/addTache.php",
				dataType:"text",
				method:"POST",
				data:{idFonctionnalite:idFonctionnalite, nomTache:nomTache,statutTache:statutTache,affectationTache:affectationTache,dureeTache:dureeTache},
				success:function(data){
					$("#refreshPage").submit();						
				}
			})		
		}
	}

	$(function() {
	    var divDuree = $( ".modifierDureePrevi" );
		$(divDuree).dblclick(function(event) {    
			var contenuTd = $("#"+this.id).html();
			var splitTable = contenuTd.split(" ");
			var nomTd = this.id;
			var splitNom = nomTd.split("_");
			var mytext = $('#myTextDuree').html();
		    $('#dialogChgtDuree').html(mytext);    
	        $("#dialogChgtDuree").dialog({                   
	            width: 200,
	            modal: true
	        });
	        document.getElementsByName("dureeModif")[0].value = splitTable[0];  
		    document.getElementsByName("dureeModifTacheId")[0].value = splitNom[1]; 
	        document.getElementsByName("dureeModif")[1].value = splitTable[0];  
		    document.getElementsByName("dureeModifTacheId")[1].value = splitNom[1]; 
	    }); //close click
	});

	function updateDuree(){
		var idTache = document.getElementsByName("dureeModifTacheId")[1].value; 
		var nouvelleDuree = document.getElementsByName("dureeModif")[1].value;
		var idFonctionnalite = $("#fonctionnaliteId").val();
		$.ajax({
			url:"../moteurs/updateDureeTache.php",
			method:"POST",
			data:{idFonctionnalite:idFonctionnalite, idTache:idTache,nouvelleDuree:nouvelleDuree},
			success:function(data){
				$("#refreshPage").submit();						
			}
		})
	}
</script>
