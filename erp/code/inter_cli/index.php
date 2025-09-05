<?php
$res=0;
include("../../main.inc.php");
include("../include/config/connexion.php");

llxHeader('','Interventions Clients','');

$form=new Form($db);

?>

<head>
<!-- Import des feuilles de style -->
<style type="text/css" media="screen">
    @import "../include/css/index_inter.css";
</style>

<!-- Import des scripts -->
</head>

<body>

<!--- INTERVENTIONS CLOTUREES MAIS PAS ENCORE FACTUREE-->
<table class="gauche" cellspacing="0">
<thead>
	<tr>
    	<th colspan='4' class='title'>Intervention clotur&eacute;es mais pas factur&eacute;es</th>
    </tr>
    <tr>
        <th class="wscreen">Intervention</th>
        <th class="wscreen">Client</th>
        <th class="wscreen">Technicien en charge</th>
        <th class="wscreen">Date de d&eacute;but</th>
    </tr>
</thead>
<tbody>
<?php   
//Requêtes SQL destinées à populer les tableaux

//Requête de récupération des données destinées à peupler le tableau des inter cloturées mais non facturées
$sql_inter_non_facture=" SELECT i.nom as inom, i.date_debut as idatedebut, i.fk_createur as ifkcreateur, s.nom as snom, u.login as ulogin, i.rowid as irowid";
$sql_inter_non_facture.=" FROM ".$tblref."inter as i";
$sql_inter_non_facture.=" LEFT JOIN ".$tblref."societe as s ON s.rowid=i.fk_soc";
$sql_inter_non_facture.=" LEFT JOIN ".$tblref."user as u ON u.rowid=i.fk_createur";
$sql_inter_non_facture.=" WHERE i.facture='0' AND i.etat='Cloture'";
$sql_inter_non_facture.=" ORDER BY i.date_debut ASC";
$sql_inter_non_facture.=" LIMIT 10";
$req_inter_non_facture=mysql_query($sql_inter_non_facture);
//$result_inter_non_facture=mysql_fetch_object($req_inter_non_facture);

if ($req_inter_non_facture)
{
	$num = mysql_num_rows($req_inter_non_facture);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$result_inter_non_facture = mysql_fetch_object($req_inter_non_facture);
			print '<tr class="tligne">';
			if ($result_inter_non_facture)
			{
				//On transforme les dates
				$dateinter = $result_inter_non_facture->idatedebut;
				$datetemp = explode('-',$dateinter);
				$annee = $datetemp[0];
				$mois = $datetemp[1];
				$jour = $datetemp[2];
				$datecorrect=$jour."/".$mois."/".$annee;
				// On utilise les données récupérées
				print '<td class="wscreen"><a href="./ficheinter_inter.php?rowid='.$result_inter_non_facture->irowid.'">'.$result_inter_non_facture->inom.'</a></td>';
				print '<td class="wscreen">'.$result_inter_non_facture->snom.'</td>';
				print '<td class="wscreen">'.$result_inter_non_facture->ulogin.'</td>';
				print '<td class="wscreen">'.$datecorrect.'</td>';
				
			}
			print '</tr>';
			$i++;
		}
	}
}
?>
</tbody>
</table>

<!--- INTERVENTIONS OUVERTES LES PLUS ANCIENNES -->
<table class="droite" cellspacing="0">
<thead>
	<tr>
    	<th colspan='4' class='title'>Interventions ouvertes les plus anciennes</th>
    </tr>
    <tr>
        <th class="wscreen">Intervention</th>
        <th class="wscreen">Client</th>
        <th class="wscreen">Technicien en charge</th>
        <th class="wscreen">Date de d&eacute;but</th>
    </tr>
</thead>
<tbody>
<?php
//Requête de récupération des données destinées à peupler le tableau des inters ouvertes les plus anciennes
$sql_inter_open_old=" SELECT i.nom as inom, i.date_debut as idatedebut, i.fk_createur as ifkcreateur, s.nom as snom, u.login as ulogin, i.rowid as irowid";
$sql_inter_open_old.=" FROM ".$tblref."inter as i";
$sql_inter_open_old.=" LEFT JOIN ".$tblref."societe as s ON s.rowid=i.fk_soc";
$sql_inter_open_old.=" LEFT JOIN ".$tblref."user as u ON u.rowid=i.fk_createur";
$sql_inter_open_old.=" WHERE i.etat='En Cours'";
$sql_inter_open_old.=" ORDER BY i.date_debut ASC";
$sql_inter_open_old.=" LIMIT 10";
$req_inter_open_old=mysql_query($sql_inter_open_old);
//$result_inter_open_old=mysql_fetch_object($req_inter_open_old);

