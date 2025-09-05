<?php
require_once("include/verif.php");
include_once("include/config/common.php");

include_once("include/language/$lang.php");
echo '<link rel="stylesheet" type="text/css" href="include/style.css">';
echo'<link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico" >';

if (!isset($insert_stock)) 
{

	$lib=isset($_POST['lib'])?$_POST['lib']:"";
	$prix=isset($_POST['prix'])?$_POST['prix']:"";
	$fourn=isset($_POST['fourn'])?$_POST['fourn']:"";
	$fournisseur=isset($_POST['fournisseur'])?$_POST['fournisseur']:"";
	$date=isset($_POST['date'])?$_POST['date']:"";
	$type="AM";
	list($jour, $mois,$annee) = preg_split('/\//', $date, 3);
	//$mois=isset($_POST['mois'])?$_POST['mois']:"";
	//$jour=isset($_POST['jour'])?$_POST['jour']:"";
	$fournisseur = stripslashes($fournisseur);
	
	if($lib==''|| $prix=='')
	{
	echo $lang_oublie_champ;
	include('form_achatsmarchandises.php');
	exit;
	}
	if ($fourn=='' and $fournisseur=='default') { 
	echo "<center><h1>$lang_dep_choi";
	include('form_achatsmarchandises.php');
	exit;  
	}
	
	if ($fournisseur =='default') 
	{
	$fourn= addslashes($fourn);
	mysql_select_db($db) or die ("Could not select $db database");
	$sql1 = "INSERT INTO " . $tblpref ."depense(fournisseur, lib, prix, date, type) VALUES ('$fourn', '$lib', '$prix', '$annee-$mois-$jour', '$type')";
	mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
	echo "<center><br><h2>$lang_dep_enr<br><hr>";
	}
	else
	{
	$fournisseur=addslashes($fournisseur);
	mysql_select_db($db) or die ("Could not select $db database");
	$sql1 = "INSERT INTO " . $tblpref ."depense(fournisseur, lib, prix, date, type) VALUES ('$fournisseur', '$lib', '$prix', '$annee-$mois-$jour', '$type')";
	mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
	$message="<center><h2>$lang_dep_enr</h2>";  
	}

	$sql00 = "SELECT MAX(num) AS id_max FROM gest_depense";
	$query00 = mysql_query($sql00);
	$result00 = mysql_fetch_array($query00);
	$ID_depense = $result00['id_max'];

}
else
{

// $serial 
$facture_achat = $ID_depense;
$status = 'in';

mysql_select_db($db) or die ("Could not select $db database");
$sql1 = "INSERT INTO " . $tblpref ."stock(article, serial, facture_achat, status) VALUES ('$article', '$serial', '$facture_achat', '$status')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

$sql03 = "SELECT stock FROM ". $tblpref ."article WHERE num = '$article'";
$req03 = mysql_query($sql03) or die('Erreur SQL !<br>'.$sql03.'<br>'.mysql_error());
$data03 = mysql_fetch_array($req03);

$stock_article = $data03['stock'];
$stock_article = $stock_article + 1;

$sql2 = "UPDATE " . $tblpref ."article SET stock = '$stock_article'  WHERE num = '$article'";
mysql_query($sql2) OR die("<p>Erreur Mysql1<br/>$sql2<br/>".mysql_error()."</p>");

}

?>
<form name="formu2" method="post" action="form_achatsmarchandises_suite.php" >
  <center><table >
    <caption>Mise à jour du stock</caption>
    <tr> 
      <td class="texte0">Article :</td>
      <td class="texte0">
<script type="text/javascript"> 
function redirection(){
window.location="form_depenses.php";
}
</script>
		<?php
		include("include/categorie_choix.php"); 
		?>
        <input name="insert_stock" type="hidden" id="insert_stock" value="1">
        <input name="ID_depense" type="hidden" value="<? echo $ID_depense; ?>"></td>
    </tr>
    <tr> 
        <td class="texte0">Serial :</td>
      <td class="texte0"><input name="serial" type="text" value="" size="35"></td>
    </tr>

    <tr> 
      <td class="submit" colspan="2"><div align="center">
            <input type="submit" name="Submit" value="Ajouter">
            &nbsp;
            <input type="button" name="terminer" value="Terminer" onclick="redirection()">
      </div></td>
    
  </table> </center>
</form>


<center>
<table width="760" border="0" class="page">
  <caption>Articles déjà encodés</caption>
  <tr>
    <th>N°</th>
    <th>Article</th>
    <th>PA</th>
    <th>Stock</th>
    <th>Serial</th>  </tr>
<?php
$sql = "SELECT * FROM ". $tblpref ."stock WHERE facture_achat = '$ID_depense'";
$req = mysql_query($sql);

$nombre = 1;

while($data = mysql_fetch_array($req))
{
  $num = $data['ID'];
  $article = $data['article'];
  $serial = $data['serial'];
  
  $sql2 = "SELECT article, prix_htva, stock FROM " . $tblpref ."article WHERE num = '$article'";
  $req2 = mysql_query($sql2);
  $data2 = mysql_fetch_array($req2);
  
  $nom_article = $data2['article'];
  $PA = $data2['prix_htva'];
  $stock = $data2['stock'];

	$nombre = $nombre +1;
		if($nombre & 1){
		$line="0";
		}else{
		$line="1"; 
		}
  
?>
  <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
  	<td class="highlight"><?php echo $num; ?></td>
    <td class="highlight"><?php echo $nom_article; ?></td>
    <td class="highlight"><?php echo $PA; ?> &euro; HTVA </td>
    <td class="highlight"><?php echo $stock; ?></td>		
    <td class="highlight"><?php echo $serial; ?></td>
  </tr>
  <?php
	}
  ?>

<tr>
  <td colspan="5" class="submit">&nbsp;</td>
</tr>
<tr>
<td colspan="5" class="texte0">
<?php
include_once("include/bas.php");
?>
</td></tr>
</table>
</center>
</body>
</html>
