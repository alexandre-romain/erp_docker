<?php
include("../config/common.php");

$id = $_REQUEST['id'] ;
$value = $_REQUEST['value'] ;
$rowid = $_REQUEST['rowid'] ;
$current = $_REQUEST['current'] ;

if ($id == 'name') { //on update le name
	$sql="UPDATE ".$tblpref."task SET name='".$value."' WHERE rowid=".$rowid."";
	$req=mysql_query($sql);
}

else if ($id == 'tarif') { //on update le tarif
	$sql="UPDATE ".$tblpref."task SET tarif_special='".$value."' WHERE rowid=".$rowid."";
	$req=mysql_query($sql);
}

else if ($id == 'type') { //on update le type
	$sql="UPDATE ".$tblpref."task SET type='".$value."' WHERE rowid=".$rowid."";
	$req=mysql_query($sql);
}

else if ($id == 'deplacement') { //on update le deplacement
	$sql="UPDATE ".$tblpref."task SET deplacement='".$value."' WHERE rowid=".$rowid."";
	$req=mysql_query($sql);
}

else if ($id == 'timespent') { //on update le time
	$sql="UPDATE ".$tblpref."task SET time_spent='".$value."', time_spent_set_manual='1' WHERE rowid=".$rowid."";
	$req=mysql_query($sql);
}

else if ($id == 'user') { //on update le time
	$sql="UPDATE ".$tblpref."task SET user_intervenant='".$value."' WHERE rowid=".$rowid."";
	$req=mysql_query($sql);
}

else if ($id == 'date_due') { //on update le time
	$sql0="UPDATE ".$tblpref."task SET date_due='".$value."' WHERE rowid=".$rowid."";
	$req0=mysql_query($sql0);
	//Mailing
	$sql="SELECT user_intervenant";
	$sql.=" FROM ".$tblpref."task";
	$sql.=" WHERE rowid=".$rowid."";
	$req=mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');
	$results=mysql_fetch_object($req);
	$user=$results->user_intervenant;
	if ($user != $current) { //Si l'intervenant est différent de l'user actuel, on envoie un mail à l'intervenant. (Date echeance modifiée)
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
		//On défini le mail
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
				<div style="color:#FFF;">L\'echeance de la t&acirc;che "'.$name_task.'" &acirc; &eacute;t&eacute; modifi&eacute;e</div> 
				<div>La nouvelle &eacute;cheance &acirc; &eacute;t&eacute; fix&eacute;e au : <span style="color:#00bce4;">'.$value.'</span></div>
			</div>
			</center>
		</div>
		';
		//On send
		mail(''.$mail_user1.'',$client_task.' - '.$name_task.' : Changement d\'echeance', $message, $headers);	
	}
}
?>
<script>
location.reload() //On reload pour un affichage correct
</script>
