<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_selection").hide();
	$("#hide_selection").click(function(){
		$("#selection").hide(500);	
		$("#hide_selection").hide();
		$("#show_selection").show();
	});
	$("#show_selection").click(function(){
		$("#selection").show(500);	
		$("#hide_selection").show();
		$("#show_selection").hide();
	});
	$("#show_verif").hide();
	$("#hide_verif").click(function(){
		$("#verif").hide(500);	
		$("#hide_verif").hide();
		$("#show_verif").show();
	});
	$("#show_verif").click(function(){
		$("#verif").show(500);	
		$("#hide_verif").show();
		$("#show_verif").hide();
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
$mois = date("m");
$annee = date("Y");
$jour = date("d");
$step=isset($_POST['step'])?$_POST['step']:"";
if($step=="")
{		
	?>
    <!--SELECTION PERIODE-->
    <div class="portion">
        <!-- TITRE - SELECTION PERIODE -->
        <div class="choice_action">
            <span class="fa-stack fa-lg">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-calendar fa-stack-1x"></i>
            </span>
            S&eacute;lectionner une p&eacute;riode
            <span class="fa-stack fa-lg add" style="float:right" id="show_selection">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
            </span>
            <span class="fa-stack fa-lg del" style="float:right" id="hide_selection">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
            </span>
            <span class="fa-stack fa-lg action" style="float:right">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-info fa-stack-1x"></i>
            </span>
        </div>
        <!-- CONTENT - SELECTION PERIODE -->
        <div class="content_traitement" id="selection">
            <form name="form_export" method="post" action="listing_tva.php">
            <table class="base" width="100%">
                <tr>
                    <td class='right' width="50%"><?php echo $lang_date_deb; ?> :</td>
                    <td class='left' width="50%">
                        <input type="text" name="date_deb" value="<?php echo "1/$mois/$annee" ?>" readonly="readonly" class="styled datepicker"/>
                    </td>      
                </tr>
                <tr>
                    <td class='right'><?php echo $lang_date_fin; ?> :</td>
                    <td class='left'>
                        <input type="text" name="date_fin" value="<?php echo "$jour/$mois/$annee" ?>" readonly="readonly" class="styled datepicker"/>
                    </td>
                </tr>
            </table>
            <div class="center">
                <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-check"></i><span>Valider</span></button>
            </div>  
            <input type="hidden" name="step" id="step" value="1" />
            </form>
    	</div>
    </div>
	<?php 
} 
else if($step=="1")
{
	//Traitement php export
	$date_deb=isset($_POST['date_deb'])?$_POST['date_deb']:"";
	$date_fin=isset($_POST['date_fin'])?$_POST['date_fin']:"";
	
	$date = explode('/',$date_deb);
	$jourD = $date[0];
	$moisD = $date[1];
	$anneeD = $date[2];
	$date_deb=$anneeD."-".$moisD."-".$jourD;

	$date = explode('/',$date_fin);
	$jourF = $date[0];
	$moisF = $date[1];
	$anneeF = $date[2];
	$date_fin=$anneeF."-".$moisF."-".$jourF;
	
	$sql = "SELECT max(num) AS fact_max,min(num) AS fact_min FROM " . $tblpref ."facture WHERE date_fact BETWEEN '".$date_deb."' AND '".$date_fin."'";
	$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	while($data = mysql_fetch_array($req))
	{
		$fact_min = $data['fact_min'];
		$fact_max = $data['fact_max'];
	}
	?>
    <!--SELECTION PERIODE-->
    <div class="portion">
        <!-- TITRE - SELECTION PERIODE -->
        <div class="choice_action">
            <span class="fa-stack fa-lg">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-database fa-stack-1x"></i>
            </span>
            V&eacute;rification des donn&eacute;es
            <span class="fa-stack fa-lg add" style="float:right" id="show_verif">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
            </span>
            <span class="fa-stack fa-lg del" style="float:right" id="hide_verif">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
            </span>
            <span class="fa-stack fa-lg action" style="float:right">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-info fa-stack-1x"></i>
            </span>
        </div>
        <!-- CONTENT - SELECTION PERIODE -->
        <div class="content_traitement" id="verif">
            <table class="base" width="100%">
                <tr>
                    <td class="">Num&eacute;ro de la premi&egrave;re facture &agrave; exporter : <?php echo $fact_min ?> </td>
                </tr>
                <tr>
                    <td class="">Num&eacute;ro de la derni&egrave;re facture &agrave; exporter : <?php echo $fact_max ?></td>
                </tr>
            </table>
            <div class="center">
            	<form name="form_export" method="post" action="listing_tva_export_client.php">
                    <input type="hidden" name="fact_min" id="fact_min" value="<?php echo $fact_min ?>" />
                    <input type="hidden" name="fact_max" id="fact_max" value="<?php echo $fact_max ?>" />            
                    <button class="button_act button--shikoba button--border-thin medium" type="submit" name="Submit"><i class="button__icon fa fa-file-code-o"></i><span>Exporter clients</span></button>
                </form>
                
                <form name="form_export" method="post" action="listing_tva_export_facture.php">
                    <input type="hidden" name="fact_min" id="fact_min" value="<?php echo $fact_min ?>" />
                    <input type="hidden" name="fact_max" id="fact_max" value="<?php echo $fact_max ?>" />
                    <button class="button_act button--shikoba button--border-thin medium" type="submit" name="Submit2"><i class="button__icon fa fa-file-code-o"></i><span>Exporter factures</span></button>
                </form>
                
            </div>  
    	</div>
    </div>
<?php
}
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
