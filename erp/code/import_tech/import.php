<?php
/////INFOS DE CONNEXION BDD + CONNEXION/////
$user= "root";//l'utilisateur de la base de données mysql
$pwd= "rootpass01";//le mot de passe à la base de données mysql
$db= "gestion";//le nom de la base de données mysql
$host= "localhost";//l'adresse de la base de données mysql 
$default_lang= "fr";//la langue de l'interface et des factures : voir la doc pour les abbréviations
$tblpref= "gestsprl_";//prefixe des tables 
mysql_connect($host,$user,$pwd) or die ("serveur de base de données injoignable. Vérifiez dans /factux/include/common.php si $host est correct.");
mysql_select_db($db) or die ("La base de données est injoignable. Vérifiez dans /factux/include/common.php si $user, $pwd, $db sont exacts.");
/////FIN INFOS DE CONNEXION BDD + CONNEXION/////

echo '============ DEBUT IMPORT ============<br/>';

echo '------------ CONNEXION FTP ------------<br/>';
/////CONNEXION FTP ET RECUPERATION FICHIERS/////
if(($ftp = ftp_connect("ftp2.techdata-it-emea.com", "21")) == false)
{
	echo 'Erreur de connexion...';
}
	
if(!ftp_login($ftp, "633268", "l6gsj8vJ"))
{
	echo 'L\'identification a échoué...';
}
echo '------------ FIN CONNEXION FTP ------------<br/>';
echo '------------ RECUP ZIP ------------<br/>';
$local_file_price	="/var/gestion/import_tech/upload/price.zip";
$local_file_fees	="/var/gestion/import_tech/upload/fees.zip";

if (ftp_get($ftp, $local_file_price, "prices.zip", FTP_BINARY)) {
echo "Le fichier ".$local_file_price." a &eacute;t&eacute; &eacute;cris avec succ&egrave;s<br/>";
} 
else {
	echo "Il y a un probl&eacute;me\n avec ".$local_file_price."";
}

if (ftp_get($ftp, $local_file_fees, "Fees/Fees.zip", FTP_BINARY)) {
echo "Le fichier ".$local_file_fees." a &eacute;t&eacute; &eacute;cris avec succ&egrave;s\n<br/>";
} 
else {
	echo "Il y a un probl&eacute;me\n avec ".$local_file_fees."";
}
/////FIN CONNEXION FTP ET RECUPERATION FICHIERS/////
echo '------------ FIN RECUP ZIP ------------<br/>';
echo '------------ DECOMPRESSION ZIP ------------<br/>';
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
	//echo 'Archive extrait';
}

unzip_file('/var/gestion/import_tech/upload/price.zip', '/var/gestion/import_tech/upload/');
unzip_file('/var/gestion/import_tech/upload/fees.zip', '/var/gestion/import_tech/upload/');
echo '------------ FIN DECOMPRESSION ZIP ------------<br/>';
/////FIN TRAITEMENT DES FICHIERS ZIP/////

