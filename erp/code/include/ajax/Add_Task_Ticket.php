<?php
include("../config/common.php");
include("../fonctions.php");
//Début Récuperation des données
$soc 					= addslashes($_REQUEST['listeville']);
$new_or_existing 		= addslashes($_REQUEST['new_or_existing']);
$name_ticket 			= addslashes($_REQUEST['name_ticket']);
$user_ticket 			= addslashes($_REQUEST['user_ticket']);
$date_due_ticket 		= addslashes($_REQUEST['date_due_ticket']);
$hour_due_ticket 		= addslashes($_REQUEST['hour_due_ticket']);
$min_due_ticket 		= addslashes($_REQUEST['min_due_ticket']);
$note_internal 			= addslashes($_REQUEST['note_internal']);
$name_task 				= addslashes($_REQUEST['name_task']);
$type_task 				= addslashes($_REQUEST['type_task']);
$state_task 			= addslashes($_REQUEST['state_task']);
$user_task 				= addslashes($_REQUEST['user_task']);
$date_due_task 			= addslashes($_REQUEST['date_due_task']);
$hour_due_task 			= addslashes($_REQUEST['hour_due_task']);
$min_due_task 			= addslashes($_REQUEST['min_due_task']);
$time_spent_hours 		= addslashes($_REQUEST['time_spent_hours']);
$time_spent_min 		= addslashes($_REQUEST['time_spent_min']);
$name_task2 			= addslashes($_REQUEST['name_task2']);
$type_task2 			= addslashes($_REQUEST['type_task2']);
$state_task2 			= addslashes($_REQUEST['state_task2']);
$user_task2 			= addslashes($_REQUEST['user_task2']);
$date_due_task2 		= addslashes($_REQUEST['date_due_task2']);
$hour_due_task2 		= addslashes($_REQUEST['hour_due_task2']);
$min_due_task2	 		= addslashes($_REQUEST['min_due_task2']);
$time_spent_hours2 		= addslashes($_REQUEST['time_spent_hours2']);
$time_spent_min2 		= addslashes($_REQUEST['time_spent_min2']);
$user_creator 			= addslashes($_REQUEST['user_creator']);
$num_ticket				= addslashes($_REQUEST['num_ticket']);
$deplacement			= addslashes($_REQUEST['deplacement']);
$tarif_special			= addslashes($_REQUEST['tarif_special']);
$deplacement2			= addslashes($_REQUEST['deplacement2']);
$tarif_special2			= addslashes($_REQUEST['tarif_special2']);
$name_contact			= addslashes($_REQUEST['name_contact']);
$firstname_contact		= addslashes($_REQUEST['firstname_contact']);
$tel_contact			= addslashes($_REQUEST['tel_contact']);
$mail_contact			= addslashes($_REQUEST['mail_contact']);
$place					= addslashes($_REQUEST['place']);
//Convertion des dates au format mysql
if (isset($_REQUEST['date_due_ticket'])) {
	$datetemp = explode('-',$date_due_ticket);
	$jour = $datetemp[0];
	$mois = $datetemp[1];
	$annee = $datetemp[2];
	$date_due_ticket_correct=$annee."-".$mois."-".$jour;
	$date_due_ticket_final=$date_due_ticket_correct.' '.$hour_due_ticket.':'.$min_due_ticket;
}

if (isset($_REQUEST['date_due_task'])) {
	$datetemp = explode('-',$date_due_task);
	$jour = $datetemp[0];
	$mois = $datetemp[1];
	$annee = $datetemp[2];
	$date_due_task_correct=$annee."-".$mois."-".$jour;
	$date_due_task_final=$date_due_task_correct.' '.$hour_due_task.':'.$min_due_task;
}

