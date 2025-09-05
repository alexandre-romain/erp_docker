<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_search").hide();
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
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD 
$rqSql = "SELECT num_client, nom FROM " . $tblpref ."client WHERE 1";
if ($user_dev == r) { 
$rqSql = "SELECT num_client, nom FROM " . $tblpref ."client 
	 WHERE " . $tblpref ."client.permi LIKE '$user_num,' 
	 or  " . $tblpref ."client.permi LIKE '%,$user_num,' 
	 or  " . $tblpref ."client.permi LIKE '%,$user_num,%' 
	 or  " . $tblpref ."client.permi LIKE '$user_num,%' ";
}
?>
<!--RECHERCHE-->
<div class="portion">
    <!-- TITRE - RECHERCHE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-search fa-stack-1x"></i>
        </span>
        <?php echo $lang_devis_chercher ; ?>
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
    <!-- CONTENT - RECHERCHE -->
    <div class="content_traitement" id="search">
        <form name="formu" method="post" action="recherche_devis.php">
        <table class="base" width="100%"> 
            <tr> 
                <td  class="right" width="50%">
                    <?php echo "$lang_client";?> :
                </td>
                <td class="left" width="50%">
                    <?php
                    include_once("include/choix_cli.php");
                    ?>
                </td>
            </tr>
            <tr>
                <td class="right"><?php echo $lang_devis_numero; ?> :</td>
                <td class="left"><input name="numero" type="text" id="numero" value="" size="5" class="styled"></td>
            </tr>
            <tr>
                <td class="right"><?php echo $lang_jour; ?> :</td>
                <td class="left"><input name="jour" type="text" id="jour"  size="5" maxlength="2" class="styled"></td>
            </tr>
            <tr>
                <td class="right"><?php echo $lang_mois; ?> :</td>
                <td class="left"><input name="mois" type="text" id="mois" size="5"  maxlength="2" class="styled"></td>
            </tr>
            <tr>
                <td class="right"><?php echo $lang_annee; ?> :</td>
                <td class="left"><input name="annee" type="text" id="annee" size="5" maxlength="4" class="styled"></td>
            </tr>
            <tr>
                <td class="right"><?php echo $lang_montant_htva; ?> :</td>
                <td class="left"><input name="montant" type="text" id="montant" class="styled"></td>
            </tr>
            <tr>
                <td class="right"><?php  echo $lang_tri; ?> :</td>
                <td class="left">
                	<div class="styled-select-inline" style="width:20%">
                          <select name="tri" id="tri" class="styled-inline">
                                <option value="nom"><?php echo $lang_client; ?></option>
                                <option value="num_dev"><?php echo $lang_devis_numero; ?></option>
                                <option value="date"><?php echo $lang_date ?></option>
                                <option value="devis.tot_htva">
                                <?php  echo $lang_montant_htva ?>
                                </option>
                          </select>
                  	</div>
                </td>
            </tr>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-search"></i><span>Rechercher</span></button>
        </div>
        </form>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>