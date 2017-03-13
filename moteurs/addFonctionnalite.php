<?php
	define('__ROOT__',dirname(dirname(__FILE__)));
	require_once(__ROOT__.'/utils/links.php');

	$idFonctionnalite = $_POST['idFonctionnalite'];
	if($idFonctionnalite == "default")
		$idFonctionnalite = NULL;
	$idProjet = $_POST['idProjet'];
	$nomFonctionnalite = $_POST['nomFonctionnalite'];
	$affectationFonctionnalite = $_POST['affectationFonctionnalite'];
	$prioriteFonctionnalite = $_POST['prioriteFonctionnalite'];

	$nouvelleFonctionnalite = new Fonctionnalite("Evolution", $nomFonctionnalite, "A analyser", $affectationFonctionnalite, $prioriteFonctionnalite, $idFonctionnalite, "");
	$DAO -> saveFonctionnalite($nouvelleFonctionnalite, $idFonctionnalite, $idProjet);

?>