if (isset($_REQUEST['date_due_task2'])) {
	$datetemp = explode('-',$date_due_task2);
	$jour = $datetemp[0];
	$mois = $datetemp[1];
	$annee = $datetemp[2];
	$date_due_task2_correct=$annee."-".$mois."-".$jour;
	$date_due_task2_final=$date_due_task2_correct.' '.$hour_due_task2.':'.$min_due_task2;
}
//Fin de récupération///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Creation de la variable reprenant date/heure de manière a pouvoir l'insérer
$date_now=date('Y-m-d H:m:s');

if (isset($_POST['submit_new_task'])) { //Si on a valider, on ne clos que ce qui est indiqué
	
	if ($new_or_existing == 1) { //Si le ticket n'existe pas, on le crée
		$sql_ticket="INSERT INTO ".$tblpref."ticket(name,user_in_charge,soc,date_due,note,user_creator,date_creation, name_contact, firstname_contact, tel_contact, mail_contact) VALUES ('$name_ticket','$user_ticket','$soc','$date_due_ticket_final','$note_internal','$user_creator',now(),'$name_contact','$firstname_contact','$tel_contact','$mail_contact')";
		$req_ticket=mysql_query($sql_ticket);
		
		$sql_num_ticket="SELECT rowid FROM ".$tblpref."ticket ORDER BY date_creation DESC LIMIT 1"; //On récupère l'id du ticket que l'on vient de créer
		$req_num_ticket=mysql_query($sql_num_ticket);
		$results_num_ticket=mysql_fetch_object($req_num_ticket);
		$num_ticket=$results_num_ticket->rowid;
	}
	
	if ($name_task != '') {
	
		if ($state_task == 1) { //Si la première tâche est cloturée, on insère le time_spent //1st CLOSE
			//On construit le timespent
			$time_spent=$time_spent_hours.':'.$time_spent_min.':00';
			$sql_task="INSERT INTO ".$tblpref."task(name,ticket_num,date_due,type,state,user_intervenant,user_creator,date_creation,time_spent,deplacement,tarif_special) VALUES ('$name_task','$num_ticket',now(),'$type_task','$state_task','$user_creator','$user_creator',now(),'$time_spent','$deplacement','$tarif_special')";
			$req_task=mysql_query($sql_task);
			
			if ($state_task2 == 1 && $name_task2 != '') { //Si la deuxième tache existe et qu'elle est cloturée, on l'insère avec time_spent // 2nd CLOSE
				//On construit le timespent
				$time_spent2=$time_spent_hours2.':'.$time_spent_min2.':00';
				$sql_task2="INSERT INTO ".$tblpref."task(name,ticket_num,date_due,type,state,user_intervenant,user_creator,date_creation,time_spent,deplacement,tarif_special) VALUES ('$name_task2','$num_ticket',now(),'$type_task2','$state_task2','$user_creator','$user_creator',now(),'$time_spent2','$deplacement2','$tarif_special2')";
				$req_task2=mysql_query($sql_task2);
			}
			else if ($state_task2 == 0 && $name_task2 != '') { //Sinon on l'insère avec les infos habituelle //2nd OPEN
				$sql_task2="INSERT INTO ".$tblpref."task(name,ticket_num,date_due,type,state,user_intervenant,user_creator,date_creation,deplacement,tarif_special) VALUES ('$name_task2','$num_ticket','$date_due_task2_final','$type_task2','$state_task2','$user_task2','$user_creator',now(),'$deplacement2','$tarif_special2')";
				$req_task2=mysql_query($sql_task2);
			}
		}
		
		else { //Sinon on insère la première tache sans timespent, à l'état ouvert, sans seconde tâche //1st OPEN
			$sql_task="INSERT INTO ".$tblpref."task(name,ticket_num,date_due,type,state,user_intervenant,user_creator,date_creation,deplacement,tarif_special) VALUES ('$name_task','$num_ticket','$date_due_task_final','$type_task','$state_task','$user_task','$user_creator',now(),'$deplacement','$tarif_special')";
			$req_task=mysql_query($sql_task);
			}
	}
}
else if(isset($_POST['submit_close_task'])) { //Si on a valider et cloturer, on clos tout.
	
	if ($new_or_existing == 1) { //Si le ticket n'existe pas, on le crée
		$sql_ticket="INSERT INTO ".$tblpref."ticket(name,user_in_charge,soc,date_due,note,user_creator,date_creation, name_contact, firstname_contact, tel_contact, mail_contact, state) VALUES ('$name_ticket','$user_ticket','$soc','$date_due_ticket_final','$note_internal','$user_creator',now(),'$name_contact','$firstname_contact','$tel_contact','$mail_contact', '1')";
		$req_ticket=mysql_query($sql_ticket);
		
		$sql_num_ticket="SELECT rowid FROM ".$tblpref."ticket ORDER BY date_creation DESC LIMIT 1"; //On récupère l'id du ticket que l'on vient de créer
		$req_num_ticket=mysql_query($sql_num_ticket);
		$results_num_ticket=mysql_fetch_object($req_num_ticket);
		$num_ticket=$results_num_ticket->rowid;
	}
	
	if ($name_task != '') {
	
		if ($state_task == 1) { //Si la première tâche est cloturée, on insère le time_spent //1st CLOSE
			//On construit le timespent
			$time_spent=$time_spent_hours.':'.$time_spent_min.':00';
			$sql_task="INSERT INTO ".$tblpref."task(name,ticket_num,date_due,type,state,user_intervenant,user_creator,date_creation,time_spent,deplacement,tarif_special) VALUES ('$name_task','$num_ticket',now(),'$type_task','$state_task','$user_creator','$user_creator',now(),'$time_spent','$deplacement','$tarif_special')";
			$req_task=mysql_query($sql_task);
			
			if ($state_task2 == 1 && $name_task2 != '') { //Si la deuxième tache existe et qu'elle est cloturée, on l'insère avec time_spent // 2nd CLOSE
				//On construit le timespent
				$time_spent2=$time_spent_hours2.':'.$time_spent_min2.':00';
				$sql_task2="INSERT INTO ".$tblpref."task(name,ticket_num,date_due,type,state,user_intervenant,user_creator,date_creation,time_spent,deplacement,tarif_special) VALUES ('$name_task2','$num_ticket',now(),'$type_task2','$state_task2','$user_creator','$user_creator',now(),'$time_spent2','$deplacement2','$tarif_special2')";
				$req_task2=mysql_query($sql_task2);
			}
			else if ($state_task2 == 0 && $name_task2 != '') { //Sinon on l'insère avec les infos habituelle //2nd OPEN
				$sql_task2="INSERT INTO ".$tblpref."task(name,ticket_num,date_due,type,state,user_intervenant,user_creator,date_creation,deplacement,tarif_special,state) VALUES ('$name_task2','$num_ticket','$date_due_task2_final','$type_task2','$state_task2','$user_task2','$user_creator',now(),'$deplacement2','$tarif_special2','1')";
				$req_task2=mysql_query($sql_task2);
			}
		}
		
		else { //Sinon on insère la première tache sans timespent, à l'état ouvert, sans seconde tâche //1st OPEN
			$sql_task="INSERT INTO ".$tblpref."task(name,ticket_num,date_due,type,state,user_intervenant,user_creator,date_creation,deplacement,tarif_special,state) VALUES ('$name_task','$num_ticket','$date_due_task_final','$type_task','$state_task','$user_task','$user_creator',now(),'$deplacement','$tarif_special','1')";
			$req_task=mysql_query($sql_task);
			}
	}
}

