<?php 
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
$coment=isset($_POST['coment'])?$_POST['coment']:"";
$num_bon=isset($_POST['num_bon'])?$_POST['num_bon']:""; //numero du bon de commande
$client_num=isset($_POST['client_num'])?$_POST['client_num']:"";

//on récupère toutes les entrées du bon de commande
$sql = "SELECT  num, article_num, quanti, p_u_jour FROM " . $tblpref ."cont_bon WHERE bon_num = $num_bon";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
	$num = $data['num'];
	$article_num = $data['article_num'];
	$quanti = $data['quanti'];
	$p_u_jour = $data['p_u_jour'];
	
	//inserer les données dans la table du conten des bons.
	$sql1 = "INSERT INTO " . $tblpref ."cont_bl(p_u_jour, quanti, article_num, bon_num, tot_art_htva, to_tva_art, num_lot) 
	VALUES ('$prix_article', '$quanti', '$article', '$max', '$total_htva', '$mont_tva', '$lot1')";
	mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
	
	}


?>
<table class="page" width="760" align="center">
<tr><td>

<center>
<table>
<tr><td>&nbsp;</td></tr>
</table>
</center>

<?php include("include/bas.php"); ?>
</center></td></tr>
</table>

</body>
</html>