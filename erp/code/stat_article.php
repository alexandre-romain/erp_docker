<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
<!--SHOW/HIDE-->
$(document).ready(function() {
	<?php 
	if (isset($_REQUEST['marque']) && $_REQUEST['marque'] != '' || isset($_REQUEST['nom']) && $_REQUEST['nom'] != '' || isset($_REQUEST['partnumber']) && $_REQUEST['partnumber'] != '') {
		?>
		$("#hide_search").hide();
		<?php
	}
	else {
		?>
		$("#show_search").hide();
		<?php
	}
	?>						   
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
<!--DATEPCIKER-->
$(function() {
	$( "#date_fin" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd/mm/yy" })
	$( "#date_debut" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd/mm/yy" })
});
<!--DATATABLES-->
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
		"pageLength" : 20,
		"order": [[0, 'desc']],
  	});
} );
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
?>
<?php
//Gestion des messages informatifs
include_once("include/message_info.php");
//On récupère la variable search, servant à savoir si une recherche a déjà été lancée et de supprimer le message "aucun résultats"
$search		=	$_REQUEST['search'];
$marque		=	$_REQUEST['marque'];
$nom		=	$_REQUEST['nom'];
$partnumber	=	$_REQUEST['partnumber'];
$date_debut	=	$_REQUEST['date_debut'];
$date_fin	=	$_REQUEST['date_fin'];
//Transformation des dates pour leurs utilisations en mysql
$datetemp = explode('-',$date_debut); //DATE DEBUT
$jour = $datetemp[0];
$mois = $datetemp[1];
$annee = $datetemp[2];
$date_debut=$annee."-".$mois."-".$jour;
$datetemp = explode('-',$date_fin); //DATE FIN
$jour = $datetemp[0];
$mois = $datetemp[1];
$annee = $datetemp[2];
$date_fin=$annee."-".$mois."-".$jour;
?>
<!--STATS-->
<div class="portion">
    <!-- TITRE - STATS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-search fa-stack-1x"></i>
        </span>
        Param&egrave;tres de recherche
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
    <!-- CONTENT - STATS -->
    <div class="content_traitement <?php if (isset($_REQUEST['marque']) && $_REQUEST['marque'] != '' || isset($_REQUEST['nom']) && $_REQUEST['nom'] != '' || isset($_REQUEST['partnumber']) && $_REQUEST['partnumber'] != '') {echo 'disp_none';}?>" id="search">
        <form action="./stat_article.php?search=oui" method="post">
        <table width="100%" class="base">
            <tr class="">
                <td class="right" width="50%">PartNumber :</td>
                <td class="left" width="50%"><input type="text" name="partnumber" id="partnumber" class="styled"></td>
            </tr>
            <tr class="">
                <td class="right">Nom :</td>
                <td class="left"><input type="text" name="nom" id="nom" class="styled"></td>
            </tr>
            <tr class="">
                <td class="right">Marque :</td>
                <td class="left">
                    <div class="styled-select-inline" style="width:60%">
                    <select name="marque" id="marque" class="styled-inline">
                        <option></option>
                        <?php
                        $sql="SELECT DISTINCT marque";
                        $sql.=" FROM ".$tblpref."article";
                        $sql.=" ORDER by marque";
                        $req=mysql_query($sql);
                        while ($obj=mysql_fetch_object($req)) {
                            $marque_obj=$obj->marque;
                            echo '<option value="'.$marque_obj.'">'.$marque_obj.'</option>';							   
                        }
                        ?>
                    </select>
                    </div>
                </td>
            </tr>
            <tr class="">
                <td class="right">Date de d&eacute;but :</td>
                <td class="left"><input type="text" name="date_debut" id="date_debut" class="styled"></td>
            </tr>
            <tr class="">
                <td class="right">Date de fin :</td>
                <td class="left"><input type="text" name="date_fin" id="date_fin" class="styled"></td>
            </tr>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-search"></i><span>Rechercher</span></button>
        </div>
        </form>
	</div>
