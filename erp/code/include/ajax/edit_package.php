<?php
include("../config/common.php");
include("../fonctions.php");
$id=$_REQUEST['id'];

$sql="SELECT p.echeance as echeance, p.id as id, c.nom as nom, c.num_client as num_client, p.etat as etat, p.debut, p.duree, p.com_facture, p.com_interne";
$sql.=" FROM ".$tblpref."panier as p";
$sql.=" LEFT JOIN ".$tblpref."client as c ON c.num_client = p.id_cli";
$sql.=" WHERE p.id = '".$id."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
?>
<form action="./include/form/edit_package.php" method="post">
<h1 class="modal">Editer le package</h1>
<input type="hidden" name="id_panier" value="<?php echo $id;?>">

<label class="inline">Recherche client :</label>
<input type="text" id="search_soc" name="search_soc" onKeyUp="javascript:autosuggest('asoc')" class="styled_border"><br/><br/>

<label class="inline">Client :</label>
<div class="styled-select-inline" style="width:50%">
<select id="listeville" name="listeville" class="styled-inline">
	<option value="<?php echo $obj->num_client;?>"><?php echo $obj->nom;?></option>
</select>
</div><br/><br/>

<Label class="inline">Date (D&eacute;but) :</label>
<input type="text" class="datepicker styled_border" name="debut" id="debut" value="<?php echo dateUSA_to_dateEU($obj->debut);?>"><br/><br/>

<Label class="inline">Dur&eacute;e :</label>
<div class="styled-select-inline" style="width:41%">
<select class="styled-inline" name="duree" id="duree">
    <option value="1" <?php if ($obj->duree == 1) { echo 'selected';}?>>1 mois</option>
	<option value="3" <?php if ($obj->duree == 3) { echo 'selected';}?>>3 mois</option>
    <option value="6" <?php if ($obj->duree == 6) { echo 'selected';}?>>6 mois</option>
    <option value="12" <?php if ($obj->duree == 12) { echo 'selected';}?>>1 an</option>
    <option value="24" <?php if ($obj->duree == 24) { echo 'selected';}?>>2 ans</option>
    <option value="36" <?php if ($obj->duree == 36) { echo 'selected';}?>>3 ans</option>
	<option value="60" <?php if ($obj->duree == 60) { echo 'selected';}?>>5 ans</option>
</select>
</div><br/><br/>
<label class="inline">Commentaire facture :</label>
<input type="text" id="com_fact" name="com_fact" class="styled_border" value="<?php echo $obj->com_facture;?>"><br/><br/>
<label class="inline">Commentaire INTERNE :</label>
<input type="text" id="com_int" name="com_int" class="styled_border" value="<?php echo $obj->com_interne;?>"><br/><br/>
<div class="center">
    <button class="button_act button--shikoba button--border-thin medium" type="submit">
        <i class="button__icon fa fa-pencil"></i><span>Modifier</span>
    </button>
</div>

</form>