<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_edit").hide();
	$("#hide_edit").click(function(){
		$("#edit").hide(500);	
		$("#hide_edit").hide();
		$("#show_edit").show();
	});
	$("#show_edit").click(function(){
		$("#edit").show(500);	
		$("#hide_edit").show();
		$("#show_edit").hide();
	});
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
//Récupération du numéro user édité
if ($num_utilisateur=='') { 
	$num_utilisateur=isset($_GET['num_utilisateur'])?$_GET['num_utilisateur']:"";
} 
$sql = " SELECT * FROM " . $tblpref ."user WHERE num = $num_utilisateur ";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
	$nom = $data['nom'];
	$prenom = $data['prenom'];
	$login = $data['login'];
	$dev = $data['dev'];
	$com = $data['com'];
	$bl = $data['bl'];
	$fact = $data['fact'];
	$mail =$data['email'];
	$dep = $data['dep'];
	$stat = $data['stat'];
	$art = $data['art'];
	$cli = $data['cli'];
	$admin = $data['admin'];
	$num_utilisateur = $data['num'];
}
?>
<!--FILTRE-->
<div class="portion">
    <!-- TITRE - FILTRE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        <?php echo $lang_utilisateur_editer; ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_edit">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_edit">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - FILTRE -->
    <div class="content_traitement" id="edit">
