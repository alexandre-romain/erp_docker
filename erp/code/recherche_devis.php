<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD 
$client=isset($_POST['listeville'])?$_POST['listeville']:"";
$numero=isset($_POST['numero'])?$_POST['numero']:"";
$mois=isset($_POST['mois'])?$_POST['mois']:"";
$jour=isset($_POST['jour'])?$_POST['jour']:"";
$annee=isset($_POST['annee'])?$_POST['annee']:"";
$montant=isset($_POST['montant'])?$_POST['montant']:"";
$tri=isset($_POST['tri'])?$_POST['tri']:"";

$requete = "SELECT DATE_FORMAT(date,'%d/%m/%Y')as date, num_dev, tot_htva, tot_tva, resu, nom FROM " . $tblpref ."devis RIGHT JOIN " . $tblpref ."client on " . $tblpref ."devis.client_num = num_client WHERE num_dev !=''";
//on verifie le client
if ( isset ( $_POST['listeville'] ) && $_POST['listeville'] != '')
{
	$requete .= " AND num_client='" . $_POST['listeville'] . "'";
}
//on verifie le numero
if ( isset ( $_POST['numero'] ) && $_POST['numero'] != '')
{
	$requete .= " AND num_dev='" . $_POST['numero'] . "'";
}
//on verifie le mois
if ( isset ( $_POST['mois'] ) && $_POST['mois'] != '')
{
	$requete .= " AND MONTH(date)='" . $_POST['mois'] . "'";
}
//on verifie l'année
if ( isset ( $_POST['annee'] ) && $_POST['annee'] != '')
{
	$requete .= " AND Year(date)='" . $_POST['annee'] . "'";
}
//on verifie le jour
if ( isset ( $_POST['jour'] ) && $_POST['jour'] != '')
{
	$requete .= " AND DAYOFMONTH(date)='" . $_POST['jour'] . "'";
}
//on verifie le montant
if ( isset ( $_POST['montant'] ) && $_POST['montant'] != '')
{
	$requete .= " AND trim(devis.tot_htva)='" . $_POST['montant'] . "'";
}
$requete .= " ORDER BY $tri";  
//on execute
$req = mysql_query($requete) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$message = $lang_res_rech;
?>
<!--RECHERCHE-->
<div class="portion">
    <!-- TITRE - RECHERCHE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-trophy fa-stack-1x"></i>
        </span>
        R&eacute;sultats de la recherche
        <span class="fa-stack fa-lg add" style="float:right" id="show_results">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_results">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - RECHERCHE -->
    <div class="content_traitement" id="results">
<table class="base" width="100%">
	<thead>
        <tr>
            <th><?php echo $lang_de_num;?></th>
            <th><?php echo $lang_client;?></th>
            <th><?php echo $lang_dev_date;?></th>
            <th><?php echo $lang_total_h_tva;?></th> 
            <th><?php echo $lang_total_ttc;?></th>
            <th><?php echo $lang_action;?></th>
            <th colspan='2'><?php echo $lang_ga_per;?></th>
        </tr>
  	</thead>
    <tbody>
	<?php
    while($data = mysql_fetch_array($req))
        {
            $num_dev = $data['num_dev'];
            $total = $data['tot_htva'];
            $tva = $data['tot_tva'];
            $date = $data['date'];
            $nom = $data['nom'];
            $resu = $data['resu'];
    		?>
			<tr>
                <td class=''><?php echo $num_dev; ?></td>
                <td class=''><?php echo $nom; ?></td>
                <td class=''><?php echo $date; ?></td>
                <td class=''><?php echo montant_financier($total); ?></td>
                <td class=''><?php echo montant_financier($tva); ?></td>
                <td class="left" width="12%">
                <?php 
				//EDITION
				if ($resu !='ok' and $resu !='per') {
				?>
                	<a href="edit_devis.php?num_dev=<?php echo $num_dev; ?>&amp;nom=<?php echo $nom; ?>" class="no_effect">
                   		<i class="fa fa-pencil fa-2x fa-fw action" title="Editer"></i>
                    </a>
                <?php 
                } 
				?>
                <!-- SUPPRESSION-->
                	<a href="delete_dev_suite.php?num_dev=<?php echo $num_dev; ?>&amp;nom=<?php echo $nom; ?>" onClick="return confirmDelete('<?php echo"$lang_eff_dev $num_dev ?"; ?>')" class="no_effect">
                   		<i class="fa fa-trash fa-2x fa-fw del" title="Supprimer"></i>
                  	</a>
              	<!-- IMPRESSION-->
                	<a href="fpdf/devis_pdf.php?num_dev=<?php echo $num_dev; ?>&amp;nom=<?php echo $nom; ?>&amp;pdf_user=adm" target="_blank" class="no_effect">
                		<i class="fa fa-print fa-2x fa-fw action" title="Imprimer"></i>
                    </a>
               	</td>
                <td>
                <?php 
				if ($resu !='ok' and $resu !='per') {
				?>
                    <a href="convert.php?num_dev=<?php echo $num_dev; ?>" onClick="return confirmDelete('<?php echo"$lang_convert_dev $num_dev $lang_convert_dev2 "; ?>')" class="no_effect">
                        <i class="fa fa-thumbs-o-up fa-2x fa-fw add" title="Passer en commande"></i>
                    </a>
                    <a href="devis_non_commandes.php?num_dev=<?php echo $num_dev; ?>" onClick="return confirmDelete('<?php echo"$lang_dev_perd $num_dev $lang_dev_perd2 "; ?>')" class="no_effect">
                        <i class="fa fa-thumbs-o-down fa-2x fa-fw del" title="<?php echo $lang_devis_perdre;?>"></i>
                    </a>
                <?php 
                }
				else if ($resu =='ok') { 
				?>
					<i class="fa fa-hand-peace-o fa-2x fa-fw"></i> <b>Gagné</b> 
                <?php 
				} 
				else if ($resu =='per') {
				?>
                    <i class="fa fa-hand-paper-o fa-2x fa-fw"></i> <b>Perdu</b>
				<?php 
                }
				?>
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
include_once("chercher_devis.php");
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>