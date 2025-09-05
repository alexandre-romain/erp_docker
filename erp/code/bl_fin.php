<?php
require_once("include/verif.php");
require_once("include/config/common.php");
require_once("include/language/$lang.php");

$tot_ht=isset($_POST['tot_ht'])?$_POST['tot_ht']:"";
$tot_tva=isset($_POST['tot_tva'])?$_POST['tot_tva']:"";
$bl_num=isset($_POST['bl_num'])?$_POST['bl_num']:"";
$coment=isset($_POST['coment'])?$_POST['coment']:"";
mysql_select_db($db) or die ("Could not select $db database");

//on met à jour la quantité livrée pour chaque ligne
$rqSql = "SELECT num_cont_bon,quanti FROM " . $tblpref ."cont_bl WHERE bl_num = $bl_num";
$result = mysql_query( $rqSql ) or die( "Exécution requête impossible.");
while ( $row = mysql_fetch_array( $result)) {
	$sql5 = "UPDATE " . $tblpref ."cont_bon SET livre=(livre+".$row['quanti'].") WHERE num = ".$row['num_cont_bon']."";
	mysql_query($sql5) OR die("<p>Erreur Mysql2<br/>$sql5<br/>".mysql_error()."</p>");

}
//mise a jour du prix total, du commentaire du BL + empeche modifs futures
$sql2 = "UPDATE " . $tblpref ."bl SET tot_htva='".$tot_ht."', tot_tva='".$tot_tva."', coment='".$coment."', status='1'  WHERE num_bl = $bl_num";
mysql_query($sql2) OR die("<p>Erreur Mysql2<br/>$sql2<br/>".mysql_error()."</p>");

//récupération du n° de bon de commande
$rqSql = "SELECT bon_num, client_num FROM " . $tblpref ."bl WHERE num_bl = $bl_num";
$result = mysql_query( $rqSql ) or die( "Exécution requête impossible.");
while ( $row = mysql_fetch_array( $result)) {
		$bon_num = $row["bon_num"];
		$client = $row["client_num"];
}
//on vérifie si des bo restants pour ce bon de commande
$rqSql2 = "SELECT quanti,livre, num as num_cont_bon FROM " . $tblpref ."cont_bon WHERE bon_num = $bon_num";
$result2 = mysql_query( $rqSql2 ) or die( "Exécution requête impossible.");
$compteur = '0';
while ( $row2 = mysql_fetch_array( $result2)) {
		$comparateur=mysql_num_rows($result2);
		$bo = $row2["quanti"] - $row2["livre"] ;
		$num_cont_bon = $row2['num_cont_bon'];
		if ($bo <='0') 
		{
		$compteur = $compteur+1;
		//on desactive la ligne du bon
		//$sql5 = "UPDATE " . $tblpref ."cont_bon SET bl='1' WHERE num = $num_cont_bon";
		//mysql_query($sql5) OR die("<p>Erreur Mysql2<br/>$sql5<br/>".mysql_error()."</p>");
		}
}

//on empeche la transforation du bon de commande en nouveau bl
if ($compteur == $comparateur)
{
$sql4 = "UPDATE " . $tblpref ."bon_comm SET bl='end' WHERE num_bon = $bon_num";
mysql_query($sql4) OR die("<p>Erreur Mysql2<br/>$sql4<br/>".mysql_error()."</p>");

}
//modif stock
$rqSql3 = "SELECT article_num, quanti FROM " . $tblpref ."cont_bl WHERE bl_num = $bl_num";
$result3 = mysql_query( $rqSql3 ) or die( "ici.");
while ( $row3 = mysql_fetch_array( $result3)) 
{	
		$article_num = $row3['article_num'];
		$quanti = $row3['quanti'];
		$sql12 = "UPDATE `" . $tblpref ."article` SET `stock` = (stock - $quanti) WHERE `num` = '$article_num'";
		mysql_query($sql12) or die('Erreur SQL12 !<br>'.$sql12.'<br>'.mysql_error());
}
session_start();
$_SESSION['message']= "BL enregistré. Stock mis à jour<br/><a class='styled' href='./fact.php?listeville=".$client."&date_deb=".date('01/m/Y')."&date_fin=".date('d/m/Y')."&date_fact=".date('d/m/Y')."'>Cliquez ici pour le facturer</a>";
header('Location: ./form_bl.php');
 ?> 