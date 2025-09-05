<?php 
require_once("include/verif.php");
include_once("include/language/".$lang.".php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");			
include_once("include/head.php");
//Récupération des onglets
require_once("./menu.php");
//recuperation de l'id Intervention
$rowid = addslashes($_REQUEST['rowid']);
//Déclaraton de la variable menu et passage du rowid
$menu = affiche_menu($rowid);
$user = $_SERVER[PHP_AUTH_USER];
//echo $user;
//Requète de récupération des infos nécessaire pour populer le tableau d'inter
$sql = "SELECT i.nom as inom, i.descr as idescr, i.date_debut as idate_debut, i.date_fin as idate_fin, c.nom as snom, u.login as ulogin, i.etat as ietat ";
$sql .= " FROM ".$tblpref."inter as i";
$sql .= " LEFT JOIN ".$tblpref."user as u ON u.num = i.fk_createur ";
$sql .= " LEFT JOIN ".$tblpref."client as c ON c.num_client = i.fk_soc ";
$sql .= " WHERE i.rowid='$rowid'";
$reqsql= mysql_query($sql);
$result= mysql_fetch_object($reqsql);
//Convertion des dates en forme EU
$dateinter = explode ('-', $result->idate_debut);
$annee = $dateinter[0];
$mois = $dateinter[1];
$jour = $dateinter[2];
$datedebutcorrect = $jour.'/'.$mois.'/'.$annee;

$dateinter = explode ('-', $result->idate_fin);
$annee = $dateinter[0];
$mois = $dateinter[1];
$jour = $dateinter[2];
$datefincorrect = $jour.'/'.$mois.'/'.$annee;
?>
<!---Import de la feuille de style css des onglets + Datatables-->
<style type="text/css" media="screen">
			@import "include/css/onglets_inter.css";
			@import "include/css/actionboutons.css";
			@import "include/css/interventions.css";
</style>
<?php
//INSERTION DU MENU "ONGLETS"
echo $menu;
//CREATION DU TABLEAU INTER
print '</br>';
print '</br>';
print '<table width="80%" class="info">';
print "<tr><td class='intitule'>Client</td><td colspan='3' class='contenu'>".utf8_decode($result->snom)."</td></tr>";
print "<tr><td class='intitule'>Nom de l'intervention</td><td colspan='3' class='contenu'>".stripslashes(utf8_decode($result->inom))."</td></tr>";
print "<tr><td class='intitule'>Date de d&eacute;but</td><td width='150' class='contenu1'>".$datedebutcorrect."</td><td class='intitule'>Date de fin pr&eacute;vue</td><td class='contenu'>".$datefincorrect."</td></tr>";
print "<tr><td class='intitule'>Etat de l'intervention</td>";
//Affichage de l'état de la tâche
if ($result->ietat=='En Cours'){
print "<td colspan='3' class='contenu'>Ouverte</td>";	
}
else{
print "<td colspan='3' class='contenu'>Clotur&eacute;e</td>";	
}
print "</tr>";
print "<tr><td class='intitule'>Responsable intervention</td><td colspan='3' class='contenu'>".$result->ulogin."</td></tr>";
print "<tr><td rowspan='3' class='intitule'>Description</td><td colspan='3' rowspan='3' height='50' class='contenu'>".stripslashes(utf8_decode($result->idescr))."</td></tr>";
print "<tr></tr>";
print "<tr></tr>";
print '</table>';
print '<br/>';
print '<table width="100%" class="boutons"><tr class="boutons">';
//Affichage du bouton clore/reouvrir l'inter
if ($result->ietat=='En Cours'){
print '<td class="left"><a href="include/ajax/close_inter.php?rowid='.$rowid.'"><input type="button" value="Cl&ocirc;re l\'intervention" class="actionButton"></a></td>';
}
else {
print '<td class="left"><a href="include/ajax/open_inter.php?rowid='.$rowid.'"><input type="button" value="R&eacute;-ouvrir l\'intervention" class="actionButton"></a></td>';	
}
//Bouton MODIFIER et SUPPRIMER
print '<td class="right"><a href="./edit_inter.php?rowid='.$rowid.'"><input type="button" value="Modifier" class="actionButton"></a>&nbsp;&nbsp;&nbsp';
if ($user == 'alex') {
	print '<a href="include/ajax/delete_inter.php?rowid='.$rowid.'" onClick="return confirm( \'Confirmer la suppression?\')"><input type="button" value="Supprimer" class="actionButton"></a></td>';
}
else if ($user == 'christophe') {
	print '<a href="include/ajax/delete_inter.php?rowid='.$rowid.'" onClick="return confirm( \'Confirmer la suppression?\')"><input type="button" value="Supprimer" class="actionButton"></a></td>';
}
print '</table></tr>';
?>