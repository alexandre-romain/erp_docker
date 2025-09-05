<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
/* SHOW / HIDE */
$(document).ready(function() {
	$("#hide_add").hide();
	$("#hide_add").click(function(){
		$("#add").hide(500);	
		$("#hide_add").hide();
		$("#show_add").show();
	});
	$("#show_add").click(function(){
		$("#add").show(500);	
		$("#hide_add").show();
		$("#show_add").hide();
	});
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!-- AJOUT DE CLI -->
<div class="portion">
    <!-- TITRE - AJOUT DE CLI -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-plus fa-stack-1x"></i>
        </span>
        <?php echo $lang_client_ajouter; ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_add">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_add">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - AJOUT DE CLI -->
    <div class="content_traitement disp_none" id="add">
    	<p><i class="fa fa-info-circle fa-fw"></i>Les champs accompagn&eacute;s d'une ast&eacute;risque (<span class="requis">*</span>) sont requis.</p>
        <form action="client_new.php" method="post" name="client" id="client" >
        <table class="base" width="100%">
            <tr> 
                <td class="right" width="50%">Civilité :</td>
                <td class="left" width="50%"><input name="civ" type="text" id="civ" class="styled"></td>
            </tr>
            <tr> 
                <td class="right"><?php echo $lang_nom; ?> <span class="requis">*</span> :</td>
                <td class="left"><input name="nom" type="text" id="nom" class="styled"></td>
            </tr>
            <tr> 
                <td class="right"><?php echo $lang_complement; ?> :</td>
                <td class="left"><input name="nom_sup" type="text" id="nom_sup" class="styled"></td>
            </tr>
            <tr> 
                <td class="right"><?php echo $lang_rue; ?> <span class="requis">*</span> :</td>
                <td class="left">
                    <input name="rue" type="text" id="rue" class="styled" style="width:23.5%">
                    N&deg; : <input name="numero" type="text" id="numero" size="4" class="styled" style="width:10%">
                    Bte : <input name="boite" type="text" id="boite" size="4" class="styled" style="width:10%">
                </td>
            </tr>
            <tr> 
                <td class="right"><?php echo $lang_code_postal; ?> <span class="requis">*</span> :</td>
                <td class="left"><input name="code_post" type="text" id="code_post" class="styled"></td>
            </tr>
            <tr> 
                <td  class="right"><?php echo $lang_ville; ?> <span class="requis">*</span> :</td>
                <td class="left"><input name="ville" type="text" id="ville" class="styled"></td>
            </tr>
            <tr> 
                <td class="right"><?php echo $lang_numero_tva; ?> <span class="requis">*</span> :</td>
                <td class="left"><input name="num_tva" type="text" id="num_tva" class="styled"></td>
            </tr>
            <tr> 
                <td class="right">T&eacute;l&eacute;phone :</td>
                <td class="left"><input name="tel" type="text" id="tel" class="styled"></td>
            </tr>
            <tr> 
                <td class="right">GSM :</td>
                <td class="left"><input name="gsm" type="text" id="gsm" class="styled"></td>
            </tr>
            <tr> 
                <td class="right">Fax :</td>
                <td class="left"><input name="fax" type="text" id="fax" class="styled"></td>
            </tr>
            <tr>
                <td class="right">Email :</td>
                <td class="left"><input name="mail" type="text" id="mail" class="styled"></td>
            </tr>
        </table>
        <div class="center">
        	<button class="button_act button--shikoba button--border-thin medium" type="submit">
            	<i class="button__icon fa fa-floppy-o"></i><span>Enregistrer</span>
            </button>
            <button class="button_act button--shikoba button--border-thin medium" type="reset">
            	<i class="button__icon fa fa-eraser"></i><span>Effacer</span>
            </button>
        </div>
        </form>
	</div>
</div>

<?php 
include("lister_clients.php");
?>

