<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script type="text/javascript">
function montrer_cacher(laCase,value,leCalk,leCalk2) {
	if (value=='y') 
	{
		document.getElementById(leCalk).style.visibility="visible";
				document.getElementById(leCalk2).style.visibility="visible";
	}
	else 
	{
		document.getElementById(leCalk).style.visibility="hidden";
				document.getElementById(leCalk2).style.visibility="hidden";
	}
}
/* SHOW / HIDE */
$(document).ready(function() {
	$("#show_settings").hide();
	$("#hide_settings").click(function(){
		$("#settings").hide(500);	
		$("#hide_settings").hide();
		$("#show_settings").show();
	});
	$("#show_settings").click(function(){
		$("#settings").show(500);	
		$("#hide_settings").show();
		$("#show_settings").hide();
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
<!-- MAILING -->
<div class="portion">
    <!-- TITRE - MAILING -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-cog fa-stack-1x"></i>
        </span>
        <?php echo "Modifier les param&egrave;tres de l'ERP"; ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_settings">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_settings">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - MAILING -->
    <div class="content_traitement" id="settings">
        <form action="admin_modif.php" method="post" >
        <table class="base" width="100%">
            <tr> 
                <td class="right" width="50%"><?php echo "$lang_use_cat"; ?> :</td>
                <td class="left" width="50%">
                    <select name="choix_use_cat">
                        <option <?php if($use_categorie =='y'){echo"selected";}?> value="y">oui</option>
                        <option <?php if($use_categorie !='y'){echo"selected";}?> value="n">non</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="right"><?php echo "$lang_use_list_client"; ?></td>
                <td class="left">
                    <select name="choix_use_liste_cli">
                        <option <?php if($liste_cli =='y'){echo"selected";}?> value="y">oui</option>
                        <option <?php if($liste_cli !='y'){echo"selected";}?> value="n">non</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="right"><?php echo"$lang_use_payement"; ?></td>
                <td class="left">
                    <select name="choix_use_payement">
                        <option <?php if($use_payement =='y'){echo"selected";}?> value="y">oui</option>
                        <option <?php if($use_payement !='y'){echo"selected";}?> value="n">non</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="right"><?php echo"$lang_choix_use_lot"; ?></td>
                <td class="left">
                    <select name="choix_use_lot">
                        <option <?php if($lot =='y'){echo"selected";}?> value="y">oui</option>
                        <option <?php if($lot !='y'){echo"selected";}?> value="n">non</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="right"><?php echo"$lang_choix_use_stock"; ?></td>
                <td class="left">
                    <select name="choix_use_stock">
                        <option <?php if($use_stock =='y'){echo"selected";}?> value="y">oui</option>
                        <option <?php if($use_stock !='y'){echo"selected";}?> value="n">non</option>
                    </select>
                </td>
            </tr>
            <!--impression -->
            <tr>
                <td class="right"><?php echo"$lang_choix_Impression"; ?>
                </td>
                <td class="left">
                    <select name="choix_impression" onchange="montrer_cacher(this,value,'cluster','cluster2')">
                        <option <?php if($autoprint =='y'){echo"selected";}?> value="y">oui</option>
                        <option <?php if($autoprint !='y'){echo"selected";}?> value="n">non</option>					
                    </select>
                    <div id="cluster2" <?php if($autoprint !='y'){ echo"style=\"visibility:hidden\"";}?> ><?php echo"$lang_nbr_impression"; ?> </div>
                    <input type="text" size="3" value="<?php echo"$nbr_impr"; ?>" name="nbr_impr" id="cluster" <?php if($autoprint !='y'){ echo"style=\"visibility:hidden\"";}?> />
               </td>
            </tr>
            <!-- fin impression -->
            <tr>
                <td class="right"><?php echo "Choix du th&ecirc;me"; ?></td>
                <td class="left">
                    <select name="choix_theme">
                        <?php 
                        if ($handle = opendir('include/themes')) {
                            while (false !== ($file = readdir($handle))) {
                                if ($file != "." && $file != ".." && is_dir("include/themes/$file")) {
                                    echo "<option ";
                                    if($theme ==$file){
                                        echo"selected ";
                                    }
                                    echo"value=\"$file\">$file</option>";
                                }
                            }
                            closedir($handle);
                        }
                        ?> 
                    </select>
                </td>
            </tr>		
            <tr>
                <td colspan="2" class="main_table_header"><input type="submit" class="submit"/><input type="reset" class="submit"/></td>
            </tr>
        </table>
        </form>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
