<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
		$sql = "DELETE FROM gest_tarifs WHERE ID = $ID";
		mysql_query($sql) or die ("Effacement impossible.");

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
echo "<table width=\"100%\"><tr align=\"center\"><td><h2>Le tarif a été supprimé</h2></td></tr></table>";  
?>
<?php
echo"</td></tr><tr><td>";
include_once("include/bas.php");
?>
</td></tr>
</table>
</body>
</html>