<?php

include("../config/common.php");

$hours = addslashes($_REQUEST['hours']);
$min = addslashes($_REQUEST['min']);
$time_spent = addslashes($_REQUEST['time_spent']);
$fk_task = addslashes($_REQUEST['fk_task']);
$fk_inter = addslashes($_REQUEST['fk_inter']);
$place = addslashes($_REQUEST['place']);

$sql=" UPDATE ".$tblpref."inter_tache";
$sql.=" SET time_spent=ADDTIME('".$time_spent."','".$hours.":".$min.":00')";
$sql.=" WHERE rowid=$fk_task";
$req = mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');



//Redirection sur la page à partir de laquelle on a modifié le temps de travail
if ($place=='list'){
header('Location: ../../list_task.php');	
}
else if ($place=='fiche'){
header('Location: ../../fichetask_prix.php?rowid='.$fk_task.'');
}
else if ($place=='list_now'){
header('Location: ../../now_task.php');	
}
else if ($place=='list_past'){
header('Location: ../../past_task.php');	
}
else if ($place=='fiche_inter'){
header('Location: ../../ficheinter_task.php?rowid='.$fk_inter.'');	
}
?>







