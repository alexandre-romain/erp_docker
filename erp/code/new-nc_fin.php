<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/headers.php");
include_once("include/finhead.php");?>
<center><table class="boiteaction">
  <tr> 
    <th colspan="7">
<?php
include_once("include/head.php");
if ($user_admin != y) { 
echo "<h1>$lang_admin_droit";
exit;
}
?>
</th>
</tr>

<?php

//on traite les bl à facturer
if (isset($list_fact)) {
	foreach ($list_fact as $num) {
		$sql = "SELECT " . $tblprefluc ."cont_bl.num AS ligne, article, article_num, serial, num_bl, tot_art_htva FROM " . $tblprefluc ."bl RIGHT JOIN " . $tblprefluc ."cont_bl ON num_bl=bl_num RIGHT JOIN " . $tblprefluc ."article ON " . $tblprefluc ."cont_bl.article_num=" . $tblprefluc ."article.num WHERE fact_num = $num ORDER BY num_bl";
		
		$result = mysql_query($sql) or die ("requete foreach1 impossible");
		?><tr>
			<th colspan="7"><h2>Détail facture n°<?php echo $num; ?></h2></th>
		</tr>
		<tr>
			<th>N° BL</th>
			<th>Article</th>
			<th>N° de série</th>
			<th>Prix HTVA</th>
			<th>N° de ligne</th>
			<th>Etat</th>
			<th>Ajouter 1 unité?</th>
		</tr><?php
		while ($data = mysql_fetch_array($result)) {
			$numBL= $data['num_bl'];
			$test= $data['article_num'];
			$test2= $data['article_num'];
			$article= $data['article'];
			$serial= $data['serial'];
			$prix= $data['tot_art_htva'];
			$ligne= $data['ligne'];
			$sql2 = "SELECT status FROM " . $tblprefluc ."stock WHERE article = $test AND serial= '".$serial."' ";
			mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
			$result2 = mysql_query($sql2) or die ("requete foreach1 impossible");
			$data2 = mysql_fetch_array($result2);
			$status = $data2['status'];
			?>
			<form action="new-edit_nc.php" method="post"><tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
				<td><?php echo $numBL; ?></td>
				<td><?php echo $article; ?></td>
				<td><?php echo $serial; ?></td>
				<td><?php echo $prix; ?> &euro;</td>
				<td><?php echo $ligne; ?></td>
				<td><input  name="update_stock[]" type="checkbox" value="<? echo $test; ?>" <?php if ($status!="out"){echo "checked='checked'";} ?>/>
				<input type="hidden" name="sery[]" value="<? echo $serial ?>" /></td>
				<td><input  name="update_article[]" type="checkbox" value="<? echo $test2; ?>" /></td>
			</tr><?php
		}
?>
<tr>
	<td colspan="7"><input type="submit" value="edit" /></td>
</tr></form>
<tr><td colspan="7">
<?php	}
 }
include_once("include/bas.php");
?> 
</td></tr></table>