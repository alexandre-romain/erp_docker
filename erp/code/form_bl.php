<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$( "#show_create" ).hide();
	$( "#show_create" ).click(function() {
		$( "#create" ).show(500);
		$( "#show_create" ).hide();
		$( "#hide_create" ).show();
	});
	$( "#hide_create" ).click(function() {
		$( "#create" ).hide(500);
		$( "#show_create" ).show();
		$( "#hide_create" ).hide();
	});
});
<!-- DATEPICKER -->
$(function() {
	$( "#date_new" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd/mm/yy" })
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
$annee = date("Y");
$mois = date("m");
$jour = date("d");
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!--FILTRES-->
<div class="portion">
    <!-- TITRE - LISTE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        Cr&eacute;er un bon de livraison
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
        <form name="formu" method="post" action="convert_bl.php" >
            <table class="base" width="100%">
                <tr> 
                    <td class="right" width="50%">Bon de commande :</td>
                    <td class="left" width="50%">
                        <?php 
                        $rqSql = "SELECT num_bon, client_num, DATE_FORMAT(date,'%d/%m/%Y') AS date, tot_htva FROM " . $tblpref ."bon_comm WHERE bl != 'end' ORDER BY num_bon DESC";
                        $result = mysql_query( $rqSql ) or die( "Exécution requête impossible.");
                        ?>  
                        <div class="styled-select-inline" style="width:60%;">
                        <SELECT NAME='commande' class="styled-inline">
                        <OPTION VALUE='0'><?php echo $lang_choisissez; ?></OPTION>
                        <?php
                        while ( $row = mysql_fetch_array($result)) 
                        {
                            $numclient = $row['client_num'];
                            $date = $row['date'];
                            $tot_htva = $row['tot_htva'];			
                            $numbon = $row['num_bon'];
                
                            $rqSql2 = "SELECT nom FROM " . $tblpref ."client WHERE num_client = $numclient";
                            $result2 = mysql_query( $rqSql2 ) or die( "Exécution requête impossible.");
                            while ( $row2 = mysql_fetch_array( $result2)){ 
                                $nom = $row2['nom'];
                            }
                            ?>
                            <OPTION VALUE='<?php echo $numbon; ?>'><?php echo $numbon." ".$nom." ".$date." ".$tot_htva." euros"; ?></OPTION>
                        <?php 
                        }
                        ?>
                        </SELECT>
                        </div>
                    </td>
                </tr>
                <tr> 
                    <td class="right">Date :</td>
                    <td class="left">
                        <input type="text" name="date" value="<?php echo "$jour/$mois/$annee" ?>" readonly="readonly" id="date_new" class="styled"/>
                    </td>
                </tr>
            </table>
            <div class="center">
                <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-pencil"></i><span>Cr&eacute;er le BL</span></button>
            </div>
        </form>
	</div>
</div>
<?php
include_once("lister_bl.php");
?> 

