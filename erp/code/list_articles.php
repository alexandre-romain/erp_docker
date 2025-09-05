<?php 
require_once("include/verif.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");			
include_once("include/head.php");
$user = $_SERVER[PHP_AUTH_USER]; //login dans cette variable
//On inclus le footer apres la récupération de la variable $user; pour pouvoir la récupérer
include_once("include/elements/footer.php");
?>
<head>
<style type="text/css" media="screen">
	@import "include/css/demo_table_jui.css";
	@import "include/css/jquery-ui-1.7.2.custom.css";
	@import "include/css/FormAddArticle.css";			

</style>

<!-- Datatables Editable plugin -->
<script type="text/javascript" src="include/js/jquery-1.10.0.js"></script>
<script type="text/javascript" src="include/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="include/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="include/js/jquery.dataTables.editable.js"></script>
<script type="text/javascript" src="include/js/jquery.jeditable.js"></script>
<script type="text/javascript" src="include/js/jquery-ui.js"></script>
<script type="text/javascript" src="include/js/jquery.validate.js"></script>		
<!-- Liste Intervention -->
<script type="text/javascript" charset="utf-8">
$(document).ready( function () {
<!--var id = -1;//simulation of id -->
$('#tableinter').dataTable({ 
bJQueryUI: true,
"sPaginationType": "full_numbers",
"aaSorting": []
}).makeEditable({
sUpdateURL:"include/ajax/UpdateListArticles.php",
sAddURL: "include/ajax/.php", // Pas d'ajout
sAddHttpMethod: "GET",
sDeleteHttpMethod: "GET",
sDeleteURL: "include/ajax/.php", // Pas de Delete
sAddNewRowButtonId: "btnAddNewRow1",
sDeleteRowButtonId: "btnDeleteRow1",		
sAddNewRowOkButtonId: "btnAddNewRowOk1",
sAddNewRowCancelButtonId: "btnAddNewRowCancel1",		
"aoColumns": 
[
 //liste des colonnes avec leur comportement respectif + eventuellement style via CSS
	
	//Date BDC
	null,
	//Client
	null,
	//Article
	null,
	//PartNumber
	null,
	//Quantité
	null,
	//Prix d'achat
	null,
	//Total Prix d'achat(htva) (calculé par pa*nbr)
	null,
	//Prix de vente unitaire
	null,
	//Prix de vente total
	null,
	//Commandé
	null,
	//Reçu
	{
		sName: "recu",
		indicator: 'Enregistrement ...',
		tooltip: 'Double clic pour modifier',
		loadtext: 'loading...',
		type: 'select',
		onblur: 'submit',
		data: "{'oui':'oui','non':'non'}"				
	},
	//Fournisseur
	{
		sName: "commande",
		indicator: 'Enregistrement ...',
		tooltip: 'Double clic pour modifier',
		loadtext: 'loading...',
		type: 'select',
		onblur: 'submit',
		data: "{'oui':'oui','non':'non'}"
	},
	//Note
	null
],
oAddNewRowButtonOptions: {	label: "Ajouter...",
icons: {primary:'ui-icon-plus'} 
},
oDeleteRowButtonOptions: {	label: "Supprimer", 
icons: {primary:'ui-icon-trash'}
},

oAddNewRowFormOptions: { 	
title: 'Ajouter un Nom de Domaine',
//show: "blind", //saloperie qui empeche le curseur de rester en place ..
hide: "fade", //autre possibilité : explode
modal: true
},
sAddDeleteToolbarSelector: ".dataTables_length"								

});

} );
</script>
</head>
<body>
<!-- On descend la liste d'une ligne pour centrage  -->
<br/>
<div id="types" class="art-postheader" align="center"><h1>Liste des Articles &agrave; commander/en attente de r&eacute;ception</h1></div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tableinter">
	<thead>
		<tr>
            <th>Date bon de Commande</th>
            <th>Fournisseur</th>        
			<th>Client</th>
			<th>Article</th>
            <th>PartNumber</th>
            <th>Quantit&eacute;</th>
            <th>Prix d'achat(htva)</th>
            <th>Total Prix d'achat(htva)</th>
            <th>Prix de vente unitaire</th>
			<th>Prix de vente total</th>
            <th>Command&eacute;</th>
            <th>Re&ccedil;u</th>
            <th>Note/BO/Planification</th>
		</tr>
	</thead>

	<tbody>    
    <!-- création du contenu de la table sur base des enregistrements db -->
    <?php
	
	// On récupère les hébergements actifs
	$sql = "SELECT c.nom as cnom, a.article as aarticle, a.reference as partnumber, cb.quanti as cbquanti, a.prix_htva as aprix_htva, cb.p_u_jour as cbp_u_jour, cb.tot_art_htva as cbtot_art_htva, cb.commande as cbcommande, cb.recu as cbrecu, cb.fourn as cbfourn, cb.note as cbnote, bc.date as bcdate, cb.num as cbnum";
    $sql .= " FROM ".$tblpref."cont_bon as cb";
	$sql .= " LEFT JOIN ".$tblpref."article as a ON a.num=cb.article_num ";
	$sql .= " LEFT JOIN ".$tblpref."bon_comm as bc ON bc.num_bon=cb.bon_num";
	$sql .= " LEFT JOIN ".$tblpref."client as c ON c.num_client=bc.client_num ";
    $sql .= " ORDER BY bcdate DESC";
	$sql .= " LIMIT 200";
	
	$resql=mysql_query($sql);
		if ($resql)
		{
			$num =mysql_num_rows($resql);
			$i = 0;
			if ($num)
			{
				while ($i < $num)
				{
					
							$obj =mysql_fetch_object($resql);
							echo '<tr class="odd_gradeX" id="'.$obj->cbnum.'">';						
							if ($obj)
							{
								// You can use here results
								print '<td align="center">'.$obj->bcdate.'</td>';
								print '<td align="center">'.$obj->cbfourn.'</td>';
								print '<td align="center">'.$obj->cnom.'</td>';
								print '<td align="center">'.$obj->aarticle.'</td>';
								print '<td align="center">'.$obj->partnumber.'</td>';
								print '<td align="center">'.$obj->cbquanti.'</td>';
								print '<td align="center">'.$obj->aprix_htva.'</td>';
								print '<td align="center">'.$obj->aprix_htva*$obj->cbquanti.'</td>';
								print '<td align="center">'.$obj->cbp_u_jour.'</td>';
								print '<td align="center">'.$obj->cbtot_art_htva.'</td>';
								print '<td align="center">'.$obj->cbcommande.'</td>';
								print '<td align="center">'.$obj->cbrecu.'</td>';
								print '<td align="center">'.$obj->cbnote.'</td>';

							}
							echo '</tr>';	
					$i++;
				}
			}
		}
	?>
	</tbody>
