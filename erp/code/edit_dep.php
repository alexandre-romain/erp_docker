<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_edit").hide();
	$("#hide_edit").click(function(){
		$("#edit").hide(500);	
		$("#hide_edit").hide();
		$("#show_edit").show();
	});
	$("#show_edit").click(function(){
		$("#edit").show(500);	
		$("#hide_edit").show();
		$("#show_edit").hide();
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
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
$num_dep=isset($_GET['num_dep'])?$_GET['num_dep']:"";
$sql = "SELECT * FROM " . $tblpref ."depense WHERE num=$num_dep";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req)) {
	$article = htmlentities($data['article'], ENT_QUOTES);
	$num =htmlentities($data['num'], ENT_QUOTES);
	$prix = htmlentities($data['prix'], ENT_QUOTES);
	$lib = htmlentities($data['lib'], ENT_QUOTES);
	$four = htmlentities($data['fournisseur'], ENT_QUOTES);
}
?>
<!--AJOUT STOCK-->
<div class="portion">
    <!-- TITRE - AJOUT STOCK -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        Modifier une dépense
        <span class="fa-stack fa-lg add" style="float:right" id="show_edit">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_edit">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - AJOUT STOCK -->
    <div class="content_traitement" id="edit">
        <form name="form1" method="post" action="edit_dep_suite.php">
            <table class="base" width="100%">
                <tr>
                    <td class="right" width="50%">Libellé :</td>
                    <td class="left" width="50%"><input name="lib" type="text" value="<?php echo "$lib" ?>" class="styled"></td>
                </tr>
                <tr>
                    <td class="right">Montant Htva :</td>
                    <td class="left"><input name="prix" type="text" value="<?php echo "$prix" ?>" class="styled"></td>
                </tr>
                <tr>
                    <td class="right">Fournisseur :</td>
                    <td class="left"><input name="four" type="text" value="<?php echo "$four" ?>" class="styled"></td>
                </tr>
            </table>
            <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-check"></i><span>Valider</span></button>
            <button class="button_act button--shikoba button--border-thin medium" type="reset"><i class="button__icon fa fa-eraser"></i><span><?php echo $lang_effacer; ?></span></button>
        	</div>
        	<input name="num" type="hidden" value="<?php echo "$num" ?>">
        </form>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>