<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/".$lang.".php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");			
include_once("include/head.php");
require_once("./menu.php");
$flag = addslashes($_REQUEST['flag']); //récupération du flag après l'envoi de la facture de manière à afficher un message du type: "Votre facture à été traitée"
$num_fact = addslashes($_REQUEST['num_fact']);
$rowid = addslashes($_REQUEST['rowid']); //recuperation de l'id Intervention
//Déclaraton de la variable menu et passage du rowid
$menu = affiche_menu($rowid);
?>
<!---Import de la feuille de style css des onglets + Formulaire-->
<style type="text/css" media="screen">
			@import "./include/css/onglets_inter.css";
			@import "./include/css/interventions.css";
</style>
<?php
//INSERTION DU MENU "ONGLETS"
echo $menu;
//Requète de récupération des infos nécessaire pour populer le tableau d'inter
$sql = "SELECT i.nom as inom, i.descr as idescr, i.date_debut as idate_debut, i.date_fin as idate_fin, c.nom as snom, u.login as ulogin, i.fk_soc as ifk_soc ";
$sql .= " FROM ".$tblpref."inter as i";
$sql .= " LEFT JOIN ".$tblpref."inter_tache as it ON it.fk_inter = i.rowid ";
$sql .= " LEFT JOIN ".$tblpref."user as u ON u.num = i.fk_createur ";
$sql .= " LEFT JOIN ".$tblpref."client as c ON c.num_client = i.fk_soc ";
$sql .= " WHERE i.rowid=".$rowid."";
$reqsql= mysql_query($sql);
$result= mysql_fetch_object($reqsql);
$fk_soc=$result->ifk_soc;
/*//Requête permettant de savoir si le client dispose d'un contrat de maintenance
$sqlcontrat = "SELECT cm.deplacement as cmdep, cm.rowid as cmrowid";
$sqlcontrat .= " FROM ".$tblref."contrat_maintenance as cm";
$sqlcontrat .= " WHERE cm.fk_soc=".$fk_soc." AND cm.etat='a'";
$reqsqlcontrat= mysql_query($sqlcontrat);
$objcontrat= mysql_fetch_object($reqsqlcontrat);
$includedep=$objcontrat->cmdep;
//Condition permettant de savoir si le client est sous contrat de maintenance, de manière à lui facturer (ou non) la main d'oeuvre.
$souscontrat=$objcontrat->cmrowid;*/
//Requête pour récupérer le total du timespent
$sqlt = "SELECT TIME_TO_SEC(it.time_spent) as sectime";
$sqlt .= " FROM ".$tblpref."inter_tache as it";
$sqlt .= " WHERE it.fk_inter=".$rowid."";

$reqtimesql=mysql_query($sqlt);
	if ($reqtimesql)
	{
		$num = mysql_num_rows($reqtimesql);
		$i = 0;
		if ($num)
		{
			while ($i < $num)
			{
						$objtime = mysql_fetch_object($reqtimesql);
						
						if ($objtime)
						{
							$timeinter=$objtime->sectime;
							$timesec=$timesec+$timeinter;
							// You can use here results
							
						}	
				$i++;
			}
		}
	}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec / 3600);
$minutes=intval(($timesec % 3600) / 60);
$secondes=intval((($timesec % 3600) % 60));
// On calcule le prix théorique de la main d'oeuvre
$prixheures=$heures*60;
$prixminutes=$minutes*1;
$prixtotal=$prixheures+$prixminutes;

//On initialise les variable d'articles
$prixfinal=0;
$nbr_final=0;
// Requète pour récupérer le montant total des articles
$sql1 = "SELECT cb.tot_art_htva as price, cb.quanti as nbr";
$sql1 .= " FROM ".$tblpref."cont_bl as cb";
$sql1 .= " LEFT JOIN ".$tblpref."inter_tache as it ON it.rowid=cb.fk_task";
$sql1 .= " LEFT JOIN ".$tblpref."inter as i ON i.rowid=it.fk_inter";
$sql1 .= " WHERE i.rowid=".$rowid."";
	
	$reqsql=mysql_query($sql1);
	if ($reqsql)
	{
		$num = mysql_num_rows($reqsql);
		$i = 0;
		if ($num)
		{
			while ($i < $num)
			{
						$obj = mysql_fetch_object($reqsql);
						
						if ($obj)
						{
							$prixinter=$obj->price;
							$nbr_inter=$obj->nbr;
							$prixfinal=$prixfinal+$prixinter;
							$nbr_final=$nbr_final+$nbr_inter;
						}	
				$i++;
			}
		}
	}
	
//On calcule le montant total de l'intervention
$prixglobal=$prixtotal+$prixfinal;

// Tableau informatif/récapitulatif de l'inter
print '<br />';
print '<br />';
print '<table class="recap"width="60%">';
print "<tr class='title'><td colspan='2' class='title' align='center'>R&eacute;capitulatif Intervention</td></tr>";
print "<tr><td class='recap'>Client</td><td class='contenur'>".$result->snom."</td></tr>";
print "<tr><td class='recap'>Nom de l'intervention</td><td class='contenur'>".stripslashes($result->inom)."</td></tr>";
print "<tr><td class='recap'>Date de d&eacute;but</td><td class='contenur'>".$result->idate_debut."</td></tr>";
print "<tr><td class='recap'>Date de fin pr&eacute;vue</td><td class='contenur'>".$result->idate_fin."</td></tr>";
print "<tr><td class='recap'>Responsable intervention</td><td class='contenur'>".$result->ulogin."</td></tr>";
print "<tr><td class='recap'>Nombre Total Articles</td><td class='contenur'>".$nbr_final."</td></tr>";
print "<tr><td class='recap'>Montant Articles (HT)</td><td class='contenur'>&euro; ".$prixfinal."</td></tr>";
print "<tr><td class='recap'>Temps total main d'oeuvre</td><td class='contenur'>".$heures." heure(s) ".$minutes." minute(s)</td></tr>";
print "<tr><td class='recap'>Montant main d'oeuvre (HT)</td>";
if ($souscontrat==''){
print "<td class='contenur'>&euro; ".$prixtotal."</td></tr>";
}
else {
print "<td class='contenur'>Ce client possède un contrat de maintenance</td></tr>";
//Comme la main d'oeuvre n'est pas prise en compte, on recalcule le prix total HT
$prixglobal=$prixtotht;
}
print "<tr><td colspan='2' class='separateur'></td></tr>";
print "<tr><td class='recap'>Montant total(HT)</td><td class='contenur'>&euro; ".$prixglobal."</td></tr>";
$tva=($prixglobal/100)*21; //Calcul de la TVA (21%)
$prixglobalttc=$prixglobal+$tva; //Calcul du prix total TTC
$prixglobalttc=number_format($prixglobalttc,2);
print "<tr><td class='recap'>Montant total(TTC)</td><td class='contenur'>&euro; ".$prixglobalttc."</td></tr>";
print '</table>';
?>