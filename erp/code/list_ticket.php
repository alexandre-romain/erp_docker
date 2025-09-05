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
<!-- DT LIST TICKET -->
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
            	<a href="./list_ticket.php?archive=oui" class="no_effect">
                <button class="button_act button--shikoba button--border-thin medium" type="button"><i class="button__icon fa fa-archive"></i><span>Afficher les archives</span></button>
                </a>
            </div>
            <?php
        }
        else {
            ?>
            <div class="center">
            	<a href="./list_ticket.php" class="no_effect">
                <button class="button_act button--shikoba button--border-thin medium" type="button"><i class="button__icon fa fa-archive"></i><span>Masquer les archives</span></button>
                </a>
            </div>
            <?php
        }
        ?>
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
        Liste des tickets
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
    <!-- CONTENT - LISTE -->
    <div class="content_traitement" id="list">
        <table width="100%" class="base" id="listing">
            <thead>
                <tr>
                    <th>Num.</th>
                    <th width="20%">Nom du Ticket</th>
                    <th>Client</th>
                    <th>Date Due</th>
                    <th>Responsable</th>
                    <th>Date Cr&eacute;ation</th> 
                    <th>Etat</th>                      
                </tr>
            </thead>
        
            <tbody>
            <?php
            if ($user == 'alex' || $user == 'christophe') {
            ?>
            <button id="btnDeleteRow1" >Supprimer</button>
            <?php
            }
            // On récupère les tickets existants
            if ( $archive == '') {
            $sql = "SELECT t.name as tname, t.date_due tdate_due, t.date_creation tdate_creation, u.login ulogin, c.nom cnom, t.rowid as trowid, t.state as tstate";
            $sql .= " FROM ".$tblpref."ticket as t";
            $sql .= " LEFT JOIN ".$tblpref."client as c ON c.num_client=t.soc";	
            $sql .= " LEFT JOIN ".$tblpref."user as u ON u.num=t.user_in_charge";
            $sql .= " WHERE t.state='0'";
            $sql .= " ORDER by t.date_due ASC";
            }
            else {
            $sql = "SELECT t.name as tname, t.date_due tdate_due, t.date_creation tdate_creation, u.login ulogin, c.nom cnom, t.rowid as trowid, t.state as tstate";
            $sql .= " FROM ".$tblpref."ticket as t";
            $sql .= " LEFT JOIN ".$tblpref."client as c ON c.num_client=t.soc";	
            $sql .= " LEFT JOIN ".$tblpref."user as u ON u.num=t.user_in_charge";
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
                                        print '<td align="center">'.$obj->trowid.'</td>';
                                        print '<td align="center"><a class="styled" href="./ticket.php?num_ticket='.$obj->trowid.'">'.stripslashes($obj->tname).'</a></td>';
                                        print '<td align="center">'.stripslashes(ucfirst($obj->cnom)).'</td>';
                                        print '<td align="center">'.$date_due_ticket_final.'</td>';
                                        print '<td align="center">'.ucfirst($obj->ulogin).'</td>';
                                        print '<td align="center">'.$obj->tdate_creation.'</td>';
                                        print '<td align="center">'.$etat.'</td>';
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

