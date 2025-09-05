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
$sql = "SELECT i.nom as inom, it.descr as itdescr, c.nom as snom, u.login as ulogin, it.name as itname, it.date_debut as itdatedebut, it.date_fin as itdatefin, i.fk_createur as icreateur, i.rowid as irowid, it.etat as itetat, it.time_spent as time_spent";
$sql .= " FROM ".$tblpref."inter as i";
$sql .= " LEFT JOIN ".$tblpref."inter_tache as it ON it.fk_inter = i.rowid ";
$sql .= " LEFT JOIN ".$tblpref."user as u ON u.num = i.fk_createur ";
$sql .= " LEFT JOIN ".$tblpref."client as c ON c.num_client = i.fk_soc ";
$sql .= " WHERE it.rowid='$rowid'";
$reqsql= mysql_query($sql);
$result= mysql_fetch_object($reqsql);
$nom=$result->itname;
$descr=$result->itdescr;
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
			@import "include/css/interventions.css";
</style>
</head>
<body>
<?php
//INSERTION DU MENU "ONGLETS"
echo $menu;

?>
</br>
</br>
<table class="info"width="100%">
<tr><td class="intitule">Client</td><td colspan='3' class="contenu"><?php echo $result->snom; ?></td></tr>
<tr><td class="intitule">Nom de la t&acirc;che</td><td colspan='3' class="contenu"><?php echo $nom; ?></td></tr>
<tr><td class="intitule">Description</td><td colspan='3' class="contenu"><?php echo $descr; ?></td></tr>
<tr><td class="intitule">Date de d&eacute;but</td><td class="contenu1"><?php echo $datedebutcorrect; ?></td><td class="intitule">Date de fin pr&eacute;vue</td><td class="contenu"><?php echo $datefincorrect; ?></td></tr>
</table>
<br />
<table class="info" width="100%">
<tr><td class="intitule">Intervention parente</td><td colspan='3' class="contenu"><a href='./ficheinter_inter.php?rowid=<?php echo $result->irowid; ?>'><?php echo $result->inom; ?></a></td></tr>
</table>
<br/>
<br/>
<br/>
<br/>
<br/>
<table class="info">
<tr><td class="intitule">Temps de travail actuel</td><td colspan="2" class="contenu"><?php echo $result->time_spent; ?></td></tr>
<tr><td class="intitule">Ajouter du Temps de travail</td>
<td class="contenu">
<form id="add_time_spent" action="include/ajax/AddTime.php" title="Ajouter du temps de travail">
<select name="hours" id="hours">
<option value=0>0</option>
<option value=1>1</option>
<option value=2>2</option>
<option value=3>3</option>
<option value=4>4</option>
<option value=5>5</option>
<option value=6>6</option>
<option value=7>7</option>
<option value=8>8</option>
<option value=9>9</option>
</select> H

<select name="min" id="min">
<option value=0>0</option>
<option value=5>5</option>
<option value=10>10</option>
<option value=15>15</option>
<option value=20>20</option>
<option value=25>25</option>
<option value=30>30</option>
<option value=35>35</option>
<option value=40>40</option>
<option value=45>45</option>
<option value=50>50</option>
<option value=55>55</option>
</select> min
<input type="hidden" name="time_spent" id="time_spent" value="<?php echo $result->time_spent; ?>"/>
<input type="hidden" name="fk_task" id="fk_task" value="<?php echo $rowid; ?>"/>
<input type="hidden" name="place" id="place" value="fiche"/>
<input type="submit" value="Valider" name="submit_time_spent" id="submit_time_spent"/>
</form>
</td>
</tr>
</table>

</body>
<?php
//Footer
llxFooter();
$db->close();
?>