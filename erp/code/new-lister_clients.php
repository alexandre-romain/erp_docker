<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");?>
<script type="text/javascript" src="javascripts/confdel.js"></script>
<?php
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
if ($user_cli == n) { 
echo"<h1>$lang_client_droit";
exit;  
}
 ?> 
<?php 
$sql = " SELECT * FROM " . $tblprefluc ."client WHERE actif != 'non' ";
if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
{
$sql .= " ORDER BY " . $_GET[ordre] . " ASC";
}else{
$sql .= "ORDER BY nom ASC ";
}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<center><table class="boiteaction">
  <caption><?php echo $lang_clients_existants; ?></caption>
 <tr>
 <th><a href="new-lister_clients.php?ordre=civ"><?php echo $lang_civ; ?> </a></th>
 <th><a href="new-lister_clients.php?ordre=nom"><?php echo $lang_nom; ?></a></th>
<th><a href="new-lister_clients.php?ordre=nom2"><?php echo $lang_complement; ?></a></th>
<th><a href="new-lister_clients.php?ordre=rue"><?php echo $lang_rue; ?></a></th>
<th><a href="new-lister_clients.php?ordre=cp"><?php echo $lang_code_postal; ?></a></th>
<th><a href="new-lister_clients.php?ordre=ville"><?php echo $lang_ville; ?></a></th>
<th><a href="new-lister_clients.php?ordre="><?php echo $lang_numero_tva; ?></a></th>
<th><a href="new-lister_clients.php?ordre=tel"><?php  echo $lang_tele;?></a></th>
<th><a href="new-lister_clients.php?ordre=gsm">GSM</a></th>
<th><a href="new-lister_clients.php?ordre=fax"><?php echo $lang_fax;?></a></th>
<th><a href="new-lister_clients.php?ordre=mail"><?php echo $lang_email; ?></a></th>
<th colspan="2"><?php echo $lang_action; ?></th>
</tr>
<?php
$nombre =1;
while($data = mysql_fetch_array($req))
    {
		$nom = $data['nom'];
		$nom_html= addslashes($nom);
		$nom2 = $data['nom2'];
		$rue = $data['rue'];
		$rue = stripslashes($rue);
		$numero = $data['numero'];
		$boite = $data['boite'];
		$ville = $data['ville'];
		$cp = $data['cp'];
		$tva = $data['num_tva'];
		$mail =$data['mail'];
		$num = $data['num_client'];
		$civ = $data['civ'];
		$tel = $data['tel'];
		$gsm = $data['gsm'];
		$fax = $data['fax'];
		$nombre = $nombre +1;
		if($nombre & 1){
		$line="0";
		}else{
		$line="1"; 
		}
		?>
		<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
  	<td class="highlight"><?php echo $civ; ?></td>
		<td class="highlight"><?php echo $nom; ?></td>
		<td class="highlight"><?php echo $nom2; ?></td>
		<td class="highlight"><?php echo $rue." ".$numero; if ($boite !=''){ echo "/".$boite;} ?></td>
		<td class="highlight"><?php echo $cp; ?></td>
		<td class="highlight"><?php echo $ville; ?></td>
		<td class="highlight"><?php echo $tva; ?></td>
		<td class="highlight"><?php echo $tel; ?></td>
		<td class="highlight"><?php echo $gsm; ?></td>
		<td class="highlight"><?php echo $fax; ?></td>
		<td class="highlight"><a href="mailto:<?php echo $mail; ?>" ><?php echo "$mail"; ?></a></td>
		<td class="highlight"><a href='new-edit_client.php?num=<?php echo "$num" ?>'><img border='0'src='image/edit.gif' alt='<?php echo $lang_editer; ?>'></a></td>
		<td class="highlight"><a href='new-del_client.php?num=<?php echo "$num"; ?>' onClick="return confirmDelete('<?php echo"$lang_cli_effa $nom_html ?"; ?>')"><img border='0'src='image/delete.jpg'  alt='<?php echo $lang_supprimer; ?>'></a></td>
		<?php
		}
?>

<tr><TD colspan="12" class="submit"></TD></tr>
</table></center><tr><td>
<?php

echo"</td></tr><tr><td>";
include_once("include/bas.php");
?> 
</td></tr>
<?php
$url = $_SERVER['PHP_SELF'];
$file = basename ($url);
if ($file=="form_client.php") { 
echo"</table>"; 
} ?>
</table>
</body>
</html>
