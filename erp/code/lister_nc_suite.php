<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_listing").hide();
	$("#hide_listing").click(function(){
		$("#listing").hide(500);	
		$("#hide_listing").hide();
		$("#show_listing").show();
	});
	$("#show_listing").click(function(){
		$("#listing").show(500);	
		$("#hide_listing").show();
		$("#show_listing").hide();
	});
});
$(document).ready(function() {
    $('#list').DataTable( {
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

$sql3 = "SELECT nom2 FROM " . $tblpref ."client WHERE num_client='$numClient' ";
$req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());
$data3 = mysql_fetch_array($req3);
$nom = $data3['nom2'];

$sql2 = "SELECT num_nc, DATE_FORMAT(date,'%d/%m/%Y') AS date FROM " . $tblpref ."nc WHERE client_num = $numClient ";
$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
$num_nc = $data2['num_nc'];

$sql = "SELECT SUM(p_u_jour) AS total FROM " . $tblpref ."cont_nc WHERE nc_num= '$num_nc' ";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<!--RESULTATS-->
<div class="portion">
    <!-- TITRE - RESULTATS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-search fa-stack-1x"></i>
        </span>
        <?php echo "Note(s) de cr&eacute;dit pour ".$nom; ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_listing">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_listing">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - RESULTATS -->
    <div class="content_traitement" id="listing">
        <form action="lister_nc_fin.php" method="post" >
        <table class="base" align="center" width="100%" id="list">
            <thead>
            <tr> 
                <th class=""><?php echo $lang_numero; ?></th>
                <th class=""><?php echo $lang_date; ?></th>
                <th class="">Total</th>    
                <th class="">S&eacute;lection</th>
                <th class="">Doc (.pdf)</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while($data2 = mysql_fetch_array($req2)){
                $num_nc = $data2['num_nc'];
                $date = $data2['date'];
            
                $sql = "SELECT SUM(p_u_jour)*quanti AS total FROM " . $tblpref ."cont_nc WHERE nc_num= '$num_nc' ORDER BY total";
                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                $data = mysql_fetch_array($req);
                $total = $data['total'];
                switch ($pay) {
                    case carte:
                    $payement="$lang_carte_ban";
                    break;
                    case "liquide":
                    $payement="$lang_liquide";
                    break;
                    case "ok":
                    $payement="$lang_pay_ok";
                    break;
                    case "paypal":
                    $payement="$lang_paypal";
                    break;
                    case "virement":
                    $payement="$lang_virement";
                    break;
                    case "visa":
                    $payement="$lang_visa";
                    break;
                    case "non":
                    $payement="<font color=red>$lang_non_pay</font>";
                    break;
                }
                ?>
                <tr class="">
                    <td class=""><?php echo $num_nc; ?></td>
                    <td class=""><?php echo $date; ?></td>
                    <td class=""><?php echo $total; ?> &euro;</td>
                    <td class="">
                    	<input type="checkbox" name="list_nc[]" value="<? echo $num_nc; ?>" />
                    	<input type="hidden" name="num_client" value="<? echo $numClient; ?>" />
                    </td> 
                    <td width="10%">
                        <a href="./fpdf/nc_pdf.php?nc=<?php echo $num_nc; ?>&cli=<?php echo $numClient; ?>&pdf_user=adm" class="no_effect">
                        	<i class="fa fa-print fa-fw fa-2x action" title="Imprimer"></i>
                        </a>
                    </td>
                 </tr>
            <?php
            } //end WHILE
            ?> 
            </tbody>
        </table>
        <div class="center">
        	<button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-eye"></i><span>Voir le D&eacute;tail</span></button>
        </div>
        </form>
	</div>
</div>
<?php
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
