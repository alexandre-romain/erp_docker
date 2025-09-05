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
<!--SELECTION CLIENT NC-->
<div class="portion">
    <!-- TITRE - SELECTION CLIENT NC -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-search fa-stack-1x"></i>
        </span>
        Rechercher des notes de cr&eacute;dit
        <span class="fa-stack fa-lg add" style="float:right" id="show_choice">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_choice">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - SELECTION CLIENT NC -->
    <div class="content_traitement" id="choice">
        <form name="formu" method="post" action="lister_nc_suite.php" >
            <table class="base" width="100%">
                <tr> 
                    <td class="right" width="50%"><?php echo "$lang_client"; ?> :</td>
                    <td class="left" width="50%">
                        <?php 
                        include_once("include/choix_cli.php");
                        ?> 
                    </td>
                </tr>
              </table>
            <div class="center">
                <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-search"></i><span>Rechercher</span></button>
            </div>  
        </form>
	</div>
</div>
<?php
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>