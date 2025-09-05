<?php
/////INFOS DE CONNEXION BDD + CONNEXION/////
$user= "hidden";//l'utilisateur de la base de données mysql
$pwd= "hidden";//le mot de passe à la base de données mysql
$db= "fastitservice";//le nom de la base de données mysql
$host= "gestion";//l'adresse de la base de données mysql 
$default_lang= "fr";//la langue de l'interface et des factures : voir la doc pour les abbréviations
$tblpref= "gestsprl_";//prefixe des tables 
mysql_connect($host,$user,$pwd) or die ("serveur de base de données injoignable. Vérifiez dans /factux/include/common.php si $host est correct.");
mysql_select_db($db) or die ("La base de données est injoignable. Vérifiez dans /factux/include/common.php si $user, $pwd, $db sont exacts.");
/////FIN INFOS DE CONNEXION BDD + CONNEXION/////
?>