<?php
	define('__ROOT__',dirname(dirname(__FILE__)));
	require_once(__ROOT__.'/utils/links.php');

	$idTache = $_POST['idTache'];
	$nouveau = $_POST['nouveau'];
	$idFonctionnalite = $_POST['idFonctionnalite'];
	$type = $_POST['type'];

	$tache = $DAO->getTacheById($idTache);

	if($type == "Duree"){
		$tache->setDuree($nouveau);
	}else if ($type == 'Nom'){
		$tache->setNom($nouveau);
	}else if($type == "Statut"){
		$explode = explode("_",$idTache);
		$id = $explode[1];
		$tache = $DAO->getTacheById($id);
		$tache->setStatut($nouveau); 
	}else if($type == "Type"){
		$tache->setType($nouveau); 
	}else if($type == "Affectation"){
		$tache->setAffectation($nouveau); 
	}

	$DAO->saveTache($tache, $idFonctionnalite);
	
?>