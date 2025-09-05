<?php

include_once("../config/common.php");

$num_task = $_REQUEST['num_task'];

	$sql= "UPDATE ".$tblpref."task SET state=1 WHERE rowid=".$num_task."";	
	$req = mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');

header('Location: ../../task.php?num_task='.$num_task.'');
?>