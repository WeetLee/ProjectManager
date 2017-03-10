<?php
	define('__ROOT__',dirname(dirname(__FILE__)));
	require_once(__ROOT__.'/utils/links.php');

	$idFonctionnalite = $_POST['idFonctionnalite'];
	$nomTache = $_POST['nomTache'];
	$statutTache = $_POST['statutTache'];
	$dureeTache = $_POST['dureeTache'];
	$affectationTache = $_POST['affectationTache'];
	$nouvelleTache = new Tache($nomTache, $statutTache, $dureeTache, $affectationTache);
	$DAO->saveTache($nouvelleTache,$idFonctionnalite);
?>