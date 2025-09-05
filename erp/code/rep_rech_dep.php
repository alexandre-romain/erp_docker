<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
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
<!-- DT LISTE RESULTS -->
$(document).ready(function() {
    $('#listing_result').DataTable( {
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
$tri=isset($_POST['tri'])?$_POST['tri']:"";
$requete = "SELECT DATE_FORMAT(date,'%d/%m/%Y')as date, num, prix, lib, fournisseur FROM " . $tblpref ."depense WHERE 1";
//on verifie le client
if ( isset ( $_POST['fournisseur'] ) && $_POST['fournisseur'] != '')
{
$requete .= " AND fournisseur='" . $_POST['fournisseur'] . "'";
}
//on verifie le numero
if ( isset ( $_POST['numero'] ) && $_POST['numero'] != '')
{
$requete .= " AND num='" . $_POST['numero'] . "'";
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
$requete .= " AND trim(prix)='" . $_POST['montant'] . "'";
}
$requete .= " ORDER BY $tri";  
//on execute
$req = mysql_query($requete) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
?>
<!--AJOUT STOCK-->
<div class="portion">
    <!-- TITRE - AJOUT STOCK -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-trophy fa-stack-1x"></i>
        </span>
        <?php echo $lang_res_rech;?>
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
    <!-- CONTENT - AJOUT STOCK -->
    <div class="content_traitement" id="result">
        <table width='100%' class='base' id="listing_result">
            <thead>
                <tr>
                    <th>Bon N&deg;</th> 
                    <th>Fournisseur</th>
                    <th>Date dépense</th>
                    <th>Prix</th>
                    <th>Libellé</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($data = mysql_fetch_array($req)) {
                    $num = $data['num'];
                    $total = $data['prix'];
                    $lib = $data['lib'];
                    $date = $data['date'];
                    $nom = $data['fournisseur'];
                    ?>
                    <tr>
                        <td class=''><?php echo $num; ?></td>
                        <td class=''><?php echo $nom; ?></td>
                        <td class=''><?php echo $date; ?></td>
                        <td class=''><?php echo montant_financier($total); ?></td>
                        <td class=''><?php echo $lib; ?></td>
                        <td class=''>
                            <a href="edit_dep.php?num_dep=<?php echo $num; ?>" class="no_effect">
                            	<i class="fa fa-pencil fa-fw fa-2x action" title="&Eacute;diter"></i>
                            </a>
                            <a href="delete_dep.php?num=<?php echo $num; ?>" onClick="return confirmDelete('<?php echo "Etes-vous sûr de vouloir effacer la ligne n° $num ?"; ?>')" class="no_effect"> 
                                <i class="fa fa-trash fa-fw fa-2x del" title="Supprimer"></i>
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
include("chercher_dep.php");	
?>