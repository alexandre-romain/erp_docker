<?php
include_once("include/config/common.php");

$user_login = $_SERVER[PHP_AUTH_USER];

$sqlz = "SELECT * FROM " . $tblpref ."user WHERE " . $tblpref ."user.login = '".$user_login."'";
$req = mysql_query($sqlz) or die('Erreur SQL !<br>'.$sqlz.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
	$user_num = $data['num'];
	$user_nom = $data["nom"];
	$user_prenom = $data["prenom"];
	$user_email = $data['email'];
	$user_fact = $data['fact'];
	$user_com = $data['com'];
	$user_dev = $data['dev'];
	$user_admin = $data['admin'];
	$user_dep = $data['dep'];
	$user_stat = $data['stat'];
	$user_art = $data['art'];
	$user_cli = $data['cli'];
}
	
$lang ="fr"
?>