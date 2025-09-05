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
$quanti=isset($_POST['quanti'])?$_POST['quanti']:"";
$num_cont=isset($_POST['num_cont'])?$_POST['num_cont']:"";
$dev_num=isset($_POST['dev_num'])?$_POST['dev_num']:"";
$article=isset($_POST['article'])?$_POST['article']:"";
$PV=isset($_POST['PV'])?$_POST['PV']:"";
$sql = "SELECT prix_htva, taux_tva, marge FROM " . $tblpref ."article WHERE  " . $tblpref ."article.num = $article";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$PA = $data['prix_htva'];
		$taux_tva = $data['taux_tva'];
		$marge = $data['marge'];
		//echo " $prix_ht <br>";
		}

if ( (!$PV) && ($marge == '0'))
{ $prix_article = $PA; }
elseif ((!$PV) && ($marge != '0'))
{ 
$prix_article = (($marge / 100) + 1) * $PA; }
else
{ $prix_article = $PV; }

$tot_htva = $quanti * $prix_article ;
$tot_tva = $tot_htva / 100 * $taux_tva ;		 
mysql_select_db($db) or die ("Could not select $db database");
$sql2 = "UPDATE " . $tblpref ."cont_dev SET p_u_jour='".$prix_article."', quanti='".$quanti."', article_num='".$article."', tot_art_htva='".$tot_htva."', to_tva_art='".$tot_tva."'  WHERE num = '".$num_cont."'";
mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
  
$num_dev = $dev_num ;
include_once("edit_devis.php");
?> 