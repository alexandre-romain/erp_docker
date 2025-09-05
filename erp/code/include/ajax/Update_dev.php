<?php

include_once("../config/common.php");

//UpdateData.php
$state 	= $_REQUEST['state'] ; 	//L'état du dévellopement
$num 	= $_REQUEST['num'] ; 	//Le n° du dev.

$sql="UPDATE ".$tblpref."dev SET etat='".$state."' WHERE num='".$num."'";
$req=mysql_query($sql);

header('Location: ../../journal_dev.php');	

?>