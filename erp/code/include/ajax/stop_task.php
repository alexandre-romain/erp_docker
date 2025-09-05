<?php

include_once("../config/common.php");

$num_task = $_REQUEST['num_task'];

	$sql= "UPDATE ".$tblpref."task SET time_stop=now() WHERE rowid=".$num_task."";	
	$req = mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');


$sql="SELECT UNIX_TIMESTAMP(time_start) as date_d, UNIX_TIMESTAMP(time_stop) as date_f, time_spent as timespent";
$sql.=" FROM ".$tblpref."task";
$sql.=" WHERE rowid=".$num_task."";
$req=mysql_query($sql);
$results=mysql_fetch_object($req);

$date_debut = $results->date_d;
$date_fin = $results->date_f;
$time_spent = $results->timespent;

$timsespent_to_add=$date_fin-$date_debut;
//Transformation des secondes en HH:mm:ss
$heures=intval($timsespent_to_add / 3600);
$minutes=intval(($timsespent_to_add % 3600) / 60);
$secondes=intval((($timsespent_to_add % 3600) % 60));

$time_to_add=$heures.':'.$minutes.':'.$secondes;


$sql=" UPDATE ".$tblpref."task";
$sql.=" SET time_spent=ADDTIME('".$time_spent."','".$time_to_add."'), time_start=NULL, time_stop=NULL";
$sql.=" WHERE rowid=".$num_task."";
$req = mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');

header('Location: ../../task.php?num_task='.$num_task.'');
?>