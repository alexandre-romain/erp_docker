<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_search").hide();
	$("#hide_search").click(function(){
		$("#search").hide(500);	
		$("#hide_search").hide();
		$("#show_search").show();
	});
	$("#show_search").click(function(){
		$("#search").show(500);	
		$("#hide_search").show();
		$("#show_search").hide();
	});
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
<!--DATATABLES-->
$(document).ready(function() {
    $('#stating').DataTable( {
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
		"pageLength" : 20,
		"order": [[0, 'desc']],
  	});
} );
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!--FILTRE-->
<div class="portion">
    <!-- TITRE - FILTRE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-filter fa-stack-1x"></i>
        </span>
        Filtres
        <span class="fa-stack fa-lg add" style="float:right" id="show_search">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_search">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - FILTRE -->
    <div class="content_traitement" id="search">
        <form action="ca_parclient.php" method="post" name="annee">
        	<table class="base" width="100%">
            	<tr>
        			<td class="right" width="50%">Année :</td>
                    <td class="left" width="50%">
                    <div class="styled-select-inline" style="width:60%">
                    <select name="an" class="styled-inline">
                        <?php
                        //Permet de lister les années ==> Changer $i < 2016 pour augmenter la valeur finale; changer $i=2004 pour modifier la valeur initiale
                        for ($i=2004 ; $i < 2016 ; $i++) {
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
if($_POST['an'] !=''){ //On récupère la date envoyée pour afficher les résultats de cette année
$annee = $_POST['an'];
}	
if ($annee =='') { //Si pas de recherche préalable, on défini l'année à l'année courante
$annee = date("Y");  
}
$sql = "SELECT num_client FROM " . $tblpref ."client";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$nb = mysql_num_rows($req);
?>
<!--STATS-->
<div class="portion">
    <!-- TITRE - STATS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pie-chart fa-stack-1x"></i>
        </span>
        <?php echo "$lang_ca_par_client $annee" ?>
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
        <table class="base" width="100%" id="stating">
        	<thead>
                <tr> 
                    <th class=""><?php echo $lang_client; ?></th>
                    <th class=""><?php echo $lang_montant; ?></th>
                    <th class=""><?php echo $lang_pourcentage;?></th>
                </tr>
            </thead>
            <tbody>
				<?php
                //pour le total
                $sql = "SELECT SUM(tot_htva)";
                $sql.=" FROM " .$tblpref."bon_comm";
                $sql.=" WHERE YEAR(date)=".$annee."";
                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                $data = mysql_fetch_array($req);
                $total = $data['SUM(tot_htva)'];
                //Boucle sur les BL, on calcule le total des ventes par client
                for ($i=1;$i<=$nb;$i++)
                {
                    $sql ="SELECT SUM(tot_htva), nom";
                    $sql.=" FROM " . $tblpref ."bon_comm"; 
                    $sql.=" LEFT JOIN " . $tblpref ."client on client_num = num_client"; 
                    $sql.=" WHERE client_num =".$i." AND YEAR(date) = ".$annee."";
                    $sql.=" GROUP BY nom";
                    $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                    if ($data = mysql_fetch_array($req)) {
                        $nom = $data['nom'];
                        $tot = montant_financier ($data['SUM(tot_htva)']);
                        $pourcentage = number_format( round( ($tot*100)/$total), 0, ",", " ");
                        ?>
                        <tr>
                            <td class=''><?php echo $nom; ?></td>
                            <td class=''><?php echo $tot; ?></td>
                            <td class=''><?php echo stat_baton_horizontal("$pourcentage %"); ?></td>
                        </tr>
                    <?php
                    }
                }
                ?>
            </tbody>
       	</table>
        <br/>
        <table class="base" width="100%">
            <tfoot>
                <tr> 
                    <th class='right' width="50%"><?php echo $lang_total; ?> :</th>
                    <th class='left' width="50%"><?php echo montant_financier ($total); ?></th>
                </tr>
            </tfoot>
        </table>
	</div>
</div>
<?php
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>