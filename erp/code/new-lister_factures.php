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
if ($user_fact == n) { 
echo "<h1>$lang_facture_droit";
exit;
}
 ?>
<?php 
$sql = "SELECT mail, DATE_FORMAT(date_fact,'%d/%m/%Y') AS date_fact,
               total_fact_ttc, payement, num_client, date_deb, dev_num, explic, 
			   DATE_FORMAT(date_deb,'%d/%m/%Y') AS date_deb2, date_fin,
			   DATE_FORMAT(date_fin,'%d/%m/%Y') AS date_fin2, num, nom
	    FROM " . $tblprefluc ."facture RIGHT JOIN " . $tblprefluc ."client on client = num_client LEFT JOIN " . $tblprefluc ."devis on dev_num = num_dev
        WHERE num >0 ";
				//ORDER BY 'num' DESC
				if ($user_fact == r) { 
$sql = "SELECT mail, DATE_FORMAT(date_fact,'%d/%m/%Y') AS date_fact,
               total_fact_ttc, payement, num_client, date_deb, dev_num, explic, 
			   DATE_FORMAT(date_deb,'%d/%m/%Y') AS date_deb2, date_fin,
			   DATE_FORMAT(date_fin,'%d/%m/%Y') AS date_fin2, num, nom
	    FROM " . $tblprefluc ."facture RIGHT JOIN " . $tblprefluc ."client on client = num_client RIGHT JOIN " . $tblprefluc ."devis on dev_num = num_dev
        WHERE num >0 
	 and " . $tblprefluc ."client.permi LIKE '$user_num,' 
	 or  " . $tblprefluc ."client.permi LIKE '%,$user_num,' 
	 or  " . $tblprefluc ."client.permi LIKE '%,$user_num,%' 
	 or  " . $tblprefluc ."client.permi LIKE '$user_num,%' 
	";  
	//ORDER BY 'num' DESC
}
if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
{
$sql .= " ORDER BY " . $_GET[ordre] . " DESC";
}else{
$sql .= "ORDER BY num DESC ";
}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<center><table class="boiteaction">
  <caption><?php echo $lang_tou_fact; ?></caption>
  <tr> 
    <th><a href="new-lister_factures.php?ordre=num"><?php echo $lang_numero; ?></a></th>
    <th><a href="new-lister_factures.php?ordre=nom"><?php echo $lang_client; ?></a></th>
    <th><a href="new-lister_factures.php?ordre=total_fact_ttc"><?php echo $lang_tot_ttc; ?></a></th>
    <th><a href="new-lister_factures.php?ordre=date_fact"><?php echo $lang_date; ?></a></th>
	<th><a href="new-lister_factures.php?ordre=explic">Dénomination</a></th>
		<th><a href="new-lister_factures.php?ordre=payement"><?php echo $lang_pay; ?></a></th>
    <th colspan="4"><?php echo $lang_action; ?></th>
  </tr>
  <?php
	$nombre=1;
while($data = mysql_fetch_array($req))
{
  $client = $data['nom'];
	$client = htmlentities($client, ENT_QUOTES);
	$nom_html = urlencode($client);
  $debut = $data['date_deb2'];
  $debut2 = $data['date_deb'];
  $fin = $data['date_fin2'];
  $fin2 = $data['date_fin'];
  $pay = $data['payement'];
    $explic = $data['explic'];
	$nombre = $nombre +1;
		if($nombre & 1){
		$line="0";
		}else{
		$line="1";
 		}
	switch ($pay) {
	case carte:
   $payement="$lang_carte_ban";
   break;
	case "liquide":
   $payement="$lang_liquide";
   break;
	case "ok":
   $payement="$lang_pay_ok";
   break;
	case "paypal":
   $payement="$lang_paypal";
   break;
	case "virement":
   $payement="$lang_virement";
   break;
	case "visa":
   $payement="$lang_visa";
   break;
	case "non":
   $payement="<font color=red>$lang_non_pay</font>";
   break;
	 }
  $num = $data['num'];
  $num_client =$data['num_client'];
  $total = $data['total_fact_ttc'];
  $date_fact = $data['date_fact'];
	$mail = $data['mail'];
  ?>
  <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
  	<td class="highlight"><?php echo $num; ?></td>
    <td class="highlight"><?php echo $client; ?></td>
    <td class="highlight"><?php echo montant_financier($total); ?></td>
    <td class="highlight"><?php echo $date_fact; ?></td>
	<td class="highlight"><?php echo $explic; ?></td>
	<td class="highlight"><?php echo $payement; ?></td> 
    <td class="highlight">
				<a href="fpdf/facture_pdf.php?num=<?php echo $num; ?>&amp;nom=<?php echo $nom_html; ?>&amp;pdf_user=adm" target="_blank">
				<img src="image/printer.gif" alt="<?php echo $lang_imprimer; ?>" align="middle" border="0" ></a></td>

<td class="highlight">
<?
if ($mail != '') {
?>
 <td class="highlight">
 <form action="fpdf/fact_pdf.php" method="post" onClick="return confirmDelete('<?php echo"$lang_conf_env $num $lang_conf_env2 $client ?"; ?>')">
		<input type="hidden" name="client" value="<?php echo $num_client ?>" />
		<input type="hidden" name="debut" value="<?php echo $debut2 ?>" />
		<input type="hidden" name="fin" value="<?php echo $fin2 ?>" />
		<input type="hidden" name="num" value="<?php echo $num ?>" />	
		<input type="hidden" name="user" value="adm" />
		<input type="hidden" name="mail" value="y" />
		<input type="image" src="image/pdf.gif" style=" border: none; margin: 0;" alt="envoyer par mail" />
		</form>
  </td>
  </tr>
  <?php
	}else{
?>
<td class="highlight">
<?php
}
}
?>
 
</td></tr>
<tr><TD colspan="11" class="submit"></TD></tr></table></center>
<tr><td>
<?php
echo"</td></tr><tr><td>";
include_once("include/bas.php");
?>
</td></tr>
</table>
</body>
</html>
