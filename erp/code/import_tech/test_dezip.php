<?php
/////TRAITEMENT DES FICHIERS ZIP/////

function unzip_file($file, $destination) {
	// Créer l'objet (PHP 5 >= 5.2)
	$zip = new ZipArchive() ;
	// Ouvrir l'archive
	if ($zip->open($file) !== true) {
	return 'Impossible d\'ouvrir l\'archive';
	}
	// Extraire le contenu dans le dossier de destination
	$zip->extractTo($destination);
	// Fermer l'archive
	$zip->close();
	// Afficher un message de fin
	echo 'Archive extrait';
}

unzip_file('upload/price.zip', 'upload/');
unzip_file('upload/fees.zip', 'upload/');

/////FIN TRAITEMENT DES FICHIERS ZIP/////
chmod("upload/00633268.txt", 0777) or die('erreur de chmod \n');

$fichier = "upload/00633268.txt";
$extension = "csv";

$nouveau_nom = "techdata.".$extension;

rename($fichier, $nouveau_nom) or die('erreur pour le renomage \n');  // ton fichier est maintenant de la forme blabla.csv
?>