<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_list").hide();
	$("#hide_list").click(function(){
		$("#list").hide(500);	
		$("#hide_list").hide();
		$("#show_list").show();
	});
	$("#show_list").click(function(){
		$("#list").show(500);	
		$("#hide_list").show();
		$("#show_list").hide();
	});
});
<!-- DT LISTE ABOS -->
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
		"pageLength" : 10,
		"order": [[0, 'desc']],
  	});
} );
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
//Gestion des messages informatifs
include_once("include/message_info.php");
//Requête récupération abo en cours
$sql = "SELECT client, DATE_FORMAT(date,'%d/%m/%Y') AS date, tarif, temps_restant, deplacements_restant, actif FROM " . $tblpref ."abos WHERE actif = 'oui' ORDER BY date DESC";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<!--FILTRES-->
<div class="portion">
    <!-- TITRE - LISTE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        Liste des Abonnements
        <span class="fa-stack fa-lg add" style="float:right" id="show_list">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_list">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <div class="content_traitement" id="list">
        <table class="base" width="100%" id="listing">
        	<thead>
            <tr>
                <th class="">Client</th>
                <th class="">Tarif</th>
                <th class="">Temps Restant (mn)</th>
                <th class="">Déplacements Restant</th>
            </tr>
            </thead>
            <tbody>
            <?
            $nombre =1;
            while($data = mysql_fetch_array($req))
            {
                $client = $data['client'];
                $tarif = $data['tarif'];
                $temps_restant = $data['temps_restant'];
                $deplacements_restant = $data['deplacements_restant'];
                
                $sql2 = "SELECT * FROM " . $tblpref ."client WHERE num_client = $client";
                $req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
                $data2 = mysql_fetch_array($req2);
          
                $nom_client = $data2['nom'];
        
                $sql3 = "SELECT * FROM " . $tblpref ."tarifs WHERE ID = $tarif";
                $req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());
                $data3 = mysql_fetch_array($req3);
                
                $description_tarif = $data3['description'];
                
                $nombre = $nombre +1;
                if($nombre & 1) {
                    $line="0";
                }
                else {
                    $line="1";
                }
                ?>
                <tr class="">
                    <td class=""><?php echo $nom_client; ?></td>
                    <td class=""><?php echo $description_tarif; ?></td>
                    <td class=""><?php echo $temps_restant; ?></td>
                    <td class=""><?php echo $deplacements_restant; ?></td>
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