//////////MAILING/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset ($user_creator)) {
	if ($user_creator != $user_ticket) {
		$sql1 ="SELECT email";
		$sql1.=" FROM ".$tblpref."user";
		$sql1.=" WHERE num='".$user_ticket."'";
		$rsql1=mysql_query($sql1);
		$obj1=mysql_fetch_object($rsql1);
		$mail_user1=$obj1->email;
		
		$headers ='From: "ERP FastITService"<info@fastitservice.be>'."\n";
		$headers .='Reply-To: info@fastitservice.be'."\n";
		$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
		$headers .='Content-Transfer-Encoding: 8bit';
		
		$message ='
		<div style="background-color:#00bce4; color:#FFF; padding:25px">
			<div style="background-color:#333; padding-top:5px; padding-bottom:5px">
				<center><h1>Nouveau Ticket : '.$name_ticket.'</h1></center>
			</div>
			<center>
			<div style="background-color:#333; padding:15px; border-top:5px dotted #00bce4; font-size:14pt">
				<div>Vous avez &eacute;t&eacute; d&eacute;sign&eacute; comme responsable d\'un nouveau ticket : '.$name_ticket.'</div> 
				<div>Connectez-vous pour plus d\'informations</div>
			</div>
			</center>
		</div>
		';
		
		mail(''.$mail_user1.'', 'Nouveau Ticket : '.$name_ticket, $message, $headers);
	}
}

