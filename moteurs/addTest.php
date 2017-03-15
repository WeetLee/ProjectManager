<?php
	define('__ROOT__',dirname(dirname(__FILE__)));
	require_once(__ROOT__.'/utils/links.php');

	$idFonctionnalite = $_POST['idFonctionnalite'];
	$nomTest = $_POST['nomTest'];

	$nouveauTest = new Test($nomTest, "KO", null);
	$DAO->saveTest($nouveauTest,$idFonctionnalite);
?>