<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	<?php 
	if ($page == 'recherche.php') { 
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
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
$rqSql = "SELECT num_client, nom FROM " . $tblpref ."client WHERE 1";
if ($user_com == r) { 
	$rqSql = "SELECT num_client, nom FROM " . $tblpref ."client 
				WHERE " . $tblpref ."client.permi LIKE '$user_num,' 
		 		or  " . $tblpref ."client.permi LIKE '%,$user_num,' 
				or  " . $tblpref ."client.permi LIKE '%,$user_num,%' 
		 		or  " . $tblpref ."client.permi LIKE '$user_num,%' 
				";  
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
        <?php echo $lang_commandes_chercher; ?>
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
    <div class="content_traitement <?php if ($page == 'recherche.php') { echo 'disp_none';}?>" id="search">
        <form name="formu" method="post" action="recherche.php">
            <table class="base" width="100%">
            	<tbody>
                    <tr> 
                        <td class="right" width="50%"> <?php echo "$lang_client "; ?></td>
                        <td class="left" width="50%">
                        	<?php 
							include_once("include/choix_cli.php");
							?> 
                        </td>
                    </tr>
                </tbody>
                <tr>
                    <td class="right"> <?php echo $lang_num_bon; ?></td>
                    <td class="left"  colspan="5"><input name="numero" type="text" id="numero" value="" size="50" class="styled"></td>
                </tr>
                <tr>
                    <td class="right"> <?php echo $lang_jour?> </td>
                    <td class="left"><input name="jour" type="text" id="jour"  size="5" maxlength="2" class="styled"></td>
                </tr>
                <tr>
                    <td class="right"> <?php echo $lang_mois ?> </td>
                    <td class="left"><input name="mois" type="text" id="mois" size="5"  maxlength="2" class="styled"> </td>
               	</tr>
                <tr>
                    <td class="right"> <?php echo $lang_annee?> </td>
                    <td class="left"><input name="annee" type="text" id="annee" size="5" maxlength="4" class="styled"></td>
                </tr>
                <tr>
                    <td class="right"> <?php echo $lang_prix_h_tva ; ?> </td>
                    <td class="left" colspan="5"><input name="montant" type="text" id="montant" size="50" class="styled"></td>
                </tr>
                <tr>
                    <td class="right"><?php  echo $lang_tri ?></td>
                    <td class="left">
                    	<div class="styled-select-inline" style="width:40%;">
                        <select name="tri" id="tri" class="styled-inline">
                        <option value="nom"><?php echo $lang_client?></option>
                        <option value="num_bon"><?php echo $lang_num_bon?></option>
                        <option value="date"><?php echo $lang_date ?></option>
                        <option value="<?php echo "$tblpref" ?>bon_comm.tot_htva"><?php  echo $lang_montant_htva ?></option>
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
