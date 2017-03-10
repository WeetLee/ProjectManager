<?php
	define('__ROOT__',dirname(dirname(__FILE__)));
	require_once(__ROOT__.'/utils/links.php');

	$id = $_POST['idTache'];
	$nouveauStatut = $_POST['statut'];
	$idFonctionnalite = $_POST['idFonctionnalite'];

	$explode = explode("_",$id);
	$idTache = $explode[1];
	$tache = $DAO->getTacheById($idTache);
	$tache->setAvancement($nouveauStatut);
	$DAO->saveTache($tache);
	
?>