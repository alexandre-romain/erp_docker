<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script type="text/javascript" src="./include/js/autocomplete.js"></script>
<script type="text/javascript" src="./include/js/jquery.jeditable.js"></script>
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
?>
<!--SEARCH FILTER-->
<div class="portion">
    <!-- TITRE - SEARCH -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        Cr&eacute;er un nouvel article
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
    <!-- CONTENT - SEARCH -->
    <div class="content_traitement" id="create">
		<form action="article_new.php" method="post" name="artice" id="artice" onSubmit="return verif_formulaire()" >     
                <div class="portion_subtitle"><i class="fa fa-laptop fa-fw"></i> Article</div>      
                <table width="100%" align="center" class="base">
                <tr> 
                	<td class='right' width="20%"> <?php echo "$lang_art_no"; ?> :</td>
                    <td class='left' width="30%"> <input name="article" type="text" id="article_n" size="40" maxlength="40" class="styled"></td>
                    <td class='right' width="20%">Marque :</td>
                    <td class='left' width="30%"><input name="marque" type="text" id="marque" size="40" class="styled"></td>
                </tr>
                <tr> 
                    <td class='right'>Partnumber :</td>
                    <td class='left'><input name="reference" type="text" id="reference" size="40" class="styled"></td>
                    <td class='right'> <?php echo "$lang_uni_art" ?> :</td>
                    <td class='left'><input name="uni" type="text" id="uni" size="8" maxlength="8" class="styled"></td>
                </tr>
                <tr> 
                    <td class='right'>Fournisseur :</td>
                    <td class='left'>
                    	<div class="styled-select-inline" style="width:40%">
                        <select class="styled-inline" name="fourn" required>
                        	<?php
							$sql="SELECT * FROM ".$tblpref."fournisseurs WHERE actif='1'";
							$req=mysql_query($sql);
							while ($obj = mysql_fetch_object($req)) {
								?>
                                <option value="<?php echo $obj->id;?>"><?php echo $obj->nom;?></option>
                                <?php
							}
							?>
                        </select>
                        </div>
                    </td>
                </tr>
                </table>
                <?php
                include_once("include/configav.php");
                if ($use_categorie =='y') { ?>
                	<div class="portion_subtitle"><i class="fa fa-puzzle-piece fa-fw"></i> Cat&eacute;gorie(s) de l'article</div>
                    <table width="100%" align="center" class="base">
                    <tr> 
                        <td class='right' width="20%">Top Cat.</td>
                        <td class="left" width="30%"> 
                            <?php
                            $rqSql = "SELECT id_cat, categorie FROM " . $tblpref ."categorie WHERE cat_level = 1 ORDER BY categorie ASC";
                            $result = mysql_query( $rqSql ) or die( "Exécution requête impossible."); ?>
                            <div class="styled-select-inline" style="width:70%;">
                            <SELECT NAME='cat1' id="cat1" onchange="top_to_middle_cat2()" class="styled-inline">
                                <OPTION VALUE='0'><?php echo $lang_choisissez; ?></OPTION>
                                <?php
                                while ( $row = mysql_fetch_array( $result)) {
                                    $num_cat = $row["id_cat"];
                                    $categorie = $row["categorie"];
                                    ?>
                                    <OPTION VALUE='<?php echo "$num_cat" ; ?>'><?php echo "$categorie"; ?></OPTION>
                                <?
                                }
                                ?>
                            </SELECT>
                            </div>
                        </td>
                        <td class='right' width="20%">Middle Cat.</td>
                        <td class='left' width="30%"> 
                            <?php
                            $rqSql = "SELECT id_cat, categorie FROM " . $tblpref ."categorie WHERE cat_level = 2 ORDER BY categorie ASC";
                            $result = mysql_query( $rqSql ) or die( "Exécution requête impossible."); ?>
                            <div class="styled-select-inline" style="width:70%;">
                            <SELECT NAME='cat2' id="cat2" onchange="middle_to_bot_cat2()" class="styled-inline">
                                <OPTION VALUE='0'>Choisissez d'abord une top cat.</OPTION>
                            </SELECT>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class='right' width="20%">Bottom Cat.</td>
                        <td class='left' width="30%"> 
                            <?php
                            $rqSql = "SELECT id_cat, categorie FROM " . $tblpref ."categorie WHERE cat_level = 3 ORDER BY categorie ASC";
                            $result = mysql_query( $rqSql ) or die( "Exécution requête impossible."); ?>
                            <div class="styled-select-inline" style="width:70%;">
                            <SELECT NAME='cat3' id="cat3" class="styled-inline">
                                <OPTION VALUE='0'>Choisissez d'abord une middle cat.</OPTION>
                            </SELECT>
                            </div>
                        </td>
                    </tr>
                </table>	
                <?php 
                } 
                ?>
                <div class="portion_subtitle"><i class="fa fa-money fa-fw"></i> Financier</div> 
                <table width="100%" align="center" class="base">
                <tr> 
                    <td class='right' width="20%"> Prix Achat :</td>
                    <td class='left' width="30%"><input name="prix" type="text" id="prix" size="8" class="styled"> &euro; (PV Si marge = 0 -&gt; service)</td>
                    <td class='right' width="20%"> <?php echo "$lang_ttva" ?> :</td>
                    <td class='left' width="30%"> <input name="taux_tva" type="text" id="taux_tva" value="21" size="5" maxlength="5" class="styled"> %</td>
                </tr>
                <tr> 
                    <td class='right'>Marge :</td>
                    <td class='left'><input name="marge" type="text" id="marge" size="8" class="styled"> % (0 pour le service) </td>
                    <td class='right'>Garantie :</td>
                    <td class='left'><input name="garantie" type="text" id="garantie" value="1 an" size="8" class="styled"></td>
                </tr>
                <tr> 
                    <td class='right'>Recupel (HTVA) :</td>
                    <td class='left'><input name="recupel" type="text" id="recupel" size="8" class="styled"> &euro; </td>
                    <td class='right'>Reprobel (HTVA) :</td>
                    <td class='left'><input name="reprobel" type="text" id="reprobel" size="8" class="styled"> &euro; </td>
                </tr>
                <tr> 
                    <td class='right'>Bebat (HTVA) :</td>
                    <td class='left'><input name="bebat" type="text" id="bebat" size="8" class="styled"> &euro; </td>
                </tr>
                </table>
                <div class="portion_subtitle"><i class="fa fa-truck fa-fw"></i> Stock</div> 
                <table width="100%" align="center" class="base">
                <tr> 
                    <td class='right' width="20%"><?php echo "$lang_stock"; ?> :</TD>
                    <td class='left' width="30%"><input name='stock' type='text' size="8" class="styled"></td>
                </tr>
                <tr> 
                    <td class='right' width="20%"><?php echo"$lang_stomin"; ?> :</td>
                    <td class='left' width="30%"><input name='stomin' type='text' size="8" class="styled"></td>
                    <td class='right' width="20%"><?php echo"$lang_stomax"; ?> :</td>
                    <td class='left' width="30%"><input name='stomax' type='text' size="8" class="styled"></td>
                </tr>
                </table>
                <div class="portion_subtitle"><i class="fa fa-cog fa-fw"></i> Autre</div> 
                <table width="100%" align="center" class="base">
                <tr>
                	<td class='right' width="20%"> <?php echo "$langCommentaire" ?> :</td>
                    <td class='left' width="80%"><input name="commentaire" type="text" id="commentaire" size="40" class="styled"></td>
                </tr>
            </table>
            <div class="center">
                <button class="button_act button--shikoba button--border-thin medium" type="submit" name="Submit"><i class="button__icon fa fa-floppy-o"></i><span>Enregistrer</span></button>
                <button class="button_act button--shikoba button--border-thin medium" type="reset" name="reset" id="reset"><i class="button__icon fa fa-eraser"></i><span>Effacer</span></button>
            </div>
       	</form>
    </div>
</div>

<?php
if ($use_categorie =='y') { 
	include_once("ajouter_cat.php");
}
$aide = article;
require_once("lister_articles_form.php");
?>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>



