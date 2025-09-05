<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");?>
<script type="text/javascript" src="javascripts/confdel.js"></script>
<?php
include_once("include/finhead.php");
include_once("include/head.php");
$user = $_SERVER[PHP_AUTH_USER]; //login dans cette variable
//On inclus le footer apres la récupération de la variable $user; pour pouvoir la récupérer
include_once("include/elements/footer.php");
$sql = "SELECT * FROM " . $tblpref ."tarifs";
if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
{
$sql .= " ORDER BY " . $_GET[ordre] . " DESC";
}else{
$sql .= " ORDER BY ID DESC ";
}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<br/>
<center>
<table class="main_table">
  	<tr>
    	<td colspan="10" class="main_table_header">Liste des Tarifs</td>
    </tr>
  	<tr>
        <th class="subtitle"><a href="lister_tarifs.php?ordre=description">Description</a> </th>
        <th class="subtitle"><a href="lister_tarifs.php?ordre=prix">Prix (HTVA)</a> </th>
        <th class="subtitle"><a href="lister_tarifs.php?ordre=duree">Durée (heures)</a> </th>
        <th class="subtitle"><a href="lister_tarifs.php?ordre=validité">Validité (jours)</a> </th>
        <th class="subtitle"><a href="lister_tarifs.php?ordre=deplacements">Déplacements</a> </th>
        <th colspan="5" class="subtitle">Action</th>
	</tr>
  	<?
	$nombre =1;
	while($data = mysql_fetch_array($req))
    {
		$description = $data['description'];
		$prix = $data['prix'];
		$duree = $data['duree'];
		$validite = $data['validite'];
		$deplacements = $data['deplacements'];
		$ID_tarif = $data['ID'];
		$nombre = $nombre +1;
		if($nombre & 1){
		$line="0";
		}else{
		$line="1";
		}
		?>
  		<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
            <td class="highlight"><?php echo $description; ?></td>
            <td class="highlight"><?php echo $prix; ?></td>
            <td class="highlight"><?php echo $duree; ?></td>
            <td class="highlight"><?php echo $validite; ?></td>
            <td class="highlight"><?php echo $deplacements; ?></td>
    		<td class="highlight">
                <a href="edit_tarifs.php?ID=<?php echo $ID_tarif; ?>"> 
                <img src="image/edit.gif" align="middle" border="0"alt="<?php echo $lang_editer; ?>">
                </a>
            </td>
			<td class="highlight">
            	<a href="delete_tarifs.php?ID=<?php echo $ID_tarif; ?>" onClick="return confirmDelete('<?php echo"Êtes-vous sûr de vouloir effacer le tarif ".$description." ?"; ?>')">
				<img src="image/delete.jpg" align="middle" border="0" alt="<?php echo $lang_supprimer; ?>">
                </a>
           	</td>
       	</tr>
	<?php
	}
 	?>
</table>
</center>
<?php
include_once("include/bas.php");
$url = $_SERVER['PHP_SELF'];
$file = basename ($url); 
if ($file=="form_tarifs.php") { 
	echo"</table>";  
}
?>
</body>
</html>