<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
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

		$sql = "UPDATE " . $tblpref ."article SET

				uni = 'P'
				
				WHERE uni = 'pcs'";
		mysql_query($sql) or die ("requete impossible - v�rifier format de donn�es.");
?>
</td>
</tr>
<tr>
<td>Bon, ben j'esp�re que c'�tait pas pour du rire paske le stock est vid� !</td>
<td>&nbsp;</td>
</tr>

</table>