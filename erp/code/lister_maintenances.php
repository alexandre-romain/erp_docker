<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_liste").hide();
	$("#hide_liste").click(function(){
		$("#liste").hide(500);	
		$("#hide_liste").hide();
		$("#show_liste").show();
	});
	$("#show_liste").click(function(){
		$("#liste").show(500);	
		$("#hide_liste").show();
		$("#show_liste").hide();
	});
});
<!-- DT LISTE CONTRATS -->
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
//Gestion des messages informatifs
include_once("include/message_info.php");
//On récupère les contrats actifs.
$sql = "SELECT * FROM " . $tblpref ."maintenance Order by Datefin";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<!--LISTE EXISTANT-->
<div class="portion">
    <!-- TITRE - LISTE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        Liste des contrats de maintenance
        <span class="fa-stack fa-lg add" style="float:right" id="show_liste">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_liste">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <div class="content_traitement" id="liste">
        <table class="base" width="100%" id="listing">
            <thead>
            <tr>
                <th class="">Num</th>
                <th class="">Client</th>
                <th class="">Date début</th>
                <th class="">Date fin</th>
                <th class="">Action</th>
            </tr>
            </thead>
            <tbody>
            <?
            $nombre =1;
            while($data = mysql_fetch_array($req))
            {
                $id = $data['Id'];
                $idcli = $data['Idcli'];
                $datedeb = $data['Datedeb'];
                $datefin = $data['Datefin'];		
                $sql2 = "SELECT * FROM " . $tblpref ."client WHERE num_client = $idcli";
                $req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
                $data2 = mysql_fetch_array($req2); 
                $nom_client = $data2['nom'];
                $nombre = $nombre +1;
                if($nombre & 1){
                $line="0";
                }else{
                $line="1";
                }
                ?>
                <tr class="">
                    <td class="" align="center"><?php echo $id; ?></td>
                    <td class="" align="center"><?php echo $nom_client; ?></td>
                    <td class="" align="center"><?php echo dateUSA_to_dateEU($datedeb); ?></td>
                    <td class="" align="center"><?php echo dateUSA_to_dateEU($datefin); ?></td>
                    <td class="">
                        <a href='#' onClick="return confirmDelete('<?php echo $nom_client."?"; ?>')">
                        	<img border=0 alt=editer src=image/plus.gif>
                        </a>
                    </td>
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

