<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script type="text/javascript" src="include/js/showinfoticket.js"></script>
<script>
$(document).ready(function() {
	<?php
	if ($page == 'list_task.php' || $page == 'list_ticket.php') {
		?>
		$("#hide_add").hide();
		<?php
	}
	else {
		?>
		$("#show_add").hide();
		<?php
	}
	?>
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
$(function() {
	$( ".datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd-mm-yy" })
});
</script>
<?php
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!--CREATION COMMANDE-->
<div class="portion">
    <!-- TITRE - CREATION COMMANDE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        Cr&eacute;er un ticket
        <span class="fa-stack fa-lg add" style="float:right" id="show_add">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_add">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - CREATION COMMANDE -->
    <div class="content_traitement <?php if ($page == 'list_task.php' || $page == 'list_ticket.php') { echo 'disp_none';}?>" id="add">
        <form action="include/form/add_ticket.php" method="POST">
        <input type="hidden" name="user_creator" id="user_creator" value="<?php echo $num_user;?>">
        <div class="portion_subtitle"><i class="fa fa-user"></i> Le client</div>
        <!--Choix du client-->
        <table class="base" width="100%">
        	<tr>
            	<td class="right" width="50%">Recherche Client ( 3 caract&egrave;res minimum ) :</td>
                <td class="left" width="50%"><input type="text" size="25" value="" id="search_soc" name="search_soc" onKeyUp="javascript:autosuggest('asoc')" autocomplete="off" autofocus class="styled"/></td>
            </tr>
            <tr>
            	<td class="right">Client :</td>
                <td class="left">
                	<div class="styled-select-inline" style="width:80%">
                        <select id="listeville" name="client" onKeyUp="javascript:showinfoclient()" onChange="javascript:showinfoclient()" onFocus="javascript:showinfoclient()" onClick="javascript:showinfoclient()" class="styled-inline">
                        	<option value="">Veuillez d'abord effectuer une recherche...</option>
                        </select>
                    </div>
        		</td>
            </tr>
        </table>
        <!--DIV DANS LEQUEL SONT POUSSE LES INFO CLIENT, AVEC POSSIBILITE D'EDITION INLINE-->
        <div id="infoclient" style="display:block;"></div>
		<div class="portion_subtitle"><i class="fa fa-ticket"></i> Le ticket</div>
        <table class="base" width="100%">
        	<tr>
            	<td class="right" width="50%">Nom du ticket :</td>
                <td class="left" width="50%"><input type="text" size="25" id="name_ticket" name="name_ticket" class="styled" onKeyUp="copy_name_ticket()"></td>
            </tr>
            <tr>
            	<td class="right">Responsable Ticket :</td>
                <td class="left">
                	<div class="styled-select-inline" style="width:80%">
                	<select name="user_ticket" id="user_ticket" class="styled-inline">
						<?php
                        $sql1 = "SELECT login, num";
                        $sql1 .= " FROM ".$tblpref."user WHERE actif=1";
                            $resql=mysql_query($sql1);
                            if ($resql)
                            {
                                $num = mysql_num_rows($resql);
                                $i = 0;
                                if ($num)
                                {
                                    while ($i < $num)
                                    {
                                                $obj = mysql_fetch_object($resql);
                                                if ($obj)
                                                {
                                                    echo '<option value="'.$obj->num.'">'.$obj->login.'</option>';
                                                    // You can use here results

                                                }
                                        $i++;
                                    }
                                }
                            }
                        ?>
                    </select>
                    </div>
                </td>
            </tr>
            <tr>
            	<td class="right" width="50%">Date d'&eacute;cheance ticket :</td>
                <td class="left" width="50%">
                	<input type="text" size="9" id="date_due_ticket" name="date_due_ticket" value="<?php echo date('d-m-Y', strtotime("+ 1 day"));?>" class="styled datepicker" style="width:15%" onChange="copy_date_ticket()">
                    &agrave; <input type="text" id="hour_due_ticket" name="hour_due_ticket" size="1" value="<?php echo date('H');?>" class="styled" style="width:4%" onKeyUp="copy_hour_ticket()"/>
                    &nbsp;:  <input type="text" id="min_due_ticket" name="min_due_ticket" size="1" value="<?php echo date('i');?>" class="styled" style="width:4%" onKeyUp="copy_min_ticket()"/>
              	</td>
            </tr>
            <tr>
            	<td class="right" width="50%">Note Interne ticket :</td>
                <td class="left" width="50%"><textarea id="note_internal" name="note_internal" class="styled" cols="77"></textarea></td>
            </tr>
            <tr>
            	<td class="right" width="50%">Contact sp&eacute;cifique ?</td>
                <td class="left" width="50%"><input type="checkbox" name="contact" id="contact" value="contact_oui" onchange="check_contact()"></td>
            </tr>
            <tbody id="contact_place">
            </tbody>
        </table>
        <div class="portion_subtitle"><i class="fa fa-tags"></i> Les t&acirc;ches</div>
        <table class="base" width="100%" id="add_task">
        	<thead>
                <tr>
                    <th>Description</th>
                    <th>Type de t&acirc;che</th>
                    <th>D&eacute;placement</th>
                    <th>Tarif</th>
                    <th>Intervenant</th>
                    <th>Date d'&eacute;ch&eacute;ance</th>
                    <th>Termin&eacute;e ?</th>
                    <th>Temps de travail</th>
                    <th width="5%">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            	<tr>
                	<td><input type="text" class="styled" name="task[1][nom]" id="name_task" style="width:100%"></td>
                    <td>
                    	<div class="styled-select-inline" style="width:100%">
                    	<select class="styled-inline" name="task[1][type]">
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
                    <td>
                    	<div class="styled-select-inline" style="width:100%">
                    	<select name="task[1][deplacement]" id="deplacement" class="styled-inline">
                          <option value="0" selected>Aucun</option>
                          <option value="1">- 20km</option>
                          <option value="2">20 - 40km</option>
                          <option value="3">40+ km</option>
                          <option value="4">Foyer Namurois</option>
                        </select>
                        </div>
                    </td>
                    <td>
                    	<div class="styled-select-inline" style="width:100%">
                    	<select name="task[1][tarif]" id="tarif_special" class="styled-inline">
                          <option value="1" selected>Non</option>
                          <option value="2">19h+</option>
                          <option value="3">Dimanche / F&eacute;ri&eacute; / 22h+</option>
                          <option value="4">Tarif r&eacute;duit</option>
                          <option value="5">Foyer Namurois</option>
													<option value="6">CDMN</option>
                        </select>
                        </div>
                    </td>
                    <td>
                    	<div class="styled-select-inline" style="width:100%">
                    	<select name="task[1][user]" id="user_task" class="styled-inline">
							<?php
                            $sql1 = "SELECT login, num";
                            $sql1 .= " FROM ".$tblpref."user";
							$resql=mysql_query($sql1);
							while ($obj = mysql_fetch_object($resql)) {
								echo '<option value="'.$obj->num.'">'.$obj->login.'</option>';
							}
                            ?>
                        </select>
                        </div>
                    </td>
                    <td>
                    	<input type="text" size="9" id="date_due_task" name="task[1][date_due]" value="<?php echo date('d-m-Y', strtotime("+ 1 day"));?>" class="styled datepicker" style="width:50%">
                        &agrave; <input type="text" id="hour_due_task" name="task[1][heure_due]" size="1" value="<?php echo date('H');?>" class="styled" style="width:15%"/>
                        &nbsp;:  <input type="text" id="min_due_task" name="task[1][min_due]" size="1" value="<?php echo date('i');?>" class="styled" style="width:15%"/>
                    </td>
                    <td><input type="checkbox" name="task[1][fin]" value="end" id="task_terminate_1" onchange="check_end(1)"></td>
                    <td id="time1"></td>
                    <td></td>
                </tr>
            </tbody>
            <tbody id="added_task">
            </tbody>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="button" onclick="add_line_task()"><i class="button__icon fa fa-plus"></i><span>Ajouter une t&acirc;che</span></button>
        </div>
        <div class="portion_subtitle"><i class="fa fa-check"></i> Finalisation</div>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit" name="submit_new_task" id="submit_new_task"><i class="button__icon fa fa-check"></i><span>Valider</span></button>
            <button class="button_act button--shikoba button--border-thin medium" type="submit" name="submit_close_task" id="submit_close_task"><i class="button__icon fa fa-check"></i><span>Valider et Cl&ocirc;turer</span></button>
        </div>
        <input type="hidden" id="nbr_lines" value="1">
        </form>
	</div>
</div>
<?php
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
