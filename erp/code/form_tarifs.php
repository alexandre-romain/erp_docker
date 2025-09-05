<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_create").hide();
	$("#hide_create").click(function(){
		$("#create").hide(500);	
		$("#hide_create").hide();
		$("#show_create").show();
	});
	$("#show_create").click(function(){
		$("#create").show(500);	
		$("#hide_create").show();
		$("#show_create").hide();
	});
});
$(function() {
	$( "#date_new" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd/mm/yy" })
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
?>
<?php
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!--CREATION COMMANDE-->
<div class="portion">
    <!-- TITRE - CREATION COMMANDE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        Créer un tarif
        <span class="fa-stack fa-lg add" style="float:right" id="show_create">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_create">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - CREATION COMMANDE -->
    <div class="content_traitement" id="create">
        <form name="formu" method="post" action="tarifs.php" >
        <table class="base" width="100%">
              <tr> 
                    <td width="50%" class="right">Description :</td>
                    <td width="50%" class="left"><input name="description" type="text" id="description" class="styled"></td>
              </tr>
              <tr> 
                    <td class="right">Prix (HTVA) :</td>
                    <td class="left"><input name="prix" type="text" id="prix" size="6" class="styled"> &euro;</td>
              </tr>
              <tr> 
                    <td width="50%" class="right">Dur&eacute;e (heures) :</td>
                    <td width="50%" class="left"><input name="duree" type="text" id="duree" size="6" class="styled"> h</td>
              </tr>
              <tr> 
                    <td class="right">Validit&eacute; (jours) :</td>
                    <td class="left"><input name="validite" type="text" id="validite" size="6" class="styled"> j</td>
              </tr>
              <tr> 
                    <td class="right">Nbre d&eacute;placements compris :</td>
                    <td class="left"><input name="deplacements" type="text" id="deplacements" size="6" class="styled"></td>
              </tr>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-pencil"></i><span>Cr&eacute;er le tarif</span></button>
        </div>
        </form>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>