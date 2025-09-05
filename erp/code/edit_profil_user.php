<?php
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/".$lang.".php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");			
include_once("include/head.php");
//Récupération du login user
$user = $_SERVER[PHP_AUTH_USER];
//echo $user;
?>

CECI EST UNE PAGE EDIT PROFIL USER