<?php
	define('__ROOT__',dirname(dirname(__FILE__)));
	require_once(__ROOT__.'/utils/links.php');

	$nouveau = $_POST['nouveau'];
	$idFonctionnalite = $_POST['idFonctionnalite'];
	$idFonctionnaliteParent = $_POST['idFonctionnaliteParent'];
	$idProjet = $_POST['idProjet'];
	$type = $_POST['type'];
	$fonctionnalite = $DAO->getFonctionnaliteById($idFonctionnalite);

	if ($type == 'Nom'){
		$fonctionnalite->setNom($nouveau);
	}else if ($type == 'Description'){
		$fonctionnalite->setCommentaire($nouveau);
	}

	$DAO->saveFonctionnalite($fonctionnalite, $idFonctionnaliteParent, $idProjet);
	
?>