if ($req_inter_open_old)
{
	$num = mysql_num_rows($req_inter_open_old);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$result_inter_open_old = mysql_fetch_object($req_inter_open_old);
			print '<tr class="tligne">';
			if ($result_inter_open_old)
			{
				//On transforme les dates
				$dateinter = $result_inter_open_old->idatedebut;
				$datetemp = explode('-',$dateinter);
				$annee = $datetemp[0];
				$mois = $datetemp[1];
				$jour = $datetemp[2];
				$datecorrect=$jour."/".$mois."/".$annee;
				// On utilise les données récupérées
				print '<td class="wscreen"><a href="./ficheinter_inter.php?rowid='.$result_inter_open_old->irowid.'">'.$result_inter_open_old->inom.'</a></td>';
				print '<td class="wscreen">'.$result_inter_open_old->snom.'</td>';
				print '<td class="wscreen">'.$result_inter_open_old->ulogin.'</td>';
				print '<td class="wscreen">'.$datecorrect.'</td>';
				
			}
			print '</tr>';
			$i++;
		}
	}
}
?>
</tbody>
</table>


<!--- TACHES OUVERTES LES PLUS ANCIENNES -->
<table class="gauche" cellspacing="0">
<thead>
	<tr>
    	<th colspan='4' class='title'>T&acirc;ches ouvertes les plus anciennes</th>
    </tr>
    <tr>
        <th class="wscreen">T&acirc;che</th>
        <th class="wscreen">Intervention</th>
        <th class="wscreen">Technicien(s) en charge</th>
        <th class="wscreen">Date de d&eacute;but</th>
    </tr>
</thead>
<tbody>
<?php
//Requête de récupération des données destinées à peupler le tableau
$sql_task_open_old=" SELECT it.name as itname, it.date_debut as itdatedebut, it.fk_user1 as user1, it.fk_user2 as user2, it.fk_user3 as user3, i.nom as inom, u.login as ulogin, it.rowid as itrowid";
$sql_task_open_old.=" FROM ".$tblref."inter_tache as it";
$sql_task_open_old.=" LEFT JOIN ".$tblref."inter as i ON i.rowid=it.fk_inter";
$sql_task_open_old.=" LEFT JOIN ".$tblref."user as u ON u.rowid=it.fk_user1";
$sql_task_open_old.=" WHERE i.etat='En Cours'";
$sql_task_open_old.=" ORDER BY it.date_debut ASC";
$sql_task_open_old.=" LIMIT 10";
$req_task_open_old=mysql_query($sql_task_open_old);
//$result_task_open_old=mysql_fetch_object($req_task_open_old);
if ($req_task_open_old)
{
	$num = mysql_num_rows($req_task_open_old);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$result_task_open_old = mysql_fetch_object($req_task_open_old);
			print '<tr class="tligne">';
			if ($result_task_open_old)
			{
				//On transforme les dates
				$dateinter = $result_task_open_old->itdatedebut;
				$datetemp = explode('-',$dateinter);
				$annee = $datetemp[0];
				$mois = $datetemp[1];
				$jour = $datetemp[2];
				$datecorrect=$jour."/".$mois."/".$annee;
				// On utilise les données récupérées
				print '<td class="wscreen"><a href="./fichetask_task.php?rowid='.$result_task_open_old->itrowid.'">'.$result_task_open_old->itname.'</a></td>';
				print '<td class="wscreen">'.$result_task_open_old->inom.'</td>';
				print '<td class="wscreen">'.$result_task_open_old->ulogin.'</td>';
				print '<td class="wscreen">'.$datecorrect.'</td>';
				
			}
			print '</tr>';
			$i++;
		}
	}
}
?>
</tbody>
</table>


<!--- NOUVELLES TACHES -->
<table class="droite" cellspacing="0">
<thead>
	<tr>
    	<th colspan='4' class='title'>Nouvelles t&acirc;ches</th>
    </tr>
    <tr>
        <th class="wscreen">T&acirc;che</th>
        <th class="wscreen">Intervention</th>
        <th class="wscreen">Technicien(s) en charge</th>
        <th class="wscreen">Date de d&eacute;but</th>
    </tr>
