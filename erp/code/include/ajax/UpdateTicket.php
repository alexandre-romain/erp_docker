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
	$date_due_ticket_correct=$jour."-".$mois."-".$annee;
	$value=$date_due_ticket_correct.' '.$heure;	
}

//on met a jour la table ticket

$sql= "UPDATE ".$tblpref."ticket SET ";

if ($columnId ==1) {$sql.="name";}
else if ($columnId ==2) {$sql.="soc";}
else if ($columnId ==3) {$sql.="date_due";}
else if ($columnId ==4) {$sql.="user_in_charge";}
else if ($columnId ==6) {$sql.="state";}	

$sql.=" ='$value' WHERE rowid=$rowid";

$req = mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');

echo $value;

if ($columnId ==2) {
	$sql="SELECT user_in_charge";
	$sql.=" FROM ".$tblpref."ticket";
	$sql.=" WHERE rowid=".$rowid."";
	$req=mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');
	$results=mysql_fetch_object($req);
	$user=$results->user_in_charge;
	if ($user != $current) {
		$sql1 ="SELECT email";
		$sql1.=" FROM ".$tblpref."user";
		$sql1.=" WHERE num='".$user."'";
		$rsql1=mysql_query($sql1) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql1.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');
		$obj1=mysql_fetch_object($rsql1);
		$mail_user1=$obj1->email;
		//On récupère les information nécessaire pour construire l'email
		$sql_ticket="SELECT t.name as tname, c.nom as cnom";
		$sql_ticket.=" FROM ".$tblpref."ticket as t";
		$sql_ticket.=" LEFT JOIN ".$tblpref."client as c ON c.num_client=t.soc";
		$sql_ticket.=" WHERE t.rowid=".$rowid."";
		$req_ticket=mysql_query($sql_ticket);
		$results_ticket=mysql_fetch_object($req_ticket);
		$name_ticket=$results_ticket->tname;
		$client_ticket=$results_ticket->cnom;
		//On construit le mail
		$headers ='From: "ERP FastITService"<info@fastitservice.be>'."\n";
		$headers .='Reply-To: info@fastitservice.be'."\n";
		$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
		$headers .='Content-Transfer-Encoding: 8bit';
		
		$message ='
		<div style="background-color:#00bce4; color:#FFF; padding:25px">
			<div style="background-color:#333; padding-top:5px; padding-bottom:5px">
				<center><h1>Changement d\'echeance : '.$name_ticket.'</h1></center>
			</div>
			<center>
			<div style="background-color:#333; padding:15px; border-top:5px dotted #00bce4; font-size:14pt">
				<div>L\'echeance du ticket "'.$name_ticket.'" &acirc; &eacute;t&eacute; modifi&eacute;e</div> 
				<div>La nouvelle &eacute;cheance &acirc; &eacute;t&eacute; fix&eacute;e au : <span style="color:#00bce4">'.$value.'</span></div>
			</div>
			</center>
		</div>
		';
		//On send
		mail(''.$mail_user1.'', 'Changement de Date Due Ticket', $message, $headers);	
	}
}
?>