echo '------------ RECUP ARTICLES ------------<br/>';
/////ARTICLES/////
$row = 1;
if (($handle = fopen("/var/gestion/import_tech/upload/00633268.txt", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, ';')) !== FALSE) {
		//On récupère les informations de chaque article, on nommes les variables correctement pour plus de simplicité.
		$article		=mysql_real_escape_string($data[0]);
		$article_id		=mysql_real_escape_string($data[1]);
		$partnumber		=mysql_real_escape_string($data[2]);
		$cat1			=mysql_real_escape_string($data[3]);
		$cat2			=mysql_real_escape_string($data[4]);
		$cat3			=mysql_real_escape_string($data[5]);
		$marque			=mysql_real_escape_string($data[6]);
		//$version		=$data[7];
		//$language		=$data[8];
		//$media		=$data[9];
		//$trend		=$data[10];
		//$price_group	=$data[11];
		//$price_code	=$data[12];
		$list_price		=mysql_real_escape_string($data[13]);			//Prix catalogue
		$list_price		=str_replace ( ',', '.', $list_price);
		//$de			=$data[14];
		//$d1			=$data[15];
		//$d2			=$data[16];
		$price_personal	=mysql_real_escape_string($data[17]); 		//PA
		$price_personal	=str_replace ( ',', '.', $price_personal);
		$stock_tech		=mysql_real_escape_string($data[18]);
		$backorder_date	=$data[19];
		$modif_date		=$data[20];
		//$ean_code		=$data[21];
		//echo 'Partnumber: '.$data[2].'<br/>';
		
		//On transforme les dates pour insertion en BDD
		if ($backorder_date != '') {
			$date_inter=explode("/", $backorder_date);
			$jours	=$date_inter[0];
			$mois	=$date_inter[1];
			$annee	=$date_inter[2];
			$backorder_date=$annee.'-'.$mois.'-'.$jours;
		}
		else {
			$backorder_date='0000-00-00';
		}
		//echo 'Backorderdate: '.$backorder_date.'<br/>';
		
		$date_inter1=explode(" ", $modif_date);
		$date=$date_inter1[0];
		$time=$date_inter1[1];
		$date_inter2=explode("/", $date);
		$jours2	=$date_inter2[0];
		$mois2	=$date_inter2[1];
		$annee2	=$date_inter2[2];
		$modif_date=$annee2.'-'.$mois2.'-'.$jours2;
		//echo 'Modif Date: '.$modif_date.'<br/>';
		//On check les catégories, récupère leur id et les insère si nécessaire.
		//TOP CATEGORY (CAT1)
		$sql_cat1="SELECT id_cat";
		$sql_cat1.=" FROM ".$tblpref."categorie";
		$sql_cat1.=" WHERE categorie='".$cat1."'";
		$req_cat1=mysql_query($sql_cat1);
		if ($results_cat1=mysql_fetch_object($req_cat1)) { //Si la catégorie existe, on récupère son ID
			$cat1=$results_cat1->id_cat;
		}
		else {
			$sql_insert_cat1="INSERT INTO ".$tblpref."categorie(categorie, cat_level) VALUES ('$cat1', '1')";
			$req_insert_cat1=mysql_query($sql_insert_cat1);
			$sql_cat1_final="SELECT id_cat";
			$sql_cat1_final.=" FROM ".$tblpref."categorie";
			$sql_cat1_final.=" WHERE categorie='".$cat1."'";
			$req_cat1_final=mysql_query($sql_cat1_final);
			$results_cat1_final=mysql_fetch_object($req_cat1_final);
			$cat1=$results_cat1_final->id_cat;
		}
		
		//MIDDLE CATEGORY (CAT2)
		$sql_cat2="SELECT id_cat";
		$sql_cat2.=" FROM ".$tblpref."categorie";
		$sql_cat2.=" WHERE categorie='".$cat2."'";
		$req_cat2=mysql_query($sql_cat2);
		if ($results_cat2=mysql_fetch_object($req_cat2)) { //Si la catégorie existe, on récupère son ID
			$cat2=$results_cat2->id_cat;
		}
		else {
			$sql_insert_cat2="INSERT INTO ".$tblpref."categorie(categorie, cat_level, parent_cat) VALUES ('$cat2', '2', '$cat1')";
			$req_insert_cat2=mysql_query($sql_insert_cat2);
			$sql_cat2_final="SELECT id_cat";
			$sql_cat2_final.=" FROM ".$tblpref."categorie";
			$sql_cat2_final.=" WHERE categorie='".$cat2."'";
			$req_cat2_final=mysql_query($sql_cat2_final);
			$results_cat2_final=mysql_fetch_object($req_cat2_final);
			$cat2=$results_cat2_final->id_cat;
		}
		
		//BOTTOM CATEGORY (CAT3)
		$sql_cat3="SELECT id_cat";
		$sql_cat3.=" FROM ".$tblpref."categorie";
		$sql_cat3.=" WHERE categorie='".$cat3."'";
		$req_cat3=mysql_query($sql_cat3);
		if ($results_cat3=mysql_fetch_object($req_cat3)) { //Si la catégorie existe, on récupère son ID
			$cat3=$results_cat3->id_cat;
		}
		else {
			$sql_insert_cat3="INSERT INTO ".$tblpref."categorie(categorie, cat_level, parent_cat) VALUES ('$cat3', '3', '$cat2')";
			$req_insert_cat3=mysql_query($sql_insert_cat3);
			$sql_cat3_final="SELECT id_cat";
			$sql_cat3_final.=" FROM ".$tblpref."categorie";
			$sql_cat3_final.=" WHERE categorie='".$cat3."'";
			$req_cat3_final=mysql_query($sql_cat3_final);
			$results_cat3_final=mysql_fetch_object($req_cat3_final);
			$cat3=$results_cat3_final->id_cat;
		}
		
		
		//on défini les valeurs ne devant pas changer (et non contenue dans le csv d'import)
		$taux_tva=21;
		$unite='p';
		$marge=22;
		
		//On vérifie s'il existe déja un article avec le même Partnumber
		$sql ="SELECT *";
		$sql.=" FROM ".$tblpref."article";
		$sql.=" WHERE reference='".$partnumber."'";
		$req=mysql_query($sql);
		if ($results=mysql_fetch_object($req)) { //Si c'est le cas, on l'update
			//echo 'je rentre dans l\'update<br/>';
			$sql_update="UPDATE ".$tblpref."article SET";
			$sql_update.=" article='".$article."',";
			$sql_update.=" prix_htva='".$price_personal."',";
			$sql_update.=" list_price='".$list_price."',";
			$sql_update.=" stock_tech='".$stock_tech."',";
			$sql_update.=" backorder_date='".$backorder_date."',";
			$sql_update.=" cat1='".$cat1."',";
			$sql_update.=" cat2='".$cat2."',";
			$sql_update.=" cat3='".$cat3."',";
			$sql_update.=" art_id='".$article_id."',";
			$sql_update.=" marque='".$marque."',";
			$sql_update.=" modif_date='".$modif_date."'";
			$sql_update.=" WHERE reference='".$partnumber."'";
			$req_update=mysql_query($sql_update);
		}
		else { //Sinon, on l'insère
			//echo 'je rentre dans l\'insert<br/>';
			$sql_insert="INSERT INTO ".$tblpref."article(article, prix_htva, taux_tva, list_price, uni, stock_tech, backorder_date, cat1, cat2, cat3, marge, art_id, reference, marque, modif_date) VALUES ('$article', '$price_personal', '$taux_tva', '$list_price', '$unite', '$stock_tech', '$backorder_date', '$cat1', '$cat2', '$cat3', '$marge', '$article_id', '$partnumber', '$marque', '$modif_date')";
			$req_insert=mysql_query($sql_insert);
		}
    }
    fclose($handle);
}
/////FIN DES ARTICLES/////
echo '------------ FIN RECUP ARTICLES ------------<br/>';
echo '------------ RECUP TAXES ------------<br/>';
/////TAXES/////
//Auvibel
if (!$fp = fopen("/var/gestion/import_tech/upload/Auvibel.txt","r")) {
	echo "Echec de l'ouverture du fichier Auvibel";
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
		//echo $nbr.'<br/>';
		//echo $art_id.' - '.$auvibel.'<br/>';
		$sql="UPDATE ".$tblpref."article SET auvibel='".$auvibel."' WHERE art_id='".$art_id."'";
		$req=mysql_query($sql);
	}
 	fclose($fp); // On ferme le fichier
}

