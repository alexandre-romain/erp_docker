<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Rapport des maintenances</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body style="background-color:#bfbfbf; ">
<table>
<tr><td style="color:#FF0000 "><b><u>Attention au contrat de maintenances suivants:</u></b></td></tr>
<tr><td>&nbsp;</td></tr>


<br />
<?php
//Récupèration des données dans la base de données concernant les maintenances
$sql = "SELECT  * FROM " . $tblpref ."maintenance WHERE Actif='oui'";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

//récupèration de la date du jour
$anneejour = date('Y');
$moisjour = date('m');
$jourjour = date('d');
		
$datedujour = mktime (0,0,0,$moisjour,$jourjour,$anneejour);
$datedujour = intval ($datedujour);


while($data = mysql_fetch_array($req))
{

$id = $data['Id'];
$idclient = $data['Idcli'];

$datefin =$data['Datefin'];

$datefin1 = explode("-", $datefin);
		
$anneefin = intval ($datefin1[0]);
$moisfin = intval ($datefin1[1]);
$jourfin = intval ($datefin1[2]);
		
		
$datefincontrat = mktime (0, 0, 0, $moisfin, $jourfin, $anneefin);
$datefincontrat = intval($datefincontrat);
$datedelais = $datefincontrat-1296000;

$sql1 = "SELECT  * FROM " . $tblpref ."client WHERE num_client=$idclient";
$req1 = mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
$data1 = mysql_fetch_array($req1);

$nomclient = $data1['nom'];


if ($datedelais <=  $datedujour)
{
?>
<tr>
<td>
	Le contrat de <?php echo($nomclient); ?> arrive à expiration le <?php echo($datefin); ?>, pense à le renouveler Chef ;o)
</td>
</tr>
<?php	
}


}



?>
</table>

</body>
</html>
