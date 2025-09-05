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
    $('#nc').DataTable( {
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
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
$numClient=isset($_POST['listeville'])?$_POST['listeville']:"";
$sql2 = "SELECT nom FROM " . $tblpref ."client WHERE num_client=".$numClient."";
$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$data2 = mysql_fetch_array($req2);
$client2 = $data2['nom'];
$sql = "SELECT DATE_FORMAT(date_fact,'%d/%m/%Y') AS date_fact, total_fact_ttc, total_fact_h, num_client, num, nom, client, payement";
$sql.= " FROM " . $tblpref ."facture"; 
$sql.= " RIGHT JOIN " . $tblpref ."client ON client=num_client";
$sql.= " WHERE num_client=".$numClient."";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<!--RESULTATS-->
<div class="portion">
    <!-- TITRE - RESULTATS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-trophy fa-stack-1x"></i>
        </span>
        <?php echo $lang_tou_fact." de ".$client2; ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_list">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_list">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - RESULTATS -->
    <div class="content_traitement" id="list">
        <form action="nc_fin.php" method="post" >
        <table class="base" width="100%" id="nc">
			<thead>
                <tr> 
                    <th class=""><?php echo $lang_numero; ?></th>
                    <th class=""><?php echo $lang_tot_ttc; ?></th>
                    <th class=""><?php echo $lang_date; ?></th>
                    <th class="">Etat</th>
                    <th class="" width="10%">S&eacute;lection</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while($data = mysql_fetch_array($req))
            {
                $client = $data['nom'];
                $client = htmlentities($client, ENT_QUOTES);
                $nom_html = urlencode($client);
				$pay = $data['payement'];
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
                $totalHTVA = $data['total_fact_h'];
                $date_fact = $data['date_fact'];
                $mail = $data['mail'];
                ?> 
                <tr class="">
                    <td class=""><?php echo $num; ?></td>
                    <td class=""><?php echo montant_financier($total); ?></td>
                    <td class=""><?php echo $date_fact; ?></td>
                    <td class=""><?php echo $payement; ?></td>
                    <td class="">
                        <input type="hidden" name="num_client" value="<? echo $num_client; ?>"/>
                        <input type="hidden" name="totalHTVA" value="<? echo $totalHTVA ?>" />
                        <input type="checkbox" name="list_fact[]" value="<? echo $num; ?>" />
                    </td> 
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-check"></i><span>Valider</span></button>
        </div> 
        </form>
	</div>
</div>
<?php
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
