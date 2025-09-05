<?php 
require_once("include/verif.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");			
include_once("include/head.php");
//Récupération de l'utilisiteur accédant à la page
$user = $_SERVER[PHP_AUTH_USER];
?>

<head>

		<style type="text/css" media="screen">
			@import "include/css/bouton_datatables.css";
			@import "include/css/demo_table_jui.css";
			@import "include/css/jquery-ui-1.7.2.custom.css";

		</style>
    
    <!-- Datatables Editable plugin -->
    	<script type="text/javascript" src="include/js/autocomplete.js"></script>
    	<script type="text/javascript" src="include/js/jquery-1.10.0.js"></script>
		<script type="text/javascript" src="include/js/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="include/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="include/js/jquery.dataTables.editable.redirect.js"></script>
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
        "sPaginationType": "full_numbers"
        }).makeEditable({
        sUpdateURL:"include/ajax/UpdateInter.php",
        sAddURL: "include/ajax/AddInter.php",
        sAddHttpMethod: "GET",
        sDeleteHttpMethod: "GET",
        sDeleteURL: "include/ajax/DeleteInter.php",
		sAddNewRowButtonId: "btnAddNewRow1",
        sDeleteRowButtonId: "btnDeleteRow1",		
		sAddNewRowOkButtonId: "btnAddNewRowOk1",
        sAddNewRowCancelButtonId: "btnAddNewRowCancel1",		
        "aoColumns": 
		[
		 //liste des colonnes avec leur comportement respectif + eventuellement style via CSS
        	
			//Nom
			null,
			//Client
			{
				sName: "fk_soc",
				indicator: 'Enregistrement ...',
				tooltip: 'Double clic pour modifier',
				loadtext: 'loading...',
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
		<?php
		if ($user == 'alex' || $user == 'christophe') {
		?>
			//Responsable Intervention
			{
				sName: "fk_user",
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
			},
			//Responsable2 Intervention
			{
				sName: "fk_user",
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
					echo "'NULL':'',";
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
			},
			//Responsable3 Intervention
			{
				sName: "fk_user",
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
					echo "'NULL':'',";
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
			},
		<?php
		}
		else {
		?>
			//USER1
			null,
			//USER2
			null,
			//USER3
			null,
		<?php
		}
		?>
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
<form id="formAddNewRow" action="#" title="Ajouter un emplacement" style="width:100px;min-width:100px;background-color:#FFF;">
        <br /><br />
        <label for="search_soc"><i>Recherche Client (3carac min.)</i></label><br />
        <input type="text" size="25" value="" id="search_soc" name="search_soc" onKeyUp="javascript:autosuggest('asoc')" autocomplete="off" /><!--  champ texte à analyser pour les suggestions -->
        <br /><br />
        <label for="soc" style="text-align:left">Client</label><br />
        <select id="soc" name ="soc" rel="1" style="text-align:left" />
        <option value=""></option>
        </select>
        <br /><br />
        <label for="name">Nom de l'intervention</label><br />
        <input type="text" size="25" name="name" id="name" class="required shortfield" rel="0" autocomplete="off"/>
        <br /><br />
        <label for="date_debut">Date de d&eacute;but</label><br />
        <input type="text" size="25" name="date_debut" id="date_debut" class="required shortfield" rel="2" autocomplete="off" value="<?php echo date("d-m-Y"); ?>"/>
        <br /><br />
        <label for="date_fin">Date de fin</label><br />
        <input type="text" size="25" name="date_fin" id="date_fin" class="required shortfield" rel="3" autocomplete="off" value="<?php echo date("d-m-Y", strtotime("+ 1 day")); ?>"/>
        <br /><br />
        <label for="user">Responsables Inter</label><br />
        <select name="user" id="user" class="form" rel="4">
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
        <select name="user2" id="user2" class="form" rel="4">
        <option value=""></option>
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
        <select name="user3" id="user3" class="form">
        <option value=""></option>
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
        <label for="descr">Description</label><br />
        <textarea name="descr" id="descr" cols="25" rows="4" rel="5"></textarea>
        <br /><br />
        <label for="deplacement">D&eacute;placement</label><br />
        <select name="deplacement" id="deplacement">
          <option value="0">Aucun</option>
          <option value="1" selected>- 20km</option>
          <option value="2">20 - 40km</option>
          <option value="3">40+ km</option>
        </select>
        <br /><br />
        <label for="tarif_special">Tarif Sp&eacute;cial</label>
        <select name="tarif_special" id="tarif_special">
          <option value="1" selected>Non</option>
          <option value="2">19h+</option>
          <option value="3">Dimanche / F&eacute;ri&eacute; / 22h+</option>
          <option value="4">Tarif r&eacute;duit</option>
          <option value="5">Contrat Maintenance</option>
        </select>
        <br /><br />
        <input type="hidden" name="current_user" id="current_user" value="<?php echo $user;?>" />
        <button id="btnAddNewRowOk1" value="Ok" class="ButtonDataTable">Ajouter</button>
        <button id="btnAddNewRowCancel1" value="Cancel" class="ButtonDataTable">Supprimer</button>
        
</form>
<!-- fin du bouton ajouter  -->

<!-- On descend la liste d'une ligne pour centrage  -->
<br/>
<!-- On descend la liste d'une ligne pour centrage  -->
<div id="types" class="art-postheader" align="center"><h1>Liste des Interventions Clients</h1></div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tableinter">
	<thead>
		<tr>
			<th>Nom</th>
			<th>Client</th>
            <th>Date de d&eacute;but</th>
            <th>Date de fin estim&eacute;e</th>
            <th>Intervenant 1</th>
            <th>Intervenant 2</th>
            <th>Intervenant 3</th>                        
            <th>Etat</th>
            <th>Rapport d'intervention</th>
		</tr>
	</thead>

	<tbody>
	<button id="btnAddNewRow1" >Ajouter ...</button>
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
	$sql = "SELECT i.rowid as irowid, i.nom as inom, i.date_debut as idate_debut, i.date_fin as idate_fin, i.etat ietat, u.login ulogin, c.nom as cnom, i.fk_technician, i.fk_technician2 ";
    $sql .= " FROM ".$tblpref."inter as i";
	$sql .= " LEFT JOIN ".$tblpref."client as c ON c.num_client=i.fk_soc";
	$sql .= " LEFT JOIN ".$tblpref."user as u ON u.num=i.fk_createur";
    $sql .= " ORDER by i.date_debut";
	
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
							echo '<tr class="odd_gradeX" id="'.$obj->irowid.'">';						
							if ($obj)
							{
								if ($obj->fk_technician != '0') {
									$sql="SELECT login";
									$sql .=" FROM ".$tblpref."user";
									$sql .=" WHERE num=".$obj->fk_technician."";
									$req=mysql_query($sql);
									$results=mysql_fetch_object($req);
									$login1=$results->login;
								}
								else {
									$login1='N.A.';
								}
								
								if ($obj->fk_technician2 != '0') {
									$sql="SELECT login";
									$sql .=" FROM ".$tblpref."user";
									$sql .=" WHERE num=".$obj->fk_technician2."";
									$req=mysql_query($sql);
									$results=mysql_fetch_object($req);
									$login2=$results->login;
								}
								
								else {
									$login2='N.A.';
								}
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
								print '<td align="center"><a href="./ficheinter_inter.php?rowid='.$obj->irowid.'">'.utf8_decode(stripslashes($obj->inom)).'</a></td>';
								print '<td align="center">'.utf8_decode($obj->cnom).'</td>';
								print '<td align="center">'.$datecorrect.'</td>';
								print '<td align="center">'.$datecorrect2.'</td>';
								print '<td align="center">'.$obj->ulogin.'</td>';
								print '<td align="center">'.$login1.'</td>';
								print '<td align="center">'.$login2.'</td>';								
								print '<td align="center">'.$obj->ietat.'</td>';
								print '<td align="center"><a href="fpdf_rapports_inter.php?inter='.$obj->irowid.'">ICI</td>';
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

