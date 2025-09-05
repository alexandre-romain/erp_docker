<?php
$res=0;
include("../../main.inc.php");

llxHeader('','Interventions Client en Cours','');

$form=new Form($db);

?>

<head>

		<style type="text/css" media="screen">
			@import "../include/css/demo_table_jui.css";
			@import "../include/css/jquery-ui-1.7.2.custom.css";	
		</style>
    
    <!-- Datatables Editable plugin -->
    	<script type="text/javascript" src="../include/js/autocomplete.js"></script>
    	<script type="text/javascript" src="../include/js/jquery-1.10.0.js"></script>
		<script type="text/javascript" src="../include/js/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="../include/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="../include/js/jquery.dataTables.editable.js"></script>
		<script type="text/javascript" src="../include/js/jquery.jeditable.js"></script>
        <script type="text/javascript" src="../include/js/jquery-ui.js"></script>
        <script type="text/javascript" src="../include/js/jquery.validate.js"></script>
		<script type="text/javascript" src="../include/js/datepicker.js"></script>
        
    <!-- Auto-Complete -->
		
	<!-- Liste Intervention -->
		<script type="text/javascript" charset="utf-8">
        $(document).ready( function () {
        <!--var id = -1;//simulation of id -->
        $('#tableinter').dataTable({ 
		bJQueryUI: true,
        "sPaginationType": "full_numbers"
        }).makeEditable({
        sUpdateURL:"../include/ajax/UpdateInter.php",
        sAddURL: "../include/ajax/AddInter.php",
        sAddHttpMethod: "GET",
        sDeleteHttpMethod: "GET",
        sDeleteURL: "../include/ajax/DeleteInter.php",
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
			//Client
			{
				cssclass: "shortfield", //possibilités dans validate ligne 747
				sName: "fk_soc",
				indicator: 'Enregistrement ...',
				tooltip: 'Double clic pour modifier la description',
				type: 'text' //possibilités : text, textarea ou select
				
			},
			//Date début
			{
				cssclass: "shortfield", //possibilités dans validate ligne 747
				sName: "date_debut",
				indicator: 'Enregistrement ...',
				tooltip: 'Double clic pour modifier la description',
				type: 'text' //possibilités : text, textarea ou select
				
			},
			//Date fin
			{
				cssclass: "shortfield", //possibilités dans validate ligne 747
				sName: "date_fin",
				indicator: 'Enregistrement ...',
				tooltip: 'Double clic pour modifier la description',
				type: 'text' //possibilités : text, textarea ou select
				
			},
			//Responsable Intervention
			{
				sName: "fk_user",
				indicator: 'Enregistrement ...',
				tooltip: 'Double clic pour modifier',
				loadtext: 'loading...',
				type: 'select',
				onblur: 'submit',
				<?php
					
					$sql0 = "SELECT p.label as plabel, p.rowid as prowid";
					$sql0 .= " FROM ".MAIN_DB_PREFIX."product as p";
					$sql0 .= " LEFT JOIN ".MAIN_DB_PREFIX."categorie_product as cp ON p.rowid = cp.fk_product ";
					$sql0 .= " WHERE cp.fk_categorie = '26'";
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
											echo "'".$obj0->prowid."':'".$obj0->plabel."'";
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
			//Etat
			{
				sName: "etat",
				indicator: 'Enregistrement ...',
				tooltip: 'Double clic pour modifier',
				loadtext: 'loading...',
				type: 'select',
				onblur: 'submit',
				data: "{'En Cours':'En Cours','Cloture':'Cloture'}"
				
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
        
        } );
        </script>
</head>
<body>

    <!--on place le bouton ajouter -->
    <form id="formAddNewRow" action="#" title="Ajouter un emplacement" style="width:100px;min-width:100px">
            <br /><br />
            <label for="search_soc"><i>Recherche Client (3carac min.)</i></label><br />
			<input type="text" size="25" value="" id="search_soc" name="search_soc" onKeyUp="javascript:autosuggest('asocinter')" autocomplete="off" /><!--  champ texte à analyser pour les suggestions -->
            <br /><br />
            <label for="soc">Client</label><br />
            <select id="soc" name ="soc" rel="1" >
           	</select>
            <br /><br />
            <label for="name">Nom de l'intervention</label><br />
      		<input type="text" size="25" name="name" id="name" class="required shortfield" rel="0" autocomplete="off"/>
            <br /><br />
            <label for="date_debut">Date de début</label><br />
      		<input type="text" size="25" name="date_debut" id="date_debut" class="required shortfield" rel="2" autocomplete="off" value="<?php echo date("d-m-Y"); ?>"/>
            <br /><br />
            <label for="date_fin">Date de fin</label><br />
      		<input type="text" size="25" name="date_fin" id="date_fin" class="required shortfield" rel="3" autocomplete="off" value="<?php echo date("d-m-Y"); ?>"/>
            <br /><br />
            <label for="user">Responsable Inter</label><br />
      		<select name="user" id="user" rel="4">
					<?php
					
					$sql1 = "SELECT login, rowid ";
					$sql1 .= " FROM ".MAIN_DB_PREFIX."user";
					$sql1 .= " WHERE rowid>1";
					//$sql1 .= " ORDER by p.rowid";
						
						$resql=$db->query($sql1);
						if ($resql)
						{
							$num = $db->num_rows($resql);
							$i = 0;
							if ($num)
							{
								while ($i < $num)
								{
											$obj = $db->fetch_object($resql);						
											if ($obj)
											{
												echo '<option value="'.$obj->rowid.'">'.$obj->login.'</option>';
												// You can use here results
												
											}	
									$i++;
								}
							}
						}
					
					?>
            </select>
            <br /><br />
            <label for="descr">Description</label><br />
      		<input type="text" size="25" name="descr" id="descr" class="longfield" autocomplete="off" rel="5"/>
            <br /><br />
			<button id="btnAddNewRowOk1" value="Ok">Ajouter</button>
			<button id="btnAddNewRowCancel1" value="Cancel">Supprimer</button>
            
    </form>
<!-- fin du bouton ajouter  -->

<!-- On descend la liste d'une ligne pour centrage  -->
<br/>
<!-- On descend la liste d'une ligne pour centrage  -->
<div id="types" class="art-postheader" align="center">Liste des Interventions Clients (Etat = En Cours)</div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tableinter">
	<thead>
		<tr>
			<th>Nom</th>
			<th>Client</th>
            <th>Date de d&eacute;but</th>
            <th>Date de fin estimée</th>
            <th>Responsable intervention</th>
            <th>Etat</th>
		</tr>
	</thead>

	<tbody>
	<button id="btnAddNewRow1" >Ajouter ...</button>
	<button id="btnDeleteRow1" >Supprimer</button>       
    <!-- création du contenu de la table sur base des enregistrements db -->
    <?php
	
	// On récupère les hébergements actifs
	$sql = "SELECT i.rowid as irowid, i.nom as inom, i.date_debut as idate_debut, i.date_fin as idate_fin, i.etat ietat, u.login ulogin, s.nom as snom ";
    $sql .= " FROM ".MAIN_DB_PREFIX."inter as i";
	$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."societe as s ON s.rowid=i.fk_soc";
	$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."user as u ON u.rowid=i.fk_createur";
	$sql .= " WHERE i.etat='en cours'";
    $sql .= " ORDER by i.fk_soc";
	
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
							echo '<tr class="odd_gradeX" id="'.$obj->irowid.'">';						
							if ($obj)
							{
								//On transforme les dates
								$dateinter = $obj->idate_debut;
								$datetemp = explode('-',$dateinter);
								$annee = $datetemp[0];
								$mois = $datetemp[1];
								$jour = $datetemp[2];
								$datecorrect=$jour."/".$mois."/".$annee;
								
								$dateinter2 = $obj->idate_fin;
								$datetemp2 = explode('-',$dateinter2);
								$annee2 = $datetemp2[0];
								$mois2 = $datetemp2[1];
								$jour2 = $datetemp2[2];
								$datecorrect2=$jour2."/".$mois2."/".$annee2;
								// You can use here results
								print '<td align="center"><a href="./ficheinter_inter.php?rowid='.$obj->irowid.'">'.utf8_decode($obj->inom).'</a></td>';
								print '<td align="center">'.$obj->snom.'</td>';
								print '<td align="center">'.$datecorrect.'</td>';
								print '<td align="center">'.$datecorrect2.'</td>';
								print '<td align="center">'.$obj->ulogin.'</td>';
								print '<td align="center">'.$obj->ietat.'</td>';
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

llxFooter();
$db->close();
?>