<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/".$lang.".php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");			
include_once("include/head.php");
//Récupération du header et du footer + variable déclarée dans ttes pages doli (à test)
require_once("./menu.php");
//recuperation de l'id Intervention
$rowid = addslashes($_REQUEST['rowid']);
//Déclaraton de la variable menu et passage du rowid
$menu = affiche_menu($rowid);
//Requète de récupération des infos nécessaire pour populer le tableau d'inter
$sql = "SELECT i.nom as inom, i.descr as idescr, i.date_debut as idate_debut, i.date_fin as idate_fin, s.nom as snom, u.login as ulogin ";
$sql .= " FROM ".$tblpref."inter as i";
$sql .= " LEFT JOIN ".$tblpref."inter_tache as it ON it.fk_inter = i.rowid ";
$sql .= " LEFT JOIN ".$tblpref."user as u ON u.num = i.fk_createur ";
$sql .= " LEFT JOIN ".$tblpref."client as s ON s.num_client = i.fk_soc ";
$sql .= " WHERE i.rowid='$rowid'";
$reqsql= mysql_query($sql);
$result= mysql_fetch_object($reqsql);
//Récupération des informations du BL lié à l'inter
$sql_recup=" SELECT num_bl, fk_inter";
$sql_recup.=" FROM ".$tblpref."bl";
$sql_recup.=" WHERE fk_inter='".$rowid."'";
$req_sql_recup=mysql_query($sql_recup);
$result_sql_recup=mysql_fetch_object($req_sql_recup);
//création de la variable contenant le numero de BL
$num_bl=$result_sql_recup->num_bl;
?>
<head>

<?php
//INSERTION DU MENU "ONGLETS"
echo $menu;

//CREATION DU TABLEAU INTER
print '</br>';
print '</br>';
print '<table class="info">';
print "<tr><td class='intitule'>Client</td><td class='contenu'>".$result->snom."</td></tr>";
print "<tr><td class='intitule'>Nom de l'intervention</td><td class='contenu'>".stripslashes($result->inom)."</td></tr>";
print "<tr><td class='intitule'>Date de d&eacute;but</td><td class='contenu'>".$result->idate_debut."</td></tr>";
print "<tr><td class='intitule'>Date de fin pr&eacute;vue</td><td class='contenu'>".$result->idate_fin."</td></tr>";
print "<tr><td class='intitule'>Responsable intervention</td><td class='contenu'>".$result->ulogin."</td></tr>";

print '</table>';
?>

<!---Import de la feuille de style css des onglets + Datatables-->
<style type="text/css" media="screen">
			@import "include/css/onglets_inter.css";
			@import "include/css/demo_table_jui.css";
			@import "include/css/jquery-ui-1.7.2.custom.css";
			@import "include/css/interventions.css";
</style>
<!--Insertion du DataTables-->
<!-- Datatables Editable plugin -->
<script type="text/javascript" src="include/js/autocomplete.js"></script>
<script type="text/javascript" src="include/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="include/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="include/js/jquery.dataTables.editable.redirect.js"></script>
<script type="text/javascript" src="include/js/jquery.jeditable.js"></script>
<script type="text/javascript" src="include/js/jquery-ui.js"></script>
<script type="text/javascript" src="include/js/jquery.validate.js"></script>
<script type="text/javascript" src="include/js/datepicker.js"></script>
<!-- Auto-Complete -->	
<!-- DT antivirus -->
<script type="text/javascript" charset="utf-8">		
$(document).ready( function () {
<!--var id = -1;//simulation of id -->
// select everything when editing field in focus		
$('#antivirus').dataTable({
bJQueryUI: true,
"sPaginationType": "full_numbers"
}).makeEditable({		
"aoColumns": 
[
 //liste des colonnes avec leur comportement respectif + eventuellement style via CSS	
	//Nom
	null,
	//Référence
	null,
	//Nombre d'article
	null,
	//Prix Unitaire
	null,
	//Prix Total
	null
],							
});
});
</script>
</head>
<body>


<!--INSERTION DATATABLES -->

<!-- fin du bouton ajouter  -->

<!-- On descend la liste d'une ligne pour centrage  -->
<br/>
<!-- On descend la liste d'une ligne pour centrage  -->
<div id="types" class="art-postheader" align="center"><h1>Liste de l'ensemble du Mat&eacute;riel li&eacute; &acirc; l'intervention</h1></div>
<br/>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="antivirus">
<thead>
    <tr>
        <th>Nom</th>
        <th>PartNumber</th>
        <th>T&acirc;che li&eacute;e</th>
        <th>Nombre</th>
        <th>Prix Unitaire (HT)</th>
        <th>Prix Total (HT)</th>
    </tr>
</thead>

<tbody>
    
<!-- création du contenu de la table sur base des enregistrements db -->
<?php
$sql = "SELECT a.article as plabel, a.reference as aref, cb.quanti as ipnbr, cb.p_u_jour as ipprice, cb.num as iprowid, cb.fk_task, it.rowid as itrowid, it.name as itname";
$sql .= " FROM ".$tblpref."cont_bl as cb";
$sql .= " LEFT JOIN ".$tblpref."article as a ON a.num=cb.article_num ";
$sql .= " LEFT JOIN ".$tblpref."inter_tache as it ON it.rowid=cb.fk_task";
$sql .= " WHERE cb.bl_num='".$num_bl."'";

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
                            print '<td align="center">'.$obj->aref.'</td>';
							print '<td align="center"><a href="./fichetask_task.php?rowid='.$obj->itrowid.'">'.utf8_decode($obj->itname).'</a></td>';
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

<?php
//Footer
llxFooter();
$db->close();
?>