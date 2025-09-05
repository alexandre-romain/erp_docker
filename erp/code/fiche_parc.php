<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
//On récupère l'id du parc
$id_parc=$_REQUEST['id'];
//On récupère les informations du parc
$sql="SELECT * FROM ".$tblpref."parcs as p LEFT JOIN ".$tblpref."client as c ON p.cli=c.num_client WHERE id=".$id_parc."";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
$cli=$obj->cli;
$nom_cli=$obj->nom;
$nbr_server_parc=$obj->nbr_server;
$nbr_pc_parc=$obj->nbr_pc;
$nbr_laptop_parc=$obj->nbr_laptop;
$nbr_mobile_parc=$obj->nbr_mobile;
$nbr_printer_parc=$obj->nbr_printer;
////On regarde s'il existe un contrat ou un monitoring
///MONITORING
//PROP
$sql="SELECT * FROM ".$tblpref."monitoring WHERE id_parc='".$id_parc."' AND actif='1'";
$req=mysql_query($sql);
$monitoring_exists=mysql_num_rows($req);
if ($monitoring_exists > 0) {
	$obj=mysql_fetch_object($req);
	$facturation=$obj->type_fact;
	$id_monitoring=$obj->id;
}
//SIGN
$sql="SELECT * FROM ".$tblpref."monitoring WHERE id_parc='".$id_parc."' AND sign='1' AND actif='1'";
$req=mysql_query($sql);
$monitoring_sign_exists=mysql_num_rows($req);
if ($monitoring_sign_exists > 0) {
	$obj=mysql_fetch_object($req);
	//On récupère la périodicité de facturation.
	$facturation=$obj->type_fact;
	$id=$obj->id;
	//On récupère la prochaine échéance.
	$sql="SELECT MAX(echeance) as maxecheance FROM ".$tblpref."monitoring_echeance WHERE id_monitoring='".$id."'";
	$req=mysql_query($sql);
	$obj=mysql_fetch_object($req);
	$echeance=$obj->maxecheance;
}
///CONTRAT
//PROP
$sql="SELECT * FROM ".$tblpref."contrat_maintenance WHERE id_parc='".$id_parc."' AND actif='1'";
$req=mysql_query($sql);
$contrat_exists=mysql_num_rows($req);
if ($contrat_exists > 0) {
	$obj=mysql_fetch_object($req);
	$facturation=$obj->type_fact;
	$id_contrat=$obj->id;
}
//SIGN
$sql="SELECT * FROM ".$tblpref."contrat_maintenance WHERE id_parc='".$id_parc."' AND sign='1' AND actif='1'";
$req=mysql_query($sql);
$contrat_sign_exists=mysql_num_rows($req);
if ($contrat_sign_exists > 0) {
	$obj=mysql_fetch_object($req);
	//On récupère la périodicité de facturation.
	$facturation=$obj->type_fact;
	$id=$obj->id;
	//On récupère la prochaine échéance.
	$sql="SELECT MAX(echeance) as maxecheance FROM ".$tblpref."contrat_echeance WHERE id_contrat='".$id."'";
	$req=mysql_query($sql);
	$obj=mysql_fetch_object($req);
	$echeance=$obj->maxecheance;
}
//L'affichage de la facturation
if ($facturation == 'men') {
	$facturation_aff='Mensuelle';
}
else if ($facturation == 'tri') {
	$facturation_aff='Trimestrielle';
}
else if ($facturation == 'sem') {
	$facturation_aff='Semestrielle';
}
else if ($facturation == 'ann') {
	$facturation_aff='Annuelle';
}
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_parc").hide();
	$("#hide_parc").click(function(){
		$("#parc").hide(500);	
		$("#hide_parc").hide();
		$("#show_parc").show();
	});
	$("#show_parc").click(function(){
		$("#parc").show(500);	
		$("#hide_parc").show();
		$("#show_parc").hide();
	});
	$("#show_doc").hide();
	$("#hide_doc").click(function(){
		$("#doc").hide(500);	
		$("#hide_doc").hide();
		$("#show_doc").show();
	});
	$("#show_doc").click(function(){
		$("#doc").show(500);	
		$("#hide_doc").show();
		$("#show_doc").hide();
	});
	$("#show_maintenance").hide();
	$("#hide_maintenance").click(function(){
		$("#maintenance").hide(500);	
		$("#hide_maintenance").hide();
		$("#show_maintenance").show();
	});
	$("#show_maintenance").click(function(){
		$("#maintenance").show(500);	
		$("#hide_maintenance").show();
		$("#show_maintenance").hide();
	});
	$("#show_monitoring").hide();
	$("#hide_monitoring").click(function(){
		$("#monitoring_place").hide(500);	
		$("#hide_monitoring").hide();
		$("#show_monitoring").show();
	});
	$("#show_monitoring").click(function(){
		$("#monitoring_place").show(500);	
		$("#hide_monitoring").show();
		$("#show_monitoring").hide();
	});
});
<?php if ($contrat_exists == 0 || $monitoring_exists == 0) {
	?>
	$(document).ready(function() {
		calc_price_gen();
	});
	<?php
}
?>
$(document).ready(function() {
	calc_price_c();
});
$(document).ready(function() {
	calc_price_m();
});
<!-- DT HISTO CONTRAT -->
$(document).ready(function() {
    $('#listed').DataTable( {
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
<!-- DT HISTO CONTRAT -->
$(document).ready(function() {
    $('#listed_m').DataTable( {
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
/* AjaxForm UPDATE MANUEL NBR COMPOSANTES */
$(document).ready(function() { 
	$('.autosubmit').ajaxForm(function() { 
		refresh_parc('<?php echo $id_parc;?>'); 
	}); 
});
/* DATEPICKER */
$(function() {
	$( ".datep" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd-mm-yy" })
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!-- Message suppression contrat -->
<div id="del_maint_info" class="dialog-overlay">
    <div class="dialog-card">
        <div class="dialog-question-sign">
            <i class="fa fa-question fa-2x"></i>
        </div>
        <div class="dialog-info">
            <h5>Supprimer le contrat de maintenance de <?php echo $nom_cli;?> ?</h5>
            <p>Cette action est irr&eacute;versible.</p>
            <a href="./include/form/delete_contrat.php?id=<?php echo $id_parc;?>"><button class="dialog-confirm-button">Oui</button></a>
            <button class="dialog-reject-button">Non</button>
        </div>
    </div>
</div>
<!-- Message suppression monitoring -->
<div id="del_monit_info" class="dialog-overlay">
    <div class="dialog-card">
        <div class="dialog-question-sign">
            <i class="fa fa-question fa-2x"></i>
        </div>
        <div class="dialog-info">
            <h5>Supprimer le contrat de monitoring de <?php echo $nom_cli;?> ?</h5>
            <p>Cette action est irr&eacute;versible.</p>
            <a href="./include/form/delete_monitoring.php?id=<?php echo $id_parc;?>"><button class="dialog-confirm-button">Oui</button></a>
            <button class="dialog-reject-button">Non</button>
        </div>
    </div>
</div>
<!-- Modale Génération Monitoring -->
<div id="gen" class="overlay">
    <div class="popup_block">
        <a class="close" href="#noWhere">
            <span class="fa-stack fa-lg fa-2x btn_close del">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-times fa-stack-1x fa-inverse"></i>
            </span>
        </a>
        <div id="content_modale">
            <h1 class="modal">G&eacute;n&eacute;rer</h1>
            <form action="./include/form/gen_contrat.php" method="post">
            <table class="base" width="100%">
                <tr>
                    <td class="right" width="50%">Nombre de PC <i class="fa fa-desktop fa-fw"></i></td>
                    <td class="left" width="50%"><input type="text" name="nbr_pc" id="nbr_pc" class="styled" onchange="calc_price_gen()" onkeyup="calc_price_gen()" value="<?php echo $nbr_pc_parc;?>"/></td>
                </tr>
                <tr>
                    <td class="right">Nombre de Notebook <i class="fa fa-laptop fa-fw"></i></td>
                    <td class="left"><input type="text" name="nbr_laptop" id="nbr_laptop" class="styled" onchange="calc_price_gen()" onkeyup="calc_price_gen()" value="<?php echo $nbr_laptop_parc;?>"/></td>
                </tr>   
                <tr>
                    <td class="right">Nombre de serveur <i class="fa fa-server fa-fw"></i></td>
                    <td class="left"><input type="text" name="nbr_server" id="nbr_server" class="styled" onchange="calc_price_gen()" onkeyup="calc_price_gen()" value="<?php echo $nbr_server_parc;?>"/></td>
                </tr> 
                <tr>
                    <td class="right">Nombre de p&eacute;riph&eacute;riques mobiles <i class="fa fa-tablet fa-fw"></i></td>
                    <td class="left"><input type="text" name="nbr_mobile" id="nbr_mobile" class="styled" onchange="calc_price_gen()" onkeyup="calc_price_gen()" value="<?php echo $nbr_mobile_parc;?>"/></td>
                </tr> 
                <tr>
                    <td class="right">Nombre d'imprimante <i class="fa fa-print fa-fw"></i></td>
                    <td class="left"><input type="text" name="nbr_printer" id="nbr_printer" class="styled" onchange="calc_price_gen()" onkeyup="calc_price_gen()" value="<?php echo $nbr_printer_parc;?>"/></td>
                </tr>
            </table>
            <?php 
			if ($contrat_exists == 0) {
			?>
            <div class="portion_subtitle"><i class="fa fa-thumbs-o-up"></i> Le contrat de maintenance</div>
            <table class="base" width="100%">
                <tr>
                    <td class="right" width="50%">Gestion contrat de maintenance ?</td>
                    <td class="left" width="50%"><input type="checkbox" id="contrat" name="contrat" value="oui" onchange="check_contrat()"/></td>
                </tr>
                <tbody id="contract_place" class="disp_none">
                    <tr>
                        <td class="right" width="50%">Prix contrat :</td>
                        <td class="left" width="50%"><input type="text" id="prix_c" name="prix_c" class="styled" style="width:20%"/> &euro;</td>
                    </tr>
                    <tr>
                        <td class="right">Contrat sign&eacute; ?</td>
                        <td class="left"><input type="checkbox" id="sign" name="sign" value="oui" onchange="check_sign()"/></td>
                    </tr>
               	</tbody>
            </table>
            <?php
			}
			if ($monitoring_exists == 0) {
			?>
            <div class="portion_subtitle"><i class="fa fa-television"></i> Le monitoring</div>
            <table class="base" width="100%">
                <tr>
                    <td class="right" width="50%">Gestion monitoring ?</td>
                    <td class="left" width="50%"><input type="checkbox" id="monitoring" name="monitoring" value="oui" onchange="check_monitoring()"/></td>
                </tr>
                <tbody id="monitoring_place" class="disp_none">
                    <tr>
                        <td class="right">Prix monitoring :</td>
                        <td class="left"><input type="text" id="prix_m" name="prix_m" class="styled" style="width:20%"/> &euro;</td>
                    </tr>
                    <tr>
                        <td class="right">Monitoring sign&eacute; ?</td>
                        <td class="left"><input type="checkbox" id="sign_m" name="sign_m" value="oui" onchange="check_sign_m()"/></td>
                    </tr>
                </tbody>
            </table>
            <?php
			}
			?>
            <div class="portion_subtitle"><i class="fa fa-cog"></i> Param&egrave;tres de facturation</div>     
            <table class="base" width="100%">
            	<?php
				if ($monitoring_sign_exists > 0 || $contrat_sign_exists > 0) {
					?>
					<tbody id="fact_place" class="disp_none">
                        <tr>
                            <td class="right" width="50%">P&eacute;riodicit&eacute; de facturation :</td>
                            <td class="left" width="50%">
                            	<?php echo $facturation_aff;?>
                                <input type="hidden" name="facturation" id="facturation" value="<?php echo $facturation;?>" />
                            </td>
                        </tr>
                    </tbody>
                    <tbody id="fact_first_place" class="disp_none">
                        <tr>
                            <td class="right">Date de d&eacute;but facturation:</td>
                            <td class="left">
                            	<?php echo dateUSA_to_dateEU($echeance);?>
                                <input name="datesign_fix" type="hidden" id="datesign" value="<?php echo dateUSA_to_dateEU($echeance);?>" style="width:40%"> 
                            </td>
                        </tr> 
                    </tbody>
                    <?php
				}
				else if ($monitoring_exists > 0 || $contrat_exists > 0) {
					?>
                    <tbody id="fact_place" class="disp_none">
                        <tr>
                            <td class="right" width="50%">P&eacute;riodicit&eacute; de facturation :</td>
                            <td class="left" width="50%">
                            	<?php echo $facturation_aff;?>
                                <input type="hidden" name="facturation" id="facturation" value="<?php echo $facturation;?>" />
                            </td>
                        </tr>
                    </tbody>
                    <tbody id="fact_first_place" class="disp_none">
                        <tr>
                            <td class="right">Date de d&eacute;but :</td>
                            <td class="left">
                                <input name="datesign" type="text" id="datesign" value="<?php echo date('d-m-Y');?>" class="styled datep" style="width:40%"> 
                            </td>
                        </tr> 
                        <tr>
                            <td class="right" width="50%">Facturation de la premi&egrave;re p&eacute;riode ?</td>
                            <td class="left" width="50%"><input type="checkbox" name="fact_first" value="oui"/></td>
                        </tr>
                    </tbody>
                    <?php
				}
				else {
				?>
                    <tbody id="fact_place" class="disp_none">
                        <tr>
                            <td class="right" width="50%">P&eacute;riodicit&eacute; de facturation :</td>
                            <td class="left" width="50%">
                                <div class="styled-select-inline" style="width:40%">
                                <select class="styled-inline" name="facturation" id="facturation" onchange="calc_price_gen()">
                                    <option value="men">Mensuelle</option>
                                    <option value="tri">Trimestrielle</option>
                                    <option value="sem">Semestrielle</option>
                                    <option value="ann">Annuelle</option>
                                </select>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tbody id="fact_first_place" class="disp_none">
                        <tr>
                            <td class="right">Date de d&eacute;but :</td>
                            <td class="left">
                                <input name="datesign" type="text" id="datesign" value="<?php echo date('d-m-Y');?>" class="styled datep" style="width:40%"> 
                            </td>
                        </tr> 
                        <tr>
                            <td class="right" width="50%">Facturation de la premi&egrave;re p&eacute;riode ?</td>
                            <td class="left" width="50%"><input type="checkbox" name="fact_first" value="oui"/></td>
                        </tr>
                    </tbody>
                <?php
                }
				?>
            </table>
            <div class="center">
                <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-pencil"></i><span>Cr&eacute;er</span></button>
            </div>
            <input type="hidden" name="cli" value="<?php echo $cli;?>"/>
            <input type="hidden" name="id_parc" value="<?php echo $id_parc;?>"/>
            </form>
        </div>
    </div>
</div>
<!--PARC INFORMATIQUE-->
<div class="portion">
    <!-- TITRE - PARC INFORMATIQUE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-sitemap fa-stack-1x"></i>
        </span>
        Le parc informatique ( Client = <?php echo $nom_cli;?> )
        <span class="fa-stack fa-lg add" style="float:right" id="show_parc">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_parc">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
        <a href="./fpdf/rapport_parc.php?id=<?php echo $id_parc;?>" class="no_effect" target="_blank">
        <span class="fa-stack fa-lg action" style="float:right" title="Imprimer le r&eacute;capitul&eacute;">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-print fa-stack-1x"></i>
        </span>
        </a>
    </div>
    <!-- CONTENT - PARC INFORMATIQUE -->
    <div class="content_traitement" id="parc">
    	<!-- DETAILS COMPOSANTES PARC -->
    	<!-- SERVER -->
    	<div class="container_composante" style="margin-left:15%">
        	<div class="part_parc">
            	<i class="fa fa-server fa-fw"></i> <?php echo $nbr_server_parc;?>
            </div>
            <div class="btn_plus" onclick="add_compos('server', <?php echo $id_parc;?>)"><i class="fa fa-plus fa-2x"></i></div>
            <div class="btn_moins" onclick="sub_compos('server', <?php echo $id_parc;?>)"><i class="fa fa-minus fa-2x"></i></div>
            <div class="set_comp_manual">
            	<form action="./include/form/update_compos_parc.php" method="post" class="autosubmit">
                	<input type="text" class="styled" style="vertical-align:bottom;" name="nbr"/>
                    <button class="icons fa-check fa-2x add" style=""></button>
                    <input type="hidden" name="type" value="server"/>
                    <input type="hidden" name="id_parc" value="<?php echo $id_parc;?>"/>
                </form>
            </div>
        </div>
    	<!-- FIXES -->
    	<div class="container_composante">
        	<div class="part_parc">
            	<i class="fa fa-desktop fa-fw"></i> <?php echo $nbr_pc_parc;?>
            </div>
            <div class="btn_plus" onclick="add_compos('pc', <?php echo $id_parc;?>)"><i class="fa fa-plus fa-2x"></i></div>
            <div class="btn_moins" onclick="sub_compos('pc', <?php echo $id_parc;?>)"><i class="fa fa-minus fa-2x"></i></div>
            <div class="set_comp_manual">
            	<form action="./include/form/update_compos_parc.php" method="post" class="autosubmit">
                	<input type="text" class="styled" style="vertical-align:bottom;" name="nbr"/>
                    <button class="icons fa-check fa-2x add" style=""></button>
                    <input type="hidden" name="type" value="pc"/>
                    <input type="hidden" name="id_parc" value="<?php echo $id_parc;?>"/>
                </form>
            </div>
        </div>
        <!-- LAPTOP -->
    	<div class="container_composante">
        	<div class="part_parc">
            	<i class="fa fa-laptop fa-fw"></i> <?php echo $nbr_laptop_parc;?>
            </div>
            <div class="btn_plus" onclick="add_compos('laptop', <?php echo $id_parc;?>)"><i class="fa fa-plus fa-2x"></i></div>
            <div class="btn_moins" onclick="sub_compos('laptop', <?php echo $id_parc;?>)"><i class="fa fa-minus fa-2x"></i></div>
            <div class="set_comp_manual">
            	<form action="./include/form/update_compos_parc.php" method="post" class="autosubmit">
                	<input type="text" class="styled" style="vertical-align:bottom;" name="nbr"/>
                    <button class="icons fa-check fa-2x add" style=""></button>
                    <input type="hidden" name="type" value="laptop"/>
                    <input type="hidden" name="id_parc" value="<?php echo $id_parc;?>"/>
                </form>
            </div>
        </div>
        <!-- MOBILE -->
    	<div class="container_composante">
        	<div class="part_parc">
            	<i class="fa fa-mobile fa-fw"></i> <?php echo $nbr_mobile_parc;?>
            </div>
            <div class="btn_plus" onclick="add_compos('mobile', <?php echo $id_parc;?>)"><i class="fa fa-plus fa-2x"></i></div>
            <div class="btn_moins" onclick="sub_compos('mobile', <?php echo $id_parc;?>)"><i class="fa fa-minus fa-2x"></i></div>
            <div class="set_comp_manual">
            	<form action="./include/form/update_compos_parc.php" method="post" class="autosubmit">
                	<input type="text" class="styled" style="vertical-align:bottom;" name="nbr"/>
                    <button class="icons fa-check fa-2x add" style=""></button>
                    <input type="hidden" name="type" value="mobile"/>
                    <input type="hidden" name="id_parc" value="<?php echo $id_parc;?>"/>
                </form>
            </div>
        </div>
        <!-- PRINTER -->
    	<div class="container_composante">
        	<div class="part_parc">
            	<i class="fa fa-print fa-fw"></i>  <?php echo $nbr_printer_parc;?>
            </div>
            <div class="btn_plus" onclick="add_compos('printer', <?php echo $id_parc;?>)"><i class="fa fa-plus fa-2x"></i></div>
            <div class="btn_moins" onclick="sub_compos('printer', <?php echo $id_parc;?>)"><i class="fa fa-minus fa-2x"></i></div>
            <div class="set_comp_manual">
            	<form action="./include/form/update_compos_parc.php" method="post" class="autosubmit">
                	<input type="text" class="styled" style="vertical-align:bottom;" name="nbr"/>
                    <button class="icons fa-check fa-2x add" style=""></button>
                    <input type="hidden" name="type" value="printer"/>
                    <input type="hidden" name="id_parc" value="<?php echo $id_parc;?>"/>
                </form>
            </div>
        </div>
        <!-- FIN DETAILS COMPOSANTES PARC -->
        <div class="center">
        	<a href="./fpdf/rapport_parc.php?id=<?php echo $id_parc;?>" class="no_effect" target="_blank">
            	<button class="button_act button--shikoba button--border-thin" type="submit"><i class="button__icon fa fa-print"></i><span>Imprimer le r&eacute;capitul&eacute;</span></button>
        	</a>
        </div>
    </div>
</div> 
<?php
//Récupération des données du contrat.
$sql="SELECT cm.prix_mois, cm.type_fact, cm.prix_traite, cm.nbr_pc, cm.nbr_laptop, cm.nbr_server, cm.nbr_mobile, cm.nbr_printer, cm.sign, cm.date_sign, ce.echeance, cm.id";
$sql.=" FROM ".$tblpref."contrat_maintenance as cm";
$sql.=" LEFT JOIN ".$tblpref."contrat_echeance as ce ON ce.id_contrat = cm.id";
$sql.=" WHERE cm.id_parc='".$id_parc."' AND cm.actif='1'";
$req=mysql_query($sql);
$contrat_exist=mysql_num_rows($req);
$obj=mysql_fetch_object($req);
if ($obj->type_fact == 'men') {
	$fact='Mensuelle';
}
else if ($obj->type_fact == 'tri') {
	$fact='Trimestrielle';
}
else if ($obj->type_fact == 'sem') {
	$fact='Semestrielle';
}
else if ($obj->type_fact == 'ann') {
	$fact='Annuelle';
}
?>
<!--CONTRAT DE MAINTENANCE-->
<div class="portion">
    <!-- TITRE - CONTRAT DE MAINTENANCE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-thumbs-o-up fa-stack-1x"></i>
        </span>
        Le contrat de maintenance
        <span class="fa-stack fa-lg add" style="float:right" id="show_maintenance">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_maintenance">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <a class="dialog-show-button no_effect" data-show-dialog="del_maint_info" href="#">
        <span class="fa-stack fa-lg del" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-trash fa-stack-1x"></i>
        </span>
        </a>
    </div>
    <!-- CONTENT - CONTRAT DE MAINTENANCE -->
    <div class="content_traitement" id="maintenance">
		<?php
		//Si un contrat ou proposition de contrat existe
		if ($contrat_exist > 0) {
			//On récupère l'id, afin de request l'historique.
			$id_contrat=$obj->id;
			?>
            <!-- Modale MAJ contrat -->
            <div id="maj_contrat" class="overlay">
                <div class="popup_block">
                    <a class="close" href="#noWhere">
                        <span class="fa-stack fa-lg fa-2x btn_close del">
                          <i class="fa fa-circle fa-stack-2x"></i>
                          <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                    <div id="content_modale">
                        <h1 class="modal">Mettre &agrave; jour le contrat</h1>
                        <form action="./include/form/maj_contrat.php" method="post">
                            <table class="base" width="100%">
                                <tr>
                                    <td class="right">Nombre de serveur <i class="fa fa-server fa-fw"></i></td>
                                    <td class="left"><input type="text" name="nbr_server" id="nbr_server_c" class="styled" onchange="calc_price_c()" onkeyup="calc_price_c()" value="<?php echo $nbr_server_parc;?>"/></td>
                                </tr> 
                                <tr>
                                    <td class="right" width="50%">Nombre de PC <i class="fa fa-desktop fa-fw"></i></td>
                                    <td class="left" width="50%"><input type="text" name="nbr_pc" id="nbr_pc_c" class="styled" onchange="calc_price_c()" onkeyup="calc_price_c()" value="<?php echo $nbr_pc_parc;?>"/></td>
                                </tr>
                                <tr>
                                    <td class="right">Nombre de Notebook <i class="fa fa-laptop fa-fw"></i></td>
                                    <td class="left"><input type="text" name="nbr_laptop" id="nbr_laptop_c" class="styled" onchange="calc_price_c()" onkeyup="calc_price_c()" value="<?php echo $nbr_laptop_parc;?>"/></td>
                                </tr>   
                                <tr>
                                    <td class="right">Nombre de p&eacute;riph&eacute;riques mobiles <i class="fa fa-tablet fa-fw"></i></td>
                                    <td class="left"><input type="text" name="nbr_mobile" id="nbr_mobile_c" class="styled" onchange="calc_price_c()" onkeyup="calc_price_c()" value="<?php echo $nbr_mobile_parc;?>"/></td>
                                </tr> 
                                <tr>
                                    <td class="right">Nombre d'imprimante <i class="fa fa-print fa-fw"></i></td>
                                    <td class="left"><input type="text" name="nbr_printer" id="nbr_printer_c" class="styled" onchange="calc_price_c()" onkeyup="calc_price_c()" value="<?php echo $nbr_printer_parc;?>"/></td>
                                </tr>
                            </table>
                            <table id="contract_place" class="base" width="100%">
                                <tr>
                                    <td class="right">Type de facturation :</td>
                                    <td class="left">
                                        <div class="styled-select-inline" style="width:40%">
                                        <select class="styled-inline" name="facturation" id="facturation_c" onchange="calc_price_c()">
                                            <option value="men" <?php if ($fact == 'Mensuelle') { echo 'selected';}?>>Mensuelle</option>
                                            <option value="tri" <?php if ($fact == 'Trimestrielle') { echo 'selected';}?>>Trimestrielle</option>
                                            <option value="sem" <?php if ($fact == 'Semestrielle') { echo 'selected';}?>>Semestrielle</option>
                                            <option value="ann" <?php if ($fact == 'Annuelle') { echo 'selected';}?>>Annuelle</option>
                                        </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="right" width="50%">Prix contrat :</td>
                                    <td class="left" width="50%"><input type="text" id="prix_contrat" name="prix_c" class="styled" style="width:20%"/> &euro;</td>
                                </tr>
                            </table>
                        <input type="hidden" value="<?php echo $id_parc;?>" name="id_parc" />
                        <input type="hidden" value="<?php echo $id_contrat;?>" name="id_contrat" />
                        <div class="center">
                            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-refresh"></i><span>MAJ</span></button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
			//Si le contrat est signé
			if ($obj->sign == 1) {
				$sign_contrat='1';
				?>
                <div class="portion_subtitle"><i class="fa fa-bullseye"></i> Le contrat actuel</div>
                <div class="container_state">
                	<div class="state_compos">
                    	<a href="#maj_contrat" class="no_effect">
                    		<i class="button__icon fa fa-refresh fa-2x action" style="float:right" title="MAJ de la proposition de contrat"></i>
                        </a>
                    	<label class="compos_min"><i class="fa fa-server fa-fw fa-2x"></i> Serveurs : </label><?php echo $obj->nbr_server;?><br />
						<label class="compos_min"><i class="fa fa-desktop fa-fw fa-2x"></i> PCs : </label><?php echo $obj->nbr_pc;?><br />
                        <label class="compos_min"><i class="fa fa-laptop fa-fw fa-2x"></i> Notebooks : </label><?php echo $obj->nbr_laptop;?><br />
                        <label class="compos_min"><i class="fa fa-mobile fa-fw fa-2x"></i> Mobiles : </label><?php echo $obj->nbr_mobile;?><br />
                        <label class="compos_min"><i class="fa fa-print fa-fw fa-2x"></i> Imprimantes : </label><?php echo $obj->nbr_printer;?>
                    </div>
                    <div class="state_contrat">
                    	<table class="base" width="100%">
                        	<tr>
                            	<td class="right" width="25%">Date de signature :</td>
                                <td class="left" width="25%"><?php echo dateUSA_to_dateEU($obj->date_sign);?></td>
                                <td class="right" width="25%">Date du prochain renouvellement :</td>
                                <td class="left" width="25%"><?php echo dateUSA_to_dateEU($obj->echeance);?></td>
                            </tr>
                            <tr>
                            	<td class="right">P&eacute;riodicit&eacute; de facturation :</td>
                                <td class="left"><?php echo $fact;?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                            	<td class="right">Prix traite :</td>
                                <td class="left"><?php echo $obj->prix_traite;?> &euro;</td>
                                <td class="right">Prix mensuel :</td>
                                <td class="left"><?php echo $obj->prix_mois;?> &euro;</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="portion_subtitle"><i class="fa fa-clock-o"></i> Historique des contrats</div>
                <table class="base" width="100%" id="listed">
                	<thead>
                	<tr>
                    	<th>Echeance</th>
                        <th width="8%"><i class="fa fa-server fa-fw fa-2x"></i></th>
                        <th width="8%"><i class="fa fa-desktop fa-fw fa-2x"></i></th>
                        <th width="8%"><i class="fa fa-laptop fa-fw fa-2x"></i></th>
                        <th width="8%"><i class="fa fa-mobile fa-fw fa-2x"></i></th>
                        <th width="8%"><i class="fa fa-print fa-fw fa-2x"></i></th>
                        <th>Prix traite</th>
                        <th>Prix mensuel</th>
                        <th>Etat</th>
                        <th>Documents</th>
                    </tr>
                    </thead>
                    <tbody>
                    	<?php
						$sql="SELECT * FROM ".$tblpref."contrat_echeance WHERE id_contrat = '".$id_contrat."' ORDER BY echeance DESC";
						$req=mysql_query($sql);
						while ($obj=mysql_fetch_object($req)) {
							if ($obj->fact == 1 && $obj->actif == 1 && $obj->echeance > date('Y-m-d')) {
								$etat="<i class='fa fa-bullseye' style='color:#2ecc71'></i> En cours ";
							}
							else {
								$etat="<i class='fa fa-check' style='color:#d35400'></i> Termin&eacute;";	
							}
							?>
                            <tr>
                            	<td><span class="disp_none"><?php echo $obj->echeance;?></span><?php echo dateUSA_to_dateEU($obj->echeance);?></td>
                                <td><?php echo $obj->nbr_server;?></td>
                                <td><?php echo $obj->nbr_pc;?></td>
                                <td><?php echo $obj->nbr_laptop;?></td>
                                <td><?php echo $obj->nbr_mobile;?></td>
                                <td><?php echo $obj->nbr_printer;?></td>
                                <td><?php echo $obj->prix_traite;?> &euro;</td>
                                <td><?php echo $obj->prix_mois;?> &euro;</td>
                                <td><?php echo $etat;?></td>
                                <td>
                                	<?php
									if ($obj->fact_num == 'OLD' || $obj->fact_num == '') {
									}
									else {
									?>
                                	<a href="./fpdf/facture_pdf.php?num=<?php echo $obj->fact_num;?>&nom=<?php echo $nom_cli;?>&pdf_user=adm" target="_blank" class="no_effect">
                                		<i class="fa fa-file-text fa-fw fa-2x action"></i>
                                    </a>
                                    <?php
									}
									?>
                                </td>
                            </tr>
                            <?php
						}
						?>
                    </tbody>
                </table>
                <?php
			}
			//S'il s'agit d'une proposition
			else {
				?>
                <!-- Modale SIGN contrat -->
                <div id="sign_contrat" class="overlay">
                    <div class="popup_block">
                        <a class="close" href="#noWhere">
                            <span class="fa-stack fa-lg fa-2x btn_close del">
                              <i class="fa fa-circle fa-stack-2x"></i>
                              <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                        <div id="content_modale">
                            <?php
                            if ($monitoring_sign_exists > 0) {
							?>
                            	<h1 class="modal">Signer le contrat de maintenance</h1>
                                <form action="./include/form/sign_contrat.php" method="post">
                                    <table class="base" width="100%">
                                        <tr>
                                            <td width="50%" class="right">Date de premi&egrave;re facturation :</td>
                                            <td width="50%" class="left"><?php echo dateUSA_to_dateEU($echeance);?><input type="hidden" name="debut_fix" value="<?php echo dateUSA_to_dateEU($echeance);?>"/></td>
                                        </tr>
                                    </table>
                                    <input type="hidden" value="<?php echo $id_contrat;?>" name="id_contrat" />
                                    <input type="hidden" value="<?php echo $id_parc;?>" name="id_parc" />
                                    <div class="center">
                                        <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-thumbs-up"></i><span>Signer</span></button>
                                    </div>
                                    <input type="hidden" name="sign_contrat" value="oui"/>
                                </form>
                            <?php
							}
							else {
							?>
                            <h1 class="modal">Signer</h1>
                            <form action="./include/form/sign_contrat.php" method="post">
                            	<table class="base" width="100%">
                                	<tr>
                                    	<td width="50%" class="right">Signer le contrat de maintenance ?</td>
                                        <td width="50%" class="left"><input type="checkbox" name="sign_contrat" value="oui"/></td>
                                    </tr>
                                    <?php
									if ($monitoring_exists > 0) {
										?>
                                        <tr>
                                            <td width="50%" class="right">Signer le monitoring ?</td>
                                            <td width="50%" class="left"><input type="checkbox" name="sign_monitoring" value="oui"/></td>
                                        </tr>
                                        <?php
									}
									?>
                                	<tr>
                                    	<td width="50%" class="right">Date de d&eacute;but :</td>
                                        <td width="50%" class="left"><input type="text" class="styled datep" value="<?php echo '01-'.date('m-Y');?>" name="debut"/></td>
                                    </tr>
                                    <tr>
                                    	<td width="50%" class="right">Facturation de la premi&egrave;re p&eacute;riode ?</td>
                                        <td width="50%" class="left"><input type="checkbox" value="oui" name="fact_first_period"/></td>
                                    </tr>
                                </table>
                                <input type="hidden" value="<?php echo $id_monitoring;?>" name="id_monitoring" />
                                <input type="hidden" value="<?php echo $id_contrat;?>" name="id_contrat" />
                                <input type="hidden" value="<?php echo $id_parc;?>" name="id_parc" />
                                <div class="center">
                                    <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-thumbs-up"></i><span>Signer</span></button>
                                </div>
                            </form>
                            <?php
							}
							?>
                        </div>
                    </div>
                </div>
                <div class="portion_subtitle"><i class="fa fa-bullseye"></i> La proposition de contrat</div>
                <div class="container_state">
                	<div class="state_compos">
                    	<a href="#maj_contrat" class="no_effect">
                    		<i class="button__icon fa fa-refresh fa-2x action" style="float:right" title="MAJ de la proposition de contrat"></i>
                        </a>
                    	<label class="compos_min"><i class="fa fa-server fa-fw fa-2x"></i> Serveurs : </label><?php echo $obj->nbr_server;?><br />
						<label class="compos_min"><i class="fa fa-desktop fa-fw fa-2x"></i> PCs : </label><?php echo $obj->nbr_pc;?><br />
                        <label class="compos_min"><i class="fa fa-laptop fa-fw fa-2x"></i> Notebooks : </label><?php echo $obj->nbr_laptop;?><br />
                        <label class="compos_min"><i class="fa fa-mobile fa-fw fa-2x"></i> Mobiles : </label><?php echo $obj->nbr_mobile;?><br />
                        <label class="compos_min"><i class="fa fa-print fa-fw fa-2x"></i> Imprimantes : </label><?php echo $obj->nbr_printer;?>
                    </div>
                    <div class="state_contrat">
                    	<table class="base" width="100%">
                            <tr>
                            	<td class="right" width="25%">P&eacute;riodicit&eacute; de facturation :</td>
                                <td class="left" width="25%"><?php echo $fact;?></td>
                                <td width="25%"></td>
                                <td width="25%"></td>
                            </tr>
                            <tr>
                            	<td class="right">Prix traite :</td>
                                <td class="left"><?php echo $obj->prix_traite;?> &euro;</td>
                                <td class="right">Prix mensuel :</td>
                                <td class="left"><?php echo $obj->prix_mois;?> &euro;</td>
                            </tr>
                        </table>
                        <div class="center">
                        	<a href="#sign_contrat" class="no_effect">
                            <button class="button_act button--shikoba button--border-thin" type="submit"><i class="button__icon fa fa-pencil"></i><span>Signer le contrat</span></button>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
			}
        }
		//Si aucun contrat n'existe
		else {
			?>
            <div class="center">
            	Aucun contrat ou proposition de contrat n'a &eacute;t&eacute; g&eacute;n&eacute;r&eacute; pour ce parc.<br/>
                <a href="#gen" class="no_effect">
                	<button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-pencil"></i><span>G&eacute;n&eacute;rer</span></button>
                </a>
            </div>
            <?php
		}
		?>
    </div>
</div> 
<?php
//Récupération des données du monitoring.
$sql="SELECT m.prix_mois, m.type_fact, m.prix_traite, m.nbr_pc, m.nbr_laptop, m.nbr_server, m.nbr_mobile, m.nbr_printer, m.sign, m.date_sign, me.echeance, m.id";
$sql.=" FROM ".$tblpref."monitoring as m";
$sql.=" LEFT JOIN ".$tblpref."monitoring_echeance as me ON me.id_monitoring = m.id";
$sql.=" WHERE m.id_parc='".$id_parc."' AND m.actif='1'";
$req=mysql_query($sql);
$contrat_exist=mysql_num_rows($req);
$obj=mysql_fetch_object($req);
if ($obj->type_fact == 'men') {
	$fact='Mensuelle';
}
else if ($obj->type_fact == 'tri') {
	$fact='Trimestrielle';
}
else if ($obj->type_fact == 'sem') {
	$fact='Semestrielle';
}
else if ($obj->type_fact == 'ann') {
	$fact='Annuelle';
}
?>
<!--MONITORING-->
<div class="portion">
    <!-- TITRE - MONITORING -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-television fa-stack-1x"></i>
        </span>
        Le monitoring
        <span class="fa-stack fa-lg add" style="float:right" id="show_monitoring">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_monitoring">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <a class="dialog-show-button no_effect" data-show-dialog="del_monit_info" href="#">
        <span class="fa-stack fa-lg del" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-trash fa-stack-1x"></i>
        </span>
        </a>
    </div>
    <!-- CONTENT - MONITORING -->
    <div class="content_traitement" id="monitoring_place">
    	<?php
		//Si un contrat ou proposition de contrat existe
		if ($contrat_exist > 0) {
			//On récupère l'id, afin de request l'historique.
			$id_monitoring=$obj->id;
			?>
            <!-- Modale MAJ monitoring -->
            <div id="maj_monitoring" class="overlay">
                <div class="popup_block">
                    <a class="close" href="#noWhere">
                        <span class="fa-stack fa-lg fa-2x btn_close del">
                          <i class="fa fa-circle fa-stack-2x"></i>
                          <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                    <div id="content_modale">
                        <h1 class="modal">Mettre &agrave; jour le monitoring</h1>
                        <form action="./include/form/maj_monitoring.php" method="post">
                        <table class="base" width="100%">
                            <tr>
                                <td class="right">Nombre de serveur <i class="fa fa-server fa-fw"></i></td>
                                <td class="left"><input type="text" name="nbr_server" id="nbr_server_m" class="styled" onchange="calc_price_m()" onkeyup="calc_price_m()" value="<?php echo $nbr_server_parc;?>"/></td>
                            </tr> 
                            <tr>
                                <td class="right" width="50%">Nombre de PC <i class="fa fa-desktop fa-fw"></i></td>
                                <td class="left" width="50%"><input type="text" name="nbr_pc" id="nbr_pc_m" class="styled" onchange="calc_price_m()" onkeyup="calc_price_m()" value="<?php echo $nbr_pc_parc;?>"/></td>
                            </tr>
                            <tr>
                                <td class="right">Nombre de Notebook <i class="fa fa-laptop fa-fw"></i></td>
                                <td class="left"><input type="text" name="nbr_laptop" id="nbr_laptop_m" class="styled" onchange="calc_price_m()" onkeyup="calc_price_m()" value="<?php echo $nbr_laptop_parc;?>"/></td>
                            </tr>   
                            <tr>
                                <td class="right">Nombre de p&eacute;riph&eacute;riques mobiles <i class="fa fa-tablet fa-fw"></i></td>
                                <td class="left"><input type="text" name="nbr_mobile" id="nbr_mobile_m" class="styled" onchange="calc_price_m()" onkeyup="calc_price_m()" value="<?php echo $nbr_mobile_parc;?>"/></td>
                            </tr> 
                            <tr>
                                <td class="right">Nombre d'imprimante <i class="fa fa-print fa-fw"></i></td>
                                <td class="left"><input type="text" name="nbr_printer" id="nbr_printer_m" class="styled" onchange="calc_price_m()" onkeyup="calc_price_m()" value="<?php echo $nbr_printer_parc;?>"/></td>
                            </tr>
                        </table>
                        <table class="base" width="100%">
                            <tbody id="monitoring_place" class="">
                                <tr>
                                    <td class="right" width="50%">Type de facturation :</td>
                                    <td class="left" width="50%">
                                        <div class="styled-select-inline" style="width:40%">
                                        <select class="styled-inline" name="facturation_m" id="facturation_m" onchange="calc_price_m()">
                                            <option value="men" <?php if ($fact == 'Mensuelle') { echo 'selected';}?>>Mensuelle</option>
                                            <option value="tri" <?php if ($fact == 'Trimestrielle') { echo 'selected';}?>>Trimestrielle</option>
                                            <option value="sem" <?php if ($fact == 'Semestrielle') { echo 'selected';}?>>Semestrielle</option>
                                            <option value="ann" <?php if ($fact == 'Annuelle') { echo 'selected';}?>>Annuelle</option>
                                        </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="right">Prix monitoring :</td>
                                    <td class="left"><input type="text" id="prix_m" name="prix_m" class="styled" style="width:20%"/> &euro;</td>
                                </tr>
                            </tbody>
                        </table>  
                        <input type="hidden" value="<?php echo $id_monitoring;?>" name="id_monitoring" />
                        <input type="hidden" value="<?php echo $id_parc;?>" name="id_parc" />
                        <div class="center">
                            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-refresh"></i><span>MAJ</span></button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
			//Si le contrat est signé
			if ($obj->sign == 1) {
				$sign_monitoring='1';
				?>
                <div class="portion_subtitle"><i class="fa fa-bullseye"></i> Le monitoring actuel</div>
                <div class="container_state">
                	<div class="state_compos">
                    	<a href="#maj_monitoring" class="no_effect">
                    		<i class="button__icon fa fa-refresh fa-2x action" style="float:right" title="MAJ de la proposition de contrat"></i>
                        </a>
                    	<label class="compos_min"><i class="fa fa-server fa-fw fa-2x"></i> Serveurs : </label><?php echo $obj->nbr_server;?><br />
						<label class="compos_min"><i class="fa fa-desktop fa-fw fa-2x"></i> PCs : </label><?php echo $obj->nbr_pc;?><br />
                        <label class="compos_min"><i class="fa fa-laptop fa-fw fa-2x"></i> Notebooks : </label><?php echo $obj->nbr_laptop;?><br />
                        <label class="compos_min"><i class="fa fa-mobile fa-fw fa-2x"></i> Mobiles : </label><?php echo $obj->nbr_mobile;?><br />
                        <label class="compos_min"><i class="fa fa-print fa-fw fa-2x"></i> Imprimantes : </label><?php echo $obj->nbr_printer;?>
                    </div>
                    <div class="state_contrat">
                    	<table class="base" width="100%">
                        	<tr>
                            	<td class="right" width="25%">Date de signature :</td>
                                <td class="left" width="25%"><?php echo dateUSA_to_dateEU($obj->date_sign);?></td>
                                <td class="right" width="25%">Date du prochain renouvellement :</td>
                                <td class="left" width="25%"><?php echo dateUSA_to_dateEU($obj->echeance);?></td>
                            </tr>
                            <tr>
                            	<td class="right">P&eacute;riodicit&eacute; de facturation :</td>
                                <td class="left"><?php echo $fact;?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                            	<td class="right">Prix traite :</td>
                                <td class="left"><?php echo $obj->prix_traite;?> &euro;</td>
                                <td class="right">Prix mensuel :</td>
                                <td class="left"><?php echo $obj->prix_mois;?> &euro;</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="portion_subtitle"><i class="fa fa-clock-o"></i> Historique des monitoring</div>
                <table class="base" width="100%" id="listed_m">
                	<thead>
                	<tr>
                    	<th>Echeance</th>
                        <th width="8%"><i class="fa fa-server fa-fw fa-2x"></i></th>
                        <th width="8%"><i class="fa fa-desktop fa-fw fa-2x"></i></th>
                        <th width="8%"><i class="fa fa-laptop fa-fw fa-2x"></i></th>
                        <th width="8%"><i class="fa fa-mobile fa-fw fa-2x"></i></th>
                        <th width="8%"><i class="fa fa-print fa-fw fa-2x"></i></th>
                        <th>Prix traite</th>
                        <th>Prix mensuel</th>
                        <th>Etat</th>
                        <th>Documents</th>
                    </tr>
                    </thead>
                    <tbody>
                    	<?php
						$sql="SELECT * FROM ".$tblpref."monitoring_echeance WHERE id_monitoring = '".$id_monitoring."' ORDER BY echeance DESC";
						$req=mysql_query($sql);
						while ($obj=mysql_fetch_object($req)) {
							if ($obj->fact == 1 && $obj->actif == 1 && $obj->echeance > date('Y-m-d')) {
								$etat="<i class='fa fa-bullseye' style='color:#2ecc71'></i> En cours ";
							}
							else {
								$etat="<i class='fa fa-check' style='color:#d35400'></i> Termin&eacute;";	
							}
							?>
                            <tr>
                            	<td><span class="disp_none"><?php echo $obj->echeance;?></span><?php echo dateUSA_to_dateEU($obj->echeance);?></td>
                                <td><?php echo $obj->nbr_server;?></td>
                                <td><?php echo $obj->nbr_pc;?></td>
                                <td><?php echo $obj->nbr_laptop;?></td>
                                <td><?php echo $obj->nbr_mobile;?></td>
                                <td><?php echo $obj->nbr_printer;?></td>
                                <td><?php echo $obj->prix_traite;?> &euro;</td>
                                <td><?php echo $obj->prix_mois;?> &euro;</td>
                                <td><?php echo $etat;?></td>
                                <td>
                                	<?php
									if ($obj->fact_num == 'OLD' || $obj->fact_num == '') {
									}
									else {
									?>
                                	<a href="./fpdf/facture_pdf.php?num=<?php echo $obj->fact_num;?>&nom=<?php echo $nom_cli;?>&pdf_user=adm" target="_blank" class="no_effect">
                                		<i class="fa fa-file-text fa-fw fa-2x action"></i>
                                    </a>
                                    <?php
									}
									?>
                                </td>
                            </tr>
                            <?php
						}
						?>
                    </tbody>
                </table>
                <?php
			}
			//S'il s'agit d'une proposition
			else {
				?>
                <!-- Modale SIGN monitoring -->
                <div id="sign_monitoring" class="overlay">
                    <div class="popup_block">
                        <a class="close" href="#noWhere">
                            <span class="fa-stack fa-lg fa-2x btn_close del">
                              <i class="fa fa-circle fa-stack-2x"></i>
                              <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                        <div id="content_modale">
                            <?php
                            if ($contrat_sign_exists > 0) {
							?>
                            	<h1 class="modal">Signer le monitoring</h1>
                                <form action="./include/form/sign_contrat.php" method="post">
                                    <table class="base" width="100%">
                                        <tr>
                                            <td width="50%" class="right">Date de premi&egrave;re facturation :</td>
                                            <td width="50%" class="left"><?php echo dateUSA_to_dateEU($echeance);?><input type="hidden" name="debut_fix" value="<?php echo dateUSA_to_dateEU($echeance);?>"/></td>
                                        </tr>
                                    </table>
                                    <input type="hidden" value="<?php echo $id_monitoring;?>" name="id_monitoring" />
                                    <input type="hidden" value="<?php echo $id_parc;?>" name="id_parc" />
                                    <div class="center">
                                        <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-thumbs-up"></i><span>Signer</span></button>
                                    </div>
                                 	<input type="hidden" name="sign_monitoring" value="oui"/>
                                </form>
                            <?php
							}
							else {
							?>
                            <h1 class="modal">Signer</h1>
                            <form action="./include/form/sign_contrat.php" method="post">
                            	<table class="base" width="100%">
                                	<?php
									if ($contrat_exists > 0) {
										?>
                                	<tr>
                                    	<td width="50%" class="right">Signer le contrat de maintenance ?</td>
                                        <td width="50%" class="left"><input type="checkbox" name="sign_contrat" value="oui"/></td>
                                    </tr>
                                    	<?php
									}
									?>
                                    <tr>
                                    	<td width="50%" class="right">Signer le monitoring ?</td>
                                        <td width="50%" class="left"><input type="checkbox" name="sign_monitoring" value="oui"/></td>
                                    </tr>
                                	<tr>
                                    	<td width="50%" class="right">Date de d&eacute;but :</td>
                                        <td width="50%" class="left"><input type="text" class="styled datep" value="<?php echo '01-'.date('m-Y');?>" name="debut"/></td>
                                    </tr>
                                    <tr>
                                    	<td width="50%" class="right">Facturation de la premi&egrave;re p&eacute;riode ?</td>
                                        <td width="50%" class="left"><input type="checkbox" value="oui" name="fact_first_period"/></td>
                                    </tr>
                                </table>
                                <input type="hidden" value="<?php echo $id_monitoring;?>" name="id_monitoring" />
                                <input type="hidden" value="<?php echo $id_contrat;?>" name="id_contrat" />
                                <input type="hidden" value="<?php echo $id_parc;?>" name="id_parc" />
                                <div class="center">
                                    <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-thumbs-up"></i><span>Signer</span></button>
                                </div>
                            </form>
                            <?php
							}
							?>
                        </div>
                    </div>
                </div>
                <!-- FIN Modale SIGN monitoring -->
                <div class="portion_subtitle"><i class="fa fa-bullseye"></i> La proposition de monitoring</div>
                <div class="container_state">
                	<div class="state_compos">
                    	<a href="#maj_monitoring" class="no_effect">
                    		<i class="button__icon fa fa-refresh fa-2x action" style="float:right" title="MAJ de la proposition de contrat"></i>
                        </a>
                    	<label class="compos_min"><i class="fa fa-server fa-fw fa-2x"></i> Serveurs : </label><?php echo $obj->nbr_server;?><br />
						<label class="compos_min"><i class="fa fa-desktop fa-fw fa-2x"></i> PCs : </label><?php echo $obj->nbr_pc;?><br />
                        <label class="compos_min"><i class="fa fa-laptop fa-fw fa-2x"></i> Notebooks : </label><?php echo $obj->nbr_laptop;?><br />
                        <label class="compos_min"><i class="fa fa-mobile fa-fw fa-2x"></i> Mobiles : </label><?php echo $obj->nbr_mobile;?><br />
                        <label class="compos_min"><i class="fa fa-print fa-fw fa-2x"></i> Imprimantes : </label><?php echo $obj->nbr_printer;?>
                    </div>
                    <div class="state_contrat">
                    	<table class="base" width="100%">
                            <tr>
                            	<td class="right" width="25%">P&eacute;riodicit&eacute; de facturation :</td>
                                <td class="left" width="25%"><?php echo $fact;?></td>
                                <td width="25%"></td>
                                <td width="25%"></td>
                            </tr>
                            <tr>
                            	<td class="right">Prix traite :</td>
                                <td class="left"><?php echo $obj->prix_traite;?> &euro;</td>
                                <td class="right">Prix mensuel :</td>
                                <td class="left"><?php echo $obj->prix_mois;?> &euro;</td>
                            </tr>
                        </table>
                    <div class="center">
                    	<a href="#sign_monitoring" class="no_effect">
                        <button class="button_act button--shikoba button--border-thin" type="submit"><i class="button__icon fa fa-pencil"></i><span>Signer le monitoring</span></button>
                        </a>
                    </div>
                    </div>
                </div>
                <?php
			}
        }
		//Si aucun contrat n'existe
		else {
			?>
            <div class="center">
            	Aucun monitoring ou proposition de monitoring n'a &eacute;t&eacute; g&eacute;n&eacute;r&eacute; pour ce parc.<br/>
                <a href="#gen" class="no_effect">
                	<button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-pencil"></i><span>G&eacute;n&eacute;rer</span></button>
                </a>
            </div>
            <?php
		}
		?>
    </div>
</div>    

<!--PARC INFORMATIQUE-->
<div class="portion">
    <!-- TITRE - PARC INFORMATIQUE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-briefcase fa-stack-1x"></i>
        </span>
        Documents du parc
        <span class="fa-stack fa-lg add" style="float:right" id="show_doc">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_doc">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - PARC INFORMATIQUE -->
    <div class="content_traitement" id="doc">
    	<?php
		if (isset($id_contrat) || isset($id_monitoring)) {
			?>
			<!--IMPRESSION FICHE INTER-->
            <div class="three_action">
                <div>
                <span class="fa-stack fa-lg fa-2x">
                  <i class="fa fa-circle-thin fa-stack-2x"></i>
                  <i class="fa fa-bug fa-stack-1x"></i>
                </span>
                </div>
                <a href="./fpdf/prop_parc.php?id_parc=<?php echo $id_parc;?>" class="no_effect" target="_blank"> 
                    <button class="button_act button--shikoba button--border-thin" type="button">
                        <i class="button__icon fa fa-print"></i><span>Imprimer la proposition (devis)</span>
                    </button>
                </a>
            </div>
            <?php 	
			if ($sign_contrat == '1' || $sign_monitoring == '1') {
				?>
				<!--IMPRESSION FICHE INTER-->
				<div class="three_action">
					<div>
					<span class="fa-stack fa-lg fa-2x">
					  <i class="fa fa-circle-thin fa-stack-2x"></i>
					  <i class="fa fa-calculator fa-stack-1x"></i>
					</span>
					</div>
					<a href="./include/form/gen_next_fact.php?id=<?php echo $id_parc;?>" class="no_effect"> 
						<button class="button_act button--shikoba button--border-thin" type="button">
							<i class="button__icon fa fa-calculator"></i><span>G&eacute;n&eacute;rer la prochaine facture</span>
						</button>
					</a>
				</div>
				<?php
			}
		}
		else {
			?>
			<div class="center">Aucun contrat n'a &eacute;t&eacute; g&eacute;n&eacute;rer pour ce parc, aucun document n'est donc disponible.</div>
            <?php
		}
		?>
    </div>
</div>   
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>