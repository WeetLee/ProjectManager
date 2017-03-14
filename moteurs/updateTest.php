<?php
	define('__ROOT__',dirname(dirname(__FILE__)));
	require_once(__ROOT__.'/utils/links.php');

	$idTest = $_POST['idTest'];
	$nouveau = $_POST['nouveau'];
	$idFonctionnalite = $_POST['idFonctionnalite'];
	$type = $_POST['type'];

	$test = $DAO->getTestById($idTest);

	if ($type == 'Nom'){
		$test->setNom($nouveau);
	}else if($type == "Statut"){
		$explode = explode("_",$idTest);
		$id = $explode[1];
		$test = $DAO->gettestById($id);
		$test->setStatut($nouveau); 
	}

	$DAO->saveTest($test, $idFonctionnalite);
	
?>