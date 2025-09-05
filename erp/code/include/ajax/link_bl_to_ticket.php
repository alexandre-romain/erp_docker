<?php

include_once("../config/common.php");

//UpdateData.php
$num_bl = $_REQUEST['num_bl'] ;
$num_ticket = $_REQUEST['num_ticket'] ;


//on met a jour la table ticket

$sql= "UPDATE ".$tblpref."bl SET fk_ticket='".$num_ticket."' WHERE num_bl=".$num_bl."";

$req = mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');

header('Location: ../../ticket.php?num_ticket='.$num_ticket.'');
?>