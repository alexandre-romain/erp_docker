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
});
$(function() {
	$( "#date_new" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd/mm/yy" })
});
<!-- DT LISTE DEVIS -->
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

$sql ="SELECT login, mail, explic, epingle, num_dev, tot_htva, tot_tva, DATE_FORMAT(date,'%d/%m/%Y') AS date, nom";
$sql.=" FROM " .$tblpref."devis";
$sql.=" RIGHT JOIN " . $tblpref ."client on " . $tblpref ."devis.client_num = num_client";
$sql.="	WHERE num_dev >0 AND  resu = '0'";

if ($user_dev == r) { 
	$sql ="SELECT login, mail, explic, epingle, num_dev, tot_htva, tot_tva, DATE_FORMAT(date,'%d/%m/%Y') AS date, nom";
	$sql.=" FROM " . $tblpref ."devis";
	$sql.=" RIGHT JOIN " . $tblpref ."client on " . $tblpref ."devis.client_num = num_client";
	$sql.="	WHERE num_dev >0 AND  resu = '0'"; 
	$sql.="	AND " . $tblpref ."client.permi LIKE '$user_num,'"; 
	$sql.="	OR  " . $tblpref ."client.permi LIKE '%,$user_num,'"; 
	$sql.="	OR  " . $tblpref ."client.permi LIKE '%,$user_num,%'"; 
	$sql.="	OR  " . $tblpref ."client.permi LIKE '$user_num,%'"; 
}
if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '') {
	$sql .=" ORDER BY " . $_GET[ordre] . " DESC";
}
else {
	$sql .=" ORDER BY epingle DESC, num_dev DESC";
}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<!---- DEBUT AFFICHAGE ----><!---- DEBUT AFFICHAGE ----><!---- DEBUT AFFICHAGE ----><!---- DEBUT AFFICHAGE ----><!---- DEBUT AFFICHAGE ----><!---- DEBUT AFFICHAGE ----><!---- DEBUT AFFICHAGE ----><!---- DEBUT AFFICHAGE ---->
<!--CREATION COMMANDE-->
<div class="portion">
    <!-- TITRE - CREATION COMMANDE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        <?php echo $lang_devis_liste; ?>
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
    <!-- CONTENT - CREATION COMMANDE -->
    <div class="content_traitement" id="list">
        <table class="base" width="100%" id="listing">
        	<thead>
            <tr>
                <th class=""><?php echo $lang_num_dev; ?></th>
                <th class=""><?php echo $lang_client; ?></th>
                <th class="">Dénomination</th>
                <th class=""><?php echo $lang_date; ?></th>
                <th class=""><?php echo $lang_total_h_tva; ?></th>
                <th class=""><?php echo $lang_total_ttc; ?></th>
                <th class=""><?php echo $lang_action; ?> </th>
                <th class=""><?php echo $lang_gagne_perdu; ?> </th>
            </tr>
            </thead>
            <tbody>
				<?
                //AFFICHAGE DES DONNEES
                $nombre =1;
                while($data = mysql_fetch_array($req))
                {
                    $num_dev = $data['num_dev'];
                    $total = $data['tot_htva'];
                    $tva = $data['tot_tva'];
                    $date = $data['date'];
                    $nom = $data['nom'];
                    $explic = $data['explic'];
                    $nom_html =urlencode($nom);
                    $login = $data['login'];
                    $mail = $data['mail'];
                    $ttc = $total + $tva ; 
                    $nom = htmlentities($data['nom'], ENT_QUOTES);
                    $nombre = $nombre +1;
                    if($nombre & 1){
                        $line="0";
                    }
                    else {
                        $line="1";
                    }
                    ?>
                    <tr class="">	
                        <td class=""><?php echo $num_dev; ?></td>
                        <td class=""><?php echo $nom; ?></td>
                        <td class=""><?php echo $explic; ?></td>
                        <td class=""><?php echo $date; ?></td>
                        <td class=""><?php echo montant_financier ($total); ?></td>
                        <td class=""><?php echo montant_financier ($ttc); ?></td>
                        <td class="left" width="12%">
                            <!--EDITION-->
                            <a href="edit_devis.php?num_dev=<?php echo $num_dev; ?>&amp;nom=<?php echo $nom_html;?>" class="no_effect"> 
                            	<i class="fa fa-pencil fa-2x fa-fw action" title="Editer"></i>
                            </a>
                            <!--SUPPRESSION-->
                            <a href="delete_dev_suite.php?num_dev=<?php echo $num_dev; ?>&amp;nom=<?php echo $nom_html; ?>" onClick="return confirmDelete('<?php echo"$lang_eff_dev $num_dev ?"; ?>')" class="no_effect">
                            	<i class="fa fa-trash fa-2x fa-fw del" title="Supprimer"></i>
                            </a>
                            <!--IMPRESSION-->
                            <a href="fpdf/devis_pdf.php?num_dev=<?php echo $num_dev; ?>&amp;nom=<?php echo $nom_html; ?>&amp;pdf_user=adm" target="_blank" class="no_effect">
                            	<i class="fa fa-print fa-2x fa-fw action" title="Imprimer"></i>
                            </a>
							<!--MAILING-->
							<?php 
							if($mail != ''){ ?>
								<a href="fpdf/devis_pdf.php?num_dev=<?php echo $num_dev; ?>&amp;nom=<?php echo $nom; ?>&amp;action=mail&amp;pdf_user=adm" class="no_effect">
									<i class="fa fa-envelope fa-2x fa-fw action" title="Envoyer"></i>
                                </a>
							<?php
							}
                        	?>
                       	</td> 
                        <td class="">
                            <a href="convert.php?num_dev=<?php echo $num_dev; ?>" onClick="return confirmDelete('<?php echo"$lang_convert_dev $num_dev $lang_convert_dev2 "; ?>')" align="middle" border="0" class="no_effect">
                            	<i class="fa fa-thumbs-o-up fa-2x fa-fw add" title="Passer en commande"></i>
                          	</a>
                            <a href="devis_non_commandes.php?num_dev=<?php echo $num_dev; ?>" onClick="return confirmDelete('<?php echo"$lang_dev_perd $num_dev $lang_dev_perd2 "; ?>')" align="middle" border="0" class="no_effect">
                                <i class="fa fa-thumbs-o-down fa-2x fa-fw del" title="<?php echo $lang_devis_perdre;?>"></i>
                            </a>
                        </td>
                    </tr>
                <?php
                }  //FIN WHILE - AFFICHAGE DES DONNES
                ?>
         	</tbody>
        </table>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
