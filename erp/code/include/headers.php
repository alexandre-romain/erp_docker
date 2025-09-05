<?php
date_default_timezone_set('Europe/Paris');
require_once("./include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/configav.php");
include_once("include/fonctions.php");
include_once("include/config/var.php");
require ("include/del_pdf.php");
///RECUPERATION PAGE COURANTE.
//On récupère l'url
$url=$_SERVER['REQUEST_URI'];
//On explode l'url de manière à récupérer la page active
$tab=explode("/", $url);
$n=count($tab);
//On met le nom de cette page dans la variable $page
$page_inter=$tab[$n-1];
$inter=explode('?',$page_inter);
$page=$inter[0];
///FIN RECUPERATION PAGE COURANTE.
///RECUPERATION ID USER
$user = $_SERVER[PHP_AUTH_USER]; //login dans cette variable
//Récupération de l'id utilisiteur accédant à la page
$sql_user=" SELECT num, background";
$sql_user.=" FROM ".$tblpref."user";
$sql_user.=" WHERE login='".$user."'";
$req_user=mysql_query($sql_user);
$results_user=mysql_fetch_object($req_user);
$num_user=$results_user->num;
session_start();
$_SESSION['css']['background'] = $results_user->background;
///FIN RECUPERATION ID USER
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
    <title>Fast IT Service : Module de gestion intégrée</title>
    <link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico" >
    <link rel="stylesheet" type="text/css" href="include/css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="include/themes/<?php echo"$theme";?>/style.css">
    <link rel="stylesheet" type="text/css" href="include/font/font_awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="include/css/icons.css" />
	<link rel="stylesheet" type="text/css" href="include/css/menu.php" />
    <link rel="stylesheet" type="text/css" href="include/css/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="include/css/jquery-theme.css" />
    <link rel="stylesheet" type="text/css" href="include/css/dialog-confirm.css" />
    <!--<link rel="stylesheet" type="text/css" href="include/css/jquery.jeditable.datepicker.css" />-->
    <link rel="stylesheet" type="text/css" href="include/css/jquery-theme.css" />
    <script type="text/javascript" src="include/js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="include/js/jquery-ui-1.10.4.custom.js"></script>
    <script type="text/javascript" src="include/js/jquery.dataTables-1.10.6.min.js"></script>
    <script type="text/javascript" src="include/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript" src="include/js/dataTables.editor.min.js"></script>
    <script type="text/javascript" src="include/js/jquery.jeditable.js"></script>
    <script type="text/javascript" src="include/js/jquery-ui-timepicker-addon.js"></script>
    <script type="text/javascript" src="include/js/jquery.jeditable.datepicker.js"></script>
    <script type="text/javascript" src="include/js/jquery.form.js"></script>
    <script type="text/javascript" src="javascripts/confdel.js"></script>
    <script type="text/javascript" src="include/js/autocomplete.js"></script>
    <script type="text/javascript" src="include/js/jquery.validate.js"></script>	
    <script type="text/javascript" src="./include/js/confirm_freebie.js"></script>	
    <script src="include/js/modernizr.custom.js"></script>
