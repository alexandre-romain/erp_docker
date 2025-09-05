<?php

include_once("../config/common.php");

  $rowid = $_REQUEST['rowid'] ;

	//on supprime le type de tache correspondante
	
	$sql= "DELETE FROM ".$tblpref."type_task WHERE rowid=".$rowid;
	
	$req = mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');
	
header('Location: ../../param_ticket.php');

?>