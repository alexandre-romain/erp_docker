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
//Gestion des messages informatifs
include_once("include/message_info.php");
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
    <div class="content_traitement" id="search">
        <form name="form_bon" method="post" action="ca_client_parmois.php">
            <table class="base" width="100%">
                    <tr>
                      <td class="right" width="50%"><?php echo $lang_client; ?> :</td>
                      <td class="left" width="50%">
                        <?php
                        $rqSql ="SELECT num_client, nom FROM " . $tblpref ."client WHERE actif != 'non'ORDER BY nom"; 
                        $result = mysql_query( $rqSql ) or die( "Exécution requête impossible.");
                        ?>
                        <div class="styled-select-inline" style="width:60%">
                            <SELECT NAME='client' class="styled-inline">
                                <OPTION VALUE=0>Choisissez</OPTION>
                                <?php
                                while ( $row = mysql_fetch_array( $result)) {
                                    $numclient = $row["num_client"];
                                    $nom = $row["nom"];
                                    ?>
                                    <OPTION VALUE='<?php echo $numclient; ?>'><? echo $nom; ?> </OPTION>
                                <?
                                }
                                ?>
                            </SELECT>
                        </div>
                      </td>
                    </tr>
                <tr>
                    <td class="right">Année :</td>
                    <td class="left">
                        <div class="styled-select-inline" style="width:60%">
                        <select name="an" class="styled-inline">
                            <?php
                            //Permet de lister les années ==> Changer $i < 2016 pour augmenter la valeur finale; changer $i=2004 pour modifier la valeur initiale
                            for ($i=2004 ; $i < 2030 ; $i++) {
                                echo '<option value="'.$i.'">'.$i.'</option>';
                            }
                            ?>
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