<?php 
/*
 * Factux le facturier libre
 * Copyright (C) 2003-2004 Guy Hendrickx
 * 
 * Licensed under the terms of the GNU  General Public License:
 * 		http://www.opensource.org/licenses/gpl-license.php
 * 
 * For further information visit:
 * 		http://factux.sourceforge.net
 * 
 * File Name: bon.php
 * 	Editor configuration settings.
 * 
 * * Version:  1.1.5
 * * * * Modified: 23/07/2005
 * 
 * File Authors:
 * 		Guy Hendrickx
 *.
 */
 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
?><!--MMDW 1 -->
<table mmdw=0 width="760" border="0" class="page" align="center">
<tr>
<td mmdw=1 class="page" align="center">
<!--MMDW 2 --><?php
include_once("include/head.php");
?><!--MMDW 3 -->
</td>
</tr>
<tr>
<td mmdw=2  class="page" align="center">
<!--MMDW 4 --><?php
$client=isset($_POST['listeville'])?$_POST['listeville']:"";
$date=isset($_POST['date'])?$_POST['date']:"";

list($jour, $mois,$annee) = preg_split('/\//', $date, 3);

include_once("include/language/$lang.php"); 
if($client=='0')
    {
    $message="<h1> $lang_choix_client</h1>";
    include('form_commande.php');
    exit;
    }

$sql_nom = "SELECT  nom, nom2 FROM " . $tblpref ."client WHERE num_client = $client";
$req = mysql_query($sql_nom) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$nom = $data['nom'];
		$nom2 = $data['nom2'];
		$phrase = "$lang_bon_cree";
		echo "$phrase $nom $nom2 $lang_bon_cree2 $date<br>";
		}
$sql1 = "INSERT INTO " . $tblpref ."bon_comm(client_num, date) VALUES ('$client', '$annee-$mois-$jour')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
?><!--MMDW 5 -->
<center>
<form mmdw=3 name='formu2' method='post' action='bon_suite.php'>
    <table mmdw=4 class="boiteaction">
      <caption><!--MMDW 6 --><? echo $lang_donne_bon ; ?><!--MMDW 7 --></caption>
      <tr>
        <td mmdw=5 class="texte0"><!--MMDW 8 --><?php echo $lang_quanti; ?><!--MMDW 9 --> </td>
        <td mmdw=6 class="texte0" colspan="3"><input mmdw=7 name='quanti' type='text' id='quanti' size='6'></td>
				</tr>
				<tr>
			   <td mmdw=8 class="texte0"><!--MMDW 10 --><?php echo "$lang_article";
				 include_once("include/configav.php");
				  if ($use_categorie !='y') { 
  

				 $rqSql = "SELECT uni, num, article, prix_htva FROM " . $tblpref ."article WHERE actif != 'non' ORDER BY article, prix_htva";
				 $result = mysql_query( $rqSql )
             or die( "Exécution requête impossible.");?><!--MMDW 11 -->
        <td mmdw=9 class="texte0"><SELECT mmdw=10 NAME='article'>
            <OPTION mmdw=11 VALUE=0><!--MMDW 12 --><?php echo $lang_choisissez; ?><!--MMDW 13 --></OPTION>
            <!--MMDW 14 --><?php
						while ( $row = mysql_fetch_array( $result)) {
    							$num = $row["num"];
    							$article = $row["article"];
									$prix = $row["prix_htva"];
									$uni = $row["uni"];
    							?><!--MMDW 15 -->
            <OPTION mmdw=12 VALUE='<?php echo $num; ?>'><!--MMDW 16 --><?php echo "$article $prix $devise / $uni"; ?><!--MMDW 17 --></OPTION>
            <!--MMDW 18 --><?php
						}
						?><!--MMDW 19 -->
           </SELECT>
					 <!--MMDW 20 --><?php }else{?><!--MMDW 21 -->
					 <td mmdw=13 class="texte0">
					 <!--MMDW 22 --><?php
					 include("include/categorie_choix.php"); 
					 }
					 ?><!--MMDW 23 -->
			</td>
			<!--MMDW 24 --><?php 
if ($lot=='y') { ?><!--MMDW 25 -->
<td mmdw=14 class="texte0">Lot </td>
		<!--MMDW 26 --><?php $rqSql = "SELECT num, prod FROM " . $tblpref ."lot WHERE actif != 'non' ORDER BY num";
			$result = mysql_query( $rqSql )
             or die( "Exécution requête impossible.");?><!--MMDW 27 -->
					<td mmdw=15 class="texte0"><SELECT mmdw=16 NAME='lot'>
					<OPTION mmdw=17 VALUE=0><!--MMDW 28 --><?php echo $lang_choisissez; ?><!--MMDW 29 --></OPTION>
            <!--MMDW 30 --><?php
						while ( $row = mysql_fetch_array( $result)) {
    							$num = $row["num"];
    							$prod = $row["prod"];
		    ?><!--MMDW 31 -->
            <OPTION mmdw=18 VALUE='<?php echo $num; ?>'><!--MMDW 32 --><?php echo "$num $prod "; ?><!--MMDW 33 --></OPTION>
						
					<!--MMDW 34 --><?php 
}
 ?><!--MMDW 35 --> </SELECT></td>  
<!--MMDW 36 --><?php  }
 ?><!--MMDW 37 --> 
      </tr>
      <tr>
        	 		<td mmdw=19 class="submit" colspan="4"><input mmdw=20 name="nom" type="hidden" id="nom" value="<?php echo $nom ?>"><input mmdw=21 type="submit" name="Submit" value='<?php echo "$lang_valid "; ?>'></td>
      </tr>
    
    
  </table></form></center>
</td></tr><tr><td>

<!--MMDW 38 --><?php
include("help.php");
echo"</td></tr><tr><td>";
include_once("include/bas.php");
?><!--MMDW 39 --></td></tr></table>
</body>
</html>
<!-- MMDW:success -->