<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
function confirmDelete()
{
	var agree=confirm('<?php echo "$lang_con_effa"; ?>');
	if (agree)
	 return true ;
	else
	 return false ;
}
$(document).ready(function() {
	$( "#show_list" ).hide();
	$( "#show_list" ).click(function() {
		$( "#list" ).show(500);
		$( "#show_list" ).hide();
		$( "#hide_list" ).show();
	});
	$( "#hide_list" ).click(function() {
		$( "#list" ).hide(500);
		$( "#show_list" ).show();
		$( "#hide_list" ).hide();
	});
});
<!-- DT LISTE COMMANDES -->
$(document).ready(function() {
    $('#encours').DataTable( {
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
$mois = date("m");
$sql = "SELECT client_num, num_bl, tot_htva, tot_tva, nom, DATE_FORMAT(date,'%d/%m/%Y') AS date 
FROM " . $tblpref ."bl 
RIGHT JOIN " . $tblpref ."client on " . $tblpref ."bl.client_num = num_client 
WHERE fact !='ok'";
if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '') {
	$sql .= " ORDER BY " . $_GET[ordre] . " ASC";
}
else {
	$sql .= "ORDER BY " . $tblpref ."bl.`num_bl` DESC";
}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<!--RECHERCHE-->
<div class="portion">
    <!-- TITRE - RECHERCHE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        Liste des BL en cours
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
    <!-- CONTENT - RECHERCHE -->
    <div class="content_traitement" id="list">
        <table class="base" width="100%" id="encours">
        	<thead>
            <tr>
                <th class=""><?php echo $lang_numero; ?></th>
                <th class=""><?php echo $lang_client; ?></th>
                <th class=""><?php echo $lang_date; ?></th>
                <th class=""><?php echo $lang_total_h_tva; ?></th>
                <th class=""><?php echo $lang_tot_tva; ?></th>
                <th class=""><?php echo $lang_action; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            while($data = mysql_fetch_array($req))
            {
                $num_bl = $data['num_bl'];
                $total = $data['tot_htva'];
                $tva = $data['tot_tva'];
                $date = $data['date'];
                $nom = $data['nom'];
                $nom_html = urlencode($nom);
                $num_client= $data['client_num'];
                ?>
                <tr class="">
                    <td class=""><?php echo $num_bl; ?></td>
                    <td class=""><?php echo $nom; ?></td>
                    <td class=""><?php echo $date; ?></td>
                    <td class=""><?php echo montant_financier($total); ?></td>
                    <td class=""><?php echo montant_financier($tva); ?></td>
                    <td class="">
                        <a href="edit_bl.php?num_bl=<?php echo $num_bl;?>&nom=<?php echo $nom_html;?>" class="no_effect">
                        	<i class="fa fa-pencil fa-fw fa-2x action" title="Modifier"></i>
                        </a>
                        <a href="fpdf/bl_pdf.php?num_bl=<?php echo $num_bl; ?>&amp;nom=<?php echo $nom_html; ?>&amp;pdf_user=adm" target="_blank" class="no_effect">
                        	<i class="fa fa-print fa-fw fa-2x action" title="Imprimer"></i>
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
