<?php
//On inclus le fichier de co BDD
include("../config/common.php");
//On va récupérer l'id du devis predefini
$id=$_REQUEST['id'];
?>
<h1 class="modal">Utiliser le devis pr&eacute;d&eacute;fini</h1>
<form method="post" action="./include/form/attrib_dev_predef.php">
	<label class="inline">Transformer en : </label>
    <div class="styled-select-inline" style="width:30%;">
    <select id="transform" name="transform" class="styled-inline">
    	<option value="bon">Bon de commande</option>
        <option value="dev">Devis</option>
    </select>
    </div>
    <br/><br/>
	<?php
    include_once("../choix_cli_new.php");
    ?>
    <br/><br/>
    <label class="inline">Commentaire : </label>
    <textarea name="comment" id="comment" class="styled_border" cols="36" rows="4"></textarea>
    <input type="hidden" name="id_devis" value="<?php echo $id;?>">
    <div class="center">
        <button class="button_act button--shikoba button--border-thin medium"><i class="button__icon fa fa-thumbs-up"></i><span>Attribuer</span></button>
    </div>
</form>