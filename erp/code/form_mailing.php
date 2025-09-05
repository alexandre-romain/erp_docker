<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script type="text/javascript" src="include/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({selector:'textarea'});
/* SHOW / HIDE */
$(document).ready(function() {
	$("#show_mail").hide();
	$("#hide_mail").click(function(){
		$("#mail").hide(500);	
		$("#hide_mail").hide();
		$("#show_mail").show();
	});
	$("#show_mail").click(function(){
		$("#mail").show(500);	
		$("#hide_mail").show();
		$("#show_mail").hide();
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
          <i class="fa fa-envelope fa-stack-1x"></i>
        </span>
        Cr&eacute;er un mailing client
        <span class="fa-stack fa-lg add" style="float:right" id="show_mail">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_mail">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - MAILING -->
    <div class="content_traitement" id="mail">
        <form action="mailing.php" method="post" id="edit" name="edit">
            <table class="base" width="100%">
                <tr>
                	<td class="right" width="15%"><?php echo $lang_mailing_list_titremessage; ?> :</td>
                	<td class="left" width="85%"><input type="text" name="titre" class="styled"></td>
                </tr>
                <tr>
                	<td class="right"><?php echo  "$lang_mailing_list_message"; ?> :</td>
                    <td class="left">	 
                        <textarea id="" name="message"></textarea>
                    </td>
                </tr>
            </table>
            <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit">
            <i class="button__icon fa fa-envelope"></i><span>Envoyer </span>
            </button>
            <button class="button_act button--shikoba button--border-thin medium" type="reset">
            <i class="button__icon fa fa-eraser"></i><span>Effacer</span>
            </button>
            </div>
        </form>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
