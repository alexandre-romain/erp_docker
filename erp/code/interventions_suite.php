<?php 
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
$heure_debut = isset($_POST['heure_debut'])?$_POST['heure_debut']:"";
$heure_fin = isset($_POST['heure_fin'])?$_POST['heure_fin']:"";
$cause = isset($_POST['cause'])?$_POST['cause']:"";
$detail = isset($_POST['detail'])?$_POST['detail']:"";
$coment = isset($_POST['coment'])?$_POST['coment']:"";
$deplacement = isset($_POST['deplacement'])?$_POST['deplacement']:"";
$tarif_special = isset($_POST['tarif_special'])?$_POST['tarif_special']:"";
$nbtrav = isset($_POST['nombreTrav'])?$_POST['nombreTrav']:"";
$client_num = isset($_POST['client_num'])?$_POST['client_num']:"";
$num_inter = isset($_POST['num_inter'])?$_POST['num_inter']:"";
$abo = isset($_POST['abo'])?$_POST['abo']:"";

//vérification que le contrat de maintenance est tjs actif!

$sql5 = "SELECT  * FROM " . $tblpref ."maintenance WHERE Idcli = $client_num  And Actif ='oui'";
$req5 = mysql_query($sql5) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data5 = mysql_fetch_array($req5);

$datefinmaint = $data5['Datefin'];
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

$sql6 = "UPDATE " . $tblpref ."maintenance SET Actif = 'non' WHERE Idcli = $client_num";
$req6 = mysql_query($sql6) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

}

//si inter se passe un autre jour
$sql = "SELECT  date FROM " . $tblpref ."interventions WHERE num_inter = $num_inter";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
$date = $data['date'];
}

$jour = (int)substr($date, 8, 2);
$mois = (int)substr($date, 5, 2);
$annee = (int)substr($date, 0, 4);



if (strlen($heure_debut) == 4)
{
$zeroaajouter = 0;
$heure_debut = $zeroaajouter.$heure_debut;

}

if (strlen($heure_fin) == 4)
{
$zeroaajouter = 0;
$heure_fin = $zeroaajouter.$heure_fin;

}

$debut_h = (int)substr($heure_debut, 0, 2); //recupère string 'heures' du debut et force type integer pour mktime
$debut_m = (int)substr($heure_debut, 3, 2);

$fin_h = (int)substr($heure_fin, 0, 2);
$fin_m = (int)substr($heure_fin, 3, 2);

$timestamp_debut = mktime($debut_h, $debut_m, 0, $mois, $jour, $annee);
$timestamp_fin = mktime($fin_h, $fin_m, 0, $mois, $jour, $annee);

$coment = addslashes($coment);
$cause = addslashes($cause);
$detail = addslashes($detail);


		$sql = "UPDATE " . $tblpref ."interventions SET

				cause = '$cause',
				coment = '$coment',
				detail = '$detail',
				debut = '$timestamp_debut',
				fin = '$timestamp_fin',
				tarif_special = '$tarif_special',
				nbtrav = $nbtrav,			
				type_deplacement = '$deplacement'
				
				WHERE num_inter = $num_inter";
		mysql_query($sql) or die ("requete impossible - vérifier format de données.");
		$message = "<table width=\"100%\"><tr align=\"center\"><td><h2>Intervention enregistrée.</h2></td></tr></table>";

        if ($abo != "")
		{
		$sql = "UPDATE " . $tblpref ."interventions SET
				fact = 'ok'
				WHERE num_inter = $num_inter";
		mysql_query($sql) or die ("ici - vérifier format de données.");
		$message = $message."<table width=\"100%\"><tr align=\"center\"><td><h2>Abonnement débité</h2></td></tr></table>";
		
		
		$sql2 = "SELECT * FROM " . $tblpref ."abos WHERE ID = $abo";
		$r2 = mysql_query($sql2) or die ("requete2 - vérifier format de données.");
		$rowcl2 = mysql_fetch_object($r2);
		$duree = ($timestamp_fin - $timestamp_debut)*$nbtrav; 
		$temps_restant = $rowcl2->temps_restant - ((int)($duree/60)); // ici non plus temps_restant est en minutes dans database
		
			if ($temps_restant <= 0)
			{
			$sql3 = "UPDATE " . $tblpref ."abos SET
				actif = 'non'
				WHERE ID = $abo";
			mysql_query($sql3) or die ("requete3 impossible - vérifier format de données.");
			$message = $message."<table width=\"100%\"><tr align=\"center\"><td><h2>Abonnement terminé !!</h2></td></tr></table>";
			}
		
			if ($type_deplacement != '0')
			{
			$sql3 = "UPDATE " . $tblpref ."abos SET
					temps_restant = '$temps_restant', deplacements_restant = (deplacements_restant - 1)
					WHERE ID = $abo";
			mysql_query($sql3) or die ("requete3 impossible - vérifier format de données.");
			
				// on vérifie qu'il restait au moins 1  déplacement dans l'abo. Si pas, on crée une inter avec u déplacement qui devra etre facturée
				$sql2 = "SELECT * FROM " . $tblpref ."abos WHERE ID = $abo";
				$r2 = mysql_query($sql2) or die ("requete2 - vérifier format de données.");
				$data2 = mysql_fetch_array($r2);
				
				$depl_abo = $data2['deplacements_restant'];
				
				if ($depl_abo =='-1')
				{
				// on remet a 0 le nombre de déplacements				
				$sql3 = "UPDATE " . $tblpref ."abos SET
						deplacements_restant = '0'
						WHERE ID = $abo";
						mysql_query($sql3) or die ("requete3 impossible - vérifier format de données.");
				if ($deplacement !="0")
					{
					//on crée une inter rien que pour le déplacement pour facturation.
					$sql1 = "INSERT INTO " . $tblpref ."interventions(client_num, date, debut, fin, cause, detail, coment, type_deplacement, tarif_special,nbtrav) VALUES ('$client_num', '$annee-$mois-$jour', '$timestamp_debut', '$timestamp_debut', 'Déplacement hors abonnement', 'En rapport à Intervention $num_inter', 'Votre abonnement ne compte plus de déplacements. Ce bon vous sera facturé séparément', '$deplacement', '$tarif_special',$nbtrav)";
					mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
					}
				}
				
			}
			else
			{
			$sql3 = "UPDATE " . $tblpref ."abos SET
					temps_restant = '$temps_restant'
					WHERE ID = $abo";
			mysql_query($sql3) or die ("requete3 impossible - vérifier format de données.");			
			}	
		}


?>
<table class="page" width="760" align="center">
<tr><td>
<?php 
include_once("lister_interventions.php");
?></center></td></tr>
</table>

</body>
</html>