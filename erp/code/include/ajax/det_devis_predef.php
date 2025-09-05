<?php
include("../config/common.php");
//On récupère l'id du devis.
$id=$_REQUEST['id'];
//On va récupérer le contenu de ce devis
$sql="SELECT a.article as aarticle, a.reference as reference, a.marque as marque, cdp.quanti as quanti, cdp.tot_art_htva as tot_art_htva, cdp.p_u as pu, cdp.type as type, cdp.tot_tva_art as tot_tva_art, cdp.tot_art_recupel, cdp.tot_art_reprobel, cdp.tot_art_bebat, cdp.tot_art_auvibel, cdp.id as id";
$sql.=" FROM ".$tblpref."cont_dev_predef as cdp";
$sql.=" LEFT JOIN ".$tblpref."article as a ON a.num = cdp.article_num";
$sql.=" WHERE id_dev_predef = '".$id."'";
$sql.=" ORDER BY cdp.type ASC";
$req=mysql_query($sql);
?>
<table width="100%" class="details">
	<thead>
    	<tr>
        	<th>Article</th>
            <th>P/N</th>
            <th>Marque</th>
            <th>Type</th>
            <th>Nombre</th>
            <th>P.U. HTVA</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
<?php
while ($obj=mysql_fetch_object($req)) {
	//Gestiaux des totaux
	$tot_htva+=$obj->tot_art_htva;
	$tot_tva+=$obj->tot_tva_art;
	$tot_taxes+=$obj->tot_art_recupel;
	$tot_taxes+=$obj->tot_art_reprobel;
	$tot_taxes+=$obj->tot_art_bebat;
	$tot_taxes+=$obj->tot_art_auvibel;
	//Gestion des types
	if ($obj->type == 'proc') {
		$type='processeur';
	}
	else if ($obj->type == 'mb') {
		$type='carte m&egrave;re';
	}
	else if ($obj->type == 'ram') {
		$type='m&eacute;moire ram';
	}
	else if ($obj->type == 'fan') {
		$type='ventilateur';
	}
	else if ($obj->type == 'cfan') {
		$type='p&acirc;te thermique';
	}
	else if ($obj->type == 'gpu') {
		$type='carte graphique';
	}
	else if ($obj->type == 'hdd') {
		$type='disque dur';
	}
	else if ($obj->type == 'cd') {
		$type='lecteur/graveur';
	}
	else if ($obj->type == 'card') {
		$type='lecteur de cartes';
	}
	else if ($obj->type == 'wifi') {
		$type='carte wifi';
	}
	else if ($obj->type == 'son') {
		$type='carte son';
	}
	else if ($obj->type == 'case') {
		$type='boitier';
	}
	else if ($obj->type == 'alim') {
		$type='alimentation';
	}
	else if ($obj->type == 'os') {
		$type='syst&egrave;me d\'exploitation';
	}
	else if ($obj->type == 'soft') {
		$type='programme';
	}
	else if ($obj->type == 'screen') {
		$type='&eacute;cran';
	}
	else if ($obj->type == 'keyb') {
		$type='clavier';
	}
	else if ($obj->type == 'mouse') {
		$type='souris';
	}
	else if ($obj->type == 'hifi') {
		$type='enceintes';
	}
	else if ($obj->type == 'heads') {
		$type='casque/micro';
	}
	else if ($obj->type == 'wifik') {
		$type='cl&eacute; wifi';
	}
	else if ($obj->type == 'print') {
		$type='imprimante';
	}
	else if ($obj->type == 'webc') {
		$type='webcam';
	}
	else if ($obj->type == 'o') {
		$type='autre';
	}
	else if ($obj->type == 'wire') {
		$type='c&acirc;blage';
	}
	?>
    <tr>
    	<td><?php echo $obj->aarticle;?></td>
		<td><?php echo $obj->reference;?></td>
        <td><?php echo $obj->marque;?></td>
        <td><?php echo $type;?></td>
        <td class="edit" id="<?php echo $obj->id;?>"><?php echo $obj->quanti;?></td>
        <td><?php echo $obj->pu;?> &euro;</td>
        <td class="right"><?php echo $obj->tot_art_htva;?> &euro;</td>
        <td style="vertical-align:top;">
        	<button class="icons fa-pencil fa-2x fa-fw action"></button>
            <!-- SUPPRESSION -->
            <form method="post" action="./include/form/del_cont_dev_predef.php" class="autosubmit_list" style="display:inline-block;vertical-align:top;">
        		<button class="icons fa fa-trash-o fa-2x fa-fw del"></button>
                <input type="hidden" name="id" value="<?php echo $obj->id;?>" />
            </form>
        </td>
	</tr>
	<?php
}
$gd_total=$tot_htva+$tot_tva+$tot_taxes;
?>
	<tr style="border-bottom:0;">
    	<td colspan="6" class="right bold" style="background:#2980b9;color:#ecf0f1">Total HTVA :</td>
        <td class="right bold" style="background:#2980b9;color:#ecf0f1"><?php echo number_format($tot_htva,2);?> &euro;</td>
        <td style="background:#2980b9;color:#ecf0f1"></td>
    </tr>
    <tr>
    	<td colspan="6" class="right bold" style="background:#2980b9;color:#ecf0f1">Total TTC :</td>
        <td class="right bold" style="background:#2980b9;color:#ecf0f1"><?php echo number_format($gd_total,2);?> &euro;</td>
        <td style="background:#2980b9;color:#ecf0f1"></td>
    </tr>
	</tbody>
