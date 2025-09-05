<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/".$lang.".php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");			
include_once("include/head.php");
//Récupération du header et du footer + variable déclarée dans ttes pages doli (à test)
require_once("./menu.php");
//recuperation de l'id Intervention
$rowid = addslashes($_REQUEST['rowid']);
//Déclaraton de la variable menu et passage du rowid
$menu = affiche_menu($rowid);
//Requète de récupération des infos nécessaire pour populer le tableau d'inter
$sql1 = "SELECT i.nom as inom, i.descr as idescr, i.date_debut as idate_debut, i.date_fin as idate_fin, c.nom as snom, u.login as ulogin, i.fk_soc as ifk_soc ";
$sql1 .= " FROM ".$tblpref."inter as i";
$sql1 .= " LEFT JOIN ".$tblpref."user as u ON u.num = i.fk_createur ";
$sql1 .= " LEFT JOIN ".$tblpref."client as c ON c.num_client = i.fk_soc ";
$sql1 .= " WHERE i.rowid='$rowid'";
$reqsql= mysql_query($sql1);
$result= mysql_fetch_object($reqsql);
//Convertion des dates en forme EU
$dateinter = explode ('-', $result->idate_debut);
$annee = $dateinter[0];
$mois = $dateinter[1];
$jour = $dateinter[2];
$datedebutcorrect = $jour.'/'.$mois.'/'.$annee;

$dateinter = explode ('-', $result->idate_fin);
$annee = $dateinter[0];
$mois = $dateinter[1];
$jour = $dateinter[2];
$datefincorrect = $jour.'/'.$mois.'/'.$annee;
?>
<!---Import de la feuille de style css des onglets + Datatables-->
<head>
<?php
//INSERTION DU MENU "ONGLETS"
echo $menu;
?>

