<?php 
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");

include_once("include/language/$lang.php");
include_once("include/headers.php");
?>
<SCRIPT LANGUAGE="JavaScript">
var lequel=""; 
var lautre=""; 
var ledernier="PV";
var valeur=0;
function conv(f) {
	if (lequel=="prix") {valeur=(parseFloat(f.elements[lequel].value)/100)*(parseFloat(f.elements[lautre].value)+ 100);}
	if (lequel=="marge")  {valeur=(parseFloat(f.elements[lautre].value)/100)*(parseFloat(f.elements[lequel].value)+ 100);}
	if (isNaN(valeur)) {
		return false;	
	} else {
		return true;
	}
}
function Start() {
	if (lequel!="") {
		var f=document.forms["article"];
		if (conv(document.forms["article"])) {
			document.forms["article"].elements[ledernier].value=valeur;
		}
		// astuce pour netscape !
		if (document.layers) {
			document.forms["article"].elements[lequel].blur()
			document.forms["article"].elements[lequel].focus()
		}
	}
	setTimeout("Start()",100);
}
</SCRIPT>
<?
include_once("include/finhead.php");

$article=isset($_GET['article'])?$_GET['article']:"";
$sql = "SELECT * FROM " . $tblpref ."article  left join " . $tblpref ."categorie on " . $tblpref ."article.cat = " . $tblpref ."categorie.id_cat
 WHERE num=$article";

$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
    {
		$article_nom = $data['article'];
		$num = $data['num'];
		$prix = $data['prix_htva'];
		$tva = $data['taux_tva'];
		$uni = $data['uni'];
		$stock = $data['stock'];
		$min = $data['stomin'];
		$max = $data['stomax'];
		$cate = $data['categorie'];
		$cat_id = $data['id_cat'];
		$uni = $data['uni'];
		$marge = $data['marge'];
		$garantie = $data['garantie'];
		$reference = $data['reference'];
		$marque = $data['marque'];
		$recupel = $data['recupel'];
		$reprobel = $data['reprobel'];
		$bebat = $data['bebat'];
		}
include_once("include/head.php");
?>
<br/>
<center>
<form action="article_update.php" metdod="post" name="article" id="article">
<table class="main_table">
 	<tr>
    	<td colspan="3" class="main_table_header"><?php echo $lang_modi_pri.' '.$article; ?></td>
    </tr>
    <tr>
   		<td class="main_table"><?php echo "$lang_categorie" ?></td>
   		<td class="main_table_left">
			<?php 
 			$rqSql = "SELECT id_cat, categorie FROM " . $tblpref ."categorie WHERE 1 ORDER BY categorie";
			$result = mysql_query( $rqSql ) or die( "Exécution requête impossible."); ?> 
			<SELECT NAME='categorie'>
			 	<OPTION VALUE='<?php echo"$cat_id" ?>'><?php echo $cate; ?></OPTION>
			 	<?php
				while ( $row = mysql_fetch_array( $result)) {
					$num_cat = $row["id_cat"];
					$categorie = $row["categorie"];
					?>
				 	<OPTION VALUE='<?php echo "$num_cat" ; ?>'><?php echo "$categorie"; ?></OPTION>
				<?
				}
				?>
			</SELECT>
    	</td>
    </tr>
 	<tr>
   		<td class="main_table">Marque</td>
   		<td class="main_table_left"><input name="marque" type="text" id="marque" value ="<?php echo"$marque" ?>" size="25"></td>
 	</tr>
    <tr>
   		<td class="main_table">Description</td>
   		<td class="main_table_left"><input name="article_nom" type="text" id="article_nom" value ="<?php echo"$article_nom" ?>" size="25"></td>
 	</tr>
    <tr>
 		<td class="main_table">R&eacute;f&eacute;rence</td>
 		<td class="main_table_left"><input name="reference" type="text" id="reference" value ="<?php echo"$reference" ?>" size="25"></td>
 	</tr>
    <tr>
   		<td class="main_table">Unit&eacute;</td>
   		<td class="main_table_left"><input name="uni" type="text" id="uni" value ="<?php echo"$uni" ?>"></td>
 	</tr>
    <tr>
   		<td class="main_table">PA</td>
   		<td class="main_table_left"><input name="prix" onFocus="lequel='prix';lautre='marge'" onmouseover="Start()" type="text"  value ="<?php echo"$prix" ?>"> &euro; HTVA</td>
 	</tr>
    <tr>
   		<td class="main_table">Marge</td>
   		<td class="main_table_left"><input name="marge" type="text" onFocus="lequel='marge';lautre='prix'" onmouseover="Start()" id="marge"  value ="<?php echo"$marge" ?>"> %</td>
 	</tr>
    <tr>
   		<td style="background:#999; height:5px" colspan="3"></td>
 	</tr>
    <tr>
   		<td class="main_table">Calcul du PV </td>
   		<td class="main_table_left"><input name="PV" type="text" onmouseover="Start()" readonly="readonly" id="PV"> &euro; HTVA</td>
 	</tr>
    <tr>
   		<td style="background:#999; height:5px" colspan="3"></td>
 	</tr>
    <tr>
   		<td class="main_table">Recupel</td>
   		<td class="main_table_left"><input name="recupel" type="text" id="recupel"  value ="<?php echo"$recupel" ?>"> &euro; HTVA</td>
 	</tr>
    <tr>
   		<td class="main_table">Reprobel</td>
   		<td class="main_table_left"><input name="reprobel" type="text" id="reprobel"  value ="<?php echo"$reprobel" ?>"> &euro; HTVA</td>
 	</tr>
    <tr>
   		<td class="main_table">Bebat</td>
   		<td class="main_table_left"><input name="bebat" type="text" id="bebat"  value ="<?php echo"$bebat" ?>"> &euro; HTVA</td>
 	</tr>
    <tr>
   		<td style="background:#999; height:5px" colspan="3"></td>
 	</tr>
    <tr>
   		<td class="main_table">Stock actuel </td>
   		<td class="main_table_left"><input name="stock" type="text" value ="<?php echo"$stock" ?>"></td>
 	<tr>
   		<td class="main_table">Stock Min </td>
   		<td class="main_table_left"><input name="min" type="text" value ="<?php echo"$min" ?>"></td>
 	<tr>
   		<td class="main_table">Stock Max </td>
   		<td class="main_table_left"><input name="max" type="text" value ="<?php echo"$max" ?>"></td>
 	<tr>
   		<td style="background:#999; height:5px" colspan="3"></td>
 	<tr>
   		<td class="main_table">Garantie</td>
   		<td class="main_table_left"><input name="garantie" type="text" id="garantie" value ="<?php echo"$garantie" ?>"></td>
 	</tr>
    <tr>
    	<td colspan="3" class="main_table_header">
   			<input type="submit" name="Submit" value="<?php echo $lang_envoyer; ?>" class="submit">
   			<input name="article" type="hidden" id="article" value="<? echo $article; ?>">
		</td>
 	<tr>
</table>
</form>	
</center>		
<?php
include_once("include/bas.php");
?>