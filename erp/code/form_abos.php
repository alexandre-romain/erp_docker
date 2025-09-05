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
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
//Gestion des messages informatifs
include_once("include/message_info.php");
$rqSql = "SELECT num_client, nom FROM " . $tblpref ."client WHERE actif != 'non'";
$result = mysql_query( $rqSql ) or die( "Exécution requête impossible.");
$rqSql2 = "SELECT * FROM " . $tblpref ."tarifs";
$result2 = mysql_query( $rqSql2 ) or die( "Exécution requête2 impossible.");
$annee = date("Y");
$mois = date("m");
$jour = date("d");
?> 
<!--FILTRES-->
<div class="portion">
    <!-- TITRE - LISTE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        Créer un abonnement
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
    <div class="content_traitement" id="create">
        <form name="formu" method="post" action="abos.php" >
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
                    <td class="right">Tarif :</td>
                    <td class="left">
                    	<div class="styled-select-inline" style="width:40%">
                        <select name="tarif" id="tarif" class="styled-inline">
                            <?php
                            while ( $row2 = mysql_fetch_array( $result2)) {
                                $ID_tarif = $row2["ID"];
                                $description_tarif = $row2["description"];
                                $prix_tarif = $row2["prix"];
                                echo "<option value=".$ID_tarif.">\"".$description_tarif."\" ".$prix_tarif." &euro;</option>";
                            } 
                            ?>
                        </select>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="center">
                <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-pencil"></i><span>Cr&eacute;er</span></button>
            </div>
        </form>
	</div>
</div>
<?php
include_once("lister_abos.php");
?> 