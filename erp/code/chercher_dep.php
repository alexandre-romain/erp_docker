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
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!--AJOUT STOCK-->
<div class="portion">
    <!-- TITRE - AJOUT STOCK -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-search fa-stack-1x"></i>
        </span>
        <?php echo "$lang_che_dep" ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_search">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_search">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - AJOUT STOCK -->
    <div class="content_traitement" id="search">
        <form name="form_rec_dep" method="post" action="rep_rech_dep.php">
        <table class="base" width="100%">
            <tr>
                <td class='right' width="50%">Fournisseur :</td>
                <td class='left' width="50%">
                    <?php 
                    $rqSql = "SELECT * FROM " . $tblpref ."depense GROUP by fournisseur ORDER BY fournisseur";
                    $result = mysql_query( $rqSql ) or die( "Ex&eacute;cution requ&ecirc;te impossible.");
					?>
                    <div class="styled-select-inline" style="width:40%">
                    <SELECT NAME='fournisseur' class="styled-inline">
                    <OPTION VALUE=''><?php echo $lang_choisissez;?></OPTION>
                    <?php
                    while ( $row = mysql_fetch_array( $result)) {
                        $four = $row["fournisseur"];
						?>
                        <OPTION VALUE='<?php echo $four;?>'><?php echo stripslashes($four);?></OPTION>
                        <?php
                    }
					?>
                    </SELECT>
                    </div>
                </td>
            </tr>
            <tr>
                <td class='right'>Dépense n° :</td>
                <td class='left'><input name="numero" type="text" id="numero" value="" size="2" class="styled"></td>
            </tr>
            <tr>
                <td class='right'><?php echo $lang_jour; ?> :</td>
                <td class="left"><input name="jour" type="text" id="jour"  size="2" class="styled"></td>
            </tr>
            <tr>
                <td class='right'><?php echo $lang_mois; ?> :</td>
                <td class="left"><input name="mois" type="text" id="mois" size="2" maxlength="2" class="styled"></td>
            </tr>
            <tr>
                <td class='right'><?php echo $lang_annee; ?> :</td>
                <td class="left"><input name="annee" type="text" id="annee" size="4" class="styled"></td>
            </tr>
            <tr>
                <td class='right'><?php echo $lang_montant_htva; ?> :</td>
                <td class="left"><input name="montant" type="text" id="montant" class="styled"></td>
            </tr>
            <tr>
                <td class='right'><?php echo $lang_tri; ?> :</td>
                <td class="left">
                	<div class="styled-select-inline" style="width:40%">
                    <select name="tri" id="tri" class="styled-inline">
                        <option value="fournisseur"><?php echo $lang_fournisseur; ?></option>
                        <option value="num"><?php echo "$lang_no_dep" ?></option>
                        <option value="date"><?php echo $lang_date ?></option>
                        <option value="prix"><?php  echo $lang_montant_htva ?></option>
                    </select> 
                    </div>
                </td>
            </tr>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-search"></i><span><?php echo $lang_rech ?></span></button>
        </div>
        </form>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>