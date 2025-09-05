<?php
include("../config/common.php");
//Début Récuperation des données
$old_pass 					= addslashes($_REQUEST['old_pass']);
$new_pass 					= addslashes($_REQUEST['new_pass']);
$new_pass_confirm 			= addslashes($_REQUEST['new_pass_confirm']);
$user 						= addslashes($_REQUEST['user']);										

$sql="SELECT pwd";
$sql.=" FROM ".$tblpref."user";
$sql.=" WHERE num=".$user."";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
$pass_in_use=$obj->pwd;

$old_pass = Crypter($old_pass, $cle);

if ($pass_in_use == $old_pass) { //Si le mot de passe actuel est correct on continue
	if ($new_pass == $new_pass_confirm) { //Si le nouveau mdp et sa vérification correspondent on update
		$new_pass = Crypter($new_pass, $cle);
		$sql="UPDATE ".$tblpref."user SET pwd='".$new_pass."' WHERE num=".$user."";
		$req=mysql_query($sql);
		header('Location: ../../profil_user.php');
	}
	else { //Sinon on renvoie une erreur
		echo 'La vérification du nouveau mot de passe, ne correspond pas au nouveau mot de passe fourni.';
	}
}
else { //Sinon on informe l'user qu'il a fourni un mdp éronné
	echo 'Mot de passe éroné.';
}
?>								