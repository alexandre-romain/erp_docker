<?php
include("../config/common.php");

$id=$_GET['id'];

$sql="SELECT a.num as num, a.article as article, a.article_name, a.prix_htva as prix_htva, a.taux_tva as taux_tva, a.list_price as list_price, a.uni as uni, a.stock_tech as stock_tech, a.backorder_date as backorder_date, a.stock as stock, a.stomin as stomin, a.stomax as stomax, c1.categorie as cat1, c2.categorie as cat2, c3.categorie as cat3, a.marge as marge, a.garantie as garantie, a.reference as partnumber, a.marque as marque, a.auvibel as auvibel, a.recupel as recupel, a.reprobel as reprobel, a.bebat as bebat, a.commentaire as commentaire, a.modif_date as modif_date";
$sql.=" FROM ".$tblpref."article as a";
$sql.=" LEFT JOIN ".$tblpref."categorie as c1 ON c1.id_cat=a.cat1";
$sql.=" LEFT JOIN ".$tblpref."categorie as c2 ON c2.id_cat=a.cat2";
$sql.=" LEFT JOIN ".$tblpref."categorie as c3 ON c3.id_cat=a.cat3";
$sql.=" WHERE num='".$id."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);

$num=$obj->num;
$article=$obj->article;
$article_name=$obj->article_name;
$prix_ht=$obj->prix_htva;
$taux_tva=$obj->taux_tva;
$list_price=$obj->list_price;
$unite=$obj->uni;
$stock_tech=$obj->stock_tech;
$backorder_date=$obj->backorder_date;
$stock=$obj->stock;
$stomin=$obj->stomin;
$stomax=$obj->stomax;
$topcat=$obj->cat1;
$midcat=$obj->cat2;
$botcat=$obj->cat3;
$marge=$obj->marge;
$garantie=$obj->garantie;
$partnumber=$obj->partnumber;
$marque=$obj->marque;
$auvibel=$obj->auvibel;
$reprobel=$obj->reprobel;
$recupel=$obj->recupel;
$bebat=$obj->bebat;
$modif_date=$obj->modif_date;
$commentaire=$obj->commentaire;

//Calcul du prix de vente

$marge_calc_inter=$prix_ht/100;
$marge_calc=$marge_calc_inter*$marge;

$pv_ht=$prix_ht+$marge_calc;

$tva_inter=$pv_ht/100;
$tva=$tva_inter*$taux_tva;

$pv_ttc=$pv_ht+$tva;

