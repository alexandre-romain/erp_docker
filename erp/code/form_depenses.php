<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_choice").hide();
	$("#hide_choice").click(function(){
		$("#choice").hide(500);	
		$("#hide_choice").hide();
		$("#show_choice").show();
	});
	$("#show_choice").click(function(){
		$("#choice").show(500);	
		$("#hide_choice").show();
		$("#show_choice").hide();
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
<!--CHOIX TYPE FRAIS-->
<div class="portion">
    <!-- TITRE - CHOIX TYPE FRAIS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-arrows-h fa-stack-1x"></i>
        </span>
        Choisir un type d'achat
        <span class="fa-stack fa-lg add" style="float:right" id="show_choice">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_choice">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - CHOIX TYPE FRAIS -->
    <div class="content_traitement" id="choice">
        <form method="post" name="achats" id="achats">
        <table class="base" width="100%">
            <tr> 
                <td class="right" width="50%">Type d'achat: </td>
                <td class="left" width="50%">
                    <div class="styled-select-inline" style="width:40%">
                    <SELECT NAME='type_achat' onchange="javascript:window.location=this.value" class="styled-inline">
                        <option value="#">Faites un choix</option>
                        <option value="form_fraisgeneraux.php">Frais G&eacute;n&eacute;raux</option>
                        <option value="form_achatsmarchandises.php">Achats Marchandises</option>
                    </SELECT> 
                    </div>
                </td>
            </tr>
        </table>
        </form>
	</div>
</div>
<?php 
include_once("lister_depenses.php");
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>


