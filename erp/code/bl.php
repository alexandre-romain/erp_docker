<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
?>
<table width="760" border="0" class="page" align="center">
<tr>
<td class="page" align="center">
<?php
include_once("include/head.php");
?>
</td>
</tr>
<tr>
<td  class="page" align="center">
<?php
$numbon=isset($_POST['commande'])?$_POST['commande']:"";
$date=isset($_POST['date'])?$_POST['date']:"";
list($jour, $mois, $annee) = preg_split('/\//', $date, 3);

include_once("include/language/$lang.php"); 
if($numbon =='0')
    {
    $message="<h1>Veuillez choisir un bon de commande</h1>";
    include('form_bl.php');
    exit;
    }

$sql = "SELECT  num_bon, client_num FROM " . $tblpref ."bon_comm WHERE num_bon = $numbon";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$num_bon = $data['num_bon'];
		$client_num = $data['client_num'];
		$phrase = "BL Créé pour commande";
		echo "<h2>$phrase $num_bon $lang_bon_cree2 $date</h2>";
		}
//créé record dans table bl
$sql1 = "INSERT INTO " . $tblpref ."bl(client_num, bon_num, date) VALUES ('$client_num', '$num_bon', '$annee-$mois-$jour')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

// change état bon de commande en bl = 1 (0 = pas de bl, 1 = bl, end = tout livré)
$sql2 = "UPDATE " . $tblpref ."bon_comm SET bl ='1' WHERE num_bon ='".$num_bon."' LIMIT 1 ";
mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());

//on récupère les lignes de la commande pour vérification livraison
$sql3 = "SELECT  num, article_num, p_u_jour, quanti FROM " . $tblpref ."cont_bon WHERE bon_num = $numbon AND bl = 0";
$req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());
?>
<center>
<form name='formu2' method='post' action='bl_suite.php'>
    <table class="boiteaction">
      <caption>Choisissez les articles à livrer</caption>
	    <tr>
		<th>N&deg;</th>
		<th>Nom</th>
		<th>Unit&eacute;</th>
		<th>PV</th>
		<th>Qt&eacute;</th>
  		<th><? echo $lang_editer ;?></th>		
		</tr>

	      <?
	$nombre = 1;
	while($data3 = mysql_fetch_array($req3))
    {
	$num_cont = $data3['num'];
	$PV = $data3['p_u_jour'];
	$qty = $data3['quanti'];
	$article_num = $data3['article_num'];
	
	$nombre = $nombre +1;
	if($nombre & 1){
	$line="0";
	}else{
	$line="1"; 
	}
	
	//on récupère le nom et l'unité de l'article
	$sql4 = "SELECT  article, uni, marque FROM " . $tblpref ."article WHERE num = $article_num";
	$req4 = mysql_query($sql4) or die('Erreur SQL !<br>'.$sql4.'<br>'.mysql_error());
	
		while($data4 = mysql_fetch_array($req4))
    	{
		$article = $data4['article'];
		$uni = $data4['uni'];
		$marque = $data4['marque'];
		} ?>
	<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
		<td class="highlight"><center><? echo $num_cont; ?></center></td>
		<td class="highlight"><? echo $marque." ".$article; ?></td>
		<td class="highlight"><center><? echo $uni; ?></center></td>
		<td class="highlight"><center><? echo $PV; ?> &euro;</center></td>
		<td class="highlight"><center><? echo $qty." ".$uni; ?></center></td>
		<td class="highlight">	<form method="get" action="edit_cont_bl.php">
								<input name="<?php echo $lang_editer; ?>" type="image" value="<?php echo $lang_editer; ?>"
								src="image/edit.gif"
								alt="<?php echo $lang_editer; ?>"
								align="middle" onclick="submit ()">
								<input type="hidden" name="num_cont" value="<?php echo $num_cont; ?>">
								</form>
  		</td>
	</tr>
	<?
	}
?>	
  <tr>
  <td class="texte0" colspan="6">&nbsp;</td>
  </tr>
  <tr>
  <td class="submit" colspan="6">Ajouter un commentaire au BL</td>
  </tr>
  <td class="texte0" colspan="6"><div align="center"><textarea name="coment" cols="45" rows="3"><?php echo $coment; ?></textarea></div></td>
  </tr>
  <tr>
  <td class="submit" colspan="6"><input type="submit" name="Submit" value="Poursuivre"></td>    
  </tr>
</table>
<input name="num_bon" type="hidden" id="num_bon" value="<? echo $num_bon; ?>">
<input name="client_num" type="hidden" id="client_num" value="<? echo $client_num; ?>">
</form>
</center>
</td></tr><tr><td>

<?php
echo"</td></tr><tr><td>";
include_once("include/bas.php");
?></td></tr></table>
</body>
</html>
