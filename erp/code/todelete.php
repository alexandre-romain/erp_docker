<?php 
require_once("include/verif.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");			
include_once("include/head.php");
$user = $_SERVER[PHP_AUTH_USER]; //login dans cette variable
//On inclus le footer apres la récupération de la variable $user; pour pouvoir la récupérer
include_once("include/elements/footer.php");

//Récupération de l'utilisiteur accédant à la page
$sql_user=" SELECT num";
$sql_user.=" FROM ".$tblpref."user";
$sql_user.=" WHERE login='".$user."'";
$req_user=mysql_query($sql_user);
$results_user=mysql_fetch_object($req_user);
$num_user=$results_user->num;
//Récupération de la variable archive, pour afficher ou masquer les archives
$archive = $_REQUEST['archive'];
?>
<head>
<style type="text/css" media="screen">
	@import "include/css/demo_table_jui.css";
	@import "include/css/jquery-ui-1.7.2.custom.css";
	@import "include/css/list_task_ticket.css";

</style>
<!-- Datatables Editable plugin -->
<script type="text/javascript" src="include/js/autocomplete.js"></script>
<script type="text/javascript" src="include/js/showinfoticket.js"></script>  
<script type="text/javascript" src="include/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="include/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="include/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="include/js/jquery.dataTables.editable.js"></script>
<script type="text/javascript" src="include/js/jquery.jeditable.js"></script>
<script type="text/javascript" src="include/js/jquery-ui.js"></script>
<script type="text/javascript" src="include/js/jquery.validate.js"></script>
<script type="text/javascript" src="include/js/datepicker.js"></script>

<!-- Auto-Complete -->

