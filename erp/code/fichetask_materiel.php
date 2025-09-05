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
$sql = "SELECT i.nom as inom, it.descr as itdescr, s.nom as snom, u.login as ulogin, it.name as itname, it.date_debut as itdatedebut, it.date_fin as itdatefin, i.fk_createur as icreateur, i.rowid as irowid ";
$sql .= " FROM ".$tblpref."inter as i";
$sql .= " LEFT JOIN ".$tblpref."inter_tache as it ON it.fk_inter = i.rowid ";
$sql .= " LEFT JOIN ".$tblpref."user as u ON u.num = i.fk_createur ";
$sql .= " LEFT JOIN ".$tblpref."client as s ON s.num_client = i.fk_soc ";
$sql .= " WHERE it.rowid='$rowid'";
$reqsql= mysql_query($sql);
$result= mysql_fetch_object($reqsql);
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

//Récupération de l'id inter
$fk_inter=$result->irowid;
//Récupération des informations du BL lié à l'inter
$sql_recup=" SELECT num_bl, fk_inter";
$sql_recup.=" FROM ".$tblpref."bl";
$sql_recup.=" WHERE fk_inter='".$fk_inter."'";
$req_sql_recup=mysql_query($sql_recup);
$result_sql_recup=mysql_fetch_object($req_sql_recup);
//création de la variable contenant le numero de BL
$num_bl=$result_sql_recup->num_bl;
?>
<head>
<!---Import de la feuille de style css des onglets + Datatables-->
<style type="text/css" media="screen">
			@import "include/css/onglets_inter.css";
			@import "include/css/demo_table_jui.css";
			@import "include/css/jquery-ui-1.7.2.custom.css";
			@import "include/css/interventions.css";
</style>
<!--Insertion du DataTables-->
<!-- Datatables Editable plugin -->
<script type="text/javascript" src="include/js/price_article_inter.js"></script>
<script type="text/javascript" src="include/js/autocomplete.js"></script>
<script type="text/javascript" src="include/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="include/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="include/js/jquery.dataTables.editable.js"></script>
<script type="text/javascript" src="include/js/jquery.jeditable.js"></script>
<script type="text/javascript" src="include/js/jquery-ui.js"></script>
<script type="text/javascript" src="include/js/jquery.validate.js"></script>
<script type="text/javascript" src="include/js/datepicker.js"></script>

<?php
//INSERTION DU MENU "ONGLETS"
echo $menu;

