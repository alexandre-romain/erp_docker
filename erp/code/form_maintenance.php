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
	$( ".datep" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd-mm-yy" })
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
//Gestion des messages informatifs
include_once("include/message_info.php");
?> 
<!--create EXISTANT-->
<div class="portion">
    <!-- TITRE - create -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        Créer un contrat de maintenance
        <span class="fa-stack fa-lg add" style="float:right" id="show_create">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_create">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <div class="content_traitement" id="create">
        <form name="formu" method="post" action="maintenances.php" >
        <table class="base" width="100%">
            <tr> 
                <td class="right" width="50%">Client :</td>
                <td class="left" width="50%"> 
                    <?php 
                    include_once("include/choix_cli.php");
                    ?>
                </td>
            </tr>
            <tr>
                <td class="right">P&eacute;riode initiale :</td>
                <td class="left">
                    <input name="dateDeb" type="text" id="DateDeb" value="<?php echo date('d-m-Y');?>" size="10" maxlength="10" class="styled datep" style="width:15%"> &agrave; 
                    <input name="dateFin" type="text" id="dateFin" value="<?php echo date('d-m-Y', strtotime('+6 months'));?>" size="10" maxlength="10" class="styled datep" style="width:15%">
                </td>
            </tr>       
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-pencil"></i><span>Cr&eacute;er</span></button>
        </div>
        </form>
	</div>
</div>
<?php
//On inclus la liste des contrats.
include_once("lister_maintenances.php");
?> 

