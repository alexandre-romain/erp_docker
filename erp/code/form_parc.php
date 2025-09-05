<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#hide_create").hide();
	$("#hide_create").click(function(){
		$("#create").hide(500);	
		$("#hide_create").hide();
		$("#show_create").show();
	});
	$("#show_create").click(function(){
		$("#create").show(500);	
		$("#hide_create").show();
		$("#show_create").hide();
	});
});
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
<!--create EXISTANT-->
<div class="portion">
    <!-- TITRE - create -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        Créer un parc informatique
        <span class="fa-stack fa-lg add" style="float:right" id="show_create">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_create">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <div class="content_traitement disp_none" id="create">
        <form name="formu" method="post" action="./include/form/add_parc.php" >
        <div class="portion_subtitle"><i class="fa fa-sitemap"></i> Le parc informatique</div>
        <table class="base" width="100%">
            <tr> 
                <td class="right" width="50%">Client :</td>
                <td class="left" width="50%"> 
                    <?php 
                    include_once("include/choix_cli.php");
                    ?>
                </td>
            </tr>
            <tr>
                <td class="right">Nombre de PC <i class="fa fa-desktop fa-fw"></i></td>
                <td class="left"><input type="text" name="nbr_pc" id="nbr_pc" class="styled" onchange="calc_price()" onkeyup="calc_price()"/></td>
            </tr>
            <tr>
                <td class="right">Nombre de Notebook <i class="fa fa-laptop fa-fw"></i></td>
                <td class="left"><input type="text" name="nbr_laptop" id="nbr_laptop" class="styled" onchange="calc_price()" onkeyup="calc_price()"/></td>
            </tr>   
            <tr>
                <td class="right">Nombre de serveur <i class="fa fa-server fa-fw"></i></td>
                <td class="left"><input type="text" name="nbr_server" id="nbr_server" class="styled" onchange="calc_price()" onkeyup="calc_price()"/></td>
            </tr> 
            <tr>
                <td class="right">Nombre de p&eacute;riph&eacute;riques mobiles <i class="fa fa-tablet fa-fw"></i></td>
                <td class="left"><input type="text" name="nbr_mobile" id="nbr_mobile" class="styled" onchange="calc_price()" onkeyup="calc_price()"/></td>
            </tr> 
            <tr>
                <td class="right">Nombre d'imprimante <i class="fa fa-print fa-fw"></i></td>
                <td class="left"><input type="text" name="nbr_printer" id="nbr_printer" class="styled" onchange="calc_price()" onkeyup="calc_price()"/></td>
            </tr>
       	</table>
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
        </table>
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
        <div class="portion_subtitle"><i class="fa fa-cog"></i> Param&egrave;tres de facturation</div>     
        <table class="base" width="100%">
        	<tbody id="fact_place" class="disp_none">
                <tr>
                    <td class="right" width="50%">P&eacute;riodicit&eacute; de facturation :</td>
                    <td class="left" width="50%">
                        <div class="styled-select-inline" style="width:40%">
                        <select class="styled-inline" name="facturation" id="facturation" onchange="calc_price()">
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
                        <input name="datesign" type="text" id="datesign" value="<?php echo date('d-m-Y');?>" class="styled datep" style="width:15%"> 
                    </td>
                </tr> 
                <tr>
                    <td class="right" width="50%">Facturation de la premi&egrave;re p&eacute;riode ?</td>
                    <td class="left" width="50%"><input type="checkbox" name="fact_first" value="oui"/></td>
                </tr>
            </tbody>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-pencil"></i><span>Cr&eacute;er</span></button>
        </div>
        </form>
	</div>
</div>
<?php
//On inclus la liste des contrats.
include_once("lister_parcs.php");
?> 

