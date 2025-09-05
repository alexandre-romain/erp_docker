<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script type="text/javascript">
/* SHOW / HIDE */
$(document).ready(function() {
	$("#show_backup").hide();
	$("#hide_backup").click(function(){
		$("#backup").hide(500);	
		$("#hide_backup").hide();
		$("#show_backup").show();
	});
	$("#show_backup").click(function(){
		$("#backup").show(500);	
		$("#hide_backup").show();
		$("#show_backup").hide();
	});
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
$page = split("/", getenv('SCRIPT_NAME')); 
$n = count($page)-1; 
$page = $page[$n]; 
$page = split("\.", $page, 2); 
$extension = $page[1];
$page = $page[0];
$script 	= "$page.$extension";
$directory 	= $_SERVER['PHP_SELF'];
$script_base = "$base_url$directory";
$base_path = $_SERVER['PATH_TRANSLATED'];
$url_base = ereg_replace("$script", '', "$_SERVER[PATH_TRANSLATED]");
?> 
<!-- BACKUP -->
<div class="portion">
    <!-- TITRE - BACKUP -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-floppy-o fa-stack-1x"></i>
        </span>
        <?php echo $lang_bc_titre ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_backup">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_backup">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - BACKUP -->
    <div class="content_traitement" id="backup">
        <FORM NAME="dobackup" METHOD="post" ACTION="main.php">
        <table class="base" width="100%">
            <TR> 
                <td class="right" width="50%"><?php echo $lang_bc_host ?> :</TD>
                <td class="left" width="50%"> <INPUT NAME="dbhost" TYPE="text" class="styled" VALUE="<?php echo $host; ?>" SIZE="37" MAXLENGTH="100"></TD>
            </TR>
            <TR> 
                <td class="right"><?php echo $lang_bc_bata ?> :</TD>
                <td class="left"> <INPUT NAME="dbuser" TYPE="text" class="styled" VALUE="<?php echo $user; ?>" SIZE="37" MAXLENGTH="100"></TD>
            </TR>
            <TR> 
                <td class="right"><?php echo $lang_bc_bata_pwd ?> :</TD>
                <td class="left"> <INPUT NAME="dbpass" TYPE="password" class="styled" VALUE="<?php echo $pwd; ?>" SIZE="37" MAXLENGTH="100"> </TD>
            </TR>
            <TR> 
                <td class="right"><?php echo $lang_bc_login ?> :</TD>
                <td class="left"> 
                    <INPUT NAME="dbname" TYPE="text" class="styled" VALUE="<?php echo $db; ?>" SIZE="37" MAXLENGTH="100"> 
                     
                </TD>
           </TR>  
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit">
            	<i class="button__icon fa fa-floppy-o"></i><span>Sauvegarder</span>
            </button>
        </div>
        <INPUT NAME="path" TYPE="hidden" class="textbox" VALUE="<? echo $url_base; ?>" SIZE="37" MAXLENGTH="100">
        </FORM>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>