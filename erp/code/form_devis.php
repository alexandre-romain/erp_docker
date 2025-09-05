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
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
$rqSql = "SELECT num_client, nom FROM " . $tblpref ."client WHERE actif != 'non'";
if ($user_dev == r) { 
$rqSql = "SELECT num_client, nom FROM " . $tblpref ."client WHERE actif != 'non'
		 			 				 AND (" . $tblpref ."client.permi LIKE '$user_num,' 
		 			 				 or  " . $tblpref ."client.permi LIKE '%,$user_num,' 
									 or  " . $tblpref ."client.permi LIKE '%,$user_num,%' 
									 or  " . $tblpref ."client.permi LIKE '$user_num,%') ";
}
$annee = date("Y");
$mois = date("m");
$jour = date("d");
?>
<!--CREATION DEVIS-->
<div class="portion">
    <!-- TITRE - CREATION DEVIS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        <?php echo $lang_devis_créer; ?>
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
    <!-- CONTENT - CREATION DEVIS -->
    <div class="content_traitement" id="create">
        <form name="formu" method="post" action="devis.php" >
        <table class="base" width="100%" border="0">
            <tr> 
                <td class="right" width="50%"><?php echo "$lang_client"; ?> :</td>
                <td class="left" width="50%">
                    <?php 
					include_once("include/choix_cli.php");
					?> 
                </td>
            </tr>
            <tr> 
                <td class="right"><?php echo "Date" ?> :</td>
                <td class="left"><input type="text" name="date" value="<?php echo "$jour/$mois/$annee" ?>" readonly="readonly" id="date_new" class="styled"/></td>
            </tr>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-pencil"></i><span>Cr&eacute;er le devis</span></button>
        </div>
        </form>
	</div>
</div>
<?php
include_once("lister_devis.php");
?> 