//Bebat
if (!$fp = fopen("/var/gestion/import_tech/upload/Bebat.txt","r")) {
	echo "Echec de l'ouverture du fichier Bebat";
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
		//echo $nbr.'<br/>';
		//echo $art_id.' - '.$bebat.'<br/>';
		$sql="UPDATE ".$tblpref."article SET bebat='".$bebat."' WHERE art_id='".$art_id."'";
		$req=mysql_query($sql);
	}
 	fclose($fp); // On ferme le fichier
}

//Recupel
if (!$fp = fopen("/var/gestion/import_tech/upload/Recupel.txt","r")) {
	echo "Echec de l'ouverture du fichier Recupel";
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
		//echo $nbr.'<br/>';
		//echo $art_id.' - '.$recupel.'<br/>';
		$sql="UPDATE ".$tblpref."article SET recupel='".$recupel."' WHERE art_id='".$art_id."'";
		$req=mysql_query($sql);
	}
 	fclose($fp); // On ferme le fichier
}
//Reprobel
if (!$fp = fopen("/var/gestion/import_tech/upload/Reprobel.txt","r")) {
	echo "Echec de l'ouverture du fichier Reprobel";
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
		//echo $nbr.'<br/>';
		//echo $art_id.' - '.$reprobel.'<br/>';
		$sql="UPDATE ".$tblpref."article SET reprobel='".$reprobel."' WHERE art_id='".$art_id."'";
		$req=mysql_query($sql);
	}
 	fclose($fp); // On ferme le fichier
}
/////FIN TAXES/////
echo '------------ FIN RECUP TAXES ------------<br/>';
echo '============ FIN IMPORT ============';
?>