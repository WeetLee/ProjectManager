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
<table style='border-spacing: 0px 10px'>
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
				echo "<td class='".$unTest->getStatut()."' style='border:solid black 1px;'>".$unTest->getStatut()."</td>";
				echo "<td style='width : 200px;'>";
					$date = $unTest->getDateExec();
					if($date != ""){
						$formatFr = date("d/m/Y H:i:s", $date);
						echo $formatFr;
					}
				echo "</td>";
				echo "<td style='width : 200px;'><img src='../img/play.png' onclick='lancerTest(\"".$unTest->getId()."\", \"live\")' width='25px' title='Test live'/> <img src='../img/OK.png' onclick='lancerTest(\"".$unTest->getId()."\", \"OK\")' width='20px' style='margin-left:20px;' title='Test OK'/><img src='../img/KO.png' onclick='lancerTest(\"".$unTest->getId()."\", \"KO\")' width='20px' style='margin-left:20px;' title='Test KO'/></td>";
			echo "</tr>";

			$index++;
		}
	?>
		<form id="ajoutTest">
			<tr>
				<td colspan="4">
					<input type="text" placeholder="Nom" id="ajoutNomTest" name="ajoutNomTest" required/>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<input class="boutonAjout" onclick="javascript:ajouterTestFonctionnalite()" type='button' value="Créer un test"/>
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
	function ajouterTestFonctionnalite(){
		var message = "";
		if($("#ajoutNomTest").val())
			var nomTest = $("#ajoutNomTest").val();
		else		
			message+="Erreur : le nom n'est pas renseigné.\n";
		if(message != ""){
			$("#dialog").html(message);
			$( "#dialog" ).dialog();	
		}else{
			var idFonctionnalite = $("#fonctionnaliteId").val();
			$.ajax({
				url:"../moteurs/addTest.php",
				dataType:"text",
				method:"POST",
				data:{idFonctionnalite:idFonctionnalite, nomTest:nomTest},
				success:function(data){
					$("#refreshPage").submit();						
				}
			})		
		}
	}

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

	function lancerTest(idTest, typeTest){
		var idFonctionnalite = $("#fonctionnaliteId").val();
		$.ajax({
			url:"../moteurs/updateTest.php",
			method:"POST",
			data:{idFonctionnalite:idFonctionnalite, idTest:idTest,nouveau:typeTest, type:"Statut"},
			success:function(data){
				$("#refreshPage").submit();						
			}
		})	
	}
</script>
