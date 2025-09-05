<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$( "#show_create" ).hide();
	$( "#show_create" ).click(function() {
		$( "#create" ).show(500);
		$( "#show_create" ).hide();
		$( "#hide_create" ).show();
	});
	$( "#hide_create" ).click(function() {
		$( "#create" ).hide(500);
		$( "#show_create" ).show();
		$( "#hide_create" ).hide();
	});
});
$(function() {
	$( ".datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd/mm/yy" })
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
//FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
$mois = date("m");
$annee = date("Y");
$jour = date("d");
$rqSql = "SELECT num_client, nom FROM " . $tblpref ."client WHERE actif != 'non'";
if ($user_fact == r) { 
	$rqSql = "SELECT num_client, nom FROM " . $tblpref ."client WHERE actif != 'non'
		 	 and (" . $tblpref ."client.permi LIKE '$user_num,' 
		 	 or  " . $tblpref ."client.permi LIKE '%,$user_num,' 
			 or  " . $tblpref ."client.permi LIKE '%,$user_num,%' 
			 or  " . $tblpref ."client.permi LIKE '$user_num,%') 
	";  
}
?>
<!--CREATION FACT-->
<div class="portion">
    <!-- TITRE - CREATION FACT -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        <?php echo $lang_facture_creer; ?>
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
    <!-- CONTENT - CREATION FACT -->
    <div class="content_traitement" id="create">
        <form name="formu" method="post" action="fact.php">
        <table class="base" width="100%">
            <tr> 
                <td class="right" width="50%"> <?php echo $lang_client; ?> </td>
                <td class="left" width="50%">
                    <?php 
                   	include_once("include/choix_cli.php");
                    ?>
                </td>
            </tr>
            <tr>
                <td class='right'><?php echo $lang_date_deb; ?></td>
                <td class='left'>
                    <input type="text" name="date_deb" value="<?php echo "1/$mois/$annee" ?>" readonly="readonly" class="styled datepicker"/>
                </td>   
            </tr>
            <tr>
                <td class='right'><?php echo $lang_date_fin; ?></td>
                <td class='left'>
                    <input type="text" name="date_fin" value="<?php echo "$jour/$mois/$annee" ?>" readonly="readonly" class="styled datepicker"/>   
                </td>              
            </tr>
            <tr>
                <td class='right'><?php echo $lang_facture_date; ?></td>
                <td class='left'>
                    <input type="text" name="date_fact" value="<?php echo "$jour/$mois/$annee" ?>" readonly="readonly" class="styled datepicker"/>
                </td>
            </tr>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit" name="Submit">
            	<i class="button__icon fa fa-search"></i><span><?php echo $lang_facture_creer_bouton; ?></span>
           	</button>
        </div>
        </form>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
