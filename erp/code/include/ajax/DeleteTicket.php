<?php

include_once("../config/common.php");

  //recuperation des données du form d'ajour
  $rowid = $_REQUEST['id'] ;


	//on delete l'entrée dans la table ticket	
	$sql= "DELETE FROM ".$tblpref."ticket WHERE rowid=".$rowid;	
	$req = mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');
	//on delete les entrées correspondantes dans la table task
	$sql1= "DELETE FROM ".$tblpref."task WHERE ticket_num=".$rowid;	
	$req1 = mysql_query($sql1) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');

?>