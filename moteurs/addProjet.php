<?php
	define('__ROOT__',dirname(dirname(__FILE__)));
	require_once(__ROOT__.'/utils/links.php');

	if(isset($_POST)){
		$upload = upload('imageProjet','img/projets',1000000, array('png','gif','jpg','jpeg') );
		if ($upload){
			$projet = new Projet($_POST['nomProjet'], $upload);
			$DAO->saveProjet($projet);
		}

	}
	header('Location:../index.php');
?>