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
$jour = date("d");
$mois = date("m");
$annee = date("Y");
$rqSql = "SELECT num_client, nom FROM " . $tblpref ."client WHERE actif != 'non'";
if ($user_com == r) { 
	$rqSql = "SELECT num_client, nom FROM " . $tblpref ."client WHERE actif != 'non'
		 and (" . $tblpref ."client.permi LIKE '$user_num,' 
		 or  " . $tblpref ."client.permi LIKE '%,$user_num,' 
		 or  " . $tblpref ."client.permi LIKE '%,$user_num,%' 
		 or  " . $tblpref ."client.permi LIKE '$user_num,%')  
		";  
}
?>
<!--CREATION COMMANDE-->
<div class="portion">
    <!-- TITRE - CREATION COMMANDE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        Cr&eacute;er un bon de commande
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
        <form name="formu" method="post" action="bon.php" onSubmit="return verif_formulaire()">
        <table class="base" border="0" width="100%">
            <tr> 
                <td width="50%" class="right"><?php echo "$lang_client";?> :</td>
                <td width="50%" class="left">
                <?php 
                    include_once("include/choix_cli.php");
                ?> 
                </td>
            </tr>
            <tr> 
                <td class="right">Date :</td>
                <td class="left">
                    <input type="text" name="date" id="date_new" value="<?php echo"$jour/$mois/$annee" ?>" class="styled"/>
                    <!--<a href="#" onClick=" window.open('include/pop.calendrier.php?frm=formu&amp;ch=date','calendrier','width=415,height=160,scrollbars=0').focus();">
                    <img src="image/petit_calendrier.gif" alt="calendrier" border="0"/></a>-->
                </td>
            </tr>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-pencil"></i><span><?php echo "$lang_crer_bon" ?></span></button>
        </div>
        </form>
    </div>
</div>
<?php
include_once("lister_commandes.php");
?>