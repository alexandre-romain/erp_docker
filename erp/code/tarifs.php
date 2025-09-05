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

$description=isset($_POST['description'])?$_POST['description']:"";
$prix=isset($_POST['prix'])?$_POST['prix']:"";
$duree=isset($_POST['duree'])?$_POST['duree']:"";
$validite=isset($_POST['validite'])?$_POST['validite']:"";
$deplacements=isset($_POST['deplacements'])?$_POST['deplacements']:"";

include_once("include/language/$lang.php"); 

echo "<h2>Tarif créé</h2>";

mysql_select_db($db) or die ("Could not select $db database");
$sql1 = "INSERT INTO " . $tblpref ."tarifs(description, prix, duree, validite, deplacements) VALUES ('$description', '$prix', '$duree', '$validite', '$deplacements')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

include_once("lister_tarifs.php");
?>
</td></tr><tr><td>

<?php
include_once("include/bas.php");
?>
</td></tr></table>
</body>
</html>