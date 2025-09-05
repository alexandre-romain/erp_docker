<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/head.php");
echo '<link rel="stylesheet" type="text/css" href="include/style.css">';
echo'<link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico" >';
$num_dev=isset($_GET['num_dev'])?$_GET['num_dev']:"";
$jour = date("d");
$mois = date("m");
$annee = date("Y");
//on recpere les donnée de devis
$sql0 = "SELECT * FROM " . $tblpref ."devis WHERE num_dev = $num_dev";
$req = mysql_query($sql0) or die('Erreur SQL !<br>'.$sql0.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
	$num_dev = $data['num_dev'];
	$client_num = $data['client_num'];
	$date = $data['date'];
	$tot_htva = $data['tot_htva'];
	$tot_tva = $data['tot_tva'];
}
//on les reinjecte dans la base bon_comm
$sql1 = "INSERT INTO " . $tblpref ."bon_comm ( client_num, date, tot_htva, tot_tva ) VALUES ( $client_num, '$annee-$mois-$jour', $tot_htva, $tot_tva )";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
$bon_commande = mysql_insert_id();
$sql2 = "UPDATE " . $tblpref ."devis SET resu='ok' WHERE num_dev= $num_dev";
mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());

$sql3 = "SELECT * FROM " . $tblpref ."cont_dev WHERE dev_num = $num_dev";
$req = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());

while($data = mysql_fetch_array($req))
{
	$article_num = $data['article_num'];
	$quanti = $data['quanti'];
	$tot_art_htva = $data['tot_art_htva'];
	$to_tva_art = $data['to_tva_art'];
	$p_u_jour = $data['p_u_jour'];
	$sql4 = "INSERT INTO " . $tblpref ."cont_bon(bon_num, article_num, quanti, tot_art_htva, to_tva_art, p_u_jour) 
	VALUES ('$bon_commande', '$article_num', '$quanti', '$tot_art_htva', '$to_tva_art', '$p_u_jour')";
	mysql_query($sql4) or die('Erreur SQL !<br>'.$sql4.'<br>'.mysql_error());
}
$message= "Votre devis &agrave; &eacute;t&eacute; transform&eacute; en bon de commande";

include_once("lister_commandes.php");
 ?> 