//echo '<div onclick="hide_det('.$id.')">Close '.$num.'</div>';
?>
<table class="details" align="center" width="100%">
	<thead>
	<!--<tr>
    	<th colspan="8">Détails "<?php echo $article; ?>"</th>
    </tr>-->
	<tr>
    	<th colspan="2" width="25%"><i class="fa fa-cog"></i> Fiche Tech.</th>
        <th colspan="2" width="25%"><i class="fa fa-database"></i> Stocks</th>
        <th colspan="2" width="25%"><i class="fa fa-calculator"></i> Taxes</th>
        <th colspan="2" width="25%"><i class="fa fa-money"></i> Financier</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    	<td colspan="8">
        	<div class="indication">
            	Les champs pr&eacute;c&eacute;d&eacute;s de l'indicateur attention ( <i class="fa fa-exclamation-triangle fa-fw warn"></i> ), sont mis &agrave; jour lors de l'update automatique des articles en provenance de Techdata.<br/>
                Gardez-donc en tête que, si l'article provient de Techdata, les modifications seront écrasées lors de cet update. <i>(Si vous souhaitez changer le nom d'article affich&eacute; sur les diff&eacute;rents documents, utilisez le champs 'Nom perso')</i>
            </div>
        </td>
    </tr>
    <tr>
    	<td class="details"><i class="fa fa-exclamation-triangle fa-fw warn"></i> Nom :</td>
        <td class="details edit_art" id="nom"><?php echo $article; ?></td>
        <td class="details">Stock FastIT :</td>
        <td class="details"><?php echo '<div class="edit_stock_fi" id="stock_fastit" style="display:inline">'.$stock.'</div> '.$unite; ?></td>
        <td class="details"><i class="fa fa-exclamation-triangle fa-fw warn"></i> Auvibel :</td>
        <td class="details"><?php echo '<div class="edit_art" id="auvibel" style="display:inline">'.$auvibel.'</div>'; ?> &euro;</td>
        <td class="details"><i class="fa fa-exclamation-triangle fa-fw warn"></i> P.A. :</td>
        <td class="details"><?php echo '<div class="edit_art" id="prix_achat" style="display:inline">'.$prix_ht.'</div>'; ?>  &euro;</td>
    </tr>
    <tr>
    	<td class="details">Nom perso :</td>
        <td class="details"><?php echo '<div class="edit_n_perso" id="nom_perso" style="display:inline">'.$article_name.'</div> '; ?></td>
        <td class="details">Stock Min. :</td>
        <td class="details"><?php echo '<div class="edit_stomin" id="stomin" style="display:inline">'.$stomin.'</div> '.$unite; ?></td>
        <td class="details"><i class="fa fa-exclamation-triangle fa-fw warn"></i> Bebat :</td>
        <td class="details"><?php echo '<div class="edit_art" id="bebat" style="display:inline">'.$bebat.'</div>'; ?> &euro;</td>
        <td class="details">T.V.A. :</td>
        <td class="details"><?php echo '<div class="edit_tva" id="tva" style="display:inline">'.$taux_tva.'</div>'; ?> %</td>
    </tr>
    <tr>
    	<td class="details"><i class="fa fa-exclamation-triangle fa-fw warn"></i> Marque :</td>
        <td class="details edit_art" id="marque"><?php echo $marque; ?></td>
        <td class="details">Stock Max. :</td>
        <td class="details"><?php echo '<div class="edit_stomax" id="stomax" style="display:inline">'.$stomax.'</div> '.$unite; ?></td>
        <td class="details"><i class="fa fa-exclamation-triangle fa-fw warn"></i> Recupel :</td>
        <td class="details"><?php echo '<div class="edit_art" id="recupel" style="display:inline">'.$recupel.'</div>'; ?> &euro;</td>
        <td class="details">Marge :</td>
        <td class="details"><?php echo '<div class="edit_marge" id="marge" style="display:inline">'.$obj->marge.'</div>'; ?> %</td>
    </tr>
    <tr>
    	<td class="details"><i class="fa fa-exclamation-triangle fa-fw warn"></i> Top Cat. :</td>
        <td class="details"><?php echo $topcat; ?></td>
        <td class="details"><i class="fa fa-exclamation-triangle fa-fw warn"></i> Stock TechData :</td>
        <td class="details"><?php echo '<div class="edit_art" id="stock_fourn" style="display:inline">'.$stock_tech.'</div> '.$unite; ?></td>
        <td class="details"><i class="fa fa-exclamation-triangle fa-fw warn"></i> Reprobel :</td>
        <td class="details"><?php echo '<div class="edit_art" id="reprobel" style="display:inline">'.$reprobel.'</div>'; ?> &euro;</td>
        <td class="details"><i class="fa fa-exclamation-triangle fa-fw warn"></i> List Price :</td>
        <td class="details"><?php echo '<div class="edit_art" id="list_price" style="display:inline">'.$list_price.'</div>'; ?>  <?php if ($list_price != "" || $list_price != NULL) {?> &euro; <?php }?></td>
    </tr>
    <tr>
    	<td class="details"><i class="fa fa-exclamation-triangle fa-fw warn"></i> Middle Cat. :</td>
        <td class="details"><?php echo $midcat; ?></td>
        <td class="details"><i class="fa fa-exclamation-triangle fa-fw warn"></i> Backorder date :</td>
        <td class="details edit_art" id="backorder"><?php echo $backorder_date; ?></td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
        <td class="details">--------------</td>
        <td class="details">&nbsp;</td>
    </tr>
    <tr>
    	<td class="details"><i class="fa fa-exclamation-triangle fa-fw warn"></i> Bottom Cat. :</td>
        <td class="details"><?php echo $botcat; ?></td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
        <td class="details">P.V.H.T. :</td>
        <td class="details"><?php echo $pv_ht; ?> &euro;</td>
    </tr>
    <tr>
    	<td class="details"><i class="fa fa-exclamation-triangle fa-fw warn"></i> Partnumber :</td>
        <td class="details edit_art" id="partnumber"><?php echo $partnumber; ?></td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
        <td class="details">P.V.T.T.C. :</td>
        <td class="details"><?php echo $pv_ttc; ?> &euro;</td>
    </tr>
    <tr>
    	<td class="details">Garantie :</td>
        <td class="details edit_garantie" id="garantie"><?php echo $garantie; ?></td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
    </tr>
    <tr>
    	<td class="details">Unit&eacute; :</td>
        <td class="details edit_art" id="unit"><?php echo $unite; ?></td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
        <td class="details">&nbsp;</td>
    </tr>
    <tr>
    	<td class="details_bottom_intitule" colspan="2">Commentaire :</td>
        <td class="details_bottom edit_note" colspan="6" id="note"><?php if ($commentaire != '0') {echo $commentaire;} else {echo 'Aucun Commentaire';} ?></td>
    </tr>
     <tr>
    	<td class="details_bottom_intitule" colspan="2">Date de mise &agrave; jour article :</td>
        <td class="details_bottom" colspan="6"><?php echo $modif_date; ?></td>
    </tr>
    </tbody>
</table>