<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
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
	$("#hide_filter").hide();
	$("#hide_filter").click(function(){
		$("#filter").hide(500);	
		$("#hide_filter").hide();
		$("#show_filter").show();
	});
	$("#show_filter").click(function(){
		$("#filter").show(500);	
		$("#hide_filter").show();
		$("#show_filter").hide();
	});
});
$(function() {
	$( "#date_new" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd/mm/yy" })
});
<!-- DT LISTE DEVIS -->
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
		"pageLength" : 100,
		"order": [[0, 'desc']],
  	});
} );
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!--FILTRE-->
<div class="portion">
    <!-- TITRE - FILTRE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-filter fa-stack-1x"></i>
        </span>
        Filtres
        <span class="fa-stack fa-lg add" style="float:right" id="show_filter">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_filter">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - FILTRE -->
    <div class="content_traitement disp_none" id="filter">
		<?php
        $archive = $_REQUEST['archive'];
        if ($archive == '') {
            ?>
            <div class="center">
            	<a href="./list_task.php?archive=oui" class="no_effect">
                <button class="button_act button--shikoba button--border-thin medium" type="button"><i class="button__icon fa fa-archive"></i><span>Afficher les archives</span></button>
                </a>
            </div>
            <?php
        }
        else {
            ?>
            <div class="center">
            	<a href="./list_task.php" class="no_effect">
                <button class="button_act button--shikoba button--border-thin medium" type="button"><i class="button__icon fa fa-archive"></i><span>Masquer les archives</span></button>
                </a>
            </div>
            <?php
        }
        ?>
	</div>
</div>

<!--LISTE TACHES-->
<div class="portion">
    <!-- TITRE - LISTE TACHES -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        Liste des t&acirc;ches
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
    </div>
    <!-- CONTENT - LISTE TACHES -->
    <div class="content_traitement" id="list">
        <table width="100%" class="base" id="listing">
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
                                        print '<td align="center"><a class="styled" href="./task.php?num_task='.$obj->trowid.'">'.stripslashes($obj->tname).'</a></td>';
                                        print '<td align="center">'.stripslashes(ucfirst($obj->cnom)).'</td>';
                                        print '<td align="center">'.$date_due_task_final.'</td>';
                                        print '<td align="center">'.ucfirst($obj->ulogin).'</td>';
                                        print '<td align="center"><a class="styled" href="./ticket.php?num_ticket='.$obj->tirowid.'">'.$obj->tiname.'</a></td>';
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
	</div>
</div>
<?php 
//Inclusion nouveau ticket
include_once("new_task.php");
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>