if ($name_task != '') {
	if ($user_creator != $user_task) {
		$sql1 ="SELECT email";
		$sql1.=" FROM ".$tblpref."user";
		$sql1.=" WHERE num='".$user_task."'";
		$rsql1=mysql_query($sql1);
		$obj1=mysql_fetch_object($rsql1);
		$mail_user1=$obj1->email;
		
		$headers ='From: "ERP FastITService"<info@fastitservice.be>'."\n";
		$headers .='Reply-To: info@fastitservice.be'."\n";
		$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
		$headers .='Content-Transfer-Encoding: 8bit';
		
		$message ='
		<div style="background-color:#00bce4; color:#FFF; padding:25px">
			<div style="background-color:#333; padding-top:5px; padding-bottom:5px">
				<center><h1>Nouvelle T&acirc;che : '.$name_task.'</h1></center>
			</div>
			<center>
			<div style="background-color:#333; padding:15px; border-top:5px dotted #00bce4; font-size:14pt">
				<div>Vous avez &eacute;t&eacute; d&eacute;sign&eacute; comme responsable d\'une nouvelle t&acirc;che : '.$name_task.'</div> 
				<div>Connectez-vous pour plus d\'informations</div>
			</div>
			</center>
		</div>
		';
		
		mail(''.$mail_user1.'', 'Nouvelle tache : '.$name_task, $message, $headers);
	}
}

if (isset ($user_task2)) {
	if ($name_task2 != '') {
		if ($user_creator != $user_task2) {
		$sql1 ="SELECT email";
		$sql1.=" FROM ".$tblpref."user";
		$sql1.=" WHERE num='".$user_task2."'";
		$rsql1=mysql_query($sql1);
		$obj1=mysql_fetch_object($rsql1);
		$mail_user1=$obj1->email;
		
		$headers ='From: "ERP FastITService"<info@fastitservice.be>'."\n";
		$headers .='Reply-To: info@fastitservice.be'."\n";
		$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
		$headers .='Content-Transfer-Encoding: 8bit';
		
		$message ='
		<div style="background-color:#00bce4; color:#FFF; padding:25px">
			<div style="background-color:#333; padding-top:5px; padding-bottom:5px">
				<center><h1>Nouvelle T&acirc;che : '.$name_task2.'</h1></center>
			</div>
			<center>
			<div style="background-color:#333; padding:15px; border-top:5px dotted #00bce4; font-size:14pt">
				<div>Vous avez &eacute;t&eacute; d&eacute;sign&eacute; comme responsable d\'une nouvelle t&acirc;che : '.$name_task2.'</div> 
				<div>Connectez-vous pour plus d\'informations</div>
			</div>
			</center>
		</div>
		';
		
		mail(''.$mail_user1.'', 'Nouvelle tache : '.$name_task2, $message, $headers);	
		}
	}
}
///////////////////////////////////////////FIN MAILING////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($place == 'from_ticket_page') {
header('Location: ../../ticket.php?num_ticket='.$num_ticket.'');	
}
else {
header('Location: ../../list_task.php'); 
}
?>
