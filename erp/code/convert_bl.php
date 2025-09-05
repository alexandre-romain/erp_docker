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
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
if($_POST['commande']=='0')
{
	$message = "Veuillez choisir un bon de commande";
	include('form_bl.php');
	exit;
}
$num_bon=isset($_REQUEST['commande'])?$_REQUEST['commande']:"";
$date=isset($_REQUEST['date'])?$_REQUEST['date']:"";

echo $date;

list($jour, $mois,$annee) = preg_split('/\//', $date, 3);
//on recpere les donnée de la commande
$sql0 = "SELECT * FROM ".$tblpref."bon_comm WHERE num_bon=".$num_bon."";
$req = mysql_query($sql0) or die('Erreur SQL 1!<br>'.$sql0.'<br>'.mysql_error());
while($data = mysql_fetch_array($req)) {
	$client_num = $data['client_num'];
	$date = $data['date'];
	$tot_htva = $data['tot_htva'];
	$tot_tva = $data['tot_tva'];
}
//on les reinjecte dans la base bl
$sql1 = "INSERT INTO " . $tblpref ."bl ( client_num, date, bon_num, tot_htva, tot_tva ) VALUES ( $client_num, '$annee-$mois-$jour', $num_bon, $tot_htva, $tot_tva )";
mysql_query($sql1) or die('Erreur SQL 2!<br>'.$sql1.'<br>'.mysql_error());
$num_bl=mysql_insert_id();

//on crée les lignes du bl dans la table gest_cont_bl (obligé si on veutdes traces de tous ls bl ...)

$sql3 = "SELECT * FROM " . $tblpref ."cont_bon WHERE bon_num = $num_bon AND livre < quanti";
$req = mysql_query($sql3) or die('Erreur SQL 3!<br>'.$sql3.'<br>'.mysql_error());
while($data = mysql_fetch_array($req)) {
	$article_num = $data['article_num'];
	$article_name = $data['article_name'];
	$quanti_bon = $data['quanti'];
	$tot_art_htva = $data['tot_art_htva'];
	$to_tva_art = $data['to_tva_art'];
	$p_u_jour = $data['p_u_jour'];
	$num_cont_bon = $data['num'];
	$livre = $data['livre'];
	$alivrer = $quanti_bon - $livre;

	$tot_art_htva = $alivrer * $p_u_jour;
	
	$sql4 = "SELECT taux_tva FROM " . $tblpref ."article WHERE num = $article_num";
	$req4 = mysql_query($sql4) or die('Erreur SQL 4!<br>'.$sql4.'<br>'.mysql_error());
		
	while($data4 = mysql_fetch_array($req4)) 
	{
		$taux_tva = $data4['taux_tva'];
		$to_tva_art = $tot_art_htva / 100 * $taux_tva ;
	}
	//on crée la ligne du bl
	if ($article_name == NULL) {
		$sql4 = "INSERT INTO " . $tblpref ."cont_bl(bl_num, article_num, quanti, tot_art_htva, to_tva_art, p_u_jour, num_cont_bon) 
		VALUES ('$num_bl', '$article_num', '$alivrer', '$tot_art_htva', '$to_tva_art', '$p_u_jour', '$num_cont_bon')";
	}
	else {
		$sql4 = "INSERT INTO " . $tblpref ."cont_bl(bl_num, article_num, article_name, quanti, tot_art_htva, to_tva_art, p_u_jour, num_cont_bon) 
		VALUES ('$num_bl', '$article_num', '$article_name', '$alivrer', '$tot_art_htva', '$to_tva_art', '$p_u_jour', '$num_cont_bon')";
	}
	mysql_query($sql4) or die('Erreur SQL5 !<br>'.$sql4.'<br>'.mysql_error());
}
$message= "Votre bon de commande n°".$num_bon." a été converti en BL n°".$num_bl."<br>Modifiez le pour insérer les n° de série";
include_once("edit_bl.php");
?> 