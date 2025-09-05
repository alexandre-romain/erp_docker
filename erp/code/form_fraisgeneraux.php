<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_create").hide();
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
	$( ".datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd/mm/yy" })
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
$rqSql = "SELECT * FROM " . $tblpref ."depense GROUP by fournisseur ORDER BY fournisseur";
$result = mysql_query( $rqSql ) or die( "Ex&eacute;cution requ&ecirc;te impossible.");
$jour = date("d");
$mois = date("m");
$annee = date("Y");
?>
<!--CREATION FRAIS GENERAUX-->
<div class="portion">
    <!-- TITRE - CREATION FRAIS GENERAUX -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-plus fa-stack-1x"></i>
        </span>
        Ajouter un achat (Frais Généraux)
        <span class="fa-stack fa-lg add" style="float:right" id="show_create">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_create">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - CREATION FRAIS GENERAUX -->
    <div class="content_traitement" id="create">
        <form action="form_fraisgeneraux_suite.php" method="post" name="depense" id="depense">
        <table class="base" width="100%">
            <tr> 
                <td class="right" width="50%"> <?php echo "$lang_fournisseur" ?> :</td>
                <td class="left" width="50%">
                	<div class="styled-select-inline" style="width:40%">
                    <SELECT NAME='fournisseur' class="styled-inline">
                        <OPTION VALUE=default><?php echo $lang_choisissez; ?></OPTION>
                        <?php
                        while ( $row = mysql_fetch_array( $result))
                        {
                            $four = $row["fournisseur"];
                            $four = stripslashes($four);
                            $four2 = addslashes($four);
                            ?>
                                <OPTION VALUE="<?php echo "$four2"; ?>"><?php echo"$four"; ?></OPTION>
                        <?php
                        }
                        ?>
                    </SELECT>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="right"><b>OU</b> entrez le nom du fournisseur :</td>
                <td class="left"><input name="fourn" type="text" id="article" size="30" maxlength="30" class="styled"></td>
            </tr>
            <tr>
                <td class="right"> <?php echo $lang_libelle; ?> :</td>
                <td class="left"><input name="lib" type="text" id="lib" size="30" maxlength="30" class="styled"></td>
            </tr>
            <tr>
                <td class="right"> <?php echo $lang_prix_h_tva;  ?> :</td>
                <td class="left"><input name="prix" type="text" id="prix" class="styled"> <?php echo $devise; ?></td>
            </tr>
            <tr>
                <td class="right">Date :</td>
                <td class="left">
                    <input type="text" name="date" value="<?php echo"$jour/$mois/$annee" ?>" readonly="readonly" class="styled datepicker"/>
                </td>
            </tr>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-pencil"></i><span>Cr&eacute;er</span></button>
            <button class="button_act button--shikoba button--border-thin medium" type="reset"><i class="button__icon fa fa-eraser"></i><span><?php echo $lang_effacer; ?></span></button>
        </div>
        </form>
	</div>
</div>        
<?php
include_once("lister_depenses.php");
?>