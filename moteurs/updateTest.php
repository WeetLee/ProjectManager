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
		if($nouveau == "live"){
			$test->setStatut("KO");
		}else if($nouveau == "KO"){
			$test->setStatut("KO");
		}else{
			$test->setStatut("OK");
		}
		$test->setStatut($nouveau); 
		$test->setDateExec(time());
	}
	$DAO->saveTest($test, $idFonctionnalite);
	
?>