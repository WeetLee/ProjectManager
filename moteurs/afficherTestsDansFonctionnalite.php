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
	$tests = $maFonctionnalite->getTests();  
	$completionTests = $maFonctionnalite->getCompletionTests();
?>
<h1>Tests - <?php echo round($completionTests);?>%</h1><hr/>
<table>
	<tr>
		<th>Nom</th>
		<th>Statut</th>
		<th>Dernière exécution</th>
		<th>Tester</th>
	</tr>
	<?php 
		$index = 0;
		foreach($tests as $unTest){
			echo "<tr>";
				echo "<td class='modifierNomTest' id='nomTest_".$unTest->getId()."'>".$unTest->getNom()."</td>";
				echo "<td class='".$unTest->getStatut()."'>".$unTest->getStatut()."</td>";
				echo "<td>";
					$date = $unTest->getDateExec();
					if($date != ""){
						$formatFr = date("d/m/Y h:i:s", $date);
						echo $formatFr;
					}
				echo "</td>";
				echo "<td></td>";
			echo "</tr>";

			$index++;
		}
	?>
		<form id="ajoutTache">
			<tr>
				<td colspan="4">
					<input type="text" placeholder="Nom" id="ajoutNomTache" name="ajoutNomTache" required/>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<input class="boutonAjout" onclick="javascript:ajouterTacheFonctionnalite()" type='button' value="Créer un test"/>
				</td>
			</tr>
		</form>
</table>

<div id="dialogChgtNomTest" title="Changer le nom">
</div>

;<div id="myTextNomTest" style="display:none">
	<input type="hidden" name="nomModifTestId" id="nomModifTestId"/>
  	<label for='nomModifTest'>Nom :</label>
  	<input type='text' class="clickable" name='nomModifTest' id='nomModifTest' value=''><br/>
  	<input class="boutonAjout" type='button' value="Modifier" onclick="javascript:updateNomTest();" style="margin-top : 10px; margin-left : 25px;">
</div>
<script>
	/*function ajouterTacheFonctionnalite(){
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
		var typeTache =$("#ajoutTypeTache").val();
		if(message != ""){
			$("#dialog").html(message);
			$( "#dialog" ).dialog();	
		}else{
			var idFonctionnalite = $("#fonctionnaliteId").val();
			$.ajax({
				url:"../moteurs/addTache.php",
				dataType:"text",
				method:"POST",
				data:{idFonctionnalite:idFonctionnalite, nomTache:nomTache,statutTache:statutTache,affectationTache:affectationTache,dureeTache:dureeTache, typeTache:typeTache},
				success:function(data){
					$("#refreshPage").submit();						
				}
			})		
		}
	}
*/
	$(function() {
	    var divNom = $( ".modifierNomTest" );
		$(divNom).dblclick(function(event) {    
			var contenuTd = $("#"+this.id).html();
			var nomTd = this.id;
			var splitNom = nomTd.split("_");
			var mytext = $('#myTextNomTest').html();

		    $('#dialogChgtNomTest').html(mytext);    
	        $("#dialogChgtNomTest").dialog({                   
	            width: 500,
	            modal: true
	        });
	        document.getElementsByName("nomModifTest")[0].value = contenuTd;  
		    document.getElementsByName("nomModifTestId")[0].value = splitNom[1]; 
	        document.getElementsByName("nomModifTest")[1].value = contenuTd;  
		    document.getElementsByName("nomModifTestId")[1].value = splitNom[1]; 
	    });
	});

	function updateNomTest(){
		var idTest = document.getElementsByName("nomModifTestId")[1].value; 
		var nouveauNom = document.getElementsByName("nomModifTest")[1].value;
		var idFonctionnalite = $("#fonctionnaliteId").val();
		$.ajax({
			url:"../moteurs/updateTest.php",
			method:"POST",
			data:{idFonctionnalite:idFonctionnalite, idTest:idTest,nouveau:nouveauNom, type:"Nom"},
			success:function(data){
				$("#refreshPage").submit();						
			}
		})		
	}
</script>
