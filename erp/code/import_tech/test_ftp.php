<?php
/////CONNEXION FTP ET RECUPERATION FICHIERS/////
if(($ftp = ftp_connect("ftp2.techdata-it-emea.com", "21")) == false)
{
	echo 'Erreur de connexion...';
}
	
if(!ftp_login($ftp, "633268", "l6gsj8vJ"))
{
	echo 'L\'identification a échoué...';
}

/*$liste_fichiers = ftp_nlist($ftp, '.');
	
foreach($liste_fichiers as $fichier)
{
	echo '<a href="?filename=' .$fichier. '">' .$fichier. '</a><br/>';
}*/
	
$local_file_price	="./upload/price.zip";
$local_file_fees	="./upload/fees.zip";

if (ftp_get($ftp, $local_file_price, "prices.zip", FTP_BINARY)) {
echo "Le fichier ".$local_file_price." a &eacute;t&eacute; &eacute;cris avec succ&egrave;s\n";
} 
else {
	echo "Il y a un probl&eacute;me\n avec ".$local_file_price."";
}

if (ftp_get($ftp, $local_file_fees, "Fees/Fees.zip", FTP_BINARY)) {
echo "Le fichier ".$local_file_fees." a &eacute;t&eacute; &eacute;cris avec succ&egrave;s\n";
} 
else {
	echo "Il y a un probl&eacute;me\n avec ".$local_file_fees."";
}
/////FIN CONNEXION FTP ET RECUPERATION FICHIERS/////



?>