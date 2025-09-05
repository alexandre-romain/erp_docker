<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");?>
<script type="text/javascript" src="javascripts/confdel.js"></script>
<?php
include_once("include/finhead.php");
?>

<table width="760" border="0" class="page" align="center">
<tr>
<td class="page" align="center">
<?php
include_once("include/head.php");
?>
</td>
</tr>
<tr>
<td  class="page" align="center">
<?php


$idClient = isset($_POST['listeville'])?$_POST['listeville']:"";

$sql = "SELECT * FROM " . $tblpref ."interventions Where client_num = ".$idClient." and tarif_special = 5";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());


?>
<center><table class="boiteaction">
  <caption>Intervention de maintenance</caption>
  <tr>
  	<th>Num</th>
    <th>Client</th>
    <th>Date</th>
    <th>Durée</th>
	
    
	</tr>
  <?
	$nombre =1;
	$total_h = 0;
while($data = mysql_fetch_array($req))
    {
		$id = $data['num_inter'];
		$idcli = $data['client_num'];
		$date = $data['date'];
		$deb_inter = $data['debut'];
		$fin_inter = $data['fin'];
		
		// calcul de la durée! plus ajout au nombre total d'heure!
		$duree = ($fin_inter-$deb_inter)/3600;
		
		$total_h += $duree;
		
		//Mise en page de la durée d'intervention sous contrat de maintenance!
		$total_inter = explode (".",$duree);
		
		$heure = intval($total_inter[0]);
		// Multiplication des minutes par 60.
		$minute = "0.";
		$minute .= $total_inter[1];
		$minute = floatval($minute);
		$minute = $minute*60;
		$minute = intval ($minute);
		
		if($minute == 0)
		{
			$minute .= "0";
		}
		
		$sql2 = "SELECT * FROM " . $tblpref ."client WHERE num_client = '".$idcli."'";
		$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
		$data2 = mysql_fetch_array($req2);
  
  		$nom_client = $data2['nom'];

		
		
		
		$nombre = $nombre +1;
		if($nombre & 1){
		$line="0";
		}else{
		$line="1";
		}
		?>
  <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
  	
	<td class="highlight" align="center"><?php echo $id; ?></td>
    <td class="highlight" align="center"><?php echo $nom_client; ?></td>
    <td class="highlight" align="center"><?php echo $date; ?></td>
    <td class="highlight" align="center"><?php echo $heure ."h". $minute; ?></td>
	<td class="highlight"></td>
    
<?php
}


//Mise en page de la durée total d'intervention sous contrat de maintenance!
$total_inter = explode (".",$total_h);
		
$heure = intval($total_inter[0]);
// Multiplication des minutes par 60.
$minute = "0.";
$minute .= $total_inter[1];
$minute = floatval($minute);
$minute = $minute*60;
$minute = intval ($minute);
		
if($minute == 0)
		{
			$minute .= "0";
		}
 ?>
  </tr><td>&nbsp;</td><td><div align="left" style="font-size: 14px"><b>Total des heures sous contrat de maintenance :<span style="color:#FF0000 "> <?php echo("".$heure."".h."".$minute."");?></span></b></div></td>
  <tr>
	<TD colspan="12" class="submit"></TD></tr>
			</table></center><tr><td>
<?php
echo"</td></tr><tr><td>";
include_once("include/bas.php");
?>
</td></tr>
</table>
</table>
</body>
</html>
