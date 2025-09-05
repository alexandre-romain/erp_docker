<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<link rel="stylesheet" type="text/css" href="include/css/user.css" />
<script>
$(document).ready(function() {
	$("#show_screen").hide();
	$("#hide_screen").click(function(){
		$("#screen").hide(500);	
		$("#hide_screen").hide();
		$("#show_screen").show();
	});
	$("#show_screen").click(function(){
		$("#screen").show(500);	
		$("#hide_screen").show();
		$("#show_screen").hide();
	});
	$("#show_info").hide();
	$("#hide_info").click(function(){
		$("#info").hide(500);	
		$("#hide_info").hide();
		$("#show_info").show();
	});
	$("#show_info").click(function(){
		$("#info").show(500);	
		$("#hide_info").show();
		$("#show_info").hide();
	});
	$("#show_widget").hide();
	$("#hide_widget").click(function(){
		$("#widget").hide(500);	
		$("#hide_widget").hide();
		$("#show_widget").show();
	});
	$("#show_widget").click(function(){
		$("#widget").show(500);	
		$("#hide_widget").show();
		$("#show_widget").hide();
	});
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
?>
<?php
//Gestion des messages informatifs
include_once("include/message_info.php");
//Récupération du flag accusant la modif des widgets
$valid 			= $_REQUEST['valid'];
$valid_shortcut = $_REQUEST['valid_shortcut'];
//Récupération du login user
$user 			= $_SERVER[PHP_AUTH_USER];
//Récupération de l'id utilisiteur accédant à la page
$sql_user=" SELECT num";
$sql_user.=" FROM ".$tblpref."user";
$sql_user.=" WHERE login='".$user."'";
$req_user=mysql_query($sql_user);
$results_user=mysql_fetch_object($req_user);
$num_user=$results_user->num;
//Requête de récupération des information du Profil
$sql="SELECT login, nom, prenom, email, widgt_inter_all, widgt_inter_user, widgt_ticket_user, widgt_ticket_all, widgt_ticket_close_non_fact, widgt_task_day, widgt_commande, shortcut_new_task, shortcut_list_task, shortcut_list_ticket, shortcut_bill, shortcut_list_bill, shortcut_list_article, shortcut_profil, shortcut_accueil, shortcut_param_ticket, widgt_bon_liv, widgt_panier";
$sql.=" FROM ".$tblpref."user";
$sql.=" WHERE login='".$user."'";
$reqsql=mysql_query($sql);
$obj=mysql_fetch_object($reqsql);
?>
<!--Tableau Info Profil-->
<div class="portion">
    <!-- TITRE - Tableau Info Profil -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-user fa-stack-1x"></i>
        </span>
        Votre profil
        <span class="fa-stack fa-lg add" style="float:right" id="show_info">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_info">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - Tableau Info Profil -->
    <div class="content_traitement" id="info">
    	<div class="portion_subtitle"><i class="fa fa-newspaper-o fa-fw"></i> Vos information personelles</div>
        <table class='base' width="100%">
        <tr>
        	<td class='right' width="25%">Nom :</td>
            <td class='left' width="25%"><?php echo $obj->nom; ?></td>
            <td class='right' width="25%">Pr&eacute;nom :</td>
            <td class='left' width="25%"><?php echo $obj->prenom; ?></td>
        </tr>
        <tr>
        	<td class='right'>Login :</td>
            <td class='left'><?php echo $obj->login; ?></td>
            <td class='right'>E-mail :</td>
            <td class='left'><?php echo $obj->email; ?></td>
        </tr>
        </table>
        <div class="portion_subtitle"><i class="fa fa-lock fa-fw"></i> Changer votre mot de passe</div>
        <form action="./include/ajax/Change_password.php" method="post">
        <table class='base' width="100%">
            <tr id="">
            	<td class='right' width="50%">Ancien mot de passe :</td>
                <td class='left' width="50%"><input class="styled" type="password" id="old_pass" name="old_pass"/></td>
            </tr>
            <tr id="">
            	<td class='right'>Nouveau mot de passe :</td>
                <td class='left'><input class="styled" type="password" id="new_pass" name="new_pass"/></td>
            </tr>
            <tr id="">
            	<td class='right'>Confirmer le mot de passe :</td>
                <td class='left'><input class="styled" type="password" id="new_pass_confirm" name="new_pass_confirm"/></td>
            </tr>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-check"></i><span>Valider</span></button>
        </div>
        <input type="hidden" id="user" name="user" value="<?php echo $num_user; ?>"/>
        </form>
	</div>
</div>
<!--WIDGETS-->
<div class="portion">
    <!-- TITRE - WIDGETS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-cube fa-stack-1x"></i>
        </span>
        Vos widgets
        <span class="fa-stack fa-lg add" style="float:right" id="show_widget">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_widget">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - WIDGETS -->
    <div class="content_traitement" id="widget">
        <form name='form_widget' action='./include/ajax/widget_user.php' method='get'>
            <table class='base' width="100%">
                <tr>
                    <td class=''><input type='checkbox' name='wid_inter_all' <?php if ($obj->widgt_inter_all == 1) {echo 'checked';} ?>/>&nbsp;&nbsp;T&acirc;ches</td>
                    <td class=''><input type='checkbox' name='wid_ticket_all' <?php if ($obj->widgt_ticket_all == 1) {echo 'checked';} ?>/>&nbsp;&nbsp;Tickets</td>
                </tr>
                <tr>
                    <td class=''><input type='checkbox' name='wid_ticket_close_non_fact' <?php if ($obj->widgt_ticket_close_non_fact == 1) {echo 'checked';} ?>/>&nbsp;&nbsp;Tickets cl&ocirc;s mais non-factur&eacute;</td>
                    
                    <td class=''><input type='checkbox' name='wid_bon_liv' <?php if ($obj->widgt_bon_liv == 1) {echo 'checked';} ?>/>&nbsp;&nbsp;Bons de livraison non factur&eacute;s</td>
				</tr>
                <tr>
                    <td class=''><input type='checkbox' name='wid_commande' <?php if ($obj->widgt_commande == 1) {echo 'checked';} ?>/>&nbsp;&nbsp;Commandes non-enti&egrave;rement livr&eacute;es</td>
                    <td class=''><input type='checkbox' name='wid_panier' <?php if ($obj->widgt_panier == 1) {echo 'checked';} ?>/>&nbsp;&nbsp;Paniers d'articles arrivant &agrave; terme</td>
                </tr>
            </table>
            <div class="center">
                <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-check"></i><span>Valider</span></button>
            </div>
            <input type='hidden' name='user' id='user' value='<?php echo $user;?>'>
        </form>
	</div>
</div>
<!--Affichage-->
<div class="portion">
    <!-- TITRE - Affichage -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-television fa-stack-1x"></i>
        </span>
        Votre affichage
        <span class="fa-stack fa-lg add" style="float:right" id="show_screen">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_screen">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - Affichage -->
    <div class="content_traitement" id="screen">
    	<div class="portion_subtitle"><i class="fa fa-newspaper-o fa-fw"></i> Votre fond d'&eacute;cran</div>
        <form>
        	<table width="100%">
            	<tr>
                	<td width="16.5%"><img src="./include/themes/FAST_IT/images/background" width="100%" height="140px" onclick="change_back('background.png')"/></td>
                    <td width="16.5%"><img src="./include/themes/FAST_IT/images/back_apple" width="100%" height="140px" onclick="change_back('back_apple.png')"/></td>
                    <td width="16.5%"><img src="./include/themes/FAST_IT/images/back_autumn" width="100%" height="140px" onclick="change_back('back_autumn.png')"/></td>
                	<td width="16.5%"><img src="./include/themes/FAST_IT/images/back_car" width="100%" height="140px" onclick="change_back('back_car.png')"/></td>
                    <td width="16.5%"><img src="./include/themes/FAST_IT/images/back_countryside" width="100%" height="140px" onclick="change_back('back_countryside.png')"/></td>
                    <td width="16.5%"><img src="./include/themes/FAST_IT/images/back_office" width="100%" height="140px" onclick="change_back('back_office.png')"/></td>
                </tr>
                <tr>
                	<td width="16.5%"><img src="./include/themes/FAST_IT/images/back_underwater" width="100%" height="140px" onclick="change_back('back_underwater.png')"/></td>
                    <td width="16.5%"><img src="./include/themes/FAST_IT/images/back_fishing" width="100%" height="140px" onclick="change_back('back_fishing.png')"/></td>
                    <td width="16.5%"><img src="./include/themes/FAST_IT/images/back_growing" width="100%" height="140px" onclick="change_back('back_growing.png')"/></td>
                	<td width="16.5%"><img src="./include/themes/FAST_IT/images/back_space" width="100%" height="140px" onclick="change_back('back_space.png')"/></td>
                    <td width="16.5%"><img src="./include/themes/FAST_IT/images/back_vintage" width="100%" height="140px" onclick="change_back('back_vintage.png')"/></td>
                    <td width="16.5%"><img src="./include/themes/FAST_IT/images/back_bees" width="100%" height="140px" onclick="change_back('back_bees.png')"/></td>
                </tr>
            </table>
        </form>
    </div>
</div>    
<?php
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>