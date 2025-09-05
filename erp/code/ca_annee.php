<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
<!--SHOW-HIDE-->
$(document).ready(function() {
	$("#show_filtre").hide();
	$("#hide_filtre").click(function(){
		$("#filtre").hide(500);	
		$("#hide_filtre").hide();
		$("#show_filtre").show();
	});
	$("#show_filtre").click(function(){
		$("#filtre").show(500);	
		$("#hide_filtre").show();
		$("#show_filtre").hide();
	});
	$("#show_ca").hide();
	$("#hide_ca").click(function(){
		$("#ca").hide(500);	
		$("#hide_ca").hide();
		$("#show_ca").show();
	});
	$("#show_ca").click(function(){
		$("#ca").show(500);	
		$("#hide_ca").show();
		$("#show_ca").hide();
	});
	$("#show_cae").hide();
	$("#hide_cae").click(function(){
		$("#cae").hide(500);	
		$("#hide_cae").hide();
		$("#show_cae").show();
	});
	$("#show_cae").click(function(){
		$("#cae").show(500);	
		$("#hide_cae").show();
		$("#show_cae").hide();
	});
	$("#show_ben").hide();
	$("#hide_ben").click(function(){
		$("#ben").hide(500);	
		$("#hide_ben").hide();
		$("#show_ben").show();
	});
	$("#show_ben").click(function(){
		$("#ben").show(500);	
		$("#hide_ben").show();
		$("#show_ben").hide();
	});
});
<!-- DT LIST TICKET -->
$(document).ready(function() {
    $('#listing').DataTable( {
		"language": {
			"lengthMenu": 'Afficher <div class="styled-select-dt"><select class="styled-dt">'+
						'<option value="10">10</option>'+
						'<option value="20">20</option>'+
						'<option value="30">30</option>'+
						'<option value="40">40</option>'+
						'<option value="50">50</option>'+
						'<option value="100">100</option>'+
						'<option value="-1">All</option>'+
						'</select></div> lignes'
		},
		"pageLength" : 100,
		"order": [[0, 'desc']],
  	});
} );
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!--FILTRES-->
<div class="portion">
    <!-- TITRE - FILTRES -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-filter fa-stack-1x"></i>
        </span>
        Filtres
        <span class="fa-stack fa-lg add" style="float:right" id="show_filtre">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_filtre">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - FILTRES -->
    <div class="content_traitement" id="filtre">
        <form action="ca_annee.php" method="post" name="annee">
        	<table class="base" width="100%">
            	<tr>
                	<td width='50%' class="right">Année :</td>
                    <td width='50%' class="left">
                    	<div class="styled-select-inline" style="width:30%">
                            <select name="an" class="styled-inline">
                                <?php
                                //Permet de lister les années ==> Changer $i < 2016 pour augmenter la valeur finale; changer $i=2004 pour modifier la valeur initiale
                                for ($i=2004 ; $i < 2030 ; $i++) {
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                }
                                ?>
                            </select>
                        </div>
            		</td>
            	</tr>
            </table>
            <div class="center">
                <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-filter"></i><span>Filtrer</span></button>
            </div>
        </form>
	</div>
</div>
<?php
if($_POST['an'] !=''){
	$annee = $_POST['an'];
}
if ($annee =='') { 
	$annee = date("Y");  
}
$liste_mois = calendrier_local_mois ();
$recettes = array ();
$depenses = array ();
$resultat_net = array ();
reset ($liste_mois);
while (list ($numero_mois, $nom_mois) = each ($liste_mois))
{
	$recettes [$numero_mois] = array ("htva" => 0.0, "tva" => 0.0, "T.T.C" => 0.0);
	$depenses [$numero_mois] = array ("htva" => 0.0, "tva" => 0.0, "T.T.C" => 0.0);
	$resultat_net [$mois] = 0.0;
}
// Recettes
$sql1 = "SELECT  MONTH(date_fact) numero_mois, SUM(total_fact_h) htva, (SUM(total_fact_ttc) - SUM(total_fact_h)) AS tva
        FROM " . $tblpref ."facture
        WHERE YEAR(date_fact) = $annee
		GROUP BY numero_mois;";
$req = mysql_query($sql1);
while ($data = mysql_fetch_array($req))
{
	$numero_mois = $data["numero_mois"];
	$recettes [$numero_mois] = $data;
	$recettes [$numero_mois]["T.T.C"] = $data ["htva"] + $data ["tva"];
}
// Dépenses
$sql2 = "SELECT MONTH(date) numero_mois, SUM(prix) htva
        FROM " . $tblpref ."depense
        WHERE YEAR(date) = $annee
		GROUP BY numero_mois";
$req = mysql_query($sql2);
while ($data = mysql_fetch_array($req))
{
	$numero_mois = $data["numero_mois"];
	$depenses [$numero_mois] = $data;
}
// Résultat net
reset ($liste_mois);
while (list ($numero_mois, $nom_mois) = each ($liste_mois))
{
	$numero_mois = $data->$numero_mois;
	$resultat_net [$numero_mois] = $recettes [$numero_mois]["htva"]  - $depenses [$numero_mois]["htva"] ;
}
?>
<!--CA/ANN-->
<div class="portion">
    <!-- TITRE - CA/ANN -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pie-chart fa-stack-1x"></i>
        </span>
        <?php echo "$lang_ca_annee $annee"; ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_ca">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_ca">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - CA/ANN -->
    <div class="content_traitement" id="ca">
        <table class="base" width="100%">
        	<thead>
            <tr>
                <th class="">Mois</th>
                <th class=""><?php echo $lang_depenses_htva; ?></th>
                <th class=""><?php echo $lang_ca_htva; ?></th>
                <th class=""><?php echo $lang_ca_ttc; ?></th>
                <th class=""><?php echo $lang_resultat_net; ?></th>
            </tr>
            </thead>
            <tbody>
			<?php
            reset ($liste_mois);
            while (list ($numero_mois, $nom_mois) = each ($liste_mois))
            {
            ?>
                <tr>
                    <td class=''><?php echo ucfirst ($nom_mois); ?></td>
                    <td class=''><?php echo montant_financier ($depenses [$numero_mois]["htva"]); ?></td>
                    <td class=''><?php echo montant_financier ($recettes [$numero_mois]["htva"]); ?></td>
                    <td class=''><?php echo montant_financier ($recettes [$numero_mois]["T.T.C"]); ?></td>
                    <td class=''><?php echo montant_financier ($recettes [$numero_mois]["htva"] - $depenses [$numero_mois]["htva"]); ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
	</div>
</div>
<?php
include("graph_ca.php");
include("graph_ben.php");
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
