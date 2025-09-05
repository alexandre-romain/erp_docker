<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$( "#show_create" ).hide();
	$( "#show_create" ).click(function() {
		$( "#create" ).show(500);
		$( "#show_create" ).hide();
		$( "#hide_create" ).show();
	});
	$( "#hide_create" ).click(function() {
		$( "#create" ).hide(500);
		$( "#show_create" ).show();
		$( "#hide_create" ).hide();
	});
});
$(function() {
	$( ".datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd/mm/yy" })
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
//FINHEAD
//Récupération des variables postées via "form_facture.php"
$date_deb=isset($_REQUEST['date_deb'])?$_REQUEST['date_deb']:"";
list($jour_deb, $mois_deb,$annee_deb) = preg_split('/\//', $date_deb, 3);
$date_fin=isset($_REQUEST['date_fin'])?$_REQUEST['date_fin']:"";
list($jour_f, $mois_f,$annee_f) = preg_split('/\//', $date_fin, 3);
$date_fact1=isset($_REQUEST['date_fact'])?$_REQUEST['date_fact']:"";
list($jour_fact, $mois_fact,$annee_fact) = preg_split('/\//', $date_fact1, 3);
$client=isset($_REQUEST['listeville'])?$_REQUEST['listeville']:"";
$debut = "$annee_deb-$mois_deb-$jour_deb" ;
$fin = "$annee_f-$mois_f-$jour_f" ;
$date_fact ="$annee_fact-$mois_fact-$jour_fact";

if($client=='null' || $date_deb==''|| $date_fin=='' || $date_fact=='' )
{
	$message= "<div class='message'>$lang_oubli_champ</div>";
	include('form_facture.php');
	exit;
}	
// on recupere les infos client
$sql = " SELECT nom, nom2, num_tva From " . $tblpref ."client WHERE num_client = $client ";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
	$nom = $data['nom'];
	$nom =  stripslashes ($nom);
	$nom2 = $data['nom2'];
	$num_tva = $data['num_tva'];
}
?>
<!--CREATION FACT-->
<div class="portion">
    <!-- TITRE - CREATION FACT -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-money fa-stack-1x"></i>
        </span>
        Documents &agrave; facturer
        <span class="fa-stack fa-lg add" style="float:right" id="show_create">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_create">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - CREATION FACT -->
    <div class="content_traitement" id="create">
        <form action="fact_fin.php" method="post" name="fact" id="fact">
        <div class="portion_subtitle"><i class="fa fa-truck"></i> Bons de Livraison</div>
        <table class='base' width="100%">
            <thead>
            <tr>
                <th class="">N°</th>
                <th class="">Client</th>
                <th class="">Date</th>
                <th class="">BDC</th>
                <th class="">Total HT</th>
                <th class="">Total TTC</th>
                <th class="">Facturer ?</th>
            </tr>
            </thead>
            <tbody>
            <?		
            //ya un truk pas clean avec la comparaison des dates ... pas sur a 100% que ca fonctionne ..
            // en tout cas, pose problème avec les interventions ...
            $sql = "SELECT num_bl, bon_num, tot_htva, tot_tva, DATE_FORMAT(date,'%d/%m/%Y') AS date
                FROM " . $tblpref ."bl
                WHERE " . $tblpref ."bl.client_num = '".$client."' 
                and fact='0'";
            $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            $nombre= 1;//1ere ligne du tableau foncee
            while($data = mysql_fetch_array($req))
            {
                $num_bl = $data['num_bl'];
                $bon_num = $data['bon_num'];
                $date = $data['date'];
                $tot_htva = $data['tot_htva'];
                $tot_tva = $data['tot_tva'];
                $tot_ttc=$tot_htva+$tot_tva;
        
                $nombre = $nombre +1;
                if($nombre & 1){
                $line="0";
                }else{
                $line="1";
                }
                ?>
                <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
                    <td class=""><? echo $num_bl; ?></td>
                    <td class=""><? echo $nom; ?></td>
                    <td class=""><? echo $date; ?></td>
                    <td class=""><? echo $bon_num; ?></td>
                    <td class=""><? echo $tot_htva; ?></td>
                    <td class=""><? echo $tot_ttc; ?></td>
                    <td class=""><input type="checkbox" name="liste_bl[]" value="<? echo $num_bl; ?>" CHECKED></td>
                </tr>
            <?
            } 
            ?>
            </tbody>
        </table>
        <br/><br/>
        <div class="portion_subtitle"><i class="fa fa-ticket"></i> T&acirc;ches</div>
        <table class='base' width="100%">
        	<thead>
            <tr>
                <th class="" width="5%">N°</th>
                <th class="" width="15%">Nom</th>
                <th class="" width="10%">Client</th>
                <th class="" width="10%">Type</th>
                <th class="" width="10%">Date</th>
                <th class="" width="10%">Dur&eacute;e</th>
                <th class="" width="7%">Factur&eacute;</th>
                <th class="" width="7%">Prix HT</th>
                <th class="" width="5%">Deplacement HT</th>
                <th class="" width="6%">Ticket</th>
                <th class="" width="5%">Facturer ?</th>
            </tr>
            </thead>
            <tbody>
            <?
            $sql = "SELECT t.rowid as trowid, t.name as tname, t.date_due as tdate_due, t.time_spent as ttime_spent, ti.name as tiname, ti.rowid as tirowid, tt.type as type";
            $sql .=" FROM ".$tblpref."task as t";
            $sql .=" LEFT JOIN ".$tblpref."ticket as ti ON ti.rowid=t.ticket_num";
            $sql .=" LEFT JOIN ".$tblpref."type_task as tt ON tt.rowid=t.type";
            $sql .=" WHERE ti.soc='".$client."' AND t.facture='0' AND ti.state='1' AND ti.facture='0'";
            $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            $nombre=1;	//1ere ligne du tableau foncée
			$check=mysql_num_rows($req);
			if ($check > 0) {
				while($data = mysql_fetch_array($req))
				{
					$num_inter = $data['trowid'];
					$date = $data['tdate_due'];
					$cause = stripslashes ($data['tname']);
					$duree = $data['ttime_spent'];
					$duree_inter=explode(':',$duree);
					$hours=$duree_inter[0];
					$minutes=$duree_inter[1];
					$duree=$hours.':'.$minutes;	
					$name_ticket=$data['tiname'];
					$rowid=$data['tirowid'];
					$type=$data['type'];
					//Alternance des couleurs des lignes du tableau lors de l'affichage
					$nombre = $nombre +1;
					if($nombre & 1){
						$line="0";
					} else {
						$line="1";
					}	
					//Récupération des données servant à calculer les montants.
					$sql_cost 	= "SELECT tarif_special, deplacement, TIME_TO_SEC(time_spent) as sectime, ticket_num as ticketnum  FROM ".$tblpref."task WHERE rowid=$num_inter";
					$results_cost  	= mysql_query($sql_cost);
					$data_cost	= mysql_fetch_array($results_cost);	
					$tarif_special = $data_cost['tarif_special'];
					$nbtrav = '1';
					$type_deplacement = $data_cost['deplacement'];	
					$duree_s=$data_cost['sectime'];
					//tarifs des inters
					if ($tarif_special == '4'){
						$tarif_quartdh = $tarif_REDUIT*$nbtrav;	
						if ($duree_s % 900 > '0') { 
							$cout = (int)(($duree_s / 900)+1) * $tarif_quartdh; 
						} 
						else { 
							$cout = (int)($duree_s / 900) * $tarif_quartdh; 
						}
					}
					//Si foyer namurois
					else if ($tarif_special == '5') {
						$tarif_quartdh = 13.50;	
						if ($duree_s % 900 > '0') { 
							$cout = (int)(($duree_s / 900)+1) * $tarif_quartdh; 
						} 
						else { 
							$cout = (int)($duree_s / 900) * $tarif_quartdh; 
						}
					}
					else{
							if ($num_tva == 'NA') { 
								$tarif_quartdh = $tarif_NA*$nbtrav; 
							} 
							else { 
								$tarif_quartdh = $tarif_ASSUJETI*$nbtrav; 
							}
							
							if ($duree_s % 900 > '0') { 
								$cout = (int)(($duree_s / 900)+1) * $tarif_quartdh; 
							} 
							else { 
								$cout = (int)($duree_s / 900) * $tarif_quartdh; 
							}
						}	
					//cout du deplacement
					if ($num_tva == 'NA') { 
						if ($type_deplacement == '1') {$cout_depl = '16.52892561983471';}
						elseif ($type_deplacement == '2') {$cout_depl = '24.79338842975207';}
						elseif ($type_deplacement == '3') {$cout_depl = '33.05785123966942';}
						elseif ($type_deplacement == '0') {$cout_depl = '0';}
						elseif ($type_deplacement == '4') {$cout_depl = '16';}
					}
					else {
						if ($type_deplacement == '1') {$cout_depl = '20';}
						elseif ($type_deplacement == '2') {$cout_depl = '30';}
						elseif ($type_deplacement == '3') {$cout_depl = '40';}
						elseif ($type_deplacement == '0') {$cout_depl = '0';}
						elseif ($type_deplacement == '4') {$cout_depl = '16';}
					}
					//si tarif special
					if ($tarif_special == 2) { $cout = $cout * 1.5; $cout_depl = $cout_depl * 1.5;}
					elseif ($tarif_special == 3) { $cout = $cout * 2; $cout_depl = $cout_depl * 2;}	
					?>
					<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
						<td class="highlight"><?php echo $num_inter; ?></td>
						<td class="highlight"><?php echo $cause; ?></td>
						<td class="highlight"><?php echo $nom; ?></td>
						<td class="highlight"><?php echo $type; ?></td>
						<td class="highlight"><?php echo $date; ?></td>
						<td class="highlight"><?php echo $duree." h"; ?></td>
						<td class="highlight"><input type="text" name="time_facturation_<? echo $num_inter?>" id="time_facturation_<? echo $num_inter?>" value="<? echo $duree;?>" size="3" class="styled"/></td>	
						<td class="highlight"><input type="text" name="fact_fixed_<? echo $num_inter?>" id="fact_fixed_<? echo $num_inter?>" value="<? echo $cout;?>" size="6" class="styled"/> &euro;</td>
						<td class="highlight"><input type="text" name="depl_fixed_<? echo $num_inter?>" id="depl_fixed_<? echo $num_inter?>" value="<? echo $cout_depl;?>" size="5" class="styled"/> &euro;</td>	
						<td class="highlight"><?php echo $name_ticket; ?></td>
						<td class="highlight"><input type="checkbox" name="liste_inter[]" value="<? echo $num_inter; ?>" CHECKED></td>
					</tr>
				<?php
				} 
			}
			else {
				?>
                <td colspan="11"><i class="fa fa-exclamation-triangle"></i> Aucune t&acirc;che &agrave; facturer trouv&eacute;e.</td>
                <?php
			}
            ?>
            </tbody>
        </table>
        <br/><br/>
        <div class="portion_subtitle"><i class="fa fa-floppy-o"></i> Finalisation</div>
        <table class='base' width="100%">
            <tr>
                <td class="right" width="50%">Commentaires :</td>
                <td class="left" width="50%">
                <textarea name="coment" cols="45" rows="3" id="coment" class="styled"></textarea>
                </td>
            </tr>
            <tr>
                <td class="right">Intra-communautaire (cocher si oui)</td>
                <td class="left"><input type="checkbox" name="tvaouinon" id="tvaouinon" value="oui" class="styled"></td>
            </tr>
            <tr>
                <td class="right">Acompte :</td>
                <td class="left"><input name="acompte" type="text" id="acompte" size="8" class="styled"> &euro;</td>
            </tr>
            <tr>
                <td class="right">Delai paiement :</td>
                <td class="left"><input name="delai" type="text" id="delai" value="3" size="8" class="styled"> jours</td>
            </tr>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit" name="Submit">
            	<i class="button__icon fa fa-money"></i><span>Facturer la s&eacute;lection</span>
           	</button>
        </div>
        <input type="submit" name="Submit" value="" class="submit">
        <input type="hidden" name="client" value="<? echo $client;?>">
        <input type="hidden" name="date_deb" value="<? echo $date_deb;?>">
        <input type="hidden" name="date_fin" value="<? echo $date_fin;?>">
        <input type="hidden" name="date_fact" value="<? echo $date_fact1;?>">
        </form>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
