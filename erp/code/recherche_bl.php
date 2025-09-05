<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$( "#show_result" ).hide();
	$( "#show_result" ).click(function() {
		$( "#result" ).show(500);
		$( "#show_result" ).hide();
		$( "#hide_result" ).show();
	});
	$( "#hide_result" ).click(function() {
		$( "#result" ).hide(500);
		$( "#show_result" ).show();
		$( "#hide_result" ).hide();
	});
});
<!-- DT RESULTATS -->
$(document).ready(function() {
    $('#results').DataTable( {
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
//Récupération du tri
$tri=isset($_POST['tri'])?$_POST['tri']:"";
$requete = "SELECT * FROM " . $tblpref ."bl RIGHT JOIN " . $tblpref ."client on " . $tblpref ."bl.client_num = num_client WHERE num_bl !=''";
//On check le cli
if ( isset ( $_POST['listeville'] ) && $_POST['listeville'] != '')
{
$requete .= " AND client_num='" . $_POST['listeville'] . "'";
}
//on verifie le numero
if ( isset ( $_POST['numero'] ) && $_POST['numero'] != '')
{
$requete .= " AND num_bl='" . $_POST['numero'] . "'";
}
//on verifie le mois
if ( isset ( $_POST['mois'] ) && $_POST['mois'] != '')
{
$requete .= " AND MONTH(date)='" . $_POST['mois'] . "'";
}
//on verifie l'année
if ( isset ( $_POST['annee'] ) && $_POST['annee'] != '')
{
$requete .= " AND Year(date)='" . $_POST['annee'] . "'";
}
//on verifie le jour
if ( isset ( $_POST['jour'] ) && $_POST['jour'] != '')
{
$requete .= " AND DAYOFMONTH(date)='" . $_POST['jour'] . "'";
}
//on verifie le montant
if ( isset ( $_POST['montant'] ) && $_POST['montant'] != '')
{
$requete .= " AND trim(tot_htva) =" . $_POST[montant] . "";
}
//
if ( isset ( $_POST['payement'] ) && $_POST['payement'] != '')
{
$requete .= " AND payement ='" . $_POST[payement] . "'";
}
//Gestion du tri
$requete .= " ORDER BY $tri";
//on execute
$req = mysql_query($requete) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
?>
<!--RESULTATS-->
<div class="portion">
    <!-- TITRE - RESULTATS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-trophy fa-stack-1x"></i>
        </span>
        R&eacute;sultats de la recherche
        <span class="fa-stack fa-lg add" style="float:right" id="show_result">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_result">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - RESULTATS -->
    <div class="content_traitement" id="result">
        <table class="base" width="100%" id="results">
            <thead>
                <tr>
                    <th>BL N&deg;</th> 
                    <th>Client</th>
                    <th>Date du bon</th>
                    <th><?php echo $lang_total_h_tva;?></th>
                    <th>Total T.T.C</th>
                    <th>pay</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
			<?php
            while($data = mysql_fetch_array($req))
            {
                $num = $data['num_bl'];
                $total = $data['tot_htva'];
                $tva = $data['tot_tva'];
                $date = $data['date'];
                $nom = $data['nom'];
                $debut = $data['date_deb'];
                $fin = $data['date_fin'];
                $client = $data['client'];
                $num_client = $data['num_client'];
                $pay = $data['payement'];
                ?>
                <tr class="">
                    <td class=""><?php echo $num ; ?></td>
                    <td class=""><?php echo $nom ; ?></td>
                    <td class=""><?php echo $date ;?></td>
                    <td class=""><?php echo montant_financier($total) ; ?></td>
                    <td class=""><?php echo montant_financier($tva) ; ?></td>
                    <td class=""><?php echo $pay ;?></td>
                    <td class="">
                        <a href="fpdf/bl_pdf.php?num_bl=<?php echo $num;?>&nom=<?php echo $nom;?>&pdf_user=adm" target="_blank" class="no_effect">
                        	<i class="fa fa-print fa-fw fa-2x action" title="Imprimer"></i>
                        </a>
                        <a href="edit_bl.php?num_bl=<?php echo $num;?>" class="no_effect">
                        	<i class="fa fa-pencil fa-fw fa-2x action"></i>
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
include("chercher_bl.php");		
?>
