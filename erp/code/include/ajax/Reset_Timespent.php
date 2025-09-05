<?php
include("../config/common.php");

$rowid = $_REQUEST['rowid'] ;

$sql="UPDATE ".$tblpref."task SET time_spent='00:00:00', time_spent_set_manual='0' WHERE rowid=".$rowid."";
$req=mysql_query($sql);

header('Location: ../../task.php?num_task='.$rowid.'');
?>