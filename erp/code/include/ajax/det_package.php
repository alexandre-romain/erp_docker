<?php
include("../config/common.php");
$id=$_GET['id'];
?>
<table width="100%" class="details">
<thead>
	<tr>
    	<th>Article</th>
        <th>Partnumber</th>
        <th>Qt&eacute;</th>
        <th>PV HTVA</th>
        <th>Supprimer</th>
    </tr>
</thead>
<?php
$sql="SELECT a.article as name, a.article_name as article_name, a.reference as reference, a.prix_htva as prix_htva, a.marge as marge, cp.id as id, cp.qty as qty";
$sql.=" FROM ".$tblpref."cont_panier as cp";
$sql.=" LEFT JOIN ".$tblpref."article as a ON a.num = cp.id_product";
$sql.=" WHERE cp.id_panier = '".$id."'";
$req=mysql_query($sql);
while ($obj=mysql_fetch_object($req)) {
	//ON check quel nom sera affiché
	if ($obj->article_name != '' && $obj->article_name != NULL) {
		$article=utf8_encode($obj->article_name);
	}
	else {
		$article=utf8_encode($obj->name);
	}
	//ON calcule le PV HTVA
	$pa=$obj->prix_htva;
	$marge=($pa/100)*$obj->marge;
	$pv=$pa+$marge;
	?>
    <tr>
    	<td width="30%"><?php echo $article;?></td>
        <td width="30%"><?php echo $obj->reference;?></td>
        <td width="10%"><?php echo $obj->qty;?></td>
        <td width="15%"><?php echo $pv;?> &euro;</td>
        <td width="15%"><button class="icons fa-trash fa-fw fa-2x del" onclick="del_cont_package(<?php echo $obj->id;?>,<?php echo $id;?>)" type="button" title="Supprimer l'article"></button></td>
    </tr>
    <?php
}
?>
</table>
<form class="autosubmit" action="./include/form/add_cont_package.php" method="post">
<table class="details" width="100%">
	<thead>
    	<tr>
        	<th style="background:#2c3e50" colspan="5">Ajouter un article au panier</th>
        </tr>
    </thead>
    <tbody>
    	<tr>
            <td class="" width="30%"><i class="fa fa-search fa-fw"></i> <input type="text" id="search_art" onKeyUp="rech_art_inline()" class="styled"></td>
            <td class="" width="45%">
                <div class="styled-select-inline" style="width:100%">
                <select name="articles" id="articles" class="styled-inline">
                    <option value="">Veuillez d'abord effectuer une recherche...</option>
                </select>
                </div>
            </td>
            <td width="15%">Qt&eacute; : <input type="text" class="styled" name="qty" id="qty"/></td>
            <td width="10%"><button class="icons fa-plus fa-fw fa-2x add"></button></td>
        </tr>
    </tbody>
</table>
<input type="hidden" name="id_panier" id="id_panier" value="<?php echo $id;?>" />
</form>