<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
//On récupère l'id de la task (nécessaire pr déclaration Jquery
$num_task = addslashes($_REQUEST['num_task']);
//Request recup des infos ticket
$sql_task ="SELECT t.name as tname, c.nom as cnom, t.date_due as tdate_due, t.tarif_special as ttarif_special, t.deplacement as tdeplacement, ti.name as tiname, t.date_creation as tdate_creation, u.login as ulogin, u2.login as u2login, t.ticket_num as tnumticket, t.state as tstate, t.time_start as time_start, t.time_stop as time_stop, t.time_spent as ttime_spent, tt.type as tttype, t.time_spent_set_manual as tset_manual, ti.note as tinote, ti.rowid as tirowid, ti.soc as tsoc";
$sql_task.=" FROM ".$tblpref."task as t";
$sql_task.=" LEFT JOIN ".$tblpref."user as u ON u.num = t.user_intervenant";
$sql_task.=" LEFT JOIN ".$tblpref."user as u2 ON u2.num = t.user_creator";
$sql_task.=" LEFT JOIN ".$tblpref."ticket as ti ON ti.rowid = t.ticket_num";
$sql_task.=" LEFT JOIN ".$tblpref."client as c ON c.num_client = ti.soc";
$sql_task.=" LEFT JOIN ".$tblpref."type_task as tt ON tt.rowid = t.type";
$sql_task.=" WHERE t.rowid=".$num_task."";
$req_task=mysql_query($sql_task);
$results_task=mysql_fetch_object($req_task);
$state_task=$results_task->tstate;
$time_start=$results_task->time_start;
$time_stop=$results_task->time_stop;
$time_spent=$results_task->ttime_spent;
$set_manual=$results_task->tset_manual;
$num_ticket=$results_task->tirowid;
$client_id=$results_task->tsoc;
//Correspondance des tarifs
if ($results_task->ttarif_special == 1) {
	$tarif='Non';
}
else if ($results_task->ttarif_special == 2) {
	$tarif='19h+';
}
else if ($results_task->ttarif_special == 3) {
	$tarif='Dimanche / F&eacute;ri&eacute; / 22h+';
}
else if ($results_task->ttarif_special == 4) {
	$tarif='Tarif r&eacute;duit';
}
//Correspondance des déplacements
if ($results_task->tdeplacement == 0) {
	$deplacement='Aucun';
}
else if ($results_task->tdeplacement == 1) {
	$deplacement='- 20km';
}
else if ($results_task->tdeplacement == 2) {
	$deplacement='20 - 40km';
}
else if ($results_task->tdeplacement == 3) {
	$deplacement='40+ km';
}
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<style type="text/css" media="screen">

