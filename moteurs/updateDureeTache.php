<?php
	define('__ROOT__',dirname(dirname(__FILE__)));
	require_once(__ROOT__.'/utils/links.php');

	$idTache = $_POST['idTache'];
	$nouvelleDuree = $_POST['nouvelleDuree'];
	$idFonctionnalite = $_POST['idFonctionnalite'];

	$tache = $DAO->getTacheById($idTache);
	$tache->setDuree($nouvelleDuree);
	$DAO->saveTache($tache);
	
?>