<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
//Récupération des widgets activés pas l'utlisateur
$sql=" SELECT widgt_inter_all, widgt_inter_user, widgt_ticket_user, widgt_ticket_all, widgt_ticket_close_non_fact, widgt_task_day, widgt_commande, widgt_bon_liv, widgt_task_state, widgt_ticket_state, widgt_panier";
$sql.=" FROM ".$tblpref."user";
$sql.=" WHERE num='".$num_user."'";
$reqsql=mysql_query($sql) or die ('erreur resquest widgets :'.$sql);
$result_sql=mysql_fetch_object($reqsql);
$widget_inter_all=$result_sql->widgt_inter_all;
$widget_inter_user=$result_sql->widgt_inter_user;
$widget_widgt_ticket_user=$result_sql->widgt_ticket_user;
$widget_widgt_ticket_all=$result_sql->widgt_ticket_all;
$widget_ticket_close_non_fact=$result_sql->widgt_ticket_close_non_fact;
$widget_task_day=$result_sql->widgt_task_day;
$widget_commande=$result_sql->widgt_commande;
$widget_bon_liv=$result_sql->widgt_bon_liv;
$widget_panier=$result_sql->widgt_panier;
$widget_task_state=$result_sql->widgt_task_state;
$widget_ticket_state=$result_sql->widgt_ticket_state;
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
/* SHOW / HIDE */
$(document).ready(function() {
	<?php 
	if ($widget_inter_all == '0') { 
		?>
		$("#hide_task").hide();
		<?php
	}
	else {
		?>
		$("#show_task").hide();
		<?php
	}
	?>
	$("#hide_task").click(function(){
		$("#task").hide(500);	
		$("#hide_task").hide();
		$("#show_task").show();
		save_pref('task', 'non');
	});
	$("#show_task").click(function(){
		$("#task").show(500);	
		$("#hide_task").show();
		$("#show_task").hide();
		save_pref('task', 'oui');
	});
	<?php 
	if ($widget_widgt_ticket_all == '0') { 
		?>
		$("#hide_ticket").hide();
		<?php
	}
	else {
		?>
		$("#show_ticket").hide();
		<?php
	}
	?>
	$("#hide_ticket").click(function(){
		$("#ticket").hide(500);	
		$("#hide_ticket").hide();
		$("#show_ticket").show();
		save_pref('ticket', 'non');
	});
	$("#show_ticket").click(function(){
		$("#ticket").show(500);	
		$("#hide_ticket").show();
		$("#show_ticket").hide();
		save_pref('ticket', 'oui');
	});
	<?php 
	if ($widget_ticket_close_non_fact == '0') { 
		?>
		$("#hide_ticketclo").hide();
		<?php
	}
	else {
		?>
		$("#show_ticketclo").hide();
		<?php
	}
	?>
	$("#hide_ticketclo").click(function(){
		$("#ticketclo").hide(500);	
		$("#hide_ticketclo").hide();
		$("#show_ticketclo").show();
		save_pref('ticketclo', 'non');
	});
	$("#show_ticketclo").click(function(){
		$("#ticketclo").show(500);	
		$("#hide_ticketclo").show();
		$("#show_ticketclo").hide();
		save_pref('ticketclo', 'oui');
	});
	<?php 
	if ($widget_bon_liv == '0') { 
		?>
		$("#hide_blpafact").hide();
		<?php
	}
	else {
		?>
		$("#show_blpafact").hide();
		<?php
	}
	?>
	$("#hide_blpafact").click(function(){
		$("#blpafact").hide(500);	
		$("#hide_blpafact").hide();
		$("#show_blpafact").show();
		save_pref('blpafact', 'non');
	});
	$("#show_blpafact").click(function(){
		$("#blpafact").show(500);	
		$("#hide_blpafact").show();
		$("#show_blpafact").hide();
		save_pref('blpafact', 'oui');
	});
	<?php 
	if ($widget_commande == '0') { 
		?>
		$("#hide_bcpliv").hide();
		<?php
	}
	else {
		?>
		$("#show_bcpliv").hide();
		<?php
	}
	?>
	$("#hide_bcpliv").click(function(){
		$("#bcpliv").hide(500);	
		$("#hide_bcpliv").hide();
		$("#show_bcpliv").show();
		save_pref('bcpliv', 'non');
	});
	$("#show_bcpliv").click(function(){
		$("#bcpliv").show(500);	
		$("#hide_bcpliv").show();
		$("#show_bcpliv").hide();
		save_pref('bcpliv', 'oui');
	});
	<?php 
	if ($widget_panier == '0') { 
		?>
		$("#hide_panier").hide();
		<?php
	}
	else {
		?>
		$("#show_panier").hide();
		<?php
	}
	?>
	$("#hide_panier").click(function(){
		$("#panier").hide(500);	
		$("#hide_panier").hide();
		$("#show_panier").show();
		save_pref('panier', 'non');
	});
	$("#show_panier").click(function(){
		$("#panier").show(500);	
		$("#hide_panier").show();
		$("#show_panier").hide();
		save_pref('panier', 'oui');
	});
});
<!-- DECLARATION DES DT -->
$(document).ready(function() {
    $('.datat').DataTable( {
		"language": {
			"lengthMenu": 'Afficher <div class="styled-select-dt" style="width:30%"><select class="styled-dt">'+
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
		"aaSorting": [],
  	});
} );

$(document).ready(function() {

$("#show_my_task").click(function(){
	$("#show_my_task").hide();
	$("#show_all_task").show();
	save_aff('task', 'my');
});
		
$("#show_all_task").click(function(){
	$("#show_all_task").hide();
	$("#show_my_task").show();
	save_aff('task', 'all');
});

$("#show_my_ticket").click(function(){
	$("#show_my_ticket").hide();
	$("#show_all_ticket").show();
	save_aff('ticket', 'my');
});
		
$("#show_all_ticket").click(function(){
	$("#show_all_ticket").hide();
	$("#show_my_ticket").show();
	save_aff('ticket', 'all');
});

});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
//Gestion des messages informatifs
include_once("include/message_info.php");
?>

<!-- COLLONE GAUCHE -->
<div class="two_cols" style="width:42.5%;margin-left:5%;">
    <div class="w_portion">
        <div class="choice_action">
            <span class="fa-stack fa-lg">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-folder-open-o fa-stack-1x"></i>
            </span>
            T&acirc;ches Ouvertes
            <span class="fa-stack fa-lg add" style="float:right" id="show_task">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
            </span>
            <span class="fa-stack fa-lg del" style="float:right" id="hide_task">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
            </span>
            <span class="fa-stack fa-lg action" style="float:right;<?php if ($widget_task_state == 1) { echo 'display:none';}?>" id="show_my_task" title="Afficher uniquement mes t&acirc;ches">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-user fa-stack-1x"></i>
            </span>
            <span class="fa-stack fa-lg action" style="float:right;<?php if ($widget_task_state == 0) { echo 'display:none';}?>" id="show_all_task" title="Afficher toutes les t&acirc;ches">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-users fa-stack-1x"></i>
            </span>
        </div>
        <div class="content_traitement <?php if ($widget_inter_all == '0') { echo 'disp_none';}?>" id="task">
            <?php
            $sql="SELECT t.rowid as trowid, t.name as tname, t.date_due as tdate_due, c.nom as cnom, ti.name as tiname, u.login as ulogin, tt.type as type, ti.rowid as tirowid";
            $sql.=" FROM ".$tblpref."task as t";
            $sql.=" LEFT JOIN ".$tblpref."ticket as ti ON ti.rowid=t.ticket_num";
            $sql.=" LEFT JOIN ".$tblpref."client as c ON c.num_client=ti.soc";
            $sql.=" LEFT JOIN ".$tblpref."user as u ON u.num=t.user_intervenant";
            $sql.=" LEFT JOIN ".$tblpref."type_task as tt ON tt.rowid=t.type";
            $sql.=" WHERE t.state='0'";
			if ($widget_task_state == 1) {
				$sql.=" AND t.user_intervenant = '".$num_user."'";
			}
            $sql.=" ORDER BY t.date_due ASC";
            ?>
            <table class='base datat' width="100%">
                <thead>
                    <tr>
                        <th class="">Nom</th>
                        <th class="">Client</th>
                        <th class="">Date Due</th>
                        <th class="">Type</th>
                        <th class="">Intervenant</th>
                        <th class="">Ticket</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $resql0=mysql_query($sql) or die ('erreur resquest 2');
                while ($obj0 = mysql_fetch_object($resql0))
                {
                    //Récupération de la date du jour, et conversion en timestamp
                    $date_today=date('d-m-Y');
                    list($day, $month, $year) = explode('-', $date_today);
                    $ts_today = mktime(0, 0, 0, $month, $day, $year);
                    //Récupération de la date de fin et conversion en timestamp
                    $date_due=$obj0->tdate_due;
                    list($year, $month, $day) = explode('-', $date_due);
                    $ts_fin = mktime(0, 0, 0, $month, $day, $year);
                    //Convertion des dates au format mysql
                    $dateduetemp = explode(' ',$obj0->tdate_due);
                    $date = $dateduetemp[0];
                    $datetemp = explode('-',$date);
                    $heure = $dateduetemp[1];
                    $jour = $datetemp[0];
                    $mois = $datetemp[1];
                    $annee = $datetemp[2];
                    $date_due_ticket_correct=$annee."-".$mois."-".$jour;
                    $date_due_ticket_final=$date_due_ticket_correct.' '.$heure;
                    //Comparaison des deux dates, si date_fin < date_du_jour alors on surligne en rouge pour signifier le retard
                    if ($ts_fin < $ts_today) {
                        //RETARD
                        echo '<tr>';
                        echo '<td class=""><a class="dashboard" href="./task.php?num_task='.$obj0->trowid.'" data-hover="'.stripslashes($obj0->tname).'">'.stripslashes($obj0->tname).'</a></td>';
                        echo '<td class="">'.$obj0->cnom.'</td>';
                        echo '<td class="">'.$date_due_ticket_final.'</td>';
                        echo '<td class="">'.$obj0->type.'</td>';
                        echo '<td class="">'.ucfirst($obj0->ulogin).'</td>';
                        echo '<td class=""><a class="dashboard" href="./ticket.php?num_ticket='.$obj0->tirowid.'" data-hover="'.stripslashes($obj0->tiname).'">'.stripslashes($obj0->tiname).'</a></td>';
                        echo '</tr>';
                    }
                    else {
                        //DANS LES TEMPS
                        echo '<tr>';
                        echo '<td class=""><a class="dashboard" href="./task.php?num_task='.$obj0->trowid.'" data-hover="'.stripslashes($obj0->tname).'">'.stripslashes($obj0->tname).'</a></td>';
                        echo '<td class="">'.$obj0->cnom.'</td>';
                        echo '<td class="">'.$date_due_ticket_final.'</td>';
                        echo '<td class="">'.$obj0->type.'</td>';
                        echo '<td class="">'.ucfirst($obj0->ulogin).'</td>';			
                        echo '<td class=""><a class="dashboard" href="./ticket.php?num_ticket='.$obj0->tirowid.'" data-hover="'.stripslashes($obj0->tiname).'">'.stripslashes($obj0->tiname).'</a></td>';
                        echo '</tr>';
                    }
                }				
                ?>
                </tbody>
            </table> 
        </div>
    </div>
    <div class="w_portion">
        <div class="choice_action">
            <span class="fa-stack fa-lg">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-credit-card fa-stack-1x"></i>
            </span>
            Tickets clotur&eacute;s & non-factur&eacute;s
            <span class="fa-stack fa-lg add" style="float:right" id="show_ticketclo">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
            </span>
            <span class="fa-stack fa-lg del" style="float:right" id="hide_ticketclo">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
            </span>
        </div>
        <div class="content_traitement <?php if ($widget_ticket_close_non_fact == '0') { echo 'disp_none';}?>" id="ticketclo">
        	<?php
        $sql="SELECT t.rowid as trowid, t.name as tname, t.date_due as tdate_due, c.nom as cnom, u.login as ulogin, t.soc as tsoc";
        $sql.=" FROM ".$tblpref."ticket as t";
        $sql.=" LEFT JOIN ".$tblpref."client as c ON c.num_client=t.soc";
        $sql.=" LEFT JOIN ".$tblpref."user as u ON u.num=t.user_in_charge";
        $sql.=" WHERE t.state='1' AND t.facture='0'";
        $sql.=" ORDER BY t.date_due ASC";
        ?>
            <table class='base datat' width="100%">
            <thead>
            <tr>
                <th class="" width="28%">Nom</th>
                <th class="" width="20%">Client</th>
                <th class="" width="13">Date Due</th>
                <th class="" width="15%">Responsable</th>
                <th class="" width="12%">Facturer</th>
                <th class="" width="12%">Purger</th>
            </tr>
            </thead>
            <?php
            $resql0=mysql_query($sql) or die ('erreur resquest 5');
            while ($obj0 = mysql_fetch_object($resql0))
            {
                //Convertion des dates au format mysql
                $dateduetemp = explode(' ',$obj0->tdate_due);
                $date = $dateduetemp[0];
                $datetemp = explode('-',$date);
                $heure = $dateduetemp[1];
                $jour = $datetemp[0];
                $mois = $datetemp[1];
                $annee = $datetemp[2];
                $date_due_ticket_correct=$annee."-".$mois."-".$jour;
                $date_due_ticket_final=$date_due_ticket_correct.' '.$heure;
                $date_day=date('d/m/Y');
                $date_past=date('d/m/Y', strtotime("- 1 year"));
                ?>
                <tr>
                <td class="ok"><a class="dashboard" href="./ticket.php?num_ticket=<?php echo $obj0->trowid;?>" data-hover="<?php echo stripslashes($obj0->tname);?>"><?php echo stripslashes($obj0->tname);?></a></td>
                <td class="ok"><?php echo $obj0->cnom;?></td>
                <td class="ok"><?php echo '<span style="display:none">'.$date.'</span>'.$date_due_ticket_final;?></td>
                <td class="ok"><?php echo ucfirst($obj0->ulogin);?></td>
                <td class="ok">
                    <form name="formu" method="POST" action="fact.php" style="display:inline-block;vertical-align:top">
                        <input type="hidden" id="listeville" name="listeville" value="<?php echo $obj0->tsoc;?>">
                        <input type="hidden" id="date_deb" name="date_deb" value="<?php echo $date_past;?>">
                        <input type="hidden" id="date_fin" name="date_fin" value="<?php echo $date_day;?>">
                        <input type="hidden" id="date_fact" name="date_fact" value="<?php echo $date_day;?>">
                        <button type="submit" class="icons fa fa-credit-card fa-fw fa-2x action" title="Facturer"></button>
                    </form>
                    <?php
                    //ON recherche si le client dispose d'un abonnement
                    $sql_abo =" SELECT ID, temps_restant";
                    $sql_abo.=" FROM ".$tblpref."abos";
                    $sql_abo.=" WHERE client=".$obj0->tsoc." AND actif='oui'";	
                    $req_abo=mysql_query($sql_abo);
                    if ( $results_abo=mysql_fetch_object($req_abo)) { //Si le client dispo d'un abo prépayé on affiche le bouton déduire de l'abo, si déja déduit
                            ?>
                            <a href="./include/ajax/gestion_abo.php?num_ticket=<?php echo $obj0->trowid;?>" class="no_effect">
                                <i class="fa fa-calendar-minus-o fa-fw fa-2x action" title="D&eacute;duire de l'abo"></i>
                            </a>
                            <?php
                    }
					?>
                </td>
                <td class="ok">
                    <a href="javascript:if(confirm('Purger le ticket ?')) document.location.href='./include/ajax/purge_ticket.php?num_ticket=<?php echo $obj0->trowid;?>&location=acceuil'" class="no_effect">
                        <i class="fa fa-fire-extinguisher fa-fw fa-2x del" title="Purger"></i>
                    </a>
                </td>
                </tr>
            <?php
            }	
            ?>
            </table>
        </div>
    </div>
	<div class="w_portion">
		<div class="choice_action">
			<span class="fa-stack fa-lg">
			  <i class="fa fa-square-o fa-stack-2x"></i>
			  <i class="fa fa-phone fa-stack-1x"></i>
			</span>
			Bons de commandes non-enti&egrave;rement livr&eacute;s
			<span class="fa-stack fa-lg add" style="float:right" id="show_bcpliv">
			  <i class="fa fa-square-o fa-stack-2x"></i>
			  <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
			</span>
			<span class="fa-stack fa-lg del" style="float:right" id="hide_bcpliv">
			  <i class="fa fa-square-o fa-stack-2x"></i>
			  <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
			</span>
		</div>
		<div class="content_traitement <?php if ($widget_commande == '0') { echo 'disp_none';}?>" id="bcpliv">
			<table class='base datat' width="100%">
				<thead>
					<tr>
						<th class="">Num. BC</th>
						<th class="">Client</th>
						<th class="">Date</th>
						<th class="">Montant (HT)</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql ="SELECT bc.num_bon as num, c.nom as nom, bc.date as bcdate, bc.tot_htva as tot_htva";
					$sql.=" FROM ".$tblpref."bon_comm as bc";
					$sql.=" LEFT JOIN ".$tblpref."client as c ON c.num_client = bc.client_num";
					$sql.=" WHERE bc.bl != 'end'";
					$sql.=" ORDER by bc.num_bon DESC";
					$req=mysql_query($sql);
					while ($obj=mysql_fetch_object($req)) {
						?>
						<tr>
							<td><?php echo $obj->num;?></td>
							<td><?php echo $obj->nom;?></td>
							<td><?php echo $obj->bcdate;?></td>
							<td><?php echo $obj->tot_htva;?> &euro;</td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- COLLONE DROITE -->
<div class="two_cols" style="width:42.5%;margin-left:5%;">
    <div class="w_portion">
        <div class="choice_action">
            <span class="fa-stack fa-lg">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-ticket fa-stack-1x"></i>
            </span>
            Tickets Ouverts
            <span class="fa-stack fa-lg add" style="float:right" id="show_ticket">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
            </span>
            <span class="fa-stack fa-lg del" style="float:right" id="hide_ticket">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
            </span>
            <span class="fa-stack fa-lg action" style="float:right;<?php if ($widget_ticket_state == 1) { echo 'display:none';}?>" id="show_my_ticket" title="Afficher uniquement mes tickets">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-user fa-stack-1x"></i>
            </span>
            <span class="fa-stack fa-lg action" style="float:right;<?php if ($widget_ticket_state == 0) { echo 'display:none';}?>" id="show_all_ticket" title="Afficher tous les tickets">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-users fa-stack-1x"></i>
            </span>
        </div>
        <div class="content_traitement <?php if ($widget_widgt_ticket_all == '0') { echo 'disp_none';}?>" id="ticket">
            <?php
            $sql="SELECT t.rowid as trowid, t.name as tname, t.date_due as tdate_due, c.nom as cnom, u.login as ulogin";
            $sql.=" FROM ".$tblpref."ticket as t";
            $sql.=" LEFT JOIN ".$tblpref."client as c ON c.num_client=t.soc";
            $sql.=" LEFT JOIN ".$tblpref."user as u ON u.num=t.user_in_charge";
            $sql.=" WHERE t.state='0'";
			if ($widget_ticket_state == 1) {
				$sql.=" AND t.user_in_charge = '".$num_user."'";
			}
            $sql.=" ORDER BY t.date_due ASC";
            ?>
            <table class='base datat' width="100%">
                <thead>
                    <tr>
                        <th class="soustitre">Nom</th>
                        <th class="soustitre">Client</th>
                        <th class="soustitre">Date Due</th>
                        <th class="soustitre">Responsable</th>
                    </tr>
                </thead>
            <?php
            $resql0=mysql_query($sql) or die ('erreur resquest 4');
            while ($obj0 = mysql_fetch_object($resql0))
            {
                //Récupération de la date du jour, et conversion en timestamp
                $date_today=date('d-m-Y');
                list($day, $month, $year) = explode('-', $date_today);
                $ts_today = mktime(0, 0, 0, $month, $day, $year);
                //Récupération de la date de fin et conversion en timestamp
                $date_due=$obj0->tdate_due;
                list($year, $month, $day) = explode('-', $date_due);
                $ts_fin = mktime(0, 0, 0, $month, $day, $year);
                //Convertion des dates au format mysql
                $dateduetemp = explode(' ',$obj0->tdate_due);
                $date = $dateduetemp[0];
                $datetemp = explode('-',$date);
                $heure = $dateduetemp[1];
                $jour = $datetemp[0];
                $mois = $datetemp[1];
                $annee = $datetemp[2];
                $date_due_ticket_correct=$annee."-".$mois."-".$jour;
                $date_due_ticket_final=$date_due_ticket_correct.' '.$heure;
                //Comparaison des deux dates, si date_fin < date_du_jour alors on surligne en rouge pour signifier le retard
                if ($ts_fin < $ts_today) {
                    echo '<tr class="retard">';
                    echo '<td class=""><a class="dashboard" href="./ticket.php?num_ticket='.$obj0->trowid.'" data-hover="'.stripslashes($obj0->tname).'">'.stripslashes($obj0->tname).'</a></td>';
                    echo '<td class="">'.$obj0->cnom.'</td>';
                    echo '<td class="">'.$date_due_ticket_final.'</td>';
                    echo '<td class="">'.ucfirst($obj0->ulogin).'</td>';
                    echo '</tr>';
                }
                else {
                    echo '<tr>';
                    echo '<td class=""><a class="dashboard" href="./ticket.php?num_ticket='.$obj0->trowid.'" data-hover="'.stripslashes($obj0->tname).'">'.stripslashes($obj0->tname).'</a></td>';
                    echo '<td class="">'.$obj0->cnom.'</td>';
                    echo '<td class="">'.$date_due_ticket_final.'</td>';
                    echo '<td class="">'.ucfirst($obj0->ulogin).'</td>';
                    echo '</tr>';
                }
            }	
            ?>
            </table>
        </div>
    </div>
    <div class="w_portion">
        <div class="choice_action">
            <span class="fa-stack fa-lg">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-truck fa-stack-1x"></i>
            </span>
            Bons de livraison non-factur&eacute;s
            <span class="fa-stack fa-lg add" style="float:right" id="show_blpafact">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
            </span>
            <span class="fa-stack fa-lg del" style="float:right" id="hide_blpafact">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
            </span>
        </div>
        <div class="content_traitement <?php if ($widget_bon_liv == '0') { echo 'disp_none';}?>" id="blpafact">
            <table class="base datat" width="100%">
                <thead>
                    <tr>
                        <th>Num</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Total HT</th>
                        <th>Facturer</th>
                    </tr>
                </thead>
                <?php
                $sql = "SELECT bl.num_bl, bl.bon_num, bl.tot_htva, bl.tot_tva, DATE_FORMAT(bl.date,'%d/%m/%Y') AS bldate, c.nom, c.num_client
                        FROM " . $tblpref ."bl as bl
                        LEFT JOIN ".$tblpref."client as c on c.num_client = bl.client_num
                        WHERE fact='0'";
                $req=mysql_query($sql);
                $date_day=date('d/m/Y');
                $date_past=date('d/m/Y', strtotime("- 1 year"));
                while ($obj=mysql_fetch_object($req)) {
                    ?>
                    <tr>
                        <td><?php echo $obj->num_bl;?></td>
                        <td><?php echo $obj->nom;?></td>
                        <td><?php echo $obj->bldate;?></td>
                        <td><?php echo $obj->tot_htva;?> &euro;</td>
                        <td>
                        <form name="formu" method="POST" action="fact.php">
                            <input type="hidden" id="listeville" name="listeville" value="<?php echo $obj->num_client;?>">
                            <input type="hidden" id="date_deb" name="date_deb" value="<?php echo $date_past;?>">
                            <input type="hidden" id="date_fin" name="date_fin" value="<?php echo $date_day;?>">
                            <input type="hidden" id="date_fact" name="date_fact" value="<?php echo $date_day;?>">
                            <button type="submit" class="icons fa fa-credit-card fa-fw fa-2x action" title="Facturer"></button>
                        </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
    <div class="w_portion">
        <div class="choice_action">
            <span class="fa-stack fa-lg">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-shopping-cart fa-stack-1x"></i>
            </span>
            Panier d'articles arrivant &agrave; terme
            <span class="fa-stack fa-lg add" style="float:right" id="show_panier">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
            </span>
            <span class="fa-stack fa-lg del" style="float:right" id="hide_panier">
              <i class="fa fa-square-o fa-stack-2x"></i>
              <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
            </span>
        </div>
        <div class="content_traitement <?php if ($widget_panier == '0') { echo 'disp_none';}?>" id="panier">
        	<table class="base datat" width="100%">
            	<thead>
                	<tr>
                    	<th>Client</th>
                        <th>&Eacute;ch&eacute;ance</th>
                        <th>&Eacute;tat</th>
                    </tr>
                </thead>
                <tbody>
                	<?php
					$date_compar = date('Y-m-d', strtotime("+2 week"));
					$sql="SELECT p.echeance, p.etat, c.nom";
					$sql.=" FROM ".$tblpref."panier as p";
					$sql.=" LEFT JOIN ".$tblpref."client as c ON c.num_client = p.id_cli";
					$sql.=" WHERE p.echeance < '".$date_compar."'";
					$req=mysql_query($sql);
					while ($obj = mysql_fetch_object($req)) {
						if ($obj->etat == 1) {
							if ($obj->echeance < date('Y-m-d')) {
								$etat='<i class="fa fa-frown-o" style="color:#c0392b"></i> D&eacute;pass&eacute;';
							}
							else {
								$etat='<i class="fa fa-refresh"></i> En cours';
							}
						}
						else if ($obj->etat == 2) {
							$etat='<i class="fa fa-hourglass-half"></i> Mail envoy&eacute; - Attente de r&eacute;ponse';
						}
						else if ($obj->etat == 3) {
							$etat='<i class="fa fa-thumbs-up"></i> Renouvelement accept&eacute;';
						}
						else if ($obj->etat == 4) {
							$etat='<i class="fa fa-thumbs-down"></i> Renouvelement refus&eacute;';
						}
						?>
                        <tr>
                        	<td><?php echo $obj->nom;?></td>
                            <td><?php echo $obj->echeance;?></td>
                            <td><?php echo $etat;?></td>
                        </tr>
                        <?php
					}
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>