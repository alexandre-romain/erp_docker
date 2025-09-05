<?php

include_once("../config/common.php");

  //recuperation des données du form d'ajour
  $rowid = $_REQUEST['id'] ;


	//on met a jour la table emplacements en mettant à inactif l'emplacemet a supprimer
	
	$sql= "DELETE FROM ".$tblpref."task WHERE rowid=".$rowid;
	
	$req = mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');

?>