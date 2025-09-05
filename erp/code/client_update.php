<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
$num=isset($_POST['num'])?$_POST['num']:"";
$civ=isset($_POST['civ'])?$_POST['civ']:"";
$nom=isset($_POST['nom'])?$_POST['nom']:"";
$nom=addslashes($nom);
$nom_sup=isset($_POST['nom_sup'])?$_POST['nom_sup']:"";
$nom_sup=addslashes($nom_sup);
$rue=isset($_POST['rue'])?$_POST['rue']:"";
$rue=addslashes($rue);
$numero=isset($_POST['numero'])?$_POST['numero']:"";
$boite=isset($_POST['boite'])?$_POST['boite']:"";
$code_post=isset($_POST['code_post'])?$_POST['code_post']:"";
$ville=isset($_POST['ville'])?$_POST['ville']:"";
$num_tva=isset($_POST['num_tva'])?$_POST['num_tva']:"";
$tel=isset($_POST['tel'])?$_POST['tel']:"";
$gsm=isset($_POST['gsm'])?$_POST['gsm']:"";
$fax=isset($_POST['fax'])?$_POST['fax']:"";
$mail_cli=isset($_POST['mail'])?$_POST['mail']:"";

if($nom=='' || $rue=='' || $ville=='' || $code_post=='' || $num_tva=='') {
	$message = $lang_oubli_champ;
	include('form_client.php'); // On inclus le formulaire d'identification
	exit;
}

$sql2 = "UPDATE " . $tblpref ."client SET boite='" . $boite . "', numero='" . $numero . "', fax='" . $fax . "', tel='" . $tel . "', gsm='" . $gsm . "', civ='" . $civ . "', nom='" . $nom . "', mail='" . $mail_cli . "', num_tva='" . $num_tva . "', nom2='" . $nom_sup . "', rue='" .$rue . "', ville='" . $ville . "', cp='" . $code_post . "' WHERE num_client = '" . $num . "'";
mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");

$message= "$lang_cli_jour";

include("form_client.php");
?>