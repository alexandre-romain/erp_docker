<?php

include_once("../config/common.php");

$num_ticket = $_REQUEST['num_ticket'];

	$sql= "UPDATE ".$tblpref."ticket SET state=1 WHERE rowid=".$num_ticket."";	
	$req = mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');

header('Location: ../../ticket.php?num_ticket='.$num_ticket.'');
?>