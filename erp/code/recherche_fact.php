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
$(document).ready(function() {
    $('#fact').DataTable( {
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
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD

$tri=isset($_POST['tri'])?$_POST['tri']:"";

$requete = "SELECT * FROM " . $tblpref ."facture RIGHT JOIN " . $tblpref ."client on " . $tblpref ."facture.client = num_client WHERE num !=''";
//on verifie le client
if ( isset ( $_POST['listeville'] ) && $_POST['listeville'] != '')
{
$requete .= " AND client='" . $_POST['listeville'] . "'";
}
//on verifie le numero
if ( isset ( $_POST['numero'] ) && $_POST['numero'] != '')
{
$requete .= " AND num='" . $_POST['numero'] . "'";
}
//on verifie le mois
if ( isset ( $_POST['mois'] ) && $_POST['mois'] != '')
{
$requete .= " AND MONTH(date_fact)='" . $_POST['mois'] . "'";
}
//on verifie l'année
if ( isset ( $_POST['annee'] ) && $_POST['annee'] != '')
{
$requete .= " AND Year(date_fact)='" . $_POST['annee'] . "'";
}
//on verifie le jour
if ( isset ( $_POST['jour'] ) && $_POST['jour'] != '')
{
$requete .= " AND DAYOFMONTH(date_fact)='" . $_POST['jour'] . "'";
}
//on verifie le montant
if ( isset ( $_POST['montant'] ) && $_POST['montant'] != '')
{
$requete .= " AND trim(total_fact_T.T.C) =" . $_POST[montant] . "";
}
//
if($use_payement =='y'){
if ( isset ( $_POST['payement'] ) && $_POST['payement'] != '')
{
$requete .= " AND payement ='" . $_POST[payement] . "'";
}
}else{
if ( isset ( $_POST['payement'] ) && $_POST['payement'] != '')
{
if($_POST['payement'] =='non'){
$requete .= " AND payement ='non'";
}else{
$requete .= " AND payement !='non'";
}
}
}
if ($user_fact == 'r') {
$requete .="  and " . $tblpref ."client.permi LIKE '$user_num,' 
		 		or  " . $tblpref ."client.permi LIKE '%,$user_num,' 
					or  " . $tblpref ."client.permi LIKE '%,$user_num,%' 
				 or  " . $tblpref ."client.permi LIKE '$user_num,%' ";
}
//

$requete .= " ORDER BY $tri";
//on execute
$req = mysql_query($requete) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
?>
<!--RECHERCHE FACTURES-->
<div class="portion">
    <!-- TITRE - RECHERCHE FACTURES -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-trophy fa-stack-1x"></i>
        </span>
        <?php echo $lang_res_rech; ?>
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
    <!-- CONTENT - RECHERCHE FACTURES -->
    <div class="content_traitement" id="search">
    	<table class="base" width="100%" id="fact">
        	<thead>
            <tr>
            	<th>Fac N&deg;</th> 
                <th>Client</th>
                <th>Date du bon</th> 
                <th>$lang_total_h_tva</th> 
                <th>Total T.T.C</th>
                <th>Pay&eacute; ?</th>
                <th>Action</th>
           	</tr>
            </thead>
            <tbody>
			<?php
            while($data = mysql_fetch_array($req)) {
				$num = $data['num'];
				$total = $data['total_fact_h'];
				$tva = $data['total_fact_ttc'];
				$date = $data['date_fact'];
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
                    <td class=""><?php echo ucfirst($pay) ;?></td>
                    <td class="">
                        <a href="fpdf/facture_pdf.php?num=<?php echo $num; ?>&amp;nom=<?php echo $nom; ?>&amp;pdf_user=adm" target="_blank" class="no_effect">
                            <i class="fa fa-print fa-fw fa-2x action" title="Imprimer"></i>
                        </a>
                        <a href="edit_fact.php?num_fact=<?php echo"$num";?>" class="no_effect">
                        	<i class="fa fa-pencil fa-fw fa-2x action" title="Editer"></i>
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
include("chercher_factures.php");
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>