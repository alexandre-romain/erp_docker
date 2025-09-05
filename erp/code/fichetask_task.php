<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/".$lang.".php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");			
include_once("include/head.php");
//Récupération du header et du footer + variable déclarée dans ttes pages doli (à test)
require_once("./menu_task.php");
//recuperation de l'id Intervention
$rowid = addslashes($_REQUEST['rowid']);
//Déclaraton de la variable menu et passage du rowid
$menu = affiche_menu($rowid);
 


//Requète de récupération des infos nécessaire pour populer le tableau d'inter
$sql = "SELECT i.nom as inom, it.descr as itdescr, c.nom as snom, u.login as ulogin, it.name as itname, it.date_debut as itdatedebut, it.date_fin as itdatefin, i.fk_createur as icreateur, i.rowid as irowid, it.etat as itetat ";
$sql .= " FROM ".$tblpref."inter as i";
$sql .= " LEFT JOIN ".$tblpref."inter_tache as it ON it.fk_inter = i.rowid ";
$sql .= " LEFT JOIN ".$tblpref."user as u ON u.num = i.fk_createur ";
$sql .= " LEFT JOIN ".$tblpref."client as c ON c.num_client = i.fk_soc ";
$sql .= " WHERE it.rowid='$rowid'";
$reqsql= mysql_query($sql);
$result= mysql_fetch_object($reqsql);
$nom=$result->itname;
$descr=$result->itdescr;
$fk_inter=$result->irowid;
//Convertion des dates en forme EU
$dateinter = explode ('-', $result->itdatedebut);
$annee = $dateinter[0];
$mois = $dateinter[1];
$jour = $dateinter[2];
$datedebutcorrect = $jour.'/'.$mois.'/'.$annee;

$dateinter = explode ('-', $result->itdatefin);
$annee = $dateinter[0];
$mois = $dateinter[1];
$jour = $dateinter[2];
$datefincorrect = $jour.'/'.$mois.'/'.$annee;
?>
<head>
<!---Import de la feuille de style css des onglets + Datatables-->
<style type="text/css" media="screen">
			@import "include/css/onglets_inter.css";
			@import "include/css/demo_table_jui.css";
			@import "include/css/jquery-ui-1.7.2.custom.css";	
			@import "include/css/actionboutons.css";
			@import "include/css/interventions.css";
</style>
</head>
<body>
<?php
//INSERTION DU MENU "ONGLETS"
echo $menu;

// Requête pour récupérer les noms des personnes en charge
//Récupération des 5rowid user
$idinter=$result->icreateur;
//Requêtes des logins
$sqllogininter = "SELECT u.login as ulogin";
$sqllogininter .=" FROM ".$tblpref."user as u";
$sqllogininter .=" WHERE u.num='$idinter'";
$querylogininter= mysql_query($sqllogininter);
$objlogininter= mysql_fetch_object($querylogininter);

//CREATION DU TABLEAU INTER
print '</br>';
print '</br>';
print '<table class="info" width="100%">';
print "<tr><td class='intitule'>Client</td><td colspan='3' class='contenu'>".utf8_decode($result->snom)."</td></tr>";
print "<tr><td class='intitule'>Nom de la t&acirc;che</td><td colspan='3' class='contenu'>".utf8_decode($nom)."</td></tr>";
print "<tr><td class='intitule'>Description</td><td colspan='3' class='contenu'>".stripslashes(utf8_decode($descr))."</td></tr>";
print "<tr><td class='intitule'>Date de d&eacute;but</td><td class='contenu1'>".$datedebutcorrect."</td><td class='intitule'>Date de fin pr&eacute;vue</td><td class='contenu'>".$datefincorrect."</td></tr>";
print "<tr><td class='intitule'>Etat de la t&acirc;che</td>";
//Affichage de l'état de la tâche
if ($result->itetat=='En Cours'){
print "<td colspan='3' class='contenu'>Ouverte</td>";	
}
else{
print "<td colspan='3' class='contenu'>Clotur&eacute;e</td>";	
}
print "</table>";
print "<br />";
//print "<tr><td colspan='4' height='15'></td></tr>";
print '<table class="info" width="100%">';
print "<tr><td class='intitule'>Intervention parente</td><td colspan='3' class='contenu'><a href='./ficheinter_inter.php?rowid=".$result->irowid."'>".$result->inom."</a></td></tr>";
print "<tr><td class='intitule'>Responsable intervention parente</td><td colspan='3' class='contenu'>".$objlogininter->ulogin."</td></tr>";
print '</table>';
print '<br/>';
print '<table width="100%"><tr class="boutons">';
//Bouton Clore/Ré-ouvrir la tâche
if ($result->itetat=='En Cours'){
print '<td class="left"><a href="include/ajax/close_task.php?rowid='.$rowid.'"><input type="button" value="Cl&ocirc;re la t&acirc;che" class="actionButton"></a></td>';
}
else {
print '<td class="left"><a href="include/ajax/open_task.php?rowid='.$rowid.'"><input type="button" value="R&eacute;-ouvrir la t&acirc;che" class="actionButton"></a></td>';	
}
print '<td class="right"><a href="./edit_task.php?rowid='.$rowid.'"><input type="button" value="Modifier" class="actionButton"></a>&nbsp;&nbsp;&nbsp;<a href="include/ajax/delete_task.php?rowid='.$rowid.'&fk_inter='.$fk_inter.'"><input type="button" value="Supprimer" class="actionButton"></a></td>';
print '</table></tr>';
?>
</body>