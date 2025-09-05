<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script type="text/javascript" src="include/js/showinfoticket.js"></script> 
<script>
$(document).ready(function() {
	$("#show_recap").hide();
	$("#hide_recap").click(function(){
		$("#recap").hide(500);	
		$("#hide_recap").hide();
		$("#show_recap").show();
	});
	$("#show_recap").click(function(){
		$("#recap").show(500);	
		$("#hide_recap").show();
		$("#show_recap").hide();
	});
	$("#show_list").hide();
	$("#hide_list").click(function(){
		$("#list").hide(500);	
		$("#hide_list").hide();
		$("#show_list").show();
	});
	$("#show_list").click(function(){
		$("#list").show(500);	
		$("#hide_list").show();
		$("#show_list").hide();
	});
	$("#hide_file").hide();
	$("#hide_file").click(function(){
		$("#file").hide(500);	
		$("#hide_file").hide();
		$("#show_file").show();
	});
	$("#show_file").click(function(){
		$("#file").show(500);	
		$("#hide_file").show();
		$("#show_file").hide();
	});
	$("#hide_action").hide();
	$("#hide_action").click(function(){
		$("#action").hide(500);	
		$("#hide_action").hide();
		$("#show_action").show();
	});
	$("#show_action").click(function(){
		$("#action").show(500);	
		$("#hide_action").show();
		$("#show_action").hide();
	});
});
<!-- DT LISTE FICHIERS LIES -->
$(document).ready(function() {
    $('#filing').DataTable( {
		"language": {
			"lengthMenu": 'Afficher <div class="styled-select-dt"><select class="styled-dt">'+
						'<option value="10">10</option>'+
						'<option value="20">20</option>'+
						'<option value="30">30</option>'+
						'<option value="40">40</option>'+
						'<option value="50">50</option>'+
						'<option value="100">100</option>'+
						'<option value="-1">All</option>'+
						'</select></div> lignes'
		},
		"pageLength" : 10,
  	});
});
<!-- DT LISTE TACHES LIES -->
$(document).ready(function() {
    $('#listing').DataTable( {
		"language": {
			"lengthMenu": 'Afficher <div class="styled-select-dt"><select class="styled-dt">'+
						'<option value="10">10</option>'+
						'<option value="20">20</option>'+
						'<option value="30">30</option>'+
						'<option value="40">40</option>'+
						'<option value="50">50</option>'+
						'<option value="100">100</option>'+
						'<option value="-1">All</option>'+
						'</select></div> lignes'
		},
		"pageLength" : 10,
  	});
});
<!--JEDITABLE-->
$(document).ready( function () {
	$('.edit_name').editable('./include/ajax/Edit_ticket.php?rowid=<?php echo $num_ticket; ?>', {
	 tooltip   : 'Cliquez pour modifier...'
	});	
	$('.edit_date').editable('./include/ajax/Edit_ticket.php?rowid=<?php echo $num_ticket; ?>&current=<?php echo $num_user; ?>', {
	 tooltip   : 'Cliquez pour modifier...',
	});
	$('.edit_note').editable('./include/ajax/Edit_ticket.php?rowid=<?php echo $num_ticket; ?>', {
	 tooltip   : 'Cliquez pour modifier...',
	});
	<?php 
	if ($user == 'alex' || $user == 'christophe') { 
	?>
			$('.edit_user').editable('./include/ajax/Edit_ticket.php?rowid=<?php echo $num_ticket; ?>', {
			<?php
				
				$sql0 = "SELECT num, login";
				$sql0 .= " FROM ".$tblpref."user";
				$resql0=mysql_query($sql0);
				echo 'data: "{';
				$num0 = mysql_num_rows($resql0);
				$i0 = 0;
				while ($i0 < $num0)
				{
					$obj0 = mysql_fetch_object($resql0);						
					if ($obj0)
					{
						echo "'".$obj0->num."':'".ucfirst($obj0->login)."'";
					}	
					$i0++;
					if ($i0 < $num0) 
					{ 
						echo ",";
					}
				}
				echo '}",';
			?>
			 type   : 'select',
			 tooltip   : 'Cliquez pour modifier...',
			 submit : 'Modifier'
			});
	<?php
	}
	?>
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
if ($_REQUEST['upload'] == 'ok') {
	$message = "Votre fichier &agrave; &eacute;t&eacute; upload&eacute; avec succ&egrave;s";
}
include_once("include/message_info.php");
//Récupération des variables, requête infos ticket
$num_ticket = addslashes($_REQUEST['num_ticket']);
$sql_ticket ="SELECT t.name as tname, t.user_in_charge as tuser_in_charge, t.soc as tsoc, t.date_due as tdate_due, t.note as tnote, t.user_creator as tuser_creator, t.date_creation as tdate_creation, t.state as tstate, u.login as responsable, u2.login as creator, c.nom as cnom, t.rowid as trowid, t.name_contact as name_contact, t.firstname_contact as firstname_contact, t.tel_contact as tel_contact, t.mail_contact as mail_contact, t.soc as tsoc, t.fact_num tfactnum, t.facture as tfacture";
$sql_ticket.=" FROM ".$tblpref."ticket as t";
$sql_ticket.=" LEFT JOIN ".$tblpref."user as u ON u.num = t.user_in_charge";
$sql_ticket.=" LEFT JOIN ".$tblpref."user as u2 ON u2.num = t.user_creator";
$sql_ticket.=" LEFT JOIN ".$tblpref."client as c ON c.num_client = t.soc";
$sql_ticket.=" WHERE rowid=".$num_ticket."";
$req_ticket=mysql_query($sql_ticket);
$results_ticket=mysql_fetch_object($req_ticket);
$state_ticket=$results_ticket->tstate;
$num_client=$results_ticket->tsoc;
//On vérifie si toutes les tâches sont cloturées
$sql_verif="SELECT state";
$sql_verif.=" FROM ".$tblpref."task";
$sql_verif.=" WHERE ticket_num='".$num_ticket."'";
$req_verif=mysql_query($sql_verif);
while ($results_verif=mysql_fetch_object($req_verif)) {
	$state=$results_verif->state;
	if ($state == '0') {
		//VARIABLE SERVANT POUR L'AFFICHAGE DES DIFFERENTES ACTIONS
		$state_tasks='0';
	}
}
?>
<?php
if ($state_ticket == 0) {
?>
<!--Modale Ajout Task-->
<div id="overlay3">
    <div class="popup_block">
        <a class="close" href="#noWhere">
        	<span class="fa-stack fa-lg fa-2x btn_close del">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-times fa-stack-1x fa-inverse"></i>
            </span>
      	</a>
        <div id="content_modale">
        	<form action="include/form/add_task_from_ticket.php" method="POST">
                <h1 class="modal">Ajouter une t&acirc;che</h1>
                <table class="base" width="100%">
                	<tr>
                    	<td class="right" width="50%">Description/Nom T&acirc;che :</td>
                        <td class="left" width="50%"><input type="text" size="25" id="name_task" name="name_task" class="styled" style="width:60%"></td>
                    </tr>
                    <tr>
                    	<td class="right">Type de T&acirc;che :</td>
                        <td class="left">
                        	<div class="styled-select-inline" style="width:60%">
                        	<select name="type_task" id="type_task" class="styled-inline">
								<?php
                                    $sql1 = "SELECT rowid, type";
                                    $sql1 .= " FROM ".$tblpref."type_task";
                                    $resql=mysql_query($sql1);
                                    while ($obj = mysql_fetch_object($resql))
                                    {					
                                            echo '<option value="'.$obj->rowid.'">'.$obj->type.'</option>';
                    
                                    }
                                ?>
                            </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                    	<td class="right">D&eacute;placement :</td>
                        <td class="left">
                        	<div class="styled-select-inline" style="width:60%">
                        	<select name="deplacement" id="deplacement" class="styled-inline">
                                <option value="0" selected>Aucun</option>
                                <option value="1">- 20km</option>
                                <option value="2">20 - 40km</option>
                                <option value="3">40+ km</option>
                            </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                    	<td class="right">Tarif Sp&eacute;cial :</td>
                        <td class="left">
                        	<div class="styled-select-inline" style="width:60%">
                        	<select name="tarif_special" id="tarif_special" class="styled-inline">
                                <option value="1" selected>Non</option>
                                <option value="2">19h+</option>
                                <option value="3">Dimanche / F&eacute;ri&eacute; / 22h+</option>
                                <option value="4">Tarif r&eacute;duit</option>
                            </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                    	<td class="right">Intervenant :</td>
                        <td class="left">
                        	<div class="styled-select-inline" style="width:60%">
                        	<select name="user_task" id="user_task" class="styled-inline">
								<?php
                                $sql1 = "SELECT login, num";
                                $sql1 .= " FROM ".$tblpref."user";
                                $resql=mysql_query($sql1);
                                while ($obj = mysql_fetch_object($resql)) {
									if ($num_user == $obj->num) {
										echo '<option value="'.$obj->num.'" selected>'.$obj->login.'</option>';
									}
									else {
                                    	echo '<option value="'.$obj->num.'">'.$obj->login.'</option>';
									}
                                }
                                ?>
                    		</select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                    	<td class="right">Date d'&eacute;ch&eacute;ance :</td>
                        <td class="left">
                        	<input type="text" size="9" id="date_due_task" name="date_due_task" value="<?php echo date('d-m-Y', strtotime("+ 1 day"));?>" class="styled datepicker" style="width:30%"> 
                            &agrave; <input type="text" id="hour_due_task" name="hour_due_task" value="<?php echo date('H');?>" class="styled" style="width:10%"/>
                            &nbsp;:  <input type="text" id="min_due_task" name="min_due_task" value="<?php echo date('i');?>" class="styled" style="width:10%"/>
                        </td>
                    </tr>
                    <tr>
                    	<td class="right">&Eacute;tat de la t&acirc;chel :</td>
                        <td class="left">
                        	<div class="styled-select-inline" style="width:60%">
                        	<select name="state_task" id="state_task" onKeyup="check_state()" onChange="check_state()" onFocus="check_state()" class="styled-inline">
                                <option value="0">Ouverte</option>
                                <option value="1">Clotur&eacute;e</option>
                            </select>
                            </div>
                        </td>
                    </tr>
                    <tbody id="worktime_place">
                    </tbody>
                </table>
                <div class="center">
                    <button class="button_act button--shikoba button--border-thin medium" type="submit">
                        <i class="button__icon fa fa-plus"></i><span>Ajouter la t&acirc;che</span>
                    </button>
                </div>
                <input type="hidden" name="user_creator" id="user_creator" value="<?php echo $num_user;?>">
                <input type="hidden" name="num_ticket" id="num_ticket" value="<?php echo $num_ticket;?>">
            </form>
        </div>
    </div>
</div>
<?php
}
?>
<!--Modale Upload-->
<div id="overlay4">
    <div class="popup_block">
        <a class="close" href="#noWhere">
        	<span class="fa-stack fa-lg fa-2x btn_close del">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-times fa-stack-1x fa-inverse"></i>
            </span>
      	</a>
        <div id="content_modale">
        	<h1 class="modal">Ajouter un fichier</h1>
            <form method="POST" action="upload.php" enctype="multipart/form-data" class="add_files">
                <input type="hidden" name="MAX_FILE_SIZE" value="100000000">
                <table class="base" width="100%">
                    <tr>
                        <td class="right" width="50%">Fichier :</td>
                        <td class="left" width="50%"><input type="file" name="doc"></td>
                    </tr>
                    <tr>
                        <td class="right" width="50%">Nom/Description du Fichier :</td>
                        <td class="left" width="50%"><input type="text" id="name" name="name" class="styled"></td>
                    </tr>
                </table>
                <div class="center">
                    <button class="button_act button--shikoba button--border-thin medium" type="submit">
                        <i class="button__icon fa fa-plus"></i><span>Ajouter le fichier</span>
                    </button>
                </div>
                <input type="hidden" name="num_ticket" id="num_ticket" value="<?php echo $num_ticket;?>">
                <input type="hidden" name="user" id="user" value="<?php echo $num_user;?>">
            </form>
        </div>
    </div>
</div>
<!--FILES-->
<div class="portion">
    <!-- TITRE - FILES -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-file-pdf-o fa-stack-1x"></i>
        </span>
        Documents du ticket
        <span class="fa-stack fa-lg add" style="float:right" id="show_action">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_action">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - FILES -->
    <div class="content_traitement disp_none" id="action">
        <!--IMPRESSION FICHE INTER-->
        <div class="three_action">
            <div>
            <span class="fa-stack fa-lg fa-2x">
              <i class="fa fa-circle-thin fa-stack-2x"></i>
              <i class="fa fa-bug fa-stack-1x"></i>
            </span>
            </div>
            <a href="./fpdf_fiche_inter.php?inter=<?php echo $num_ticket;?>" class="no_effect" target="_blank"> 
            	<button class="button_act button--shikoba button--border-thin" type="button">
                    <i class="button__icon fa fa-print"></i><span>Imprimer la fiche d'intervention</span>
                </button>
            </a>
        </div>
        <!--RAPPORT D'INTERVENTION-->
        <div class="three_action">
        	<div>
            <span class="fa-stack fa-lg fa-2x">
              <i class="fa fa-circle-thin fa-stack-2x"></i>
              <i class="fa fa-newspaper-o fa-stack-1x"></i>
            </span>
            </div>
			<?php
            if ($state_tasks == '0') { //Si le ticket est OPEN on affiche le bouton "Cloturer ticket" grisé
				?>
                <button class="button_act button--border-thin info" type="button" style="color:#95a5a6;border-color:#95a5a6">
                        Imprimer le rapport d'intervention
                        <!-- Texte de l'info bulle, classe du parent "info" --->
                    <span><i class="fa fa-info-circle fa-fw"></i> Vous devez d'abord cl&ocirc;turer le ticket avant de pouvoir imprimer le rapoort d'intervention.</span>
                </button>
                <button class="button_act button--border-thin info" type="button" style="color:#95a5a6;border-color:#95a5a6">
                    Envoyer le rapport d'intervention
                    <!-- Texte de l'info bulle, classe du parent "info" --->
                    <span class="medium"><i class="fa fa-info-circle fa-fw"></i> Vous devez d'abord cl&ocirc;turer le ticket avant de pouvoir envoyer le rapoort d'intervention.</span>
                </button>
                <?php
            }
            else {
                if ($state_ticket == 1) { //Si le ticket est cloturé, on affiche permet d'imprimer/envoyer le rapport
					?>
                    <a href="./fpdf_rapports_inter.php?inter=<?php echo $num_ticket;?>" class="no_effect" target="_blank">
                        <button class="button_act button--shikoba button--border-thin" type="button">
                            <i class="button__icon fa fa-print"></i><span>Imprimer le rapport d'intervention</span>
                        </button>
                    </a>
                    <a href="javascript:if(confirm('Envoyer le rapport au client ?')) document.location.href='./fpdf_rapports_inter_sent_to_client.php?inter=<?php echo $num_ticket;?>'" class="no_effect">
                        <button class="button_act button--shikoba button--border-thin" type="button">
                            <i class="button__icon fa fa-paper-plane-o"></i><span> Envoyer le rapport d'intervention</span>
                        </button>
                    </a>
                    <?php
                } 
                
                else { //Sinon on affiche le bouton "CLOSE TICKET"
					?>
                    <button class="button_act button--border-thin info" type="button" style="color:#95a5a6;border-color:#95a5a6">
                        Imprimer le rapport d'intervention
                        <!-- Texte de l'info bulle, classe du parent "info" --->
                        <span><i class="fa fa-info-circle fa-fw"></i> Vous devez d'abord cl&ocirc;turer le ticket avant de pouvoir imprimer le rapoort d'intervention.</span>
                    </button>
                    <button class="button_act button--border-thin info" type="button" style="color:#95a5a6;border-color:#95a5a6">
                        Envoyer le rapport d'intervention
                        <!-- Texte de l'info bulle, classe du parent "info" --->
                        <span><i class="fa fa-info-circle fa-fw"></i> Vous devez d'abord cl&ocirc;turer le ticket avant de pouvoir envoyer le rapoort d'intervention.</span>
                    </button>
                    <?php
                } 
            }
            ?>
        </div>
    </div>
</div>
<!--RECAP-->
<div class="portion">
    <!-- TITRE - RECAP -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
        R&eacute;capitulatif du ticket : "<?php echo stripslashes($results_ticket->tname); ?>"
        <span class="fa-stack fa-lg add" style="float:right" id="show_recap">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_recap">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - RECAP -->
    <div class="content_traitement" id="recap">
    	<div class="portion_subtitle"><i class="fa fa-ticket fa-fw"></i> Le ticket</div>
        <table class="base" width="100%">
        <tr>
        	<td class="right" width="25%">Nom du Ticket :</td>				
            <td class="edit_name left" id="name" width="25%"><?php echo ucfirst(stripslashes($results_ticket->tname)); ?></td>	
            <td class="right" width="25%">Client :</td>		
            <td class="left" width="25%"><?php echo ucfirst($results_ticket->cnom); ?></td>
        </tr>
        <tr>
        	<td class="right">Date Due :</td>					
            <td class="edit_date left" id="date_due"><?php echo $results_ticket->tdate_due; ?></td>	
            <td class="right">Responsable :</td>	
            <td class="edit_user left" id="user"><?php echo ucfirst($results_ticket->responsable); ?></td>
        </tr>
        <tr>
        	<td class="right">Note :</td>		
            <td class="edit_note left" id="note" colspan="3"><?php echo stripslashes($results_ticket->tnote); ?></td>
        </tr>
        <tr>
        	<td  class="intitule right">Date de cr&eacute;ation</td>	
            <td class="left"><?php echo $results_ticket->tdate_creation; ?></td>		
            <td  class="intitule right">Cr&eacute;ateur</td>	
            <td class="left"><?php echo ucfirst($results_ticket->creator); ?></td>
        </tr>
        </table>
        <div class="portion_subtitle"><i class="fa fa-user fa-fw"></i> Le contact</div>
        <table class="base" width="100%">
        <?php
		// Si des infos sont définies, on les affiches
        if ($results_ticket->name_contact != '' || $results_ticket->firstname_contact != '' || $results_ticket->tel_contact != '' || $results_ticket->mail_contact != '') { 
            ?>
            <tr>
            	<td class="intitule right" width="25%">Nom :</td>		
                <td class="left" width="25%"><?php echo $results_ticket->name_contact; ?></td>
            	<td class="intitule right" width="25%">Pr&eacute;nom :</td>	
                <td class="left" width="25%"><?php echo $results_ticket->firstname_contact; ?></td>
            </tr>
            <tr>
            	<td class="intitule right">T&eacute;l&eacute;phone :</td>		
                <td class="left"><?php echo $results_ticket->tel_contact; ?></td>
            	<td class="intitule right">E-mail :</td>		
                <td class="left"><?php echo $results_ticket->mail_contact; ?></td>
            </tr>
        <?php    
        }
        else { //Sinon on va les chercher dans la table client
            //Requête de récupération des infos client
            $sql_cli =" SELECT nom, nom2, tel, gsm, mail as email";
            $sql_cli.=" FROM ".$tblpref."client";
            $sql_cli.=" WHERE num_client=".$num_client."";
            $req_cli=mysql_query($sql_cli);
            $results_cli=mysql_fetch_object($req_cli);
        ?>
            <tr>
            	<td class="intitule right" width="25%">Nom :</td>		
                <td class="left" width="25%"><?php echo $results_cli->nom; ?></td>
            	<td class="intitule right" width="25%">Alias :</td>		
                <td class="left" width="25%"><?php echo $results_cli->nom2; ?></td>
            </tr>
            <tr>
            	<td class="intitule right">T&eacute;l&eacute;phone :</td>		
                <td class="left"><?php echo $results_cli->tel; ?></td>
            	<td class="intitule right">E-mail :</td>		
                <td class="left"><?php echo $results_cli->email; ?></td>
            </tr>
            <tr>
            	<td class="intitule right">GSM :</td>		
                <td colspan="3" class="left"><?php echo $results_cli->gsm; ?></td>
            </tr>
        <?php 
        }
        ?>
        </table>
        <div class="portion_subtitle"><i class="fa fa-ticket fa-fw"></i> Actions</div>
            <div class="center">
            <!--CLOTURE DU TICKET-->
            <?php
            if ($state_tasks == '0') { //Si le ticket est OPEN on affiche le bouton "Cloturer ticket" grisé
                ?>
                <button class="button_act button--border-thin medium add info" type="button" style="color:#95a5a6;border-color:#95a5a6">
                    Cl&ocirc;turer le ticket
                    <!-- Texte de l'info bulle, classe du parent "info" --->
                    <span><i class="fa fa-info-circle fa-fw"></i> Vous devez d'abord cl&ocirc;turer toutes les t&acirc;ches du ticket avant de pouvoir cl&ocirc;turer le ticket lui-m&ecirc;me.</span>
                </button>
                <?php
            }
            else {
                if ($state_ticket == 1) { //Si le ticket est cloturé, on affiche l'image "Ticket CLOSED" , et les boutons AFFICHER RAPPORT ET ENVOYER RAPPORT
                    ?>
                    <button class="button_act button--border-thin medium add" type="button" style="color:#27ae60;border-color:#27ae60">
                        <i class="fa fa-check"></i> Ticket clotur&eacute;
                    </button>
                    <?php
                } 
                
                else { //Sinon on affiche le bouton "CLOSE TICKET"
                    ?>
                    <a href="./include/ajax/close_ticket.php?num_ticket=<?php echo $num_ticket;?>" class="no_effect">
                        <button class="button_act button--shikoba button--border-thin medium" type="button">
                            <i class="button__icon fa fa-thumbs-o-up"></i><span>Cl&ocirc;turer le ticket</span>
                        </button>
                    </a>
                    <?php
                } 
            }
            ?>
        	<!--FACTURATION-->
            <?php
            if ($state_tasks == '0') { //Si les tâches ne sont pas cloturées, aucune facturation n'est disponible.
                //ON recherche si le client dispose d'un abonnement
				$sql_abo =" SELECT ID, temps_restant";
				$sql_abo.=" FROM ".$tblpref."abos";
				$sql_abo.=" WHERE client=".$num_client." AND actif='oui'";	
				$req_abo=mysql_query($sql_abo);
				if ( $results_abo=mysql_fetch_object($req_abo)) { //Si le client dispo d'un abo prépayé on affiche le bouton déduire de l'abo, grisé
						?>
                        <button class="button_act button--border-thin medium info" type="button" style="color:#95a5a6;border-color:#95a5a6">
                            D&eacute;duire de l'abo
                            <!-- Texte de l'info bulle, classe du parent "info" --->
                            <span><i class="fa fa-info-circle fa-fw"></i> Vous devez d'abord cl&ocirc;turer le ticket avant d'acc&eacute;der aux options de facturation.</span>
                        </button>
                        <?php
				}
				//On place le bouton purge, grisé
				?>
                <button class="button_act button--border-thin medium info" type="button" style="color:#95a5a6;border-color:#95a5a6">
                    Purger
                    <!-- Texte de l'info bulle, classe du parent "info" --->
                    <span><i class="fa fa-info-circle fa-fw"></i> Vous devez d'abord cl&ocirc;turer le ticket avant d'acc&eacute;der aux options de facturation.</span>
                </button>
                <button class="button_act button--border-thin medium info" type="button" style="color:#95a5a6;border-color:#95a5a6">
                    Facturer
                    <!-- Texte de l'info bulle, classe du parent "info" --->
                    <span><i class="fa fa-info-circle fa-fw"></i> Vous devez d'abord cl&ocirc;turer le ticket avant d'acc&eacute;der aux options de facturation.</span>
                </button>
                <?php
            }
            else { //Si les tâche sont cloturées
                if ($state_ticket == 1) { //Si le ticket est lui aussi cloturé, on peut facturer.
                    if ($results_ticket->tfacture != 'ok') { //Si le ticket n'est pas facturé, on affiche les diff option de fact (purge/abo)
                        //ON recherche si le client dispose d'un abonnement
                        $sql_abo =" SELECT ID, temps_restant";
                        $sql_abo.=" FROM ".$tblpref."abos";
                        $sql_abo.=" WHERE client=".$num_client." AND actif='oui'";	
                        $req_abo=mysql_query($sql_abo);
                        if ( $results_abo=mysql_fetch_object($req_abo)) { //Si le client dispo d'un abo prépayé on affiche le bouton déduire de l'abo, si déja déduit
								?>
                                <a href="./include/ajax/gestion_abo.php?num_ticket=<?php echo $num_ticket;?>" class="no_effect">
                                <button class="button_act button--shikoba button--border-thin medium" type="button">
                                    <i class="button__icon fa fa-minus"></i><span>D&eacute;duire de l'abo</span>
                                </button>
                                </a>
                                <?php
                        }
                        //On place le bouton purge et le bouton facturation
						?>
                        <a href="./include/ajax/purge_ticket.php?num_ticket=<?php echo $num_ticket;?>&location=ficheticket" class="no_effect">
                        <button class="button_act button--shikoba button--border-thin medium" type="button">
                            <i class="button__icon fa fa-fire-extinguisher"></i><span>Purger</span>
                        </button>
                        </a>
                        <?php
						$mois = date("m");
						$annee = date("Y");
						$jour = date("d");
						?>
                        <form name="formu" method="post" action="fact.php">
                            <input type="hidden" name="listeville" value="<?php echo $num_client;?>"/>
                            <input type="hidden" name="date_deb" value="<?php echo "1/$mois/$annee" ?>"/>
                            <input type="hidden" name="date_fin" value="<?php echo "$jour/$mois/$annee" ?>"/>
                            <input type="hidden" name="date_fact" value="<?php echo "$jour/$mois/$annee" ?>"/>
                            <button class="button_act button--shikoba button--border-thin medium" type="submit" name="Submit">
                                Facturer
                            </button>
                        </form>
                        <?php
						
                    }
                    //Sinon on affiche l'indicateur de facture correspondant
                    else if ($results_ticket->tfactnum == 'ABONNEMENT') {
						?>
                        <button class="button_act button--border-thin medium info" type="button" style="color:#27ae60;border-color:#27ae60">
                            <i class="fa fa-check"></i> Ticket d&eacute;ja deduit de l\'abonnement
                        </button>
                        <?php
                    }
                    else if ($results_ticket->tfactnum == 'PURGE') {
						?>
                        <button class="button_act button--border-thin medium info" type="button" style="color:#27ae60;border-color:#27ae60">
                            <i class="fa fa-check"></i> Ticket d&eacute;ja purg&eacute;
                        </button>
                        <?php
                    }
                    else {
						?>
                        <button class="button_act button--border-thin medium info" type="button" style="color:#27ae60;border-color:#27ae60">
                            <i class="fa fa-check"></i> Ticket factur&eacute;
                        </button>
                        <?php
                    }
                } 
                else { //Sinon il faut cloturer le ticket d'abord
                    //ON recherche si le client dispose d'un abonnement
					$sql_abo =" SELECT ID, temps_restant";
					$sql_abo.=" FROM ".$tblpref."abos";
					$sql_abo.=" WHERE client=".$num_client." AND actif='oui'";	
					$req_abo=mysql_query($sql_abo);
					if ( $results_abo=mysql_fetch_object($req_abo)) { //Si le client dispo d'un abo prépayé on affiche le bouton déduire de l'abo, grisé
							?>
							<button class="button_act button--border-thin medium info" type="button" style="color:#95a5a6;border-color:#95a5a6">
								D&eacute;duire de l'abo
								<!-- Texte de l'info bulle, classe du parent "info" --->
								<span><i class="fa fa-info-circle fa-fw"></i> Vous devez d'abord cl&ocirc;turer le ticket avant d'acc&eacute;der aux options de facturation.</span>
							</button>
							<?php
					}
					//On place le bouton purge, grisé
					?>
					<button class="button_act button--border-thin medium info" type="button" style="color:#95a5a6;border-color:#95a5a6">
						Purger
						<!-- Texte de l'info bulle, classe du parent "info" --->
						<span><i class="fa fa-info-circle fa-fw"></i> Vous devez d'abord cl&ocirc;turer le ticket avant d'acc&eacute;der aux options de facturation.</span>
					</button>
                    <button class="button_act button--border-thin medium info" type="button" style="color:#95a5a6;border-color:#95a5a6">
                        Facturer
                        <!-- Texte de l'info bulle, classe du parent "info" --->
                        <span><i class="fa fa-info-circle fa-fw"></i> Vous devez d'abord cl&ocirc;turer le ticket avant d'acc&eacute;der aux options de facturation.</span>
                    </button>
					<?php
                } 
            }
            ?>
        </div>
	</div>
</div>
<?php
$sql_files="SELECT name, path, date_upload";
$sql_files.=" FROM ".$tblpref."files as f";
$sql_files.=" WHERE ticket=".$num_ticket."";
$req_files=mysql_query($sql_files);
$num_files=mysql_num_rows($req_files);
?>
<!--FILES-->
<div class="portion">
    <!-- TITRE - FILES -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-file fa-stack-1x"></i>
        </span>
        Fichiers li&eacute;s au ticket (<?php echo $num_files;?>)
        <span class="fa-stack fa-lg add" style="float:right" id="show_file">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_file">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
        <a href="#overlay4" class="no_effect">
        <span class="fa-stack fa-lg action" style="float:right" title="Ajouter un fichier">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-plus fa-stack-1x"></i>
        </span>
        </a>
    </div>
    <!-- CONTENT - FILES -->
    <div class="content_traitement disp_none" id="file">
        <table class="base" width="100%" id="filing">
            <thead>
            <tr>
                <th>Nom</th>	
                <th>Date Upload</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
			//Requête de récupération des fichiers liés au ticket
			$sql_files="SELECT name, path, date_upload";
			$sql_files.=" FROM ".$tblpref."files as f";
			$sql_files.=" WHERE ticket=".$num_ticket."";
			$req_files=mysql_query($sql_files);
			$num_files=mysql_num_rows($req_files);
            while ($results_files=mysql_fetch_object($req_files)) {
                ?>
                <tr>
                    <td><?php echo $results_files->name;?></td>
                    <td><?php echo $results_files->date_upload;?></td>
                    <td>
                        <a href="./<?php echo $results_files->path;?>" target="_blank" class="no_effect">
                            <i class="fa fa-play-circle-o fa-fw fa-2x action"></i>
                        </a>
                        <a href="#" class="no_effect">
                            <i class="fa fa-trash fa-fw fa-2x del"></i>
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
        <!-- AJOUT FICHIER -->
        <div class="center">
        	<a href="#overlay4" class="">
            <button class="button_act button--shikoba button--border-thin" type="button">
                <i class="button__icon fa fa-plus"></i><span> Ajouter un fichier</span>
            </button>
            </a>
       	</div>
    </div>
</div>
<!--LISTE-->
<div class="portion">
    <!-- TITRE - LISTE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        Liste des T&acirc;ches li&eacute;es au ticket
        <span class="fa-stack fa-lg add" style="float:right" id="show_list">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_list">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
        <a href="#overlay3" class="no_effect">
        <span class="fa-stack fa-lg add" style="float:right" title="Ajouter une t&acirc;che">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-plus fa-stack-1x"></i>
        </span>
        </a>
    </div>
    <!-- CONTENT - LISTE -->
    <div class="content_traitement" id="list">
        <table class="base" width="100%" id="listing">
            <thead>
                <tr>
                    <th>Num.</th>
                    <th>Nom de la t&acirc;che</th>
                    <th>Client</th>
                    <th>Date Due</th>
                    <th>Intervenant</th>
                    <th>Date Cr&eacute;ation</th>
                    <th>Etat (TimeSpent)</th>                        
                </tr>
            </thead>
            <tbody>
            <?php
            // On récupère les hébergements actifs
            $sql = "SELECT t.name as tname, ti.name as tiname, t.date_due tdate_due, t.state tstate, t.date_creation tdate_creation, u.login ulogin, c.nom cnom, t.rowid as trowid, t.time_spent as ttime_spent, ti.rowid as tirowid";
            $sql .= " FROM ".$tblpref."task as t";
            $sql .= " LEFT JOIN ".$tblpref."ticket as ti ON ti.rowid=t.ticket_num";
            $sql .= " LEFT JOIN ".$tblpref."client as c ON c.num_client=ti.soc";	
            $sql .= " LEFT JOIN ".$tblpref."user as u ON u.num=t.user_intervenant";
            $sql .= " WHERE ti.rowid=".$num_ticket."";
            $sql .= " ORDER by t.date_due ASC";
            
            $resql=mysql_query($sql);
            while ($obj = mysql_fetch_object($resql)) {
                // You can use here results
                //Transformation d'etat en mots
                if ($obj->tstate == 0) {
                    $etat='Open';
                }
                else {
                    $etat='Close';
                }
                //Transformation du Timespent pour n'afficher que HH:mm
                $timeinter=explode(':',$obj->ttime_spent);
                $hours=$timeinter[0];
                $min=$timeinter[1];
                $timefinal=$hours.':'.$min;
                //Convertion des dates au format mysql
                $dateduetemp = explode(' ',$obj->tdate_due);
                $date = $dateduetemp[0];
                $datetemp = explode('-',$date);
                $heure = $dateduetemp[1];
                $jour = $datetemp[0];
                $mois = $datetemp[1];
                $annee = $datetemp[2];
                $date_due_ticket_correct=$annee."-".$mois."-".$jour;
                $date_due_ticket_final=$date_due_ticket_correct.' '.$heure;
                //Affichage
                echo '<tr>';
                print '<td align="">'.$obj->tirowid.'-'.$obj->trowid.'</td>';
                print '<td align=""><a class="styled" href="./task.php?num_task='.$obj->trowid.'">'.stripslashes($obj->tname).'</a></td>';
                print '<td align="">'.stripslashes(ucfirst($obj->cnom)).'</td>';
                print '<td align="">'.$date_due_ticket_final.'</td>';
                print '<td align="">'.ucfirst($obj->ulogin).'</td>';
                print '<td align="">'.$obj->tdate_creation.'</td>';
                print '<td align="">';
                if ($etat=='Close') {
                    print $etat.' ('.$timefinal.')';
                }
                else {
                    print $etat;
                }
                print '</td>';
                echo '</tr>';	
            }
            ?>
            </tbody>
        </table>
        <!-- AJOUT TACHE -->
        <div class="center">
			<?php
            if ($state_ticket == 0) {
            ?>
            	<a href="#overlay3" class="">
                <button class="button_act button--shikoba button--border-thin" type="button">
                    <i class="button__icon fa fa-plus"></i><span> Nouvelle t&acirc;che</span>
                </button>
                </a>
            <?php
            }
			else {
				?>
                <button class="button_act button--border-thin info" type="button" style="color:#95a5a6;border-color:#95a5a6">
                    Nouvelle t&acirc;che
                    <!-- Texte de l'info bulle, classe du parent "info" --->
                    <span class="medium"><i class="fa fa-info-circle fa-fw"></i> Le ticket est cl&ocirc;s. Il est impossible d'y ajouter de nouvelle t&acirc;ches.</span>
                </button>
                <?php
			}
            ?>
        </div>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>