</table>
<form method="post" action="./include/form/add_cont_dev_predef.php" class="autosubmit_list">
<table width="100%" class="details">
	<thead>
        <tr>
            <th colspan="8" style="background:#2c3e50">Ajouter un composant au devis</th>
        </tr>
    </thead>
    <tbody>
    	<tr>
        	<td style="background:#2980b9;color:#ecf0f1" width="10%" class="right">Type de composant :</td>
            <td style="background:#2980b9;color:#ecf0f1" width="15%" class="left">
            	<div class="styled-select-inline">
                    <select class="styled-inline" id="type_add_cont" name="type_add_cont">
                        <option value="rech_alim">Alimentation</option>
                        <option value="rech_o">Autre</option>
                        <option value="rech_case">Boitier</option>
                        <option value="rech_wire">C&acirc;blage</option>
                        <option value="rech_gpu">Carte Graphique</option>
                        <option value="rech_mb">Carte M&egrave;re</option>
                        <option value="rech_son">Carte Son</option>
                        <option value="rech_wifi">Carte Wifi</option>
                        <option value="rech_heads">Casque/Micro</option>
                        <option value="rech_keyb">Clavier</option>
                        <option value="rech_wifik">Cl&eacute; Wifi</option>
                        <option value="rech_screen">&Eacute;cran</option>
                        <option value="rech_hifi">Enceintes</option>
                        <option value="rech_hdd">HDD/SSD</option>
                        <option value="rech_print">Imprimante</option>
                        <option value="rech_card">Lecteur de cartes</option>
                        <option value="rech_cd">Lecteur/Graveur</option>
                        <option value="rech_soft">Logiciel</option>
                        <option value="rech_ram">M&eacute;moire Ram</option>
                        <option value="rech_os">OS</option>
                        <option value="rech_cfan">P&acirc;te thermique</option>
                        <option value="rech_proc">Processeur</option>
                        <option value="rech_fan">Refroidissement CPU</option>
                        <option value="rech_mouse">Souris</option>
                        <option value="rech_webc">Webcam</option>
                    </select>
                </div>
            </td>
            <td style="background:#2980b9;color:#ecf0f1" width="18%" class="right">Recherche (nom, marque, p/n) :</td>
            <td style="background:#2980b9;color:#ecf0f1" width="15%" class="left"><input type="text" class="styled_border" id="rech_add_cont" onkeyup="filter_article_inline('select_add_count')"/></td>
            <td style="background:#2980b9;color:#ecf0f1" width="30%">
                <div class="styled-select-inline">
                    <select class="styled-inline" id="select_add_count" name="article">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </td>
            <td style="background:#2980b9;color:#ecf0f1" width="4%" class="right">Nbr :</td>
            <td style="background:#2980b9;color:#ecf0f1" width="5%" class="left"><input type="text" class="styled_border" id="nbr" name="nbr" size="5" value="1"/></td>
            <td style="background:#2980b9;color:#ecf0f1" width="5%"><button class="icons fa-plus fa-2x add" title="Ajouter le composant"></button></td>
        </tr>
    </tbody>
</table>
<input type="hidden" name="id_devis" value="<?php echo $id;?>" />
</form>