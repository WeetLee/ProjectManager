<?php
	//Requête qui récupère tous les objets triés par priorité
	$id = $_POST['id'];
	$nouvellePriorite = $_POST['priorite'];
	$prio = explode("_",$nouvellePriorite);
	$priorite = $prio[1];
	echo $id.' '.$nouvellePriorite;
	define('__ROOT__',dirname(dirname(__FILE__)));
	require_once(__ROOT__.'/utils/links.php');
	$fonctionnalite = $DAO->getFonctionnaliteById($id);
	$fonctionnalite->setPriorite($priorite);
	$DAO->saveFonctionnalite($fonctionnalite);
?>