<!-- Liste Intervention -->
<script type="text/javascript" charset="utf-8">
$(document).ready( function () {
<!--var id = -1;//simulation of id -->
$('#tableinter').dataTable({ 
bJQueryUI: true,
"sPaginationType": "full_numbers",
"aaSorting": []
}).makeEditable({
sUpdateURL:"include/ajax/UpdateTask.php?current=<?php echo $num_user;?>",
sAddHttpMethod: "GET",
sDeleteHttpMethod: "GET",
sDeleteURL: "include/ajax/DeleteTask.php",
sAddNewRowButtonId: "btnAddNewRow1",
sDeleteRowButtonId: "btnDeleteRow1",		
sAddNewRowOkButtonId: "btnAddNewRowOk1",
sAddNewRowCancelButtonId: "btnAddNewRowCancel1",		
"aoColumns": 
[
 //liste des colonnes avec leur comportement respectif + eventuellement style via CSS
	//ID
	null,
	//Nom
	{
		sName: "name",
		indicator: 'Enregistrement ...',
		tooltip: 'Double clic pour modifier',
		loadtext: 'loading...',
		type: 'text' //possibilités : text, textarea ou select
		
	},
	//Client
	{
		sName: "soc",
		indicator: 'Enregistrement ...',
		tooltip: 'Double clic pour modifier',
		loadtext: 'loading...',
		type: 'text' //possibilités : text, textarea ou select
		
	},
	//Date Due
	{
		sName: "date_due",
		indicator: 'Enregistrement ...',
		tooltip: 'Double clic pour modifier',
		loadtext: 'loading...',
		type: 'text' //possibilités : text, textarea ou select
		
	},
<?php
if ($user == 'alex' || $user == 'christophe') {
?>
	//Intervenant
	{
		sName: "user_intervenant",
		indicator: 'Enregistrement ...',
		tooltip: 'Double clic pour modifier',
		loadtext: 'loading...',
		type: 'select',
		onblur: 'submit',
		<?php
			
			$sql0 = "SELECT u.num, u.login";
			$sql0 .= " FROM ".$tblpref."user as u";
			$resql0=mysql_query($sql0);
			echo 'data: "{';
			if ($resql0)
			{
				$num0 = mysql_num_rows($resql0);
				$i0 = 0;
				if ($num0)
				{
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
				}
			}
			echo '}"';
		?>
	},
	
<?php
}
else {
?>
	//USER1
	null,
<?php
}
?>

	//Ticket Parent
	{
		sName: "ticket",
		indicator: 'Enregistrement ...',
		tooltip: 'Double clic pour modifier',
		loadtext: 'loading...',
		type: 'select',
		onblur: 'submit',
		<?php
			
			$sql0 = "SELECT u.rowid, u.name";
			$sql0 .= " FROM ".$tblpref."ticket as u";
			$resql0=mysql_query($sql0);
			echo 'data: "{';
			if ($resql0)
			{
				$num0 = mysql_num_rows($resql0);
				$i0 = 0;
				if ($num0)
				{
					while ($i0 < $num0)
					{
								$obj0 = mysql_fetch_object($resql0);						
								if ($obj0)
								{
									echo "'".$obj0->rowid."':'".$obj0->name."'";
								}	
						$i0++;
						if ($i0 < $num0) 
						{ 
							echo ",";
						}
					}
				}
			}
			echo '}"';
		?>
	},
	//Date Creation
	null,
	//Etat
	{
		sName: "etat",
		indicator: 'Enregistrement ...',
		tooltip: 'Double clic pour modifier',
		loadtext: 'loading...',
		type: 'select',
		onblur: 'submit',
		data: "{'0':'Open','1':'Close'}"
		
	}
],
oAddNewRowButtonOptions: {	label: "Ajouter...",
icons: {primary:'ui-icon-plus'} 
},
oDeleteRowButtonOptions: {	label: "Supprimer", 
icons: {primary:'ui-icon-trash'}
},

oAddNewRowFormOptions: { 	
title: 'Ajouter un Nom de Domaine',
//show: "blind", //saloperie qui empeche le curseur de rester en place ..
hide: "fade", //autre possibilité : explode
modal: true
},
sAddDeleteToolbarSelector: ".dataTables_length"								

});

});
</script>
</head>
<body>
<?php
if ($archive == '') {
	?>
	<a href="./list_task.php?archive=oui"><button class="archive">Afficher les archives</button></a>
    <?php
}
else {
	?>
    <a href="./list_task.php"><button class="archive">Masquer les archives</button></a>
    <?php
}
?>
<!--Contenu de la modale d'ajout-->
<div id="overlay3">
    <div class="popup_block">
        <a class="close" href="#noWhere"><img alt="Fermer" title="Fermer la fenêtre" class="btn_close" src="./include/img/close_pop.png"></a>
        <form action="include/ajax/Add_Task_Ticket.php" method="POST">
        <input type="hidden" name="user_creator" id="user_creator" value="<?php echo $num_user;?>">
        <!--Choix du client-->
        <fieldset class="client">
        <legend>1. Le client</legend>
        <label for="search_soc"><i>Recherche Client (3carac min.)</i></label><br/>
        <input type="text" size="25" value="" id="search_soc" name="search_soc" onKeyUp="javascript:autosuggest('asoc')" autocomplete="off" autofocus /><!--  champ texte à analyser pour les suggestions -->   
        <br/>
        <label for="soc" class="add_task_gauche">Client</label><br/>
        <select id="soc" name ="soc" onKeyUp="javascript:showinfoclient()" onChange="javascript:showinfoclient()" onFocus="javascript:showinfoclient()" onClick="javascript:showinfoclient()">
        </select>
        </fieldset>
        <div id="infoclient" style="display:block;"></div>
        <br/><br/>
        <!--Choix du ticket, New or existing-->
        <fieldset class="ticket">
        <legend>2. Le Ticket</legend>
        <label for="new_or_existing">Type de Ticket Parent</label><br/>
        <select name="new_or_existing" id="new_or_existing" onKeyup="javascript:showinfoticket()" onChange="javascript:showinfoticket()" onFocus="javascript:showinfoticket()" onload="javascript:showinfoticket()" >
        <option value="0" selected>Ticket existant</option>
        <option value="1">Nouveau ticket</option>
        </select>
        <br/><br/>
        <div id="infoticket" style="display:block;"></div>
        </fieldset>
        <!--Fields Taches-->
        <fieldset class="tache">
        <legend>3. La T&acirc;che</legend>
        <label for="name_task" id="name_task_label">Description/Nom T&acirc;che</label><br/>
        <input type="text" size="25" id="name_task" name="name_task">
        <br/><br/>
        <label for="type_task" id="type_task_label">Type de T&acirc;che</label><br/>
        <select name="type_task" id="type_task">
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
        <br /><br />
        <label for="deplacement">D&eacute;placement</label><br/>
        <select name="deplacement" id="deplacement">
          <option value="0" selected>Aucun</option>
          <option value="1">- 20km</option>
          <option value="2">20 - 40km</option>
          <option value="3">40+ km</option>
        </select>
        <br /><br />
        <label for="tarif_special">Tarif Sp&eacute;cial</label><br/>
        <select name="tarif_special" id="tarif_special">
          <option value="1" selected>Non</option>
          <option value="2">19h+</option>
          <option value="3">Dimanche / F&eacute;ri&eacute; / 22h+</option>
          <option value="4">Tarif r&eacute;duit</option>
        </select>
        <br/><br/>
        <label for="state_task" id="state_task_label">&Eacute;tat de la T&acirc;che</label><br/>
        <select name="state_task" id="state_task" onKeyup="javascript:showmoretask()" onChange="javascript:showmoretask()" onFocus="javascript:showmoretask()">
        <option value="0">Ouverte</option>
        <option value="1">Clotur&eacute;e</option>
        </select>
        <br/><br/>
        <div id="infotask" style="display:block;"></div>
        <input type="submit" value="Valider" id="submit_new_task" name="submit_new_task">
        </form>
    </div>
