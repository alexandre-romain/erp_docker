<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_add").hide();
	$("#hide_add").click(function(){
		$("#add").hide(500);	
		$("#hide_add").hide();
		$("#show_add").show();
	});
	$("#show_add").click(function(){
		$("#add").show(500);	
		$("#hide_add").show();
		$("#show_add").hide();
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
//Récupération des variables client + date
$client=isset($_POST['listeville'])?$_POST['listeville']:"";
$date=isset($_POST['date'])?$_POST['date']:"";
list($jour, $mois,$annee) = preg_split('/\//', $date, 3);
//calcul de l'écheance
$jour_echeance = $jour;
$mois_echeance = $mois;
$annee_echeance = $annee;
while ($i<10)
{
$jour_echeance = $jour_echeance +1;
	if ($jour_echeance >= 30) 
	{
	$mois_echeance = $mois_echeance +1;
	$jour_echeance = 1;
		if ($mois_echeance == 13)
		{
		$annee_echeance = $annee_echeance +1;
		$mois_echeance = 1;
		} 
	}
	$i = $i+1;
}

if($client=='0')
{
	echo "<p><center><h1>$lang_choix_client</p>";
	include('form_devis.php');
	exit;
}
$sql_nom = "SELECT  nom, nom2 FROM " . $tblpref ."client WHERE num_client = $client";
$req = mysql_query($sql_nom) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
	$nom = $data['nom'];
	$nom = htmlentities($nom, ENT_QUOTES);
	$nom2 = $data['nom2'];
	$phrase = "$lang_devis_cree";
	$message = "$phrase $nom $nom2 $lang_bon_cree2 $date";
}
mysql_select_db($db) or die ("Could not select $db database");
$sql1 = "INSERT INTO " . $tblpref ."devis(client_num, date, echeance) VALUES ('$client', '$annee-$mois-$jour','$annee_echeance-$mois_echeance-$jour_echeance')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
$rqSql = "SELECT num, article, prix_htva, uni FROM " . $tblpref ."article WHERE actif != 'non' ORDER BY article, prix_htva";
$result = mysql_query( $rqSql ) or die( "Exécution requête impossible.");
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!--CREATION DEVIS-->
<div class="portion">
    <!-- TITRE - CREATION DEVIS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        <?php echo $lang_donne_devis; ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_add">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_add">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - CREATION DEVIS -->
    <div class="content_traitement" id="add">
        <form name='formu2' method='post' action='devis_suite.php'>
            <table class="base" width="100%">
                <tr> 
                    <td class="right" width="30%"><?php echo $lang_article;?> :</td>
                    <td class="left" width="70%">
                        <?php
                        include("include/categorie_choix.php"); 
                        ?>
                    </td>
                </tr>
                <tr> 
                    <td class="right"> <?php echo $lang_quanti;?> :</td>
                    <td class="left"><input name='quanti' type='text' id='quanti' value="1" size='6' class="styled"></td>
                </tr>
                <tr>
                    <td class="right">PV (HTVA) :</td>
                    <td class="left"><input name='PV' type='text' id='PV' size='6' class="styled"> &euro;</td>
                </tr>
            </table>
            <div class="center">
                <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-check"></i><span><?php echo $lang_valid; ?></span></button>
            </div>
            <input name="nom" type="hidden" id="nom" value='<?php echo $nom; ?>'>
        </form>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>