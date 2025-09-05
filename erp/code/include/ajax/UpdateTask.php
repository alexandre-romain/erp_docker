<?php

include_once("../config/common.php");

//UpdateData.php
$rowid = $_REQUEST['id'] ;
$value = addslashes($_REQUEST['value']);
$columnId = $_REQUEST['columnId'] ; //id de la colonne de 0 à ...
$current = $_REQUEST['current'] ; //current_user

if ($columnId ==3) {
	//Convertion des dates au format mysql
	$dateduetemp = explode(' ',$value);
	$date = $dateduetemp[0];
	$heure = $dateduetemp[1];
	$datetemp = explode('-',$date);	
	$annee = $datetemp[0];
	$mois = $datetemp[1];
	$jour = $datetemp[2];
	$date_due_task_correct=$jour."-".$mois."-".$annee;
	$value=$date_due_task_correct.' '.$heure;	
}

//on met a jour la table task

$sql= "UPDATE ".$tblpref."task SET ";

if ($columnId ==1) {$sql.="name";}
else if ($columnId ==3) {$sql.="date_due";}
else if ($columnId ==4) {$sql.="user_intervenant";}
else if ($columnId ==5) {$sql.="ticket_num";}
else if ($columnId ==6) {$sql.="state";} //Valable pour la fiche ticket
else if ($columnId ==7) {$sql.="state";}


$sql.=" ='$value' WHERE rowid=$rowid";

$req = mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');

echo $value;
  
if ($columnId ==2) {
	$sql="SELECT user_intervenant";
	$sql.=" FROM ".$tblpref."task";
	$sql.=" WHERE rowid=".$rowid."";
	$req=mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');
	$results=mysql_fetch_object($req);
	$user=$results->user_intervenant;
	if ($user != $current) {
		$sql1 ="SELECT email";
		$sql1.=" FROM ".$tblpref."user";
		$sql1.=" WHERE num='".$user."'";
		$rsql1=mysql_query($sql1) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql1.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');
		$obj1=mysql_fetch_object($rsql1);
		$mail_user1=$obj1->email;
		//On récupère les information nécessaire pour construire l'email
		$sql_task =" SELECT t.name as tname, c.nom as cnom";
		$sql_task.=" FROM ".$tblpref."task as t";
		$sql_task.=" LEFT JOIN ".$tblpref."ticket as ti ON ti.rowid=t.ticket_num";
		$sql_task.=" LEFT JOIN ".$tblpref."client as c ON c.num_client=ti.soc";
		$sql_task.=" WHERE t.rowid=".$rowid."";
		$req_task=mysql_query($sql_task);
		$results_task=mysql_fetch_object($req_task);
		$client_task=$results_task->cnom;
		$name_task=$results_task->tname;
		//On construit le mail
		$headers ='From: "ERP FastITService"<info@fastitservice.be>'."\n";
		$headers .='Reply-To: info@fastitservice.be'."\n";
		$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
		$headers .='Content-Transfer-Encoding: 8bit';
		
		$message ='
		<div style="background-color:#00bce4; color:#FFF; padding:25px">
			<div style="background-color:#333; padding-top:5px; padding-bottom:5px">
				<center><h1>Changement d\'echeance : '.$name_task.'</h1></center>
			</div>
			<center>
			<div style="background-color:#333; padding:15px; border-top:5px dotted #00bce4; font-size:14pt">
				<div>L\'echeance de la t&acirc;che "'.$name_task.'" &acirc; &eacute;t&eacute; modifi&eacute;e</div> 
				<div>La nouvelle &eacute;cheance &acirc; &eacute;t&eacute; fix&eacute;e au : <span style="color:#00bce4">'.$value.'</span></div>
			</div>
			</center>
		</div>
		';
		//On send
		mail(''.$mail_user1.'', 'Changement de Date Due Task', $message, $headers);	
	}
}


?>