//CREATION DU TABLEAU INTER
print '</br>';
print '</br>';
print '<table class="info"width="100%">';
print "<tr><td class='intitule'>Nom de la t&acirc;che</td><td colspan='3' class='contenu'>".utf8_decode($result->itname)."</td></tr>";
print "<tr><td class='intitule'>Date de d&eacute;but</td><td class='contenu1'>".$datedebutcorrect."</td><td class='intitule'>Date de fin pr&eacute;vue</td><td class='contenu'>".$datefincorrect."</td></tr>";
//print "<tr><td>Date de fin pr&eacute;vue</td><td>".$result->idate_fin."</td></tr>";
print '</table>';
?>	
<!-- DT Matériel -->
<script type="text/javascript" charset="utf-8">		
$(document).ready( function () {
<!--var id = -1;//simulation of id -->
// select everything when editing field in focus		
$('#antivirus').dataTable({
bJQueryUI: true,
"sPaginationType": "full_numbers"
}).makeEditable({
sUpdateURL:"include/ajax/UpdateProductTache.php",
sAddURL: "include/ajax/AddProductTache.php",
sAddHttpMethod: "GET",
sDeleteHttpMethod: "GET",
sDeleteURL: "include/ajax/DeleteProductTache.php",
sAddNewRowButtonId: "btnAddNewRow1",
sDeleteRowButtonId: "btnDeleteRow1",		
sAddNewRowOkButtonId: "btnAddNewRowOk1",
sAddNewRowCancelButtonId: "btnAddNewRowCancel1",		
"aoColumns": 
[
 //liste des colonnes avec leur comportement respectif + eventuellement style via CSS
	
	//Nom
	null,
	//Référence
	null,
	//Nombre d'article
	{
		cssclass: "shortfield", //possibilités dans validate ligne 747
		sName: "nbr_product",
		className: "showCalendar",
		indicator: 'Enregistrement ...',
		tooltip: 'Double clic pour modifier la description',
		type: 'text' //possibilités : text, textarea ou select
	},
	//Prix Unitaire
	{
		cssclass: "shortfield", //possibilités dans validate ligne 747
		sName: "price",
		className: "showCalendar",
		indicator: 'Enregistrement ...',
		tooltip: 'Double clic pour modifier la description',
		type: 'text' //possibilités : text, textarea ou select
	},
	//Prix Total
	null
],
oAddNewRowButtonOptions: {	label: "Ajouter...",
icons: {primary:'ui-icon-plus'} 
},
oDeleteRowButtonOptions: {	label: "Supprimer", 
icons: {primary:'ui-icon-trash'}
},
oAddNewRowFormOptions: { 	
title: 'Ajouter un Produit',
//show: "blind", //saloperie qui empeche le curseur de rester en place ..
hide: "fade", //autre possibilité : explode
modal: true
},
sAddDeleteToolbarSelector: ".dataTables_length"								
});
});
</script>
</head>
<body>
<!--INSERTION DATATABLES -->
<form id="formAddNewRow" action="#" title="Ajouter un article" style="width:100px;min-width:100px;background-color:#FFF;">
    <br /><br />
    <label for="search_product"><i>Recherche Produit (nom ou partnumber)</i></label><br />
    <input type="text" size="25" id="search_product" name="search_product" onKeyUp="javascript:autosuggest('product')"  autocomplete="off" rel=""/><!--  champ texte à analyser pour les suggestions -->
    <br />
    <label for="fk_product">Produit</label><br />
    <select id="fk_product" name ="fk_product" rel="0" onChange="javascript:showprice()" onFocus="javascript:showprice()" onKeyup="javascript:showprice()"/>
    </select>
    <div id="div_price"></div>
    <label for="nbre">Nombre d'articles</label><br />
    <input type="text" size="25" id="nbre" name="nbre" autocomplete="off" rel="1" value="1"/>
    <br /><br />
    <input type="hidden" id="fk_task" name="fk_task" value="<?php echo $rowid;?>" rel="2" />
    <input type="hidden" id="fk_inter" name="fk_inter" value="<?php echo $result->irowid;?>" rel="3" />
    <button id="btnAddNewRowOk1" value="Ok">Ajouter</button>
    <button id="btnAddNewRowCancel1" value="Cancel">Supprimer</button>
</form>
<!-- fin du bouton ajouter  -->

<!-- On descend la liste d'une ligne pour centrage  -->
<br/>
<!-- On descend la liste d'une ligne pour centrage  -->
<div id="types" class="art-postheader" align="center"><h1>Liste du Mat&eacute;riel</h1></div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="antivirus">
<thead>
    <tr>
        <th>Nom</th>
        <th>PartNumber</th>
        <th>Nombre</th>
        <th>Prix Unitaire</th>
        <th>Prix Total</th>
    </tr>
</thead>

<tbody>
<button id="btnAddNewRow1" >Ajouter ...</button>
<button id="btnDeleteRow1" >Supprimer</button>       
<!-- création du contenu de la table sur base des enregistrements db -->
<?php
$sql = "SELECT a.article as plabel, a.reference as pref, cb.quanti as ipnbr, cb.p_u_jour as ipprice, cb.num as iprowid, cb.fk_task";
$sql .= " FROM ".$tblpref."cont_bl as cb";
$sql .= " LEFT JOIN ".$tblpref."article as a ON a.num=cb.article_num ";
$sql .= " WHERE cb.bl_num='".$num_bl."' AND cb.fk_task='".$rowid."'";

$resql=mysql_query($sql);
    if ($resql)
    {
        $num = mysql_num_rows($resql);
        $i = 0;
        if ($num)
        {
            while ($i < $num)
            {
                
                        $obj = mysql_fetch_object($resql);
                        echo '<tr class="odd_gradeX" id="'.$obj->iprowid.'">';
                        if ($obj)
                        {
							$nombre=$obj->ipnbr;
							$prix=$obj->ipprice;
							$prixtotal=$nombre*$prix;
							$prixformat= number_format ($prix,2);
                            // You can use here results
                            print '<td align="center">'.$obj->plabel.'</td>';
                            print '<td align="center">'.$obj->pref.'</td>';
                            print '<td align="center">'.$obj->ipnbr.'</td>';
                            print '<td align="center">'.$prixformat.'</td>';
                            print '<td align="center">'.$prixtotal.'</td>';
                        }
                        echo '</tr>';	
                $i++;
            }
        }
    }
?>
</tbody>
</table>

</body>