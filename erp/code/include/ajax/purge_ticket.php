<?php
include("../config/common.php");

$num_ticket = $_REQUEST['num_ticket'];
$location = $_REQUEST['location'];

$sql="UPDATE ".$tblpref."ticket SET facture='ok', fact_num='PURGE' WHERE rowid=".$num_ticket."";
$req=mysql_query($sql);

$sql="UPDATE ".$tblpref."task SET fact_num='PURGE' WHERE ticket_num='".$num_ticket."'";
$req=mysql_query($sql);


if ($location == 'acceuil') {
	header('Location: ../../accueil.php');
}
else if ($location == 'ficheticket') {
	header('Location: ../../ticket.php?num_ticket='.$num_ticket.'');
}
?>