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
$client=isset($_POST['listeville'])?$_POST['listeville']:"";
$dateDeb=isset($_POST['dateDeb'])?$_POST['dateDeb']:"";
$dateFin=isset($_POST['dateFin'])?$_POST['dateFin']:"";
$dateDeb=dateEU_to_dateUSA($dateDeb);
$dateFin=dateEU_to_dateUSA($dateFin);

$message = "Maintenance créée";

$sql1 = "INSERT INTO " . $tblpref ."maintenance(Idcli, Datedeb, Datefin, Actif) VALUES ('$client', '$dateDeb', '$dateFin', 'oui')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

include_once("form_maintenance.php");
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>