</div>
<p><a href="#overlay3" class="btn_new_task">Ajouter une t&acirc;che</a></p>



<!-- On descend la liste d'une ligne pour centrage  -->
<br/>
<!-- On descend la liste d'une ligne pour centrage  -->
<div id="types" class="art-postheader" align="center"><h1>Liste des T&acirc;ches</h1></div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tableinter">
	<thead>
		<tr>
        	<th>Num.</th>
			<th>Nom de la t&acirc;che</th>
			<th>Client</th>
            <th>Date Due</th>
            <th>Intervenant</th>
            <th>Ticket Parent</th>
            <th>Date Cr&eacute;ation</th>
            <th>Etat (TimeSpent)</th>                        
		</tr>
	</thead>

	<tbody>
	<?php
	if ($user == 'alex') {
	?>
		<button id="btnDeleteRow1" >Supprimer</button>
    <?php
	}
	else if ($user == 'christophe') {
	?>	
		<button id="btnDeleteRow1" >Supprimer</button>	
    <!-- création du contenu de la table sur base des enregistrements db -->
    <?php
	}
	// On récupère les hébergements actifs
	if ($archive == '') {
	$sql = "SELECT t.name as tname, ti.name as tiname, t.date_due tdate_due, t.state tstate, t.date_creation tdate_creation, u.login ulogin, c.nom cnom, t.rowid as trowid, t.time_spent as ttime_spent, ti.rowid as tirowid";
    $sql .= " FROM ".$tblpref."task as t";
	$sql .= " LEFT JOIN ".$tblpref."ticket as ti ON ti.rowid=t.ticket_num";
	$sql .= " LEFT JOIN ".$tblpref."client as c ON c.num_client=ti.soc";	
	$sql .= " LEFT JOIN ".$tblpref."user as u ON u.num=t.user_intervenant";
	$sql .= " WHERE t.state='0'";
    $sql .= " ORDER by t.date_due ASC";
	}
	else {
	$sql = "SELECT t.name as tname, ti.name as tiname, t.date_due tdate_due, t.state tstate, t.date_creation tdate_creation, u.login ulogin, c.nom cnom, t.rowid as trowid, t.time_spent as ttime_spent, ti.rowid as tirowid";
    $sql .= " FROM ".$tblpref."task as t";
	$sql .= " LEFT JOIN ".$tblpref."ticket as ti ON ti.rowid=t.ticket_num";
	$sql .= " LEFT JOIN ".$tblpref."client as c ON c.num_client=ti.soc";	
	$sql .= " LEFT JOIN ".$tblpref."user as u ON u.num=t.user_intervenant";
    $sql .= " ORDER by t.date_due ASC";
	}
	$resql=mysql_query($sql);
		if ($resql)
		{
			$num =mysql_num_rows($resql);
			$i = 0;
			if ($num)
			{
				while ($i < $num)
				{
					
							$obj =mysql_fetch_object($resql);
							echo '<tr class="odd_gradeX" id="'.$obj->trowid.'">';						
							if ($obj)
							{
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
								$date_due_task_correct=$annee."-".$mois."-".$jour;
								$date_due_task_final=$date_due_task_correct.' '.$heure;
								//Affichage
								print '<td align="center">'.$obj->tirowid.'-'.$obj->trowid.'</td>';
								print '<td align="center"><a class="fiche_ticket" href="./task.php?num_task='.$obj->trowid.'">'.stripslashes($obj->tname).'</a></td>';
								print '<td align="center">'.stripslashes(ucfirst($obj->cnom)).'</td>';
								print '<td align="center">'.$date_due_task_final.'</td>';
								print '<td align="center">'.ucfirst($obj->ulogin).'</td>';
								print '<td align="center"><a class="fiche_ticket" href="./ticket.php?num_ticket='.$obj->tirowid.'">'.$obj->tiname.'</a></td>';
								print '<td align="center">'.$obj->tdate_creation.'</td>';
								if ($etat=='Close') {
								print '<td align="center">'.$etat.' ('.$timefinal.')</td>';
								}
								else {
								print '<td align="center">'.$etat.'</td>';
								}
							}
							echo '</tr>';	
					$i++;
				}
			}
		}
	?>
	</tbody>
</table>

</body>