</style>
<script type="text/javascript" src="include/js/task.js"></script>
<script>
<!--SHOW/HIDE-->
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
	$("#show_time").hide();
	$("#hide_time").click(function(){
		$("#time").hide(500);	
		$("#hide_time").hide();
		$("#show_time").show();
	});
	$("#show_time").click(function(){
		$("#time").show(500);	
		$("#hide_time").show();
		$("#show_time").hide();
	});
	$("#show_article").hide();
	$("#hide_article").click(function(){
		$("#article").hide(500);	
		$("#hide_article").hide();
		$("#show_article").show();
	});
	$("#show_article").click(function(){
		$("#article").show(500);	
		$("#hide_article").show();
		$("#show_article").hide();
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
});
$(function() {
	$( "#date_new" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd/mm/yy" })
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
<!-- DT LISTE MATOS -->
$(document).ready(function() {
    $('#materieling').DataTable( {
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
<!-- JEDIT -->
$(document).ready(function() {
	 $('.edit_note').editable('./include/ajax/Edit_ticket.php?rowid=<?php echo $num_ticket; ?>', {
	 	 tooltip   : 'Cliquez pour modifier...',
	 });
     $('.edit_name').editable('./include/ajax/Edit_task.php?rowid=<?php echo $num_task; ?>', {
		 tooltip   : 'Cliquez pour modifier...'
	 });	
	 $('.edit_date').editable('./include/ajax/Edit_task.php?rowid=<?php echo $num_task; ?>&current=<?php echo $num_user; ?>', {
		 tooltip   : 'Cliquez pour modifier...',
		 type : 'datepicker'
	 });
	 $('.edit_deplacement').editable('./include/ajax/Edit_task.php?rowid=<?php echo $num_task; ?>', {
		 data   : " {'0':'Aucun','1':'- 20km','2':'20 - 40km', '3':'+ 40km'}",
		 type   : 'select',
		 tooltip   : 'Cliquez pour modifier...',
		 submit : 'Modifier'
     });
	 $('.edit_type').editable('./include/ajax/Edit_task.php?rowid=<?php echo $num_task; ?>', {
		<?php
			
			$sql0 = "SELECT rowid, type";
			$sql0 .= " FROM ".$tblpref."type_task";
			$resql0=mysql_query($sql0);
			echo 'data: "{';
			$num0 = mysql_num_rows($resql0);
			$i0 = 0;
			while ($i0 < $num0)
			{
				$obj0 = mysql_fetch_object($resql0);						
				if ($obj0)
				{
					echo "'".$obj0->rowid."':'".ucfirst($obj0->type)."'";
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
	  $('.edit_tarif').editable('./include/ajax/Edit_task.php?rowid=<?php echo $num_task; ?>', {
		 data   : " {'1':'Non','2':'19h+','3':'Dimanche / F&eacute;ri&eacute; / 22h+', '4':'Tarif r&eacute;duit'}",
		 type   : 'select',
		 tooltip   : 'Cliquez pour modifier...',
		 submit : 'Modifier'
	  });
	  <?php
	  if ($state_task == 0) {
	  ?>
		  $('.edit_timespent').editable('./include/ajax/Edit_task.php?rowid=<?php echo $num_task; ?>', {					  
		  });
	  <?php 
	  }
	  if ($user == 'alex' || $user == 'christophe') { 
	  ?>
		$('.edit_user').editable('./include/ajax/Edit_task.php?rowid=<?php echo $num_task; ?>', {
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
                        <td class="left" width="50%">
                        	<div class="input-file-container">
                              <input class="input-file" id="my-file" type="file" name="doc">
                              <label for="my-file" class="input-file-trigger" tabindex="0"><i class="fa fa-file fa-fw"></i>&nbsp;&nbsp;S&eacute;lectionner un fichier ...</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                    	<td class="right" width="50%">&nbsp;</td>
                        <td class="left" width="50%">
                            <p class="file-return"></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="right" width="50%">
                        <i class="fa fa-info-circle fa-fw info_small"><span><i class="fa fa-info-circle fa-fw"></i> Si aucun nom n'est pr&eacute;cis&eacute; le nom du fichier sera utilis&eacute;</span></i>
                        Nom/Description du Fichier :
                        </td>
                        <td class="left" width="50%">
                        	<input type="text" id="name" name="name" class="styled">
                        </td>
                    </tr>
                </table>
                <div class="center">
                    <button class="button_act button--shikoba button--border-thin medium" type="submit">
                        <i class="button__icon fa fa-plus"></i><span>Ajouter le fichier</span>
                    </button>
                </div>
                <input type="hidden" name="num_ticket" id="num_ticket" value="<?php echo $results_task->tnumticket;?>">
                <input type="hidden" name="user" id="user" value="<?php echo $num_user;?>">
                <input type="hidden" name="num_task" id="num_task" value="<?php echo $num_task;?>">
            </form>
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
        R&eacute;capitulatif de la T&acirc;che : "<?php echo $results_task->tname; ?>"
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
    	<div class="portion_subtitle"><i class="fa fa-wrench fa-fw"></i> La t&acirc;che</div>
        <table class="base" width="100%">
            <tr>
            	<td class="right" width="25%">Nom de la T&acirc;che :</td>		
                <td class="edit_name left" id="name" width="25%"><?php echo ucfirst($results_task->tname); ?></td>	
                <td class="right" width="25%">Client :</td>				
                <td class="left" width="25%"><?php echo ucfirst($results_task->cnom); ?></td>
            </tr>
            <tr>
            	<td class="right">Date Due :</td>					
                <td class="left edit_date" id="date_due"><?php echo $results_task->tdate_due; ?></td>	
                <td class="right">Intervenant :</td>			
                <td class="edit_user left" id="user"><?php echo ucfirst($results_task->ulogin); ?></td>
            </tr>
            <tr>
            	<td class="right">Tarif Sp&eacute;cial :</td>		
                <td class="edit_tarif left" id="tarif"><?php echo $tarif; ?></td>						
                <td class="right">D&eacute;placement :</td>	
                <td class="edit_deplacement left" id="deplacement"><?php echo $deplacement; ?></td>
            </tr>
            <tr>
            	<td class="right">Type de T&acirc;che :</td>		
                <td class="edit_type left" id="type"><?php echo $results_task->tttype; ?></td>			
                
            </tr>
            <tr>
            	<td class="right">Date de cr&eacute;ation :</td>	
                <td class="left"><?php echo $results_task->tdate_creation; ?></td>	
                <td class="right">Cr&eacute;ateur :</td>		
                <td class="left"><?php echo ucfirst($results_task->u2login); ?></td>
            </tr>
            </table>
            <div class="portion_subtitle"><i class="fa fa-ticket fa-fw"></i> Le ticket</div>
            <table class="base" width="100%">
            <tr>
                <td width="25%" class="right">Remarques relatives au Ticket :</td>
                <td width="25%" class="left edit_note"><?php echo stripslashes(ucfirst($results_task->tinote)); ?></td>
                <td width="25%" class="right">Ticket parent :</td>			
                <td width="25%" class="left"><a class="styled" href="./ticket.php?num_ticket=<?php echo $results_task->tnumticket; ?>"><?php echo $results_task->tiname; ?></a></td>
            </tr>
        </table>
        <div class='center'>
        <?php
        //Bouton CloseTask/Task Closed
        if ($state_task == 1) {
			?>
            <button class="button_act button--border-thin medium add" type="button" style="color:#27ae60;border-color:#27ae60">
                <i class="fa fa-check"></i> T&acirc;che clotur&eacutee
            </button>
            <?php
        } 
        else {
			?>
            <a href="./include/ajax/close_task.php?num_task=<?php echo $num_task;?>">
            <button class="button_act button--shikoba button--border-thin medium" type="button">
                <i class="button__icon fa fa-thumbs-o-up"></i><span>Cl&ocirc;turer la t&acirc;che</span>
            </button>
            </a>
            <?php
        } 
		?>
        </div>
	</div>
</div>
<!--Temps de travail-->
<div class="portion">
    <!-- TITRE - Temps de travail -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-clock-o fa-stack-1x"></i>
        </span>
        Temps de travail
        <span class="fa-stack fa-lg add" style="float:right" id="show_time">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_time">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - Temps de travail -->
    <div class="content_traitement" id="time">
    	<table class="base" width="100%">
        	<tr>
            	<td class="right" width="50%" style="vertical-align:bottom;font-size:1.5em">Temps de Travail Actuel :</td>
                <td class="left" width="50%" style="vertical-align:bottom;font-size:1.5em">
                	<span class="edit_timespent" id="timespent"><?php echo $time_spent;?></span>
                    <?php
					if ($set_manual == 1) {
						echo '<a href="./include/ajax/Reset_Timespent.php?rowid='.$num_task.'" class="no_effect"><i class="fa fa-eraser fa-fw del" title="Reset"></i></a>';
					}
					?>
                </td>
            </tr>
        </table>
        <!-- TIMER START / STOP -->
        <div class='center'>
        <?php
        if ($state_task == 0) {//Si la tâche est ouverte on affiche le bouton timer //Sinon on affiche rien
            //Si le temps est défini manuellement, on affiche le bouton TimeStart Grisé
            if ($set_manual == 1) {
				?>
                <button class="button_act button--border-thin medium add info" type="button" style="color:#95a5a6;border-color:#95a5a6">
                    Start Timer
                    <!-- Texte de l'info bulle, classe du parent "info" --->
                    <span><i class="fa fa-info-circle fa-fw"></i> Le temps de travail a &eacute;t&eacute; d&eacute;fini manuellement. Afin de pouvoir utiliser le timer vous devez d'abord le r&eacute;initialiser.</span>
                </button>
				<?php                
            }
            //Sinon on affiche le Bouton TimeStart/Timestop
            else {
                if ($time_start == NULL) { //Si le time_start est vide, on affiche le bouton Start
					?>
                    <a href="./include/ajax/start_task.php?num_task=<?php echo $num_task;?>">
                    <button class="button_act button--shikoba button--border-thin medium" type="button">
                        <i class="button__icon fa fa-hourglass-start"></i><span>Start Timer</span>
                    </button>
                    </a>
                    <?php
                }
                else if ($time_stop == NULL && $time_start != NULL) { //Si le timestart n'est pas vide, mais que le time_stop l'es, on affiche le bouton STOP
					?>
                    <a href="./include/ajax/stop_task.php?num_task=<?php echo $num_task;?>">
                    <button class="button_act button--shikoba button--border-thin medium" type="button">
                        <i class="button__icon fa fa-hourglass-end"></i><span>Stop Timer</span>
                    </button>
                    </a>
                    <?php
                }
            }
        }
        ?>
        </div>
	</div>
</div>
<!--FICHIER TICKET !-->
<?php
//Requête de récupération des fichiers liés au ticket
$sql_files="SELECT name, path, date_upload";
$sql_files.=" FROM ".$tblpref."files as f";
$sql_files.=" WHERE ticket=".$num_ticket."";
$req_files=mysql_query($sql_files);
$num_files=mysql_num_rows($req_files);
?>
<div class="portion">
    <!-- TITRE - FICHIER TICKET ! -->
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
    <!-- CONTENT - FICHIER TICKET ! -->
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
            while ($results_files=mysql_fetch_object($req_files)) {
                ?>
                <tr>
                    <td><?php echo $results_files->name;?></td>
                    <td><?php echo $results_files->date_upload;?></td>
                    <td>
                        <a href="./<?php echo $results_files->path;?>" target="_blank" class="no_effect">
                            <i class="fa fa-play-circle fa-fw fa-2x action"></i>
                        </a>
                        <a href="./<?php echo $results_files->path;?>" target="_blank" class="no_effect">
                            <i class="fa fa-trash fa-fw fa-2x del"></i>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
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
<!--RECAP-->
<div class="portion">
    <!-- TITRE - RECAP -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        Mat&eacute;riel
        <span class="fa-stack fa-lg add" style="float:right" id="show_article">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_article">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - RECAP -->
    <div class="content_traitement" id="article">
        <!-- Gestion des articles liés à la tâche -->
        <div class="portion_subtitle"><i class="fa fa-wrench fa-fw"></i> Lier des articles &agrave; la t&acirc;che</div>
        <?php
		//Si le ticket est cloturé, on empêche l'ajout d'articles.
		if ($state_task == 1) {
			?>
            <div class='center' style="margin:1%;">
            	Cette t&acirc;che est clotur&eacute;e. <br/>
                Il est impossible de lui ajouter du mat&eacute;riel suppl&eacute;mentaire.
            </div>
            <?php
		}
		//Sinon on le permet
		else {
		?>
            <table class="base" width="100%">
            <input type="hidden" id="num_task" value="<?php echo $num_task; ?>">
                <tr>
                    <td class="right" style="width:25%">Articles d&eacute;j&agrave; en commande :</td>
                    <?php
                    $sql="SELECT cb.num as cbnum, a.article as article, cb.quanti as quanti, cb.livre as livre, cb.article_name as article_name";
                    $sql.=" FROM ".$tblpref."cont_bon as cb";
                    $sql.=" LEFT JOIN ".$tblpref."bon_comm as bc ON bc.num_bon=cb.bon_num";
                    $sql.=" LEFT JOIN ".$tblpref."article as a ON a.num=cb.article_num";
                    $sql.=" WHERE bc.client_num=".$client_id." AND cb.livre != cb.quanti";
                    $req=mysql_query($sql);
                    $num_art_com=mysql_num_rows($req);
                    if ($num_art_com > 0) {
						?>
						<script>
						<?php
						if ($state_task == 0) {
							?>
							$(document).ready(function(){
								nbr_articles();
							})
							<?php
						}
						?>
						</script>
                        <td class="left" style="width:45%">
                            <div class="styled-select-inline" style="width:90%">
                            <select id="articles" onFocus="nbr_articles()" onMouseOver="nbr_articles()" OnChange="nbr_articles()" onKeyUp="nbr_articles()" onKeyDown="nbr_articles()" class="styled-inline"> 
                                <?php
                                while ($obj=mysql_fetch_object($req)) {
                                    if ($obj->article_name != '' && $obj->article_name != NULL) {
                                        $article=$obj->article_name;
                                    }
                                    else {
                                        $article=$obj->article;
                                    }
                                    $restant=$obj->quanti-$obj->livre; //On calcule le nombre d'article non-livrés restants.
                                    echo '<option value="'.$obj->cbnum.'">'.$obj->cbnum.' | '.$article.' | QTY : '.$restant.'</option>';
                                }
                                ?>
                            </select>
                            </div>
                        </td>
                        <td style="width:15%">
                                &nbsp;Qty :
                                <div class="styled-select-inline" style="width:50%">
                                <select id="nbr_articles" class="styled-inline">
                                </select>
                                </div>
                        </td>
                        <td class="center" style="width:15%">
                            <i class="fa fa-plus fa-fw fa-2x add" id="sub_art_com" OnClick="add_article_com()" title="Ajouter"></i>
                        </td>
                    <?php
                    }
                    else {
                        echo '<td class="left" colspan="3">Pas d\'article en commande pour ce client.</td>';
                    }
                    ?>
                </tr>
                <tr>
                    <td class="right" style="width:25%">Articles de stock :</td>
                    <?php
                    $sql ="SELECT num, article, stock";
                    $sql.=" FROM ".$tblpref."article";
                    $sql.=" WHERE stock > '0'";
                    $req=mysql_query($sql);
                    $num_art_stock=mysql_num_rows($req);
                    if ($num_art_stock > 0) {
						?>
						<script>
						<?php
						if ($state_task == 0) {
							?>
							$(document).ready(function(){
								nbr_articles_stock();
							})
							<?php
						}
						?>
						</script>
                        <td class="left" style="width:45%">
                            <div class="styled-select-inline" style="width:90%">
                            <select id="articles_stock" onFocus="nbr_articles_stock()" onMouseOver="nbr_articles_stock()" OnChange="nbr_articles_stock()" onKeyUp="nbr_articles_stock()" onKeyDown="nbr_articles_stock()" class="styled-inline">
                                <?
                                while ($obj=mysql_fetch_object($req)) {
                                    $qty=number_format($obj->stock, 0);
                                    echo '<option value="'.$obj->num.'">'.$obj->article.' | QTY : '.$qty.'</option>';
                                }
                                ?>
                            </select>
                            </div>
                        </td>
                        <td style="width:15%">
                            &nbsp;Qty :
                            <div class="styled-select-inline" style="width:50%">
                            <select id="nbr_articles_stock" class="styled-inline">
                            </select>
                            </div>
                        </td>
                        <td class="center" style="width:15%">
                            <i class="fa fa-plus fa-fw fa-2x add" id="sub_art_stock" OnClick="add_article_stock()" title="Ajouter"></i>
                        </td>
                        <?php
                    }
                    else {
                        echo '<td colspan="3" class="left">Pas d\'articles en stock.</td>';
                    }
                    ?>
                </tr>
            </table>
        <?php
		}
		?>
        <div class="portion_subtitle"><i class="fa fa-wrench fa-fw"></i> Liste des articles d&eacute;j&agrave; li&eacute;s &agrave; la t&acirc;che</div>
        <br/>
        <table class="base" width="100%" id="materieling">
                <?php
                $sql="SELECT cb.quanti as quanti, a.article as nom, a.reference as partnumber, cb.article_name as article_name";
                $sql.=" FROM ".$tblpref."cont_bl as cb";
                $sql.=" LEFT JOIN ".$tblpref."article as a ON a.num=cb.article_num";
                $sql.=" WHERE cb.num_task='".$num_task."'";
                $req=mysql_query($sql);
                $num=mysql_num_rows($req);
                ?>
                <thead>
                <tr>
                	<th class="" width="40%">Article</th>
                    <th class="" width="30%">Partnumber</th>
                    <th class="" width="20%">Qty.</th>
                    <th class="" width="10%">Actions</th>                    
                </tr>
                </thead>
                <tbody>
                <?php
                while ($obj=mysql_fetch_object($req)) {
                    if ($obj->article_name != NULL && $obj->article_name != '') {
                        $nom=$obj->article_name;
                    }
                    else {
                        $nom=$obj->nom;
                    }
                    ?>
                    <tr>
                        <td class=""><?php echo $obj->partnumber; ?></td>
                        <td class=""><?php echo $nom; ?></td>
                        <td class=""><?php echo $obj->quanti; ?></td>
                        <td></td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
        </table>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
