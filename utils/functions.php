<?php
function upload($index,$destination,$maxsize=FALSE,$extensions=FALSE)
{
	//Test1: fichier correctement uploadé
    if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) return FALSE;
	//Test2: taille limite
    if ($maxsize !== FALSE AND $_FILES[$index]['size'] > $maxsize) return FALSE;
	//Test3: extension
    $ext = substr(strrchr($_FILES[$index]['name'],'.'),1);
    if ($extensions !== FALSE AND !in_array($ext,$extensions)) return FALSE;
	//Déplacement
	$deplacement = __ROOT__.'/'.$destination;
	$nomAleatoire = aleatoireString(30).".".$ext;
	$nouveauNom = str_replace("/","\\",$deplacement.'\\'.$nomAleatoire);
    if(move_uploaded_file($_FILES[$index]['tmp_name'],$nouveauNom)){
		return $nomAleatoire;
	}
}

function aleatoireString($car) {
	$string = "";
	$chaine = "abcdefghijklmnpqrstuvwxy";
	srand((double)microtime()*1000000);
	for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
	}
	return $string;
}
?>
