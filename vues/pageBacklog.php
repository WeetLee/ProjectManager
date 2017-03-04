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
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $monProjet->getNom(); ?></title>
	<script src="../js/jquery-3.1.1.js"></script>
  	<script src="../js/jquery-ui-1.12.1/jquery-ui.js"></script>
 	<link rel="stylesheet" href="../css/jquery-ui.css"/>
 	<link rel="stylesheet" href="../css/style.css"/>
 	<link rel="stylesheet" href="../css/backlog.css"/>
 	<link rel="stylesheet" type="text/css" href="../css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="../img/fonts/font-awesome-4.3.0/css/font-awesome.min.css" />
</head> 
<body>
	<div class="mainPage">
		<h1><?php echo $monProjet->getNom(); ?></h1><hr/>
		<div class="backlogDiv">
			<form id="changerVue" method="post" action="pageFonctionnalite.php">
				<div id="changerVueProjet">
					<input type="hidden" id="project" name="project" value="<?php echo $id; ?>"/>
					<input type="hidden" name="fonctionnalite" value="default"/>
					<p onclick="javascript:changerStatut();" class="clickable">Afficher les fonctionnalités</p>
				</div>
			</form>
			<fieldset style="display:none;">
				<legend id="filtre" class="clickable">Filtres</legend> 
				<table id="tabFiltre" style="font-size:19px; table-layout: fixed; display:none;">
				  <tr style="text-align:left;">
				    <td>Type</td>
				    <td>Status</td>
				    <td>Affectation</td>
				  </tr>
				  <tr style="text-align:left;">
				    <td style="vertical-align:top;">
				      <label><input type="checkbox" value="Bug" name="filtre" onclick='javascript:refreshBacklog()' checked="checked" id="bug"/> Bug</label><br/>
				      <label><input type="checkbox" value="Evolution" name="filtre" onclick='javascript:refreshBacklog()' checked="checked"/> Evolution</label>
				    </td>
				    <td style="vertical-align:top;">
				      <label><input type="checkbox" value="A analyser" name="filtre" onclick='javascript:refreshBacklog()'checked="checked"/> A analyser</label><br/>
				      <label><input type="checkbox" value="A faire" name="filtre" onclick='javascript:refreshBacklog()'checked="checked"/> A faire</label><br/>
				      <label><input type="checkbox" value="En cours" name="filtre" onclick='javascript:refreshBacklog()' checked="checked"/> En cours</label><br/>
				      <label><input type="checkbox" value="A tester" name="filtre" onclick='javascript:refreshBacklog()' checked="checked"/> A tester</label><br/>
				      <label><input type="checkbox" value="Terminé" name="filtre" onclick='javascript:refreshBacklog()'/> Terminé</label>
				    </td>
				    <td style="vertical-align:top;">
				      <label><input type="checkbox" value="Florent" name="filtre" onclick='javascript:refreshBacklog()' checked="checked"/> Florent</label><br/>
				      <label><input type="checkbox" value="Marianne" name="filtre" onclick='javascript:refreshBacklog()' checked="checked"/> Marianne</label>
				    </td>
				  </tr>
				</table>
			</fieldset>
			<br/>
			<form id="pageFonctionnalite" method="post" action="pageFonctionnalite.php">
				<input type="hidden" id="project" name="project" value="<?php echo $id; ?>"/>
				<input type="hidden" name="fonctionnalite" id="fonctionnalite" value="default"/>
				<div id="backlog">

				</div>
			</form>
		</div>
	</div>
</body>
</html>

<script>
	$( function() {
	    $( "#sortable_1, #sortable_2, #sortable_3, #sortable_4" ).sortable({
	      connectWith: ".connectedSortable"
	    }).disableSelection();
	  } );
	function changerStatut(){
		$("#changerVue").submit();
	}

	function afficherFonctionnalite(id){
		document.getElementById("fonctionnalite").value = id;
		$("#pageFonctionnalite").submit();
	}

	$( function() {
		$( "#tabFiltre input" ).checkboxradio();
		refreshBacklog();
	});

  	function refreshBacklog(){
  		var filtre = new Array();
  		$("input:checkbox[name=filtre]:checked").each(function(){
		    filtre.push($(this).val());
		});
  		$.ajax({
	  		url:'../moteurs/moteurBacklog.php',
	  		method:'post',
	  		data : {"filtre":filtre, "idProjet":document.getElementById('project').value},
	  		dataType :'text',
	  		success:function(data){
	  			$("#backlog").html(data);
	  			$( function() {
	  			    $( "#sortable_1, #sortable_2, #sortable_3, #sortable_4" ).sortable({
				      	connectWith: ".connectedSortable",
				      	cursor:"move",
				      	helper: fixWidthHelper,
				      	update: function(event,ui){
				      		$.ajax({
					    		url : "../moteurs/updatePriorityBacklog.php",
					    		method:"post",
					    		data : {"id":$(ui.item).attr('id'), "priorite" : $(ui.item).parent().attr('id')},
					    		dataType : 'text'
				    		})
				      	}
		  			}).disableSelection();
					    
					function fixWidthHelper(e, ui) {
					    ui.children().each(function() {
					        $(this).width($(this).width());
					    });
					    return ui;
					}
				});
	  		}
	  	})	
	}

	$(document).ready(function(){
	    $("#filtre").click(function(){
	        $("#tabFiltre").toggle(200);
	    });
	});
</script>
