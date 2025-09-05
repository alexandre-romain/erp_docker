<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_search").hide();
	$("#hide_search").click(function(){
		$("#search").hide(500);	
		$("#hide_search").hide();
		$("#show_search").show();
	});
	$("#show_search").click(function(){
		$("#search").show(500);	
		$("#hide_search").show();
		$("#show_search").hide();
	});
	$("#show_comptes").hide();
	$("#hide_comptes").click(function(){
		$("#comptes").hide(500);	
		$("#hide_comptes").hide();
		$("#show_comptes").show();
	});
	$("#show_comptes").click(function(){
		$("#comptes").show(500);	
		$("#hide_comptes").show();
		$("#show_comptes").hide();
	});
});
$(document).ready(function() {
    $('#fact').DataTable( {
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
	$('#list_comptes').DataTable( {
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
		"order": [[3, 'desc']],
  	});
} );

</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
$sql = "SELECT TO_DAYS(NOW()) - TO_DAYS(date_fact) AS peri, client,r1, r2, r3,  date_deb, mail, date_fin, total_fact_ttc, num, nom, nom2, DATE_FORMAT(date_fact,'%d/%m/%Y') AS date_fact
        FROM " . $tblpref ."facture 
	    RIGHT JOIN " . $tblpref ."client on " . $tblpref ."facture.client = " . $tblpref ."client.num_client
        WHERE payement = 'non'";
if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '') {
	$sql .= " ORDER BY " . $_GET[ordre] . " ASC";
}
else {
	$sql .= "ORDER BY num ASC";
}

$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<!--FACTURES NON REGLEE-->
<div class="portion">
    <!-- TITRE - FACTURES NON REGLEE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        <?php echo $lang_factures_non_reglees; ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_search">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_search">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - FACTURES NON REGLEE -->
    <div class="content_traitement" id="search">
        <table class="base" width="100%" id="fact">
        	<thead>
                <tr> 
                    <th class=""><?php echo $lang_numero; ?></th>
                    <th class=""><?php echo $lang_client; ?></th>
                    <th class=""><?php echo $lang_date; ?></th>
                    <th class=""><?php echo $lang_total_ttc; ?></th>
                    <th class=""><?php echo $lang_depuis; ?></th>
                    <th class=""><?php echo $lang_regler; ?></th>
                    <th class=""><?php echo $lang_voir; ?></th>
                    <th class=""><?php echo $lang_rappel; ?> 1</th>
                    <th class=""><?php echo $lang_rappel; ?> 2</th>
                    <th class=""><?php echo $lang_rappel; ?> 3</th>
                </tr>
            </thead>
            <tbody>
                <?php
				while($data = mysql_fetch_array($req))
				{
					$num = $data['num'];
					$total = $data['total_fact_ttc'];
					$nom = $data['nom'];
					$nom2 = $data['nom2'];
					$date = $data['date_fact'];
					$debut = $data['date_deb'];
					$fin = $data['date_fin'];
					$num_client = $data['client'];
					$peri = $data['peri'];
					$r1 = $data['r1'];
					$r2 = $data['r2'];
					$r3 = $data['r3'];
					$mail = $data['mail'];
					?>
                    <tr class="">
                        <td class=""><?php echo $num; ?></td>
                        <td class=""><?php echo "$nom $nom2"; ?></td>
                        <td class=""><?php echo $date; ?></td>
                        <td class=""><?php echo montant_financier($total); ?></td>
                        <td class=""><b><!--<a href='rapel.php?client=<?php echo $num_client; ?>'>--><?php echo "$peri $lang_jours"; ?><!--</a>--></b></td>
                        <td class="">
							<?php
                            if($use_payement =='y') { 
							?>				
                            	<form action="payement_suite.php" id="payement<?php echo "$num";?>" method="post" name="payement<?php echo "$num";?>">
                                    <div class="styled-select-inline">
                                    <select name="methode" class="styled-inline" onchange="if(this.value != -1){if(confirm('<?php echo"$lang_conf_carte_reg";?> '+ forms['payement<?php echo "$num";?>'].elements['num'].value +' <?php echo"$lang_par ";?>'+ this.value)){forms['payement<?php echo "$num";?>'].submit();}else{return false}}">
                                        <option value="-1"><?php echo"$lang_mode_paiement"; ?></option>
                                        <option value="liquide"><?php echo"$lang_liquide"; ?></option>
                                        <option value="virement"><?php echo"$lang_virement"; ?></option>
                                        <option value="paypal"><?php echo"$lang_paypal"; ?></option>
                                        <option value="carte"><?php echo"$lang_carte_ban"; ?></option>
                                        <option value="visa"><?php echo"$lang_visa"; ?></option>
                                        <option value="NC">Note de Crédit</option>
                                    </select>
                                    </div> 
                                    <input type="hidden" name="num"  value="<?php echo"$num"; ?>" />
                                    <input type="submit" name="envoi" style="display: none" />
                            	</form>
                			<?php 
                			}
							else {	
							?>		
                            	<a href='payement_suite.php?num=<?php echo $num; ?>'onClick="return confirmDelete('<?php echo"$lang_regler_fact $num $lang_regler_fact2"; ?>')"> 
                    				<img border=0 src='image/ok.jpg' alt='regler'>
                                </a>
							<?php
                            } 
                            ?>
                        </td>
                        <td class="">
                        	<a href="fpdf/facture_pdf.php?num=<?php echo $num; ?>&amp;nom=<?php echo $nom_html; ?>&amp;pdf_user=adm" target="_blank" class="no_effect">
                            	<i class="fa fa-print fa-fw fa-2x action"></i>
                            </a>
                        </td>
                        <td class=""><?php 
                        if ($r1 != 'non') {
                        echo '<div class="rappel_done_btn"><i class="fa fa-calendar-check-o"></i> '.$r1.'</div>';
                        }
                        else {
                        echo '<a href="fpdf/rappel1.php?num='.$num.'&amp;pdf_user=adm" style=" text-decoration:none;" onclick="return confirm(\'Envoyer le 1er rappel à '.$mail.' ('.$nom.') ?\')"><div class="rappel_btn"><i class="fa fa-envelope"></i> Rappel 1</div></a>';
                        }
                        ?></td>
                        <td class="highlight"><?php
                            if ($r2 != 'non') {
                                echo '<div class="rappel_done_btn"><i class="fa fa-calendar-check-o"></i> '.$r2.'</div>';
                            }
                            else {
                                echo '<a href="fpdf/rappel2.php?num='.$num.'&amp;pdf_user=adm" style=" text-decoration:none;" onclick="return confirm(\'Envoyer le 2eme rappel à '.$mail.' ('.$nom.') ?\')" class="no_effect"><div class="rappel_btn"><i class="fa fa-envelope"></i> Rappel 2</div></a>';
                            } 
                            ?>
                        </td>
                        <td class="highlight">
                        <?php
                        if ($r3 != 'non') {
                            echo '<div class="rappel_done_btn"><i class="fa fa-calendar-check-o"></i> '.$r3.'</div>';
                        }
                        else {
                            echo '<a href="fpdf/rappel3.php?num='.$num.'&amp;pdf_user=adm" style=" text-decoration:none;" onclick="return confirm(\'Envoyer le 3eme rappel à '.$mail.' ('.$nom.') ?\')"><div class="rappel_btn"><i class="fa fa-envelope"></i> Rappel 3</div></a>';
                        }
                        ?>
                        </td>
                    </tr>
               	<?php
				}
				?>
            </tbody>
        </table>
        <br/><br/>
		<?php
        //ON calcule le total de tous les impayés
        $sql = "SELECT SUM(total_fact_ttc) FROM " . $tblpref ."facture RIGHT JOIN " . $tblpref ."client on " . $tblpref ."facture.client = " . $tblpref ."client.num_client WHERE payement = 'non'";
        $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
        while($data = mysql_fetch_array($req))
        {
            $tot = $data['SUM(total_fact_ttc)'];
        }
        ?>
        <table class="base" width="100%">
        	<thead>
                <tr> 
                  <th class="right" width="50%"><?php echo $lang_factures_non_reglees_total; ?> :</th>
                  <th class="left" width="50%"><?php echo montant_financier($tot) ; ?></th>
                </tr>
            </thead>
    	</table>
	</div>
</div>

<!--FACTURES NON REGLEE-->
<div class="portion">
    <!-- TITRE - FACTURES NON REGLEE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        &Eacute;tat des comptes par client
        <span class="fa-stack fa-lg add" style="float:right" id="show_comptes">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_comptes">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - FACTURES NON REGLEE -->
    <div class="content_traitement" id="comptes">
    	<table class="base" width="100%" id="list_comptes">
        	<thead>
            	<th>Client</th>
                <th>Nombre de factures impay&eacute;es</th>
                <th>Montant TTC impay&eacute;s</th>
                <th>Date de la premi&egrave;re &eacute;ch&eacute;ance</th>
                <th>Imprimer</th>
            </thead>
            <tbody>
			<?php
            $sql = "SELECT DISTINCT client
            FROM " . $tblpref ."facture 
            RIGHT JOIN " . $tblpref ."client on " . $tblpref ."facture.client = " . $tblpref ."client.num_client
            WHERE payement = 'non' ORDER BY ABS(num)";
            $req=mysql_query($sql);
            while ($obj=mysql_fetch_object($req)) {
                $num_cli=$obj->client;
                //On va récupérer le nom du client
                $sql_cli="SELECT nom FROM ".$tblpref."client WHERE num_client='".$num_cli."'";
                $req_cli=mysql_query($sql_cli);
                $obj_cli=mysql_fetch_object($req_cli);
                $nom_cli=$obj_cli->nom;
                //echo $nom_cli.'<br/>';
                //On récupère le total des facture
                $sql_tot="SELECT SUM(total_fact_ttc) as total FROM ".$tblpref."facture WHERE payement='non' AND client = '".$num_cli."'";
                $req_tot=mysql_query($sql_tot);
                $obj_tot=mysql_fetch_object($req_tot);
                $total=$obj_tot->total;
                //On récupère le nbt de facture
                $sql_nbr="SELECT * FROM ".$tblpref."facture WHERE payement='non' AND client = '".$num_cli."'";
                $req_nbr=mysql_query($sql_nbr);
                $nbr_fact=mysql_num_rows($req_nbr);
                //On récupère la date de la facture la plus récente.
                $sql_date="SELECT MIN(echeance_fact) as datemax, TO_DAYS(NOW()) - TO_DAYS(echeance_fact) AS peri FROM ".$tblpref."facture WHERE payement='non' AND client = '".$num_cli."'";
                $req_date=mysql_query($sql_date);
                $obj_date=mysql_fetch_object($req_date);
                $lastdate=$obj_date->datemax;
				$days_fact=$obj_date->peri;
            	?>
                <tr>
                	<td><?php echo $nom_cli;?></td>
                    <td><?php echo $nbr_fact;?></td>
                    <td><?php echo $total;?> &euro;</td>
                    <td><?php echo '<span class="disp_none">'.$lastdate.'</span>'.dateUSA_to_dateEU($lastdate).' ( '.$days_fact.' jours )';?></td>
                    <td>
                        <a href="./fpdf/situation_fin.php?cli=<?php echo $num_cli;?>&pdf_user=adm" class="no_effect" target="_blank">
                            <i class="fa fa-print fa-fw fa-2x action"></i>
                        </a>
                    </td>
                </tr>
			<?php
			}
            ?>
        	</tbody>
        </table>
    </div>
</div>
<?php
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
