<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
include_once("include/head.php");
$user = $_SERVER[PHP_AUTH_USER]; //login dans cette variable
//On inclus le footer apres la récupération de la variable $user; pour pouvoir la récupérer
include_once("include/elements/footer.php");
if ($message !='') { 
	echo"<table width=\"100%\"><tr align=\"center\"><td><h2>".$message."</h2></td></tr></table>";  
}
$rqSql = "SELECT num_client, nom FROM " . $tblpref ."client WHERE actif != 'non'";
$result = mysql_query( $rqSql ) or die( "Exécution requête impossible.");

$rqSql2 = "SELECT * FROM " . $tblpref ."tarifs";
$result2 = mysql_query( $rqSql2 ) or die( "Exécution requête2 impossible.");

$annee = date("Y");
$mois = date("m");
$jour = date("d");
?> 
<br/>
<form name="formu" method="post" action="maintenance_listing.php" >
<center>
<table class="main_table">
    <tr>
    	<td class="main_table_header" colspan="2">Recherche d'un contrat de maintenance</td>
    </tr>
    <tr> 
        <td class="main_table">Client :</td>
        <td class="main_table"> 
        	<?php 
			require_once("include/configav.php");
			if ($liste_cli!='y') { 
				$rqSql="$rqSql order by nom";
				$result = mysql_query( $rqSql ) or die( "Exécution requête impossible.");
 				?>
            	<SELECT NAME='listeville'>
                	<OPTION VALUE='0'><?php echo $lang_choisissez; ?></OPTION>
                	<?php
                	while ( $row = mysql_fetch_array( $result)) {
						$numclient = $row["num_client"];
						$nom = $row["nom"];
						?>
                		<OPTION VALUE='<?php echo $numclient; ?>'><?php echo $nom; ?></OPTION>
                	<?php 
					}
					?>
              	</SELECT> 
         	<?php 
			}
			else {
				include_once("include/choix_cli.php");
			} 
			?>
     	</td>
    </tr>		  
    <tr> 
        <td class="main_table_header" colspan="2"><input type="submit" name="Submit" value="Rechercher" class="submit"></td>
  	</tr>
</table>
</center>
</form>
<?php
//vérification que le contrat de maintenance n'est pas dépassé!
$sql2 = "SELECT  * FROM " . $tblpref ."maintenance WHERE Actif ='oui'";
$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
while($data2 = mysql_fetch_array($req2))
{
	$datefinmaint = $data2['Datefin'];
	$idmaintenance = $data2['Id'];	
	$annee2 = date("Y");
	$mois2 = date("m");
	$jour2 = date("d");	
	$datedujour = $annee2;
	$datedujour .= "-";
	$datedujour .= $mois2;
	$datedujour .= "-";
	$datedujour .= $jour2;	
	if ($datefinmaint < $datedujour)
	{
		$sql3 = "UPDATE " . $tblpref ."maintenance SET Actif = 'non' WHERE Id = $idmaintenance";
		$req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());
	}
}
?> 