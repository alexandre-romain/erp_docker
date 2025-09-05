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
} );
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
//Gestion des messages informatifs
include_once("include/message_info.php");
///FINHEAD
$sql = "SELECT mail, DATE_FORMAT(date_fact,'%d/%m/%Y') AS date_fact,
               total_fact_ttc, payement, num_client, date_deb, dev_num, explic, 
			   DATE_FORMAT(date_deb,'%d/%m/%Y') AS date_deb2, date_fin,
			   DATE_FORMAT(date_fin,'%d/%m/%Y') AS date_fin2, num, nom, mail
	    FROM " . $tblpref ."facture RIGHT JOIN " . $tblpref ."client on client = num_client LEFT JOIN " . $tblpref ."devis on dev_num = num_dev
        WHERE num >0 ";
				//ORDER BY 'num' DESC
				if ($user_fact == r) { 
$sql = "SELECT mail, DATE_FORMAT(date_fact,'%d/%m/%Y') AS date_fact,
               total_fact_ttc, payement, num_client, date_deb, dev_num, explic, 
			   DATE_FORMAT(date_deb,'%d/%m/%Y') AS date_deb2, date_fin,
			   DATE_FORMAT(date_fin,'%d/%m/%Y') AS date_fin2, num, nom, mail
	    FROM " . $tblpref ."facture RIGHT JOIN " . $tblpref ."client on client = num_client RIGHT JOIN " . $tblpref ."devis on dev_num = num_dev
        WHERE num >0 
	 and " . $tblpref ."client.permi LIKE '$user_num,' 
	 or  " . $tblpref ."client.permi LIKE '%,$user_num,' 
	 or  " . $tblpref ."client.permi LIKE '%,$user_num,%' 
	 or  " . $tblpref ."client.permi LIKE '$user_num,%' 
	";  
	//ORDER BY 'num' DESC
}
if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
{
$sql .= " ORDER BY " . $_GET[ordre] . " DESC";
}else{
$sql .= "ORDER BY num DESC ";
}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<!--CREATION DEVIS-->
<div class="portion">
    <!-- TITRE - CREATION DEVIS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        <?php echo $lang_tou_fact; ?>
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
    <!-- CONTENT - CREATION DEVIS -->
    <div class="content_traitement" id="list">
    <table class="base" width="100%" id="fact">
    	<thead>
            <tr> 
                <th><?php echo $lang_numero; ?></th>
                <th><?php echo $lang_client; ?></th>
                <th><?php echo $lang_tot_ttc; ?></th>
                <th><?php echo $lang_date; ?></th>
                <th>Dénomination</th>
                <th><?php echo $lang_pay; ?></th>
                <th><?php echo $lang_action; ?></th>
            </tr>
        </thead>
        <tbody>
        <?php
        while($data = mysql_fetch_array($req))
        {
            $client = $data['nom'];
            $mail = $data ['mail'];
            $client = $client;
            $nom_html = urlencode($client);
            $debut = $data['date_deb2'];
            $debut2 = $data['date_deb'];
            $fin = $data['date_fin2'];
            $fin2 = $data['date_fin'];
            $pay = $data['payement'];
            $explic = $data['explic'];
            switch ($pay) {
                case carte:
                	$payement=$lang_carte_ban." <i class='fa fa-credit-card fa-2x fa-fw' style='vertical-align:middle'></i>";
                break;
                case "liquide":
                	$payement=$lang_liquide." <i class='fa fa-money fa-2x fa-fw' style='vertical-align:middle'></i>";
                break;
                case "ok":
                	$payement=$lang_pay_ok." <i class='fa fa-money fa-2x fa-fw' style='vertical-align:middle'></i>";
                break;
                case "paypal":
                	$payement=$lang_paypal." <i class='fa fa-paypal fa-2x fa-fw' style='vertical-align:middle'></i>";
                break;
                case "virement":
                	$payement=$lang_virement." <i class='fa fa-credit-card fa-2x fa-fw' style='vertical-align:middle'></i>";
                break;
                case "visa":
                	$payement=$lang_visa." <i class='fa fa-cc-visa fa-2x fa-fw' style='vertical-align:middle'></i>";
                break;
                case "non":
                	$payement="<font color=red>".$lang_non_pay." <i class='fa fa-frown-o fa-2x fa-fw' style='vertical-align:middle'></i></font>";
                break;
            }
            $num = $data['num'];
            $num_client =$data['num_client'];
            $total = $data['total_fact_ttc'];
            $date_fact = $data['date_fact'];
            $mail = $data['mail'];
            ?>
            <tr class="">
                <td class=""><?php echo $num; ?></td>
                <td class=""><?php echo $client; ?></td>
                <td class=""><?php echo montant_financier($total); ?></td>
                <td class=""><?php echo $date_fact; ?></td>
                <td class=""><?php echo $explic; ?></td>
                <td class=""><?php echo $payement; ?></td> 
                <td class="">
                    <a href="fpdf/facture_pdf.php?num=<?php echo $num; ?>&amp;nom=<?php echo $nom_html; ?>&amp;pdf_user=adm" target="_blank" class="no_effect">
                    	<i class="fa fa-print fa-fw fa-2x action" title="Imprimer"></i>
                    </a>
					<?php
                    if ($mail != '') {
                    ?>
                        <a href="fpdf/fact_pdf.php?num=<?php echo $num; ?>&nom=<?php echo $nom_html; ?>&pdf_user=adm" onclick='return confirm("Envoyer cette facture &agrave; : <?php echo $mail; ?>?")' class="no_effect">
                            <i class="fa fa-envelope fa-fw fa-2x action" title="Envoyer par mail"></i>
                        </a>
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
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
