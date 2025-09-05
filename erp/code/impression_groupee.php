<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_print").hide();
	$("#hide_print").click(function(){
		$("#print").hide(500);	
		$("#hide_print").hide();
		$("#show_print").show();
	});
	$("#show_print").click(function(){
		$("#print").show(500);	
		$("#hide_print").show();
		$("#show_print").hide();
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
<!--SELECTION PERIODE-->
<div class="portion">
    <!-- TITRE - SELECTION PERIODE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-print fa-stack-1x"></i>
        </span>
        D&eacute;finir une s&eacute;quence &agrave; imprimer
        <span class="fa-stack fa-lg add" style="float:right" id="show_print">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_print">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - SELECTION PERIODE -->
    <div class="content_traitement" id="print">
        <form name="form_export" method="GET" action="fpdf/facture_group.php">
        <table class="base" width="100%">
            <tr>
                <td class='right' width="50%">Entrer le n&deg; de la premi&egrave;re facture :</td>
                <td class='left' width="50%"><input type="text" name="num" class="styled"/></td>
            </tr>
            <tr>
                <td class='right'>Entrer le n&deg; de la derni&egrave;re facture :</td>
                <td class='left'><input type="text" name="num_fin" class="styled"/></td>
            </tr>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-print"></i><span>Imprimer</span></button>
        </div>  
        <input type="hidden" name="pdf_user" value="adm" />
        </form>
    </div>
</div>        
<?php
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
