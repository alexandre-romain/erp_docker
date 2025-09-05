<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
?>
<script type="text/javascript" src="javascripts/confdel.js"></script>
<?php
include_once("include/finhead.php");
include_once("include/configav.php");
include_once("include/head.php");
$user = $_SERVER[PHP_AUTH_USER]; //login dans cette variable
//On inclus le footer apres la récupération de la variable $user; pour pouvoir la récupérer
include_once("include/elements/footer.php");
if ($user_art == n) { 
	echo "<h1>$lang_article_droit";
	exit;  
}
if ($message !='') { 
 	echo $message; 
}
$sql = "SELECT * FROM " . $tblpref ."article 
	LEFT JOIN " . $tblpref ."categorie ON " . $tblpref ."categorie.id_cat = " . $tblpref ."article.cat1
	WHERE actif != 'non' ";
if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '') {
	$sql .= " ORDER BY " . $_GET[ordre] . " ASC";
}
else {
	$sql .= "ORDER BY categorie ASC ";
}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
?>
<br/>
<center>
<table class="main_table_80" align="center">	
	<tr>
		<td class="main_table_header" colspan="16"><?php echo $lang_articles_liste; ?></td>
   	</tr>
  	<tr> 
	<?php
	if ($use_categorie =='y') { 
	?>	
    	<th class="subtitle">Num.</th>
		<th class="subtitle"><a href="lister_articles.php?ordre=categorie"><?php echo $lang_categorie ?></a></th>
	<?php 
	} 
	?>
    	<th class="subtitle"><a href="lister_articles.php?ordre=marque">Marque</a></th>
		<th class="subtitle"><a href="lister_articles.php?ordre=article"><?php echo $lang_article; ?></a></th>
    	<th class="subtitle"><a href="lister_articles.php?ordre=reference">Référence</a></th>
    	<th class="subtitle"><a href="lister_articles.php?ordre=prix_htva">P.A.</a></th>
    	<th class="subtitle"><a href="lister_articles.php?ordre=commentaire">Commentaire</a></th>	
		<?php
		if($use_stock=='y'){?>
			<th class="subtitle"><a href="lister_articles.php?ordre=stock"><?php echo $lang_stock; ?></a></th>
		<?php 
		} 
		?>
		<th class="subtitle"><a href="lister_articles.php?ordre=marge">Marge</a></th>
		<th class="subtitle"><a href="lister_articles.php?ordre=garantie">Garantie</a></th>
		<th class="subtitle"><a href="lister_articles.php?ordre=recupel">Recupel (HTVA)</a></th>
		<th class="subtitle"><a href="lister_articles.php?ordre=reprobel">Reprobel (HTVA)</a></th>
		<th class="subtitle"><a href="lister_articles.php?ordre=bebat">Bebat (HTVA)</a></th>
		<th valign="middle" class="subtitle">PV</th>
    	<th colspan="2" valign="middle" class="subtitle"><?php echo $lang_action; ?></th>
  	</tr>
  	<?php
	$nombre="1";
	while($data = mysql_fetch_array($req))
    {
		$article = $data['article'];
		$article_html=addslashes($article);
		$article = htmlentities($article, ENT_QUOTES);
		$cat = $data['cat1'];
		$cat = htmlentities($cat, ENT_QUOTES);
		$num =$data['num'];
		$prix = $data['prix_htva'];
		$tva = $data['taux_tva'];
		$uni = $data['uni'];
		$stock = $data['stock'];
		$min = $data['stomin'];
		$max = $data['stomax'];
		$marque = $data['marque'];
		$reference = $data['reference'];
		$commentaire = $data['commentaire'];
		$marge = $data['marge'];
		$garantie = $data['garantie'];
		$recupel = $data['recupel'];
		$reprobel = $data['reprobel'];
		$bebat = $data['bebat'];
		
		if ($marge != 0) {
			$PV = $prix + ($prix/100*$marge);
		} 
		else {
			$PV = $prix;
		}
		if ($stock < $min ||$stock > $max  ) { 
  			$stock="<h1>$stock</h1>";
		}
		$nombre = $nombre +1;
		if($nombre & 1){
			$line="0";
		}
		else {
			$line="1";
 		}
		?>
		<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
		<?php 
		if ($use_categorie =='y') { ?>
        	<td class="highlight"><?php echo $num; ?></td>	
			<td class="highlight"><?php echo $cat; ?></td>
		<?php 
		} 
		?>
			<td class="highlight"><?php echo $marque; ?></td>
			<td class="highlight"><?php echo $article; ?></td>
			<td class="highlight"><?php echo $reference; ?></td>
            <td class="highlight"><?php echo montant_financier ($prix); ?></td>
            <td class="highlight"><?php echo $commentaire; ?></td>
			<?php
			if($use_stock=='y'){?>
				<td class="highlight"><?php echo $stock; ?></td>
			<?php 
			} 
			?>
	        <td class="highlight"><?php if ($marge != ""){echo $marge." %"; }?></td>		
			<td class="highlight"><?php echo $garantie; ?></td>
	        <td class="highlight"><?php if ($recupel != ""){echo $recupel." &euro;"; }?></td>
	        <td class="highlight"><?php if ($reprobel != ""){echo $reprobel." &euro;"; }?></td>
	        <td class="highlight"><?php if ($bebat != ""){echo $bebat." &euro;"; }?></td>
			<td class="highlight"><?php echo montant_financier ($PV); ?></td>
    		<td class="highlight">
            	<a href='edit_art.php?article=<?php echo $num; ?>'>
	        	<img border=0 alt="<?php echo $lang_editer; ?>" src="image/edit.gif"></a>
            </td>
			<td class="highlight">
            	<a href="delete_article.php?article=<?php echo $num; ?>" onClick="return confirmDelete('<?php echo"$lang_art_effa $article_html ?"; ?>')">
	            <img border=0 alt="<?php echo $lang_suprimer; ?>" src="image/delete.jpg" ></a>
            </td>
      	</tr>
	<?php
	}
 	?>
</table>
</center>
<?php
include_once("include/bas.php");
?>
</body>
</html>