<form action="suite_edit_utilisateur.php" method="post" name="utilisateur" id="utilisateur">
	<div class="portion_subtitle"><i class="fa fa-info-circle fa-fw"></i> Informations utilisateur</div>
    <table class="base" width="100%">
        <tr> 
            <td class='right' width="50%">Login :</td>
            <td class='left' width="50%"><?php echo $login ?>
                <input type="hidden" name="login2" value="<?php echo $login ?>" />
            </td>
        </tr>
        <tr> 
            <td class='right'> <?php echo $lang_nom; ?> :</td>
            <td class='left'><input name="nom" type="text" id="nom" value="<?php echo $nom ?>" class="styled"></td>
        </tr>
        <tr> 
            <td class='right'><?php echo $lang_prenom; ?> :</td>
            <td class='left'><input name="prenom" type="text" id="prenom" value="<?php echo $prenom ?>" class="styled"></td>
        </tr>
        <tr> 
            <td class='right'><?php echo $lang_motdepasse; ?> :</td>
            <td class='left'><input name="pass" type="password" id="pass" class="styled"></td>
        </tr>
        <tr> 
            <td class='right'><?php echo $lang_mot_de_passe; ?> :</td>
            <td class='left'><input name="pass2" type="password" id="pass2" class="styled"></td>
        </tr>
        <tr> 
            <td class='right'><?php echo $lang_mail; ?> :</td>
            <td class='left'><input name="mail" type="text" id="mail" value="<?php echo $mail ?>" class="styled"></td>
        </tr>
    </table>
    <div class="portion_subtitle"><i class="fa fa-lock fa-fw"></i> Droits d'acc&egrave;s</div>
    <table class="base" width="100%">
        <tr>
            <td class='right' width="50%"><?php echo $lang_ger_dev ?></td>
            <td class='left' width="50%">
            	<div class="styled-select-inline" style="width:40%">
                <select name="dev" class="styled-inline">
                    <option value="n" <?php if ($dev == 'n') { echo 'selected';}?>><?php echo $lang_non ?></option>
                    <option value="y" <?php if ($dev == 'y') { echo 'selected';}?>><?php echo $lang_oui ?></option>
                    <option value="r" <?php if ($dev == 'r') { echo 'selected';}?>><?php echo $lang_restrint ?></option>
                </select>
                </div>
            </td>
        </tr>
        <tr>
            <td class='right'><?php echo $lang_ger_com ?></td>
            <td class='left'>
            	<div class="styled-select-inline" style="width:40%">
                <select name="com" class="styled-inline">
                    <option value="n" <?php if ($com == 'n') { echo 'selected';}?>><?php echo $lang_non ?></option>
                    <option value="y" <?php if ($com == 'y') { echo 'selected';}?>><?php echo $lang_oui ?></option>
                    <option value="r" <?php if ($com == 'r') { echo 'selected';}?>><?php echo $lang_restrint ?></option>
                </select>
                </div>
            </td>
        </tr>
        <tr>
            <td class='right'>Peut g&eacute;rer les bons de livraison ?</td>
            <td class='left'>
            	<div class="styled-select-inline" style="width:40%">
                <select name="bl" class="styled-inline">
                    <option value="n" <?php if ($bl == 'n') { echo 'selected';}?>><?php echo $lang_non ?></option>
                    <option value="y" <?php if ($bl == 'y') { echo 'selected';}?>><?php echo $lang_oui ?></option>
                </select>
                </div>
            </td>
        </tr>
        <tr>
            <td class='right'><?php echo $lang_ger_fact ?></td>
            <td class='left'>
            	<div class="styled-select-inline" style="width:40%">
                <select name="fact" class="styled-inline">
                    <option value="n" <?php if ($fact == 'n') { echo 'selected';}?>><?php echo $lang_non ?></option>
                    <option value="y" <?php if ($fact == 'y') { echo 'selected';}?>><?php echo $lang_oui ?></option>
                    <option value="r" <?php if ($fact == 'r') { echo 'selected';}?>><?php echo $lang_restrint ?></option>
                </select>
                </div>
            </td>
        </tr>
            
        <tr>
            <td class='right'>Peut g&eacute;rer les achats ?</td>
            <td class='left'>
            	<div class="styled-select-inline" style="width:40%">
                <select name="dep" class="styled-inline">
                    <option value="n" <?php if ($dep == 'n') { echo 'selected';}?>><?php echo $lang_non ?></option>
                    <option value="y" <?php if ($dep == 'y') { echo 'selected';}?>><?php echo $lang_oui ?></option>
                </select>
                </div>
            </td>
        </tr> 
        <tr>
            <td class='right'><?php echo $lang_ger_art ?></td>
            <td class='left'>
            	<div class="styled-select-inline" style="width:40%">
                <select name="art" class="styled-inline">
                    <option value="n" <?php if ($art == 'n') { echo 'selected';}?>><?php echo $lang_non ?></option>
                    <option value="y" <?php if ($art == 'y') { echo 'selected';}?>><?php echo $lang_oui ?></option>
                </select>
                </div>
            </td>
        </tr> 
        <tr>
            <td class='right'><?php echo $lang_ger_cli ?></td>
            <td class='left'>
            	<div class="styled-select-inline" style="width:40%">
                <select name="cli" class="styled-inline">
                    <option value="n" <?php if ($cli == 'n') { echo 'selected';}?>><?php echo $lang_non ?></option>
                    <option value="y" <?php if ($cli == 'y') { echo 'selected';}?>><?php echo $lang_oui ?></option>
                </select>
                </div>
            </td>
        </tr>
        <tr>
            <td class='right'><?php echo $lang_ger_stat ?></td>
            <td class='left'>
            	<div class="styled-select-inline" style="width:40%">
                <select name="stat" class="styled-inline">
                    <option value="n" <?php if ($stat == 'n') { echo 'selected';}?>><?php echo $lang_non ?></option>
                    <option value="y" <?php if ($stat == 'y') { echo 'selected';}?>><?php echo $lang_oui ?></option>
                </select>
                </div>
            </td>
        </tr>
        <tr>
            <td class='right'><i class="fa fa-info-circle fa-fw info_small"><span><i class="fa fa-info-circle fa-fw"></i> <?php echo $lang_admi_modu ?></span></i><?php echo $lang_dr_admi ?> ?</td>
            <td class='left'>
            	<div class="styled-select-inline" style="width:40%">
                <select name="admin" class="styled-inline">
                    <option value="n" <?php if ($admin == 'n') { echo 'selected';}?>><?php echo $lang_non ?></option>
                    <option value="y" <?php if ($admin == 'y') { echo 'selected';}?>><?php echo $lang_oui ?></option>
                </select>
                </div>
            </td>
        </tr>
    </table>
    <div class="center">
        <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-check"></i><span>Valider</span></button>
        <button class="button_act button--shikoba button--border-thin medium" type="reset"><i class="button__icon fa fa-eraser"></i><span>Effacer</span></button>
    </div>
    <input type="hidden" name="num_user" value="<?php echo $num_utilisateur ?>" /> 
</form>
	</div>
</div>
<?php 
/* GESTION CLIENTS RESTREINTS
if ($fact == $lang_restrint || $com == $lang_restrint || $dev == $lang_restrint ) { 
	include_once("edit_choix_cli.php");
	require_once("lister_clients_restreint.php");
}*/
?> 
<?php
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>