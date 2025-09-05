<?php 
include_once("include/verif.php");
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

$client=isset($_POST['listeville'])?$_POST['listeville']:"";
$tarif=isset($_POST['tarif'])?$_POST['tarif']:"";
$timestamp = time();

$rqSql = "SELECT duree, deplacements FROM " . $tblpref ."tarifs WHERE ID = $tarif";
$result = mysql_query( $rqSql ) or die( "Exécution requête impossible.");
$data = mysql_fetch_array($result);
  
  $temps_restant = $data['duree'] * 60;
  $deplacements_restant = $data['deplacements'];
  

include_once("include/language/$lang.php"); 

echo "<h2>Abonnement créé</h2>";

mysql_select_db($db) or die ("Could not select $db database");
$sql1 = "INSERT INTO " . $tblpref ."abos(client, date, tarif, temps_restant, deplacements_restant) VALUES ('$client', '$timestamp', '$tarif', '$temps_restant', '$deplacements_restant')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

include_once("lister_abos.php");
?>
</td></tr><tr><td>

<?php
include_once("include/bas.php");
?>
</td></tr></table>
</body>
</html>