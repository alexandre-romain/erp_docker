<?php
//Connexion BDD
include("../include/config/connexion.php");
//Récupération du header et du footer + variable déclarée dans ttes pages doli (à test)
include("../../main.inc.php");
$res=0;
llxHeader('','Mes T&acirc;ches','');
?>
<!---Import de la feuille de style css des onglets + Datatables-->
<head>
<style type="text/css" media="screen">
			@import "../include/css/demo_table_jui.css";
			@import "../include/css/jquery-ui-1.7.2.custom.css";	
</style>

<!--Insertion du DataTables-->
<!-- Datatables Editable plugin -->
    	<script type="text/javascript" src="../include/js/autocomplete.js"></script>
		<script type="text/javascript" src="../include/js/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="../include/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="../include/js/jquery.dataTables.editable.js"></script>
		<script type="text/javascript" src="../include/js/jquery.jeditable.js"></script>
        <script type="text/javascript" src="../include/js/jquery-ui.js"></script>
        <script type="text/javascript" src="../include/js/jquery.validate.js"></script>
        <script type="text/javascript" src="../include/js/datepicker.js"></script>
    <!-- Auto-Complete -->	
	<!-- DT antivirus -->
		<script type="text/javascript" charset="utf-8">		
        $(document).ready( function () {
        <!--var id = -1;//simulation of id -->
		// select everything when editing field in focus		
        $('#inter_task').dataTable({
		bJQueryUI: true,
        "sPaginationType": "full_numbers"
        }).makeEditable({
        sUpdateURL:"../include/ajax/UpdateTache.php",
        sAddURL: "../include/ajax/AddTache.php",
        sAddHttpMethod: "GET",
        sDeleteHttpMethod: "GET",
        sDeleteURL: "../include/ajax/DeleteTache.php",
		sAddNewRowButtonId: "btnAddNewRow1",
        sDeleteRowButtonId: "btnDeleteRow1",		
		sAddNewRowOkButtonId: "btnAddNewRowOk1",
        sAddNewRowCancelButtonId: "btnAddNewRowCancel1",		
        "aoColumns": 
		[
		 //liste des colonnes avec leur comportement respectif + eventuellement style via CSS
        	
			//Nom
			null,
			//Fk_inter
			{
				sName: "fk_inter",
				indicator: 'Enregistrement ...',
				tooltip: 'Double clic pour modifier',
				loadtext: 'loading...',
				type: 'select',
				onblur: 'submit',
				<?php
					
					$sql0 = "SELECT i.rowid, i.nom";
					$sql0 .= " FROM ".MAIN_DB_PREFIX."inter as i";
					$sql0 .= " WHERE i.etat='en cours'";
					//$sql1 .= " ORDER by p.rowid";
						
					$resql0=$db->query($sql0);
					echo 'data: "{';
					if ($resql0)
					{
						$num0 = $db->num_rows($resql0);
						$i0 = 0;
						if ($num0)
						{
							while ($i0 < $num0)
							{
										$obj0 = $db->fetch_object($resql0);						
										if ($obj0)
										{
											echo "'".$obj0->rowid."':'".$obj0->nom."'";
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
			//Fk_soc
			null,
			//Date Debut
			{
				cssclass: "shortfield", //possibilités dans validate ligne 747
				sName: "date_debut",
				indicator: 'Enregistrement ...',
				tooltip: 'Double clic pour modifier la description',
				type: 'text' //possibilités : text, textarea ou select
			},
			//Date Fin
			{
				cssclass: "shortfield", //possibilités dans validate ligne 747
				sName: "date_fin",
				className: "showCalendar",
				indicator: 'Enregistrement ...',
				tooltip: 'Double clic pour modifier la description',
				type: 'text' //possibilités : text, textarea ou select
			},
			//Temps Consommé
			null,
			//Ajout de temps
			null,
			//% d'avancement
			{
				sName: "completition",
				indicator: 'Enregistrement ...',
				tooltip: 'Double clic pour modifier',
				loadtext: 'loading...',
				type: 'select',
				onblur: 'submit',
				data: "{'5':'5','10':'10','15':'15','20':'20','25':'25','30':'30','35':'35','40':'40','45':'45','50':'50','55':'55','60':'60','65':'65','70':'70','75':'75','80':'80','85':'85','90':'90','95':'95','100':'100'}"	
			},
			//Etat
			{
				sName: "etat",
				indicator: 'Enregistrement ...',
				tooltip: 'Double clic pour modifier',
				loadtext: 'loading...',
				type: 'select',
				onblur: 'submit',
				data: "{'En Cours':'En Cours','Cloture':'Cloture'}"
				
			},
			//Responsable
			{
				sName: "fk_user1",
				indicator: 'Enregistrement ...',
				tooltip: 'Double clic pour modifier',
				loadtext: 'loading...',
				type: 'select',
				onblur: 'submit',
				<?php
					$sql0 = "SELECT u.rowid, u.login";
					$sql0 .= " FROM ".MAIN_DB_PREFIX."user as u";
					$sql0 .= " WHERE u.rowid > 1";
					//$sql1 .= " ORDER by p.rowid";
						
					$resql0=$db->query($sql0);
					echo 'data: "{';
					if ($resql0)
					{
						$num0 = $db->num_rows($resql0);
						$i0 = 0;
						if ($num0)
						{
							while ($i0 < $num0)
							{
										$obj0 = $db->fetch_object($resql0);						
										if ($obj0)
										{
											echo "'".$obj0->rowid."':'".$obj0->login."'";
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
			}
		],
        oAddNewRowButtonOptions: {	label: "Ajouter...",
        icons: {primary:'ui-icon-plus'} 
        },
        oDeleteRowButtonOptions: {	label: "Supprimer", 
        icons: {primary:'ui-icon-trash'}
        },
        oAddNewRowFormOptions: { 	
        title: 'Ajouter une T&acirc;che',
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

    <!--on place le bouton ajouter -->
    <form id="formAddNewRow" action="#" title="Ajouter un emplacement" style="width:100px;min-width:100px">
            <br />
            <br />
           
       
            <label for="nom">Nom</label><br />
      		<input type="text" size="25" name="nom" id="nom" class="required" rel="0"/>
            <br /><br />
            <label for="descr">Description</label><br />
      		<input type="textarea" size="25" name="descr" id="descr" rel="7"/>
            <br /><br />
            <label for="search_inter"><i>Recherche Intervention</i></label><br />
            <input type="text" size="25" id="search_inter" name="search_inter" onKeyUp="javascript:autosuggest('inter')"  autocomplete="off" rel="8"/><!--  champ texte à analyser pour les suggestions -->
            <br />
            <label for="fk_inter">Intervention</label><br />
            <select id="fk_inter" name ="fk_inter" rel="1">
           	</select>
            <br/><br/>
            <label for="date_debut">Date de d&eacute;but</label><br />
      		<input type="text" size="25" name="date_debut" id="date_debut" class="required shortfield" rel="2" autocomplete="off" value="<?php echo date("d-m-Y"); ?>"/>   
      		<br /><br />
            <label for="date_fin">Date de fin (estimation)</label><br />
            <input type="text" size="25" name="date_fin" id="date_fin" class="required shortfield" rel="3" autocomplete="off" value="<?php echo date("d-m-Y"); ?>"/>
            <br /><br />
            <label for="tech1">Technicien(s) en charge</label><br />
            <select name="tech1" id="tech1" rel="4"/>
            <option value="2">Alex</option>
            <option value="3">Chris</option>
            <option value="4">Corentin</option>
            <option value="5">Jeremy</option>
            <option value="6">Renaud</option>
            </select>
            <select name="tech2" id="tech2" rel="5"/>
            <option value=""></option>
            <option value="2">Alex</option>
            <option value="3">Chris</option>
            <option value="4">Corentin</option>
            <option value="5">Jeremy</option>
            <option value="6">Renaud</option>
            </select>
            <select name="tech3" id="tech3" rel="6"/>
            <option value=""></option>
            <option value="2">Alex</option>
            <option value="3">Chris</option>
            <option value="4">Corentin</option>
            <option value="5">Jeremy</option>
            <option value="6">Renaud</option>
            </select>
            <br /><br />
            <input type="hidden" rel="9" />
			<button id="btnAddNewRowOk1" value="Ok">Ajouter</button>
			<button id="btnAddNewRowCancel1" value="Cancel">Supprimer</button>
            
    </form>
<!-- fin du bouton ajouter  -->

<!-- On descend la liste d'une ligne pour centrage  -->
<br/>
<!-- On descend la liste d'une ligne pour centrage  -->
<div id="types" class="art-postheader" align="center">Liste de mes T&acirc;ches</div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="inter_task">
	<thead>
		<tr>
			<th>Nom</th>
            <th>Intervention</th>
            <th>Client</th>
			<th>Date de d&eacute;but</th>
            <th>Date de fin</th>
            <th>Temps consommé</th>
            <th>Ajouter du temps de travail</th>
            <th>% d'avancement</th>
            <th>Etat</th>
            <th>Personne(s) en charge</th>
		</tr>
	</thead>

	<tbody>
	<button id="btnAddNewRow1" >Ajouter ...</button>
	<button id="btnDeleteRow1" >Supprimer</button>       
    <!-- création du contenu de la table sur base des enregistrements db -->
    <?php
	$sql = "SELECT it.rowid as itrowid, it.name as itname, it.time_spent as ittime_spent, it.date_debut as itdate_debut, it.date_fin as itdate_fin, it.completition as itcompletition, it.etat as itetat, it.fk_user1, it.fk_user2, it.fk_user3, it.fk_user4, it.fk_user5, i.nom as inom, s.nom as snom";
    $sql .= " FROM ".$tblref."inter_tache as it";
	$sql .= " LEFT JOIN ".$tblref."inter as i ON i.rowid=it.fk_inter";
	$sql .= " LEFT JOIN ".$tblref."societe as s ON s.rowid=i.fk_soc";
	$sql .= " WHERE it.fk_user1='$user->id' OR it.fk_user2='$user->id' OR it.fk_user3='$user->id'";
    $sql .= " ORDER BY it.date_debut DESC";
	
	
	
	$resql=$db->query($sql);
		if ($resql)
		{
			$num = $db->num_rows($resql);
			$i = 0;
			if ($num)
			{
				while ($i < $num)
				{
					
							$obj = $db->fetch_object($resql);
							echo '<tr class="odd_gradeX" id="'.$obj->itrowid.'">';
							if ($obj)
							{
								// Requête pour récupérer les noms des personnes en charge
								//Récupération des 5rowid user
								$id1=$obj->fk_user1;
								$id2=$obj->fk_user2;
								$id3=$obj->fk_user3;
								$id4=$obj->fk_user4;
								$id5=$obj->fk_user5;
								//Requêtes des logins
								$sqllogin = "SELECT u.login as ulogin";
								$sqllogin .=" FROM ".$tblref."user as u";
								$sqllogin .=" WHERE u.rowid='$id1'";
								$querylogin= mysql_query($sqllogin);
								$objlogin= mysql_fetch_object($querylogin);
								
								$sqllogin2 = "SELECT u.login as ulogin";
								$sqllogin2 .=" FROM ".$tblref."user as u";
								$sqllogin2 .=" WHERE u.rowid='$id2'";
								$querylogin2= mysql_query($sqllogin2);
								$objlogin2= mysql_fetch_object($querylogin2);
								
								$sqllogin3 = "SELECT u.login as ulogin";
								$sqllogin3 .=" FROM ".$tblref."user as u";
								$sqllogin3 .=" WHERE u.rowid='$id3'";
								$querylogin3= mysql_query($sqllogin3);
								$objlogin3= mysql_fetch_object($querylogin3);
								
								$sqllogin4 = "SELECT u.login as ulogin";
								$sqllogin4 .=" FROM ".$tblref."user as u";
								$sqllogin4 .=" WHERE u.rowid='$id4'";
								$querylogin4= mysql_query($sqllogin4);
								$objlogin4= mysql_fetch_object($querylogin4);
								
								$sqllogin5 = "SELECT u.login as ulogin";
								$sqllogin5 .=" FROM ".$tblref."user as u";
								$sqllogin5 .=" WHERE u.rowid='$id5'";
								$querylogin5= mysql_query($sqllogin5);
								$objlogin5= mysql_fetch_object($querylogin5);
								//On transforme les dates
								$dateinter = $obj->itdate_debut;
								$datetemp = explode('-',$dateinter);
								$annee = $datetemp[0];
								$mois = $datetemp[1];
								$jour = $datetemp[2];
								$datecorrect=$jour."/".$mois."/".$annee;
								
								$dateinter2 = $obj->itdate_fin;
								$datetemp2 = explode('-',$dateinter2);
								$annee2 = $datetemp2[0];
								$mois2 = $datetemp2[1];
								$jour2 = $datetemp2[2];
								$datecorrect2=$jour2."/".$mois2."/".$annee2;
								// You can use here results
								print '<td align="center"><a href="./fichetask_task.php?rowid='.$obj->itrowid.'">'.utf8_decode($obj->itname).'</a></td>';
								print '<td align="center">'.utf8_decode($obj->inom).'</td>';
								print '<td align="center">'.$obj->snom.'</td>';
								print '<td align="center">'.$datecorrect.'</td>';
								print '<td align="center">'.$datecorrect2.'</td>';
								print '<td align="center">'.$obj->ittime_spent.'</td>';
								?>
                                <td>
                                <form id="add_time_spent" action="../include/ajax/AddTime.php" title="Ajouter du temps de travail">
                                <select name="hours" id="hours">
                                <option value=0>0</option>
                                <option value=1>1</option>
                                <option value=2>2</option>
                                <option value=3>3</option>
                                <option value=4>4</option>
                                <option value=5>5</option>
                                <option value=6>6</option>
                                <option value=7>7</option>
                                <option value=8>8</option>
                                <option value=9>9</option>
                                </select> H
                                
                                <select name="min" id="min">
                                <option value=0>0</option>
                                <option value=5>5</option>
                                <option value=10>10</option>
                                <option value=15>15</option>
                                <option value=20>20</option>
                                <option value=25>25</option>
                                <option value=30>30</option>
                                <option value=35>35</option>
                                <option value=40>40</option>
                                <option value=45>45</option>
                                <option value=50>50</option>
                                <option value=55>55</option>
                                </select> min
                                <input type="hidden" name="time_spent" id="time_spent" value="<?php echo $obj->ittime_spent; ?>"/>
                                <input type="hidden" name="fk_task" id="fk_task" value="<?php echo $obj->itrowid; ?>"/>
                                <input type="hidden" name="place" id="place" value="list"/>
                                <input type="submit" value="Valider" name="submit_time_spent" id="submit_time_spent"/>
                                </form>
                                </td>
                                <?php
								print '<td align="center">'.$obj->itcompletition.'%</td>';
								print '<td align="center">'.$obj->itetat.'</td>';
								print '<td align="center">'.$objlogin->ulogin.' '.$objlogin2->ulogin.' '.$objlogin3->ulogin.' '.$objlogin4->ulogin.' '.$objlogin5->ulogin.'</td>';
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





<?php
print '</table>';

//Footer
llxFooter();
$db->close();
?>