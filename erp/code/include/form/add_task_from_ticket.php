<?php
include("../config/common.php");
include("../fonctions.php");
//Récupération des variables
$name_task				=$_REQUEST['name_task'];
$type_task				=$_REQUEST['type_task'];
$deplacement			=$_REQUEST['deplacement'];
$tarif_special			=$_REQUEST['tarif_special'];
$user_task				=$_REQUEST['user_task'];
$min_due_task			=$_REQUEST['min_due_task'];
$hour_due_task			=$_REQUEST['hour_due_task'];
$date_due_task			=$_REQUEST['date_due_task'];
$state_task				=$_REQUEST['state_task'];
if ($state_task == 1) {
	$time_spent_hours	=$_REQUEST['time_spent_hours'];
	$time_spent_min		=$_REQUEST['time_spent_min'];
	//Transformation TIMESPENT
	$time_spent = $time_spent_hours.':'.$time_spent_min.':00';
}
$num_ticket				=$_REQUEST['num_ticket'];
$user_creator			=$_REQUEST['user_creator'];
///TRANSFORMATION DES VARS POUR INSERTION
//DATE DUE
$date_due = dateEU_to_dateUSA($date_due_task).' '.$hour_due_task.':'.$min_due_task.':00';



//Si la tâche est cloturée, on l'insère avec le TIME-SPENT
if ($state_task == 1) {
	$sql="INSERT INTO ".$tblpref."task(name, ticket_num, date_due, type, state, tarif_special, deplacement, user_intervenant, time_spent, user_creator, date_creation) VALUES ('".$name_task."', '".$num_ticket."', '".$date_due."', '".$type_task."', '".$state_task."', '".$tarif_special."', '".$deplacement."', '".$user_task."', '".$time_spent."', '".$user_creator."', now())";
	$req=mysql_query($sql);
}
//Sinon, on l'insère sans.
else if ($state_task == 0) {
	$sql="INSERT INTO ".$tblpref."task(name, ticket_num, date_due, type, state, tarif_special, deplacement, user_intervenant, user_creator, date_creation) VALUES ('".$name_task."', '".$num_ticket."', '".$date_due."', '".$type_task."', '".$state_task."', '".$tarif_special."', '".$deplacement."', '".$user_task."', '".$user_creator."', now())";
	$req=mysql_query($sql);
}

header('Location: ../../ticket.php?num_ticket='.$num_ticket.'#list');
?>