</thead>
<tbody>
<?php
//Requête de récupération des données destinées à peupler le tableau
$sql_task_new=" SELECT it.name as itname, it.date_debut as itdatedebut, it.fk_user1 as user1, it.fk_user2 as user2, it.fk_user3 as user3, i.nom as inom, u.login as ulogin, it.rowid as itrowid";
$sql_task_new.=" FROM ".$tblref."inter_tache as it";
$sql_task_new.=" LEFT JOIN ".$tblref."inter as i ON i.rowid=it.fk_inter";
$sql_task_new.=" LEFT JOIN ".$tblref."user as u ON u.rowid=it.fk_user1";
$sql_task_new.=" ORDER BY it.date_debut DESC";
$sql_task_new.=" LIMIT 10";
$req_task_new=mysql_query($sql_task_new);

if ($req_task_new)
{
	$num = mysql_num_rows($req_task_new);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$result_task_new = mysql_fetch_object($req_task_new);
			print '<tr class="tligne">';
			if ($result_task_new)
			{
				//On transforme les dates
				$dateinter = $result_task_new->itdatedebut;
				$datetemp = explode('-',$dateinter);
				$annee = $datetemp[0];
				$mois = $datetemp[1];
				$jour = $datetemp[2];
				$datecorrect=$jour."/".$mois."/".$annee;
				// On utilise les données récupérées
				print '<td class="wscreen"><a href="./fichetask_task.php?rowid='.$result_task_new->itrowid.'">'.$result_task_new->itname.'</a></td>';
				print '<td class="wscreen">'.$result_task_new->inom.'</td>';
				print '<td class="wscreen">'.$result_task_new->ulogin.'</td>';
				print '<td class="wscreen">'.$datecorrect.'</td>';
				
			}
			print '</tr>';
			$i++;
		}
	}
}
?>
</tbody>
</table>
<?php
///Requête "stats" Footer
//Construction de la variable $date, servant de paramètre aux requêtes stats
$date= date("Y-m-d", strtotime("-1 month"));
//Requete de calcul du nombre d'inter ce mois-ci
$sql_nombre_inter="SELECT rowid";
$sql_nombre_inter.=" FROM dol_inter";
$sql_nombre_inter.=" WHERE date_debut > '".$date."' ";
$req_nombre_inter=mysql_query($sql_nombre_inter);
$nbr_nombre_inter=mysql_num_rows($req_nombre_inter);
//Requete de calcul du nombre de tâche ce mois-ci + temps de travail
$sql_nombre_task="SELECT rowid, TIME_TO_SEC(time_spent) as sectime";
$sql_nombre_task.=" FROM ".$tblref."inter_tache";
$sql_nombre_task.=" WHERE date_debut > '".$date."' ";
$req_nombre_task=mysql_query($sql_nombre_task);
$nbr_nombre_task=mysql_num_rows($req_nombre_task);
//On calcule le nombre d'heures passées sur les tâche ce mois-ci
if ($req_nombre_task)
{
	$num = mysql_num_rows($req_nombre_task);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$result_nombre_task = mysql_fetch_object($req_nombre_task);
			if ($result_nombre_task)
			{	
				$time_task=$time_task+$result_nombre_task->sectime;	
			}
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($time_task / 3600);
$minutes=intval(($time_task % 3600) / 60);
$secondes=intval((($time_task % 3600) % 60));
?>
<div id="zone_bottom" class="line_bottom">
<div id="nombre_inter_month" class="cadre_bot_top_left">&nbsp  Nombre d'interventions d&eacute;but&eacute;es ce mois-ci: <?php echo $nbr_nombre_inter; ?></div>
<div id="montant_inter_month" class="cadre_bot_bot_left">&nbsp  Montant total des interventions d&eacute;but&eacute;es ce mois-ci: <?php echo $user->id ?></div>
<div id="nombre_task_month" class="cadre_bot_top_right">&nbsp  Nombre de t&acirc;ches d&eacute;but&eacute;es ce mois-ci: <?php echo $nbr_nombre_task; ?></div>
<div id="heure_task_month" class="cadre_bot_bot_right">&nbsp  Nombre d'heures de travail sur les t&acirc;ches ce mois-ci: <?php echo $heures.'h '.$minutes.'min';?></div>
</div>


<?php
llxFooter();
$db->close();
?>