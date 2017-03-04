<?php
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=testYourCode', 'root', '');
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}

?>