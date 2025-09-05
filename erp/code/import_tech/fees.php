<?
/////INFOS DE CONNEXION BDD + CONNEXION/////
$user= "root";//l'utilisateur de la base de données mysql
$pwd= "rootpass01";//le mot de passe à la base de données mysql
$db= "erp-dev";//le nom de la base de données mysql
$host= "localhost";//l'adresse de la base de données mysql 
$default_lang= "fr";//la langue de l'interface et des factures : voir la doc pour les abbréviations
$tblpref= "gestdev_";//prefixe des tables 
mysql_connect($host,$user,$pwd) or die ("serveur de base de données injoignable. Vérifiez dans /factux/include/common.php si $host est correct.");
mysql_select_db($db) or die ("La base de données est injoignable. Vérifiez dans /factux/include/common.php si $user, $pwd, $db sont exacts.");
/////FIN INFOS DE CONNEXION BDD + CONNEXION/////


//Auvibel
if (!$fp = fopen("upload/Auvibel.txt","r")) {
	echo "Echec de l'ouverture du fichier";
	exit;
}

else {
	while(!feof($fp)) {
		// On récupère une ligne
		$Ligne = fgets($fp,255);
		// On affiche la ligne
		$content_line=explode('	',$Ligne); //ATTENTION LE SEPARATEUR EST UNE TABULATION ET PAS UN ESPACE
		$nbr=count($content_line);
		$art_id=$content_line[0];
		$auvibel=$content_line[2];
		$auvibel=str_replace(",",".",$auvibel);
		echo $nbr.'<br/>';
		echo $art_id.' - '.$auvibel.'<br/>';
		$sql="UPDATE ".$tblpref."article SET auvibel='".$auvibel."' WHERE art_id='".$art_id."'";
		$req=mysql_query($sql);
	}
 	fclose($fp); // On ferme le fichier
}

//Bebat
if (!$fp = fopen("upload/Bebat.txt","r")) {
	echo "Echec de l'ouverture du fichier";
	exit;
}

else {
	while(!feof($fp)) {
		// On récupère une ligne
		$Ligne = fgets($fp,255);
		// On affiche la ligne
		$content_line=explode('	',$Ligne); //ATTENTION LE SEPARATEUR EST UNE TABULATION ET PAS UN ESPACE
		$nbr=count($content_line);
		$art_id=$content_line[0];
		$bebat=$content_line[2];
		$bebat=str_replace(",",".",$bebat);
		echo $nbr.'<br/>';
		echo $art_id.' - '.$bebat.'<br/>';
		$sql="UPDATE ".$tblpref."article SET bebat='".$bebat."' WHERE art_id='".$art_id."'";
		$req=mysql_query($sql);
	}
 	fclose($fp); // On ferme le fichier
}

//Recupel
if (!$fp = fopen("upload/Recupel.txt","r")) {
	echo "Echec de l'ouverture du fichier";
	exit;
}

else {
	while(!feof($fp)) {
		// On récupère une ligne
		$Ligne = fgets($fp,255);
		// On affiche la ligne
		$content_line=explode('	',$Ligne); //ATTENTION LE SEPARATEUR EST UNE TABULATION ET PAS UN ESPACE
		$nbr=count($content_line);
		$art_id=$content_line[0];
		$recupel=$content_line[2];
		$recupel=str_replace(",",".",$recupel);
		echo $nbr.'<br/>';
		echo $art_id.' - '.$recupel.'<br/>';
		$sql="UPDATE ".$tblpref."article SET recupel='".$recupel."' WHERE art_id='".$art_id."'";
		$req=mysql_query($sql);
	}
 	fclose($fp); // On ferme le fichier
}

//Reprobel
if (!$fp = fopen("upload/Reprobel.txt","r")) {
	echo "Echec de l'ouverture du fichier";
	exit;
}

else {
	while(!feof($fp)) {
		// On récupère une ligne
		$Ligne = fgets($fp,255);
		// On affiche la ligne
		$content_line=explode('	',$Ligne); //ATTENTION LE SEPARATEUR EST UNE TABULATION ET PAS UN ESPACE
		$nbr=count($content_line);
		$art_id=$content_line[0];
		$reprobel=$content_line[2];
		$reprobel=str_replace(",",".",$reprobel);
		echo $nbr.'<br/>';
		echo $art_id.' - '.$reprobel.'<br/>';
		$sql="UPDATE ".$tblpref."article SET reprobel='".$reprobel."' WHERE art_id='".$art_id."'";
		$req=mysql_query($sql);
	}
 	fclose($fp); // On ferme le fichier
}

?>