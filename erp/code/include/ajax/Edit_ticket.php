<?php
include("../config/common.php");

$id = $_REQUEST['id'] ;
$value = $_REQUEST['value'] ;
$rowid = $_REQUEST['rowid'] ;
$current = $_REQUEST['current'] ;

$value = utf8_decode($value);

if ($id == 'name') { //on update le name
	$sql="UPDATE ".$tblpref."ticket SET name='".$value."' WHERE rowid=".$rowid."";
	$req=mysql_query($sql);
}

else if ($id == 'note') { //on update le tarif
	$sql="UPDATE ".$tblpref."ticket SET note='".$value."' WHERE rowid=".$rowid."";
	$req=mysql_query($sql);
}

else if ($id == 'user') { //on update le type
	$sql="UPDATE ".$tblpref."ticket SET user_in_charge='".$value."' WHERE rowid=".$rowid."";
	$req=mysql_query($sql);
}

else if ($id == 'date_due') { //on update le time
	$sql0="UPDATE ".$tblpref."ticket SET date_due='".$value."' WHERE rowid=".$rowid."";
	$req0=mysql_query($sql0);
	//Mailing
	$sql="SELECT user_in_charge";
	$sql.=" FROM ".$tblpref."ticket";
	$sql.=" WHERE rowid=".$rowid."";
	$req=mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');
	$results=mysql_fetch_object($req);
	$user=$results->user_in_charge;
	if ($user != $current) { //Si l'intervenant est différent de l'user actuel, on envoie un mail à l'intervenant.
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
		//On défini le mail
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
		mail(''.$mail_user1.'',$client_ticket.' - '.$name_ticket.' : Changement d\'echeance', $message, $headers);	
	}
}
?>
<script>
location.reload() //On reload pour un affichage correct
</script>
