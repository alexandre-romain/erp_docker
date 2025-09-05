<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/headers.php");
include_once("include/finhead.php");
include_once("include/head.php");
if ($user_admin != y) { 
	echo "<h1>$lang_admin_droit";
	exit;
}
$num_client=$_POST['num_client'];

$sql3 = "SELECT nom2 FROM " . $tblpref ."client WHERE num_client='$num_client' ";
$req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());
$data3 = mysql_fetch_array($req3);
$nom = $data3['nom2'];


foreach ($_POST['list_nc'] as $num_nc) {
	$sql = "SELECT article, article_num, fact_num, serial, p_u_jour, quanti 
	FROM " . $tblpref ."cont_nc 
	RIGHT JOIN " . $tblpref ."article ON " . $tblpref ."cont_nc.article_num=" . $tblpref ."article.num 
	WHERE nc_num = $num_nc";
	
	$result = mysql_query($sql) or die ("requete foreach1 impossible");
	?>
    <br/>
	<table class="main_table" align="center" width="760px">
		<tr>
			<td colspan="6" class="main_table_header">Détail NC n°<?php echo $num_nc." pour ".$nom; ?></td>
		</tr>
		<tr>
			<th class="subtitle">Article</th>
			<th class="subtitle">N° de série</th>
			<th class="subtitle">N° de facture</th>
			<th class="subtitle">Prix unitaire</th>
            <th class="subtitle">Quantit&eacute;</th>
            <th class="subtitle">Total HTVA</th>
		</tr>
		<?php
		while ($data = mysql_fetch_array($result)) {
			$article= $data['article'];
			$serial= $data['serial'];
			$prix= $data['p_u_jour'];
			$fact_num = $data['fact_num'];
			$quanti = $data['quanti'];
			?>
			<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
				<td><?php echo $article; ?></td>
				<td><?php if ($serial == '' || $serial== 'aucun') {echo 'NA';} else {echo $serial;} ?></td>
				<td><?php echo $fact_num; ?></td>
				<td><?php echo $prix; ?> &euro;</td>
                <td><?php echo $quanti; ?></td>
                <td><?php echo $quanti*$prix; ?> &euro;</td>
			</tr><?php
		} //fin du while
?>
</table>
<?php	
}//fin du 1er foreach
?>
<form action="./lister_nc_suite.php" method="post">
<input type="hidden" value="<?php echo $num_client; ?>" name="listeville" id="listeville" />
<br/>
<input type="submit" value="Retour" class="submit"/>
</form>
<?php
include_once("include/bas.php");
?> 