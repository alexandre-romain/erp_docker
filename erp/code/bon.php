<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_data").hide();
	$("#hide_data").click(function(){
		$("#data").hide(500);	
		$("#hide_data").hide();
		$("#show_data").show();
	});
	$("#show_data").click(function(){
		$("#data").show(500);	
		$("#hide_data").show();
		$("#show_data").hide();
	});
});
$(function() {
	$( "#date_new" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd-mm-yy" })
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
?>
<?php
$client=isset($_POST['listeville'])?$_POST['listeville']:"";
$date=isset($_POST['date'])?$_POST['date']:"";
//On split la date.
list($jour,$mois,$annee) = preg_split('/\//', $date, 3);
//Si le client n'est pas défini, on affiche le message et on arrête le traitement.
if($client=='0')
{
	$message="$lang_choix_client";
	include('form_commande.php');
	exit;
}
//Sinon on crée le bon de commande, vide.
$sql_nom = "SELECT  nom, nom2 FROM " . $tblpref ."client WHERE num_client = $client";
$req = mysql_query($sql_nom) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
	$nom = $data['nom'];
	$nom2 = $data['nom2'];
	$phrase = "$lang_bon_cree";
	$message="$phrase $nom $nom2 $lang_bon_cree2 $date";
}
$sql1 = "INSERT INTO " . $tblpref ."bon_comm(client_num, date) VALUES ('$client', '$annee-$mois-$jour')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
$bon_num=mysql_insert_id();
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<div class="portion">
    <!-- TITRE - SEARCH -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-keyboard-o fa-stack-1x"></i>
        </span>
        <?php echo $lang_donne_bon ; ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_data">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_data">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - SEARCH -->
    <div class="content_traitement" id="data">
    <form name='formu2' method='post' action='bon_suite.php'>
    <table class="base" align="center" width="100%">
        <tr>
            <td class="right" width="30%"><?php echo "$lang_article";?> :</td>
            <td class="left" width="70%"><?php include("include/categorie_choix.php");?></td>
        </tr>
        <tr>
            <td class="right"><?php echo $lang_quanti; ?> :</td>
            <td class="left" colspan="3"><input name='quanti' type='text' id='quanti' value="1" size='6' class="styled"></td>
        </tr>				
        <tr>
            <td class="right">PV (HTVA) :</td>
            <td class="left"><input name='PV' type='text' id='PV' size='6' class="styled"> &euro; </td>
        </tr>
    </table>
    <div class="center">
        <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-check"></i><span><?php echo "$lang_valid ";?></span></button>
    </div>
    <input type="hidden" name="bon_num" value="<?php echo $bon_num;?>" />
    </form>
    </div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
