<?php
include("../config/common.php");
include("../fonctions.php");
//RECUPERATION VAR TICKET
$user_creator		=$_REQUEST['user_creator'];
$client				=$_REQUEST['client'];
$name_ticket		=$_REQUEST['name_ticket'];
$user_ticket		=$_REQUEST['user_ticket'];
$date_due_ticket	=$_REQUEST['date_due_ticket'];
$hour_due_ticket	=$_REQUEST['hour_due_ticket'];
$min_due_ticket		=$_REQUEST['min_due_ticket'];
$note_internal		=addslashes($_REQUEST['note_internal']);
//On récupère les infos de contact, si un contact est défini
if (isset($_REQUEST['contact']) && $_REQUEST['contact'] == 'contact_oui') {
	$nom_contact		=$_REQUEST['nom_contact'];
	$prenom_contact		=$_REQUEST['prenom_contact'];
	$mail_contact		=$_REQUEST['mail_contact'];
	$tel_contact		=$_REQUEST['tel_contact'];
}
//On vérifie si la tâche est ouverte ou cloturée.
if (isset($_REQUEST['submit_new_task'])) {
	$state=0;
}
else if (isset($_REQUEST['submit_close_task'])) {
	$state=1;
}
///TRANSFORMATION VARIABLE
$date_due=dateEU_to_dateUSA($date_due_ticket).' '.$hour_due_ticket.':'.$min_due_ticket.':00';
//On insère la ligne du ticket
$sql="INSERT INTO ".$tblpref."ticket(name, user_in_charge, soc, date_due, note, user_creator, date_creation, state) VALUES ('".$name_ticket."', '".$user_ticket."', '".$client."', '".$date_due."', '".$note_internal."', '".$user_creator."', now(), '".$state."')";
$req=mysql_query($sql);
//On récupère l'id de la ligne insérée
$id_ticket=mysql_insert_id();
//Si un contact est défini on l'insère
if (isset($_REQUEST['contact']) && $_REQUEST['contact'] == 'contact_oui') {
	$sql="UPDATE ".$tblpref."ticket SET name_contact='".$nom_contact."', firstname_contact='".$prenom_contact."', tel_contact='".$tel_contact."', mail_contact='".$mail_contact."' WHERE rowid='".$id_ticket."'";
	$req=mysql_query($sql);
}
//On s'occupe des tâches.
$tasks		=$_REQUEST['task'];
foreach ($tasks as $task) {
	//On construit la date due
	$date_due_task=dateEU_to_dateUSA($task[date_due]).' '.$task[heure_due].':'.$task[min_due].':00';
	//Si la tâche est terminée, on l'insère avec sa durée, état closed (1)
	if (isset($task[fin])) {
		//On construit le time spent
		$timespent=$task[hours_spent].':'.$task[min_spent].':00';
		$sql="INSERT INTO ".$tblpref."task(name, ticket_num, date_due, type, state, tarif_special, deplacement, user_intervenant, time_spent, user_creator, date_creation) VALUES ('".$task[nom]."', '".$id_ticket."', '".$date_due_task."', '".$task[type]."', '1', '".$task[tarif]."', '".$task[deplacement]."', '".$task[user]."', '".$timespent."', '".$user_creator."', now())";
	}
	//Sinon on l'insère à l'état ouverte (0)
	else {
		$sql="INSERT INTO ".$tblpref."task(name, ticket_num, date_due, type, state, tarif_special, deplacement, user_intervenant, user_creator, date_creation) VALUES ('".$task[nom]."', '".$id_ticket."', '".$date_due_task."', '".$task[type]."', '0', '".$task[tarif]."', '".$task[deplacement]."', '".$task[user]."', '".$user_creator."', now())";
	}
	$req=mysql_query($sql);
}
header('Location: ../../ticket.php?num_ticket='.$id_ticket);
?>