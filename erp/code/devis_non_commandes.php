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
<!-- DT DEVIS PERDUS -->
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
	});
} );
function confirmDelete()
{
var agree=confirm('<?php echo "$lang_con_dev_effa"; ?>');
if (agree)
 return true ;
else
 return false ;
}
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD

$num_dev=isset($_GET['num_dev'])?$_GET['num_dev']:"";
if ($num_dev !='') { 
	$sql2 = "UPDATE " . $tblpref ."devis SET resu='per' WHERE num_dev= $num_dev";
	mysql_query($sql2) or die('Erreur SQL2 !<br>'.$sql2.'<br>'.mysql_error());
	$message=$lang_de_per;  
}
$sql = "SELECT num_dev, tot_htva, tot_tva, DATE_FORMAT(date,'%d/%m/%Y') AS date, nom FROM " . $tblpref ."devis RIGHT JOIN " . $tblpref ."client on " . $tblpref ."devis.client_num = num_client WHERE num_dev >0 AND  resu = 'per' ORDER BY " . $tblpref ."devis.num_dev DESC ";
if ($user_dev == r) { 
	$sql = "SELECT num_dev, tot_htva, tot_tva, DATE_FORMAT(date,'%d/%m/%Y') AS date, nom FROM " . $tblpref ."devis RIGHT JOIN " . $tblpref ."client on " . $tblpref ."devis.client_num = num_client WHERE num_dev >0 AND  resu = 'per'  
	 AND " . $tblpref ."client.permi LIKE '$user_num,' 
	 or  " . $tblpref ."client.permi LIKE '%,$user_num,' 
	 or  " . $tblpref ."client.permi LIKE '%,$user_num,%' 
	 or  " . $tblpref ."client.permi LIKE '$user_num,%' ORDER BY " . $tblpref ."devis.num_dev DESC";
}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!--DEV PERDUS-->
<div class="portion">
    <!-- TITRE - DEV PERDUS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        <?php echo $lang_devis_perdus; ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_list">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_list">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - DEV PERDUS -->
    <div class="content_traitement" id="list">
        <table class="base" width="100%" id="listing">
        	<thead>
                <tr>
                    <th class=""><?php echo $lang_devis_numero; ?></th>
                    <th class=""><?php echo $lang_client; ?></th>
                    <th class=""><?php echo $lang_devis_date; ?></th>
                    <th class=""><?php echo $lang_total_h_tva; ?></th>
                    <th class=""><?php echo $lang_total_ttc; ?></th>
                    <th class=""><?php echo $lang_action; ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            while($data = mysql_fetch_array($req))
            {
                $num_dev = $data['num_dev'];
                $total = $data['tot_htva'];
                $tva = $data['tot_tva'];
                $date = $data['date'];
                $nom = $data['nom'];
                $ttc = $total + $tva ;
                ?>
                <tr> 
                    <td class=''><?php echo $num_dev; ?></td>
                    <td class=''><?php echo $nom; ?></td>
                    <td class=''><?php echo $date; ?></td>
                    <td class=''><?php echo montant_financier($total); ?></td>
                    <td class=''><?php echo montant_financier($ttc); ?></td>
                    <td class=''>
                        <a href="./delete_dev_suite.php?num_dev=<?php echo $num_dev;?>&nom=<?php echo $nom;?>" onClick='return confirmDelete()' class="no_effect">
                        	<i class="fa fa-trash fa-2x fa-fw del" title="Supprimer"></i>
                        </a>
                        <a href="./fpdf/devis_pdf.php?num_dev=<?php echo $num_dev;?>&nom=<?php echo $nom;?>&pdf_user=adm" target='_blank' class="no_effect">
                        	<i class="fa fa-print fa-2x fa-fw del" title="Imprimer"></i>
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
</center>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