<head>

		<style type="text/css" media="screen">
			@import "include/css/bouton_datatables.css";
			@import "include/css/demo_table_jui.css";
			@import "include/css/jquery-ui-1.7.2.custom.css";
			@import "include/css/onglets_inter.css";
			@import "include/css/actionboutons.css";
			@import "include/css/interventions.css";
		</style>
    
    <!-- Datatables Editable plugin -->
    	<script type="text/javascript" src="include/js/autocomplete.js"></script>
    	<script type="text/javascript" src="include/js/jquery-1.10.0.js"></script>
		<script type="text/javascript" src="include/js/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="include/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="include/js/jquery.dataTables.editable.js"></script>
		<script type="text/javascript" src="include/js/jquery.jeditable.js"></script>
        <script type="text/javascript" src="include/js/jquery-ui.js"></script>
        <script type="text/javascript" src="include/js/jquery.validate.js"></script>
		<script type="text/javascript" src="include/js/datepicker.js"></script>
        
    <!-- Auto-Complete -->
	<?php
	//CREATION DU TABLEAU INFO INTER
	print '</br>';
	print '</br>';
	print '<table class="info">';
	print "<tr><td class='intitule'>Client</td><td colspan='3' class='contenu'>".$result->snom."</td></tr>";
	print "<tr><td class='intitule'>Nom de l'intervention</td><td colspan='3' class='contenu'>".stripslashes($result->inom)."</td></tr>";
	print "<tr><td class='intitule'>Date de d&eacute;but</td><td class='contenu1'>".$datedebutcorrect."</td><td class='intitule'>Date de fin pr&eacute;vue</td><td class='contenu'>".$datefincorrect."</td></tr>";
	print "</table>";
	?>
	<!-- Liste Intervention -->
		<!-- DT antivirus -->
		<script type="text/javascript" charset="utf-8">		
        $(document).ready( function () {
        <!--var id = -1;//simulation of id -->
		// select everything when editing field in focus		
        $('#antivirus').dataTable({
		bJQueryUI: true,
        "sPaginationType": "full_numbers"
        }).makeEditable({
        sUpdateURL:"include/ajax/UpdateTacheFiche.php",
        sAddURL: "include/ajax/AddTacheFiche.php",
        sAddHttpMethod: "GET",
        sDeleteHttpMethod: "GET",
        sDeleteURL: "include/ajax/DeleteTacheFiche.php",
		sAddNewRowButtonId: "btnAddNewRow1",
        sDeleteRowButtonId: "btnDeleteRow1",		
		sAddNewRowOkButtonId: "btnAddNewRowOk1",
        sAddNewRowCancelButtonId: "btnAddNewRowCancel1",		
        "aoColumns": 
		[
		 //liste des colonnes avec leur comportement respectif + eventuellement style via CSS
        	
			//Nom
			{
				cssclass: "shortfield", //possibilités dans validate ligne 747
				sName: "nom",
				indicator: 'Enregistrement ...',
				tooltip: 'Double clic pour modifier la description',
				type: 'text' //possibilités : text, textarea ou select
			},
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
			//Add Time
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
					$sql0 = "SELECT u.num, u.login";
					$sql0 .= " FROM ".$tblpref."user as u";
					//$sql1 .= " ORDER by p.rowid";
						
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
											echo "'".$obj0->num."':'".$obj0->login."'";
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
    <form id="formAddNewRow" action="#" title="Ajouter un emplacement" style="width:100px;min-width:100px;background-color:#FFF">
            <br /><br />
           <label for="nom">Nom</label><br />
      		<input type="text" size="25" name="nom" id="nom" class="required shortfield" rel="0"/>
            <br /><br />
            <label for="descr">Description</label><br />
      		<input type="text" size="25" name="descr" id="descr" rel="3"/>
            <br/><br/>
            <label for="date_debut">Date de d&eacute;but</label><br />
      		<input type="text" size="25" name="date_debut" id="date_debut" class="required shortfield" rel="1" autocomplete="off" value="<?php echo date("d-m-Y"); ?>"/>   
      		<br /><br />
            <label for="date_fin">Date de fin (estimation)</label><br />
            <input type="text" size="25" name="date_fin" id="date_fin" class="required shortfield" rel="2" autocomplete="off" value="<?php echo date("d-m-Y"); ?>"/>
            <br /><br />
            <label for="user">Executant</label><br />
            <select name="user" id="user" class="form" rel="5">
            <?php
            $sql1 = "SELECT login, num";
            $sql1 .= " FROM ".$tblpref."user";
            //$sql1 .= " ORDER by p.rowid";
                
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
            <br /><br />
            <div style="color:#F00">N'oubliez pas d'ajouter le mat&eacute;riel n&eacute;cessaire &agrave; la t&acirc;che !</div>
            <br /><br />
            <input type="hidden" name="fk_inter" id="fk_inter" value="<?php echo $rowid;?>" rel="4">
            <input type="hidden" rel="6">
            <input type="hidden" rel="7">
			<button id="btnAddNewRowOk1" value="Ok">Ajouter</button>
			<button id="btnAddNewRowCancel1" value="Cancel">Supprimer</button>
            
    </form>
<!-- fin du bouton ajouter  -->

<!-- On descend la liste d'une ligne pour centrage  -->
<br/>
<!-- On descend la liste d'une ligne pour centrage  -->
<div id="types" class="art-postheader" align="center"><h1>Liste des T&acirc;ches li&eacute;es &agrave; l'intervention "<?php echo stripslashes($result->inom); ?>"</h1></div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="antivirus">
	<thead>
		<tr>
			<th>Nom</th>
			<th>Date de d&eacute;but</th>
            <th>Date de fin</th>
            <th>Executant</th>
            <th>Temps consomm&eacute;</th>
            <th>Ajouter du temps de travail</th>
            <th>% d'avancement</th>
            <th>Etat</th>
		</tr>
	</thead>

	<tbody>
	<button id="btnAddNewRow1" >Ajouter ...</button>
	<button id="btnDeleteRow1" >Supprimer</button>       
    <!-- création du contenu de la table sur base des enregistrements db -->
    <?php
	$sql = "SELECT it.rowid as itrowid, it.name as itname, it.time_spent as ittime_spent, it.date_debut as itdate_debut, it.date_fin as itdate_fin, it.completition as itcompletition, it.etat as itetat, u.login as ulogin ";
    $sql .= " FROM ".$tblpref."inter_tache as it";
	$sql .= " LEFT JOIN ".$tblpref."user as u ON u.num=it.fk_user";
    $sql .= " WHERE it.fk_inter='$rowid'";
    $sql .= " ORDER by it.date_debut";
	
	$resql=mysql_query($sql);
		if ($resql)
		{
			$num = mysql_num_rows($resql);
			$i = 0;
			if ($num)
			{
				while ($i < $num)
				{
					
							$obj = mysql_fetch_object($resql);
							echo '<tr class="odd_gradeX" id="'.$obj->itrowid.'">';
							if ($obj)
							{
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
								print '<td align="center">'.$datecorrect.'</td>';
								print '<td align="center">'.$datecorrect2.'</td>';
								print '<td align="center">'.$obj->ulogin.'</td>';
								print '<td align="center">'.$obj->ittime_spent.'</td>';
								?>
                                <td>
                                <form id="add_time_spent" action="include/ajax/AddTime.php" title="Ajouter du temps de travail">
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
                                <input type="hidden" name="place" id="place" value="fiche_inter"/>
                                <input type="hidden" name="fk_inter" id="fk_inter" value="<?php echo $rowid;?>">
                                <input type="submit" value="Valider" name="submit_time_spent" id="submit_time_spent"/>
                                </form>
                                </td>
                                <?php
								print '<td align="center">'.$obj->itcompletition.'%</td>';
								print '<td align="center">'.$obj->itetat.'</td>';
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