</table>
<br />
<br />
<div id="overlay3">
    <div class="popup_block">
        <a class="close" href="#noWhere"><img alt="Fermer" title="Fermer la fenêtre" class="btn_close" src="./include/img/close_pop.png"></a>

        <form action="./include/ajax/AddArticle.php" method="post" name="artice" id="artice" onSubmit="return verif_formulaire()" >
	<table class="addarticle">
    	<tr class="first">
        	<td colspan="4" class="titre">Cr&eacute;er un article</td>
        </tr><tr>
        	<td class="intitule gauche">Cat&eacute;gorie</td>
        	<td class="inp">
			<?php
            $rqSql = "SELECT id_cat, categorie FROM " . $tblpref ."categorie WHERE 1 ORDER BY categorie ASC";
            $result = mysql_query( $rqSql ) or die( "Exécution requête impossible."); ?>
            <SELECT NAME='categorie' ID='categorie'>
            <OPTION VALUE='0'><?php echo $lang_choisissez; ?></OPTION>
            			<?php
                        while ( $row = mysql_fetch_array( $result)) {
                            $num_cat = $row["id_cat"];
                            $categorie = $row["categorie"];
            			?>
            <OPTION VALUE='<?php echo "$num_cat" ; ?>'><?php echo "$categorie"; ?></OPTION>
            		<? } ?>
            </SELECT>
            </td>
			<td class="intitule">Marque</td>
            <td class="inp droite"><input type="text" id="marque" name="marque"></td>
      	</tr><tr>
        	<td class="intitule2 gauche">Nom</td>
            <td class="inp2"><input type="text" id="article" name="article"></td>
        	<td class="intitule2">Partnumber</td>
            <td class="inp2 droite"><input type="text" id="reference" name="reference"></td>
     	</tr><tr>
        	<td class="intitule gauche">Unit&eacute;(kg,pcs,gr,...)</td>
            <td class="inp"><input type="text" id="uni" name="uni"></td>
        	<td class="intitule">Prix Achat</td>
            <td class="inp droite"><input type="text" id="prix" name="prix">&#8364; (PV si marge = 0 -> Service)</td>
     	</tr><tr>
        	<td class="intitule2 gauche">% T.V.A.</td>
            <td class="inp2"><input type="text" id="taux_tva" name="taux_tva" value="21">%</td>
        	<td class="intitule2">Commentaire (optionel)</td>
            <td class="inp2 droite"><input type="text" id="commentaire" name="commentaire"></td>
    	</tr><tr>
        	<td class="intitule gauche">Stock</td>
            <td class="inp"><input type="text" id="stock" name="stock" ></td>
        	<td class="intitule">Stock min.</td>
            <td class="inp droite"><input type="text" id="stomin" name="stomin"></td>
     	</tr><tr>
        	<td class="intitule2 gauche">Stock max.</td>
            <td class="inp2"><input type="text" id="stomax" name="stomax" ></td>
        	<td class="intitule2">Marge</td>
            <td class="inp2 droite"><input type="text" id="marge" name="marge">% (0 pour le service)</td>
      	</tr><tr>
        	<td class="intitule gauche">Garantie</td>
            <td class="inp"><input type="text" id="garantie" name="garantie" value="1 an"></td>
        	<td class="intitule">Recupel (HTVA)</td>
            <td class="inp droite"><input type="text" id="recupel" name="recupel">&#8364;</td>
  		</tr><tr>
        	<td class="intitule2 gauche">Reprobel</td>
            <td class="inp2"><input type="text" id="reprobel" name="reprobel">&#8364;</td>
        	<td class="intitule2">Bebat</td>
            <td class="inp2 droite"><input type="text" id="bebat" name="bebat">&#8364;</td>
      	</tr><tr class="first">
        	<td colspan="4" class="subm"><input type="submit" value="Ajouter l'article"></td>
        </tr>
    </table>    
</form>
        
    </div>
</div>
<div><a href="#overlay3"><button class="divfixe">Cr&eacute;er un nouvel article</button></a></div>

</body>