</div>
<!-- FIN FORM RECHERCHE - DEBUT TABLE INFO GENERALES -->
<?php
if (isset($_REQUEST['marque']) && $_REQUEST['marque'] != '' || isset($_REQUEST['nom']) && $_REQUEST['nom'] != '' || isset($_REQUEST['partnumber']) && $_REQUEST['partnumber'] != '') {
	$sql="SELECT cb.tot_art_htva, cb.to_tva_art, cb.quanti, a.prix_htva as pa";
	$sql.=" FROM ".$tblpref."cont_bl as cb";
	$sql.=" LEFT JOIN ".$tblpref."article as a ON cb.article_num=a.num";
	$sql.=" LEFT JOIN ".$tblpref."bl as bl ON bl.num_bl = cb.bl_num";
	$sql.=" LEFT JOIN ".$tblpref."facture as f ON f.num=bl.fact_num";
	if (!empty($_REQUEST['partnumber'])) {
		$sql.=" WHERE a.reference='".$partnumber."'";
	}
	if (!empty($_REQUEST['nom'])) {
		$sql.=" WHERE a.article LIKE '%".$nom."%'";
	}
	if (!empty($_REQUEST['marque'])) {
		$sql.=" WHERE a.marque='".$marque."'";
	}
	if (!empty($_REQUEST['date_debut']) && !empty($_REQUEST['date_fin'])) {
		$sql.=" AND f.date_fact BETWEEN '".$date_debut."' AND '".$date_fin."'";
	}
	$req=mysql_query($sql);
	while ($obj=mysql_fetch_object($req)) {
		$montant_htva=$obj->tot_art_htva;
		$montant_tva=$obj->to_tva_art;
		$pa=$obj->pa;
		
		$multiplier=$obj->quanti;
		$nombre=1*$multiplier;
		$nombre_tot=$nombre_tot+$nombre;
		
		$pa_inter=$pa*$multiplier;
		
		$pa_tot=$pa_tot+$pa_inter;
		
		$montant_tot_htva=$montant_tot_htva+$montant_htva;
		$montant_tot_tva=$montant_tot_tva+$montant_tva;		
	}
	$montant_tot_ttc=$montant_tot_htva+$montant_tot_tva;
	?>
    <!--STATS-->
<div class="portion">
    <!-- TITRE - STATS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pie-chart fa-stack-1x"></i>
        </span>
        Statistiques de vente - <?php if ($marque != '') { echo 'Marque : '.$marque; } if ($nom != '') { echo 'Nom : '.$nom; } if ($partnumber != '') { echo 'PartNumber :'.$partnumber; }?> 
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
        <table class="base" width="100%">
            <tr>
                <td class="right" width="50%">Nombre d'articles vendus :</td>
                <td class="left" width="50%"><?php if ($nombre_tot != '') {echo $nombre_tot;} else {echo '0';} ?></td>
            </tr>
            <tr>
                <td class="right">P.A. Total :</td>
                <td class="left"><?php if ($pa_tot != '') {echo $pa_tot;} else {echo '0';} ?> &euro;</td>
            </tr>
            <tr>
                <td class="right">C.A. Total HTVA :</td>
                <td class="left"><?php if ($montant_tot_htva != '') {echo $montant_tot_htva;} else {echo '0';} ?> &euro;</td>
            </tr>
            <tr>
                <td class="right">C.A. Total TTC :</td>
                <td class="left"><?php echo $montant_tot_ttc; ?> &euro;</td>
            </tr>
        </table> 
    </div>
</div>   

<!--STATS-->
<div class="portion">
    <!-- TITRE - STATS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        Factures - <?php if ($marque != '') { echo 'Marque : '.$marque; } if ($nom != '') { echo 'Nom : '.$nom; } if ($partnumber != '') { echo 'PartNumber : '.$partnumber; }?>
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
    <!-- CONTENT - STATS -->
    <div class="content_traitement" id="list">
        <table class="base" width="100%" id="listing">
        	<thead>
                <tr>
                    <th class="">Num. Facture</th>
                    <th class="">Client</th>
                    <th class="">Montant</th>
                    <th class="">Date</th>
                    <th class="">Afficher</th>
                </tr>
            </thead>
            <tbody>
				<?php
                //On construit la request SQL
                $sql="SELECT DISTINCT f.total_fact_ttc as montant, c.nom as nom, f.num as num, f.date_fact as datefact";
                $sql.=" FROM ".$tblpref."facture as f";
                $sql.=" LEFT JOIN ".$tblpref."bl as bl ON bl.fact_num = f.num";
                $sql.=" LEFT JOIN ".$tblpref."cont_bl as cbl ON cbl.bl_num = bl.num_bl";
                $sql.=" LEFT JOIN ".$tblpref."article as a ON a.num = cbl.article_num";
                $sql.=" LEFT JOIN ".$tblpref."client as c ON c.num_client = f.CLIENT";
                if (!empty($_REQUEST['partnumber'])) {
                    $sql.=" WHERE a.reference='".$partnumber."'";
                }
                if (!empty($_REQUEST['nom'])) {
                    $sql.=" WHERE a.article LIKE '%".$nom."%'";
                }
                if (!empty($_REQUEST['marque'])) {
                    $sql.=" WHERE a.marque='".$marque."'";
                }
                if (!empty($_REQUEST['date_debut']) && !empty($_REQUEST['date_fin'])) {
                    $sql.=" AND f.date_fact BETWEEN '".$date_debut."' AND '".$date_fin."'";
                }
                $sql.="ORDER BY f.date_fact DESC";
                $req=mysql_query($sql);
                while ($obj=mysql_fetch_object($req)) {
                    ?>
                    <tr>
                        <td><?php echo $obj->num; ?></td>
                        <td><?php echo $obj->nom; ?></td>
                        <td><?php echo $obj->montant; ?></td>
                        <td><?php echo $obj->datefact; ?></td>
                        <td>
                            <a href="fpdf/facture_pdf.php?num=<?php echo $obj->num; ?>&amp;pdf_user=adm" target="_blank" class="no_effect">
                            	<i class="fa fa-print fa-fw fa-2x action" title="Imprimer la facture"></i>
                            </a>
                        </td>
                    </tr>
                <?php
                } //end while	
                ?>
            </tbody>
        </table>
	</div>
</div>    
<?php
} //end if->isset
?>
<?php
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>