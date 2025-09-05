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
$rqSql = "SELECT num_client, nom FROM " . $tblprefluc ."client WHERE actif != 'non'";
if ($user_dev == r) { 
$rqSql = "SELECT num_client, nom FROM " . $tblprefluc ."client WHERE actif != 'non'
		 			 				 AND (" . $tblprefluc ."client.permi LIKE '$user_num,' 
		 			 				 or  " . $tblprefluc ."client.permi LIKE '%,$user_num,' 
									 or  " . $tblprefluc ."client.permi LIKE '%,$user_num,%' 
									 or  " . $tblprefluc ."client.permi LIKE '$user_num,%') ";
}

$annee = date("Y");
$mois = date("m");
$jour = date("d");

?>
</td>
</tr>
<tr>
<td  class="page" align="center">
<?php
if ($message !='') { 
echo"<table width=\"100%\"><tr align=\"center\"><td><h2>".$message."</h2></td></tr></table>";  
}
?> 
<form name="formu" method="post" action="nc_suite.php" >
  <center><table >
    <caption>Choisissez un client</caption>
    <tr> 
      <td class="texte0"><?php echo "$lang_client"; ?></td>
      <td class="texte0">
			<?php 
						require_once("include/configav.php");
						if ($liste_cli!='y') { 
						$rqSql="$rqSql order by nom";
						echo"$rqSql";
						$result = mysql_query( $rqSql ) or die( "Exécution requête impossible.");
 ?>  
			<SELECT NAME='listeville'>
          <OPTION VALUE='0'><?php echo $lang_choisissez; ?></OPTION>
          <?php

							 while ( $row = mysql_fetch_array( $result)) {
    					 $numclient = $row["num_client"];
    					 $nom = $row["nom"];
    					 ?>
          		 <OPTION VALUE='<?php echo $numclient; ?>'><?php echo $nom; ?></OPTION>
          		 <?php 
							 }
							 ?>
        </SELECT>
				<?php }else{include_once("include/new-choix_cli.php");
										} ?> 
							 </td>
    </tr>f
    <tr> 
      <td class="submit" colspan="2"><input type="submit" name="Submit" value="<?php echo "Afficher les factures" ?>">
      </td>
    
  </table></center>
</form>
</td><tr><td>

<?php
include_once("lister_nc.php");
?> 

