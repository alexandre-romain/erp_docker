<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_stat").hide();
	$("#hide_stat").click(function(){
		$("#stat").hide(500);	
		$("#hide_stat").hide();
		$("#show_stat").show();
	});
	$("#show_stat").click(function(){
		$("#stat").show(500);	
		$("#hide_stat").show();
		$("#show_stat").hide();
	});
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
//Gestion des messages informatifs
include_once("include/message_info.php");
$client=isset($_POST['client'])?$_POST['client']:"";	 
$annee=isset($_POST['an'])?$_POST['an']:"";	 
$sql = "SELECT nom from " . $tblpref ."client WHERE num_client = $client";
$req = mysql_query($sql);
$data = mysql_fetch_array($req);
$client_nom = $data["nom"];
$calendrier = calendrier_local_mois ();
$sql = "SELECT SUM(tot_htva) FROM " . $tblpref ."bon_comm LEFT JOIN " . $tblpref ."client on client_num = num_client WHERE YEAR(date) = $annee  AND client_num = $client";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$data = mysql_fetch_array($req);
$total = $data['SUM(tot_htva)'];
?>
<!--STATS-->
<div class="portion">
    <!-- TITRE - STATS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pie-chart fa-stack-1x"></i>
        </span>
        <?php echo "$lang_client: ".$client_nom." - P&eacuteriode : ".$annee; ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_stat">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_stat">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - STATS -->
    <div class="content_traitement" id="stat">
        <table class="base" width="100%">
        	<thead>
            <tr>
                <th class=""><?php echo $lang_mois; ?></th>
                <th class=""><?php echo $lang_ca_htva; ?></th>
                <th class=""><?php echo $lang_pourcentage; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            for ($i=1;$i<=12;$i++)
            {
                $sql = "SELECT SUM(tot_htva) FROM " . $tblpref ."bon_comm LEFT JOIN " . $tblpref ."client on client_num = num_client WHERE MONTH(date) = \"$i\" AND YEAR(date) = $annee  AND client_num = $client";
                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                $data = mysql_fetch_array($req);
                $nom = $data['nom'];
                $tot = $data['SUM(tot_htva)'];
                $pourcentage = round($tot / $total * 100.0);
                ?>
                <tr>
                    <td class=''><?php echo ucfirst($calendrier[$i]); ?></td>
                    <td class=''><?php echo montant_financier ($tot); ?></td>
                    <td class=''><?php echo stat_baton_horizontal("$pourcentage %"); ?></td>  
                </tr>
            <?php
            }
        	?>
            </tbody>
        </table>
	</div>
</div>
<?php
//On inclu la recherche
include_once("form_stat_client.php");
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
