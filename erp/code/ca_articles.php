<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
<!--SHOW-HIDE-->
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
$sql = "SELECT SUM(tot_art_htva)
        FROM " . $tblpref ."cont_bon RIGHT JOIN " . $tblpref ."bon_comm on bon_num = num_bon";      
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_array($req);
$tot2 = $data['SUM(tot_art_htva)'];
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$nb = mysql_num_rows($req);
?>
<!--LISTE-->
<div class="portion">
    <!-- TITRE - LISTE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pie-chart fa-stack-1x"></i>
        </span>
        Statistiques par article
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
    <!-- CONTENT - LISTE -->
    <div class="content_traitement" id="stat">
        <table class="base" width="100%" id="listing">
			<thead>
            <tr> 
                <th class=""><?php echo $lang_article; ?></th>
                <th class=""><?php echo $lang_prix_uni_abrege; ?></th>
                <th class=""><?php echo $lang_quantite; ?></th>
                <th class=""><?php echo $lang_total; ?></th>
                <th class=""><?php echo $lang_pourcentage; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT SUM( tot_art_htva ) total FROM " . $tblpref ."cont_bon";
            $req = mysql_query($sql);
            $data = mysql_fetch_array($req);
            $total = $data ["total"];
            $sql = "SELECT " . $tblpref ."article.num, SUM( tot_art_htva ) , article, prix_htva, SUM(quanti) nombre , uni
                    FROM " . $tblpref ."cont_bon
                    RIGHT JOIN " . $tblpref ."article ON " . $tblpref ."article.num = article_num
                            GROUP BY article
                    ORDER BY article";
            $req = mysql_query($sql)or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());;
        
            while ($data = mysql_fetch_array($req))
            {
                $tot = $data['SUM(tot_art_htva)'];
                $art = $data['article'];
                $quanti = $data['nombre'];
                $uni = $data['uni'];
                $prix = $data['prix_htva'];
                $tot = $quanti * $prix;
                $pourcentage = avec_virgule ($tot / $total * 100.0, 1);
                ?>
                <tr> 
                    <td class=''><?php echo $art; ?></td>
                    <td class=''><?php echo montant_financier ($prix); ?></td>
                    <td class=''><?php echo $quanti.$uni; ?></td>
                    <td class=''><?php echo montant_financier ($tot); ?></td>
                    <td class=''><?php echo stat_baton_horizontal("$pourcentage %", 1); ?></td>  
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
	</div>
</div>
<?php
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
