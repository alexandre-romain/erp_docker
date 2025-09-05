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
	$("#show_result").hide();
	$("#hide_result").click(function(){
		$("#result").hide(500);	
		$("#hide_result").hide();
		$("#show_result").show();
	});
	$("#show_result").click(function(){
		$("#result").show(500);	
		$("#hide_result").show();
		$("#show_result").hide();
	});
});
<!-- DT LISTE COMMANDES -->
$(document).ready(function() {
    $('#results').DataTable( {
		"language": {
			"lengthMenu": 'Afficher <div class="styled-select-dt"><select class="styled-dt">'+
						'<option value="10">10</option>'+
						'<option value="20">20</option>'+
						'<option value="30">30</option>'+
						'<option value="40">40</option>'+
						'<option value="50">50</option>'+
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
///FINHEAD
$client=isset($_POST['listeville'])?$_POST['listeville']:"";
$numero=isset($_POST['numero'])?$_POST['numero']:"";
$mois=isset($_POST['mois'])?$_POST['mois']:"";
$jour=isset($_POST['jour'])?$_POST['jour']:"";
$annee=isset($_POST['annee'])?$_POST['annee']:"";
$montant=isset($_POST['montant'])?$_POST['montant']:"";
$tri=isset($_POST['tri'])?$_POST['tri']:"";
//Construction de la request de recherche
$requete = "SELECT DATE_FORMAT(date,'%d/%m/%Y')as date, num_bon, tot_htva, tot_tva, num_bon, nom FROM " . $tblpref ."bon_comm RIGHT JOIN " . $tblpref ."client on " . $tblpref ."bon_comm.client_num = num_client WHERE num_bon !=''";
//on verifie le client
if ( isset ( $_POST['listeville'] ) && $_POST['listeville'] != '')
{
	$requete .= " AND num_client='" . $_POST['listeville'] . "'";
}
//on verifie le numero
if ( isset ( $_POST['numero'] ) && $_POST['numero'] != '')
{
	$requete .= " AND num_bon='" . $_POST['numero'] . "'";
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
	$requete .= " AND trim(bon_comm.tot_htva)='" . $_POST['montant'] . "'";
}
$requete .= " ORDER BY $tri";  
//on execute
$req = mysql_query($requete) or die('Erreur SQL !<br>'.$requete.'<br>'.mysql_error());
?>
<!--RESULTATS RECHERCHE-->
<div class="portion">
    <!-- TITRE - RESULTATS RECHERCHE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-search fa-stack-1x"></i>
        </span>
        Resultats de la recherche
        <span class="fa-stack fa-lg add" style="float:right" id="show_result">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_result">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - RESULTATS RECHERCHE -->
    <div class="content_traitement" id="result">
        <table width="100%" class="base" id="results">
            <thead>
                <tr>
                    <th>Bon N&deg;</th> 
                    <th>Client</th>
                    <th>Date du bon</th>
                    <th><?php echo $lang_total_h_tva;?></th>
                    <th>Total T.V.A</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while($data = mysql_fetch_array($req))
            {
                $num_bon = $data['num_bon'];
                $total = $data['tot_htva'];
                $tva = $data['tot_tva'];
                $date = $data['date'];
                $nom = $data['nom'];
                ?>
                <tr>
                    <td class=''><?php echo $num_bon; ?></td>
                    <td class=''><?php echo $nom; ?> </td>
                    <td class=''><?php echo $date; ?> </td>
                    <td class=''><?php echo montant_financier($total); ?> </td>
                    <td class=''><?php echo montant_financier($tva); ?> </td>
                    <td class=''>
                        <a href="edit_bon.php?num_bon=<?php echo "$num_bon";?>&nom=<?php echo "$nom";?>" class="no_effect">
                        	<i class="fa fa-pencil fa-fw fa-2x action"></i>
                        </a>
                        <a href=delete_bon_suite.php?num_bon=<?php echo $num_bon; ?> &nom=<?php echo $nom; ?>  onClick='return confirmDelete()' class="no_effect">
                        	<i class="fa fa-trash fa-fw fa-2x action"></i>
                        </a>
                        <a href="fpdf/bon_pdf.php?num_bon=<?php echo $num_bon; ?>&nom=<?php echo $nom; ?>&pdf_user=adm" target="_blank" class="no_effect">
                        	<i class="fa fa-print fa-fw fa-2x action"></i>
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
include("chercher_commande.php");
?>