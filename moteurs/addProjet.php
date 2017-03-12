<?php
	define('__ROOT__',dirname(dirname(__FILE__)));
	require_once(__ROOT__.'/utils/links.php');

	if(isset($_POST)){
		var_dump($_POST);
		$upload = upload('imageProjet','img/projets',100000000000000000000000000000, array('png','gif','jpg','jpeg','JPG') );
		echo $upload;
		if ($upload){
			$projet = new Projet($_POST['nomProjet'], $upload);
			$DAO->saveProjet($projet);
		}

	}
	header('Location:../index.php');
?>