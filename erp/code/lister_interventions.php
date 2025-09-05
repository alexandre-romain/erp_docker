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


<table width="760"  class="page" align="center">
<tr>
<td class="page" align="center">
<?php
include_once("include/head.php");
?>
</td>
</tr>
<?
if (isset($message)) { 
echo "<tr><td><center><h2>".$message."</h2></center></td></tr>";
}
?>
<tr>
<td  class="page" align="center">
<?php 
$mois = date("m");
$annee = date("Y");
//pour le formulaire
?>
<?php 
$mois_1=isset($_POST['mois_1'])?$_POST['mois_1']:"";
$annee_1=isset($_POST['annee_1'])?$_POST['annee_1']:"";

if ($mois_1=='') {
 $mois_1= $mois ;
} 
if ($annee_1=='') { 
 $annee_1= $annee ; 
}

$calendrier = calendrier_local_mois ();
$sql = "SELECT nom, client_num, num_inter, DATE_FORMAT(date,'%d/%m/%Y') AS date, fin, debut, cause, detail, coment, type_deplacement, tarif_special
		 FROM " . $tblpref ."interventions
		 RIGHT JOIN " . $tblpref ."client on " . $tblpref ."interventions.client_num = num_client 
		 WHERE MONTH(date) = $mois_1 AND Year(date)=$annee_1 
		 ";

if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
{
$sql .= " ORDER BY " . $_GET[ordre] . " DESC";
}else{
$sql .= "ORDER BY num_inter DESC ";
}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());

?>
     <center><form action="lister_interventions.php" method="post">
        <table >
  <caption>Lister les Interventions</caption>

          <tr>
		  <td  class="texte0">&nbsp;</td>
            <td  class="texte0"> <select name="mois_1">
			<?php for ($i=1;$i<=12;$i++)
			{
			?>
                <option value="<?php echo $i; ?>"><?php echo ucfirst($calendrier [$i]); ?></option>
				<?php
				}
				?>
              </select> </td><td width="27%" class="texte0">
			  <select name="annee_1">
				<option value="<?php $date=(date("Y")-2);echo"$date"; ?>"><?php $date=(date("Y")-2);echo"$date"; ?></option>
                <option value="<?php $date=(date("Y")-1);echo"$date"; ?>"><?php $date=(date("Y")-1);echo"$date"; ?></option>
				<option value="<?php $date=date("Y");echo"$date"; ?>"><?php $date=date("Y");echo"$date"; ?></option>
				<option value="<?php $date=(date("Y")+1);echo"$date"; ?>"><?php $date=(date("Y")+1);echo"$date"; ?></option>
                <option value="<?php $date=(date("Y")+2);echo"$date"; ?>"><?php $date=(date("Y")+2);echo"$date"; ?></option>
              </select> </td>
			  <td width="29%"  class="texte0">&nbsp;</td>
          </tr>
<tr><td class="submit" colspan="4"><input type="submit" value='<?php echo $lang_envoyer; ?>'></td></tr>        
       </table></form> </center>
		<br>
        <center><table class="boiteaction">
  <caption><?php echo "Interventions du mois de ".$mois_1." ".$annee_1; ?></caption>
          <tr> 
            <th><a href="lister_interventions.php?ordre=num_inter"><?php echo $lang_numero; ?></a></th>
            <th><a href="lister_interventions.php?ordre=nom"><?php echo $lang_client; ?></a></th>
            <th><a href="lister_interventions.php?ordre=date"><?php echo $lang_date; ?></a></th>
            <th><a href="lister_interventions.php?ordre=duree">Durée</a></th>
            <th colspan="5"><?php echo $lang_action; ?></th>
          </tr>
          <?php
	$nombre = 1;
while($data = mysql_fetch_array($req))
{
  $num_inter = $data['num_inter'];
  $date = $data['date'];
  $nom = $data['nom'];
  $nom = htmlentities($nom, ENT_QUOTES);
  $nom_html = htmlentities (urlencode ($nom)); 
  $num_client = $data['num_client'];
  $fin = $data['fin'];
  $debut = $data['debut'];
  $duree_s = $fin - $debut;
  
  $duree_h = (int)($duree_s / 3600);
  $reste = (int)($duree_s % 3600);
  $duree_m = (int)($reste / 60);
  if ($duree_m < 10)
  {
  $duree_m = "0".$duree_m;
  }
  $duree = $duree_h.":".$duree_m;
  
  $nombre = $nombre +1;
	if($nombre & 1){ $line="0";	}else{ 	$line="1"; }
  ?>
          <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
  	   <td class="highlight"><?php echo "$num_inter"; ?></td>
           <td class="highlight"><?php echo "$nom"; ?></td>
           <td class="highlight"><?php echo "$date"; ?></td>
           <td class="highlight"><?php echo "$duree";?></td>
	   		<td class="highlight">
				<a href="fpdf/inter_pdf.php?num_inter=<?php echo $num_inter; ?>&amp;nom=<?php echo $nom_html; ?>&amp;pdf_user=adm" target="_blank">
				<img src="image/printer.gif" alt="<?php echo $lang_imprimer; ?>" align="middle" border="0" ></a></td>


<?
if ($mail != '' ) {
?>
<td class="highlight">
		 <form action="fpdf/interventions_pdf.php" method="post" onClick="return confirmDelete('<?php echo"$lang_con_env_pdf $num_inter"; ?>')">
<input type="hidden" name="num_inter" value="<?php echo $num_inter; ?>" />
<input type="hidden" name="nom" value="<?php echo $nom; ?>" />
<input type="hidden" name="user" VALUE="adm">
<input type="hidden" name="ext" VALUE=".pdf">
 <input type="hidden" name="mail" VALUE="y">
<input type="image" src="image/pdf.gif" alt="Envoyer rapport par mail" />
</form>	
<?php 
}else{
 ?>  
<td class="highlight">
<?php 
}
 ?>  
</td>
</tr>
<?php } ?> 
   
   <tr><td colspan="10" class="submit"></td></tr>
</table>
</center><br><br> <? include_once("include/bas.php"); ?></table>

<?php
$url = $_SERVER['PHP_SELF'];
$file = basename ($url); 
?>
<?php 
if ($file=="form_interventions.php" or $file=="login.php") { 
echo"</table>"; 
}
 ?>
<?php 
include_once("include/footers.php");
 ?>
