<?php 
if ($user_art == n) { 
	echo "<h1>$lang_article_droit";
	exit;  
}
?>
<script>
$(document).ready(function() {
	$( "#hide_cat" ).hide();
	$( "#show_cat" ).click(function() {
		$( "#cat" ).show(500);
		$( "#show_cat" ).hide();
		$( "#hide_cat" ).show();
	});
	$( "#hide_cat" ).click(function() {
		$( "#cat" ).hide(500);
		$( "#show_cat" ).show();
		$( "#hide_cat" ).hide();
	});
});
</script>
<!--FILTRES-->
<div class="portion">
    <!-- TITRE - LISTE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-paint-brush fa-stack-1x"></i>
        </span>
        Cr&eacute;er une nouvelle cat&eacute;gorie
        <span class="fa-stack fa-lg add" style="float:right" id="show_cat">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_cat">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <div class="content_traitement disp_none" id="cat">
    	<form action="categorie_new.php" method="post" >
            <table class="base" align="center" width="100%">
                <tr> 
                    <td class="right" width="50%"><?php echo ucfirst($lang_cat_nom); ?> :</td>
                    <td class="left" width="50%"><input name="categorie" type="text" id="uni2" size="15" maxlength="30" value="" class="styled"></td>
                </tr>
                <tr> 
                    <td class="right" width="50%">Cat&eacute;gorie parente :</td>
                    <td class="left" width="50%">
                    	<?php
						$rqSql = "SELECT id_cat, categorie FROM " . $tblpref ."categorie ORDER BY categorie ASC";
						$result = mysql_query( $rqSql ) or die( "Exécution requête impossible."); ?>
						<div class="styled-select-inline" style="width:70%;">
						<select name="cat_parent" id="cat_parent" class="styled-inline">
							<option value="none">Pas de parent</option>
							<?php
							while ( $row = mysql_fetch_array( $result)) {
								$num_cat = $row["id_cat"];
								$categorie = $row["categorie"];
								?>
								<option value='<?php echo "$num_cat" ; ?>'><?php echo "$categorie"; ?></option>
							<?
							}
							?>
						</select>
						</div>
                    </td>
                </tr>
            </table>
            <div class="center">
                <button class="button_act button--shikoba button--border-thin medium" type="submit" name="Submit2"><i class="button__icon fa fa-floppy-o"></i><span>Enregistrer</span></button>
                <button class="button_act button--shikoba button--border-thin medium" type="reset" name="reset" id="reset2"><i class="button__icon fa fa-eraser"></i><span>Effacer</span></button>
            </div>
      	</form>
    </div>
</div>
  

