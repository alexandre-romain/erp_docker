<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
/* SHOW / HIDE */
$(document).ready(function() {
	$("#show_add").hide();
	$("#hide_add").click(function(){
		$("#add").hide(500);	
		$("#hide_add").hide();
		$("#show_add").show();
	});
	$("#show_add").click(function(){
		$("#add").show(500);	
		$("#hide_add").show();
		$("#show_add").hide();
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
<!-- LISTE DES PANIERS -->
<div class="portion">
    <!-- TITRE - LISTE DES PANIERS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-user-plus fa-stack-1x"></i>
        </span>
        <?php echo $lang_utilisateur_ajouter; ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_add">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_add">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - LISTE DES PANIERS -->
    <div class="content_traitement" id="add">
        <form action="register.php" method="post" name="utilisateur" id="utilisateur">
        	<div class="portion_subtitle"><i class="fa fa-user"></i> Informations utilisateur</div>
            <table class="base" width="100%">
                <tr> 
                    <td class='right' width="50%"><?php echo 'Nom d\'utilisateur (login)' ?> :</td>
                    <td class='left'><input name="login2" type="text" id="login2" class="styled"></td>
                </tr>
                <tr> 
                    <td class='right' width="50%"> <?php echo $lang_nom; ?> :</td>
                    <td class='left'><input name="nom" type="text" id="nom" class="styled"></td>
                </tr>
                <tr> 
                    <td class='right'><?php echo $lang_prenom; ?> :</td>
                    <td class='left'><input name="prenom" type="text" id="prenom" class="styled"></td>
                </tr>
                <tr> 
                    <td class='right'><?php echo $lang_motdepasse; ?> :</td>
                    <td class='left'><input name="pass" type="password" id="pass" class="styled"></td>
                </tr>
                <tr> 
                    <td class='right'>Confirmer le mot de passe :</td>
                    <td class='left'><input name="pass2" type="password" id="pass2" class="styled"></td>
                </tr>
                <tr> 
                    <td class='right'><?php echo $lang_mail; ?> :</td>
                    <td class='left'><input name="mail" type="text" id="mail" class="styled"></td>
                </tr>
        	</table>
            <div class="portion_subtitle"><i class="fa fa-shield"></i> Droits utilisateurs</div>
            <table class="base" width="100%">
                <tr>
                    <td class='right' width="50%"><?php echo $lang_ger_dev ?></td>
                    <td class='left' width="50%">
                    	<div class="styled-select-inline" style="width:20%">
                    	<select name ="dev" class="styled-inline">
                        <option value="n"><?php echo $lang_non ?></option>
                        <option value="y"><?php echo $lang_oui ?></option>
                        <option value="r"><?php echo $lang_restrint ?></option>
                        </select>
                        </div>
                    </td>
                </tr>	
                <tr>
                    <td class='right'><?php echo $lang_ger_com ?></td>
                    <td class='left'>
                    	<div class="styled-select-inline" style="width:20%">
                        <select name ="com" class="styled-inline">
                        <option value="n"><?php echo $lang_non ?></option>
                        <option value="y"><?php echo $lang_oui ?></option>
                        <option value="r"><?php echo $lang_restrint ?></option>
                        </select>
                        </div>
                    </td>
                </tr>		
                <tr>
                    <td class='right'><?php echo $lang_ger_fact ?></td>
                    <td class='left'>
                    	<div class="styled-select-inline" style="width:20%">
                        <select name ="fact" class="styled-inline">
                        <option value="n"><?php echo $lang_non ?></option>
                        <option value="y"><?php echo $lang_oui ?></option>
                        <option value="r"><?php echo $lang_restrint ?></option>
                        </select>
                        </div>
                    </td>
                </tr>		
                <tr>
                    <td class='right'><?php echo 'Peut g&eacute;rer les d&eacute;penses ?'; ?></td>
                    <td class='left'>
                    	<div class="styled-select-inline" style="width:20%">
                        <select name ="dep" class="styled-inline">
                        <option value="n"><?php echo $lang_non ?></option>
                        <option value="y"><?php echo $lang_oui ?></option>
                        </select>
                        </div>
                    </td>
              	</tr>
                <tr>
                    <td class='right'><?php echo $lang_ger_stat ?></td>
                    <td class='left'>
                    	<div class="styled-select-inline" style="width:20%">
                        <select name ="stat" class="styled-inline">
                        <option value="n"><?php echo $lang_non ?></option>
                        <option value="y"><?php echo $lang_oui ?></option>
                        </select>
                        </div>
                    </td>
                </tr>		
                <tr>
                    <td class='right'><?php echo $lang_ger_art ?></td>
                    <td class='left'>
                    	<div class="styled-select-inline" style="width:20%">
                        <select name ="art" class="styled-inline">
                        <option value="n"><?php echo $lang_non ?></option>
                        <option value="y"><?php echo $lang_oui ?></option>
                        </select>
                        </div>
                    </td>
                </tr>		
                <tr>
                    <td class='right'><?php echo $lang_ger_cli ?></td>
                    <td class='left'>
                    	<div class="styled-select-inline" style="width:20%">
                        <select name ="cli" class="styled-inline">
                        <option value="n"><?php echo $lang_non ?></option>
                        <option value="y"><?php echo $lang_oui ?></option>
                        </select>
                        </div>
                    </td>
                </tr>		
                <tr>
                    <td class='right'><?php echo $lang_dr_admi ?> ?<br>(<?php echo $lang_admi_modu ?>)</td>
                    <td class='left'>
                    	<div class="styled-select-inline" style="width:20%">
                        <select name ="admin" class="styled-inline">
                        <option value="n"><?php echo $lang_non ?></option>
                        <option value="y"><?php echo $lang_oui ?></option>
                        </select>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="center">
                <button class="button_act button--shikoba button--border-thin medium" type="submit">
                    <i class="button__icon fa fa-floppy-o"></i><span>Enregistrer </span>
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
